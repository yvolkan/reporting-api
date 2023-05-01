<?php

namespace Database\Seeders;

use App\Models\Client;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Generator::class);

        for ($i = 0; $i < 100; $i++) {
            $gender = $faker->randomElement(['male', 'female']);
            $client = Client::create([
                'email' => $faker->email(),
                'birthday' => $faker->date(),
                'gender' => $gender,
            ]);

            $creditCardNo = $faker->creditCardNumber();
            $creditCardNoWithMask = substr_replace($creditCardNo, str_repeat("X", 6), 6, 6);

            $expirationDate = $faker->creditCardExpirationDateString();
            list($expiryMonth, $expiryYear) = explode('/', $expirationDate);

            $client->card()->create([
                'client_id' => $client->id,
                'number' => $creditCardNoWithMask,
                'expiryMonth' => $expiryMonth,
                'expiryYear' => $expiryYear,
            ]);

            $client->address()->create([
                'type' => 'billing',
                'client_id' => $client->id,
                'title' => $faker->word, 
                'first_name' => $faker->firstName($gender), 
                'last_name' => $faker->lastName($gender), 
                'company' => $faker->company, 
                'address1' => $faker->address, 
                'address2' => $faker->secondaryAddress, 
                'city' => $faker->city, 
                'post_code' => $faker->postcode, 
                'state' => $faker->state, 
                'country' => $faker->country, 
                'phone' => $faker->phoneNumber, 
                'fax' => $faker->phoneNumber, 
            ]);

            $client->address()->create([
                'type' => 'shipping',
                'client_id' => $client->id,
                'title' => $faker->word, 
                'first_name' => $faker->firstName($gender), 
                'last_name' => $faker->lastName($gender), 
                'company' => $faker->company, 
                'address1' => $faker->address, 
                'address2' => $faker->secondaryAddress, 
                'city' => $faker->city, 
                'post_code' => $faker->postcode, 
                'state' => $faker->state, 
                'country' => $faker->country, 
                'phone' => $faker->phoneNumber, 
                'fax' => $faker->phoneNumber, 
            ]);
        }
    }
}
