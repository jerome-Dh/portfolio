<?php

namespace Tests\Feature\Client;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AboutTest extends TestCase
{
    /**
     * Test About
     *
     * @return void
     * @throws \Exception
     */
    public function testAbout()
    {
        $response = $this->get('/fr');
        $response->assertStatus(200);
        $response->assertViewIs('client.about');
    }
}
