<?php

namespace Municipal\Attestation\Support;

class TemplateRenderer
{
    /**
     * Render a template string by replacing placeholders with data values.
     *
     * Supported syntax:
     *  - {{key}}                   → htmlspecialchars($data['key'])
     *  - **text**                  → <strong>text</strong>
     *  - {{#repeater_key}}...{{/repeater_key}}  → iterated block over $data['repeater_key'] (array of rows)
     */
    public static function render(string $template, array $data): string
    {
        // 1. Handle repeater blocks first: {{#key}}...{{/key}}
        $template = preg_replace_callback(
            '/\{\{#(\w+)\}\}(.*?)\{\{\/\1\}\}/s',
            function (array $matches) use ($data) {
                $key   = $matches[1];
                $block = $matches[2];

                if (!isset($data[$key]) || !is_array($data[$key])) {
                    return '';
                }

                $output = '';
                foreach ($data[$key] as $row) {
                    $rowBlock = $block;
                    if (is_array($row)) {
                        // Replace {{field}} within the block using the row's fields
                        $rowBlock = preg_replace_callback(
                            '/\{\{(\w+)\}\}/',
                            function (array $m) use ($row) {
                                return isset($row[$m[1]])
                                    ? htmlspecialchars((string) $row[$m[1]], ENT_QUOTES, 'UTF-8')
                                    : '';
                            },
                            $rowBlock
                        );
                    }
                    $output .= $rowBlock;
                }

                return $output;
            },
            $template
        );

        // 2. Replace simple {{key}} placeholders
        $template = preg_replace_callback(
            '/\{\{(\w+)\}\}/',
            function (array $matches) use ($data) {
                $key = $matches[1];
                return isset($data[$key])
                    ? htmlspecialchars((string) $data[$key], ENT_QUOTES, 'UTF-8')
                    : '';
            },
            $template
        );

        // 3. Convert **text** to <strong>text</strong>
        $template = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $template);

        return $template;
    }
}
