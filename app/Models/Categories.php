<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;

class Categories extends Model
{
    use HasFactory;
        /**
     * fillable
     *
     * @var array
     */

    protected $fillable = [
        'name',
    ];

    /**
     * Get the products for the category.
     */
    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Post::class);
    }
}
