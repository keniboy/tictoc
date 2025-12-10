<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enrollment extends Model
{
    use HasFactory;

    protected $table = 'enrollments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'course_id',
        'data_matricula',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'data_matricula' => 'date',
        ];
    }

    /**
     * Get the student that owns the enrollment.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * Get the course that owns the enrollment.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
     * Get the evaluations for the enrollment.
     */
    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class, 'enrollment_id');
    }

    /**
     * Get the payments for the enrollment.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'enrollment_id');
    }
}

