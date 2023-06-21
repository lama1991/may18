<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(['role_name'=>'admin']);
        DB::table('categories')->insert([
            [
                'category_name'=>'car',
                'desc'=>'car description'
            ],
            [
                'category_name'=>'truck',
                'desc'=>'truck description'
            ],
            [
                'category_name'=>'phone',
                'desc'=>'phone description'
            ]
        ]); 
    }
}
