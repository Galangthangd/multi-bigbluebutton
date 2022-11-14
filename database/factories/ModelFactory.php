<?php

/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Brackets\AdminAuth\Models\AdminUser::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => bcrypt($faker->password),
        'remember_token' => null,
        'activated' => true,
        'forbidden' => $faker->boolean(),
        'language' => 'en',
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
    ];
});/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Server::class, static function (Faker\Generator $faker) {
    return [
        'base_url' => $faker->sentence,
        'sec_secret' => $faker->sentence,
        'weight' => $faker->randomNumber(5),
        'enabled' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\ServerMeeting::class, static function (Faker\Generator $faker) {
    return [
        'server_id' => $faker->sentence,
        'meeting_id' => $faker->sentence,
        'meeting_name' => $faker->sentence,
        'status' => $faker->sentence,
        'start_time' => $faker->dateTime,
        
        
    ];
});
