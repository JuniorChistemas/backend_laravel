<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        // create user
         $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john.@example.com',
        ]);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $token = $response['token'];


        // create another user
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/create-user', [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'password' => 'password',
            ]);

        $response->assertStatus(201);
    }
}