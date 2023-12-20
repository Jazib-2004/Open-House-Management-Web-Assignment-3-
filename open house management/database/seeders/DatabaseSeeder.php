<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $formFields=
            [
                'name'=>'Raja Fawad',
                'email'=>'rajafawady@gmail.com',
                'role'=>'admin',
                'password'=>'fawadhihun',
            ];
            // Hash Password
        $formFields['password'] = bcrypt($formFields['password']);
        // Create User
         User::create($formFields);
        $this->call([
            ProjectSeeder::class,
            // Add other seeders as needed
        ]);
    }
}
