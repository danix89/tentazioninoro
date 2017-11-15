<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fiscal_code', 16);
//            $table->bigInteger('identity_document')->unsigned();
            $table->string('mobile_phone');
            $table->string('phone_number');
            $table->string('email')->unique();
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
//        Schema::table('identity_documents', function (Blueprint $table) {
//            $table->dropForeign('customer_id');
//        });
//        Schema::table('fixings', function (Blueprint $table) {
//            $table->dropForeign('customer_id');
//        });
//        Schema::table('sales_acts', function (Blueprint $table) {
//            $table->dropForeign('customer_id');
//        });
        Schema::dropIfExists('customers');
    }

}
