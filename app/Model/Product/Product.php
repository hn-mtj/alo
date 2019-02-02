<?php

namespace App\Model\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id',
        'title' ,
        'description' ,
        'code' ,
        'roduct_data' ,
        'provider_id' ,
        'publish_time' ,
        'status',
	    'count_sell',
	    'count_exist',
	    'price',
	    'provider_price_suggest',
	    'category_id',
    ];

    public static $status=[
        1 =>"publish",
        2=>"wait",
        3=>"expire"
    ];


    public static function generateProductCode($randomString=null){
        $characters = '0123456789KQRUVWXZPHL';
        $charactersLength = strlen($characters);
        $unique=false;
        while($unique!=true){

            if(static::where("code",$randomString)->count()>0){
                $randomString=null;
                $unique=false;
            }else{
                $unique=true;
            }
            if(!$unique){
                if(!$randomString){
                    $randomString = ''.config("app.prifix_product_id");
                }

                for ($i = 0; $i < 7; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
            }

        }
        return $randomString;
    }

}
