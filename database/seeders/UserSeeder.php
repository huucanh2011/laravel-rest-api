<?php

namespace Database\Seeders;

use App\Enums\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => Str::uuid(),
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('123456'),
                'role' => Role::ADMINISTRATOR->value,
                'address' => 'VN',
                'phone_number' => '09091231234',
                'created_at' => now(),
                'created_by' => 'admin@admin.com',
            ],
        ]);
    }
}
