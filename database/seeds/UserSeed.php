<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon as Carbon;

class UserSeed extends Seeder
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
            DB::table('users')->truncate();
        }

        $users = [
            [
                'name'              => 'Operator',
                'email'             => 'operator@operator.com',
                'password'          => bcrypt('password'),
                'role_id'           => 1,
                'remember_token'    => '',
                'phone'             => 9428315132,
                'dob'               => null,
                'photo'             => null,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'name'              => 'Patient1',
                'email'             => 'patient@gmail.com',
                'password'          => bcrypt('password'),
                'role_id'           => 2,
                'remember_token'    => '',
                'phone'             => 9016608346,
                'dob'               => null,
                'photo'             => null,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
        ];

        DB::table('users')->insert($users);
    }
}
