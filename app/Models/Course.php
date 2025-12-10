<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'data_inicio',
        'data_fim',
        'professor_id',
        'valor',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'data_inicio' => 'date',
            'data_fim' => 'date',
            'valor' => 'decimal:2',
        ];
    }

    /**
     * Get the professor that owns the course.
     */
    public function professor(): BelongsTo
    {
        return $this->belongsTo(Professor::class, 'professor_id');
    }

    /**
     * Get the enrollments for the course.
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'course_id');
    }
}

