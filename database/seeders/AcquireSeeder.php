<?php

namespace Database\Seeders;

use App\Models\Acquire;
use Faker\Generator;
use Illuminate\Database\Seeder;

class AcquireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Generator::class);

        for ($i=0; $i < 10; $i++) {
            $name = $faker->company;

            $acquire = new Acquire;
            $acquire->name = $name;
            $acquire->code = strtoupper(substr($name, 0, 2));
            $acquire->type = 'CREDITCARD';
            $acquire->save();
        }
    }
}
