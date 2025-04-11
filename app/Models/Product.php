<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    //
    use hasFactory;
    protected $table = 'products';
    protected $fillable = ['name', 'price', 'category_id', 'image', 'description','is_showhome'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(Variant::class, 'product_id', 'id');
    }

    public function gallerires()
    {
        return $this->hasMany(Gallery::class);
    }
}
