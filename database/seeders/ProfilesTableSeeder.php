<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\Profile;
use Illuminate\Support\Facades\Config;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$genders = Config::get('constants.genders');

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('profiles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $datas = [
            [
				'user_id' => 1,
                'first_name' => 'Raisa',
                'last_name' => 'Andriana',
				'phone' => '+6282225557777',
				'birthday' => '1990-06-06',
				'gender' => $genders['FEMALE']
            ],
			[
                'user_id' => 2,
                'first_name' => 'Fiersa',
                'last_name' => 'Besari',
				'phone' => '+6289260098322',
				'birthday' => '1994-11-12',
				'gender' => $genders['MALE']
            ],
        ];

        foreach ($datas as $q) {
            $data = Profile::create([
                'user_id' => $q['user_id'],
				'first_name' => $q['first_name'],
				'last_name' => $q['last_name'],
				'phone' => $q['phone'],
				'birthday' => $q['birthday'],
				'gender' => $q['gender']
            ]);
        }
    }
}
