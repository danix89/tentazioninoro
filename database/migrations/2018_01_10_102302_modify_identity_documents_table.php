<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyIdentityDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('identity_documents', function (Blueprint $table) {
            $table->date('release_date')->nullable()->change();
            $table->string('number')->after('release_date')->nullable()->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('identity_documents', function (Blueprint $table) {
            $table->date('release_date')->change();
            $table->dropColumn('number');
        });
    }
}
