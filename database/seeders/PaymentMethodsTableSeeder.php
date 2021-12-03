<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Order\PaymentMethod;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('payment_methods')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $datas = [
            [
				'name' => 'Credit/Debit Card',
                'service_fee' => 3590,
                'type' => 'card'
            ],
			[
                'name' => 'BRI Credit/Debit Card',
                'service_fee' => 3133,
                'type' => 'card'
            ],
			[
                'name' => 'BNI Virtual Account',
                'service_fee' => 5000,
                'type' => 'virtual'
            ],
			[
                'name' => 'BCA Virtual Account',
                'service_fee' => 5000,
                'type' => 'virtual'
            ],
			[
                'name' => 'OVO',
                'service_fee' => 3000,
                'type' => 'emoney'
            ],
			[
                'name' => 'GOPAY',
                'service_fee' => 2000,
                'type' => 'emoney'
            ]
        ];

        foreach ($datas as $q) {
            $data = PaymentMethod::create([
                'name' => $q['name'],
				'service_fee' => $q['service_fee'],
				'type' => $q['type']
            ]);
        }
    }
}
