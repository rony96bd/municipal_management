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

    public function test_preserves_safe_base64_images_in_src(): void
    {
        $input = '<p><img src="data:image/jpeg;base64,/9j/4AAQSkZJRg==" alt="সিটিজেন চার্টার ১"></p>';
        $cleaned = HtmlSanitizer::clean($input);

        $this->assertStringContainsString('src="data:image/jpeg;base64,/9j/4AAQSkZJRg=="', $cleaned);
        $this->assertStringContainsString('alt="সিটিজেন চার্টার ১"', $cleaned);
    }

    public function test_blocks_malicious_data_uris_and_data_uris_in_href(): void
    {
        $input = '<a href="data:text/html;base64,PHNjcmlwdD5hbGVydCgxKTwvc2NyaXB0Pg==">Link</a><img src="data:text/html;base64,PHNjcmlwdD4=">';
        $cleaned = HtmlSanitizer::clean($input);

        $this->assertStringNotContainsString('data:text/html', $cleaned);
        $this->assertStringNotContainsString('href=', $cleaned);
        $this->assertStringNotContainsString('src=', $cleaned);
    }

    public function test_preserves_layout_attributes_and_safe_css_for_tables(): void
    {
        $input = '<table align="center" style="width: 100%; border-collapse: collapse; vertical-align: middle;"><tr><td align="center" valign="middle" style="text-align: center; vertical-align: middle;">বাজেট</td></tr></table>';
        $cleaned = HtmlSanitizer::clean($input);

        $this->assertStringContainsString('align="center"', $cleaned);
        $this->assertStringContainsString('valign="middle"', $cleaned);
        $this->assertStringContainsString('border-collapse: collapse', $cleaned);
        $this->assertStringContainsString('vertical-align: middle', $cleaned);
    }
}
