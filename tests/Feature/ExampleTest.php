<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        // Run only the minimal contents migration (avoid MySQL-specific migrations in sqlite)
        \Artisan::call('migrate', ['--path' => 'database/migrations/2026_01_09_120000_create_contents_table.php']);

        // Seed a minimal content row
        $this->seed(\Database\Seeders\ContentSeeder::class);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
