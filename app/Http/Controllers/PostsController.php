<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    public function store(Request $request) {
        if($request->hasFile('image')) {
            $json = json_decode($request->json, true);
            
            $urlname = Storage::disk('public')->put('posts', $request->file('image'));

            $post = Post::create([
                'title' => $json['title'],
                'thinks' => $json['thinks'],
                'image_url' => Storage::url($urlname)
            ]);

            for($i=0; $i<count($json['tags']); $i++) {
                $tag = Tag::where(['name' => $json['tags'][$i]])->first();

                if(!$tag) {
                    $tag = Tag::create([
                        'name' => $json['tags'][$i]
                    ]);
                }

                $post->tags()->save($tag);
            }

            return response()->json(['post' => $post, 'created' => true], 200);
        }
        
        return response()->json(['post' => null, 'created' => false], 200);
    }

    public function index(Request $request) {
        $json = json_decode($request->getContent(), true);

        $posts = [];
        if(count($json['tags'])) {
            $tags = $json['tags'];
            $posts = Post::whereHas('tags', function($q) use ($tags)
            {
                $q->whereIn('id', $tags);
            })->get();
        } else {
            $posts = Post::all();
        }

        return response()->json(['posts' => $posts], 200);
    }
}
