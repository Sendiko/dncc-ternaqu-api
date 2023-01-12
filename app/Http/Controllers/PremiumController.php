<?php

namespace App\Http\Controllers;

use App\Models\User;

class PremiumController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(int $id)
    {
        $user = User::find($id); // find data by id
        $user->update([
            "premium" => "1"
        ]); // update data in users table

        return response()->json([
            'status' => 200,
            'message' => "Selamat datang di premium, $user->name!!",
            'info' => $user
        ], 200); // return data with status code 200
    }
}
