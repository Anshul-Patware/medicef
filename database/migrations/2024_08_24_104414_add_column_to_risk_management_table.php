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
        Schema::table('risk_management', function (Blueprint $table) {
            $table->text('cft_completed_by')->nullable();
            $table->text('cft_completed_on')->nullable();
            $table->text('cft_comments')->nullable();
            // $table->text('cancelled_comment')->nullable();
            $table->text('QA_Initial_Review_Complete_By')->nullable();
            $table->text('QA_Initial_Review_Complete_On')->nullable();
            $table->text('QA_Initial_Review_Comments')->nullable();
            $table->text('actionchild')->nullable();
            $table->text('Capachild')->nullable();
            $table->text('Changecontrolchild')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('risk_management', function (Blueprint $table) {
            //
        });
    }
};
