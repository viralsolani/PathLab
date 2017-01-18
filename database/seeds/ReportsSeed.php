<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon as Carbon;

class ReportsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::connection()->getDriverName() == 'mysql')
        {
            DB::table('reports')->truncate();
        }

        $items = [
            [
                'user_id'           => 2,
                'name'              => 'Vitmain Profile',
                'details'           => 'Selected Vitamin Report',
                'date'              => Carbon::now(),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'user_id'           => 2,
                'name'              => 'Himoglobin Report',
                'details'           => 'Himoglobin Report',
                'date'              => Carbon::now(),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
        ];

        DB::table('reports')->insert($items);
    }
}
