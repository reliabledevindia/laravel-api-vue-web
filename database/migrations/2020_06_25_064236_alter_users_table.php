<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('slug')->unique()->after('id');
            $table->string('username')->unique()->after('slug');
            $table->integer('status')->default(1)->after('image');
            $table->timestamp('last_login_at')->after('remember_token')->nullable();
            $table->string('last_login_ip')->after('last_login_at')->nullable();
            $table->softDeletes()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
