<?php

namespace Tests\Feature\Client;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExperienceTest extends TestCase
{
    /**
     * Test experiencies
     *
     * @return void
     * @throws \Exception
     */
    public function testExperiencies()
    {
        $response = $this->get('/en/experiencies');
        $response->assertStatus(200);
        $response->assertViewIs('client.experiencies');
    }
}
