<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = Permission::all();

        // Super Admin with Permission
        User::updateOrCreate(['email'=>'super@gmail.com'],[
            'name'     => 'Sujon Mia',
            'email'    => 'super@gmail.com',
            'password' => Hash::make('12345678'),
            'mobile_no'=>'01743776488',
            'gender'   => 1,
            'created_by'=> 'Sujon Mia'
        ])->permissions()
            ->sync($permissions->pluck('id'));

        // Admin User
        User::updateOrCreate(['email'=>'admin@gmail.com'],[
            'name'     => 'Admin',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'mobile_no'=>'01602603147',
            'gender'   => 1,
            'created_by'=> 'Sujon Mia'
        ])->permissions()
            ->sync($permissions->pluck('id'));
    }
}
