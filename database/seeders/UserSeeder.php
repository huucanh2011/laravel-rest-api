<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Carbon\Carbon;
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
        User::insert([
            [
                'id' => Str::uuid(),
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('123456'),
                'role' => RoleEnum::ADMINISTRATOR->value,
                'address' => 'VN',
                'phone_number' => '09091231234',
                'created_at' => Carbon::now(config('app.timezone')),
                'created_by' => 'admin@admin.com',
            ],
        ]);

        // DB::disableQueryLog();
        // User::withoutEvents(function () {
        //     DB::beginTransaction();
        //     $chunkSize = 10;
        //     for ($i = 0; $i < 100; $i += $chunkSize) {
        //         $data = [];
        //         for ($j = 0; $j < $chunkSize; $j++) {
        //             $data[] = [
        //                 'id' => Str::uuid(),
        //                 'name' => fake()->name(),
        //                 'email' => fake()->unique()->safeEmail(),
        //                 'password' => bcrypt('123456'),
        //                 'role' => RoleEnum::USER->value,
        //                 'address' => 'VN',
        //                 'phone_number' => fake()->phoneNumber(),
        //                 'created_at' => Carbon::now(config('app.timezone')),
        //                 'created_by' => 'admin@admin.com',
        //             ];
        //         }
        //         User::insert($data);
        //     }
        //     DB::commit();
        // });
    }
}
