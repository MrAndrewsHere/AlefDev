<?php

declare(strict_types=1);

use App\Domain\Classroom\Controllers\ClassroomController;
use App\Domain\Lecture\Controllers\LectureController;
use App\Domain\Student\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware(['throttle:60,1', 'api'])->group(function (): void {
    Route::apiResource('students', StudentController::class);

    Route::apiResource('classes', ClassroomController::class)
        ->parameters(['classes' => 'classroom']);

    Route::get('classes/{classroom}/curriculum', [ClassroomController::class, 'curriculum'])
        ->name('classes.curriculum');
    Route::put('classes/{classroom}/curriculum', [ClassroomController::class, 'upsertCurriculum'])
        ->name('classes.upsertCurriculum');

    Route::apiResource('lectures', LectureController::class);
});
