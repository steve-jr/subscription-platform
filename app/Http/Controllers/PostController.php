<?php

namespace App\Http\Controllers;

use App\Contract\PostServiceContract;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostServiceContract $postService)
    {
        $this->postService = $postService;
    }

    public function create(Request $request)
    {
        $validated_post = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'website_id' => 'required|exists:websites,id'
        ]);

        $post = $this->postService->createPostForWebsite($validated_post);

        return response()->json($post, 201);
    }
}
