<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Event\Ticket;

class TicketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('tickets')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $datas = [
            [
                'event_id' => 1,
                'name' => 'Saintek A : 4-5 desember 2021 (2 days)',
				'event_session_ids' => '[1, 2]',
				'selling_period' => '["2021-11-29 10:15:00", "2021-12-29 15:15:00"]',
				'price' => 33000,
				'qty' => 100,
				'max_per_person' => 10,
				'package_details' => 'Terms and Conditions. Syarat dan Ketentuan.',
				'group' => 'SAINTEK',
			],
			[
                'event_id' => 1,
                'name' => 'Saintek B : 4-5 desember 2021 (2 days)',
				'event_session_ids' => '[1, 2]',
				'selling_period' => '["2021-11-29 10:15:00", "2021-12-29 15:15:00"]',
				'price' => 33000,
				'qty' => 100,
				'max_per_person' => 10,
				'package_details' => 'Terms and Conditions. Syarat dan Ketentuan.',
				'group' => 'SAINTEK',
			],
			[
                'event_id' => 2,
                'name' => '[ONLINE] Amba Sesi 1 Presale 3',
				'event_session_ids' => '[3]',
				'selling_period' => '["2021-11-29 10:15:00", "2021-12-29 15:15:00"]',
				'price' => 75000,
				'qty' => 150,
				'max_per_person' => 10,
				'package_details' => 'Terms and Conditions. Syarat dan Ketentuan.',
				'group' => '2021-12-20',
			],
			[
                'event_id' => 2,
                'name' => '[ONLINE] Amba Sesi 2 Presale 3',
				'event_session_ids' => '[3]',
				'selling_period' => '["2021-11-29 10:15:00", "2021-12-29 15:15:00"]',
				'price' => 75000,
				'qty' => 150,
				'max_per_person' => 10,
				'package_details' => 'Terms and Conditions. Syarat dan Ketentuan.',
				'group' => '2021-12-20',
			],
			[
                'event_id' => 2,
                'name' => '[ONSITE] Bhisma (Reguler) Sesi 1 Presale 3',
				'event_session_ids' => '[3]',
				'selling_period' => '["2021-11-29 10:15:00", "2021-12-29 15:15:00"]',
				'price' => 80000,
				'qty' => 50,
				'max_per_person' => 2,
				'package_details' => 'Terms and Conditions. Syarat dan Ketentuan.',
				'group' => '2021-12-20',
			],
        ];

        foreach ($datas as $q) {
            $data = Ticket::create([
                'event_id' => $q['event_id'],
				'name' => $q['name'],
				'event_session_ids' => $q['event_session_ids'],
				'selling_period' => $q['selling_period'],
				'price' => $q['price'],
				'qty' => $q['qty'],
				'max_per_person' => $q['max_per_person'],
				'package_details' => $q['package_details'],
				'group' => $q['group']
            ]);
        }
    }
}
