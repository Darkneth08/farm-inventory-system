<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicLandingPageTest extends TestCase
{
    public function test_public_landing_page_renders_core_sections(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSeeText('Farm Supply Inventory');
        $response->assertSeeText('Create Account');
        $response->assertSeeText('Live Stock');
        $response->assertSeeText('Common questions');
    }
}
