<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Event\Event;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('events')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $datas = [
            [
                'type' => 'webinar',
				'organization_id' => 1,
                'name' => 'Bedah Kampus Universitas Indonesia - BKUI 21',
				'place' => 'INDONESIA',
				'location' => 'Online',
				'location_details' => '',
				'maps' => '',
				'description' => 'Indonesia adalah kegiatan eksplorasi kampus yang memberi informasi mengenai fakultas, jurusan, dan segala fasilitas yang ada di Universitas Indonesia. Dengan mengikuti BKUI, peserta akan mendapatkan gambaran mengenai kehidupan perkuliahan di Universitas Indonesia. Dengan mendatangkan alumni- alumni universitas indonesai dari berbagai jurusan untuk sharing pengalaman dan dinamika perkuliahan sehingga menjadi cerita yang sangat inspiratif. Jelajahi juga Universitas Indonesia secara daring namun tetap interaktif dengan virtual tour 360!',
				'interests' => '["WEBINAR", "SEMINAR", "UNIVERSITY STUDENT", "TALKSHOW", "EDUCATION EXPO", "EDUCATION"]',
				'group' => 'events'
			],
			[
                'type' => 'art',
				'organization_id' => 2,
                'name' => 'Wajah Nusantara 2021',
				'place' => 'BANDUNG',
				'location' => 'Universitas Katolik Parahyangan',
				'location_details' => 'Auditorium Pusat Pembelajaran Arntz-Geise UNPAR',
				'maps' => 'https://www.google.com/maps/search/?api=1&query=-6.874735,107.6049079',
				'description' => 'Wajah Nusantara (WANUS) merupakan salah satu program unggulan Unit Kegiatan Mahasiswa Lingkung Seni Tradisional Universitas Katolik Parahyangan (LISTRA UNPAR). WANUS dilaksanakan setiap tahunnya dimana kami membuat sebuah pagelaran seni tari dalam bentuk Seni, Drama, Tari yang mengangkat cerita rakyat Jawa Barat. Tahun ini WANUS mengangkat cerita pewayangan Jawa Barat dalam SRIKANDI. ',
				'interests' => '["ART", "CONCERT", "CULTURE", "THEATER"]',
				'group' => 'places'
            ],
        ];

        foreach ($datas as $q) {
            $data = Event::create([
                'type' => $q['type'],
				'organization_id' => $q['organization_id'],
				'name' => $q['name'],
				'place' => $q['place'],
				'location' => $q['location'],
				'location_details' => $q['location_details'],
				'maps' => $q['maps'],
				'description' => $q['description'],
				'interests' => $q['interests'],
				'group' => $q['group'],
            ]);
        }
    }
}
