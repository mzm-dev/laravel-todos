<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'is_active'];

    // ✅ Category has many Tasks
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
