<?php

namespace Tests\Feature\Client;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SkillsTest extends TestCase
{
    /**
     * Test skills
     * @group tt
     * @return void
     * @throws \Exception
     */
    public function testSkills()
    {
        $response = $this->get('/fr/skills');
        $response->assertStatus(200);
        $response->assertViewIs('client.skills');
    }
}
