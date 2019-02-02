<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAddress extends Model
{
    use SoftDeletes;

    protected $fillable=[
        "id",
        "user_id",
        "email",
        "name",
        "mobile",
        "address",
        "postal_code",
        "city_id",
        "province_id",
        "latitude",
        "longitude",
    ];
}
