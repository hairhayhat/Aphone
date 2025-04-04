<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    public function variants()
    {
        return $this->belongsToMany(Variant::class, 'storages');
    }
}
