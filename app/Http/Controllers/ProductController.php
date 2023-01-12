<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::get(); // get all data from products table

        return response()->json([
            'status' => 200,
            'message' => 'data successfully retrieved',
            'product' => $products
        ], 200); // return data with status code 200
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProductStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        $data = $request->validated(); // validate data from request
        $data['product_id'] = uniqid(); // generate unique id

        $product = Product::create($data); // create new data in products table

        return response()->json([
            'status' => 201,
            'message' => 'data successfully sent',
            'product' => $product
        ], 201); // return data with status code 201
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $product = Product::with('store')->find($id); // find data by id

        if (!$product) { // if data not found
            return response()->json([
                'status' => 404,
                'message' => "product id " . $id . " not found",
                'product' => 'null'
            ], 404); // return data with status code 404
        }

        return response()->json([
            'status' => 200,
            'message' => 'data successfully retrieved',
            'product' => $product,
            'store' => $product->store
        ], 200); // return data with status code 200
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProductUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, int $id)
    {
        $data = $request->validated(); // validate data from request

        $product = Product::find($id); // find data by id

        if (!$product) { // if data not found
            return response()->json([
                'status' => 404,
                'message' => "product with id $id not found",
                'product' => 'null'
            ], 404); // return data with status code 404
        }

        $product->update($data); // update data in products table

        return response()->json([
            'status' => 200,
            'message' => 'data successfully updated',
            'product' => $product
        ], 200); // return data with status code 200
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $product = Product::find($id); // find data by id

        if (!$product) { // if data not found
            return response()->json([
                'status' => 404,
                'message' => "product with id $id not found",
                'product' => 'null'
            ], 404); // return data with status code 404
        }

        $product->delete(); // delete data in products table

        return response()->json([
            'status' => 200,
            'message' => 'data successfully deleted',
            'product' => $product
        ], 200); // return data with status code 200
    }
}
