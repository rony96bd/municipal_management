<?php

namespace Tests\Unit;

use App\Support\HtmlSanitizer;
use PHPUnit\Framework\TestCase;

class HtmlSanitizerTest extends TestCase
{
    public function test_returns_empty_string_for_null_or_empty_input(): void
    {
        $this->assertSame('', HtmlSanitizer::clean(null));
        $this->assertSame('', HtmlSanitizer::clean(''));
        $this->assertSame('', HtmlSanitizer::clean('   '));
    }

    public function test_preserves_safe_html_formatting(): void
    {
        $input = '<p>Hello <strong>World</strong><br><ul><li>Item 1</li></ul></p>';
        $cleaned = HtmlSanitizer::clean($input);

        $this->assertStringContainsString('<p>Hello <strong>World</strong>', $cleaned);
        $this->assertStringContainsString('<ul><li>Item 1</li></ul>', $cleaned);
    }

    public function test_strips_script_iframe_and_object_tags(): void
    {
        $input = '<p>Safe</p><script>alert(1)</script><iframe src="https://evil.com"></iframe><object data="x"></object>';
        $cleaned = HtmlSanitizer::clean($input);

        $this->assertStringContainsString('<p>Safe</p>', $cleaned);
        $this->assertStringNotContainsString('<script', $cleaned);
        $this->assertStringNotContainsString('alert(1)', $cleaned);
        $this->assertStringNotContainsString('<iframe', $cleaned);
        $this->assertStringNotContainsString('<object', $cleaned);
    }

    public function test_strips_inline_event_handlers_and_javascript_urls(): void
    {
        $input = '<a href="javascript:alert(1)" onclick="steal()">Click</a><img src="x" onerror="alert(2)">';
        $cleaned = HtmlSanitizer::clean($input);

        $this->assertStringNotContainsString('javascript:', $cleaned);
        $this->assertStringNotContainsString('onclick', $cleaned);
        $this->assertStringNotContainsString('onerror', $cleaned);
    }

    public function test_preserves_safe_links_and_bengali_text(): void
    {
        $input = '<p>পৌরসভার <a href="https://example.com/notice">নোটিশ দেখুন</a></p>';
        $cleaned = HtmlSanitizer::clean($input);

        $this->assertStringContainsString('পৌরসভার', $cleaned);
        $this->assertStringContainsString('href="https://example.com/notice"', $cleaned);
    }

    public function test_strips_dangerous_css_properties_and_css_escapes(): void
    {
        $input = '<div style="position: fixed; top: 0; left: 0; background-image: u\72l(evil); color: #0f6b3a; text-align: center;">Text</div>';
        $cleaned = HtmlSanitizer::clean($input);

        $this->assertStringNotContainsString('position', $cleaned);
        $this->assertStringNotContainsString('u\72l', $cleaned);
        $this->assertStringContainsString('color: #0f6b3a', $cleaned);
        $this->assertStringContainsString('text-align: center', $cleaned);
    }
}
