<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::query()->create([
            'name' => 'admin'
        ]);

        Role::query()->create([
            'name' => 'user'
        ]);

        Role::query()->create([
            'name' => 'librarian'
        ]);
    }
}
