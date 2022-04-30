<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * A PostType has Many Child PostTypes
     */
    public function children()
    {
        return $this->hasMany(PostType::class, 'parent_id', 'id');
    }

    /**
     * A PostType has or not A Parent PostType
     */
    public function parent()
    {
        return $this->belongsTo(PostType::class, 'parent_id', 'id');
    }

    /**
     * This is Parent PostType or not
     */
    public function isParent()
    {
        return is_null($this->parent_id);
    }
}
