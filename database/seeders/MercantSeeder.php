<?php

namespace Database\Seeders;

use App\Models\Merchant;
use Faker\Generator;
use Illuminate\Database\Seeder;

class MercantSeeder extends Seeder
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
            Merchant::create([
                'name' => $faker->word
            ]);
        }
    }
}
