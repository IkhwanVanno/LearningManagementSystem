<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassMemberStatus extends Model
{
    use HasFactory;

    protected $table = 'class_member_statuses';

    protected $fillable = [
        'name'
    ];

    public function classMembers()
    {
        return $this->hasMany(ClassMember::class, 'status_id');
    }
}
