<?php

namespace Database\Seeders;

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
        $roles = ['admin', 'petani', 'pemodal'];

        foreach($roles as $role){
            \App\Models\Role::factory()->create([
                'name' => $role
            ]);
        }
    }
}
