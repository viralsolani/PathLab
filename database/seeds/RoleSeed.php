<?php

use App\Models\Role;
use Illuminate\Database\Seeder;
use Carbon\Carbon as Carbon;

class RoleSeed extends Seeder
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
            DB::table('roles')->truncate();
        }

        $users = [
            [
                'title'              => 'Operator',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'title'              => 'Patient',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
        ];

        DB::table('roles')->insert($users);
    }
}
