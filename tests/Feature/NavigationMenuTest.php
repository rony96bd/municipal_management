<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NavigationMenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_and_navigation_render_cleanly(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('nav-section');
        $response->assertSee('main-menu');
        $response->assertSee('mobile-navbar');
    }

    public function test_nav_js_contains_full_box_click_forwarding_and_grace_period(): void
    {
        $navJs = file_get_contents(public_path('js/nav.js'));
        $this->assertStringContainsString('directLink.click()', $navJs);
        $this->assertStringContainsString('250', $navJs);
        $this->assertStringNotContainsString('z-index-3', $navJs);
    }

    public function test_slidder_js_has_null_guards(): void
    {
        $slidderJs = file_get_contents(public_path('js/slidder.js'));
        $this->assertStringContainsString('slides && slideItems.length > 0', $slidderJs);
        $this->assertStringContainsString('slidderWrapper && items.length > 0', $slidderJs);
    }

    public function test_search_form_box_css_has_pointer_events_none(): void
    {
        $siteCss = file_get_contents(public_path('css/site-css.css'));
        $this->assertStringContainsString('pointer-events: none', $siteCss);
        $this->assertStringContainsString('pointer-events: auto', $siteCss);
    }
}
