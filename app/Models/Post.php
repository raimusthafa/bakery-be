<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
        /**
     * fillable
     *
     * @var array
     */

    protected $fillable = [
        'image',
        'title',
        'content',       // deskripsi produk
        'price',
        'is_preorder',
        'category_id',
    ];

    protected $casts = [
        'price' => 'float',
        'is_preorder' => 'boolean',
    ];

    /**
     * Accessor for image URL.
     */
        /**
     * image
     *
     * @return Attribute
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($image) => url('/storage/posts/' . $image),
        );
    }

    /**
     * Relasi ke kategori produk.
     */
    // public function category()
    // {
    //     return $this->belongsTo(Category::class);
    // }

    // /**
    //  * Relasi ke stok produk (jika ada).
    //  */
    // public function productStocks()
    // {
    //     return $this->hasMany(ProductStock::class, 'product_id');
    // }

    // /**
    //  * Relasi ke item pesanan.
    //  */
    // public function orderItems()
    // {
    //     return $this->hasMany(OrderItem::class, 'product_id');
    // }
}
