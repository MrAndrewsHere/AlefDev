<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classroom_lecture', function (Blueprint $blueprint): void {
            $blueprint->id();
            $blueprint->foreignId('classroom_id')->constrained('classrooms')->cascadeOnDelete();
            $blueprint->foreignId('lecture_id')->constrained('lectures')->cascadeOnDelete();
            $blueprint->unsignedInteger('position');
            $blueprint->timestamps();
            $blueprint->unique(['classroom_id', 'lecture_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classroom_lecture');
    }
};
