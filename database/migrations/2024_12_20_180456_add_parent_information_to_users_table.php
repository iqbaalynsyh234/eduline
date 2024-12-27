<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('father_name')->nullable();
            $table->string('father_job')->nullable();
            $table->string('father_email')->nullable();
            $table->string('father_phone')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_job')->nullable();
            $table->string('mother_email')->nullable();
            $table->string('mother_phone')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'father_name',
                'father_job',
                'father_email',
                'father_phone',
                'mother_name',
                'mother_job',
                'mother_email',
                'mother_phone',
            ]);
        });
    }
};
