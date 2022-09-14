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
            $table->datetime('price_spare1_created_at')->nullable()->after('price_spare1');
            $table->datetime('price_spare2_created_at')->nullable()->after('price_spare2');
            $table->datetime('price_spare3_created_at')->nullable()->after('price_spare3');
            $table->datetime('price_spare4_created_at')->nullable()->after('price_spare4');
            $table->integer('budget')->default(0)->after('price_spare4_created_at');
            $table->integer('budget_spare1')->nullable()->after('budget');
            $table->datetime('budget_spare1_created_at')->nullable()->after('budget_spare1');
            $table->integer('budget_spare2')->nullable()->after('budget_spare1_created_at');
            $table->datetime('budget_spare2_created_at')->nullable()->after('budget_spare2');
            $table->integer('budget_spare3')->nullable()->after('budget_spare2_created_at');
            $table->datetime('budget_spare3_created_at')->nullable()->after('budget_spare3');
            $table->integer('budget_spare4')->nullable()->after('budget_spare3_created_at');
            $table->datetime('budget_spare4_created_at')->nullable()->after('budget_spare4');
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
            $table->dropColumn('price_spare1_created_at');
            $table->dropColumn('price_spare2_created_at');
            $table->dropColumn('price_spare3_created_at');
            $table->dropColumn('price_spare4_created_at');
            $table->dropColumn('budget');
            $table->dropColumn('budget_spare1');
            $table->dropColumn('budget_spare1_created_at');
            $table->dropColumn('budget_spare2');
            $table->dropColumn('budget_spare2_created_at');
            $table->dropColumn('budget_spare3');
            $table->dropColumn('budget_spare3_created_at');
            $table->dropColumn('budget_spare4');
            $table->dropColumn('budget_spare4_created_at');
        });
    }
};
