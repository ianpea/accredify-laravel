<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterPageTest extends TestCase {
    use RefreshDatabase;

    public function test_register_page_can_render(): void {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_register_successful() {
        $response = $this->post('/register', [
            'name' => 'Test_User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);
        $response->assertRedirect('/');
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'name' => 'Test_User'
        ]);
    }

    public function test_register_submit_invalid_name(): void {
        $response = $this->post('/register', [
            'name' => 'Test User', // invalid user name with space
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors("name");
    }
    public function test_register_submit_invalid_password(): void {
        $response = $this->post('/register', [
            'name' => 'Test_User',
            'email' => 'test@example.com',
            'password' => 'pas', // invalid user name with less than 3 chars
        ]);

        $response->assertSessionHasErrors("password");
    }
    public function test_register_submit_invalid_email(): void {
        $response = $this->post('/register', [
            'name' => 'Test_User',
            'email' => 'tes', // invalid email without @
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors("email");
    }
}
