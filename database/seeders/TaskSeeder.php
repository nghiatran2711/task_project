<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //get user from table users
        $users = DB::table('users')->get();
        if (!empty($users)) {
            $date = date('Y-m-d H:i:s');
            foreach ($users as $user) {
                $dataInsert = [
                    'content' => Str::random(300),
                    'user_id' => $user->id,
                    'created_at' => $date,
                    'updated_at' => $date,
                ];
                DB::table('tasks')->insert($dataInsert);
            }
        }
    }
}
