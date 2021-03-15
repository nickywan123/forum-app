<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Activity;
use App\Reply;
use App\Thread;
use App\User;
use App\Channel;

use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

// Create a factory for Thread table

$factory->define(Thread::class, function (Faker $faker){

    return [
        'user_id' => function(){
            return factory('App\User')->create()->id;
        },
        'channel_id' => function(){
            return factory('App\Channel')->create()->id;
        },
        'title' => $faker->sentence(),
        'body' => $faker->paragraph()

    ];

});

// Create a channel
$factory->define(Channel::class, function (Faker $faker){

    $name = $faker->word();
    return [
        'name' => $name,
        'slug' => $name
    ];

});


// Create a factory for Replies table

$factory->define(Reply::class, function (Faker $faker){

    return [
        'thread_id' => function(){
            return factory('App\Thread')->create()->id;
        },
        'user_id' => function(){
            return factory('App\User')->create()->id;
        },
        'body' => $faker->paragraph()

    ];

});

//Factory for Activities table

$factory->define(Activity::class, function (Faker $faker){

    return [
        'user_id' => function(){
            return factory('App\User')->create()->id;
        },
        'type' => $faker->word(),
        'subject_id' => function(){
            return factory('App\User')->create()->id;
        },
        'subject_type'=>$faker->word()

    ];

});

$factory->define(IlluminateNotificationsDatabaseNotification::class, function ($faker) {
    return [
        'id' => RamseyUuidUuid::uuid4()->toString(),
        'type' => 'AppNotificationsThreadWasUpdated',
        'notifiable_id' => function () {
            return auth()->id() ?: factory('AppUser')->create()->id;
        },
        'notifiable_type' => 'AppUser',
        'data' => ['foo' => 'bar']
    ];
});