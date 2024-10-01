<?php

namespace App\Http\Controllers;

use App\Contract\PostServiceContract;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostServiceContract $postService)
    {
        $this->postService = $postService;
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'website_id' => 'required|exists:websites,id'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $post = $this->postService->createPostForWebsite($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $post,
        ], 201);
    }
}
