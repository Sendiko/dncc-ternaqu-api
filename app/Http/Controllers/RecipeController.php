<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipe = Recipe::all();
        return response()->json([
            'status' => 200,
            'message' => 'data successfully retrieved',
            'recipe' => $recipe
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
            'benefit' => 'required|string|max:255',
            'tools_and_materials' => 'required|string',
            'steps' => 'required|string'
        ]);

        $recipe = Recipe::create([
            'title' => $data['title'],
            'benefit' => $data['benefit'],
            'tools_and_materials' => $data['tools_and_materials'],
            'steps' => $data['steps']
        ]);
        return response()->json([
            'status' => 201,
            'message' => 'data successfully sent',
            'recipe' => $recipe
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
        $recipe = Recipe::find($id);
        if($recipe){
            return response()->json([
                'status' => 200,
                'message' => 'data successfully retrieved',
                'recipe' => $recipe
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "recipe id $id not found",
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
        $recipe = Recipe::find($id);
        $data = $request->validate([
            'title' => 'string|max:255',
            'benefit' => 'string|max:255',
            'tools_and_materials' => 'string',
            'steps' => 'string'
        ]);
        if($recipe){
            $recipe->update([
                'title' => $request->title ? $request->title : $recipe->title,
                'benefit' => $request->benefit ? $request->benefit : $recipe->benefit,
                'tools_and_materials' => $request->tools_and_materials ? $request->tools_and_materials : $recipe->tools_and_materials,
                'steps' => $request->steps ? $request->steps : $recipe->steps 
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'data successfully updated',
                'recipe' => $recipe
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "recipe with id $id not found",
                'recipe' => 'null'
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
        $recipe = Recipe::find($id);
        if($recipe){
            $recipe->delete();
            return response()->json([
                'status' => 200,
                'message' => 'data successfully deleted',
                'recipe' => $recipe
            ], 200); 
        } else {
            return response()->json([
                'status' => 404,
                'message' => "recipe with id $id not found",
                'recipe' => 'null'
            ], 404);
        }
    }
}
