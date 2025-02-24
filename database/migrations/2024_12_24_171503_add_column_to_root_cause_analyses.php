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
        Schema::table('root_cause_analyses', function (Blueprint $table) {
            $table->string('cq_cqa_by')->nullable();
            $table->string('cq_cqa_on')->nullable();
            $table->text('cq_cqa_comment')->nullable();
            $table->string('root_send_stage_second_by')->nullable();
            $table->string('root_send_stage_second_on')->nullable();
            $table->text('root_send_stage_second_comment')->nullable();

            $table->string('cft_review_by')->nullable();
            $table->string('cft_review_on')->nullable();
            $table->text('cft_review_comment')->nullable();
            $table->text('qa_cqa_approval_comment')->nullable();
            $table->text('qa_cqa_approval_attach')->nullable();
           
          


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('root_cause_analyses', function (Blueprint $table) {
            //
        });
    }
};
