<?php

use App\Channel;
use Illuminate\Database\Seeder;

class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Channel::create([
            'name' => 'politics',
            'slug' => 'politics'
        ]);

        Channel::create([
            'name' => 'gaming',
            'slug' => 'gaming'
        ]);

        Channel::create([
            'name' => 'books',
            'slug' => 'books'
        ]);

        Channel::create([
            'name' => 'bodybuilding',
            'slug' => 'bodybuilding'
        ]);

        Channel::create([
            'name' => 'history',
            'slug' => 'history'
        ]);

        Channel::create([
            'name' => 'news',
            'slug' => 'news'
        ]);

        Channel::create([
            'name' => 'comics',
            'slug' => 'comics'
        ]);

        Channel::create([
            'name' => 'rant',
            'slug' => 'rant'
        ]);

        Channel::create([
            'name' => 'science',
            'slug' => 'science'
        ]);

        Channel::create([
            'name' => 'soccer',
            'slug' => 'soccer'
        ]);

        Channel::create([
            'name' => 'sports',
            'slug' => 'sports'
        ]);

        Channel::create([
            'name' => 'space',
            'slug' => 'space'
        ]);

        Channel::create([
            'name' => 'technology',
            'slug' => 'technology'
        ]);

        Channel::create([
            'name' => 'music',
            'slug' => 'music'
        ]);

        Channel::create([
            'name' => 'art',
            'slug' => 'art'
        ]);
    }
}
