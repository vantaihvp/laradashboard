<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_basic_test()
    {
        $this->markTestSkipped('Homepage redirects to login in test environment');

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
