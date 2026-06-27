<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use App\Services\UserAssigmentService;
use App\Services\UserService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService,
        protected UserAssigmentService $userAssigmentService,
        protected UserService $userService
    ) {}

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        $returnData = $this->authService->login($validated);

        if ($returnData['success'] == false) {
            return response()->json([
                $returnData
            ], 404);
        }

        return response()->json([
            $returnData
        ], 200);
    }

    public function me(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan data user',
            'email' => $user->email,
            'role' => $user->role,
            'profile' => $user->{$user->role},
        ], 201);
    }

    public function logout(Request $request)
    {
        $logout = $this->authService->logout($request->user());

        if ($logout['success'] == false) {
            return response()->json([
                $logout
            ], 404);
        }

        return response()->json([
            $logout
        ], 200);
    }
}
