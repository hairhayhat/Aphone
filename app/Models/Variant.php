<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{

    protected $table = 'product_variants';
    protected $fillable = ['product_id', 'price', 'quantity', 'color_id', 'storage_id'];
    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }
}
