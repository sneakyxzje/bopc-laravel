<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'parent_id'];


    /* 
        Method này trả về toàn bộ sản phẩm thuộc 1 danh mục
    */
    public function products()
    {
        return $this->hasMany(Product::class);
    }


    /* 
        Đoạn này về sau có thể sẽ cần.
        Trả về danh mục cấp trên của nó (nếu có).
        Ví dụ: CPU -> thuộc về -> Linh kiện.
    */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
