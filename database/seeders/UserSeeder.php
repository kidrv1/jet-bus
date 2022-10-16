<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'first_name'    => 'Me',
            'last_name'     => 'Admin',
            'gender'        => 'male',
            'email'         => 'admin@yahoo.com',
            'password'      => bcrypt('admin123'),
            'mobile'        => '09650918852',
            'valid_id'      => 'admin',
            'vaccine_id'    => 'admin',
            'status_id'     => 2
        ]);

         $admin->assignRole('admin');

         

    }
}
