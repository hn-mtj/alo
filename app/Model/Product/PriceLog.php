<?php

namespace App\Model\Product;

use Illuminate\Database\Eloquent\Model;

class PriceLog extends Model
{

    protected $fillable = [
        'id',
        'product_id' ,
        'price' ,
        'publish_time' ,
    ];

    public static function insertLog($product_id,$price){

        $old_price=static::where("product_id",$product_id)->orderBy('id', 'DESC')->pluck("price")->first();

        if($old_price!=$price){
            static::create(["product_id"=>$product_id,"price"=>$price,"publish_time"=>date("Y-m-d H:i:s")]);
        }
    }

    public static function showLog($product_id){
        $data=static::where("product_id",$product_id)
            ->orderBy('id')
            ->select("price","publish_time")
            ->get();
        if($data){
            return $data->toArray();
        }else{
            return null;
        }
    }
}
