<?php

namespace App\Model\Order;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{


    protected $fillable=[
        "user_address_id",
        "tracking_code",
        "total_price",
        "status",
        "time_buy",
        "pay_status",
        "tracking_code",
    ];

    public static $status=[
        1=>"wait",
        2=>"make",
        3=>"delivery",
    ];

    public static $pay_status=[
        1=>"wait",
        2=>"pay",
        3=>"cancel",
    ];

    public static function generateTrackingCode(){
        $characters = '0123456789KQRUVWXZPHL';
        $charactersLength = strlen($characters);
        $unique=false;
        while($unique!=true){
            $randomString = ''.config("app.prifix_order_id");
            for ($i = 0; $i < 7; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            if(static::where("tracking_code",$randomString)->count()>0){
                $unique=false;
            }else{
                $unique=true;
            }
        }
        return $randomString;
    }

}
