<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Topic;
use App\Http\Requests\TopicStoreRequest;
use App\Http\Requests\TopicUpdateRequest;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = Topic::where('replyTo', 0)->get(); // get all data from topics table
        $topics->toArray(); // convert to array

        if (!$topics) { // if data not found
            return response()->json([
                'status' => 404,
                'message' => 'there is no topic',
                'topics' => 'null'
            ], 404); // return data with status code 404
        }

        return response()->json([
            'status' => 200,
            'message' => 'data successfully retrieved',
            'topics' => $topics
        ], 200); // return data with status code 200
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TopicStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TopicStoreRequest $request)
    {
        $data = $request->validated(); // validate data from request

        $user = User::find($data['user_id']); // find user by id

        if (!$user) { // if user not found
            return response()->json([
                'status' => 404,
                'message' => "user with id " . $user->id . " not found",
                'topic' => 'null'
            ], 404); // return data with status code 404
        }

        unset($data['user_id']); // remove user_id from data

        $data['name'] = $user->name; // add name to data
        $data['profileUrl'] = $user->profileUrl; // add profileUrl to data

        $topic = Topic::create($data); // create new data in topics table

        return response()->json([
            'status' => 201,
            'message' => 'data successfully sent',
            'topic' => $topic,
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
        $topic = Topic::find($id); // find data by id

        if (!$topic) { // if data not found
            return response()->json([
                'status' => 404,
                'message' => "topic with id " . $id . " not found",
                'topic' => 'null',
                'replies' => 'null'
            ], 404); // return data with status code 404
        }

        $replies = Topic::where('replyTo', $topic->id)->get(); // get all replies from topics table
        $replies->toArray(); // convert to array

        return response()->json([
            'status' => 200,
            'message' => 'data successfully retrieved',
            'topic' => $topic,
            'replies' => $replies
        ], 200); // return data with status code 200
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TopicUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TopicUpdateRequest $request, int $id)
    {
        $data = $request->validated(); // validate data from request

        $topic = Topic::find($id); // find data by id

        if (!$topic) { // if data not found
            return response()->json([
                'status' => 404,
                'message' => "topic with id " . $id . " not found",
                'topic' => 'null',
                'replies' => 'null'
            ], 404); // return data with status code 404
        }

        if ($topic->replyTo == 0) { // if data is not a reply
            return response()->json([
                'status' => 403,
                'message' => "You're not allowed to edit this topic"
            ]); // return data with status code 403
        }

        $topic->update($data); // update data in topics table

        return response()->json([
            'status' => 200,
            'message' => 'data successfully updated',
            'topic' => $topic
        ]); // return data with status code 200
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $topic = Topic::find($id); // find data by id

        if (!$topic) { // if data not found
            return response()->json([
                'status' => 404,
                'message' => "topic with id " . $id . " not found",
                'topic' => 'null',
                'replies' => 'null'
            ], 404); // return data with status code 404
        }

        $topic->delete(); // delete data from topics table

        return response()->json([
            'status' => 200,
            'message' => 'data successfully deleted',
            'topic' => 'null'
        ], 200); // return data with status code 200
    }
}
