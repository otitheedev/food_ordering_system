<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'food_id',
        'customer_name',
        'quantity',
        'phone_number',
    ];

    public function food()
    {
        return $this->belongsTo(Food::class);
    }
}