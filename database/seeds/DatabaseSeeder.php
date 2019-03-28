<?php

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
       $user = \App\User::create([
            'name' => 'Kiki',
            'email' => 'kristijan.jurcic@tempusmedia.hr',
            'email_verified_at' => now(),
            'password' => bcrypt('1q2w3e4r5t'),
            'remember_token' => str_random(10),
        ]);


       $site = new \App\Site([
           'name' => 'Nikas Staging',
           'store_url' => 'http://staging.tempus.media',
           'consumer_key' => encrypt('ck_fec70ccc608dffab43ac375587183f999d3a9122'),
           'consumer_secret' => encrypt('cs_6608e2a6f5451b168cd1c64ca4d781c338831427'),
       ]);


        $site2 = new \App\Site([
            'name' => 'Nikas Production',
            'store_url' => 'https://shop.nikas.hr',
            'consumer_key' => encrypt('ck_174d206a6a676220e512e7136016dd1ac91db93e'),
            'consumer_secret' => encrypt('cs_e2badc5d25370cdecb59aea407217ed9993e9897'),
        ]);

        $user->sites()->save($site);
        $user->sites()->save($site2);

    }
}
