<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'MAC',
        'name'
    ];
    public function datas(): HasMany
    {
        return $this->hasMany(Data::class);
    }

}
