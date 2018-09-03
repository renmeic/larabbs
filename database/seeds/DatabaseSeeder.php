<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            TopicsTableSeeder::class,
            ReplysTableSeeder::class,
            LinksTableSeeder::class,
        ]);
    }
}
