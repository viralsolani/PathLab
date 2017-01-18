<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon as Carbon;

class TestSeed extends Seeder
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
            DB::table('tests')->truncate();
        }

        $items = [
            [
                'name'              => 'Vitamin A',
                'description'        => 'Vitamin Report',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'title'              => 'Vitamin D',
                'description'        => 'Vitamin Report',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
        ];

        DB::table('tests')->insert($items);
    }
}
