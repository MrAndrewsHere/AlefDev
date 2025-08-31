<?php

declare(strict_types=1);

namespace App\Domain\Lecture\Controllers;

use App\Domain\Lecture\Models\Lecture;
use App\Domain\Lecture\Requests\LectureIndexRequest;
use App\Domain\Lecture\Requests\LectureStoreRequest;
use App\Domain\Lecture\Requests\LectureUpdateRequest;
use App\Domain\Lecture\Resources\LectureResource;
use App\Domain\Lecture\Services\LectureService;
use App\Domain\Share\Controllers\Controller as BaseController;
use Illuminate\Http\JsonResponse;

class LectureController extends BaseController
{
    public function __construct(private readonly LectureService $lectureService) {}

    /**
     * List lectures
     */
    public function index(LectureIndexRequest $lectureIndexRequest): JsonResponse
    {
        $lengthAwarePaginator = $this->lectureService->list($this->requestPerPage($lectureIndexRequest));
        $lengthAwarePaginator->appends($lectureIndexRequest->query());

        return LectureResource::collection($lengthAwarePaginator)->response();
    }

    /**
     * Show lecture by ID
     */
    public function show(Lecture $lecture): JsonResponse
    {
        $model = $this->lectureService->get($lecture);

        return (new LectureResource($model))->response();
    }

    /**
     * Create a lecture
     */
    public function store(LectureStoreRequest $lectureStoreRequest): JsonResponse
    {
        $lecture = $this->lectureService->create($lectureStoreRequest->dto());

        return (new LectureResource($lecture))->response()->setStatusCode(201);
    }

    /**
     * Update a lecture
     */
    public function update(LectureUpdateRequest $lectureUpdateRequest, Lecture $lecture): JsonResponse
    {
        $updated = $this->lectureService->update($lecture, $lectureUpdateRequest->dto());

        return (new LectureResource($updated))->response();
    }

    /**
     * Delete a lecture
     */
    public function destroy(Lecture $lecture): JsonResponse
    {
        $this->lectureService->delete($lecture);

        return response()->json(status: 204);
    }
}
