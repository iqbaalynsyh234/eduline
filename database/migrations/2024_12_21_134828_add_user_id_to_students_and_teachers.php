<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToStudentsAndTeachers extends Migration
{
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            if (!Schema::hasColumn('students', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('class');
            }
        });

        Schema::table('teachers', function (Blueprint $table) {
            if (!Schema::hasColumn('teachers', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('subject');
            }
        });
    }
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('teachers', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
