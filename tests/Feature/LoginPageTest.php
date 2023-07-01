<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginPageTest extends TestCase {
    use RefreshDatabase;

    public function test_login_page_can_render(): void {
        $response = $this->get('login');
        $response->assertStatus(200);
    }

    public function test_login_successfull(): void {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->post('/login', ['loginName' => 'Test_User', 'loginPassword' => 'password']);

        $this->assertAuthenticated();
    }

    public function test_login_fail(): void {
        $response = $this->post('/login', ['loginName' => 'Test_User', 'loginPassword' => 'password']);

        $response->assertStatus(302);
        $response->assertSessionHas("message", "Invalid credentials.");
    }
}
