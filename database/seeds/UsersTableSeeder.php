<?php

use Illuminate\Database\Seeder;

use App\User;

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
            'name' => 'AdminSeed',
            'email' => 'AdminSeed@gmail.com',
            'password' => Hash::make('AdminSeed'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'FarmerSeed',
            'email' => 'FarmerSeed@gmail.com',
            'password' => Hash::make('FarmerSeed'),
            'role' => 'farmer'
        ]);

        factory(User::class, 20)->create();
    }
}
