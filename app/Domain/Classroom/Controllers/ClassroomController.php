<?php

declare(strict_types=1);

namespace App\Domain\Classroom\Controllers;

use App\Domain\Classroom\Models\Classroom;
use App\Domain\Classroom\Requests\ClassroomIndexRequest;
use App\Domain\Classroom\Requests\ClassroomStoreRequest;
use App\Domain\Classroom\Requests\ClassroomUpdateRequest;
use App\Domain\Classroom\Requests\CurriculumUpsertRequest;
use App\Domain\Classroom\Resources\ClassroomResource;
use App\Domain\Classroom\Services\ClassroomService;
use App\Domain\Lecture\Resources\LectureResource;
use App\Domain\Share\Controllers\Controller as BaseController;
use Illuminate\Http\JsonResponse;

class ClassroomController extends BaseController
{
    public function __construct(private readonly ClassroomService $classroomService) {}

    /**
     * List classes
     */
    public function index(ClassroomIndexRequest $classroomIndexRequest): JsonResponse
    {
        $lengthAwarePaginator = $this->classroomService->list($this->requestPerPage($classroomIndexRequest));
        $lengthAwarePaginator->appends($classroomIndexRequest->query());

        return ClassroomResource::collection($lengthAwarePaginator)->response();
    }

    /**
     * Get class by ID
     */
    public function show(Classroom $classroom): JsonResponse
    {

        $model = $this->classroomService->get($classroom);

        return (new ClassroomResource($model))->response();
    }

    /**
     * Create a class
     */
    public function store(ClassroomStoreRequest $classroomStoreRequest): JsonResponse
    {
        $classroom = $this->classroomService->create($classroomStoreRequest->dto());

        return (new ClassroomResource($classroom))->response()->setStatusCode(201);
    }

    /**
     * Update a class
     */
    public function update(ClassroomUpdateRequest $classroomUpdateRequest, Classroom $classroom): JsonResponse
    {
        $updated = $this->classroomService->update($classroom, $classroomUpdateRequest->dto());

        return (new ClassroomResource($updated))->response();
    }

    /**
     * Delete a class
     */
    public function destroy(Classroom $classroom): JsonResponse
    {
        $this->classroomService->delete($classroom);

        return response()->json(status: 204);
    }

    /**
     * Get class curriculum
     */
    public function curriculum(Classroom $classroom): JsonResponse
    {
        $model = $this->classroomService->getCurriculum($classroom);
        $lectures = LectureResource::collection($model->lectures)->resolve();

        return response()->json(['data' => $lectures]);
    }

    public function upsertCurriculum(CurriculumUpsertRequest $curriculumUpsertRequest, Classroom $classroom): JsonResponse
    {
        $model = $this->classroomService->upsertCurriculum($classroom, $curriculumUpsertRequest->validated('lectures'));
        $lectures = LectureResource::collection($model->lectures)->resolve();

        return response()->json(['data' => $lectures]);
    }
}
