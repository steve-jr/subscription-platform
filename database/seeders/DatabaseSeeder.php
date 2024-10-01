<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            WebsiteSeeder::class,
            SubscriberSeeder::class,
            PostSeeder::class,
            PostSubscriberSeeder::class,
        ]);
    }
}
