<?php

namespace Tests\Feature\Tenant;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TestExemple extends TestCase
{
    protected $tenancy = true;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_ping()
    {
        $response = $this->get($this->tenantUrl . '/ping');

        $response->assertStatus(200);
    }
}
