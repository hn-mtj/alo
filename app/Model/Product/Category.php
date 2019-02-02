<?php

namespace App\Model\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id',
        'title',
        'slug',
        'is_active'
    ];

    public static function getName($id){
        $data=static::where("id",$id)->select("title","id")->first();
        if($data){
            return $data->toArray();
        }else{
            return null;
        }
    }
}
