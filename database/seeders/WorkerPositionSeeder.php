<?php

namespace Database\Seeders;

use App\Models\WorkerPosition;
use Illuminate\Database\Seeder;

class WorkerPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        WorkerPosition::truncate();

        $positions = [
            [
                'parent_id' => null,
                'position_name' => 'General Direktor'
            ],
            [
                'parent_id' => null,
                'position_name' => 'Head Of Technical Department'
            ],
            [
                'parent_id' => 2,
                'position_name' => 'Developer'
            ],
            [
                'parent_id' => null,
                'position_name' => 'Head Of Finance Department'
            ],
            [
                'parent_id' => 4,
                'position_name' => 'Accountant'
            ],
            [
                'parent_id' => null,
                'position_name' => 'Head Of Marketing Department'
            ],
            [
                'parent_id' => 6,
                'position_name' => 'Marketing Manager'
            ],
            [
                'parent_id' => null,
                'position_name' => 'Head Of Warehouse Department'
            ],
            [
                'parent_id' => 8,
                'position_name' => 'Warehouseman'
            ],
            [
                'parent_id' => 8,
                'position_name' => 'Courier'
            ],
        ];

        WorkerPosition::insert($positions);
    }
}
