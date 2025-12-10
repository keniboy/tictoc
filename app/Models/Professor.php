<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Professor extends Model
{
    use HasFactory;

    protected $table = 'professors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'telemovel',
    ];

    /**
     * Get the courses for the professor.
     */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'professor_id');
    }
}

