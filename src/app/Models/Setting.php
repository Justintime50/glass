<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Setettings are the main configuration of the blog.
 *
 * @property int $id
 * @property string $title
 * @property int $theme
 * @property int $comments
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @mixin \Eloquent
 */
class Setting extends Model
{
    protected $fillable = [
        'comments',
        'theme',
        'title',
    ];
}
