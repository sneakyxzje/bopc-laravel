<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

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
}
