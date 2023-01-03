<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();
        return response()->json([
            'status' => 200,
            'message' => 'data successfully retrieved',
            'stores' => $product
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'benefits' => 'required|string',
            'price' => 'required|integer',
            'brand' => 'required|string|max:255',
            'store_id' => 'required|integer',
        ]);

        $product = Product::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'benefits' => $data['benefits'],
            'price' => $data['price'],
            'brand' => $data['brand'],
            'store_id' => $data['store_id'],
            'product_id' => uniqid()
        ]);
        
        return response()->json([
            'status' => 201,
            'message' => 'data successfully sent',
            'product' => $product
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if($product){
            return response()->json([
                'status' => 200,
                'message' => 'data successfully retrieved',
                'recipe' => $product
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "product id $id not found",
                'recipe' => 'null'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        $data = $request->validate([
            'title' => 'string|max:255',
            'description' => 'string',
            'benefits' => 'string',
            'price' => 'integer',
            'brand' => 'string|max:255',
            'store_id' => 'integer',
        ]);
        
        if($product){
            $product->update([
                'title' => $request->title ? $request->title : $product->title,
                'description' => $request->description ? $request->description : $product->description,
                'benefits' => $request->benefits ? $request->benefits : $product->benefits, 
                'price' => $request->price ? $request->price : $product->price, 
                'brand' => $request->brand ? $request->brand : $product->brand,
                'store_id' => $request->store_id ? $request->store_id : $product->store_id,  
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'data successfully updated',
                'product' => $product
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "product with id $id not found",
                'product' => 'null'
            ], 404);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if($product){
            $product->delete();
            return response()->json([
                'status' => 200,
                'message' => 'data successfully deleted',
                'product' => $product
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "product with id $id not found",
                'product' => 'null'
            ], 404); 
        }
    }
}
