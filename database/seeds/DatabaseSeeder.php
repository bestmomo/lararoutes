<?php

use Illuminate\Database\Seeder;
use App\User;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@somewhere.fr',
            'password' => bcrypt('secret'),
            'admin' => true,
            'email_verified_at' => Carbon::now()
        ]);

    }
}
