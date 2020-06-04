<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class User extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 10; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->email,
                'image' => 'default.png',
                'password' => Hash::make($faker->password),
                'remember_token' => '',
                'role_id' => 2,
                'is_active' => 1,
                'date_created' => time(),
                'email_verified_at' => null
            ]);
        }
    }
}
