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
            ['message' => 'Siaran A'],
            ['message' => 'Siaran B'],
            ['message' => 'Siaran C'],
            ['message' => 'Siaran D'],
            ['message' => 'Siaran E'],
            ['message' => 'Siaran F'],
            ['message' => 'Siaran G'],
            ['message' => 'Siaran H'],
            ['message' => 'Siaran I'],
            ['message' => 'Siaran J'],
        ];

        foreach ($broadcasts as $broadcast) {
            Broadcast::create($broadcast);
        }
    }
}
