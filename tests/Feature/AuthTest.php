<?php

namespace Tests\Feature;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_success_login_api_returns_json_data_with_access_token_field(): void
    {
        $this->loginGetAccessToken();
    }

    public function test_incorrect_login_returns_not_found_status_error_with_message()
    {
        $this->createUser([
            'email' => 'lomiashvili.dato5@gmail.com',
        ],Role::admin);


        $response = $this->postJson(self::API_URL . 'auth/login', [
            'email' => 'lomiashvili.dato5@gmail.com',
            'password' => 'incorrect_password',
        ]);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertJsonStructure([
            'message',
        ]);
    }

    public function test_login_api_incorrect_email_format_returns_validation_error_with_message()
    {
        $response = $this->postJson(self::API_URL . 'auth/login', [
            'email' => 'lomiashvilidato5gmail.com',
            'password' => 'wrong_password',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors' => ['email'],
        ]);
    }

    public function test_success_refresh_token_api_returns_new_access_token()
    {
        $this->loginGetAccessToken();
        $response = $this->postJson(self::API_URL . 'auth/refresh_token');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
        ]);
    }

    public function test_refresh_token_api_unauthorized_user_can_not_get_access_token()
    {
        $response = $this->postJson(self::API_URL . 'auth/refresh_token');
        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }
}
