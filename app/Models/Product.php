<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    // Giá trị mặc định khi tạo mới - is_active luôn là true
    protected $attributes = [
        'is_active' => true,
    ];

    // Method trả về 1 kết quả để biết sản phẩm thuộc về danh mục nào
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Tương tự như trên, để biết được thuộc về brand nào
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }


    // Trả về các thông số kỹ thuật của PC, 1 PC có nhiều thông số kỹ thuật
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
