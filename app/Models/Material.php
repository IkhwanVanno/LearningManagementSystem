<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = ['class_id', 'type_id', 'title', 'content'];
    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }
    public function type()
    {
        return $this->belongsTo(MaterialType::class, 'type_id');
    }
}
