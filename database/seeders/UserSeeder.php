<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->create([
            'name' => 'Admin',
            'password' => bcrypt('admin'),
            'email' => 'godsness980@gmail.com',
            'role_id' => 1
        ]);
    }
}
