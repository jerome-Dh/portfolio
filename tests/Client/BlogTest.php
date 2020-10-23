<?php

namespace Tests\Feature\Client;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogTest extends TestCase
{
    /**
     * Test blog
     *
     * @return void
     * @throws \Exception
     */
    public function testBlog()
    {
        $response = $this->get('/en/blog');
        $response->assertStatus(200);
        $response->assertViewIs('client.blog');
    }
}
