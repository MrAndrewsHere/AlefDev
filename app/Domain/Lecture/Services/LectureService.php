<?php

declare(strict_types=1);

namespace App\Domain\Lecture\Services;

use App\Domain\Lecture\DTOs\LectureStoreData;
use App\Domain\Lecture\DTOs\LectureUpdateData;
use App\Domain\Lecture\Models\Lecture;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class LectureService
{
    /**
     * @return LengthAwarePaginator<int, Lecture>
     */
    public function list(int $perPage = 15): LengthAwarePaginator
    {
        return QueryBuilder::for(Lecture::class)
            ->allowedFilters([
                AllowedFilter::partial('topic'),
                AllowedFilter::partial('description'),
            ])
            ->allowedSorts(['id', 'topic'])
            ->defaultSort('-id')
            ->paginate($perPage);
    }

    public function get(Lecture $lecture): Lecture
    {
        return $lecture->load(['classrooms', 'students']);
    }

    public function create(LectureStoreData $lectureStoreData): Lecture
    {
        return Lecture::query()->create($lectureStoreData->toArray());
    }

    public function update(Lecture $lecture, LectureUpdateData $lectureUpdateData): Lecture
    {
        $lecture->fill($lectureUpdateData->toArray());
        $lecture->save();

        return $lecture->refresh();
    }

    public function delete(Lecture $lecture): void
    {
        $lecture->delete();
    }
}
