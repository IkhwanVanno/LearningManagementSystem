<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAnswer extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'student_id',
        'question_id',
        'selected_answer',
        'is_correct',
        'answered_at'
    ];
    protected $casts = [
        'is_correct' => 'boolean',
        'answered_at' => 'datetime'
    ];
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
