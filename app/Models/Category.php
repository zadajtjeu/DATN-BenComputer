<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
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

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * A Category has Many Child Categories
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    /**
     * A Category has or not A Parent Category
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    /**
     * This is Parent Category or not
     */
    public function isParent()
    {
        return is_null($this->parent_id);
    }
}
