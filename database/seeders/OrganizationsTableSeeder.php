<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Event\Organization;

class OrganizationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('organizations')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $datas = [
            [
                'name' => 'Bedah Kampus Universitas Indonesia'
            ],
			[
                'name' => 'Wajah Nusantara 2021'
            ],
        ];

        foreach ($datas as $q) {
            $data = Organization::create([
                'name' => $q['name']
            ]);
        }
    }
}
