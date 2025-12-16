<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    protected $table = 'classes';
    protected $fillable = ['mentor_id', 'title', 'description', 'status_id'];
    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }
    public function members()
    {
        return $this->hasMany(ClassMember::class, 'class_id');
    }
    public function materials()
    {
        return $this->hasMany(Material::class, 'class_id');
    }
    public function exercises()
    {
        return $this->hasMany(Exercise::class, 'class_id');
    }
    public function status()
    {
        return $this->belongsTo(ClassStatus::class, 'status_id');
    }
}
