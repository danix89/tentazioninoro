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
	    $table->string('customer_id', 16);
	    $table->date('release_date');
	    $table->string('name');
	    $table->string('surname');
	    $table->string('birth_residence');
	    $table->string('birth_province');
	    $table->date('birth_date');
	    $table->string('residence');
	    $table->string('street');
	    $table->string('street_number');
	    $table->timestamps();
	});
        
        Schema::table('identity_documents', function (Blueprint $table) {
            $table->foreign('customer_id')
                    ->references('fiscal_code')->on('customers')
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
