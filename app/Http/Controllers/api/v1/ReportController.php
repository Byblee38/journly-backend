<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 401);
        }

        $student = $user->student;

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan'
            ], 404);
        }

        $reports = $student
            ->report()
            ->with('reportActivities')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diambil',
            'data' => $reports
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'report_date' => ['required', 'date_format:Y-m-d']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ]);
        }

        $user = Auth::user();

        $checkReport = $user->student->report()->where('report_date', $request->report_date)->first();

        if ($checkReport) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memiliki report',
            ], 409);
        }

        Report::create([
            'student_id' => $user->student->id,
            'teacher_id' => $user->student->teacher_id,
            'report_date' => $request->report_date,
            'status' => 'pending'
        ]);

        $updateReport = $user->student->report()->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Report baru berhasil dibuat',
            'data' => [
                $updateReport
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
