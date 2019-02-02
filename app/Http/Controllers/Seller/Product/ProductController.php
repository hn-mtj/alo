<?php

namespace App\Http\Controllers\Seller\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\ProductRequest;
use App\Model\Product\Category;
use App\Model\Product\PriceLog;
use App\Model\Product\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $user_id=1; // temp

            $page = $request->input('page') ?: 0;
            $count = $request->input('count') ?: 30;
            $data= Product::select("id","title","code")
                ->where("provider_id",$user_id)
                ->take((int)$count)
                ->offset(((int)$page - 1) * $count)
                ->get();
            if($data){
                return response(['status' => true, 'resutlt' =>$data->toArray() ],200);
            }else{
                return response(['status' => false, 'message' =>"not found" ],401);
            }

        }catch (\Exception $e){
            return response(['status' => false, 'message' => $e->getMessage()],403);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        try {

            $user_id=1;  //temp

            $data=$request->json()->all();
            $data["provider_id"]=$user_id;
            $data["status"]=2;

            if(!isset($data["code"])){
                $data["code"]=Product::generateProductCode();
            }else{
                $data["code"]=Product::generateProductCode($data["code"]);
            }
            $product= Product::create($data);
            return $product;

        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()],403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //TODO change request to object

        $user_id=1; //temp

        $product=Product::where("id",$request->get("id"))->where("provider_id",$user_id)->first();
        if($product){
            $product=$product->toArray();

            $product["price_log"]=PriceLog::showLog($product["id"]);
            $product["category"]=Category::getName($product["category_id"]);

            return response(['status' => true, 'resutlt' =>$product],200);
        }else{
            return response(['status' => false, 'message' =>"not found"],401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request)
    {
        try {
            $user_id=1; // temp
            $data=$request->json()->all();

            if(isset($data["code"])){
                unset($data["code"]);
            }
            $data["status"]=2;

            if(isset($data["id"])){
                $product=Product::where("id",$data["id"])->where("provider_id",$user_id)->first();
                if($product){
                    if( $product->update($data)){
                        return response(['status' => true ],200);
                    }else{
                        return response(['status' => false],401);
                    }
                }else{
                    return response(['status' => false],401);
                }
            }else{
                return response(['status' => false],401);
            }
        }catch (\Exception $e) {
            return response(['status' => false, 'message' => $e->getMessage()],403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
