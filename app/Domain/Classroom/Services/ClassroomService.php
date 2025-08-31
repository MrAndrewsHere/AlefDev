<?php

declare(strict_types=1);

namespace App\Domain\Classroom\Services;

use App\Domain\Classroom\DTOs\ClassroomStoreData;
use App\Domain\Classroom\DTOs\ClassroomUpdateData;
use App\Domain\Classroom\Models\Classroom;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ClassroomService
{
    /**
     * @return LengthAwarePaginator<int, Classroom>
     */
    public function list(int $perPage = 15): LengthAwarePaginator
    {
        return QueryBuilder::for(Classroom::class)
            ->with(['students'])
            ->allowedFilters([
                AllowedFilter::partial('name'),
            ])
            ->allowedSorts(['id', 'name'])
            ->defaultSort('-id')
            ->paginate($perPage);
    }

    public function get(Classroom $classroom): Classroom
    {
        return $classroom->load(['students', 'lectures']);
    }

    public function create(ClassroomStoreData $classroomStoreData): Classroom
    {
        return Classroom::query()->create($classroomStoreData->toArray());
    }

    public function update(Classroom $classroom, ClassroomUpdateData $classroomUpdateData): Classroom
    {
        $classroom->fill($classroomUpdateData->toArray());
        $classroom->save();

        return $classroom->refresh();
    }

    public function delete(Classroom $classroom): void
    {
        // Students are detached via foreign key nullOnDelete.
        $classroom->delete();
    }

    public function getCurriculum(Classroom $classroom): Classroom
    {
        return $classroom->load(['lectures']);
    }

    /**
     * @param  array<int, array{lecture_id:int, position:int}>  $lectures
     */
    public function upsertCurriculum(Classroom $classroom, array $lectures): Classroom
    {
        $sync = [];
        foreach ($lectures as $lecture) {
            $sync[$lecture['lecture_id']] = ['position' => $lecture['position']];
        }

        $classroom->lectures()->sync($sync);

        return $classroom->load('lectures');
    }
}
