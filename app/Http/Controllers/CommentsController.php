<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function index(Request $request) {
        $json = json_decode($request->getContent(), true);

        $comments = Comment::with('user')->where('post_id', $json['post_id'])->get();

        return response()->json(['comments' => $comments]);
    }

    public function store(Request $request) {
        $json = json_decode($request->getContent(), true);

        $comment = Comment::create([
            'text' => $json['text'],
            'post_id' => $json['post_id'],
            'user_id' => Auth::user()->id
        ]);

        return response()->json(['comment' => $comment, 'created'=>true]);
    }
}
