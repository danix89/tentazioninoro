<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdentityDocumentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
	Schema::create('identity_documents', function (Blueprint $table) {
	    $table->increments('id');
	    $table->bigInteger('customer_id')->unsigned();
//	    $table->string('customer_id', 16);
	    $table->string('type')->nullable();
	    $table->date('release_date')->nullable();
	    $table->string('name');
	    $table->string('surname');
	    $table->string('birth_residence')->nullable();
	    $table->string('birth_province')->nullable();
	    $table->date('birth_date')->nullable();
	    $table->string('residence')->nullable();
	    $table->string('street')->nullable();
	    $table->string('street_number')->nullable();
	    $table->timestamps();
	});
        
        Schema::table('identity_documents', function (Blueprint $table) {
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
    public function down() {
//	Schema::table('identity_documents', function (Blueprint $table) {
//            $table->dropForeign('customer_id');
//        });
        
        Schema::dropIfExists('identity_documents');
    }

}
