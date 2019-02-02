<?php

namespace App\Http\Controllers\User\Main;

use App\Http\Controllers\Controller;

use App\Model\Product\Category;
use App\Model\Product\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        try{
            $category_ids=$request->input("category_ids") ?:null;
            $page = $request->input('page') ?: 0;
            $count = $request->input('count') ?: 30;
            $product= Product::select("id","title","code")
                ->where("status",1)
                ->where("publish_time","<=",date("Y-m-d H:i:s"))
                ->take((int)$count)
                ->offset(((int)$page - 1) * $count);

                if($category_ids!=null){
                    $product->whereIn("category_id",$request->input("category_ids"));
                }

            $product=$product->get();
            if($product){
                return response(['status' => true, 'resutlt' =>$product->toArray() ],200);
            }else{
                return response(['status' => false, 'message' =>"not found" ],401);
            }

        }catch (\Exception $e){
            return response(['status' => false, 'message' => $e->getMessage()],403);
        }
    }

    public function getCategory(){
        try{
            $data=Category::where("is_active",true)->select("id","title")->get();
            if($data){
                return response(['status' => true, 'resutlt' =>$data->toArray() ],200);
            }else{
                return response(['status' => false, 'message' =>"not found" ],401);
            }
        }catch (\Exception $e){
            return response(['status' => false, 'message' => $e->getMessage()],403);
        }
    }

}
