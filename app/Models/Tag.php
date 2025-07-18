<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];

    // ✅ Tag has many Tasks (many-to-many)
    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }
}
