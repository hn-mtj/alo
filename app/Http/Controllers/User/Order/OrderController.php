<?php

namespace App\Http\Controllers\User\Order;


use App\Http\Controllers\Controller;
use App\Model\Order\Cart;
use App\Model\Order\Order;

use App\Model\Product\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
   public function buyUser(Request $request){

       $data=$request->json()->all();

       $data["time_buy"]=date("Y-m-d H:i:s");
       $data["status"]=1;
       $data["pay_status"]=1;
       $data["tracking_code"]=Order::generateTrackingCode();

       $order=Order::create($data);

       $total_price=0;

       foreach($data["products"] as $row){
           $product=Product::where("id",$row["id"])
               ->where("count_exist",">=",1)
               ->where("publish_time","<",date("Y-m-d h:i:s"))
               ->where("status",1)
               ->first();
           if($product){
               if($row["qty"] <= $product->count_exist){
                   Cart::create(["product_id"=>$row["id"],"order_id"=>$order->id,"price"=>$product->price,"qty"=>$row["qty"]]);
                   $total_price+=($product->price * $row["qty"]);

                   $product->update(["count_exist"=>$product->count_exist-$row["qty"]]);
               }

           }
       }
       $order->update(["total_price"=>$total_price]);

       return response(['status' => true, 'resutlt' =>$order->tracking_code ],200);
   }
}
