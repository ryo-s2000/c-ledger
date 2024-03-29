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
        Schema::table('constructions', function (Blueprint $table) {
            $table->datetime('payment_date1')->nullable()->after('payment_date');
            $table->datetime('payment_date2')->nullable()->after('payment_date1');
            $table->datetime('payment_date3')->nullable()->after('payment_date2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('constructions', function (Blueprint $table) {
            $table->dropColumn('payment_date1');
            $table->dropColumn('payment_date2');
            $table->dropColumn('payment_date3');
        });
    }
};
