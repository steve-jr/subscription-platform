<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create(Request $request)
    {
        $validated_post = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'website_id' => 'required|exists:websites,id'
        ]);

        $post = Post::create($validated_post);

        return response()->json($post, 201);
    }
}
