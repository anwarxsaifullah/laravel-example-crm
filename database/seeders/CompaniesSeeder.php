<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('en_US');
        for($i = 0; $i < 50; $i++){
            // $logoName = time().'.jpg';
            $publicPath = public_path('images');
            // var_dump($publicPath);
            $logoName = $faker->image($publicPath, 100, 100, 'cats');
            $path = explode('\\', $logoName);
            $logoName = $path[count($path)-1];
            // $newName = $publicPath.'\\'.$logoName;
            // $newName = $logoName;
            // Storage::move($tmp, $newName);
            DB::table('companies')->insert([
                'name' => $faker->company,
                'email' => $faker->email,
                'website' => $faker->domainName,
                'logo' => $logoName,
            ]);

        }
    }
}
