<?php

namespace App\Http\Controllers\User\Address;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Address\AddressUserRequest;
use App\Model\User\UserAddress;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id=1;
        try{
            $user_id=1; // temp

            $page = $request->input('page') ?: 0;
            $count = $request->input('count') ?: 30;
            $data= UserAddress::where("user_id",$user_id)
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
    public function store(AddressUserRequest $request)
    {
        try {
            $user_id=1;  //temp

            $data=$request->json()->all();

            $data["user_id"]=$user_id;

            $product= UserAddress::create($data);
            return $product;

        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()],403);
        }

    }

    /**
     * Update the specified resource in storage.
     *

     * @return \Illuminate\Http\Response
     */
    public function update(AddressUserRequest $request)
    {
        try {
            $user_id=1; // temp
            $data=$request->json()->all();

            if(isset($data["id"])){
                $address=UserAddress::where("id",$data["id"])->where("user_id",$user_id)->first();
                if($address){
                    if( $address->update($data)){
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

}
