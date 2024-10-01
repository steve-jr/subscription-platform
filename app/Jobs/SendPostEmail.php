<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPostEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $post;
    protected $email;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Post $post, $email)
    {
        $this->post = $post;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::raw("Title: {$this->post->title}\nDescription: {$this->post->description}", function ($message) {
            $message->to($this->email)->subject('New Post Update');
        });
    }
}
