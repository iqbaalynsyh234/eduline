<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubprogramIdToEModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('e_modules', function (Blueprint $table) {
            $table->bigInteger('subprogram_id')->unsigned()->nullable()->after('program_id');
            $table->foreign('subprogram_id')->references('id')->on('sub_programs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('e_modules', function (Blueprint $table) {
            $table->dropForeign(['subprogram_id']);
            $table->dropColumn('subprogram_id');
        });
    }
}
