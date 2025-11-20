<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        // create user
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'prueba.@example.com',
        ]);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        // frontend test

        $token = $response['token'];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->get('/api/user');

        $response->assertStatus(200);
    }
}
