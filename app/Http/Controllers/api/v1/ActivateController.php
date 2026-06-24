<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActivateAccount;
use App\Http\Requests\CheckAccount;
use App\Services\FindAccountService;

class ActivateController extends Controller
{
    public function checkAccount(CheckAccount $request, FindAccountService $findAccount){
        $validated = $request->validated();
        $identity_number = $validated['identity_number'];

        $userFound = $findAccount->findAccountByIdentity($identity_number);

        if(!$userFound){
            return response()->json([
                'success' => false,
                'message' => 'Data user tidak ditemukan'
            ], 404);
        }

        return response()->json([
            $userFound
        ], 200);
    }

    public function activateAccount(ActivateAccount $request, FindAccountService $findAccount){
        $validated = $request->validated();
        $userFound = $findAccount->activateAccount($validated);

        if($userFound['success'] == false){
            return response()->json([
                $userFound
            ], 404);
        }

        return response()->json([
            $userFound
        ], 200);
    }
}
