<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $datas = [
            [
                'email' => 'raisa6690@gmail.com',
                'password' => 'yesgoers123',
            ],
			[
                'email' => 'maudyayunda@gmail.com',
                'password' => 'yesgoers456',
            ],
        ];

        foreach ($datas as $q) {
            $data = User::create([
                'email' => $q['email'],
				'email_verified_at' => Carbon::now(),
                'password' => app('hash')->make($q['password'])
            ]);
        }
    }
}
