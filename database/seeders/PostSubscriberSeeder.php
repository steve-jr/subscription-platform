<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Subscriber;
use App\Models\Website;
use Illuminate\Database\Seeder;

class PostSubscriberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subscribers = Subscriber::all();

        // Attach random subscribers to each website
        Website::all()->each(function ($website) use ($subscribers) {
            $randomSubscribers = $subscribers->random(rand(2, 5))->pluck('id');
            $website->subscribers()->attach($randomSubscribers);
        });
    }
}
