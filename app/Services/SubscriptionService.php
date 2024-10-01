<?php

namespace App\Services;

class SubscriptionService implements SubscriptionServiceContract
{
    public function subscribeToWebsite(array $data)
    {
        $subscriber = Subscriber::firstOrCreate(['email' => $data['email']]);
        $website = Website::findOrFail($data['website_id']);

        if ($website->subscribers()->where('subscribers.id', $subscriber->id)->exists()) {
            return ['message' => 'User is already subscribed to this website.'];
        }

        // Attach the subscriber to the website
        $website->subscribers()->attach($subscriber);

        // Cache the subscribers list
        Cache::forget("website_{$website->id}_subscribers");
        $this->cacheWebsiteSubscribers($website);

        return ['message' => 'Subscription successful'];
    }

    protected function cacheWebsiteSubscribers(Website $website)
    {
        $subscribers = $website->subscribers()->pluck('email')->toArray();
        Cache::put("website_{$website->id}_subscribers", $subscribers, now()->addMinutes(30));
    }
}
