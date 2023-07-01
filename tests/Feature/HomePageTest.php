<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomePageTest extends TestCase {
    use RefreshDatabase;
    public function test_unauthenticated_home_page_can_render(): void {
        $response = $this->get('/');

        $response->assertStatus(302);
        $response->assertRedirect('login');
    }

    public function test_authenticated_home_page_can_render(): void {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/');

        $response->assertStatus(200);
    }


    public function test_authenticated_user_verify_success(): void {
        $content = Storage::disk('testing')->get('success.json');
        $file = UploadedFile::fake()->createWithContent("success.json", $content);
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->post('/verify', ["fileInput" => $file]);
        $this->assertDatabaseHas('verifications', ['user_id' => '1', 'result' => '1']);

        $response->assertRedirect('/');
    }

    public function test_authenticated_user_verify_invalid_issuer(): void {
        $content = Storage::disk('testing')->get('fail_issuer.json');
        $file = UploadedFile::fake()->createWithContent("fail_issuer.json", $content);
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->post('/verify', ["fileInput" => $file]);
        $this->assertDatabaseHas('verifications', ['user_id' => '1', 'result' => '0', 'result_detail' => 'invalid_issuer']);

        $response->assertRedirect('/');
    }


    public function test_authenticated_user_verify_invalid_recipient(): void {
        $content = Storage::disk('testing')->get('fail_recipient.json');
        $file = UploadedFile::fake()->createWithContent("fail_recipient.json", $content);
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->post('/verify', ["fileInput" => $file]);
        $this->assertDatabaseHas('verifications', ['user_id' => '1', 'result' => '0', 'result_detail' => 'invalid_recipient']);

        $response->assertRedirect('/');
    }

    public function test_authenticated_user_verify_invalid_file_type(): void {
        $content = Storage::disk('testing')->get('invalid.json');
        $file = UploadedFile::fake()->createWithContent("invalid.json", $content);
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->post('/verify', ["fileInput" => $file]);
        $this->assertDatabaseHas('verifications', ['user_id' => '1', 'result' => '0', 'result_detail' => 'invalid_file_type']);

        $response->assertRedirect('/');
    }

    public function test_authenticated_user_verify_invalid_computed_signature(): void {
        $content = Storage::disk('testing')->get('fail_signature_computed.json');
        $file = UploadedFile::fake()->createWithContent("fail_signature_computed.json", $content);
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->post('/verify', ["fileInput" => $file]);
        $this->assertDatabaseHas('verifications', ['user_id' => '1', 'result' => '0', 'result_detail' => 'invalid_signature']);

        $response->assertRedirect('/');
    }
    public function test_authenticated_user_verify_invalid_target_signature(): void {
        $content = Storage::disk('testing')->get('fail_signature_target.json');
        $file = UploadedFile::fake()->createWithContent("fail_signature_target.json", $content);
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->post('/verify', ["fileInput" => $file]);
        $this->assertDatabaseHas('verifications', ['user_id' => '1', 'result' => '0', 'result_detail' => 'invalid_signature']);

        $response->assertRedirect('/');
    }

    public function test_authenticated_user_can_logout(): void {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->withSession(['banned' => false])->post('/logout');

        $response->assertRedirect('');
        $this->assertGuest();
    }
}
