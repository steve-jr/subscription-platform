<?php

namespace App\Http\Controllers;

use App\Contract\SubscriptionServiceContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriberController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionServiceContract $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'website_id' => 'required|exists:websites,id'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $response = $this->subscriptionService->subscribeToWebsite($request->all());

        return response()->json([
            'status' => 'sucess',
            'errors' => $response,
        ], 201);
    }
}
