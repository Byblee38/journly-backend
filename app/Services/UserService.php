<?php

namespace App\Services;

use App\Models\Mentor;
use App\Models\MentorToken;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserService
{
    public function __construct(
        protected UserAssigmentService $userAssigmentService
    ) {}

    public function createUser(array $data)
    {
        $config = $this->userAssigmentService->getTargetModel($data['role']);

        try {
            DB::transaction(function () use ($data, $config) {
                $config['model']::create([
                    $config['identity_type'] => $data['identity_number'],
                    'name' => $data['name'],
                ]);
            });

            return [
                'success' => true,
                'message' => 'User baru berhasil dibuat',
                'data' => [
                    'name' => $data['name'],
                    'nisn' => $data['identity_number'],
                    'role' => $data['role']
                ]
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function createMentorToken()
    {
        $string = str()->random(16);
        $result = Str::of(Str::upper($string))->split(4)->implode('-');
        $mentorTokens = ('MENTOR-' . $result);

        try {
            DB::transaction(function () use ($mentorTokens) {
                MentorToken::create([
                    'token' => $mentorTokens
                ]);
            });

            return [
                'success' => true,
                'message' => 'Token berhasil dibuat',
                'data' => [
                    'mentor_token' => $mentorTokens,
                ]
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function createMentorAccount(array $data)
    {
        try {
            $validateToken = MentorToken::where('token', $data['token'])->first();
            if ($validateToken->is_used == 1 || $validateToken->is_used == true) {
                return [
                    'success' => false,
                    'message' => 'Token invalid, atau sudah digunakan',
                ];
            }

            DB::transaction(function () use ($data, $validateToken) {
                Mentor::create([
                    'identity_number' => $data['identity_number'],
                    'name' => $data['name'],
                    'company_name' => $data['company_name'],
                    'position' => $data['position'],
                ]);

                $validateToken->update(['is_used' => 1]);
            });

            return [
                'success' => true,
                'message' => 'User berhasil dibuat',
                'data' => [
                    'identity_number' => $data['identity_number'],
                    'name' => $data['name'],
                    'company_name' => $data['company_name'],
                    'position' => $data['position'],
                ]
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
