<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKkmDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('kkm_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('target_id');
            $table->string('subject');
            $table->integer('kkm'); 
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('target_id')->references('id')->on('targets')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kkm_details');
    }
}
