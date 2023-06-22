<?php

namespace Database\Seeders\Tests;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestBookStoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('book_stores')->insert([
            'id' => 1,
            'name' => 'Book test',
            'isbn' => 9783161484100,
            'value' => 16.99
        ]);
    }
}
