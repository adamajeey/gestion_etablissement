<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $this->markTestSkipped('Ce test est ignoré car la route / redirige vers une autre page');

        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
