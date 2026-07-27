<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
        ]);

        $admin = User::firstOrCreate(
            ['email' => 'admin@samaasc.sn'],
            [
                'name' => 'Admin ASC',
                'password' => bcrypt('password'),
            ]
        );
        

        $admin->assignRole('admin_asc');

        $coach = User::firstOrCreate(
    ['email' => 'coach@samaasc.sn'],
    [
        'name' => 'Coach Test',
        'password' => bcrypt('password'),
    ]
);

$coach->assignRole('coach');
    }
}