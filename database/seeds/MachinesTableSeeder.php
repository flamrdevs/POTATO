<?php

use Illuminate\Database\Seeder;

use App\Machine;

class MachinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $machines = [
            ['code' => 'mcodeA1', 'status' => 'used'],

            ['code' => 'mcodeA2', 'status' => 'used'],

            ['code' => 'mcodeA3', 'status' => 'used'],

            ['code' => 'mcodeA4', 'status' => 'used'],

            ['code' => 'mcodeA5', 'status' => 'ready'],

            ['code' => 'mcodeA6', 'status' => 'ready'],

            ['code' => 'mcodeA7', 'status' => 'ready'],

            ['code' => 'mcodeA8', 'status' => 'ready'],
        ];

        foreach ($machines as $machine) {
            Machine::create($machine);
        }
    }
}
