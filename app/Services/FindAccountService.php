<?php

namespace App\Services;

use App\Models\Administrator;
use App\Models\Mentor;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FindAccountService
{
    public function findAccountByIdentity(string $identity_number)
    {
        $roleMapping = [
            'administrator' => ['model' => Administrator::class, 'identity_type' => 'nip'],
            'teacher' => ['model' => Teacher::class, 'identity_type' => 'nip'],
            'mentor' => ['model' => Mentor::class, 'identity_type' => 'identity_number'],
            'student' => ['model' => Student::class, 'identity_type' => 'nisn'],
        ];

        foreach ($roleMapping as $roleName => $config) {
            $userFound = $config['model']::where($config['identity_type'], $identity_number)->first();
            if ($userFound) {
                $keyColumn = $config['identity_type'];
                return [
                    'success' => true,
                    'message' => 'Data user ditemukan',
                    'data' => [
                        'name' => $userFound->name,
                        'identity' => $userFound->$keyColumn,
                        'role' => $roleName,
                        'is_active' => $userFound->is_active
                    ]
                ];
            }
        }

        return null;
    }

    public function activateAccount(array $data)
    {
        $roleMapping = [
            'administrator' => ['model' => Administrator::class, 'identity_type' => 'nip'],
            'teacher' => ['model' => Teacher::class, 'identity_type' => 'nip'],
            'mentor' => ['model' => Mentor::class, 'identity_type' => 'identity_number'],
            'student' => ['model' => Student::class, 'identity_type' => 'nisn'],
        ];

        if (!array_key_exists($data['role'], $roleMapping)) {
            return [
                'success'=> false,
                'message'=> 'Role tidak sesuai'
            ];
        }

        $role = $data['role'];
        $config = $roleMapping[$role];
        $identity_type = $config['identity_type'];

        $userFound = $config['model']::where($identity_type, $data['identity_number'])->first();
        if (!$userFound) {
            return [
                'success'=> false,
                'message'=> 'Data user tidak ditemukan'
            ];
        }

        if ($userFound->is_active == 1 || $userFound->is_active == true){
            return [
                'success'=> false,
                'message'=> 'Akun user sudah diaktivasi'
            ];
        }

        DB::transaction(function () use ($data, $config) {
            $newUser = User::create([
                'email' => $data['email'],
                'role' => $data['role'],
                'password' => Hash::make($data['password'])
            ]);

            $model = $config['model'];

            $model::where($config['identity_type'], $data['identity_number'])->update([
                'user_id' => $newUser->id,
                'is_active' => 1
            ]);
        });

        $userFound->refresh();

        return [
            'success' => true,
            'message' => 'Akun berhasil diaktivasi',
            'data' => [
                'name' => $userFound->name,
                $identity_type => $data['identity_number'],
                'role' => $role,
                'is_active' => $userFound->is_active
            ]
        ];
    }
}
