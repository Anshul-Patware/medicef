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
    Schema::create('regulatory_inspections', function (Blueprint $table) {
        $table->id();
        $table->date('date')->nullable();
        $table->integer('initiator_id')->nullable();
        $table->string('division_id')->nullable();
        $table->string('division_code')->nullable();
        $table->string('initiator_group_code')->nullable();
        $table->string('intiation_date')->nullable();
        $table->string('form_type')->nullable();
        $table->integer('record')->nullable();
        $table->integer('assign_to')->nullable();
        $table->string('Initiator_Group')->nullable();
        $table->text('short_description')->nullable();
        $table->text('priority_data')->nullable();
        $table->string('audit_type')->nullable();
        $table->text('if_other')->nullable();
        $table->text('initiated_through')->nullable();
        $table->text('initiated_if_other')->nullable();
        $table->text('others')->nullable();
        $table->text('repeat')->nullable();
        $table->text('repeat_nature')->nullable();
        $table->text('initial_comments')->nullable();
        $table->text('severity_level')->nullable();
        $table->string('due_date')->nullable();
        $table->string('audit_start_date')->nullable();
        $table->string('audit_end_date')->nullable();
        $table->string('external_agencies')->nullable();
        $table->longText('inv_attachment')->nullable();
        $table->string('start_date')->nullable();
        $table->string('end_date')->nullable();
        $table->text('audit_agenda')->nullable();
        $table->text('material_name')->nullable();
        $table->text('if_comments')->nullable();
        $table->string('lead_auditor')->nullable();
        $table->longText('file_attachment')->nullable();
        $table->text('Audit_team')->nullable();
        $table->text('Auditee')->nullable();
        $table->text('Auditor_Details')->nullable();
        $table->text('External_Auditing_Agency')->nullable();
        $table->text('Relevant_Guidelines')->nullable();
        $table->text('QA_Comments')->nullable();
        $table->longText('file_attachment_guideline')->nullable();
        $table->text('Audit_Category')->nullable();
        $table->text('Supplier_Details')->nullable();
        $table->text('Supplier_Site')->nullable();
        $table->text('Comments')->nullable();
        $table->longText('Audit_file')->nullable();
        $table->text('Audit_Comments1')->nullable();
        $table->text('Remarks')->nullable();
        $table->longText('report_file')->nullable();
        $table->text('Reference_Recores1')->nullable();
        $table->text('Reference_Recores2')->nullable();
        $table->longText('myfile')->nullable();
        $table->text('Audit_Comments2')->nullable();
        $table->text('due_date_extension')->nullable();
        $table->string('status')->nullable();
        $table->integer('stage')->nullable();
        $table->longtext('audit_schedule_by')->nullable();
        $table->longtext('cancelled_by')->nullable();
        $table->longtext('rejected_on')->nullable();
        $table->longtext('rejected_by')->nullable();
        $table->longtext('audit_preparation_completed_by')->nullable();
        $table->longtext('audit_mgr_more_info_reqd_by')->nullable();
        $table->longtext('audit_observation_submitted_by')->nullable();
        $table->longtext('audit_lead_more_info_reqd_by')->nullable();
        $table->longtext('audit_response_completed_by')->nullable();
        $table->longtext('response_feedback_verified_by')->nullable();
        $table->longtext('audit_schedule_on')->nullable();
        $table->longtext('cancelled_on')->nullable();
        $table->longtext('audit_preparation_completed_on')->nullable();
        $table->longtext('audit_mgr_more_info_reqd_on')->nullable();
        $table->longtext('audit_observation_submitted_on')->nullable();
        $table->longtext('audit_lead_more_info_reqd_on')->nullable();
        $table->longtext('audit_response_completed_on')->nullable();
        $table->longtext('response_feedback_verified_on')->nullable();
        $table->text('supplier_audits')->nullable();
        $table->text('audit_preparation_comment')->nullable();
        $table->text('pending_response_comment')->nullable();
        $table->text('capa_execution_in_progress_comment')->nullable();
        $table->text('comment_closed_done_by_comment')->nullable();
        $table->text('comment_rejected_comment')->nullable();
        $table->text('comment_cancelled_comment')->nullable();  
        $table->text('comment')->nullable();
        $table->longText('summaryReport')->nullable();

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
        Schema::dropIfExists('regulatory_inspections');
    }
};
