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
            'mobile'        => '09650918852'
        ]);

         $admin->assignRole('admin');

         $staff = User::create([
            'first_name'    => 'Me',
            'last_name'     => 'Staff',
            'gender'        => 'female',
            'email'         => 'staff@yahoo.com',
            'password'      => bcrypt('staff123'),
            'mobile'        => '09650918852'
        ]);

         $staff->assignRole('staff');



    }
}
