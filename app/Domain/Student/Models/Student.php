<?php

declare(strict_types=1);

namespace App\Domain\Student\Models;

use App\Domain\Classroom\Models\Classroom;
use App\Domain\Lecture\Models\Lecture;
use App\Domain\Student\Factories\StudentFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property int|null $classroom_id
 * @property-read Classroom|null $classroom
 * @property-read Collection<int, Lecture> $lectures
 */
class Student extends Model
{
    use HasFactory;

    protected static string $factory = StudentFactory::class;

    protected $fillable = ['name', 'email', 'classroom_id'];

    /**
     * @return BelongsTo<Classroom, Student>
     */
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    /**
     * @return BelongsToMany<Lecture>
     */
    public function lectures(): BelongsToMany
    {
        return $this->belongsToMany(Lecture::class)
            ->withPivot('attended_at')
            ->withTimestamps();
    }
}
