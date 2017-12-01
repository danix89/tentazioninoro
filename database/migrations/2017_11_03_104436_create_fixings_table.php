<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFixingsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('fixings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('customer_id')->unsigned();
//            $table->string('customer_id', 16);
            $table->bigInteger('jewel_id')->unsigned();
            $table->text('description')->nullable();
            $table->float('deposit');
            $table->float('estimate');
            $table->text('notes')->nullable();
            $table->string('state');
            $table->timestamps();
        });

        Schema::table('fixings', function (Blueprint $table) {
            $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');
            $table->foreign('customer_id')
                    ->references('id')->on('customers')
                    ->onDelete('cascade');
            $table->foreign('jewel_id')
                    ->references('id')->on('jewels')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
//        Schema::table('fixings', function (Blueprint $table) {
//            $table->dropForeign('user_id');
//            $table->dropForeign('customer_id');
//            $table->dropForeign('jewel_id');
//        });

        Schema::dropIfExists('fixings');
    }

}
