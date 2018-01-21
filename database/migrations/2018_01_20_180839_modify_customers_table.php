<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->renameColumn('mobile_phone', 'phone_number_1')->change();
            $table->renameColumn('phone_number', 'phone_number_2')->change();
	    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->renameColumn('phone_number_1', 'mobile_phone')->change();
            $table->renameColumn('phone_number_2', 'phone_number')->change();
        });
    }
}
