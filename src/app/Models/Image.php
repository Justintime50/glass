<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Images can be attached to a Post.
 *
 * @property int $id
 * @property string $subdirectory
 * @property string $filename
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @mixin \Eloquent
 */
class Image extends Model
{
    use HasFactory;
}
