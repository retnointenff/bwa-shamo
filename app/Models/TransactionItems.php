<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'transaction_id',
        'quantity'
    ];

    public function product()
    {
        return $this->hasOne(Products::class, 'id', 'product_id');
    }
}
