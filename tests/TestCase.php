<?php

namespace Tests;

use App\Enums\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\AssertableJson;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    public const API_URL = '/api/';

    /**
     * @param array|null $data
     * @param string|null $role
     * @return User
     */
    public function createUser(?array $data, ?string $role = null): User
    {
        return User::factory()->setRole($role)->create($data);
    }

    /**
     * Login and get access token
     *
     * @return string
     */
    public function loginGetAccessToken(): string
    {
        $data = [
            'email' => 'lomiashvili.dato5@gmail.com',
        ];
        $user = $this->createUser($data,Role::editor);
        $data['password'] = '12345678';
        $response = $this->postJson(self::API_URL . 'auth/login', $data);
        $accessToken = json_decode($response->getContent())->access_token;
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
            'username'
        ]);
        $response->assertJson(function (AssertableJson $json) use ($user) {
            $json->has('access_token')
                ->where('token_type', 'bearer')
                ->where('expires_in', 3600)
                ->where('username', $user->name);
        });

        return $accessToken;
    }
}
