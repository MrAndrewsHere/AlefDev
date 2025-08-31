<?php

declare(strict_types=1);

namespace App\Domain\Lecture\Models;

use App\Domain\Classroom\Models\Classroom;
use App\Domain\Lecture\Factories\LectureFactory;
use App\Domain\Student\Models\Student;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $topic
 * @property string $description
 * @property-read Collection<int, Classroom> $classrooms
 * @property-read Collection<int, Student> $students
 */
class Lecture extends Model
{
    use HasFactory;

    protected $fillable = ['topic', 'description'];

    protected static string $factory = LectureFactory::class;

    /**
     * @return BelongsToMany<Classroom>
     */
    public function classrooms(): BelongsToMany
    {
        return $this->belongsToMany(Classroom::class)
            ->withPivot('position')
            ->withTimestamps()
            ->orderBy('classroom_lecture.position');
    }

    /**
     * @return BelongsToMany<Student>
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class)
            ->withPivot('attended_at')
            ->withTimestamps();
    }
}
