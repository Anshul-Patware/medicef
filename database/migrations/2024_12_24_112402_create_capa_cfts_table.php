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
        Schema::create('capa_cfts', function (Blueprint $table) {
            $table->id();
            $table->integer('capa_id');
            $table->text('Production_Review')->nullable();
            $table->text('Production_person')->nullable();
            $table->longtext('Production_assessment')->nullable();
            $table->longtext('Production_feedback')->nullable();
            $table->string('production_attachment')->nullable();
            $table->text('Production_by')->nullable();
            $table->date('production_on')->nullable();

            $table->text('Warehouse_review')->nullable();
            $table->text('Warehouse_notification')->nullable();
            $table->longtext('Warehouse_assessment')->nullable();
            $table->longtext('Warehouse_feedback')->nullable();
            $table->string('Warehouse_attachment')->nullable();
            $table->text('Warehouse_by')->nullable();
            $table->date('Warehouse_on')->nullable();

            $table->text('Quality_review')->nullable();
            $table->text('Quality_Control_Person')->nullable();
            $table->longtext('Quality_Control_assessment')->nullable();
            $table->longtext('Quality_Control_feedback')->nullable();
            $table->string('Quality_Control_attachment')->nullable();
            $table->text('Quality_Control_by')->nullable();
            $table->date('Quality_Control_on')->nullable();

            $table->text('Quality_Assurance_Review')->nullable();
            $table->text('QualityAssurance_person')->nullable();
            $table->longtext('QualityAssurance_assessment')->nullable();
            $table->longtext('QualityAssurance_feedback')->nullable();
            $table->string('Quality_Assurance_attachment')->nullable();
            $table->text('QualityAssurance_by')->nullable();
            $table->date('QualityAssurance_on')->nullable();

            $table->text('Engineering_review')->nullable();
            $table->text('Engineering_person')->nullable();
            $table->longtext('Engineering_assessment')->nullable();
            $table->longtext('Engineering_feedback')->nullable();
            $table->string('Engineering_attachment')->nullable();
            $table->text('Engineering_by')->nullable();
            $table->date('Engineering_on')->nullable();

            $table->text('Environment_Health_review')->nullable();
            $table->text('Environment_Health_Safety_person')->nullable();
            $table->longtext('Health_Safety_assessment')->nullable();
            $table->longtext('Health_Safety_feedback')->nullable();
            $table->string('Environment_Health_Safety_attachment')->nullable();
            $table->text('Environment_Health_Safety_by')->nullable();
            $table->date('Environment_Health_Safety_on')->nullable();

            $table->text('Human_Resource_review')->nullable();
            $table->text('Human_Resource_person')->nullable();
            $table->longtext('Human_Resource_assessment')->nullable();
            $table->longtext('Human_Resource_feedback')->nullable();
            $table->longtext('Human_Resource_attachment')->nullable();
            $table->string('Human_Resource_by')->nullable();
            $table->date('Human_Resource_on')->nullable();

            $table->text('Information_Technology_review')->nullable();
            $table->text('Information_Technology_person')->nullable();
            $table->longtext('Information_Technology_assessment')->nullable();
            $table->longtext('Information_Technology_feedback')->nullable();
            $table->string('Information_Technology_attachment')->nullable();
            $table->text('Information_Technology_by')->nullable();
            $table->date('Information_Technology_on')->nullable();

           

            $table->text('Other1_review')->nullable();
            $table->text('Other1_person')->nullable();
            $table->text('Other1_Department_person')->nullable();
            $table->longtext('Other1_assessment')->nullable();
            $table->longtext('Other1_feedback')->nullable();
            $table->string('Other1_attachment')->nullable();
            $table->text('Other1_by')->nullable();
            $table->date('Other1_on')->nullable();

            $table->text('Other2_review')->nullable();
            $table->text('Other2_person')->nullable();
            $table->text('Other2_Department_person')->nullable();
            $table->longtext('Other2_Assessment')->nullable();
            $table->longtext('Other2_feedback')->nullable();
            $table->string('Other2_attachment')->nullable();
            $table->text('Other2_by')->nullable();
            $table->date('Other2_on')->nullable();

          


            $table->text('ResearchDevelopment_Review')->nullable();
            $table->text('ResearchDevelopment_Comments')->nullable();
            $table->text('ResearchDevelopment_person')->nullable();
            $table->longtext('ResearchDevelopment_assessment')->nullable();
            $table->longtext('ResearchDevelopment_feedback')->nullable();
            $table->string('ResearchDevelopment_attachment')->nullable();
            $table->text('ResearchDevelopment_by')->nullable();
            $table->date('ResearchDevelopment_on')->nullable();

            $table->text('Microbiology_Review')->nullable();
            $table->text('Microbiology_Comments')->nullable();
            $table->text('Microbiology_person')->nullable();
            $table->longtext('Microbiology_assessment')->nullable();
            $table->longtext('Microbiology_feedback')->nullable();
            $table->string('Microbiology_attachment')->nullable();
            $table->text('Microbiology_by')->nullable();
            $table->date('Microbiology_on')->nullable();

            $table->text('RegulatoryAffair_Review')->nullable();
            $table->text('RegulatoryAffair_Comments')->nullable();
            $table->text('RegulatoryAffair_person')->nullable();
            $table->longtext('RegulatoryAffair_assessment')->nullable();
            $table->longtext('RegulatoryAffair_feedback')->nullable();
            $table->string('RegulatoryAffair_attachment')->nullable();
            $table->text('RegulatoryAffair_by')->nullable();
            $table->date('RegulatoryAffair_on')->nullable();
            $table->text('CorporateQualityAssurance_Review')->nullable();
            $table->text('CorporateQualityAssurance_Comments')->nullable();
            $table->text('CorporateQualityAssurance_person')->nullable();
            $table->longtext('CorporateQualityAssurance_assessment')->nullable();
            $table->longtext('CorporateQualityAssurance_feedback')->nullable();
            $table->string('CorporateQualityAssurance_attachment')->nullable();
            $table->text('CorporateQualityAssurance_by')->nullable();
            $table->date('CorporateQualityAssurance_on')->nullable();
            $table->text('ContractGiver_Review')->nullable();
            $table->text('ContractGiver_Comments')->nullable();
            $table->text('ContractGiver_person')->nullable();
            $table->longtext('ContractGiver_assessment')->nullable();
            $table->longtext('ContractGiver_feedback')->nullable();
            $table->string('ContractGiver_attachment')->nullable();
            $table->text('ContractGiver_by')->nullable();
            $table->date('ContractGiver_on')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('capa_cfts');
    }
};
