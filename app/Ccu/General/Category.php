<?php

namespace App\Ccu\General;

use App\Ccu\Core\Entity;
use Cache;

class Category extends Entity
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['id', 'name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category', 'name'];


    /**
     * Get categories or specific one from database.
     *
     * @param string|null $category
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getCategories($category = null)
    {
        $categories = Cache::remember('categories', self::CACHE_A_MONTH, function ()
        {
            return Category::all();
        });

        if ((null === $category) || ! is_string($category))
        {
            return $categories;
        }

        $categories = $categories->filter(function ($item) use ($category)
        {
            return $category === $item->category;
        });

        return $categories->flatten();
    }
}