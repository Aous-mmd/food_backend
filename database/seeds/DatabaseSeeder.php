<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        DB::table('users')->insert([
            'first_name' => 'Roula',
            'last_name' => 'AlRohban',
            'email' => 'roula.rohban@gmail.com',
            'name' => 'RORO',
            'phone' => '0933737297',
            'password' => Hash::make('123456789'),
        ]);

        DB::table('restaurants')->insert([
            'name' => 'My Restaurant',
            'phone' => '+963-997166694',
            'email' => 'restaurant@email.com',
            'street' => 'My Street',
            'build_number' => '10',
            'address' => 'Al-Malki Damascus Syria',
            'from_day' => 'Sunday',
            'to_day' => 'Thursday',
            'open_time' => '10:00:00',
            'close_time' => '22:00:00',
            'min_order' => '400',
            'owner' => 'Restaurant Owner',
            'android_url' => 'https://play.google.com/store/apps/details?id=com.touchtao.soccerkinggoogle',
            'iphone_url' => 'https://play.google.com/store/apps/details?id=com.touchtao.soccerkinggoogle',
        ]);
    }
}
