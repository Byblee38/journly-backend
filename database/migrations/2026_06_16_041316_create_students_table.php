<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')
                ->nullable()
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignUlid('teacher_id')
                ->nullable()
                ->constrained('teachers')
                ->onDelete('set null');
            $table->string('nisn')->unique();
            $table->string('name');
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->string('class')->nullable();
            $table->text('address')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
