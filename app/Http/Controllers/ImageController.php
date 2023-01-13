<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  string  $path
     * @return \Illuminate\Http\Response
     */
    public function show(string $path)
    {
        try {
            $image = Storage::get('/public/image/' . $path);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 404,
                'message' => 'image not found'
            ], 404);
        }

        return response($image, 200)->header('Content-Type', Storage::getMimeType('/public/image/' . $path));
    }
}
