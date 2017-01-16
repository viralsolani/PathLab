<?php

use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'name' => 'Admin', 'email' => 'admin@admin.com', 'password' => '$2y$10$I9lLucuOlIwHgrTlDCI5OO4ujkK5CqQ3qAl4RXbyAep.q3bp5FcQO', 'role_id' => 1, 'remember_token' => '', 'phone' => null, 'dob' => '', 'photo' => null,],

        ];

        foreach ($items as $item) {
            \App\User::create($item);
        }
    }
}
