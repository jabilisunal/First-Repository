<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::truncate();

        $users = [
            [
                'name' => 'Administrator',
                'surname' => '',
                'email' => 'admin@example.com',
                'password' => bcrypt('123456'),
                'email_verified_at' => now(),
                'position_id' => 1,
                'office_id' => 1,
                'remember_token' => Str::random(10)
            ]
        ];

        foreach ($users as $user) {

            $newUser = User::create($user);

            Role::findByName('administrator', 'admin')
                ->users()->sync([$newUser->id]);
        }
    }
}
