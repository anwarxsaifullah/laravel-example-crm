<?php

namespace Database\Seeders;

use App\Models\Companies;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class EmployeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('en_US');
        $companies = Companies::all('name');
        
        for($i = 0; $i < 50; $i++){
            $company = $companies[rand(0,count($companies)-1)];
            DB::table('employees')->insert([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'company' => $company->name,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber(),
            ]);
        }
    }
}
