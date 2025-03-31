<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table = 'variant_colors';
    public function variants()
    {
        return $this->belongsToMany(Variant::class, 'variant_colors');
    }
}
