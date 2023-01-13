<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Http\Requests\RecipeStoreRequest;
use App\Http\Requests\RecipeUpdateRequest;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipes = Recipe::get(); // get all data from recipes table

        return response()->json([
            'status' => 200,
            'message' => 'data successfully retrieved',
            'recipe' => $recipes
        ], 200); // return data with status code 200
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RecipeStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RecipeStoreRequest $request)
    {
        $data = $request->validated(); // validate data from request

        if (array_key_exists('imageUrl', $data)) { // if imageUrl key exist in data
            $data['imageUrl'] = $this->saveSingleFile('image', $data['imageUrl']); // save image and return image url
        }

        $recipe = Recipe::create($data); // create new data in recipes table

        if (array_key_exists('imageUrl', $data)) { // if imageUrl key exist in data
            $recipe->imageUrl = route('image.show', $recipe->imageUrl); // add image url to data
        }

        return response()->json([
            'status' => 201,
            'message' => 'data successfully sent',
            'recipe' => $recipe
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
        $recipe = Recipe::find($id); // find data by id

        if (!$recipe) { // if data not found
            return response()->json([
                'status' => 404,
                'message' => "recipe id " . $id . " not found",
                'recipe' => 'null'
            ], 404); // return data with status code 404
        }

        if (!empty($recipe->imageUrl)) { // if image url not empty
            $recipe->imageUrl = route('image.show', $recipe->imageUrl); // add image url to data
        }

        return response()->json([
            'status' => 200,
            'message' => 'data successfully retrieved',
            'recipe' => $recipe
        ], 200); // return data with status code 200
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\RecipeUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RecipeUpdateRequest $request, int $id)
    {
        $data = $request->validated(); // validate data from request

        $recipe = Recipe::find($id); // find data by id

        if (!$recipe) { // if data not found
            return response()->json([
                'status' => 404,
                'message' => "recipe with id " . $id . " not found",
                'recipe' => 'null'
            ], 404); // return data with status code 404
        }

        if (array_key_exists('imageUrl', $data)) { // if imageUrl key exist in data
            $data['imageUrl'] = $this->updateSingleFile('image', $data['imageUrl'], $recipe->imageUrl); // update image and return image url
        }

        $recipe->update($data); // update data in recipes table

        if (array_key_exists('imageUrl', $data)) { // if imageUrl key exist in data
            $recipe->imageUrl = route('image.show', $recipe->imageUrl); // add image url to data
        }

        return response()->json([
            'status' => 200,
            'message' => 'data successfully updated',
            'recipe' => $recipe
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
        $recipe = Recipe::find($id); // find data by id

        if (!$recipe) { // if data not found
            return response()->json([
                'status' => 404,
                'message' => "recipe with id " . $id . " not found",
                'recipe' => 'null'
            ], 404); // return data with status code 404
        }

        if (!empty($recipe->imageUrl)) { // if image url not empty
            $this->deleteFile('image', $recipe->imageUrl); // delete image
        }

        $recipe->delete(); // delete data in recipes table

        if (!empty($recipe->imageUrl)) { // if image url not empty
            $recipe->imageUrl = route('image.show', $recipe->imageUrl); // add image url to data
        }

        return response()->json([
            'status' => 200,
            'message' => 'data successfully deleted',
            'recipe' => $recipe
        ], 200); // return data with status code 200
    }
}
