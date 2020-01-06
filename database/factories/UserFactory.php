<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

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
        'backimg'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQzbkln18z1H_KbAxcTaP1QcXvTgmMk6gy9INt69vIRLkKrrJNM'
    ];
});

$factory->define(App\Topic::class, function (Faker $faker) {
    $name = $faker->word;

    return [
        'name' => $name,
        'created_by'=>'admin',
        'image'=>'https://secure.meetupstatic.com/photos/event/2/e/a/7/600_450131943.jpeg'
    ];
});

$factory->define(App\Event::class, function (Faker $faker) {
return [
      'name'=>$faker->sentence,
         'desc'=> 'Nunc magna metus, laoreet sed ex nec, consequat finibus risus. Aenean massa est, venenatis id dignissim id, maximus vitae sem.',
         'strtdt'=>'4 july 2000',
          'strttm'=>'19:45',
    'enddt'=>'4 july 2001',
          'endtm'=>'19:55',
    'price'=>45,
    'location'=>'lahore,Pakistan',
     'user_id'=>function () {
            return factory('App\User')->create()->id;
        },
    'venue'=>'Lahore',
    'topic_id'=>1,
    'qty'=>2,
    'image_path'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcTHZInbmRX8Mtrdptido88vfG9e8tmTPNcYMuYdOTPFjwRE0bAG'
    
    ];
});


$factory->define(App\Reply::class, function (Faker $faker) {
    return [
        'user_id'=>function () {
            return factory('App\User')->create()->id;
        },
        'event_id'=>function () {
            return factory('App\Event')->create()->id;
        },
        'body' => 'abra ka dabra',
    ];
});

$factory->define(App\DiscussionReply::class, function (Faker $faker) {
    return [
        'reply_id'=>function () {
            return factory('App\Reply')->create()->id;
        },
        'user_id'=>function () {
            return factory('App\User')->create()->id;
        },
        'replybody' => 'abra ka dabra',
    ];
});



$factory->define(App\PurchaseTicket::class, function (Faker $faker) {
    return [
        'user_id'=>function () {
            return factory('App\User')->create()->id;
        },
        'event_id'=>function () {
            return factory('App\Event')->create()->id;
        },
        'total' =>90,
        'qty'=>2
    ];
});
