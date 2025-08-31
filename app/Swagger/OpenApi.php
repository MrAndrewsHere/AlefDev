<?php

declare(strict_types=1);

namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *   version="1.0.0",
 *   title="Template API",
 *   description="API documentation for the Template project"
 * )
 *
 * @OA\Server(
 *   url="/",
 *   description="Application server"
 * )
 *
 * @OA\Tag(name="Lectures", description="Operations about lectures")
 * @OA\Tag(name="Students", description="Operations about students")
 * @OA\Tag(name="Classes", description="Operations about classes and curriculum")
 */
final class OpenApi
{
    // Intentionally empty. This class only holds top-level OpenAPI annotations.
}
