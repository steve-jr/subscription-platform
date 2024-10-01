<?php

namespace App\Services;

use App\Contract\PostServiceContract;
use App\Models\Post;
use App\Models\Website;
use Illuminate\Support\Facades\Mail;

class PostService implements PostServiceContract
{

    public function createPostForWebsite(array $data)
    {
        $website = Website::findOrFail($data['website_id']);
        return $website->posts()->create($data);
    }

    public function sendNewPostNotifications()
    {
        $unsentPosts = Post::where('is_sent', false)->get();

        foreach ($unsentPosts as $post) {
            $website = $post->website;
            $subscribers = $website->subscribers;

            foreach ($subscribers as $subscriber) {
                Mail::raw("Title: {$post->title}\nDescription: {$post->description}", function ($message) use ($subscriber) {
                    $message->to($subscriber->email)->subject('New Post Update');
                });

                // Update the post as sent for the subscriber
                $post->subscribers()->syncWithoutDetaching([$subscriber->id]);
            }

            $post->update(['is_sent' => true]);
        }
    }
}
