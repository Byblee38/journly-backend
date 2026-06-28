<?php

namespace App\Services;

use App\Models\MentorToken;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserService {
    public function __construct(
        protected UserAssigmentService $userAssigmentService
    )
    {}

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
                'success'=> false,
                'message'=> $e->getMessage(),
            ];
        }
    }

    public function createMentorToken(){
        $string = str()->random(16);
        $result = Str::of(Str::upper($string))->split(4)->implode('-');
        $mentorTokens = ('MENTOR-'. $result);

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
                'success'=> false,
                'message'=> $e->getMessage(),
            ];
        }
    }
}
