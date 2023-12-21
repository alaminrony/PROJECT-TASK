<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory,SoftDeletes;

    public function customer() {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function orderDetails() {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function transactionHistory()
    {
        return $this->hasOne(TransactionHistory::class, 'order_id');
    }
}
