<?php

namespace Database\Seeders;

use App\Models\AdminUser;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        
        // Insert data using the AdminUser model
        AdminUser::create([
            'name' => 'admin',
            'username' => 'admin',
            'password' => Hash::make('123456'), // Hash the password
            'remember_token' => null, // You can add a token if needed
            'created_at' => now(),
            'updated_at' => now(),
            
        ]);
        $this->call(ProductImageSeeder::class);

    }
}
