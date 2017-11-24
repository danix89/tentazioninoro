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
	factory(Tentazioninoro\User::class, 1)->create();
	
	factory(Tentazioninoro\Customer::class, 5)->create()->each(
	    function($customer) {
		factory(Tentazioninoro\IdentityDocument::class, 1)->create(
			[
			    'customer_id' => $customer->id,
			]);
	    }
	);
	
	factory(Tentazioninoro\Jewel::class, 3)->create()->each(
	    function($jewel) {
		$customers = Tentazioninoro\Customer::get();
		foreach ($customers as $customer) {
		    $customerId = $customer->id;

		    $users = Tentazioninoro\User::get();
		    foreach ($users as $user) {
			$userId = $user->id;
			factory(Tentazioninoro\Fixing::class, 1)->create(
				[
				    'user_id' => $user->id,
				    'customer_id' => $customerId,
				    'jewel_id' => $jewel->id,
				]);
			factory(Tentazioninoro\SaleAct::class, 2)->create(
				[
				    'user_id' => $user->id,
				    'customer_id' => $customerId,
				]);
		    }
		}
	    }
	);
    }
}
