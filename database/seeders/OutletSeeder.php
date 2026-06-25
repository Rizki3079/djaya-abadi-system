<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Outlet;

class OutletSeeder extends Seeder
{
    public function run(): void
    {
        Outlet::firstOrCreate(
            ['code' => 'OUT-001'],
            [
                'name' => 'Outlet Pusat',
                'status' => 'active',
            ]
        );
    }
}