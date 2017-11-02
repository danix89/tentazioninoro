<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttiDiVenditaTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('atti_di_vendita', function (Blueprint $table) {
            $table->increments('id');
            $table->string('path_foto');
            $table->string('cliente_id');
            $table->timestamps();
        });
        
        Schema::table('atti_di_vendita', function (Blueprint $table) {
            $table->foreign('cliente_id')
                    ->references('id')->on('clienti')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('atti_di_vendita');
    }

}
