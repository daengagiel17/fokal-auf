<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Models\Jurusan;
use App\Models\Rayon;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $super_admin = Role::create(['name' => 'super-admin']);
        $admin = Role::create(['name' => 'admin']);

        $user = Factory(User::class)->create([
            'name' => 'Muhammad Agiel Nugraha',
            'email' => 'agielnara17@gmail.com',
            'password' => bcrypt('fokal123'),
        ]);

        $user->assignRole($super_admin);
        $user->assignRole($admin);

        $jurusan = Jurusan::create([
            'nama' => 'Mesin'
        ]);
        $jurusan = Jurusan::create([
            'nama' => 'Sipil'
        ]);
        $jurusan = Jurusan::create([
            'nama' => 'Elektro'
        ]);
        $jurusan = Jurusan::create([
            'nama' => 'Industri'
        ]);
        $jurusan = Jurusan::create([
            'nama' => 'Informatika'
        ]);

        $rayon = Rayon::create([
            'nama' => 'Neo Sapiens'
        ]);
        $rayon = Rayon::create([
            'nama' => 'Clapeyrons'
        ]);
        $rayon = Rayon::create([
            'nama' => 'Curiosita'
        ]);
        $rayon = Rayon::create([
            'nama' => 'Cakrabyawara'
        ]);
        $rayon = Rayon::create([
            'nama' => 'Informatika'
        ]);
    }
}
