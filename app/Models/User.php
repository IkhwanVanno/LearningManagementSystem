<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'password', 'role_id'];
    protected $hidden = ['password'];
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function mentorClasses()
    {
        return $this->hasMany(ClassRoom::class, 'mentor_id');
    }
    public function classMembers()
    {
        return $this->hasMany(ClassMember::class, 'student_id');
    }
}
