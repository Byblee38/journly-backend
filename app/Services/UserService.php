<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

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
}
