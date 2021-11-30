<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Event\EventSession;

class EventSessionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('event_sessions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $datas = [
            [
                'event_id' => 1,
				'start' => '2021-11-29 10:15:00',
                'end' => '2021-11-30 16:15:00',
			],
			[
                'event_id' => 1,
				'start' => '2021-12-01 10:15:00',
                'end' => '2021-12-02 15:15:00',
            ],
			[
                'event_id' => 2,
				'start' => '2021-12-10 12:15:00',
                'end' => '2021-12-15 18:15:00',
			]
        ];

        foreach ($datas as $q) {
            $data = EventSession::create([
                'event_id' => $q['event_id'],
				'start' => $q['start'],
				'end' => $q['end']
            ]);
        }
    }
}
