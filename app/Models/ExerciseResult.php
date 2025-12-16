<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExerciseResult extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'exercise_id',
        'student_id',
        'score',
        'submitted_at'
    ];
    protected $casts = [
        'submitted_at' => 'datetime'
    ];
    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
