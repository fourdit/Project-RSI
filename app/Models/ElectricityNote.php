<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectricityNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'price_per_kwh',
        'house_power',
        'total_cost',
    ];

    protected $casts = [
        'date' => 'date',
        'price_per_kwh' => 'decimal:2',
        'total_cost' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(ElectricityItem::class, 'note_id');
    }
}