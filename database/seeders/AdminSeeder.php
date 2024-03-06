<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'username' => 'admin',
            'phone' => '01270122393',
            'password' => bcrypt('123456'),
            'email' => 'admin@gmail.com',
            'show_all'=>1

        ];
        $admin = Admin::where('username', $data['username'])->first();
        if (!$admin) {
            Admin::create($data);
        }else{
            $admin->update($data);
        }
    }
}
