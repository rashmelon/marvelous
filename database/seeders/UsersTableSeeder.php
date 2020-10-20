<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Mahmoud Mokhtar',
            'email' => 'mahmoud@birdsol.com',
            'password' => bcrypt('password'),
            'email_verified_at' => Carbon::now(),
        ]);
    }
}
