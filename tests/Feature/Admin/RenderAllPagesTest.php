<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RenderAllPagesTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testRenderHome(): void
    {
        $response = $this->get('/admin');

        $response->assertStatus(200);
    }
}
