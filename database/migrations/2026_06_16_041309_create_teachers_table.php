<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->unique()
                ->constrained()
                ->cascadeOnDelete();
            $table->string('nip')->unique();
            $table->string('name');
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['L', 'P']);
            $table->string('position')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
