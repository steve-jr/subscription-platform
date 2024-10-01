<?php

namespace App\Console\Commands;

use App\Jobs\SendPostEmail;
use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class PushEmailUpdates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push:email-updates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pushes email updates to subscribers for new posts.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $posts = Post::where('is_sent', false)->get();

        foreach ($posts as $post) {
            $website = $post->website;
            $subscribers = $website->subscribers;

            foreach ($subscribers as $subscriber) {
                Mail::raw("Title: {$post->title}\nDescription: {$post->description}", function ($message) use ($subscriber) {
                    $message->to($subscriber->email)->subject('New Post Update');
                });

                $post->subscribers()->attach($subscriber);
            }

            $post->update(['is_sent' => true]);
        }

        $this->info('Emails sent successfully!');
    }
}
