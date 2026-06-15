<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User as userModels;
use App\Models\Students as students;
use App\Models\Teachers as teachers;
use App\UserGender;
use App\UserRole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Enum;

class AuthController extends Controller
{
    public function createUser(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'nisNip' => 'required|min:8|max:18|unique:teachers,nip|unique:students,nisn',
            'name' => 'required',
            'gender' => ['required', new Enum(UserGender::class)],
            'role' => ['required', new Enum(UserRole::class)]
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 'Error',
                'message' => [
                    $validasi->errors()
                ]
            ], 422);
        }
        ;

        $userRole = $request->role;

        if ($userRole === 'siswa') {
            students::create([
                'nisn' => $request->nisNip,
                'name' => $request->name,
                'gender' => $request->gender
            ]);

            return response()->json([
                'status' => 'Success',
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
                'status' => 'Success',
                'message' => 'User baru berhasil dibuat',
                'data' => [
                    'name' => $request->name,
                    'nip' => $request->nisNip,
                    'gender' => $request->gender,
                    'role' => $request->role
                ]
            ], 201);
        } else {
            return response()->json([
                'status' => 'Error',
                'message' => 'Role tidak valid',
            ], 400);
        }
    }

    public function userCheck(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nisNip' => 'required|min:10|max:18',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'Error',
                'message' => [
                    $validate->errors()
                ]
            ], 422);
        }

        $userFound = students::where('nisn', $request->nisNip)->first();

        if (!$userFound) {
            $userFound = teachers::where('nip', $request->nisNip)->first();
            if (!$userFound) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'User Not Found'
                ]);
            } else {
                return response()->json([
                    'status' => 'Success',
                    'message' => 'User Found',
                    'data' => [
                        'name' => $userFound->name,
                        'nisn' => $userFound->nip,
                        'role' => 'mentor',
                        'is_active' => $userFound->is_active
                    ]
                ], 200);
            }
            ;
        }
        ;

        return response()->json([
            'status' => 'Success',
            'message' => 'User Found',
            'data' => [
                'name' => $userFound->name,
                'nisn' => $userFound->nisn,
                'role' => 'siswa',
                'is_active' => $userFound->is_active
            ]
        ], 200);
    }

    public function userActivate(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'nisNip' => 'required|min:10|max:18',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => ['required', new Enum(UserRole::class)],
            'password' => 'required|min:8|confirmed'
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 'Error',
                'message' => [
                    $validasi->errors()
                ]
            ], 422);
        };

        $user = students::where('nisn', $request->nisNip)->first();

        if (!$user) {
            $user = teachers::where('nip', $request->nisNip)->first();
            
            if (!$user) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'User Not Found'
                ]);
            } else {
                if($user->is_active == 1 || $user->is_active == true){
                    return response()->json([
                        'status' => 'Error',
                        'message' => 'User Sudah Terdaftar'
                    ], 409);
                }

                $newUser = userModels::create([
                    'email' => $request->email,
                    'role' => $request->role,
                    'password' => Hash::make($request->password)
                ]);

                teachers::where('nip', $request->nisNip)->update([
                    'user_id' => $newUser->id,
                    'is_active' => true
                ]);

                $userNewUpdate = teachers::where('nip', $request->nisNip)->first();

                return response()->json([
                    'status' => 'Success',
                    'message' => 'Akun berhasil diaktivasi',
                    'data' => [
                        'name' => $request->name,
                        'email' => $request->email,
                        'nip' => $request->nisNip,
                        'role' => $request->role,
                        'is_active' => $userNewUpdate->is_active
                    ]
                ], 201);
            };
        };

        if($user->is_active === 1 || $user->is_active === true){
            return response()->json([
                'status' => 'Error',
                'message' => 'User Sudah Terdaftar'
            ], 409);
        }

        $newUser = userModels::create([
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password)
        ]);

        students::where('nisn', $request->nisNip)->update([
            'user_id' => $newUser->id,
            'is_active' => true
        ]);

        $userNewUpdate = students::where('nisn', $request->nisNip)->first();

        return response()->json([
            'status' => 'Success',
            'message' => 'Akun berhasil diaktivasi',
            'data' => [
                'name' => $request->name,
                'email' => $request->email,
                'nisn' => $request->nisNip,
                'role' => $request->role,
                'is_active' => $userNewUpdate->is_active
            ]
        ], 201);
    }

    public function login(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 'Error',
                'message' => [
                    $validasi->errors()
                ]
            ], 422);
        };

        $userLogin = userModels::where('email', $request->email)->first();
        
        if(!$userLogin || !Hash::check($request->password, $userLogin->password)) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Email atau Password salah'
            ], 404);
        }

        $token = $userLogin->createToken('access-token')->plainTextToken;
        $userData = teachers::where('user_id', $userLogin->id)->first();
        
        if(!$userData){
            $userData = students::where('user_id', $userLogin->id)->first();
            
            return response()->json([
                'status' => 'Success',
                'message' => 'User berhasil login',
                'data' => [
                    'name' => $userData->name,
                    'email' => $userLogin->email,
                    'role' => $userLogin->role,
                    'nisn' => $userData->nisn,
                    'birth_date' => $userData->birth_date,
                    'gender' => $userData->gender,
                    'class' => $userData->class,
                    'address' => $userData->address,
                    'token' => $token
                ]
            ], 200);
        }

        return response()->json([
            'status' => 'Success',
            'message' => 'User berhasil login',
            'data' => [
                'name' => $userData->name,
                'email' => $userLogin->email,
                'role' => $userLogin->role,
                'nip' => $userData->nip,
                'birth_date' => $userData->birth_date,
                'gender' => $userData->gender,
                'position' => $userData->position,
                'token' => $token
            ]
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'Success',
            'message' => 'Berhasil logout'
        ], 201);
    }
}
