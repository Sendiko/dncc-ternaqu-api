<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $store = Store::all();
        return response()->json([
            'status' => 200,
            'message' => 'data successfully retrieved',
            'stores' => $store
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
            'name' => 'required|string|max:255',
            'address'=> 'required|string|max:255',
            'description' => 'required|string'
        ]);

        $store = Store::create([
            'store_id' => uniqid(),
            'name' => $data['name'],
            'address' => $data['address'],
            'description' => $data['description']
        ]);

        return response()->json([
            'status' => 201, 
            'message' => 'data successfully sent',
            'store' => $store
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
        $store = Store::find($id);
        if($store){
            return response()->json([
                'status' => 200,
                'message' => 'data successfully retrieved',
                'stores' => $store
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "store with id $id not found",
                'stores' => $store
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
        $data = $request->validate([
            'name' => 'string|max:255',
            'address'=> 'string|max:255',
            'description' => 'string'
        ]);

        $store = Store::find($id);
        if($store){
            $store->update([
                'name' => $request->name ? $request->name : $store->name,
                'address' => $request->address ? $request->address : $store->address,
                'description' => $request->description ? $request->description : $store->description
            ]);
            return response()->json([
                'status' => 200,
                'message' =>'data successfully updated',
                'store' => $store
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "store with id $id not found",
                'stores' => $store
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
        $store = Store::find($id);
        if($store){
            $store->delete();
            return response()->json([
                'status' => 200,
                'message' =>'data successfully deleted',
                'store' => $store
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "store with id $id not found",
                'stores' => $store
            ], 404); 
        }
    }
}
