<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJewelsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('jewels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('typology');
            $table->float('weight');
            $table->string('metal');
            $table->string('path_photo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
//        Schema::table('fixings', function (Blueprint $table) {
//            $table->dropForeign('jewel_id');
//        });

        Schema::dropIfExists('jewels');
    }

}
