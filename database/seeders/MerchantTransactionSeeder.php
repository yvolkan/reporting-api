<?php

namespace Database\Seeders;

use App\Models\Acquire;
use App\Models\Client;
use App\Models\Merchant;
use App\Models\MerchantTransaction;
use App\Models\Transaction;
use Faker\Generator;
use Illuminate\Database\Seeder;

class MerchantTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Generator::class);

        for ($i=0; $i < 1000; $i++) {
            $client = Client::all()->random();

            $transactionId = $faker->numerify('#-##########-#');

            $client_card = $client->card->random();
            $client_billing = $client->address->where('type', 'billing')->random();
            $client_shipping = $client->address->where('type', 'shipping')->random();

            $merchant = Merchant::all()->random();
            $acquirer = Acquire::all()->random();

            $referenceNo = $faker->bothify('reference_##########');
            $status = $faker->randomElement(['APPROVED', 'WAITING', 'DECLINED', 'ERROR']);
            $operation = $faker->randomElement(['DIRECT', 'REFUND', '3D', '3DAUTH', 'STORED']);

            $errorCode = null;
            if (in_array($status, ['DECLINED', 'ERROR'])) {
                $errorCode = $faker->randomElement(['Do not honor', 'Invalid Transaction', 'Invalid Card', 'Not sufficient funds', 'Incorrect PIN',
                    'Invalid country association', 'Currency not allowed', '3-D Secure Transport Error', 'Transaction not
                    permitted to cardholder']);
            }

            $channel = $faker->randomElement(['API', 'WEB']);

            $merchantTransaction = MerchantTransaction::create([
                'transaction_id' => $transactionId, 
                'merchant_id' => $merchant->id ?? null,
                'referenceNo' => $referenceNo, 
                'status' => $status,
                'operation' => $operation, 
                'errorCode' => $errorCode,
                'channel' => $channel, 
                'customData' => null,
                'chain_id' => $faker->randomNumber(), 
                'agent_info_id' => $faker->randomNumber(), 
                'fx_transaction_id' => $faker->randomNumber(),
                'code' => $faker->randomNumber(2), 
                'message' => $status, 
                'agent' => [
                    'id' => $faker->randomNumber,
                    'customerIp' => $faker->ipv4,
                    'customerUserAgent' => $faker->userAgent,
                    'merchantIp' => $faker->localIpv4,
                ]
            ]);

            $created_at = $faker->date('2023-04-d') . ' ' . $faker->time('H:i:s');
            $updated_at = $faker->date('2023-04-d') . ' ' . $faker->time('H:i:s');

            Transaction::create([
                'transaction_id' => $transactionId,
                'client_id' => $client->id,
                'client_card_id' => $client_card->id ?? null,
                'client_billing_address_id' => $client_billing->id ?? null,
                'client_shipping_address_id' => $client_shipping->id ?? null,
                'merchant_id' => $merchant->id ?? null, 
                'acquirer_id' => $acquirer->id ?? null, 
                'merchant_transaction_id' => $merchantTransaction->id ?? null, 
                'originalAmount' => $faker->randomNumber(2), 
                'originalCurreny' => $faker->randomElement(['TRY', 'USD', 'EUR', 'GBP']),
                'ipn' => ['received' => $faker->boolean],
                'refundable' => $faker->boolean,
                'created_at' => $created_at,
                'updated_at' => $faker->boolean ? $updated_at : null,
            ]);
        }
    }
}
