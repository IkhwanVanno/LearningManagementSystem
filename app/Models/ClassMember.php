<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassMember extends Model
{
    public $timestamps = false;
    protected $fillable = ['class_id', 'student_id', 'status_id', 'joined_at'];
    protected $casts = [
        'joined_at' => 'datetime',
    ];
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }
    public function status()
    {
        return $this->belongsTo(ClassMemberStatus::class, 'status_id');
    }
}
