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
            $table->integer('billing_amount')->nullable()->after('billing_date');
            $table->integer('billing_amount1')->nullable()->after('billing_date1');
            $table->integer('billing_amount2')->nullable()->after('billing_date2');
            $table->integer('billing_amount3')->nullable()->after('billing_date3');
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
            $table->dropColumn('billing_amount');
            $table->dropColumn('billing_amount1');
            $table->dropColumn('billing_amount2');
            $table->dropColumn('billing_amount3');
        });
    }
};
