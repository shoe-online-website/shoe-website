<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 10)->nullable()->after('is_admin');
            $table->string('address', 250)->nullable()->after('is_admin');
            $table->string('province', 100)->nullable()->after('is_admin');
            $table->string('district', 100)->nullable()->after('is_admin');
            $table->string('ward', 100)->nullable()->after('is_admin');
            $table->text('content')->nullable()->after('is_admin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('address');
            $table->dropColumn('province');
            $table->dropColumn('district');
            $table->dropColumn('ward');
            $table->dropColumn('content');
        });
    }
}
