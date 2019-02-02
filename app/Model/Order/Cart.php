<?php

namespace App\Model\Order;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable=[
        "id",
        "product_id",
        "order_id",
        "price",
        "qty"

    ];
}
