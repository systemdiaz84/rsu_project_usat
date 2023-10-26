<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('home_members', function (Blueprint $table) {
            $table->boolean('is_pending')->default(true);
            $table->boolean('is_boss')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('home_trees', function (Blueprint $table) {
            $table->dropColumn('is_pending');
            $table->dropColumn('is_boss');
        });
    }
};
