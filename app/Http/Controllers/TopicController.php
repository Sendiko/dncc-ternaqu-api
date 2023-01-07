<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = DB::select('select * from topics where replyTo = 0');
        if($topics){
            return response()->json([
                'status' => 200,
                'message' => 'data successfully retrieved',
                'topics' => $topics
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'there is no topic',
                'topics' => 'null'
            ], 404);
        }
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
            'user_id' => 'required|integer',
            'title' => 'string|max:255',
            'question' => 'required|string',
            'replyTo' => 'integer'
        ]);

        $user = User::find($data['user_id']);

        if($user){
            $topic = Topic::create([
                'name' => $user->name,
                'title' => $data['title'],
                'question' => $data['question'],
                'replyTo' => $data['replyTo'],
                'profileUrl' => $user->profileUrl
            ]);
            return response()->json([
                'status' => 201,
                'message' => 'data successfully sent',
                'topic' => $topic,
            ], 201);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "user with id $user->id not found",
                'topic' => 'null'
            ], 404);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $topic = Topic::find($id);
        if($topic){
            $replyTo = $topic->id;
            $replies = DB::select("select * from topics where replyTo = $replyTo");
            return response()->json([
                'status' => 200,
                'message' => 'data successfully retrieved',
                'topic' => $topic,
                'replies' => $replies
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "topic with id $id not found",
                'topic' => 'null',
                'replies' => 'null'
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
        $topic = Topic::find($id);
        if($topic){
            if($topic->replyTo == 0){
                return response()->json([
                    'status' => 403,
                    'message' => "You're not allowed to edit this topic"
                ]);
            } else {
                $topic->update([
                    'title' => $request->title ? $request->title : $topic->title,
                    'question' => $request->question ? $request->question : $topic->question,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'data successfully updated',
                    'topic' => $topic
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => "topic with id $id not found",
                'topic' => 'null',
                'replies' => 'null'
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
        $topic = Topic::find($id);
        if($topic){
            $topic->delete();

            return response()->json([
                'status' => 200,
                'message' => 'data successfully deleted',
                'topic' => 'null'
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "topic with id $id not found",
                'topic' => 'null',
                'replies' => 'null'
            ], 404);     
        }
    }
}
