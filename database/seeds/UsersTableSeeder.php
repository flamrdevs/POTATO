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
        $users = [
            [
                'name' => 'AdminSeed',
                'email' => 'AdminSeed@gmail.com',
                'password' => Hash::make('AdminSeed'),
                'role' => 'admin'
            ],
            [
                'name' => 'FarmerSeed',
                'email' => 'FarmerSeed@gmail.com',
                'password' => Hash::make('FarmerSeed'),
                'role' => 'farmer'
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        factory(User::class, 20)->create();
    }
}
