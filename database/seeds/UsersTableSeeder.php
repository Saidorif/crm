<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Muhammadamin',
            'email' => 'mirxan@mail.ru',
            'password' => Hash::make('secret'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
