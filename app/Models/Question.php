<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public $timestamps = false;
    protected $fillable = ['exercise_id', 'question_text', 'option_a', 'option_b', 'option_c', 'option_d', 'correct_answer'];
    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }
    public function answers()
    {
        return $this->hasMany(StudentAnswer::class);
    }
}
