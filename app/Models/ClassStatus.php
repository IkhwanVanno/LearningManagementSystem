<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassStatus extends Model
{
    use HasFactory;

    protected $table = 'class_statuses';

    protected $fillable = [
        'name'
    ];

    public function classes()
    {
        return $this->hasMany(ClassRoom::class, 'status_id');
    }
}
