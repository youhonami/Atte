<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => '1',
            'start_time' => '9:00:00',
            'end_time' => '18:00:00',
            'break_start_time' => '12:00:00',
            'break_end_time' => '13:00:00',
            'break_duration' => '1:00:00',
            'work_time' => '8:00:00',
        ];
        DB::table('attendances')->insert($param);
    }
}
