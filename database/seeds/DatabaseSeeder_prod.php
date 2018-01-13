<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
	factory(Tentazioninoro\User::class, 1)->create([
            'name' => 'riparazioni',
            'password' => '$2y$10$4f1bp5Dpwj5t8zf2p5MOVe3SZEPKRHJ1jILeQVmg/kc8MfaUOp0dC',
            'email' => 'prova@gmail.com',
            'permissions' => \Config::get('constants.permission.FIXINGS'),
        ]);
	factory(Tentazioninoro\User::class, 1)->create([
            'name' => 'orousato',
            'password' => '$2y$10$4f1bp5Dpwj5t8zf2p5MOVe3SZEPKRHJ1jILeQVmg/kc8MfaUOp0dC',
            'email' => 'prova2@gmail.com',
            'permissions' => \Config::get('constants.permission.SALES_ACTS'),
        ]);
    }
}
