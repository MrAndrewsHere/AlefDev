<?php

declare(strict_types=1);

namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * Path operations extracted from controllers to reduce noise.
 * They reference existing request/response schemas defined in Schemas.
 */
final class Paths
{
    /**
     * @OA\Get(
     *   path="/api/v1/lectures",
     *   tags={"Lectures"},
     *   summary="List lectures",
     *
     *   @OA\Parameter(name="per_page", in="query", required=false, description="Items per page (1..100)", @OA\Schema(type="integer", minimum=1, maximum=100, default=15)),
     *   @OA\Parameter(name="page", in="query", required=false, description="Page", @OA\Schema(type="integer", minimum=1)),
     *   @OA\Parameter(name="filter[topic]", in="query", required=false, description="Filter by topic (partial match)", @OA\Schema(type="string")),
     *   @OA\Parameter(name="filter[description]", in="query", required=false, description="Filter by description (partial match)", @OA\Schema(type="string")),
     *   @OA\Parameter(name="sort", in="query", required=false, description="Sort by fields (id, topic). Use - for desc, e.g. -id", @OA\Schema(type="string")),
     *
     *   @OA\Response(response=200, description="OK", @OA\JsonContent(ref="#/components/schemas/PaginatedLectureResponse")),
     *   @OA\Response(response=500, description="Failed to fetch lectures")
     * )
     */
    public function lecturesIndex(): void {}

    /**
     * @OA\Get(
     *   path="/api/v1/lectures/{lecture}",
     *   tags={"Lectures"},
     *   summary="Get a lecture",
     *
     *   @OA\Parameter(name="lecture", in="path", required=true, @OA\Schema(type="integer")),
     *
     *   @OA\Response(response=200, description="OK", @OA\JsonContent(ref="#/components/schemas/Lecture")),
     *   @OA\Response(response=500, description="Failed to fetch lecture")
     * )
     */
    public function lecturesShow(): void {}

    /**
     * @OA\Post(
     *   path="/api/v1/lectures",
     *   tags={"Lectures"},
     *   summary="Create a lecture",
     *
     *   @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/LectureStoreRequest")),
     *
     *   @OA\Response(response=201, description="Created", @OA\JsonContent(ref="#/components/schemas/Lecture")),
     *   @OA\Response(response=500, description="Failed to create lecture")
     * )
     */
    public function lecturesStore(): void {}

    /**
     * @OA\Put(
     *   path="/api/v1/lectures/{lecture}",
     *   tags={"Lectures"},
     *   summary="Update a lecture",
     *
     *   @OA\Parameter(name="lecture", in="path", required=true, @OA\Schema(type="integer")),
     *
     *   @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/LectureUpdateRequest")),
     *
     *   @OA\Response(response=200, description="OK", @OA\JsonContent(ref="#/components/schemas/Lecture")),
     *   @OA\Response(response=500, description="Failed to update lecture")
     * )
     */
    public function lecturesUpdate(): void {}

    /**
     * @OA\Delete(
     *   path="/api/v1/lectures/{lecture}",
     *   tags={"Lectures"},
     *   summary="Delete a lecture",
     *
     *   @OA\Parameter(name="lecture", in="path", required=true, @OA\Schema(type="integer")),
     *
     *   @OA\Response(response=204, description="No Content"),
     *   @OA\Response(response=500, description="Failed to delete lecture")
     * )
     */
    public function lecturesDestroy(): void {}

    /**
     * @OA\Get(
     *   path="/api/v1/students",
     *   tags={"Students"},
     *   summary="List students",
     *
     *   @OA\Parameter(name="per_page", in="query", required=false, description="Items per page (1..100)", @OA\Schema(type="integer", minimum=1, maximum=100, default=15)),
     *   @OA\Parameter(name="page", in="query", required=false, description="Page", @OA\Schema(type="integer", minimum=1)),
     *   @OA\Parameter(name="filter[name]", in="query", required=false, description="Filter by name (partial match)", @OA\Schema(type="string")),
     *   @OA\Parameter(name="filter[email]", in="query", required=false, description="Filter by email (partial match)", @OA\Schema(type="string")),
     *   @OA\Parameter(name="filter[classroom_id]", in="query", required=false, description="Filter by classroom id", @OA\Schema(type="integer")),
     *   @OA\Parameter(name="sort", in="query", required=false, description="Sort by fields (id, name, email). Use - for desc", @OA\Schema(type="string")),
     *
     *   @OA\Response(response=200, description="OK", @OA\JsonContent(ref="#/components/schemas/PaginatedStudentResponse")),
     *   @OA\Response(response=500, description="Failed to fetch students")
     * )
     */
    public function studentsIndex(): void {}

    /**
     * @OA\Get(
     *   path="/api/v1/students/{student}",
     *   tags={"Students"},
     *   summary="Get a student",
     *
     *   @OA\Parameter(name="student", in="path", required=true, @OA\Schema(type="integer")),
     *
     *   @OA\Response(response=200, description="OK", @OA\JsonContent(ref="#/components/schemas/Student")),
     *   @OA\Response(response=500, description="Failed to fetch student")
     * )
     */
    public function studentsShow(): void {}

    /**
     * @OA\Post(
     *   path="/api/v1/students",
     *   tags={"Students"},
     *   summary="Create a student",
     *
     *   @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StudentStoreRequest")),
     *
     *   @OA\Response(response=201, description="Created", @OA\JsonContent(ref="#/components/schemas/Student")),
     *   @OA\Response(response=500, description="Failed to create student")
     * )
     */
    public function studentsStore(): void {}

    /**
     * @OA\Put(
     *   path="/api/v1/students/{student}",
     *   tags={"Students"},
     *   summary="Update a student",
     *
     *   @OA\Parameter(name="student", in="path", required=true, @OA\Schema(type="integer")),
     *
     *   @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StudentUpdateRequest")),
     *
     *   @OA\Response(response=200, description="OK", @OA\JsonContent(ref="#/components/schemas/Student")),
     *   @OA\Response(response=500, description="Failed to update student")
     * )
     */
    public function studentsUpdate(): void {}

    /**
     * @OA\Delete(
     *   path="/api/v1/students/{student}",
     *   tags={"Students"},
     *   summary="Delete a student",
     *
     *   @OA\Parameter(name="student", in="path", required=true, @OA\Schema(type="integer")),
     *
     *   @OA\Response(response=204, description="No Content"),
     *   @OA\Response(response=500, description="Failed to delete student")
     * )
     */
    public function studentsDestroy(): void {}

    /**
     * @OA\Get(
     *   path="/api/v1/classes",
     *   tags={"Classes"},
     *   summary="List classes",
     *
     *   @OA\Parameter(name="per_page", in="query", required=false, description="Items per page (1..100)", @OA\Schema(type="integer", minimum=1, maximum=100, default=15)),
     *   @OA\Parameter(name="page", in="query", required=false, description="Page", @OA\Schema(type="integer", minimum=1)),
     *   @OA\Parameter(name="filter[name]", in="query", required=false, description="Filter by name (partial match)", @OA\Schema(type="string")),
     *   @OA\Parameter(name="sort", in="query", required=false, description="Sort by fields (id, name). Use - for desc", @OA\Schema(type="string")),
     *
     *   @OA\Response(response=200, description="OK", @OA\JsonContent(ref="#/components/schemas/PaginatedClassroomResponse")),
     *   @OA\Response(response=500, description="Failed to fetch classes")
     * )
     */
    public function classesIndex(): void {}

    /**
     * @OA\Get(
     *   path="/api/v1/classes/{classroom}",
     *   tags={"Classes"},
     *   summary="Get a class",
     *
     *   @OA\Parameter(name="classroom", in="path", required=true, @OA\Schema(type="integer")),
     *
     *   @OA\Response(response=200, description="OK", @OA\JsonContent(ref="#/components/schemas/Classroom")),
     *   @OA\Response(response=500, description="Failed to fetch class")
     * )
     */
    public function classesShow(): void {}

    /**
     * @OA\Post(
     *   path="/api/v1/classes",
     *   tags={"Classes"},
     *   summary="Create a class",
     *
     *   @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/ClassroomStoreRequest")),
     *
     *   @OA\Response(response=201, description="Created", @OA\JsonContent(ref="#/components/schemas/Classroom")),
     *   @OA\Response(response=500, description="Failed to create class")
     * )
     */
    public function classesStore(): void {}

    /**
     * @OA\Put(
     *   path="/api/v1/classes/{classroom}",
     *   tags={"Classes"},
     *   summary="Update a class",
     *
     *   @OA\Parameter(name="classroom", in="path", required=true, @OA\Schema(type="integer")),
     *
     *   @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/ClassroomUpdateRequest")),
     *
     *   @OA\Response(response=200, description="OK", @OA\JsonContent(ref="#/components/schemas/Classroom")),
     *   @OA\Response(response=500, description="Failed to update class")
     * )
     */
    public function classesUpdate(): void {}

    /**
     * @OA\Delete(
     *   path="/api/v1/classes/{classroom}",
     *   tags={"Classes"},
     *   summary="Delete a class",
     *
     *   @OA\Parameter(name="classroom", in="path", required=true, @OA\Schema(type="integer")),
     *
     *   @OA\Response(response=204, description="No Content"),
     *   @OA\Response(response=500, description="Failed to delete class")
     * )
     */
    public function classesDestroy(): void {}

    /**
     * @OA\Get(
     *   path="/api/v1/classes/{classroom}/curriculum",
     *   tags={"Classes"},
     *   summary="Get class curriculum",
     *
     *   @OA\Parameter(name="classroom", in="path", required=true, @OA\Schema(type="integer")),
     *
     *   @OA\Response(response=200, description="OK", @OA\JsonContent(ref="#/components/schemas/CurriculumResponse")),
     *   @OA\Response(response=500, description="Failed to fetch curriculum")
     * )
     */
    public function classesCurriculum(): void {}
}
