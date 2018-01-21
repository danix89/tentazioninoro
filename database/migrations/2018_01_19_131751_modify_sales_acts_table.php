<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifySalesActsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_acts', function (Blueprint $table) {
            $table->bigInteger('id_number')->after('id')->unsigned()->unique();
	    $table->string('string_agreed_price')->after('agreed_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_acts', function (Blueprint $table) {
            $table->dropColumn('id_number');
            $table->dropColumn('string_agreed_price');
        });
    }
}
