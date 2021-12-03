<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$this->call(UsersTableSeeder::class);
		$this->call(ProfilesTableSeeder::class);
		$this->call(OrganizationsTableSeeder::class);
		$this->call(EventsTableSeeder::class);
		$this->call(EventSessionsTableSeeder::class);
		$this->call(TicketsTableSeeder::class);
		$this->call(PaymentMethodsTableSeeder::class);
    }
}
