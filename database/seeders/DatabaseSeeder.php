<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enum\UserRuleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // $user = new User();

        // $user->first_name = "Admin";
        // $user->last_name = "Super";
        // $user->email = "superadmin@khgc.com";
        // $user->password = Hash::make("Abcd@1234");
        // $user->role = UserRuleEnum::ADMIN;

        // $user->save();

        $this->call(PostSeeder::class);
    }
}