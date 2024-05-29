<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as faker;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{

    public function run()
    {
        $faker = faker::create();
        $user = new User();
        $user->name          = "admin";
        $user->email         = "okadmin@gmail.com";
        $user->password      = Hash::make('12345678');
        $user->mobile        = "9871234562";
        $user->user_roles    = 'admin';
        $user->user_status   = 0;
        $user->address       = "Baner Pune";
        $user->save();

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->name          = $faker->name;
            $user->email         = $faker->email;
            $user->password      = Hash::make('12345678');
            $user->mobile        = $faker->numerify('##########');
            $user->user_roles    = 'user';
            $user->user_status   = 0;
            $user->address       = $faker->address;

            $user->save();
        }
    }
}
