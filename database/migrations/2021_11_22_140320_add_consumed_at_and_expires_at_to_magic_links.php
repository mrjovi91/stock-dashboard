<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConsumedAtAndExpiresAtToMagicLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('magic_links', function (Blueprint $table) {
            $table->timestamp('consumed_at')->nullable();
            $table->timestamp('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('magic_links', function (Blueprint $table) {
            $table->dropColumn('consumed_at');
            $table->dropColumn('expires_at');
        });
    }
}
