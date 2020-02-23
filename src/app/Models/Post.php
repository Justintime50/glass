<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'reading_time',
        'keywords',
        'category_id',
        'user_id',
        'post',
        'published',
    ];

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();;
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->withTrashed();;
    }
}
