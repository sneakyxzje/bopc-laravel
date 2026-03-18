<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['name', 'slug', 'logo_path'];

    /**
     * LẤY SẢN PHẨM THEO HÃNG: Trả về tất cả linh kiện thuộc thương hiệu này.
     * Ví dụ: Hãng "ASUS" -> Trả về Mainboard ASUS, VGA ASUS, Màn hình ASUS...
     * Cách dùng: $brand->products
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
