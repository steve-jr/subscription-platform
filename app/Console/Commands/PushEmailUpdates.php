<?php

namespace App\Console\Commands;

use App\Contract\PostServiceContract;
use App\Jobs\SendPostEmail;
use App\Models\Post;
use App\Models\Website;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class PushEmailUpdates extends Command
{
    protected $postService;

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
    public function __construct(PostServiceContract $postService)
    {
        parent::__construct();

        $this->postService = $postService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
//        $this->postService->sendNewPostNotifications(); //Demonstrate my understanding of using Dependency Injection.

        $websites = Website::all();

        foreach ($websites as $website) {
            // Retrieve unsent posts for the website
            $unsentPosts = $website->posts()->where('is_sent', false)->get();

            // Skip if there are no unsent posts
            if ($unsentPosts->isEmpty()) {
                continue;
            }

            // Fetch all subscribers for the current website
            $subscribers = $website->subscribers()->pluck('email');

            foreach ($unsentPosts as $post) {
                foreach ($subscribers as $email) {
                    // Dispatch the job to send emails in the background
                    $this->info($post);
                    SendPostEmail::dispatch($post, $email);
                }

                // Mark the post as sent
                $post->update(['is_sent' => true]);
            }

            $this->info("Email notifications for website '{$website->name}' have been queued.");
        }

        $this->info('All unsent post notifications have been queued for delivery.');
    }
}
