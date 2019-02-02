<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\CategoryRequest;
use App\Model\Product\Category;
use App\Model\User\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{

            /*$user = new User();
            $user->name = "haa";
            $user->password = Hash::make('123');
            $user->email = 'h@m.gmail';
            $user->save();
            dd();*/

            $page = $request->input('page') ?: 0;
            $count = $request->input('count') ?: 30;
            $data= Category::select("id","title")
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
    public function store(CategoryRequest $request)
    {
        try {
            $data=$request->json()->all();
            $category= Category::create($data);
            return $category;

        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()],403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //TODO change request to object

        $category=Category::where("id",$request->get("id"))->first();
        if($category){
            $category=$category->toArray();
            return response(['status' => true, 'resutlt' =>$category],200);
        }else{
            return response(['status' => false, 'message' =>"not found"],401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Product\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Product\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request)
    {
        try {
            $data=$request->json()->all();
            if(isset($data["id"])){
                $category=Category::where("id",$data["id"])->first();
                if($category){
                    if( $category->update($data)){
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
     * @param  \App\Model\Product\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if(Category::where("id",$request->get("id"))->delete()){
            return response(['status' => true, ],200);
        }else{
            return response(['status' => false],403);
        }
    }
}
