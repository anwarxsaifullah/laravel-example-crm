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
        $companies = Companies::pluck('id')->toArray();
        // var_dump($companies);
        for($i = 0; $i < 50; $i++){
            $company_id = $companies[array_rand($companies)];
            DB::table('employees')->insert([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'company_id' => $company_id,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber(),
            ]);
        }
    }
}
