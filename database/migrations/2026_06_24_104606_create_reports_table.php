<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignUlid('student_id')
                ->nullable()
                ->constrained('students', 'id')
                ->cascadeOnDelete();
            $table
                ->foreignUlid('teacher_id')
                ->nullable()
                ->constrained('teachers', 'id')
                ->nullOnDelete();
            $table
                ->foreignUlid('mentor_id')
                ->nullable()
                ->constrained('mentors', 'id')
                ->nullOnDelete();
            $table->date('report_date');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('mentor_note')->nullable();
            $table->text('teacher_note')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
