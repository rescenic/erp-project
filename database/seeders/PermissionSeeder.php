<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'kategori.index']);
        Permission::create(['name' => 'kategori.tambah']);
        Permission::create(['name' => 'kategori.edit']);
        Permission::create(['name' => 'kategori.hapus']);
    }
}
