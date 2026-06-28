<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(
        protected UserAssigmentService $userAssigmentService
    ) {}

    public function login(array $data)
    {
        $userEmail = $data['email'];
        $user = User::where('email', $userEmail)->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return [
                'success' => false,
                'message' => 'Email atau Password salah'
            ];
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        $role = $user->role;
        $config = $this->userAssigmentService->getTargetModel($role);
        $identity_type = $config['identity_type'];
        $userData = $user->$role;

        return [
            'success' => true,
            'message' => 'Berhasil Login',
            'data' => [
                'access_token' => $token,
                'user' => [
                    'id' => $userData->user_id,
                    'email' => $user->email,
                    'role' => $user->role,
                    $identity_type => $userData->$identity_type,
                ]
            ],
        ];
    }

    public function logout(User $user) {
        $isLogout = $user->currentAccessToken()->delete();

        if($isLogout) {
            return [
                'success'=> true,
                'message'=> 'User berhasil logout'
            ];
        } else {
            return [
                'success'=> false,
                'message' => 'Gagal logout'
            ];
        }
    }

    public function me() {
        
    }
}
