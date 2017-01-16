<?php

use Illuminate\Database\Seeder;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [

            ['id' => 1, 'title' => 'Operator',],
            ['id' => 2, 'title' => 'Patient',],

        ];

        foreach ($items as $item) {
            \App\Role::create($item);
        }
    }
}
