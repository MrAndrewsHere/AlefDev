<?php

declare(strict_types=1);

namespace App\Domain\Student\Controllers;

use App\Domain\Share\Controllers\Controller as BaseController;
use App\Domain\Student\Models\Student;
use App\Domain\Student\Requests\StudentIndexRequest;
use App\Domain\Student\Requests\StudentStoreRequest;
use App\Domain\Student\Requests\StudentUpdateRequest;
use App\Domain\Student\Resources\StudentResource;
use App\Domain\Student\Services\StudentService;
use Illuminate\Http\JsonResponse;

class StudentController extends BaseController
{
    public function __construct(private readonly StudentService $studentService) {}

    /**
     * List students
     */
    public function index(StudentIndexRequest $studentIndexRequest): JsonResponse
    {
        $lengthAwarePaginator = $this->studentService->list($this->requestPerPage($studentIndexRequest));
        $lengthAwarePaginator->appends($studentIndexRequest->query());

        return StudentResource::collection($lengthAwarePaginator)->response();
    }

    /**
     * Show student by ID
     */
    public function show(Student $student): JsonResponse
    {

        $model = $this->studentService->get($student);

        return (new StudentResource($model))->response();
    }

    /**
     * Create a student
     */
    public function store(StudentStoreRequest $studentStoreRequest): JsonResponse
    {

        $student = $this->studentService->create($studentStoreRequest->dto());

        return (new StudentResource($student))->response()->setStatusCode(201);
    }

    /**
     * Update a student
     */
    public function update(StudentUpdateRequest $studentUpdateRequest, Student $student): JsonResponse
    {

        $updated = $this->studentService->update($student, $studentUpdateRequest->dto());

        return (new StudentResource($updated))->response();
    }

    /**
     * Delete a student
     */
    public function destroy(Student $student): JsonResponse
    {

        $this->studentService->delete($student);

        return response()->json(status: 204);
    }
}
