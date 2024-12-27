<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('school_origin')->nullable();
            $table->string('class')->nullable();
            $table->string('instagram')->nullable();
            $table->string('subject')->nullable();
            $table->string('hobby')->nullable();
            $table->string('photo')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['school_origin', 'class', 'instagram', 'subject', 'hobby', 'photo']);
        });
    }        
};
