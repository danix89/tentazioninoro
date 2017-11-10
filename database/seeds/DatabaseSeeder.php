<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
//	$this->call(UsersTableSeeder::class);
	factory(Tentazioninoro\User::class, 2)->create();
	factory(Tentazioninoro\Customer::class, 5)->create();
	factory(Tentazioninoro\IdentityDocument::class, 5)->create();
	factory(Tentazioninoro\SaleAct::class, 5)->create();
	factory(Tentazioninoro\Fixing::class, 5)->create();
	factory(Tentazioninoro\Jewel::class, 5)->create();
    }

}
