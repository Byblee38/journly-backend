<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User as userModels;
use App\Models\Student as students;
use App\Models\Teacher as teachers;
use App\Enums\UserGender;
use App\Enums\UserRole;
use App\Http\Requests\LoginRequest;
use App\Services\LoginService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Enum;
use App\Services\UserAssigmentService;

class AuthController extends Controller
{
    // Create User (Admin only)
    public function createUser(Request $request, UserAssigmentService $userAssigmentService)
    {
        $validasi = Validator::make($request->all(), [
            'nisNip' => 'required|min:8|max:18|unique:teachers,nip|unique:students,nisn',
            'name' => 'required',
            'gender' => ['required', new Enum(UserGender::class)],
            'role' => ['required', new Enum(UserRole::class)]
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Error',
                'error' => [
                    $validasi->errors()
                ]
            ], 422);
        }

        $userRole = $request->role;
        $userAssigmentService->getTargetModel($userRole);

        if ($userRole === 'siswa') {
            students::create([
                'nisn' => $request->nisNip,
                'name' => $request->name,
                'gender' => $request->gender
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User baru berhasil dibuat',
                'data' => [
                    'name' => $request->name,
                    'nisn' => $request->nisNip,
                    'gender' => $request->gender,
                    'role' => $request->role
                ]
            ], 201);
        } elseif ($userRole == 'admin' || $userRole == 'mentor') {
            teachers::create([
                'nip' => $request->nisNip,
                'name' => $request->name,
                'gender' => $request->gender
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User baru berhasil dibuat',
                'data' => [
                    'name' => $request->name,
                    'nip' => $request->nisNip,
                    'gender' => $request->gender,
                    'role' => $request->role
                ]
            ], 201);
        }
    }

    public function login(LoginRequest $request, LoginService $loginService)
    {
        $validated = $request->validated();
        $returnData = $loginService->login($validated);

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

        if ($user->role == 'siswa') {
            $user->load('student');
        } else {
            $user->load('teacher');
        }
        ;

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan data user',
            'data' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil logout'
        ], 201);
    }
}
