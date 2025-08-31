<?php

declare(strict_types=1);

namespace App\Domain\Classroom\Models;

use App\Domain\Classroom\Factories\ClassroomFactory;
use App\Domain\Lecture\Models\Lecture;
use App\Domain\Student\Models\Student;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property-read Collection<int, Student> $students
 * @property-read Collection<int, Lecture> $lectures
 */
class Classroom extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected static string $factory = ClassroomFactory::class;

    /**
     * @return HasMany<Student>
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Lectures in the classroom curriculum with order.
     *
     * @return BelongsToMany<Lecture>
     */
    public function lectures(): BelongsToMany
    {
        return $this->belongsToMany(Lecture::class)
            ->withPivot('position')
            ->withTimestamps()
            ->orderBy('classroom_lecture.position');
    }
}
