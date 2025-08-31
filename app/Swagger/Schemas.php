<?php

declare(strict_types=1);

namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * Component Schemas extracted from controllers to keep them centralized.
 *
 * @OA\Schema(
 *   schema="Lecture",
 *   type="object",
 *
 *   @OA\Property(property="id", type="integer", example=1),
 *   @OA\Property(property="topic", type="string", example="Intro to Algebra"),
 *   @OA\Property(property="description", type="string", example="Basics of algebraic expressions")
 * )
 *
 * @OA\Schema(
 *   schema="LectureStoreRequest",
 *   type="object",
 *   required={"topic","description"},
 *
 *   @OA\Property(property="topic", type="string", maxLength=255),
 *   @OA\Property(property="description", type="string")
 * )
 *
 * @OA\Schema(
 *   schema="LectureUpdateRequest",
 *   type="object",
 *
 *   @OA\Property(property="topic", type="string", maxLength=255),
 *   @OA\Property(property="description", type="string")
 * )
 *
 * @OA\Schema(
 *   schema="PaginatedLectureResponse",
 *   type="object",
 *
 *   @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Lecture")),
 *   @OA\Property(property="links", type="object"),
 *   @OA\Property(property="meta", type="object",
 *     @OA\Property(property="current_page", type="integer"),
 *     @OA\Property(property="last_page", type="integer"),
 *     @OA\Property(property="per_page", type="integer"),
 *     @OA\Property(property="total", type="integer")
 *   )
 * )
 *
 * @OA\Schema(
 *   schema="Student",
 *   type="object",
 *
 *   @OA\Property(property="id", type="integer", example=1),
 *   @OA\Property(property="name", type="string", example="John Doe"),
 *   @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *   @OA\Property(property="classroom", nullable=true, ref="#/components/schemas/Classroom"),
 *   @OA\Property(property="lectures", type="array", @OA\Items(ref="#/components/schemas/Lecture"))
 * )
 *
 * @OA\Schema(
 *   schema="StudentStoreRequest",
 *   type="object",
 *   required={"name","email"},
 *
 *   @OA\Property(property="name", type="string", maxLength=255),
 *   @OA\Property(property="email", type="string", format="email", maxLength=255),
 *   @OA\Property(property="classroom_id", type="integer", nullable=true)
 * )
 *
 * @OA\Schema(
 *   schema="StudentUpdateRequest",
 *   type="object",
 *
 *   @OA\Property(property="name", type="string", maxLength=255),
 *   @OA\Property(property="email", type="string", format="email", maxLength=255),
 *   @OA\Property(property="classroom_id", type="integer", nullable=true)
 * )
 *
 * @OA\Schema(
 *   schema="PaginatedStudentResponse",
 *   type="object",
 *
 *   @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Student")),
 *   @OA\Property(property="links", type="object"),
 *   @OA\Property(property="meta", type="object",
 *     @OA\Property(property="current_page", type="integer"),
 *     @OA\Property(property="last_page", type="integer"),
 *     @OA\Property(property="per_page", type="integer"),
 *     @OA\Property(property="total", type="integer")
 *   )
 * )
 *
 * @OA\Schema(
 *   schema="Classroom",
 *   type="object",
 *
 *   @OA\Property(property="id", type="integer", example=1),
 *   @OA\Property(property="name", type="string", example="Class A"),
 *   @OA\Property(property="students", type="array", @OA\Items(ref="#/components/schemas/Student"))
 * )
 *
 * @OA\Schema(
 *   schema="ClassroomStoreRequest",
 *   type="object",
 *   required={"name"},
 *
 *   @OA\Property(property="name", type="string", maxLength=255)
 * )
 *
 * @OA\Schema(
 *   schema="ClassroomUpdateRequest",
 *   type="object",
 *
 *   @OA\Property(property="name", type="string", maxLength=255)
 * )
 *
 * @OA\Schema(
 *   schema="PaginatedClassroomResponse",
 *   type="object",
 *
 *   @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Classroom")),
 *   @OA\Property(property="links", type="object"),
 *   @OA\Property(property="meta", type="object")
 * )
 *
 * @OA\Schema(
 *   schema="CurriculumUpsertRequest",
 *   type="object",
 *   required={"lectures"},
 *
 *   @OA\Property(
 *     property="lectures",
 *     type="array",
 *
 *     @OA\Items(type="object",
 *       required={"id","position"},
 *
 *       @OA\Property(property="id", type="integer"),
 *       @OA\Property(property="position", type="integer")
 *     )
 *   )
 * )
 *
 * @OA\Schema(
 *   schema="CurriculumResponse",
 *   type="object",
 *
 *   @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Lecture"))
 * )
 */
final class Schemas
{
    // Intentionally empty. Holds component schema annotations.
}
