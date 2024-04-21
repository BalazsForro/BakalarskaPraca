<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Data extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'voltage',
        'current',
        'power',
        'light',
        'effectivity',
        'device_id',
        'created_at'
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class, 'device_id');
    }
}
