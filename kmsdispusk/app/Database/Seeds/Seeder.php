<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder as DatabaseSeeder;

class Seeder extends DatabaseSeeder
{
    public function run()
    {
        // run category, rack, book & bookstock seeder
        $this->call('UserSeeder');
    }
}
