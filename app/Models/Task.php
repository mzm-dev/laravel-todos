<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'user_id',
        'due_date',
        'is_completed',
    ];

    // ✅ Task belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ✅ Task belongs to a Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // ✅ Task has many Tags (many-to-many)
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
