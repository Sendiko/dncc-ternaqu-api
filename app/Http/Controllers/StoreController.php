<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\StoreUpdateRequest;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = Store::get(); // get all data from stores table

        return response()->json([
            'status' => 200,
            'message' => 'data successfully retrieved',
            'stores' => $stores
        ], 200); // return data with status code 200
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStoreRequest $request)
    {
        $data = $request->validated(); // validate data from request
        $data['store_id'] = uniqid(); // generate unique id

        $store = Store::create($data); // create new data in stores table

        return response()->json([
            'status' => 201,
            'message' => 'data successfully sent',
            'store' => $store
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
        $store = Store::find($id); // find data by id

        if (!$store) { // if data not found
            return response()->json([
                'status' => 404,
                'message' => "store with id " . $id . " not found",
                'stores' => $store
            ], 404); // return data with status code 404
        }

        return response()->json([
            'status' => 200,
            'message' => 'data successfully retrieved',
            'stores' => $store
        ], 200); // return data with status code 200
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateRequest $request, int $id)
    {
        $data = $request->validated(); // validate data from request

        $store = Store::find($id); // find data by id

        if (!$store) { // if data not found
            return response()->json([
                'status' => 404,
                'message' => "store with id " . $id . " not found",
                'stores' => 'null'
            ], 404); // return data with status code 404
        }

        $store->update($data);

        return response()->json([
            'status' => 200,
            'message' => 'data successfully updated',
            'store' => $store
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
        $store = Store::find($id); // find data by id

        if (!$store) { // if data not found
            return response()->json([
                'status' => 404,
                'message' => "store with id " . $id . " not found",
                'stores' => 'null'
            ], 404); // return data with status code 404
        }

        $store->delete(); // delete data

        return response()->json([
            'status' => 200,
            'message' => 'data successfully deleted',
            'store' => $store
        ], 200); // return data with status code 200
    }
}
