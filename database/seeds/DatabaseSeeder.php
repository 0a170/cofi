<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Art;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // factory(User::class, 50)->create();
        factory(\App\Models\Art::class, 20)->create();
        //$faker::create()->image('public/', 400, 300, null, false); 
        //$faker = Faker\Factory::create();

        // factory(User::class, 50)->create()->each(function ($u) {
        //     $art = $u->artwork()->save(factory(\App\Models\Art::class)->make([
        //         'owner_id' => $u->uuid
        //     ]));

        //     $faker->image('public_path' . '/' . $u->name . '/art' . '/' . $title);
        // });
    }
}
