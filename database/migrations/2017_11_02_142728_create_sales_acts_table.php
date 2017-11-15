<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesActsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_acts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('customer_id')->unsigned();
//            $table->string('customer_id', 16);
            $table->string('path_photo');
            $table->timestamps();
        });
        
        Schema::table('sales_acts', function (Blueprint $table) {
            $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');
            $table->foreign('customer_id')
                    ->references('id')->on('customers')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('sales_acts', function (Blueprint $table) {
//            $table->dropForeign('user_id');
//            $table->dropForeign('customer_id');
//        });
        
        Schema::dropIfExists('sales_acts');
    }
}
