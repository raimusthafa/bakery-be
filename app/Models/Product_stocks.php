<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product_stocks extends Model
{
    use HasFactory;
        /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'stock',
    ];

    /**
     * Relasi ke produk (Post)
     */
    public function product()
    {
        return $this->belongsTo(Post::class, 'product_id');
    }
}
