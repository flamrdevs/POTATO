<?php

use Illuminate\Database\Seeder;

use App\Broadcast;

class BroadcastsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $broadcasts = [
            ['message' => 'Broadcast A'],
            ['message' => 'Broadcast B'],
            ['message' => 'Broadcast C'],
            ['message' => 'Broadcast D'],
            ['message' => 'Broadcast E'],
            ['message' => 'Broadcast F'],
        ];

        foreach ($broadcasts as $broadcast) {
            Broadcast::create($broadcast);
        }
    }
}
