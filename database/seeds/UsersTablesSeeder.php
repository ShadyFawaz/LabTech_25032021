<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\NewUserModel;


class UsersTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NewUserModel::create([
            'login_name'     => 'test',
            'user_name'      => 'testing',
            'password'       =>  Hash::make('password'),

        ]);
    }}
