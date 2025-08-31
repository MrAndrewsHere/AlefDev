<?php

declare(strict_types=1);

namespace App\Domain\Student\Services;

use App\Domain\Classroom\DTOs\ClassroomData;
use App\Domain\Student\DTOs\StudentStoreData;
use App\Domain\Student\DTOs\StudentUpdateData;
use App\Domain\Student\Models\Student;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class StudentService
{
    /**
     * @return LengthAwarePaginator<int, Student>
     */
    public function list(int $perPage = 15): LengthAwarePaginator
    {
        return QueryBuilder::for(Student::class)
            ->with(['classroom', 'lectures'])
            ->allowedFilters([
                AllowedFilter::partial('name'),
                AllowedFilter::partial('email'),
                AllowedFilter::exact('classroom_id'),
            ])
            ->allowedSorts(['id', 'name', 'email'])
            ->defaultSort('-id')
            ->paginate($perPage);
    }

    public function get(Student $student): Student
    {
        return $student->load(['classroom', 'lectures']);
    }

    public function create(StudentStoreData $studentStoreData): Student
    {
        $student = new Student;

        $student = $this->fillFromDTO($student, $studentStoreData);

        $student->save();
        $student->load(['classroom']);

        return $student;
    }

    public function update(Student $student, StudentUpdateData $studentUpdateData): Student
    {
        $student->fill($studentUpdateData->only('name', 'email')->toArray());
        $student = $this->fillFromDTO($student, $studentUpdateData);
        $student->save();
        $student->refresh();
        $student->load(['classroom']);

        return $student;
    }

    public function delete(Student $student): void
    {
        $student->delete();
    }

    private function fillFromDTO(Student $student, StudentStoreData|StudentUpdateData $data): Student
    {
        $student->fill($data->only('name', 'email')->toArray());

        if ($data->classroom instanceof ClassroomData) {
            $student->fill(['classroom_id' => $data->classroom->id]);
        }

        return $student;
    }
}
