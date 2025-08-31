<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $blueprint): void {
            $blueprint->id();
            $blueprint->string('name');
            $blueprint->string('email')->unique();
            $blueprint->foreignId('classroom_id')->nullable()->constrained('classrooms')->nullOnDelete();
            $blueprint->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
