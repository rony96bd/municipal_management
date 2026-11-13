<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;
use Illuminate\Support\Facades\Cache;

class HtmlSanitizer
{
    private const ALLOWED_TAGS = [
        'p', 'br', 'b', 'strong', 'i', 'em', 'u', 's', 'sub', 'sup',
        'ul', 'ol', 'li', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
        'blockquote', 'pre', 'code', 'hr',
        'table', 'thead', 'tbody', 'tfoot', 'tr', 'th', 'td',
        'a', 'img', 'div', 'span',
    ];

    private const DROP_WITH_CONTENT_TAGS = [
        'script', 'style', 'iframe', 'object', 'embed', 'svg', 'math',
        'form', 'input', 'button', 'textarea', 'select', 'link', 'meta', 'base',
    ];

    private const ALLOWED_ATTRIBUTES = [
        'href', 'src', 'alt', 'title', 'target', 'rel', 'class', 'style',
        'colspan', 'rowspan', 'width', 'height',
    ];

    private const ALLOWED_CSS_PROPERTIES = [
        'color', 'background-color', 'font-size', 'font-weight', 'font-style',
        'text-align', 'text-decoration', 'line-height',
        'margin', 'margin-top', 'margin-right', 'margin-bottom', 'margin-left',
        'padding', 'padding-top', 'padding-right', 'padding-bottom', 'padding-left',
        'border', 'border-radius', 'width', 'max-width', 'height',
    ];

    /** @var array<string, string> */
    private static array $cache = [];

    /**
     * Sanitize untrusted HTML while preserving safe formatting and UTF-8 text.
     */
    public static function clean(?string $html): string
    {
        if ($html === null || trim($html) === '') {
            return '';
        }

        $hash = hash('sha256', $html);
        if (isset(self::$cache[$hash])) {
            return self::$cache[$hash];
        }

        $compute = static function () use ($html): string {
            $previousErrors = libxml_use_internal_errors(true);

            $dom = new DOMDocument('1.0', 'UTF-8');
            $wrapped = '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>'
                . $html
                . '</body></html>';

            $dom->loadHTML($wrapped, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            libxml_clear_errors();
            libxml_use_internal_errors($previousErrors);

            $body = $dom->getElementsByTagName('body')->item(0);
            if (!$body) {
                return '';
            }

            self::sanitizeNode($body);

            $output = '';
            foreach ($body->childNodes as $child) {
                $output .= $dom->saveHTML($child);
            }

            return trim($output);
        };

        $cleaned = (function_exists('app') && app()->bound('cache'))
            ? Cache::remember("html_clean:{$hash}", 3600, $compute)
            : $compute();

        if (count(self::$cache) >= 200) {
            self::$cache = [];
        }
        self::$cache[$hash] = $cleaned;

        return $cleaned;
    }

    private static function sanitizeNode(DOMNode $node): void
    {
        $children = [];
        foreach ($node->childNodes as $child) {
            $children[] = $child;
        }

        foreach ($children as $child) {
            if ($child instanceof DOMElement) {
                $tag = strtolower($child->tagName);

                if (in_array($tag, self::DROP_WITH_CONTENT_TAGS, true)) {
                    $node->removeChild($child);
                    continue;
                }

                self::sanitizeNode($child);

                if (!in_array($tag, self::ALLOWED_TAGS, true)) {
                    while ($child->firstChild) {
                        $node->insertBefore($child->firstChild, $child);
                    }
                    $node->removeChild($child);
                    continue;
                }

                self::sanitizeAttributes($child);
            }
        }
    }

    private static function sanitizeAttributes(DOMElement $element): void
    {
        $attrNames = [];
        foreach ($element->attributes as $attr) {
            $attrNames[] = $attr->nodeName;
        }

        foreach ($attrNames as $name) {
            $lower = strtolower($name);

            if (str_starts_with($lower, 'on') || !in_array($lower, self::ALLOWED_ATTRIBUTES, true)) {
                $element->removeAttribute($name);
                continue;
            }

            $value = trim($element->getAttribute($name));

            if ($lower === 'href' || $lower === 'src') {
                if (!self::isSafeUrl($value)) {
                    $element->removeAttribute($name);
                }
            } elseif ($lower === 'style') {
                $safeStyle = self::sanitizeStyle($value);
                if ($safeStyle === '') {
                    $element->removeAttribute($name);
                } else {
                    $element->setAttribute($name, $safeStyle);
                }
            } elseif ($lower === 'target' && $value === '_blank') {
                $element->setAttribute('rel', 'noopener noreferrer');
            }
        }
    }

    private static function isSafeUrl(string $url): bool
    {
        if ($url === '') {
            return false;
        }

        // Decode entities and strip whitespace/control chars before checking scheme
        $decoded = html_entity_decode($url, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $normalized = preg_replace('/[\x00-\x20]+/', '', $decoded);

        if (str_starts_with($normalized, '/') || str_starts_with($normalized, '#')) {
            return !str_starts_with($normalized, '//');
        }

        $scheme = parse_url($normalized, PHP_URL_SCHEME);
        if ($scheme === null) {
            return true;
        }

        return in_array(strtolower($scheme), ['http', 'https', 'mailto', 'tel'], true);
    }

    private static function sanitizeStyle(string $style): string
    {
        $declarations = explode(';', $style);
        $safe = [];

        foreach ($declarations as $decl) {
            $parts = explode(':', $decl, 2);
            if (count($parts) !== 2) {
                continue;
            }

            $prop = strtolower(trim($parts[0]));
            $val  = trim($parts[1]);

            if (!in_array($prop, self::ALLOWED_CSS_PROPERTIES, true)) {
                continue;
            }

            // Reject CSS escapes, url(), expression(), @import, or script schemes
            if (str_contains($val, '\\') || preg_match('/(expression|javascript:|vbscript:|@import|url\s*\()/i', $val)) {
                continue;
            }

            $safe[] = "{$prop}: {$val}";
        }

        return implode('; ', $safe);
    }
}
