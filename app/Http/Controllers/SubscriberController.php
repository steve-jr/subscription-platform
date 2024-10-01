<?php

namespace App\Http\Controllers;

use App\Contract\SubscriptionServiceContract;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionServiceContract $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function subscribe(Request $request)
    {
        $validated_subscriber = $request->validate([
            'email' => 'required|email',
            'website_id' => 'required|exists:websites,id'
        ]);

        $response = $this->subscriptionService->subscribeToWebsite($validated_subscriber);

        return response()->json($response, 201);
    }
}
