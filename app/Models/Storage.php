<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    protected $table = 'variant_storages';
    public function variants()
    {
        return $this->belongsToMany(Variant::class, 'variant_storages');
    }
}
