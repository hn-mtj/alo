<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\ProductRequest;
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
            $page = $request->input('page') ?: 0;
            $count = $request->input('count') ?: 30;
            $data= Product::select("id","title","code")
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
            $data=$request->json()->all();

            if(!isset($data["code"])){
                $data["code"]=Product::generateProductCode();
            }else{
                $data["code"]=Product::generateProductCode($data["code"]);
            }

            $product= Product::create($data);

            if(Product::$status[$data["status"]]=="publish" and isset($data["price"])){
                PriceLog::insertLog($product->id,$data["price"]);
            }

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

        $product=Product::where("id",$request->get("id"))->first();
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
            $data=$request->json()->all();

            if(isset($data["code"])){
                unset($data["code"]);
            }

            if(isset($data["id"])){
                $product=Product::where("id",$data["id"])->first();
                if($product){
                    if( $product->update($data)){
                        PriceLog::insertLog($product->id,$data["price"]);
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
