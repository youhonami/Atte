<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => '田中太郎',
            'email' => 'aaa@mail.co.jp',
            'password' => Hash::make('aaaaaaaaaa')
        ];
        DB::table('users')->insert($param);
    }
}
