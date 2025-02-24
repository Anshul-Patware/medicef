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
        Schema::create('kush_forms_data1s', function (Blueprint $table) {
            $table->id();

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('depart')->nullable();
            $table->string('course')->nullable();
            $table->string('rollno')->nullable();
            $table->string('contact')->nullable();
            $table->string('branch')->nullable();
            $table->string('category')->nullable();
            $table->json('profile_pics')->nullable(); // To store paths of uploaded images

            // second form data
            $table->string('company_name')->nullable();
            $table->date('join_date')->nullable();
            $table->string('job_type')->nullable();
            $table->string('experience')->nullable();
            $table->string('skill')->nullable();
            $table->json('attachment')->nullable();

            // third form data 
            $table->string('init_dev_cate')->nullable();
            $table->string('inves_req')->nullable();
            $table->string('capa_req')->nullable();
            $table->string('qrm_req')->nullable();
            $table->string('justi_cate')->nullable();
            $table->string('qa_ini_remark')->nullable();
            $table->date('qa_ini_attach')->nullable();
            $table->date('cancel')->nullable();

            // fourth form data 
            $table->date('prod_rev_req')->nullable();
            $table->date('ware_rev_req')->nullable();
            $table->date('qua_con_per')->nullable();
            $table->date('qua_ass_rew_req')->nullable();


            // fifth form data
            $table->string('qa_eval')->nullable();
            $table->string('ini_add_atta')->nullable();

            // sixth form data
            $table->string('post_catego')->nullable();
            $table->string('justifi_for_revi_cate')->nullable();
            $table->string('closure_comment')->nullable();
            $table->string('dispo_of_batch')->nullable();
            $table->string('close_atta')->nullable();

            // seventh form data
            $table->string('propo_due_data')->nullable();
            $table->string('exten_justi')->nullable();
            $table->string('deviati_exte_comp_by')->nullable();
            $table->string('deviati_exte_comp_on')->nullable();
            $table->date('propo_due_date')->nullable();
            $table->string('extens_justi')->nullable();
            $table->string('capa_exten_completed_by')->nullable();
            $table->date('capa_exten_completed_on')->nullable();



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kush_forms_data1s');
    }
};
