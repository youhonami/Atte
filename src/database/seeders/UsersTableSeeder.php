<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'password' => 'American'
        ];
        DB::table('users')->insert($param);
    }
}
