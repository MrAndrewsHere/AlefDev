<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lecture_student', function (Blueprint $blueprint): void {
            $blueprint->id();
            $blueprint->foreignId('lecture_id')->constrained('lectures')->cascadeOnDelete();
            $blueprint->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $blueprint->timestamp('attended_at')->nullable();
            $blueprint->timestamps();
            $blueprint->unique(['lecture_id', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lecture_student');
    }
};
