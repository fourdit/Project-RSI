<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectricityItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'note_id',
        'appliance_name',
        'quantity',
        'duration_hours',
        'duration_minutes',
        'wattage',
        'cost',
    ];

    protected $casts = [
        'cost' => 'decimal:2',
    ];

    public function note()
    {
        return $this->belongsTo(ElectricityNote::class, 'note_id');
    }
}