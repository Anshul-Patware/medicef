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
        Schema::table('failure_investigation_cfts', function (Blueprint $table) {
            $table->text('RA_person')->nullable();
            $table->longtext('RA_assessment')->nullable();
            $table->longtext('RA_feedback')->nullable();
            $table->string('RA_attachment')->nullable();
            $table->text('RA_by')->nullable();
            $table->date('RA_on')->nullable();
            $table->text('RA_Review')->nullable();

            $table->text('Production_Table_Review')->nullable();
            $table->text('Production_Table_Person')->nullable();
            $table->longtext('Production_Table_Assessment')->nullable();
            $table->longtext('Production_Table_Feedback')->nullable();
            $table->string('Production_Table_Attachment')->nullable();
            $table->text('Production_Table_By')->nullable();
            $table->date('Production_Table_On')->nullable();

            $table->text('ProductionLiquid_Review')->nullable();
            $table->text('ProductionLiquid_Comments')->nullable();
            $table->text('ProductionLiquid_person')->nullable();
            $table->longtext('ProductionLiquid_assessment')->nullable();
            $table->longtext('ProductionLiquid_feedback')->nullable();
            $table->string('ProductionLiquid_attachment')->nullable();
            $table->text('ProductionLiquid_by')->nullable();
            $table->date('ProductionLiquid_on')->nullable();

            $table->text('Production_Injection_Review')->nullable();
            $table->text('Production_Injection_Person')->nullable();
            $table->longtext('Production_Injection_Assessment')->nullable();
            $table->longtext('Production_Injection_Feedback')->nullable();
            $table->string('Production_Injection_Attachment')->nullable();
            $table->text('Production_Injection_By')->nullable();
            $table->date('Production_Injection_On')->nullable();

            $table->text('Store_Review')->nullable();
            $table->text('Store_Comments')->nullable();
            $table->text('Store_person')->nullable();
            $table->longtext('Store_assessment')->nullable();
            $table->longtext('Store_feedback')->nullable();
            $table->string('Store_attachment')->nullable();
            $table->text('Store_by')->nullable();
            $table->date('Store_on')->nullable();

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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('failure_investigation_cfts', function (Blueprint $table) {
            //
        });
    }
};
