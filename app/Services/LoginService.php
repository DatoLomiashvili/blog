<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;
use App\Supports\ResponseSupport;
use Illuminate\Support\Facades\Auth;

class LoginService
{

    use ResponseSupport;

    /**
     * @param $email
     * @param $password
     * @return array
     * @throws NotFoundException
     */
    public function login($email, $password): array
    {
        $token = auth()->attempt([
            'email' => $email,
            'password' => $password,
        ]);

        if (!$token) {
            throw new NotFoundException('Incorrect credentials.');
        }

        return $this->respondWithToken($token, Auth::user());
    }


    /**
     * Refresh and Get new access token
     *
     * @return array
     */
    public function refreshToken(): array
    {
        $token = auth()->refresh();
        return $this->respondWithToken($token, Auth::user());
    }

    /**
     * @param $token
     * @param $user
     * @return array
     */
    private function respondWithToken($token, $user): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'name' => $user->name,
        ];
    }

}
