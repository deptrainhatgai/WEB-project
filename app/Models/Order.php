<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'cake_id',
        'customer_id',
        'quantity',
        'total_price',
        'status',
    ];

    public function cake()
    {
        return $this->belongsTo(Cake::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}