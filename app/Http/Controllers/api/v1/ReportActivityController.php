<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\ReportActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportActivityController extends Controller
{
    public function index(string $id)
    {
        $reportActivity = ReportActivity::find($id);
        
        if (!$reportActivity) {
            return response()->json([
                'success' => false,
                'message' => 'Report tidak ditemukan'
            ], 404);
        }
    }

    public function store(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        $reportActivity = ReportActivity::create([
            'report_id' => $id,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Activity berhasil dibuat',
            'data' => $reportActivity
        ]);
        
    }
}
