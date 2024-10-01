<?php

namespace App\Services;

use App\Contract\SubscriptionServiceContract;
use App\Models\Subscriber;
use App\Models\Website;

class SubscriptionService implements SubscriptionServiceContract
{
    public function subscribeToWebsite(array $data)
    {
        $subscriber = Subscriber::firstOrCreate(['email' => $data['email']]);
        $website = Website::findOrFail($data['website_id']);

        if ($website->subscribers()->where('subscribers.id', $subscriber->id)->exists()) {
            return ['message' => 'User is already subscribed to this website.'];
        }

        $website->subscribers()->attach($subscriber);

        return ['message' => 'Subscription successful'];
    }
}
