<?php

namespace App\Http\Controllers\rcms;

use App\Http\Controllers\Controller;
use App\Models\ActionItem;
use App\Models\Capa;
use App\Models\CapaHistory;
use App\Models\RecordNumber;
use App\Models\User;
use App\Models\CapaAuditTrial;
use App\Models\NotificationUser;
use App\Models\RoleGroup;
use App\Models\CapaGrid;
use App\Models\Extension;
use App\Models\extension_new;
use App\Models\CapaCft;
use App\Models\CapaCftResponse;
use App\Models\CC;
use App\Models\Division;
use App\Models\EffectivenessCheck;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PDF;
use Helpers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\OpenStage;
use App\Models\QMSDivision;
// use App\Services\DocumentService;
use Illuminate\Support\Facades\File;

class CapaController extends Controller
{

    public function capa()
    {
        $cft = [];
        $old_records = Capa::select('id', 'division_id', 'record')->get();
        // Record number ko pad karke 4 digits ka bana rahe hain
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);

        // Division ke hisaab se latest record check kar rahe hain
        $division = QMSDivision::where('name', Helpers::getDivisionName(session()->get('division')))->first();

        if ($division) {
            $last_capa = Capa::where('division_id', $division->id)->latest()->first();

            if ($last_capa) {
                // Agar last record hai to usko pad karke next record number bana rahe hain
                $record_number = $last_capa->record ? str_pad($last_capa->record + 1, 4, '0', STR_PAD_LEFT) : '0001';
            } else {
                $record_number = '0001';
            }
        }

        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');

        $changeControl = OpenStage::find(1);
        if (!empty($changeControl->cft)) {
            $cft = explode(',', $changeControl->cft);
        }

        return view("frontend.forms.capa", compact('due_date', 'record_number', 'old_records', 'cft'));
    }

    public function capastore(Request $request)
    {
        // return $request;

        if (!$request->short_description) {
            toastr()->error("Short description is required");
            return redirect()->back();
        }

        $capa = new Capa();
        $capa->form_type = "CAPA";
        $capa->record = ((RecordNumber::first()->value('counter')) + 1);
        $capa->initiator_id = Auth::user()->id;
        $capa->division_id = $request->division_id;
        $capa->parent_id = $request->parent_id;
        $capa->parent_type = $request->parent_type;
        $capa->division_code = $request->division_code;
        $capa->intiation_date = $request->intiation_date;
        $capa->general_initiator_group = $request->initiator_group;
        $capa->short_description = $request->short_description;
        $capa->priority_data = $request->priority_data;
        $capa->problem_description = $request->problem_description;
        $capa->due_date = $request->due_date;
        $capa->assign_to = $request->assign_to;
        $capa->product_name = $request->product_name;
        $capa->Post_Categorization = $request->Post_Categorization;
        $capa->Initial_Categorization = $request->Initial_Categorization;
        $capa->capa_source_number = $request->capa_source_number;
        $capa->capa_team =  implode(',', $request->capa_team);
        $capa_teamIdsArray = explode(',', $capa->capa_team);
        $capa_teamNames = User::whereIn('id', $capa_teamIdsArray)->pluck('name')->toArray();
        $capa_teamNamesString = implode(', ', $capa_teamNames);
        //    $capa->capa_team = implode(',', $request->capa_team);
        //    $capa->capa_team = implode(',', $request->input('capa_team', []));
        //    dd( $capa->capa_team);
        $capa->capa_type = $request->capa_type;
        $capa->severity_level_form = $request->severity_level_form;
        $capa->initiated_through = $request->initiated_through;
        $capa->initiated_through_req = $request->initiated_through_req;
        $capa->repeat = $request->repeat;
        $capa->initiator_Group = Helpers::getInitiatorGroupFullName($request->initiator_group_code);
        $capa->initiator_group_code = $request->initiator_group_code;
        $capa->repeat_nature = $request->repeat_nature;
        $capa->Effectiveness_checker = $request->Effectiveness_checker;
        $capa->effective_check_plan = $request->effective_check_plan;
        $capa->due_date_extension = $request->due_date_extension;
        $capa->cft_comments_form = $request->cft_comments_form;
        $capa->qa_comments_new = $request->qa_comments_new;
        $capa->designee_comments_new = $request->designee_comments_new;
        $capa->Warehouse_comments_new = $request->Warehouse_comments_new;
        $capa->Engineering_comments_new = $request->Engineering_comments_new;
        $capa->Instrumentation_comments_new = $request->Instrumentation_comments_new;
        $capa->Validation_comments_new = $request->Validation_comments_new;
        $capa->Others_comments_new = $request->Others_comments_new;
        $capa->Group_comments_new = $request->Group_comments_new;

        $capa->due_date_extension = $request->due_date_extension;
        $capa->hod_final_review = $request->hod_final_review;
        $capa->qa_approval_review = $request->qa_approval_review;
        $capa->qa_cqa_qa_comments = $request->qa_cqa_qa_comments;
        $capa->qah_cq_comments = $request->qah_cq_comments;
        
        //    $capa->hod_attachment = $request->hod_attachment;
        //    $capa->qa_attachment = $request->qa_attachment;
        //    $capa->capafileattachement = $request->capafileattachement;    
        $capa->investigation = $request->investigation;
        $capa->rcadetails = $request->rcadetails;
        
        //    $capa->cft_attchament_new= json_encode($request->cft_attchament_new);
        //    $capa->additional_attachments= json_encode($request->additional_attachments);
        //    $capa->group_attachments_new = json_encode($request->group_attachments_new);
        $capa->Microbiology_new = $request->Microbiology_new;
        //    $capa->Microbiology_Person = $request->Microbiology_Person;
        $capa->goup_review = $request->goup_review;
        $capa->Production_new = $request->Production_new;
        $capa->Quality_Approver = $request->Quality_Approver;
        $capa->Quality_Approver_Person = $request->Quality_Approver_Person;
        $capa->bd_domestic = $request->bd_domestic;
        $capa->Bd_Person = $request->Bd_Person;
        $capa->Production_Person = $request->Production_Person;
        //    $capa->additional_attachments= json_encode($request->additional_attachments);
        $capa->capa_related_record = implode(',', $request->capa_related_record);

        $capa->initial_observation = $request->initial_observation;
        $capa->interim_containnment = $request->interim_containnment;
        $capa->containment_comments = $request->containment_comments;
        if (!empty($request->capa_attachment)) {
            $files = [];
            if ($request->hasfile('capa_attachment')) {
                foreach ($request->file('capa_attachment') as $file) {
                    $name = $request->name . '-capa_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $capa->capa_attachment = json_encode($files);
        }
        if (!empty($request->cft_attchament_new)) {
            $files = [];
            if ($request->hasfile('cft_attchament_new')) {
                foreach ($request->file('cft_attchament_new') as $file) {
                    $name = $request->name . '-cft_attchament_new' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $capa->cft_attchament_new = json_encode($files);
        }
        if (!empty($request->additional_attachments)) {
            $files = [];
            if ($request->hasfile('additional_attachments')) {
                foreach ($request->file('additional_attachments') as $file) {
                    $name = $request->name . '-additional_attachments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $capa->additional_attachments = json_encode($files);
        }
        if (!empty($request->group_attachments_new)) {
            $files = [];
            if ($request->hasfile('group_attachments_new')) {
                foreach ($request->file('group_attachments_new') as $file) {
                    $name = $request->name . '-group_attachments_new' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $capa->group_attachments_new = json_encode($files);
        }
        if (!empty($request->hod_attachment)) {
            $files = [];
            if ($request->hasfile('hod_attachment')) {
                foreach ($request->file('hod_attachment') as $file) {
                    $name = $request->name . '-hod_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $capa->hod_attachment = json_encode($files);
        }
        if (!empty($request->qa_attachment)) {
            $files = [];
            if ($request->hasfile('qa_attachment')) {
                foreach ($request->file('qa_attachment') as $file) {
                    $name = $request->name . '-qa_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $capa->qa_attachment = json_encode($files);
        }
        if (!empty($request->capafileattachement)) {
            $files = [];
            if ($request->hasfile('capafileattachement')) {
                foreach ($request->file('capafileattachement') as $file) {
                    $name = $request->name . '-capafileattachement' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $capa->capafileattachement = json_encode($files);
        }
        if (!empty($request->hod_final_attachment)) {
            $files = [];
            if ($request->hasfile('hod_final_attachment')) {
                foreach ($request->file('hod_final_attachment') as $file) {
                    $name = $request->name . '-hod_final_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $capa->hod_final_attachment = json_encode($files);
        }
        if (!empty($request->qa_approval_attachment)) {
            $files = [];
            if ($request->hasfile('qa_approval_attachment')) {
                foreach ($request->file('qa_approval_attachment') as $file) {
                    $name = $request->name . '-qa_approval_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $capa->qa_approval_attachment = json_encode($files);
        }


        if (!empty($request->qa_closure_attachment)) {
            $files = [];
            if ($request->hasfile('qa_closure_attachment')) {
                foreach ($request->file('qa_closure_attachment') as $file) {
                    $name = $request->name . '-qa_closure_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $capa->qa_closure_attachment = json_encode($files);
        }
        //  dd($capa->qa_closure_attachment);
        if (!empty($request->qah_cq_attachment)) {
            $files = [];
            if ($request->hasfile('qah_cq_attachment')) {
                foreach ($request->file('qah_cq_attachment') as $file) {
                    $name = $request->name . '-qah_cq_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $capa->qah_cq_attachment = json_encode($files);
        }

        $capa->capa_qa_comments = $request->capa_qa_comments;
        $capa->capa_qa_comments2 = $request->capa_qa_comments2;
        $capa->hod_remarks = $request->hod_remarks;
        $capa->details_new = $request->details_new;
        $capa->project_details_application = $request->project_details_application;
        $capa->project_initiator_group = $request->project_initiator_group;
        $capa->site_number = $request->site_number;
        $capa->subject_number = $request->subject_number;
        $capa->subject_initials = $request->subject_initials;
        $capa->sponsor = $request->sponsor;
        $capa->general_deviation = $request->general_deviation;
        $capa->corrective_action = $request->corrective_action;
        $capa->preventive_action = $request->preventive_action;
        $capa->supervisor_review_comments = $request->supervisor_review_comments;
        $capa->qa_review = $request->qa_review;
        $capa->effectiveness = $request->effectiveness;
        $capa->effect_check = $request->effect_check;
        $capa->effect_check_date = $request->effect_check_date;

        if (!empty($request->closure_attachment)) {
            $files = [];
            if ($request->hasfile('closure_attachment')) {
                foreach ($request->file('closure_attachment') as $file) {
                    $name = $request->name . '-closure_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $capa->closure_attachment = json_encode($files);
        }

        $capa->status = 'Opened';
        $capa->stage = 1;
        $capa->save();

        // $userNotification = new NotificationUser();
        // $userNotification->record_id = $capa->id;
        // $userNotification->record_type = "CAPA";
        // $userNotification->to_id = Auth::user()->id;
        // $userNotification->save();

        $data1 = new CapaGrid();
        $data1->capa_id = $capa->id;
        $data1->type = "Product_Details";

        if (!empty($request->material_name)) {
            $data1->product_name = serialize($request->material_name);
        }
        if (!empty($request->material_batch_no)) {
            $data1->batch_no = serialize($request->material_batch_no);
        }
        if (!empty($request->material_mfg_date)) {
            $data1->mfg_date = serialize($request->material_mfg_date);
        }
        if (!empty($request->material_batch_desposition)) {
            $data1->batch_desposition = serialize($request->material_batch_desposition);
        }
        if (!empty($request->material_expiry_date)) {
            $data1->expiry_date = serialize($request->material_expiry_date);
        }
        if (!empty($request->material_remark)) {
            $data1->remark = serialize($request->material_remark);
        }
        if (!empty($request->material_batch_status)) {
            $data1->batch_status = serialize($request->material_batch_status);
        }
        //  dd($request->all());
        $data1->save();


        $data2 = new CapaGrid();
        $data2->capa_id = $capa->id;
        $data2->type = "Material_Details";
        if (!empty($request->material_name)) {
            $data2->material_name = serialize($request->material_name);
        }
        if (!empty($request->material_batch_no)) {
            $data2->material_batch_no = serialize($request->material_batch_no);
        }
        if (!empty($request->material_mfg_date)) {
            $data2->material_mfg_date = serialize($request->material_mfg_date);
        }
        if (!empty($request->material_expiry_date)) {
            $data2->material_expiry_date = serialize($request->material_expiry_date);
        }
        if (!empty($request->material_batch_desposition)) {
            $data2->material_batch_desposition = serialize($request->material_batch_desposition);
        }
        if (!empty($request->material_remark)) {
            $data2->material_remark = serialize($request->material_remark);
        }
        if (!empty($request->material_batch_status)) {
            $data2->material_batch_status = serialize($request->material_batch_status);
        }


        $data2->save();

        $data3 = new CapaGrid();
        $data3->capa_id = $capa->id;
        $data3->type = "Instruments_Details";
        if (!empty($request->equipment)) {
            $data3->equipment = serialize($request->equipment);
        }
        if (!empty($request->equipment_instruments)) {
            $data3->equipment_instruments = serialize($request->equipment_instruments);
        }
        if (!empty($request->equipment_comments)) {
            $data3->equipment_comments = serialize($request->equipment_comments);
        }
        $data3->save();
        // cft filed start
        $Cft = new CapaCft();
        $Cft->capa_id = $capa->id;
        $Cft->Production_Review = $request->Production_Review;
        $Cft->Production_person = $request->Production_person;
        $Cft->Production_assessment = $request->Production_assessment;
        $Cft->Production_feedback = $request->Production_feedback;
        $Cft->production_on = $request->production_on;
        $Cft->production_by = $request->production_by;

        // $Cft->RA_Review = $request->RA_Review;
        // $Cft->RA_Comments = $request->RA_Comments;
        // $Cft->RA_person = $request->RA_person;
        // $Cft->RA_assessment = $request->RA_assessment;
        // $Cft->RA_feedback = $request->RA_feedback;
        // $Cft->RA_attachment = $request->RA_attachment;
        // $Cft->RA_by = $request->RA_by;
        // $Cft->RA_on = $request->RA_on;

        // $Cft->Production_Table_Review = $request->Production_Table_Review;
        // $Cft->Production_Table_Person = $request->Production_Table_Person;
        // $Cft->Production_Table_Assessment = $request->Production_Table_Assessment;
        // $Cft->Production_Table_Feedback = $request->Production_Table_Feedback;
        // $Cft->Production_Table_Attachment = $request->Production_Table_Attachment;
        // $Cft->Production_Table_By = $request->Production_Table_By;
        // $Cft->Production_Table_On = $request->Production_Table_On;

        $Cft->Production_Injection_Review = $request->Production_Injection_Review;
        $Cft->Production_Injection_Person = $request->Production_Injection_Person;
        $Cft->Production_Injection_Assessment = $request->Production_Injection_Assessment;
        $Cft->Production_Injection_Feedback = $request->Production_Injection_Feedback;
        $Cft->Production_Injection_Attachment = $request->Production_Injection_Attachment;
        $Cft->Production_Injection_By = $request->Production_Injection_By;
        $Cft->Production_Injection_On = $request->Production_Injection_On;

        $Cft->Warehouse_review = $request->Warehouse_review;
        $Cft->Warehouse_notification = $request->Warehouse_notification;
        $Cft->Warehouse_assessment = $request->Warehouse_assessment;
        $Cft->Warehouse_feedback = $request->Warehouse_feedback;
        $Cft->Warehouse_by = $request->Warehouse_Review_Completed_By;
        $Cft->Warehouse_on = $request->Warehouse_on;

        $Cft->Quality_review = $request->Quality_review;
        $Cft->Quality_Control_Person = $request->Quality_Control_Person;
        $Cft->Quality_Control_assessment = $request->Quality_Control_assessment;
        $Cft->Quality_Control_feedback = $request->Quality_Control_feedback;
        $Cft->Quality_Control_by = $request->Quality_Control_by;
        $Cft->Quality_Control_on = $request->Quality_Control_on;

        $Cft->Quality_Assurance_Review = $request->Quality_Assurance_Review;
        $Cft->QualityAssurance_person = $request->QualityAssurance_person;
        $Cft->QualityAssurance_assessment = $request->QualityAssurance_assessment;
        $Cft->QualityAssurance_feedback = $request->QualityAssurance_feedback;
        $Cft->QualityAssurance_by = $request->QualityAssurance_by;
        $Cft->QualityAssurance_on = $request->QualityAssurance_on;

        $Cft->Engineering_review = $request->Engineering_review;
        $Cft->Engineering_person = $request->Engineering_person;
        $Cft->Engineering_assessment = $request->Engineering_assessment;
        $Cft->Engineering_feedback = $request->Engineering_feedback;
        $Cft->Engineering_by = $request->Engineering_by;
        $Cft->Engineering_on = $request->Engineering_on;



       

       

        $Cft->Environment_Health_review = $request->Environment_Health_review;
        $Cft->Environment_Health_Safety_person = $request->Environment_Health_Safety_person;
        $Cft->Health_Safety_assessment = $request->Health_Safety_assessment;
        $Cft->Health_Safety_feedback = $request->Health_Safety_feedback;
        $Cft->Environment_Health_Safety_by = $request->Environment_Health_Safety_by;
        $Cft->Environment_Health_Safety_on = $request->Environment_Health_Safety_on;

        $Cft->Human_Resource_review = $request->Human_Resource_review;
        $Cft->Human_Resource_person = $request->Human_Resource_person;
        $Cft->Human_Resource_assessment = $request->Human_Resource_assessment;
        $Cft->Human_Resource_feedback = $request->Human_Resource_feedback;
        $Cft->Human_Resource_by = $request->Human_Resource_by;
        $Cft->Human_Resource_on = $request->Human_Resource_on;

        $Cft->Information_Technology_review = $request->Information_Technology_review;
        $Cft->Information_Technology_person = $request->Information_Technology_person;
        $Cft->Information_Technology_assessment = $request->Information_Technology_assessment;
        $Cft->Information_Technology_feedback = $request->Information_Technology_feedback;
        $Cft->Information_Technology_by = $request->Information_Technology_by;
        $Cft->Information_Technology_on = $request->Information_Technology_on;


        // $Cft->ProductionLiquid_Review= $request->ProductionLiquid_Review;
        // $Cft->ProductionLiquid_person = $request->ProductionLiquid_person;
        // $Cft->ProductionLiquid_assessment = $request->ProductionLiquid_assessment;
        // $Cft->ProductionLiquid_feedback = $request->ProductionLiquid_feedback;
        // $Cft->ProductionLiquid_by = $request->ProductionLiquid_by;
        // $Cft->ProductionLiquid_on = $request->ProductionLiquid_on;


        // $Cft->Store_Review = $request->Store_Review;
        // $Cft->Store_person = $request->Store_person;
        // $Cft->Store_assessment = $request->Store_assessment;
        // $Cft->Store_feedback = $request->Store_feedback;
        // $Cft->Store_by = $request->Store_by;
        // $Cft->Store_on = $request->Store_on;

        $Cft->ResearchDevelopment_Review = $request->ResearchDevelopment_Review;
        $Cft->ResearchDevelopment_person = $request->ResearchDevelopment_person;
        $Cft->ResearchDevelopment_assessment = $request->ResearchDevelopment_assessment;
        $Cft->ResearchDevelopment_feedback = $request->ResearchDevelopment_feedback;
        $Cft->ResearchDevelopment_by = $request->ResearchDevelopment_by;
        $Cft->ResearchDevelopment_on = $request->ResearchDevelopment_on;

        $Cft->RegulatoryAffair_Review = $request->RegulatoryAffair_Review;
        $Cft->RegulatoryAffair_person = $request->RegulatoryAffair_person;
        $Cft->RegulatoryAffair_assessment = $request->RegulatoryAffair_assessment;
        $Cft->RegulatoryAffair_feedback = $request->RegulatoryAffair_feedback;
        $Cft->RegulatoryAffair_by = $request->RegulatoryAffair_by;
        $Cft->RegulatoryAffair_on = $request->RegulatoryAffair_on;

        $Cft->Microbiology_Review = $request->Microbiology_Review;
        $Cft->Microbiology_person = $request->Microbiology_person;
        $Cft->Microbiology_assessment = $request->Microbiology_assessment;
        $Cft->Microbiology_feedback = $request->Microbiology_feedback;
        $Cft->Microbiology_by = $request->Microbiology_by;
        $Cft->Microbiology_on = $request->Microbiology_on;

        $Cft->CorporateQualityAssurance_Review = $request->CorporateQualityAssurance_Review;
        $Cft->CorporateQualityAssurance_person = $request->CorporateQualityAssurance_person;
        $Cft->CorporateQualityAssurance_assessment = $request->CorporateQualityAssurance_assessment;
        $Cft->CorporateQualityAssurance_feedback = $request->CorporateQualityAssurance_feedback;
        $Cft->CorporateQualityAssurance_by = $request->CorporateQualityAssurance_by;
        $Cft->CorporateQualityAssurance_on = $request->CorporateQualityAssurance_on;


        
        // $Cft->hod_assessment_comments = $request->hod_assessment_comments;
        // $Cft->Other1_person = $request->Other1_person;
        // $Cft->Other1_Department_person = $request->Other1_Department_person;
        // $Cft->Other1_assessment = $request->Other1_assessment;
        // $Cft->Other1_feedback = $request->Other1_feedback;
        // $Cft->Other1_by = $request->Other1_by;
        // $Cft->Other1_on = $request->Other1_on;

        // $Cft->Other2_review = $request->Other2_review;
        // $Cft->Other2_person = $request->Other2_person;
        // $Cft->Other2_Department_person = $request->Other2_Department_person;
        // $Cft->Other2_Assessment = $request->Other2_Assessment;
        // $Cft->Other2_feedback = $request->Other2_feedback;
        // $Cft->Other2_by = $request->Other2_by;
        // $Cft->Other2_on = $request->Other2_on;

        // $Cft->Other3_review = $request->Other3_review;
        // $Cft->Other3_person = $request->Other3_person;
        // $Cft->Other3_Department_person = $request->Other3_Department_person;
        // $Cft->Other3_Assessment = $request->Other3_Assessment;
        // $Cft->Other3_feedback = $request->Other3_feedback;
        // $Cft->Other3_by = $request->Other3_by;
        // $Cft->Other3_on = $request->Other3_on;

        // $Cft->Other4_review = $request->Other4_review;
        // $Cft->Other4_person = $request->Other4_person;
        // $Cft->Other4_Department_person = $request->Other4_Department_person;
        // $Cft->Other4_Assessment = $request->Other4_Assessment;
        // $Cft->Other4_feedback = $request->Other4_feedback;
        // $Cft->Other4_by = $request->Other4_by;
        // $Cft->Other4_on = $request->Other4_on;

        // $Cft->Other5_review = $request->Other5_review;
        // $Cft->Other5_person = $request->Other5_person;
        // $Cft->Other5_Department_person = $request->Other5_Department_person;
        // $Cft->Other5_Assessment = $request->Other5_Assessment;
        // $Cft->Other5_feedback = $request->Other5_feedback;
        // $Cft->Other5_by = $request->Other5_by;
        // $Cft->Other5_on = $request->Other5_on;

        
        if (!empty ($request->RA_attachment)) {
            $files = [];
            if ($request->hasfile('RA_attachment')) {
                foreach ($request->file('RA_attachment') as $file) {
                    $name = $request->name . 'RA_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->RA_attachment = json_encode($files);
        }
        if (!empty ($request->Quality_Assurance_attachment)) {
            $files = [];
            if ($request->hasfile('Quality_Assurance_attachment')) {
                foreach ($request->file('Quality_Assurance_attachment') as $file) {
                    $name = $request->name . 'Quality_Assurance_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->Quality_Assurance_attachment = json_encode($files);
        }
        if (!empty ($request->Production_Table_Attachment)) {
            $files = [];
            if ($request->hasfile('Production_Table_Attachment')) {
                foreach ($request->file('Production_Table_Attachment') as $file) {
                    $name = $request->name . 'Production_Table_Attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->Production_Table_Attachment = json_encode($files);
        }
        if (!empty ($request->ProductionLiquid_attachment)) {
            $files = [];
            if ($request->hasfile('ProductionLiquid_attachment')) {
                foreach ($request->file('ProductionLiquid_attachment') as $file) {
                    $name = $request->name . 'ProductionLiquid_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->ProductionLiquid_attachment = json_encode($files);
        }
        if (!empty ($request->Production_Injection_Attachment)) {
            $files = [];
            if ($request->hasfile('Production_Injection_Attachment')) {
                foreach ($request->file('Production_Injection_Attachment') as $file) {
                    $name = $request->name . 'Production_Injection_Attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->Production_Injection_Attachment = json_encode($files);
        }    
        


        if (!empty ($request->Store_attachment)) {
            $files = [];
            if ($request->hasfile('Store_attachment')) {
                foreach ($request->file('Store_attachment') as $file) {
                    $name = $request->name . 'Store_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->Store_attachment = json_encode($files);
        }
        if (!empty ($request->Quality_Control_attachment)) {
            $files = [];
            if ($request->hasfile('Quality_Control_attachment')) {
                foreach ($request->file('Quality_Control_attachment') as $file) {
                    $name = $request->name . 'Quality_Control_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->Quality_Control_attachment = json_encode($files);
        }
        if (!empty ($request->ResearchDevelopment_attachment)) {
            $files = [];
            if ($request->hasfile('ResearchDevelopment_attachment')) {
                foreach ($request->file('ResearchDevelopment_attachment') as $file) {
                    $name = $request->name . 'ResearchDevelopment_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->ResearchDevelopment_attachment = json_encode($files);
        }
        if (!empty ($request->Engineering_attachment)) {
            $files = [];
            if ($request->hasfile('Engineering_attachment')) {
                foreach ($request->file('Engineering_attachment') as $file) {
                    $name = $request->name . 'Engineering_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->Engineering_attachment = json_encode($files);
        }
        if (!empty ($request->Human_Resource_attachment)) {
            $files = [];
            if ($request->hasfile('Human_Resource_attachment')) {
                foreach ($request->file('Human_Resource_attachment') as $file) {
                    $name = $request->name . 'Human_Resource_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->Human_Resource_attachment = json_encode($files);
        }
        if (!empty ($request->Microbiology_attachment)) {
            $files = [];
            if ($request->hasfile('Microbiology_attachment')) {
                foreach ($request->file('Microbiology_attachment') as $file) {
                    $name = $request->name . 'Microbiology_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->Microbiology_attachment = json_encode($files);
        }
        if (!empty ($request->RegulatoryAffair_attachment)) {
            $files = [];
            if ($request->hasfile('RegulatoryAffair_attachment')) {
                foreach ($request->file('RegulatoryAffair_attachment') as $file) {
                    $name = $request->name . 'RegulatoryAffair_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->RegulatoryAffair_attachment = json_encode($files);
        }
        if (!empty ($request->CorporateQualityAssurance_attachment)) {
            $files = [];
            if ($request->hasfile('CorporateQualityAssurance_attachment')) {
                foreach ($request->file('CorporateQualityAssurance_attachment') as $file) {
                    $name = $request->name . 'CorporateQualityAssurance_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->CorporateQualityAssurance_attachment = json_encode($files);
        }
        if (!empty ($request->Environment_Health_Safety_attachment)) {
            $files = [];
            if ($request->hasfile('Environment_Health_Safety_attachment')) {
                foreach ($request->file('Environment_Health_Safety_attachment') as $file) {
                    $name = $request->name . 'Environment_Health_Safety_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->Environment_Health_Safety_attachment = json_encode($files);
        }            
        if (!empty ($request->Information_Technology_attachment)) {
            $files = [];
            if ($request->hasfile('Information_Technology_attachment')) {
                foreach ($request->file('Information_Technology_attachment') as $file) {
                    $name = $request->name . 'Information_Technology_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->Information_Technology_attachment = json_encode($files);
        }
        if (!empty ($request->ContractGiver_attachment)) {
            $files = [];
            if ($request->hasfile('ContractGiver_attachment')) {
                foreach ($request->file('ContractGiver_attachment') as $file) {
                    $name = $request->name . 'ContractGiver_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $Cft->ContractGiver_attachment = json_encode($files);
        }

        
        if (!empty ($request->Other1_attachment)) {
            $files = [];
            if ($request->hasfile('Other1_attachment')) {
                foreach ($request->file('Other1_attachment') as $file) {
                    $name = $request->name . 'Other1_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Other1_attachment = json_encode($files);
        }
        if (!empty ($request->Other2_attachment)) {
            $files = [];
            if ($request->hasfile('Other2_attachment')) {
                foreach ($request->file('Other2_attachment') as $file) {
                    $name = $request->name . 'Other2_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Other2_attachment = json_encode($files);
        }
        if (!empty ($request->Other3_attachment)) {
            $files = [];
            if ($request->hasfile('Other3_attachment')) {
                foreach ($request->file('Other3_attachment') as $file) {
                    $name = $request->name . 'Other3_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Other3_attachment = json_encode($files);
        }
        if (!empty ($request->Other4_attachment)) {
            $files = [];
            if ($request->hasfile('Other4_attachment')) {
                foreach ($request->file('Other4_attachment') as $file) {
                    $name = $request->name . 'Other4_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Other4_attachment = json_encode($files);
        }
        if (!empty ($request->Other5_attachment)) {
            $files = [];
            if ($request->hasfile('Other5_attachment')) {
                foreach ($request->file('Other5_attachment') as $file) {
                    $name = $request->name . 'Other5_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Other5_attachment = json_encode($files);
        }

        $Cft->save();

        /* CFT Fields Ends */

        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();


        if (!empty($capa->record)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Record Number';
            $history->previous = "Null";
            $history->current = Helpers::getDivisionName(session()->get('division')) . "/CAPA/" . Helpers::year($capa->created_at) . "/" . str_pad($capa->record, 4, '0', STR_PAD_LEFT);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($capa->division_code)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Site/Location Code';
            $history->previous = "Null";
            $history->current = $capa->division_code;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }
        if (!empty($capa->initiator_id)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Initiator';
            $history->previous = "Null";
            $history->current = Helpers::getInitiatorName($capa->initiator_id);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }


        if (!empty($capa->intiation_date)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Date of Initiation';
            $history->previous = "Null";
            $history->current = Helpers::getdateFormat($capa->intiation_date);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }
        // if (!empty($capa->assign_to)) {
        //     $history = new CapaAuditTrial();
        //     $history->capa_id = $capa->id;
        //     $history->activity_type = 'Assigned To';
        //     $history->previous = "Null";
        //     $history->current = $capa->assign_to;
        //     $history->comment = "Not Applicable";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $capa->status;
        //     $history->change_to = "Opened";
        //     $history->change_from = "Initiation";
        //     $history->action_name = "Create";
        //     $history->save();
        // }

        if (!empty($capa->assign_to)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Assigned To';
            $history->previous = "Null";
            $history->current = $capa->assign_to;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($capa->due_date)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Due Date';
            $history->previous = "Null";
            $history->current = Helpers::getdateFormat($capa->due_date);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($capa->initiator_Group)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Department Group';
            $history->previous = "Null";
            $history->current = Helpers::getInitiatorGroupFullName($capa->initiator_group_code);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }
        if (!empty($capa->initiator_group_code)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Department Group Code';
            $history->previous = "Null";
            $history->current = $capa->initiator_group_code;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($capa->short_description)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Short Description';
            $history->previous = "Null";
            $history->current = $capa->short_description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($capa->priority_data)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Priority';
            $history->previous = "Null";
            $history->current = $capa->priority_data;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($capa->product_name)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Product Name';
            $history->previous = "Null";
            $history->current = $capa->product_name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($capa->capa_source_number)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'CAPA Source & Number';
            $history->previous = "Null";
            $history->current = $capa->capa_source_number;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($capa->initiated_through)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Initiated Through';
            $history->previous = "Null";
            $history->current = $capa->initiated_through;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }
        if (!empty($capa->initiated_through_req)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Others';
            $history->previous = "Null";
            $history->current = $capa->initiated_through_req;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }


        if (!empty($capa->repeat)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Repeat';
            $history->previous = "Null";
            $history->current = $capa->repeat;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($capa->repeat_nature)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Repeat Nature';
            $history->previous = "Null";
            $history->current = $capa->repeat_nature;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }


        if (!empty($capa->problem_description)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Problem Description';
            $history->previous = "Null";
            $history->current = $capa->problem_description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($capa->capa_team)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'CAPA Team';
            $history->previous = "Null";
            $history->current = $capa_teamNamesString;

            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }


        if (!empty($capa->capa_related_record)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Reference Records';
            $history->previous = "Null";
            if (is_array($capa->capa_related_record)) {
                $history->current = implode(',', $capa->capa_related_record);
            } else {
                // If it's a string, no need to implode
                $history->current = $capa->capa_related_record;
            }

            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($capa->initial_observation)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Initial Observation';
            $history->previous = "Null";
            $history->current = $capa->initial_observation;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($capa->interim_containnment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Interim Containnment';
            $history->previous = "Null";
            $history->current = $capa->interim_containnment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($capa->containment_comments)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Containment Comments';
            $history->previous = "Null";
            $history->current = $capa->containment_comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }
        
        if (!empty($capa->capa_attachment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'CAPA Attachment';
            $history->previous = "Null";
            $history->current = $capa->capa_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($capa->investigation)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Investigation';
            $history->previous = "Null";
            $history->current = $capa->investigation;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }
        if (!empty($capa->rcadetails)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Root Cause Analysis';
            $history->previous = "Null";
            $history->current = $capa->rcadetails;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        /////////////////////// Equipment / MAterial Info///////////
        if (!empty($capa->severity_level_form)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Severity Level';
            $history->previous = "Null";
            $history->current = $capa->severity_level_form;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }
        if (!empty($capa->details_new)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Details';
            $history->previous = "Null";
            $history->current = $capa->details_new;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        /////////////////////CAPA Details//////////////////////
        if (!empty($capa->capa_type)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Capa Type';
            $history->previous = "Null";
            $history->current = $capa->capa_type;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($capa->corrective_action)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Corrective Action';
            $history->previous = "Null";
            $history->current = $capa->corrective_action;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($capa->preventive_action)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Preventive Action';
            $history->previous = "Null";
            $history->current = $capa->preventive_action;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($capa->capafileattachement)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'File Attachment';
            $history->previous = "Null";
            $history->current = $capa->capafileattachement;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }


        /////////////////////////HOD REview////////////////
        if (!empty($capa->hod_remarks)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'HOD Remark';
            $history->previous = "Null";
            $history->current = $capa->hod_remarks;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }


        if (!empty($capa->hod_attachment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'HOD Attachment';
            $history->previous = "Null";
            $history->current = $capa->hod_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }


        if (!empty($capa->capa_qa_comments)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'CAPA QA Review';
            $history->previous = "Null";
            $history->current = $capa->capa_qa_comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($capa->qa_attachment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'QA Attachment';
            $history->previous = "Null";
            $history->current = $capa->qa_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }


        if (!empty($capa->qa_review)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'QA Head Review & Closure';
            $history->previous = "Null";
            $history->current = $capa->qa_review;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($capa->closure_attachment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Closure Attachment';
            $history->previous = "Null";
            $history->current = $capa->closure_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($capa->due_date_extension)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Due Date Extension Justification';
            $history->previous = "Null";
            $history->current = $capa->due_date_extension;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        ///////////////// HOD final Review////////////////////


        if (!empty($capa->hod_final_review)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'HOD Final Review Comment';
            $history->previous = "Null";
            $history->current = $capa->hod_final_review;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }
        if (!empty($capa->qa_approval_review)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'QA/CQA  Approval Comment';
            $history->previous = "Null";
            $history->current = $capa->qa_approval_review;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }
        if (!empty($capa->hod_final_attachment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'HOD Final Attachment';
            $history->previous = "Null";
            $history->current = $capa->hod_final_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }
        if (!empty($capa->qa_approval_review)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'QA/CQA  Approval Attachment';
            $history->previous = "Null";
            $history->current = $capa->qa_approval_review;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        ///////////////// QA/CQA Closure Review////////////////////

        if (!empty($capa->qa_cqa_qa_comments)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'QA/CQA Closure Review Comment';
            $history->previous = "Null";
            $history->current = $capa->qa_cqa_qa_comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($capa->qa_closure_attachment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'QA/CQA Closure Review Attachment';
            $history->previous = "Null";
            $history->current = $capa->qa_closure_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }
        

        ///////////////////////// QAH/CQAH Approval /////////////////////

        if (!empty($capa->qah_cq_comments)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'QAH/CQAH Approval Comment';
            $history->previous = "Null";
            $history->current = $capa->qah_cq_comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($capa->qah_cq_attachment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'QAH/CQAH Approval Attachment';
            $history->previous = "Null";
            $history->current = $capa->qah_cq_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }
       
        /////////////////////// Below This All Are Extra ///////////////////////

        // if (!empty($capa->capa_qa_comments2)) {
        //     $history = new CapaAuditTrial();
        //     $history->capa_id = $capa->id;
        //     $history->activity_type = 'CAPA QA Comments';
        //     $history->previous = "Null";
        //     $history->current = $capa->capa_qa_comments2;
        //     $history->comment = "Not Applicable";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $capa->status;
        //      $history->change_to = "Opened";
        //     $history->change_from = "Initiation";
        //     $history->action_name = "Create";
        //     $history->save();
        // }

        // if (!empty($capa->details)) {
        //     $history = new CapaAuditTrial();
        //     $history->capa_id = $capa->id;
        //     $history->activity_type = 'Details';
        //     $history->previous = "Null";
        //     $history->current = $capa->details;
        //     $history->comment = "Not Applicable";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $capa->status;
        //     $history->save();
        // }

        if (!empty($capa->project_details_application)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Project Datails Application';
            $history->previous = "Null";
            $history->current = $capa->project_details_application;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($capa->project_initiator_group)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Initiator Group';
            $history->previous = "Null";
            $history->current = $capa->project_initiator_group;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($capa->site_number)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Site Number';
            $history->previous = "Null";
            $history->current = $capa->site_number;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($capa->subject_number)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Subject Number';
            $history->previous = "Null";
            $history->current = $capa->subject_number;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($capa->subject_initials)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Subject Initials';
            $history->previous = "Null";
            $history->current = $capa->subject_initials;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($capa->supervisor_review_comments)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Supervisor Review Comments';
            $history->previous = "Null";
            $history->current = $capa->supervisor_review_comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($capa->effectiveness)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Effectiveness Check required';
            $history->previous = "Null";
            $history->current = $capa->effectiveness;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($capa->effect_check_date)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $capa->id;
            $history->activity_type = 'Effect.Check Creation Date';
            $history->previous = "Null";
            $history->current = $capa->effect_check_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $capa->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = "Create";
            $history->save();
        }



        // if (!empty($capa->capa_type)) {
        //     $history = new CapaAuditTrial();
        //     $history->capa_id = $capa->id;
        //     $history->activity_type = 'Capa Type';
        //     $history->previous = "Null";
        //     $history->current = $capa->capa_type;
        //     $history->comment = "Not Applicable";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $capa->status;
        //      $history->change_to = "Opened";
        //     $history->change_from = "Initiation";
        //     $history->action_name = "Create";
        //     $history->save();
        // }



        // DocumentService::update_qms_numbers();

        toastr()->success("Record is created Successfully");
        return redirect(url('rcms/qms-dashboard'));
    }
    public function capaUpdate(Request $request, $id)
    {
        if (!$request->short_description) {
            toastr()->error("Short description is required");
            return redirect()->back();
        }
        $lastDocument = Capa::find($id);
        $capa = Capa::find($id);
        $lastDocCft = CapaCft::where('capa_id', $id)->first();
        $cc_cfts = CapaCft::find($id);
        $lastCft = CapaCft::where('capa_id', $capa->id)->first();
        // $review = Qareview::where('capa_id', $capa->id)->first();
        $Cft = CapaCft::where('capa_id', $id)->first();

        $getId = $lastDocument->capa_team;
        $lastcapa_teamIdsArray = explode(',', $getId);
        $lastcapa_teamNames = User::whereIn('id', $lastcapa_teamIdsArray)->pluck('name')->toArray();
        $lastcapa_teamName = implode(', ', $lastcapa_teamNames);

        // $capa->parent_id = $request->parent_id;
        // $capa->parent_type = $request->parent_type;
        // $capa->division_code = $request->division_code;
        // $capa->intiation_date= $request->intiation_date;
        $capa->general_initiator_group = $request->initiator_group;
        $capa->short_description = $request->short_description;
        $capa->priority_data = $request->priority_data;
        $capa->problem_description = $request->problem_description;
        $capa->due_date = $request->due_date;
        $capa->assign_to = $request->assign_to;
        $capa->product_name = $request->product_name;
        $capa->capa_source_number = $request->capa_source_number;
        //  $capa->capa_team = $request->capa_team;
        // $capa->capa_team = implode(',', $request->capa_team);

        $capa->capa_team =  implode(',', $request->capa_team);
        $capa_teamIdsArray = explode(',', $capa->capa_team);
        $capa_teamNames = User::whereIn('id', $capa_teamIdsArray)->pluck('name')->toArray();
        $capa_teamNamesString = implode(', ', $capa_teamNames);
        
        $capa->Post_Categorization = $request->Post_Categorization;
        $capa->Initial_Categorization = $request->Initial_Categorization;

        $capa->capa_type = $request->capa_type;
        $capa->details_new = $request->details_new;
        $capa->initiated_through = $request->initiated_through;
        $capa->initiated_through_req = $request->initiated_through_req;
        $capa->repeat = $request->repeat;
        $capa->initiator_Group = Helpers::getInitiatorGroupFullName($request->initiator_group_code);
        // dd($capa->initiator_Group);
        $capa->initiator_group_code = $request->initiator_group_code;
        $capa->severity_level_form = $request->severity_level_form;
        $capa->cft_comments_form = $request->cft_comments_form;
        $capa->qa_comments_new = $request->qa_comments_new;
        $capa->designee_comments_new = $request->designee_comments_new;
        $capa->Warehouse_comments_new = $request->Warehouse_comments_new;
        $capa->Engineering_comments_new = $request->Engineering_comments_new;
        $capa->Instrumentation_comments_new = $request->Instrumentation_comments_new;
        $capa->Validation_comments_new = $request->Validation_comments_new;
        $capa->Others_comments_new = $request->Others_comments_new;
        $capa->Quality_Approver = $request->Quality_Approver;
        $capa->Quality_Approver_Person = $request->Quality_Approver_Person;
        $capa->Production_new = $request->Production_new;
        $capa->Group_comments_new = $request->Group_comments_new;
        //    $capa->cft_attchament_new = json_encode($request->cft_attchament_new);
        //    $capa->group_attachments_new = json_encode($request->group_attachments_new);
        $capa->repeat_nature = $request->repeat_nature;
        $capa->Effectiveness_checker = $request->Effectiveness_checker;
        $capa->effective_check_plan = $request->effective_check_plan;
        $capa->due_date_extension = $request->due_date_extension;
        $capa->capa_related_record =  implode(',', $request->capa_related_record);
        // $capa->reference_record = $request->reference_record;
        $capa->Microbiology_new = $request->Microbiology_new;
        $capa->goup_review = $request->goup_review;
        $capa->initial_observation = $request->initial_observation;

        $capa->interim_containnment = $request->interim_containnment;
        $capa->containment_comments = $request->containment_comments;

        $capa->capa_qa_comments = $request->capa_qa_comments;
        $capa->capa_qa_comments2 = $request->capa_qa_comments2;
        // $capa->details = $request->details;
        $capa->project_details_application = $request->project_details_application;
        $capa->project_initiator_group = $request->project_initiator_group;
        $capa->site_number = $request->site_number;
        $capa->subject_number = $request->subject_number;
        $capa->subject_initials = $request->subject_initials;
        $capa->sponsor = $request->sponsor;
        $capa->general_deviation = $request->general_deviation;
        $capa->corrective_action = $request->corrective_action;
        $capa->preventive_action = $request->preventive_action;
        $capa->supervisor_review_comments = $request->supervisor_review_comments;
        $capa->qa_review = $request->qa_review;
        $capa->effectiveness = $request->effectiveness;
        $capa->effect_check = $request->effect_check;
        $capa->effect_check_date = $request->effect_check_date;
        $capa->bd_domestic = $request->bd_domestic;
        $capa->Bd_Person = $request->Bd_Person;
        $capa->Production_Person = $request->Production_Person;
        $capa->hod_remarks = $request->hod_remarks;
        $capa->hod_final_review = $request->hod_final_review;
        $capa->qa_approval_review = $request->qa_approval_review;
        $capa->qa_cqa_qa_comments = $request->qa_cqa_qa_comments;
        $capa->qah_cq_comments = $request->qah_cq_comments;
        //    $capa->hod_attachment = $request->hod_attachment;
        //    $capa->qa_attachment = $request->qa_attachment;
        //    $capa->capafileattachement = $request->capafileattachement;    
        $capa->investigation = $request->investigation;
        $capa->rcadetails = $request->rcadetails;



        if (!empty($request->capa_attachment)) {
            $files = [];
            if ($request->hasfile('capa_attachment')) {
                foreach ($request->file('capa_attachment') as $file) {
                    $name = $request->name . 'capa_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $capa->capa_attachment = json_encode($files);
        }

        if (!empty($request->hod_attachment)) {
            $files = [];
            if ($request->hasfile('hod_attachment')) {
                foreach ($request->file('hod_attachment') as $file) {
                    $name = $request->name . 'hod_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $capa->hod_attachment = json_encode($files);
        }
        if (!empty($request->qa_attachment)) {
            $files = [];
            if ($request->hasfile('qa_attachment')) {
                foreach ($request->file('qa_attachment') as $file) {
                    $name = $request->name . 'qa_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $capa->qa_attachment = json_encode($files);
        }
        if (!empty($request->capafileattachement)) {
            $files = [];
            if ($request->hasfile('capafileattachement')) {
                foreach ($request->file('capafileattachement') as $file) {
                    $name = $request->name . 'capafileattachement' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $capa->capafileattachement = json_encode($files);
        }


        if (!empty($request->closure_attachment)) {
            $files = [];
            if ($request->hasfile('closure_attachment')) {
                foreach ($request->file('closure_attachment') as $file) {
                    $name = $request->name . 'closure_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $capa->closure_attachment = json_encode($files);
        }
        if (!empty($request->hod_final_attachment)) {
            $files = [];
            if ($request->hasfile('hod_final_attachment')) {
                foreach ($request->file('hod_final_attachment') as $file) {
                    $name = $request->name . 'hod_final_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $capa->hod_final_attachment = json_encode($files);
        }
        if (!empty($request->qa_approval_attachment)) {
            $files = [];
            if ($request->hasfile('qa_approval_attachment')) {
                foreach ($request->file('qa_approval_attachment') as $file) {
                    $name = $request->name . 'qa_approval_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $capa->qa_approval_attachment = json_encode($files);
        }
        
        if (!empty($request->qa_closure_attachment)) {
            $files = [];
            if ($request->hasfile('qa_closure_attachment')) {
                foreach ($request->file('qa_closure_attachment') as $file) {
                    $name = $request->name . 'qa_closure_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $capa->qa_closure_attachment = json_encode($files);
        }
        if (!empty($request->qah_cq_attachment)) {
            $files = [];
            if ($request->hasfile('qah_cq_attachment')) {
                foreach ($request->file('qah_cq_attachment') as $file) {
                    $name = $request->name . 'qah_cq_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $capa->qah_cq_attachment = json_encode($files);
        }
        $capa->update();


        // -----------------------grid--------------------
        if ($request->product_name) {
            $data1 = CapaGrid::where('capa_id', $id)->where('type', "Product_Details")->first();
            $data1->capa_id = $capa->id;
            $data1->type = "Product_Details";
            if (!empty($request->product_name)) {
                $data1->product_name = serialize($request->product_name);
            }
            if (!empty($request->product_batch_no)) {
                $data1->batch_no = serialize($request->product_batch_no);
            }
            if (!empty($request->mfg_date)) {
                $data1->mfg_date = serialize($request->mfg_date);
            }
            if (!empty($request->product_expiry_date)) {
                $data1->expiry_date = serialize($request->product_expiry_date);
            }
            if (!empty($request->product_batch_desposition)) {
                $data1->batch_desposition = serialize($request->product_batch_desposition);
            }

            if (!empty($request->product_remark)) {
                $data1->remark = serialize($request->product_remark);
            }
            if (!empty($request->product_batch_status)) {
                $data1->batch_status = serialize($request->product_batch_status);
            }
            $data1->update();
        }

        // // --------------------------

        if ($request->material_name) {
            $data2 = CapaGrid::where('type', 'Material_Details')->where('capa_id', $id)->first();
            if (empty($data2)) {
                $data2 = new CapaGrid();
            }

            $data2->capa_id = $capa->id;
            $data2->type = "Material_Details";
            if (!empty($request->material_name)) {
                $data2->material_name = serialize($request->material_name);
            }
            if (!empty($request->material_batch_no)) {
                $data2->material_batch_no = serialize($request->material_batch_no);
            }

            if (!empty($request->material_mfg_date)) {
                $data2->material_mfg_date = serialize($request->material_mfg_date);
            }
            if (!empty($request->material_expiry_date)) {
                $data2->material_expiry_date = serialize($request->material_expiry_date);
            }
            if (!empty($request->material_batch_desposition)) {
                $data2->material_batch_desposition = serialize($request->material_batch_desposition);
            }
            if (!empty($request->material_remark)) {
                $data2->material_remark = serialize($request->material_remark);
            }
            if (!empty($request->material_batch_status)) {
                $data2->material_batch_status = serialize($request->material_batch_status);
            }


            $data2->update();
        }

        // // ----------------------------------------
        if ($request->equipment) {
            $data3 = CapaGrid::where('capa_id', $id)->where('type', "Instruments_Details")->first();
            $data3->capa_id = $capa->id;
            $data3->type = "Instruments_Details";
            if (!empty($request->equipment)) {
                $data3->equipment = serialize($request->equipment);
            }
            if (!empty($request->equipment_instruments)) {
                $data3->equipment_instruments = serialize($request->equipment_instruments);
            }
            if (!empty($request->equipment_comments)) {
                $data3->equipment_comments = serialize($request->equipment_comments);
            }
        }
        $data3->save();
        $capa->update();

        if($capa->stage == 3 || $capa->stage == 4 ){

            $Cft = CapaCft::withoutTrashed()->where('capa_id', $id)->first();
            if($Cft && $capa->stage == 4 ){
                $Cft->Production_Review = $request->Production_Review == null ? $Cft->Production_Review : $request->Production_Review;
                $Cft->Production_person = $request->Production_person == null ? $Cft->Production_person : $request->Production_person;
                
                $Cft->Quality_review = $request->Quality_review == null ? $Cft->Quality_review : $request->Quality_review;
                $Cft->Quality_Control_Person = $request->Quality_Control_Person == null ? $Cft->Quality_Control_Person : $request->Quality_Control_Person;

                $Cft->Warehouse_review = $request->Warehouse_review == null ? $Cft->Warehouse_review : $request->Warehouse_review;
                $Cft->Warehouse_person = $request->Warehouse_person == null ? $Cft->Warehouse_person : $request->Warehouse_person;
                
                $Cft->Engineering_review = $request->Engineering_review == null ? $Cft->Engineering_review : $request->Engineering_review;
                $Cft->Engineering_person = $request->Engineering_person == null ? $Cft->Engineering_person : $request->Engineering_person;

                $Cft->ResearchDevelopment_Review = $request->ResearchDevelopment_Review == null ? $Cft->ResearchDevelopment_Review : $request->ResearchDevelopment_Review;
                $Cft->ResearchDevelopment_person = $request->ResearchDevelopment_person == null ? $Cft->ResearchDevelopment_person : $request->ResearchDevelopment_person;

                $Cft->RegulatoryAffair_Review = $request->RegulatoryAffair_Review == null ? $Cft->RegulatoryAffair_Review : $request->RegulatoryAffair_Review;
                $Cft->RegulatoryAffair_person = $request->RegulatoryAffair_person == null ? $Cft->RegulatoryAffair_person : $request->RegulatoryAffair_person;

                $Cft->CQA_Review = $request->CQA_Review == null ? $Cft->CQA_Review : $request->CQA_Review;
                $Cft->CQA_person = $request->CQA_person == null ? $Cft->CQA_person : $request->CQA_person;

                $Cft->Microbiology_Review = $request->Microbiology_Review == null ? $Cft->Microbiology_Review : $request->Microbiology_Review;
                $Cft->Microbiology_person = $request->Microbiology_person == null ? $Cft->Microbiology_person : $request->Microbiology_person;

                $Cft->SystemIT_Review = $request->SystemIT_Review == null ? $Cft->SystemIT_Review : $request->SystemIT_Review;
                $Cft->SystemIT_person = $request->SystemIT_person == null ? $Cft->SystemIT_person : $request->SystemIT_person;
                
                $Cft->Quality_Assurance_Review = $request->Quality_Assurance_Review == null ? $Cft->Quality_Assurance_Review : $request->Quality_Assurance_Review;
                $Cft->QualityAssurance_person = $request->QualityAssurance_person == null ? $Cft->QualityAssurance_person : $request->QualityAssurance_person;

                $Cft->Human_Resource_review = $request->Human_Resource_review == null ? $Cft->Human_Resource_review : $request->Human_Resource_review;
                $Cft->Human_Resource_person = $request->Human_Resource_person == null ? $Cft->Human_Resource_person : $request->Human_Resource_person;
                
                $Cft->Other1_review = $request->Other1_review  == null ? $Cft->Other1_review : $request->Other1_review;
                $Cft->Other1_person = $request->Other1_person  == null ? $Cft->Other1_person : $request->Other1_person;
                $Cft->Other1_Department_person = $request->Other1_Department_person  == null ? $Cft->Other1_Department_person : $request->Other1_Department_person;

                // $Cft->Other2_review = $request->Other2_review  == null ? $Cft->Other2_review : $request->Other2_review;
                // $Cft->Other2_person = $request->Other2_person  == null ? $Cft->Other2_person : $request->Other2_person;
                // $Cft->Other2_Department_person = $request->Other2_Department_person  == null ? $Cft->Other2_Department_person : $request->Other2_Department_person;

                // $Cft->Other3_review = $request->Other3_review  == null ? $Cft->Other3_review : $request->Other3_review;
                // $Cft->Other3_person = $request->Other3_person  == null ? $Cft->Other3_person : $request->Other3_person;
                // $Cft->Other3_Department_person = $request->Other3_Department_person  == null ? $Cft->Other3_Department_person : $request->Other3_Department_person;
                
                // $Cft->Other4_review = $request->Other4_review  == null ? $Cft->Other4_review : $request->Other4_review;
                // $Cft->Other4_person = $request->Other4_person  == null ? $Cft->Other4_person : $request->Other4_person;
                // $Cft->Other4_Department_person = $request->Other4_Department_person  == null ? $Cft->Other4_Department_person : $request->Other4_Department_person;

                // $Cft->Other5_review = $request->Other5_review  == null ? $Cft->Other5_review : $request->Other5_review;
                // $Cft->Other5_person = $request->Other5_person  == null ? $Cft->Other5_person : $request->Other5_person;
                // $Cft->Other5_Department_person = $request->Other5_Department_person  == null ? $Cft->Other5_Department_person : $request->Other5_Department_person;

            }
            else{
                $Cft->Production_Review = $request->Production_Review;
                $Cft->Production_person = $request->Production_person;

                $Cft->Warehouse_review = $request->Warehouse_review;
                $Cft->Warehouse_person = $request->Warehouse_person;

                $Cft->Quality_review = $request->Quality_review;
                $Cft->Quality_Control_Person = $request->Quality_Control_Person;
                
                $Cft->Engineering_review = $request->Engineering_review;
                $Cft->Engineering_person = $request->Engineering_person;

                $Cft->ResearchDevelopment_Review = $request->ResearchDevelopment_Review;
                $Cft->ResearchDevelopment_person = $request->ResearchDevelopment_person;

                $Cft->RegulatoryAffair_Review = $request->RegulatoryAffair_Review;
                $Cft->RegulatoryAffair_person = $request->RegulatoryAffair_person;

                $Cft->CQA_Review = $request->CQA_Review;
                $Cft->CQA_person = $request->CQA_person;

                $Cft->Microbiology_Review = $request->Microbiology_Review;
                $Cft->Microbiology_person = $request->Microbiology_person;

                $Cft->SystemIT_Review = $request->SystemIT_Review;
                $Cft->SystemIT_person = $request->SystemIT_person;
                
                $Cft->Quality_Assurance_Review = $request->Quality_Assurance_Review;
                $Cft->QualityAssurance_person = $request->QualityAssurance_person;

                $Cft->Human_Resource_review = $request->Human_Resource_review;
                $Cft->Human_Resource_person = $request->Human_Resource_person;
                
                $Cft->Other1_review = $request->Other1_review;
                $Cft->Other1_person = $request->Other1_person;
                $Cft->Other1_Department_person = $request->Other1_Department_person;

                // $Cft->Other2_review = $request->Other2_review;
                // $Cft->Other2_person = $request->Other2_person;
                // $Cft->Other2_Department_person = $request->Other2_Department_person;

                // $Cft->Other3_review = $request->Other3_review;
                // $Cft->Other3_person = $request->Other3_person;
                // $Cft->Other3_Department_person = $request->Other3_Department_person;
                
                // $Cft->Other4_review = $request->Other4_review;
                // $Cft->Other4_person = $request->Other4_person;
                // $Cft->Other4_Department_person = $request->Other4_Department_person;

                // $Cft->Other5_review = $request->Other5_review;
                // $Cft->Other5_person = $request->Other5_person;
                // $Cft->Other5_Department_person = $request->Other5_Department_person;

            }
        
            $Cft->Production_assessment = $request->Production_assessment;
            $Cft->Production_feedback = $request->Production_feedback;

            $Cft->Quality_Control_assessment = $request->Quality_Control_assessment;
            $Cft->Quality_Control_feedback = $request->Quality_Control_feedback;

            $Cft->Warehouse_assessment = $request->Warehouse_assessment;
            $Cft->Warehouse_feedback = $request->Warehouse_feedback;

            $Cft->Engineering_assessment = $request->Engineering_assessment;
            $Cft->Engineering_feedback = $request->Engineering_feedback;

            $Cft->ResearchDevelopment_assessment = $request->ResearchDevelopment_assessment;
            $Cft->ResearchDevelopment_feedback = $request->ResearchDevelopment_feedback;

            $Cft->RegulatoryAffair_assessment = $request->RegulatoryAffair_assessment;
            $Cft->RegulatoryAffair_feedback = $request->RegulatoryAffair_feedback;

            $Cft->CorporateQualityAssurance_assessment = $request->CorporateQualityAssurance_assessment;
            $Cft->CorporateQualityAssurance_feedback = $request->CorporateQualityAssurance_feedback;

            $Cft->Microbiology_assessment = $request->Microbiology_assessment;
            $Cft->Microbiology_feedback = $request->Microbiology_feedback;

            $Cft->SystemIT_comment = $request->SystemIT_comment;

            $Cft->QualityAssurance_assessment = $request->QualityAssurance_assessment;
            $Cft->QualityAssurance_feedback = $request->QualityAssurance_feedback;

            $Cft->Human_Resource_assessment = $request->Human_Resource_assessment;
            $Cft->Human_Resource_feedback = $request->Human_Resource_feedback;
            
            $Cft->Other1_Department_person = $request->Other1_Department_person;
            $Cft->Other1_assessment = $request->Other1_assessment;

            // $Cft->Other2_Department_person = $request->Other2_Department_person;
            // $Cft->Other2_Assessment = $request->Other2_Assessment;

            // $Cft->Other3_Department_person = $request->Other3_Department_person;
            // $Cft->Other3_Assessment = $request->Other3_Assessment;

            // $Cft->Other4_Department_person = $request->Other4_Department_person;
            // $Cft->Other4_Assessment = $request->Other4_Assessment;

            // $Cft->Other5_Department_person = $request->Other5_Department_person;
            // $Cft->Other5_Assessment = $request->Other5_Assessment;


            if (!empty ($request->production_attachment)) {
                $files = [];
                if ($request->hasfile('production_attachment')) {
                    foreach ($request->file('production_attachment') as $file) {
                        $name = $request->name . 'production_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $Cft->production_attachment = json_encode($files);
            }
            
            if (!empty ($request->Quality_Control_attachment)) {
                $files = [];
                if ($request->hasfile('Quality_Control_attachment')) {
                    foreach ($request->file('Quality_Control_attachment') as $file) {
                        $name = $request->name . 'Quality_Control_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $Cft->Quality_Control_attachment = json_encode($files);
            }

            if (!empty ($request->Warehouse_attachment)) {
                $files = [];
                if ($request->hasfile('Warehouse_attachment')) {
                    foreach ($request->file('Warehouse_attachment') as $file) {
                        $name = $request->name . 'Warehouse_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $Cft->Warehouse_attachment = json_encode($files);
            }
            if (!empty ($request->Engineering_attachment)) {
                $files = [];
                if ($request->hasfile('Engineering_attachment')) {
                    foreach ($request->file('Engineering_attachment') as $file) {
                        $name = $request->name . 'Engineering_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $Cft->Engineering_attachment = json_encode($files);
            }

            if (!empty ($request->ResearchDevelopment_attachment)) {
                $files = [];
                if ($request->hasfile('ResearchDevelopment_attachment')) {
                    foreach ($request->file('ResearchDevelopment_attachment') as $file) {
                        $name = $request->name . 'ResearchDevelopment_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $Cft->ResearchDevelopment_attachment = json_encode($files);
            }   

            if (!empty ($request->RegulatoryAffair_attachment)) {
                $files = [];
                if ($request->hasfile('RegulatoryAffair_attachment')) {
                    foreach ($request->file('RegulatoryAffair_attachment') as $file) {
                        $name = $request->name . 'RegulatoryAffair_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $Cft->RegulatoryAffair_attachment = json_encode($files);
            }

            if (!empty ($request->CQA_attachment)) {
                $files = [];
                if ($request->hasfile('CQA_attachment')) {
                    foreach ($request->file('CQA_attachment') as $file) {
                        $name = $request->name . 'CQA_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $Cft->CQA_attachment = json_encode($files);
            }

            if (!empty ($request->Microbiology_attachment)) {
                $files = [];
                if ($request->hasfile('Microbiology_attachment')) {
                    foreach ($request->file('Microbiology_attachment') as $file) {
                        $name = $request->name . 'Microbiology_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $Cft->Microbiology_attachment = json_encode($files);
            }

            if (!empty ($request->Quality_Assurance_attachment)) {
                $files = [];
                if ($request->hasfile('Quality_Assurance_attachment')) {
                    foreach ($request->file('Quality_Assurance_attachment') as $file) {
                        $name = $request->name . 'Quality_Assurance_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $Cft->Quality_Assurance_attachment = json_encode($files);
            }

            if (!empty ($request->SystemIT_attachment)) {
                $files = [];
                if ($request->hasfile('SystemIT_attachment')) {
                    foreach ($request->file('SystemIT_attachment') as $file) {
                        $name = $request->name . 'SystemIT_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $Cft->SystemIT_attachment = json_encode($files);
            }

            if (!empty ($request->Human_Resource_attachment)) {
                $files = [];
                if ($request->hasfile('Human_Resource_attachment')) {
                    foreach ($request->file('Human_Resource_attachment') as $file) {
                        $name = $request->name . 'Human_Resource_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $Cft->Human_Resource_attachment = json_encode($files);
            }

            if (!empty ($request->Other1_attachment)) {
                $files = [];
                if ($request->hasfile('Other1_attachment')) {
                    foreach ($request->file('Other1_attachment') as $file) {
                        $name = $request->name . 'Other1_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $Cft->Other1_attachment = json_encode($files);
            }

            // if (!empty ($request->Other2_attachment)) {
            //     $files = [];
            //     if ($request->hasfile('Other2_attachment')) {
            //         foreach ($request->file('Other2_attachment') as $file) {
            //             $name = $request->name . 'Other2_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
            //             $file->move('upload/', $name);
            //             $files[] = $name;
            //         }
            //     }
            //     $Cft->Other2_attachment = json_encode($files);
            // }

            // if (!empty ($request->Other3_attachment)) {
            //     $files = [];
            //     if ($request->hasfile('Other3_attachment')) {
            //         foreach ($request->file('Other3_attachment') as $file) {
            //             $name = $request->name . 'Other3_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
            //             $file->move('upload/', $name);
            //             $files[] = $name;
            //         }
            //     }
            //     $Cft->Other3_attachment = json_encode($files);
            // }

            // if (!empty ($request->Other4_attachment)) {
            //     $files = [];
            //     if ($request->hasfile('Other4_attachment')) {
            //         foreach ($request->file('Other4_attachment') as $file) {
            //             $name = $request->name . 'Other4_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
            //             $file->move('upload/', $name);
            //             $files[] = $name;
            //         }
            //     }

            //     $Cft->Other4_attachment = json_encode($files);
            // }

            // if (!empty ($request->Other5_attachment)) {
            //     $files = [];
            //     if ($request->hasfile('Other5_attachment')) {
            //         foreach ($request->file('Other5_attachment') as $file) {
            //             $name = $request->name . 'Other5_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
            //             $file->move('upload/', $name);
            //             $files[] = $name;
            //         }
            //     }
            //     $Cft->Other5_attachment = json_encode($files);
            // }
            $Cft->save();


            $IsCFTRequired = CapaCftResponse::withoutTrashed()->where(['is_required' => 1, 'capa_id' => $id])->latest()->first();
            $cftUsers = DB::table('capa_cfts')->where(['capa_id' => $id])->first();
            $columns = ['Production_person', 'Quality_Control_Person', 'Warehouse_person', 'Engineering_person', 'ResearchDevelopment_person', 'RegulatoryAffair_person', 'CQA_person', 'Microbiology_person', 'QualityAssurance_person','SystemIT_person', 'Human_Resource_person','Other1_person','Other2_person'];
            $valuesArray = [];
            foreach ($columns as $index => $column) {
                $value = $cftUsers->$column;
                if ($value != null && $value != 0) {
                    $valuesArray[] = $value;
                }
            }
            
            $valuesArray = array_unique($valuesArray);
            // Convert the array to a re-indexed array
            $valuesArray = array_values($valuesArray);
            // foreach ($valuesArray as $u) {
            //         $email = Helpers::getInitiatorEmail($u);
            //         if ($email !== null) {
            //             try {
            //                 Mail::send(
            //                     'mail.view-mail',
            //                     ['data' => $deviation],
            //                     function ($message) use ($email) {
            //                         $message->to($email)
            //                             ->subject("CFT Assgineed by " . Auth::user()->name);
            //                     }
            //                 );
            //             } catch (\Exception $e) {
            //             }
            //     }
            // }
        }
        // cft end

        if ($lastDocument->assign_to != $capa->assign_to || !empty($request->assign_to_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Assigned To';
            $history->previous = Helpers::getInitiatorName($lastDocument->assign_to);
            $history->current = Helpers::getInitiatorName($capa->assign_to);
            $history->comment = $request->assign_to_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->assign_to) || $lastDocument->assign_to === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        // dd($request->initiator_group);
        if ($lastDocument->initiator_group_code != $capa->initiator_group_code) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Department Group';
            $history->previous = Helpers::getInitiatorGroupFullName($lastDocument->initiator_group_code);
            $history->current = Helpers::getInitiatorGroupFullName($capa->initiator_group_code);
            $history->comment = $request->initiator_Group_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->initiator_group_code) || $lastDocument->initiator_group_code === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }
        if ($lastDocument->initiator_group_code != $capa->initiator_group_code || !empty($request->initiator_group_code_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Department Group code';
            $history->previous = $lastDocument->initiator_group_code;
            $history->current = $capa->initiator_group_code;
            $history->comment = $request->initiator_group_code_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->initiator_group_code) || $lastDocument->initiator_group_code === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }


        if ($lastDocument->short_description != $capa->short_description || !empty($request->short_description_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Short Description';
            $history->previous = $lastDocument->short_description;
            $history->current = $capa->short_description;
            $history->comment = $request->short_description_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->short_description) || $lastDocument->short_description === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        if ($lastDocument->priority_data != $capa->priority_data || !empty($request->priority_data_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Priority';
            $history->previous = $lastDocument->priority_data;
            $history->current = $capa->priority_data;
            $history->comment = $request->priority_data_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->priority_data) || $lastDocument->priority_data === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        if ($lastDocument->product_name != $capa->product_name || !empty($request->product_name_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Product Name';
            $history->previous = $lastDocument->product_name;
            $history->current = $capa->product_name;
            $history->comment = $request->product_name_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->product_name) || $lastDocument->product_name === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        if ($lastDocument->capa_source_number != $capa->capa_source_number || !empty($request->capa_source_number_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'CAPA Source & Number';
            $history->previous = $lastDocument->capa_source_number;
            $history->current = $capa->capa_source_number;
            $history->comment = $request->capa_source_number_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->capa_source_number) || $lastDocument->capa_source_number === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        if ($lastDocument->initiated_through != $capa->initiated_through) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Initiated Through';
            $history->previous = $lastDocument->initiated_through;
            $history->current = $capa->initiated_through;
            $history->comment = $request->initiated_through_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->initiated_through) || $lastDocument->initiated_through === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        if ($lastDocument->initiated_through_req != $capa->initiated_through_req) {

            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Others';
            $history->previous = $lastDocument->initiated_through_req;
            $history->current = $capa->initiated_through_req;
            $history->comment = $request->initiated_through_req_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->initiated_through_req) || $lastDocument->initiated_through_req === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->repeat != $capa->repeat) {

            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Repeat';
            $history->previous = $lastDocument->repeat;
            $history->current = $capa->repeat;
            $history->comment = $request->repeat_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->repeat) || $lastDocument->repeat === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->repeat_nature != $capa->repeat_nature) {

            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Repeat Nature';
            $history->previous = $lastDocument->repeat_nature;
            $history->current = $capa->repeat_nature;
            $history->comment = $request->repeat_nature_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->repeat_nature) || $lastDocument->repeat_nature === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->problem_description != $capa->problem_description || !empty($request->problem_description_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Problem Description';
            $history->previous = $lastDocument->problem_description;
            $history->current = $capa->problem_description;
            $history->comment = $request->problem_description_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->problem_description) || $lastDocument->problem_description === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        if ($lastDocument->capa_team != $capa->capa_team || !empty($request->capa_team_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'CAPA Team';
            $history->previous = $lastcapa_teamName;
            $history->current = $capa_teamNamesString;
            $history->comment = $request->capa_team_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->capa_team) || $lastDocument->capa_team === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        if ($lastDocument->capa_related_record != $capa->capa_related_record || !empty($request->capa_related_record_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Reference Records';
            $history->previous = $lastDocument->capa_related_record;
            $history->current = $capa->capa_related_record;
            $history->comment = $request->capa_related_record_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->capa_related_record) || $lastDocument->capa_related_record === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        if ($lastDocument->initial_observation != $capa->initial_observation || !empty($request->initial_observation_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Initial Observation';
            $history->previous = $lastDocument->initial_observation;
            $history->current = $capa->initial_observation;
            $history->comment = $request->initial_observation_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            if (is_null($lastDocument->initial_observation) || $lastDocument->initial_observation === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        if ($lastDocument->interim_containnment != $capa->interim_containnment || !empty($request->interim_containnment_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Interim Containnment';
            $history->previous = $lastDocument->interim_containnment;
            $history->current = $capa->interim_containnment;
            $history->comment = $request->interim_containnment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            if (is_null($lastDocument->interim_containnment) || $lastDocument->interim_containnment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        if ($lastDocument->containment_comments != $capa->containment_comments || !empty($request->containment_comments_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Containment Comments';
            $history->previous = $lastDocument->containment_comments;
            $history->current = $capa->containment_comments;
            $history->comment = $request->containment_comments_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->containment_comments) || $lastDocument->containment_comments === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        if ($lastDocument->capa_attachment != $capa->capa_attachment || !empty($request->capa_attachment_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'CAPA Attachment';
            $history->previous = $lastDocument->capa_attachment;
            $history->current = $capa->capa_attachment;
            $history->comment = $request->capa_attachment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            if (is_null($lastDocument->capa_attachment) || $lastDocument->capa_attachment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        if ($lastDocument->investigation != $capa->investigation) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Investigation';
            $history->previous = $lastDocument->investigation;
            $history->current = $capa->investigation;
            $history->comment = $request->investigation_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->investigation) || $lastDocument->investigation === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        if ($lastDocument->rcadetails != $capa->rcadetails) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Root Cause Analysis';
            $history->previous = $lastDocument->rcadetails;
            $history->current = $capa->rcadetails;
            $history->comment = $request->rcadetails_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->rcadetails) || $lastDocument->rcadetails === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        /////////////////////// Equipment / MAterial Info///////////

        if ($lastDocument->severity_level_form != $capa->severity_level_form) {

            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Severity Level';
            $history->previous = $lastDocument->severity_level_form;
            $history->current = $capa->severity_level_form;
            $history->comment = $request->severity_level_form_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->severity_level_form) || $lastDocument->severity_level_form === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->details_new != $capa->details_new) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Details';
            $history->previous = $lastDocument->details_new;
            $history->current = $capa->details_new;
            $history->comment = $request->details_new_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            if (is_null($lastDocument->details_new) || $lastDocument->details_new === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        /////////////////////CAPA Details//////////////////////

        if ($lastDocument->capa_type != $capa->capa_type) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Capa Type';
            $history->previous = $lastDocument->capa_type;
            $history->current = $capa->capa_type;
            $history->comment = $request->capa_type_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            if (is_null($lastDocument->capa_type) || $lastDocument->capa_type === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        if ($lastDocument->corrective_action != $capa->corrective_action || !empty($request->corrective_action_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Corrective Action';
            $history->previous = $lastDocument->corrective_action;
            $history->current = $capa->corrective_action;
            $history->comment = $request->corrective_action_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->corrective_action) || $lastDocument->corrective_action === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        if ($lastDocument->preventive_action != $capa->preventive_action || !empty($request->preventive_action_comment)) {

            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Preventive Action';
            $history->previous = $lastDocument->preventive_action;
            $history->current = $capa->preventive_action;
            $history->comment = $request->preventive_action_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->preventive_action) || $lastDocument->preventive_action === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->capafileattachement != $capa->capafileattachement) {

            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'File Attachment';
            $history->previous = $lastDocument->capafileattachement;
            $history->current = $capa->capafileattachement;
            $history->comment = $request->capafileattachement_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->capafileattachement) || $lastDocument->capafileattachement === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        /////////////////////////HOD REview////////////////

        if ($lastDocument->hod_remarks != $capa->hod_remarks) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'HOD Remark';
            $history->previous = $lastDocument->hod_remarks;
            $history->current = $capa->hod_remarks;
            $history->comment = $request->hod_remarks_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->hod_remarks) || $lastDocument->hod_remarks === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        if ($lastDocument->hod_attachment != $capa->hod_attachment) {

            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'HOD Attachment';
            $history->previous = $lastDocument->hod_attachment;
            $history->current = $capa->hod_attachment;
            $history->comment = $request->hod_attachment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->hod_attachment) || $lastDocument->hod_attachment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->capa_qa_comments != $capa->capa_qa_comments || !empty($request->capa_qa_comments_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'CAPA QA Review';
            $history->previous = $lastDocument->capa_qa_comments;
            $history->current = $capa->capa_qa_comments;
            $history->comment = $request->capa_qa_comments_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            if (is_null($lastDocument->capa_qa_comments) || $lastDocument->capa_qa_comments === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        if ($lastDocument->qa_attachment != $capa->qa_attachment) {

            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'QA Attachment';
            $history->previous = $lastDocument->qa_attachment;
            $history->current = $capa->qa_attachment;
            $history->comment = $request->qa_attachment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->qa_attachment) || $lastDocument->qa_attachment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        ///////////////////////////////////CAPA Clousure///////////////

        if ($lastDocument->qa_review != $capa->qa_review || !empty($request->qa_review_comment)) {

            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'QA Head Review & Closure';
            $history->previous = $lastDocument->qa_review;
            $history->current = $capa->qa_review;
            $history->comment = $request->qa_review_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->qa_review) || $lastDocument->qa_review === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->closure_attachment != $capa->closure_attachment || !empty($request->closure_attachment_comment)) {

            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Closure Attachment';
            $history->previous = $lastDocument->closure_attachment;
            $history->current = $capa->closure_attachment;
            $history->comment = $request->closure_attachment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->closure_attachment) || $lastDocument->closure_attachment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->due_date_extension != $capa->due_date_extension || !empty($request->due_date_extension_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Due Date Extension Justification';
            $history->previous = $lastDocument->due_date_extension;
            $history->current = $capa->due_date_extension;
            $history->comment = $request->due_date_extension_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            if (is_null($lastDocument->due_date_extension) || $lastDocument->due_date_extension === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        /////////////////////HOD Final REview////////////////

        if ($lastDocument->hod_final_review != $capa->hod_final_review || !empty($request->hod_final_review_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'HOD Final Review Comment';
            $history->previous = $lastDocument->hod_final_review;
            $history->current = $capa->hod_final_review;
            $history->comment = $request->hod_final_review_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            if (is_null($lastDocument->hod_final_review) || $lastDocument->hod_final_review === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }
        if ($lastDocument->qa_approval_review != $capa->qa_approval_review || !empty($request->qa_approval_review_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'QA/CQA  Approval Comment';
            $history->previous = $lastDocument->qa_approval_review;
            $history->current = $capa->qa_approval_review;
            $history->comment = $request->qa_approval_review_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            if (is_null($lastDocument->qa_approval_review) || $lastDocument->qa_approval_review === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        if ($lastDocument->hod_final_attachment != $capa->hod_final_attachment || !empty($request->hod_final_attachment_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'HOD Final Attachment ';
            $history->previous = $lastDocument->hod_final_attachment;
            $history->current = $capa->hod_final_attachment;
            $history->comment = $request->hod_final_attachment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            if (is_null($lastDocument->hod_final_attachment) || $lastDocument->hod_final_attachment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }
       
        ////////////////QA/CQA Closure Review//////////////////

        if ($lastDocument->qa_cqa_qa_comments != $capa->qa_cqa_qa_comments || !empty($request->qa_cqa_qa_comments_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'QA/CQA Closure Review Comment';
            $history->previous = $lastDocument->qa_cqa_qa_comments;
            $history->current = $capa->qa_cqa_qa_comments;
            $history->comment = $request->qa_cqa_qa_comments_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            if (is_null($lastDocument->qa_cqa_qa_comments) || $lastDocument->qa_cqa_qa_comments === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        if ($lastDocument->qa_closure_attachment != $capa->qa_closure_attachment || !empty($request->qa_closure_attachment_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'QA/CQA Closure Review Attachment ';
            $history->previous = $lastDocument->qa_closure_attachment;
            $history->current = $capa->qa_closure_attachment;
            $history->comment = $request->qa_closure_attachment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            if (is_null($lastDocument->qa_closure_attachment) || $lastDocument->qa_closure_attachment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        ///////////////////////// QAH/CQAH Approval /////////////////////


        if ($lastDocument->qah_cq_comments != $capa->qah_cq_comments || !empty($request->qah_cq_comments_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'QAH/CQAH Approval Comment';
            $history->previous = $lastDocument->qah_cq_comments;
            $history->current = $capa->qah_cq_comments;
            $history->comment = $request->qah_cq_comments_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            if (is_null($lastDocument->qah_cq_comments) || $lastDocument->qah_cq_comments === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        if ($lastDocument->qah_cq_attachment != $capa->qah_cq_attachment || !empty($request->qah_cq_attachment_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'QAH/CQAH Approval Attachment ';
            $history->previous = $lastDocument->qah_cq_attachment;
            $history->current = $capa->qah_cq_attachment;
            $history->comment = $request->qah_cq_attachment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            if (is_null($lastDocument->qah_cq_attachment) || $lastDocument->qah_cq_attachment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }  
        
        /////////////////////// Below This All Are Extra ///////////////////////
        
        if ($lastDocument->capa_qa_comments2 != $capa->capa_qa_comments2 || !empty($request->capa_qa_comments2_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'CAPA QA Comments';
            $history->previous = $lastDocument->capa_qa_comments2;
            $history->current = $capa->capa_qa_comments2;
            $history->comment = $request->capa_qa_comments2_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            if (is_null($lastDocument->capa_qa_comments2) || $lastDocument->capa_qa_comments2 === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        if ($lastDocument->details != $capa->details || !empty($request->details_comment)) {

            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Details';
            $history->previous = $lastDocument->details;
            $history->current = $capa->details;
            $history->comment = $request->details_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->project_details_application != $capa->project_details_application || !empty($request->project_details_application_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Project Details Application';
            $history->previous = $lastDocument->project_details_application;
            $history->current = $capa->project_details_application;
            $history->comment = $request->project_details_application_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->project_details_application) || $lastDocument->project_details_application === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        if ($lastDocument->project_initiator_group != $capa->project_initiator_group || !empty($request->project_initiator_group_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Initiator Group';
            $history->previous = $lastDocument->project_initiator_group;
            $history->current = $capa->project_initiator_group;
            $history->comment = $request->project_initiator_group_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->project_initiator_group) || $lastDocument->project_initiator_group === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        if ($lastDocument->site_number != $capa->site_number || !empty($request->site_number_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Site Number';
            $history->previous = $lastDocument->site_number;
            $history->current = $capa->site_number;
            $history->comment = $request->site_number_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->site_number) || $lastDocument->site_number === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        if ($lastDocument->subject_number != $capa->subject_number || !empty($request->subject_number_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Subject Number';
            $history->previous = $lastDocument->subject_number;
            $history->current = $capa->subject_number;
            $history->comment = $request->subject_number_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->subject_number) || $lastDocument->subject_number === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        if ($lastDocument->subject_initials != $capa->subject_initials || !empty($request->subject_initials_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Subject Initials';
            $history->previous = $lastDocument->subject_initials;
            $history->current = $capa->subject_initials;
            $history->comment = $request->subject_initials_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->subject_initials) || $lastDocument->subject_initials === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        if ($lastDocument->sponsor != $capa->sponsor || !empty($request->sponsor_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Sponsor';
            $history->previous = $lastDocument->sponsor;
            $history->current = $capa->sponsor;
            $history->comment = $request->sponsor_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->sponsor) || $lastDocument->sponsor === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        if ($lastDocument->general_deviation != $capa->general_deviation || !empty($request->general_deviation_comment)) {
            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'General Deviation';
            $history->previous = $lastDocument->general_deviation;
            $history->current = $capa->general_deviation;
            $history->comment = $request->general_deviation_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->general_deviation) || $lastDocument->general_deviation === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();
        }

        

        if ($lastDocument->supervisor_review_comments != $capa->supervisor_review_comments || !empty($request->supervisor_review_comments_comment)) {

            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Supervisor Review Comments';
            $history->previous = $lastDocument->supervisor_review_comments;
            $history->current = $capa->supervisor_review_comments;
            $history->comment = $request->supervisor_review_comments_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->supervisor_review_comments) || $lastDocument->supervisor_review_comments === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }



        if ($lastDocument->effectiveness != $capa->effectiveness || !empty($request->effectiveness_comment)) {

            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Effectiveness Check required';
            $history->previous = $lastDocument->effectiveness;
            $history->current = $capa->effectiveness;
            $history->comment = $request->effectiveness_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->effectiveness) || $lastDocument->effectiveness === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->effect_check_date != $capa->effect_check_date || !empty($request->effect_check_date_comment)) {

            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Effect.Check Creation Date';
            $history->previous = $lastDocument->effect_check_date;
            $history->current = $capa->effect_check_date;
            $history->comment = $request->effect_check_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->effect_check_date) || $lastDocument->effect_check_date === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }
        

        // DocumentService::update_qms_numbers();

        toastr()->success("Record is updated Successfully");
        return back();
    }

    public function capashow($id)
    {
        $cft = [];
        $revised_date = "";
        $data = Capa::find($id);
        //dd($data);
        $old_record = Capa::select('id', 'division_id', 'record')->get();
        $revised_date = Extension::where('parent_id', $id)->where('parent_type', "Capa")->value('revised_date');
        $data->record = str_pad($data->record, 4, '0', STR_PAD_LEFT);
        $data->assign_to = User::where('id', $data->assign_id)->value('name');
        $data->initiator_name = User::where('id', $data->initiator_id)->value('name');
        $data1 = CapaGrid::where('capa_id', $id)->where('type', "Product_Details")->first();
        $data2 = CapaGrid::where('capa_id', $id)->where('type', "Material_Details")->first();
        $data3 = CapaGrid::where('capa_id', $id)->where('type', "Instruments_Details")->first();
        if (!empty($changeControl->cft)) $cft = explode(',', $changeControl->cft);
        // $MaterialsQueryData = Http::get('http://103.167.99.37/LIMS_EL/WebServices.Query.MaterialsQuery.lims');
        // dd( $MaterialsQueryData->json());
        // $EquipmentsQueryData = Http::get('http://103.167.99.37/LIMS_EL/WebServices.Query.EquipmentsQuery.lims');
        // dd( $EquipmentsQueryData->json());
        
        return view('frontend.capa.capaView', compact('data', 'data1', 'data2', 'data3', 'old_record', 'revised_date', 'cft'));
    }


    public function capa_send_stage(Request $request, $id)
    {

        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $capa = Capa::find($id);
            $lastDocument = Capa::find($id);
            $updateCFT = CapaCft::where('capa_id', $id)->latest()->first();
            $cftDetails = CapaCftResponse::withoutTrashed()->where(['status' => 'In-progress', 'capa_id' => $id])->distinct('cft_user_id')->count();

            if ($capa->stage == 1) {
                $capa->stage = "2";
                $capa->status = "HOD Review";
                $capa->plan_proposed_by = Auth::user()->name;
                // $capa->plan_proposed_on = Carbon::now()->format('d-M-Y');
                
                // $capa->Within_Limits_on = Carbon::now('Asia/Kolkata')->format('d-M-Y H:i:s T') . ' | GMT: ' . Carbon::now('UTC')->format('d-M-Y H:i:s T');
                $capa->comment = $request->comment;
                $history = new CapaAuditTrial();
                $history->capa_id = $id;
                $history->activity_type = 'Propose Plan By,Propose Plan On';
                $history->action = 'Propose Plan';
                $history->previous = "";
                $history->current = $capa->plan_proposed_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;

                $history->change_to = "HOD Review";
                $history->change_from = $lastDocument->status;
                $history->stage = 'HOD Review';
                $history->action_name = 'Update';
                if (is_null($lastDocument->plan_proposed_by) || $lastDocument->plan_proposed_by === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->plan_proposed_by . ' , ' . $lastDocument->plan_proposed_on;
                }
                $history->current = $capa->plan_proposed_by . ' , ' . $capa->plan_proposed_on;
                if (is_null($lastDocument->plan_proposed_by) || $lastDocument->plan_proposed_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();

                /********** Notification User Start**********/
                // $list = Helpers::getHodUserList($capa->division_id);
                // $userIds = collect($list)->pluck('user_id')->toArray();
                // $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                // $userId = $users->pluck('id')->implode(',');

                // if(!empty($users)){
                //     try {
                //         $history = new CapaAuditTrial();
                //         $history->capa_id = $id;
                //         $history->activity_type = "Not Applicable";
                //         $history->previous = "Not Applicable";
                //         $history->current = "Not Applicable";
                //         $history->action = 'Notification';
                //         $history->comment = "";
                //         $history->user_id = Auth::user()->id;
                //         $history->user_name = Auth::user()->name;
                //         $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                //         $history->origin_state = "Not Applicable";
                //         $history->change_to = "Not Applicable";
                //         $history->change_from = "Opened";
                //         $history->stage = "";
                //         $history->action_name = "";
                //         $history->mailUserId = $userId;
                //         $history->role_name = "Initiator";
                //         $history->save();
                //     } catch (\Throwable $e) {
                //         \Log::error('Mail failed to send: ' . $e->getMessage());
                //     }
                // }


                // foreach ($users as $userValue) {
                //     DB::table('notifications')->insert([
                //         'activity_id' => $capa->id,
                //         'activity_type' => "Notification",
                //         'from_id' => Auth::user()->id,
                //         'user_name' => $userValue->name,
                //         'to_id' => $userValue->id,
                //         'process_name' => "CAPA",
                //         'division_id' => $capa->division_id,
                //         'short_description' => $capa->short_description,
                //         'initiator_id' => $capa->initiator_id,
                //         'due_date' => $capa->due_date,
                //         'record' => $capa->record,
                //         'site' => "CAPA",
                //         'comment' => $request->comments,
                //         'status' => $capa->status,
                //         'stage' => $capa->stage,
                //         'created_at' => Carbon::now(),
                //     ]);
                // }

                // foreach ($list as $u) {
                //     $email = Helpers::getUserEmail($u->user_id);
                //         if ($email !== null) {
                //         try {
                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $capa, 'site' => "CAPA", 'history' => "Plan Proposed", 'process' => 'CAPA', 'comment' => $request->comments, 'user' => Auth::user()->name],
                //                 function ($message) use ($email, $capa) {
                //                     $message->to($email)
                //                     ->subject("Medicef Notification: CAPA, Record #" . str_pad($capa->record, 4, '0', STR_PAD_LEFT) . " - Activity: Plan Proposed Performed");
                //                 }
                //             );
                //         } catch(\Exception $e) {
                //             info('Error sending mail', [$e]);
                //         }
                //     }
                // }

                /********** Notification User End**********/

                $capa->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($capa->stage == 2) {
                if (empty($capa->hod_remarks))
                {
                    Session::flash('swal', [
                        'type' => 'warning',
                        'title' => 'Mandatory Fields!',
                        'message' => 'HOD Remark filed is yet to be filled'
                    ]);

                    return redirect()->back();
                }
                else {
                    Session::flash('swal', [
                        'type' => 'success',
                        'title' => 'Success',
                        'message' => 'Document Sent'
                    ]);
                }
              
                $capa->stage = "3";
                $capa->status = "QA/CQA Review";
                $capa->hod_review_completed_by = Auth::user()->name;
                // $capa->hod_review_completed_on = Carbon::now()->format('d-M-Y');
                $capa->hod_review_completed_on = Carbon::now('Asia/Kolkata')->format('d-M-Y H:i:s T') . 
                                        ' | GMT: ' . Carbon::now('UTC')->format('d-M-Y H:i:s T');
                $capa->hod_comment = $request->comment;
                $history = new CapaAuditTrial();
                $history->capa_id = $id;
                $history->activity_type = 'HOD Review Complete By,HOD Review Complete On';
                $history->action = 'HOD Review Complete';
                $history->previous = "";
                $history->current = $capa->plan_approved_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "QA/CQA Review";
                $history->change_from = $lastDocument->status;
                $history->stage = 'QA/CQA Review';
                $history->action_name = 'Update';
                if (is_null($lastDocument->hod_review_completed_by) || $lastDocument->hod_review_completed_by === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->hod_review_completed_by . ' , ' . $lastDocument->hod_review_completed_on;
                }
                $history->current = $capa->hod_review_completed_by . ' , ' . $capa->hod_review_completed_on;
                if (is_null($lastDocument->hod_review_completed_by) || $lastDocument->hod_review_completed_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();

                // $list = Helpers::getQAUserList();
                // foreach ($list as $u) {
                //     if($u->q_m_s_divisions_id == $capa->division_id){
                //     $email = Helpers::getInitiatorEmail($u->user_id);
                //     if ($email !== null) {
                //         Mail::send(
                //             'mail.view-mail',
                //             ['data' => $capa],
                //             function ($message) use ($email) {
                //                 $message->to($email)
                //                     ->subject("Plan Approved By ".Auth::user()->name);
                //             }
                //         );
                //     }
                //   }
                // }

                $capa->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($capa->stage == 3) {
              if (empty($capa->capa_qa_comments))
                {
                    Session::flash('swal', [
                        'type' => 'warning',
                        'title' => 'Mandatory Fields!',
                        'message' => 'CAPA QA Review And CFT Tab Tab is yet to be filled'
                    ]);

                    return redirect()->back();
                }
                else {
                    Session::flash('swal', [
                        'type' => 'success',
                        'title' => 'Success',
                        'message' => 'Document Sent'
                    ]);
                }
               

                $capa->stage = "4";
                $capa->status = "QA/CQA Approval";
                $capa->qa_review_completed_by = Auth::user()->name;
                // $capa->qa_review_completed_on = Carbon::now()->format('d-M-Y');
                $capa->qa_review_completed_on = Carbon::now('Asia/Kolkata')->format('d-M-Y H:i:s T') . 
                                        ' | GMT: ' . Carbon::now('UTC')->format('d-M-Y H:i:s T');
                $capa->qa_comment = $request->comment;
                $history = new CapaAuditTrial();
                $history->capa_id = $id;
                $history->activity_type = 'QA/CQA Review Complete By,QA/CQA Review Complete On';
                $history->action = 'QA/CQA Review Complete';
                $history->previous = "";
                $history->current = $capa->completed_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "QA/CQA Approval";
                $history->change_from = $lastDocument->status;
                $history->stage = 'QA/CQA Approval';
                $history->action_name = 'Update';
                if (is_null($lastDocument->qa_review_completed_by) || $lastDocument->qa_review_completed_by === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->qa_review_completed_by . ' , ' . $lastDocument->qa_review_completed_on;
                }
                $history->current = $capa->qa_review_completed_by . ' , ' . $capa->qa_review_completed_on;
                if (is_null($lastDocument->qa_review_completed_by) || $lastDocument->qa_review_completed_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();
                $capa->update();
                toastr()->success('Document Sent');
                return back();
            }
            // if ($capa->stage == 4) {
            //     $capa->stage = "5";
            //     $capa->status = "QA/CQA Approval";
            //     $capa->approved_by = Auth::user()->name;
            //     $capa->approved_on = Carbon::now()->format('d-M-Y');
            //     $capa->approved_comment = $request->comment;

            //     $history = new CapaAuditTrial();
            //     $history->capa_id = $id;
            //     $history->activity_type = 'CFT Review Complete By,CFT Review Complete On';
            //     $history->action = 'CFT Review Complete';
            //     $history->previous = "";
            //     $history->current = $capa->approved_by;
            //     $history->comment = $request->comment;
            //     $history->user_id = Auth::user()->id;
            //     $history->user_name = Auth::user()->name;
            //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //     $history->origin_state = $lastDocument->status;
            //     $history->change_to = "QA/CQA Approval";
            //     $history->change_from = $lastDocument->status;
            //     $history->stage = 'QA/CQA Approval';
            //     $history->action_name = 'Update';
            //     if (is_null($lastDocument->approved_by) || $lastDocument->approved_by === '') {
            //         $history->previous = "";
            //     } else {
            //         $history->previous = $lastDocument->approved_by . ' , ' . $lastDocument->approved_on;
            //     }
            //     $history->current = $capa->approved_by . ' , ' . $capa->acknowledge_on;
            //     if (is_null($lastDocument->approved_by) || $lastDocument->approved_by === '') {
            //         $history->action_name = 'New';
            //     } else {
            //         $history->action_name = 'Update';
            //     }
            //     $history->save();
            //     $capa->update();
            //     toastr()->success('Document Sent');
            //     return back();
            // }

            if ($capa->stage == 4) {

                $IsCFTRequired = CapaCftResponse::withoutTrashed()->where(['is_required' => 1, 'capa_id' => $id])->latest()->first();
                $cftUsers = DB::table('capa_cfts')->where(['capa_id' => $id])->first();
                // dd($cftUsers);

                /****** CFT Person ******/
                $columns = ['Production_person', 'Quality_Control_Person', 'Warehouse_person', 'Engineering_person', 'ResearchDevelopment_person', 'RegulatoryAffair_person', 'CQA_person', 'Microbiology_person', 'QualityAssurance_person','SystemIT_person','Human_Resource_person',];
                // Initialize an array to store the values

                $valuesArray = [];

                // Iterate over the columns and retrieve the values
                foreach ($columns as $index => $column) {
                    $value = $cftUsers->$column;
                    if ($index == 0 && $cftUsers->$column == Auth::user()->id) {
                        $updateCFT->Production_by = Auth::user()->name;
                        $updateCFT->production_on = Carbon::now()->format('Y-m-d');
                        //   dd($updateCFT->Production_by );
                        $history = new CapaAuditTrial();
                        $history->capa_id = $id;
                        $history->activity_type = 'Production Completed By, Production Completed On';

                        if (is_null($lastDocument->Production_by) || $lastDocument->production_on == '') {
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->Production_by . ' , ' . $lastDocument->production_on;
                        }

                        $history->action = 'CFT Review Complete';
                        
                        $history->current = $updateCFT->Production_by . ', ' . $updateCFT->production_on;

                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';

                        if (is_null($lastDocument->Production_by) || $lastDocument->production_on == '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }

                        $history->save();
                    }

                    if ($index == 1 && $cftUsers->$column == Auth::user()->id) {
                        $updateCFT->Quality_Control_by = Auth::user()->name;
                        $updateCFT->Quality_Control_on = Carbon::now()->format('Y-m-d'); // Corrected line
                    
                        $history = new CapaAuditTrial();
                        $history->capa_id = $id;
                        $history->activity_type = 'Quality Control Completed By, Quality Control Completed On';
                    
                        if (is_null($lastDocument->Quality_Control_by) || $lastDocument->Quality_Control_on == '') {
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->Quality_Control_by . ' ,' .Helpers::getdateFormat ($lastDocument->Quality_Control_on);
                        }
                    
                        $history->action = 'CFT Review Complete';
                        $history->current = $updateCFT->Quality_Control_by . ',' .Helpers::getdateFormat ($updateCFT->Quality_Control_on);
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->id; // Use `id` instead of `name` for `user_id`
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';
                    
                        if (is_null($lastDocument->Quality_Control_by) || $lastDocument->Quality_Control_on == '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                    
                        $history->save();
                    }

                    if($index == 2 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Warehouse_by = Auth::user()->name;
                        $updateCFT->Warehouse_on = Carbon::now()->format('Y-m-d');
                        $history = new CapaAuditTrial();
                        $history->capa_id = $id;
                        $history->activity_type = 'Warehouse Completed By, Warehouse Completed On';
                        if(is_null($lastDocument->Warehouse_by) || $lastDocument->Warehouse_on == ''){
                            $history->previous = "";
                        }else{
                            $history->previous = $lastDocument->Warehouse_by. ' ,' .Helpers::getdateFormat ($lastDocument->Warehouse_on);
                        }
                        $history->action='CFT Review Complete';
                        $history->current = $updateCFT->Warehouse_by. ',' . Helpers::getdateFormat($updateCFT->Warehouse_on);
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to =   "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';
                        if(is_null($lastDocument->Warehouse_by) || $lastDocument->Warehouse_on == '')
                        {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->save();
                    }
                    
                    if($index == 3 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Engineering_by = Auth::user()->name;
                        $updateCFT->Engineering_on = Carbon::now()->format('Y-m-d');
                        $history = new CapaAuditTrial();
                        $history->capa_id = $id;
                        $history->activity_type = 'Engineering Completed By, Engineering Completed On';
                        if(is_null($lastDocument->Engineering_by) || $lastDocument->Engineering_on == ''){
                            $history->previous = "";
                        }else{
                            $history->previous = $lastDocument->Engineering_by. ' ,' . Helpers::getdateFormat($lastDocument->Engineering_on);
                        }
                        $history->action='CFT Review Complete';
                        $history->current = $updateCFT->Engineering_by. ',' . Helpers::getdateFormat($updateCFT->Engineering_on);
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to =   "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';
                        if(is_null($lastDocument->Engineering_by) || $lastDocument->Engineering_on == '')
                        {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->save();
                    }

                    if($index == 4 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->ResearchDevelopment_by = Auth::user()->name;
                        $updateCFT->ResearchDevelopment_on = Carbon::now()->format('Y-m-d');
                        $history = new CapaAuditTrial();
                        $history->capa_id = $id;
                        $history->activity_type = 'Research Development Completed By, Research Development Completed On';
                        if(is_null($lastDocument->ResearchDevelopment_by) || $lastDocument->ResearchDevelopment_on == ''){
                            $history->previous = "";
                        }else{
                            $history->previous = $lastDocument->ResearchDevelopment_by. ' ,' .Helpers::getdateFormat ($lastDocument->ResearchDevelopment_on);
                        }
                        $history->action='CFT Review Complete';
                        $history->current = $updateCFT->ResearchDevelopment_by. ',' . Helpers::getdateFormat($updateCFT->ResearchDevelopment_on);
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to =   "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';
                        if(is_null($lastDocument->ResearchDevelopment_by) || $lastDocument->ResearchDevelopment_on == '')
                        {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->save();
                    }

                    if($index == 4 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->RegulatoryAffair_by = Auth::user()->name;
                        $updateCFT->RegulatoryAffair_on = Carbon::now()->format('Y-m-d');
                        $history = new CapaAuditTrial();
                        $history->capa_id = $id;
                        $history->activity_type = 'Regulatory Affair Completed By, Regulatory Affair Completed On';
                        if(is_null($lastDocument->RegulatoryAffair_by) || $lastDocument->RegulatoryAffair_on == ''){
                            $history->previous = "";
                        }else{
                            $history->previous = $lastDocument->RegulatoryAffair_by. ' ,' . Helpers::getdateFormat($lastDocument->RegulatoryAffair_on);
                        }
                        $history->action='CFT Review Complete';
                        $history->current = $updateCFT->RegulatoryAffair_by. ',' . Helpers::getdateFormat($updateCFT->RegulatoryAffair_on);
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to =   "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';
                        if(is_null($lastDocument->RegulatoryAffair_by) || $lastDocument->RegulatoryAffair_on == '')
                        {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->save();
                    }

                    
                    // if($index == 6 && $cftUsers->$column == Auth::user()->id){
                    //     $updateCFT->CQA_by = Auth::user()->name;
                    //     $updateCFT->CQA_on = Carbon::now()->format('Y-m-d');
                    //     $history = new CapaAuditTrial();
                    //     $history->capa_id = $id;
                    //     $history->activity_type = 'CQA Completed By, CQA Completed On';
                    //     if(is_null($lastDocument->CQA_by) || $lastDocument->CQA_on == ''){
                    //         $history->previous = "";
                    //     } else {
                    //         $history->previous = $lastDocument->CQA_by. ' ,' . Helpers::getdateFormat($lastDocument->CQA_on);
                    //     }
                    //     $history->action='CFT Review Complete';
                    //     $history->current = $updateCFT->CQA_by. ',' . Helpers::getdateFormat($updateCFT->CQA_on);
                    //     $history->user_id = Auth::user()->name;
                    //     $history->user_name = Auth::user()->name;
                    //     $history->change_to = "Not Applicable";
                    //     $history->change_from = $lastDocument->status;
                    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    //     $history->origin_state = $lastDocument->status;
                    //     $history->stage = 'CFT Review';
                    //     if(is_null($lastDocument->CQA_by) || $lastDocument->CQA_on == ''){
                    //         $history->action_name = 'New';
                    //     } else {
                    //         $history->action_name = 'Update';
                    //     }
                    //     $history->save();
                    // }
                    
                    if($index == 5 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Microbiology_by = Auth::user()->name;
                        $updateCFT->Microbiology_on = Carbon::now()->format('Y-m-d');
                        $history = new CapaAuditTrial();
                        $history->capa_id = $id;
                        $history->activity_type = 'Microbiology Completed By, Microbiology Completed On';
                        if(is_null($lastDocument->Microbiology_by) || $lastDocument->Microbiology_on == ''){
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->Microbiology_by. ' ,' . Helpers::getdateFormat($lastDocument->Microbiology_on);
                        }
                        $history->action='CFT Review Complete';
                        $history->current = $updateCFT->Microbiology_by. ',' . Helpers::getdateFormat($updateCFT->Microbiology_on);
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';
                        if(is_null($lastDocument->Microbiology_by) || $lastDocument->Microbiology_on == ''){
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->save();
                    }

                    if($index == 6 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->QualityAssurance_by = Auth::user()->name;
                        $updateCFT->QualityAssurance_on = Carbon::now()->format('Y-m-d');
                        $history = new CapaAuditTrial();
                        $history->capa_id = $id;
                        $history->activity_type = 'Quality Assurance Completed By, Quality Assurance Completed On';
                        if(is_null($lastDocument->QualityAssurance_by) || $lastDocument->QualityAssurance_on == ''){
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->QualityAssurance_by. ' ,' . Helpers::getdateFormat($lastDocument->QualityAssurance_on);
                        }
                        $history->action='CFT Review Complete';
                        $history->current = $updateCFT->QualityAssurance_by. ',' . Helpers::getdateFormat($updateCFT->QualityAssurance_on);
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';
                        if(is_null($lastDocument->QualityAssurance_by) || $lastDocument->QualityAssurance_on == ''){
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->save();
                    }

                    if($index == 7 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->SystemIT_by = Auth::user()->name;
                        $updateCFT->SystemIT_on = Carbon::now()->format('Y-m-d');
                        $history = new CapaAuditTrial();
                        $history->capa_id = $id;
                        $history->activity_type = 'System IT Completed By, System IT Completed On';
                        if(is_null($lastDocument->SystemIT_by) || $lastDocument->SystemIT_on == ''){
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->SystemIT_by. ' ,' . Helpers::getdateFormat($lastDocument->SystemIT_on);
                        }
                        $history->action='CFT Review Complete';
                        $history->current = $updateCFT->SystemIT_by. ',' . Helpers::getdateFormat($updateCFT->SystemIT_on);
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';
                        if(is_null($lastDocument->SystemIT_by) || $lastDocument->SystemIT_on == ''){
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->save();
                    }

                    if($index == 8 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Human_Resource_by = Auth::user()->name;
                        $updateCFT->Human_Resource_on = Carbon::now()->format('Y-m-d');
                        $history = new CapaAuditTrial();
                        $history->capa_id = $id;
                        $history->activity_type = 'Human Resource Completed By, Human Resource Completed On';
                        if(is_null($lastDocument->Human_Resource_by) || $lastDocument->Human_Resource_on == ''){
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->Human_Resource_by. ' ,' . Helpers::getdateFormat($lastDocument->Human_Resource_on);
                        }
                        $history->action='CFT Review Complete';
                        $history->current = $updateCFT->Human_Resource_by. ',' . Helpers::getdateFormat($updateCFT->Human_Resource_on);
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';
                        if(is_null($lastDocument->Human_Resource_by) || $lastDocument->Human_Resource_on == ''){
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->save();
                    }

                    if($index == 9 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Other1_by = Auth::user()->name;
                        $updateCFT->Other1_on = Carbon::now()->format('Y-m-d');
                        $history = new CapaAuditTrial();
                        $history->capa_id = $id;
                        $history->activity_type = 'Other 1 Completed By, Other 1 Completed On';
                        if(is_null($lastDocument->Other1_by) || $lastDocument->Other1_on == ''){
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->Other1_by. ' ,' . Helpers::getdateFormat($lastDocument->Other1_on);
                        }
                        $history->action='CFT Review Complete';
                        $history->current = $updateCFT->Other1_by. ',' . Helpers::getdateFormat($updateCFT->Other1_on);
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';
                        if(is_null($lastDocument->Other1_by) || $lastDocument->Other1_on == ''){
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->save();
                    }

                    // if($index == 12 && $cftUsers->$column == Auth::user()->id){
                    //     $updateCFT->Other2_by = Auth::user()->name;
                    //     $updateCFT->Other2_on = Carbon::now()->format('Y-m-d');
                    //     $history = new CapaAuditTrial();
                    //     $history->capa_id = $id;
                    //     $history->activity_type = 'Other 2 Completed By, Other 2 Completed On';
                    //     if(is_null($lastDocument->Other2_by) || $lastDocument->Other2_on == ''){
                    //         $history->previous = "";
                    //     } else {
                    //         $history->previous = $lastDocument->Other2_by. ' ,' . Helpers::getdateFormat($lastDocument->Other2_on);
                    //     }
                    //     $history->action='CFT Review Complete';
                    //     $history->current = $updateCFT->Other2_by. ',' . Helpers::getdateFormat($updateCFT->Other2_on);
                    //     $history->user_id = Auth::user()->name;
                    //     $history->user_name = Auth::user()->name;
                    //     $history->change_to = "Not Applicable";
                    //     $history->change_from = $lastDocument->status;
                    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    //     $history->origin_state = $lastDocument->status;
                    //     $history->stage = 'CFT Review';
                    //     if(is_null($lastDocument->Other2_by) || $lastDocument->Other2_on == ''){
                    //         $history->action_name = 'New';
                    //     } else {
                    //         $history->action_name = 'Update';
                    //     }
                    //     $history->save();
                    // }

                    // if($index == 13 && $cftUsers->$column == Auth::user()->id){
                    //     $updateCFT->Other3_by = Auth::user()->name;
                    //     $updateCFT->Other3_on = Carbon::now()->format('Y-m-d');
                    //     $history = new CapaAuditTrial();
                    //     $history->capa_id = $id;
                    //     $history->activity_type = 'Other 3 Completed By, Other 3 Completed On';
                    //     if(is_null($lastDocument->Other3_by) || $lastDocument->Other3_on == ''){
                    //         $history->previous = "";
                    //     } else {
                    //         $history->previous = $lastDocument->Other3_by. ' ,' . Helpers::getdateFormat($lastDocument->Other3_on);
                    //     }
                    //     $history->action='CFT Review Complete';
                    //     $history->current = $updateCFT->Other3_by. ',' . Helpers::getdateFormat($updateCFT->Other3_on);
                    //     $history->user_id = Auth::user()->name;
                    //     $history->user_name = Auth::user()->name;
                    //     $history->change_to = "Not Applicable";
                    //     $history->change_from = $lastDocument->status;
                    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    //     $history->origin_state = $lastDocument->status;
                    //     $history->stage = 'CFT Review';
                    //     if(is_null($lastDocument->Other3_by) || $lastDocument->Other3_on == ''){
                    //         $history->action_name = 'New';
                    //     } else {
                    //         $history->action_name = 'Update';
                    //     }
                    //     $history->save();
                    // }

                    // if($index == 14 && $cftUsers->$column == Auth::user()->id){
                    //     $updateCFT->Other4_by = Auth::user()->name;
                    //     $updateCFT->Other4_on = Carbon::now()->format('Y-m-d');
                    //     $history = new CapaAuditTrial();
                    //     $history->capa_id = $id;
                    //     $history->activity_type = 'Other 4 Completed By, Other 4 Completed On';
                    //     if(is_null($lastDocument->Other4_by) || $lastDocument->Other4_on == ''){
                    //         $history->previous = "";
                    //     } else {
                    //         $history->previous = $lastDocument->Other4_by. ' ,' . Helpers::getdateFormat($lastDocument->Other4_on);
                    //     }
                    //     $history->action='CFT Review Complete';
                    //     $history->current = $updateCFT->Other4_by. ',' . Helpers::getdateFormat($updateCFT->Other4_on);
                    //     $history->user_id = Auth::user()->name;
                    //     $history->user_name = Auth::user()->name;
                    //     $history->change_to = "Not Applicable";
                    //     $history->change_from = $lastDocument->status;
                    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    //     $history->origin_state = $lastDocument->status;
                    //     $history->stage = 'CFT Review';
                    //     if(is_null($lastDocument->Other4_by) || $lastDocument->Other4_on == ''){
                    //         $history->action_name = 'New';
                    //     } else {
                    //         $history->action_name = 'Update';
                    //     }
                    //     $history->save();
                    // }

                    // if($index == 15 && $cftUsers->$column == Auth::user()->id){
                    //     $updateCFT->Other5_by = Auth::user()->name;
                    //     $updateCFT->Other5_on = Carbon::now()->format('Y-m-d');
                    //     $history = new CapaAuditTrial();
                    //     $history->capa_id = $id;
                    //     $history->activity_type = 'Other 5 Completed By, Other 5 Completed On';
                    //     if(is_null($lastDocument->Other5_by) || $lastDocument->Other5_on == ''){
                    //         $history->previous = "";
                    //     } else {
                    //         $history->previous = $lastDocument->Other5_by. ' ,' . Helpers::getdateFormat($lastDocument->Other5_on);
                    //     }
                    //     $history->action='CFT Review Complete';
                    //     $history->current = $updateCFT->Other5_by. ',' . Helpers::getdateFormat($updateCFT->Other5_on);
                    //     $history->user_id = Auth::user()->name;
                    //     $history->user_name = Auth::user()->name;
                    //     $history->change_to = "Not Applicable";
                    //     $history->change_from = $lastDocument->status;
                    //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    //     $history->origin_state = $lastDocument->status;
                    //     $history->stage = 'CFT Review';
                    //     if(is_null($lastDocument->Other5_by) || $lastDocument->Other5_on == ''){
                    //         $history->action_name = 'New';
                    //     } else {
                    //         $history->action_name = 'Update';
                    //     }
                    //     $history->save();
                    // }
                    $updateCFT->update();

                    // Check if the value is not null and not equal to 0
                    if ($value != null && $value != 0) {
                        $valuesArray[] = $value;
                    }
                }
                if ($IsCFTRequired) {
                    if (count(array_unique($valuesArray)) == ($cftDetails + 1)) {
                        $stage = new CapaCftResponse();
                        $stage->capa_id = $id;
                        $stage->cft_user_id = Auth::user()->id;
                        $stage->status = "Completed";
                        $stage->comment = $request->comments;
                        $stage->save();
                    } else {
                        $stage = new CapaCftResponse();
                        $stage->capa_id = $id;
                        $stage->cft_user_id = Auth::user()->id;
                        $stage->status = "In-progress";
                        $stage->comment = $request->comments;
                        $stage->save();
                    }
                }
                
                $checkCFTCount = CapaCftResponse::withoutTrashed()->where(['status' => 'Completed', 'capa_id' => $id])->count();
                $Cft = CapaCft::withoutTrashed()->where('capa_id', $id)->first();
                
                if (!$IsCFTRequired || $checkCFTCount) {
                    $capa->stage = "5";
                    $capa->status = "External Review";                
                    $capa->approved_by = Auth::user()->name;
                    $capa->approved_on = Carbon::now()->format('d-M-Y');
                    $capa->approved_comment = $request->comments;

                    $history = new CapaAuditTrial();
                    $history->capa_id = $id;

                    $history->activity_type = 'CFT Review Complete By, CFT Review Complete On';
                    if (is_null($lastDocument->approved_by) || $lastDocument->approved_by === '') {
                        $history->previous = "NULL";
                    } else {
                        $history->previous = $lastDocument->approved_by . ' , ' . $lastDocument->approved_on;
                    }
                    $history->current = $capa->approved_by . ' , ' . $capa->approved_on;
                    if (is_null($lastDocument->approved_by) || $lastDocument->approved_on === '') {
                        $history->action_name = 'New';
                    } else {
                    $history->action_name = 'Update';
                    }

                    $history->action = 'CFT Review Complete';
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to = "External Review";
                    $history->change_from = $lastDocument->status;
                    $history->stage = 'Plan Proposed';
                    $history->save();
                       
                    $capa->update();
                }
                toastr()->success('Sent External Review');
                return back();
            }
            if ($capa->stage == 5) {
                $capa->stage = "6";
                $capa->status = "CAPA In progress";
                $capa->approved_by = Auth::user()->name;
                // $capa->approved_on = Carbon::now()->format('d-M-Y');
                $capa->approved_on = Carbon::now('Asia/Kolkata')->format('d-M-Y H:i:s T') . 
                                        ' | GMT: ' . Carbon::now('UTC')->format('d-M-Y H:i:s T');
                $capa->approved_comment = $request->comment;

                $history = new CapaAuditTrial();
                $history->capa_id = $id;
                $history->activity_type = 'Approved By,Approved On';
                $history->action = 'Approved';
                $history->previous = "";
                $history->current = $capa->approved_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "CAPA In progress";
                $history->change_from = $lastDocument->status;
                $history->stage = 'CAPA In progress';
                $history->action_name = 'Update';
                if (is_null($lastDocument->approved_by) || $lastDocument->approved_by === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->approved_by . ' , ' . $lastDocument->approved_on;
                }
                $history->current = $capa->approved_by . ' , ' . $capa->acknowledge_on;
                if (is_null($lastDocument->approved_by) || $lastDocument->approved_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();
                $capa->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($capa->stage == 6) {
                $capa->stage = "7";
                $capa->status = "HOD Final Review";
                $capa->completed_by = Auth::user()->name;
                // $capa->completed_on = Carbon::now()->format('d-M-Y');
                $capa->completed_on = Carbon::now('Asia/Kolkata')->format('d-M-Y H:i:s T') . 
                                        ' | GMT: ' . Carbon::now('UTC')->format('d-M-Y H:i:s T');
                $capa->com_comment = $request->comment;
                $history = new CapaAuditTrial();
                $history->capa_id = $id;
                $history->activity_type = 'Completed By,Completed On';
                $history->action = 'Complete';
                $history->previous = "";
                $history->current = $capa->approved_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "HOD Final Review";
                $history->change_from = $lastDocument->status;
                $history->stage = 'HOD Final Review';
                $history->action_name = 'Update';
                if (is_null($lastDocument->completed_by) || $lastDocument->completed_by === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->completed_by . ' , ' . $lastDocument->completed_on;
                }
                $history->current = $capa->completed_by . ' , ' . $capa->completed_on;
                if (is_null($lastDocument->completed_by) || $lastDocument->completed_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();
                $capa->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($capa->stage == 7) {
                $capa->stage = "8";
                $capa->status = "QA/CQA Closure Review";
                $capa->hod_final_review_completed_by = Auth::user()->name;
                // $capa->hod_final_review_completed_on = Carbon::now()->format('d-M-Y');
                $capa->hod_final_review_completed_on = Carbon::now('Asia/Kolkata')->format('d-M-Y H:i:s T') . 
                                        ' | GMT: ' . Carbon::now('UTC')->format('d-M-Y H:i:s T');
                $capa->final_comment = $request->comment;

                $history = new CapaAuditTrial();
                $history->capa_id = $id;
                $history->activity_type = 'HOD Final Review Complete By,HOD Final Review Complete On';
                $history->action = 'HOD Final Review Complete';
                $history->previous = "";
                $history->current = $capa->approved_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "QA/CQA Closure Review";
                $history->change_from = $lastDocument->status;
                $history->stage = 'QA/CQA Closure Review';
                $history->action_name = 'Update';
                if (is_null($lastDocument->hod_final_review_completed_by) || $lastDocument->hod_final_review_completed_by === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->hod_final_review_completed_by . ' , ' . $lastDocument->hod_final_review_completed_on;
                }
                $history->current = $capa->hod_final_review_completed_by . ' , ' . $capa->hod_final_review_completed_on;
                if (is_null($lastDocument->hod_final_review_completed_by) || $lastDocument->acknowledge_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();
                $capa->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($capa->stage == 8) {
                $capa->stage = "9";
                $capa->status = "QA/CQA Approval ";
                $capa->qa_closure_review_completed_by = Auth::user()->name;
                // $capa->qa_closure_review_completed_on = Carbon::now()->format('d-M-Y');
                $capa->qa_closure_review_completed_on = Carbon::now('Asia/Kolkata')->format('d-M-Y H:i:s T') . 
                                        ' | GMT: ' . Carbon::now('UTC')->format('d-M-Y H:i:s T');
                $capa->qa_closure_comment = $request->comment;

                $history = new CapaAuditTrial();
                $history->capa_id = $id;
                $history->activity_type = 'QA/CQA Closure Review Complete By,QA/CQA Closure Review Complete On';
                $history->action = 'QA/CQA Closure Review Complete';
                $history->previous = "";
                $history->current = $capa->approved_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "QA/CQA Approval ";
                $history->change_from = $lastDocument->status;
                $history->stage = 'QA/CQA Approval ';
                $history->action_name = 'Update';
                if (is_null($lastDocument->qa_closure_review_completed_by) || $lastDocument->qa_closure_review_completed_by === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->qa_closure_review_completed_by . ' , ' . $lastDocument->qa_closure_review_completed_on;
                }
                $history->current = $capa->qa_closure_review_completed_by . ' , ' . $capa->qa_closure_review_completed_on;
                if (is_null($lastDocument->qa_closure_review_completed_by) || $lastDocument->qa_closure_review_completed_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();
                $capa->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($capa->stage == 9) {
                $capa->stage = "10";
                $capa->status = "Closed - Done";
                $capa->qah_approval_completed_by = Auth::user()->name;
                // $capa->qah_approval_completed_on = Carbon::now()->format('d-M-Y');
                $capa->qah_approval_completed_on = Carbon::now('Asia/Kolkata')->format('d-M-Y H:i:s T') . 
                ' | GMT: ' . Carbon::now('UTC')->format('d-M-Y H:i:s T');
                $capa->qah_comment = $request->comment;
                $history = new CapaAuditTrial();
                $history->capa_id = $id;
                $history->activity_type = 'QA/CQA Approval  Complete By,QA/CQA Approval  Complete On';
                $history->action = 'QA/CQA Approval  Complete';
                $history->previous = "";
                $history->current = $capa->completed_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Closed - Done";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Closed - Done';
                $history->action_name = 'Update';
                if (is_null($lastDocument->qah_approval_completed_by) || $lastDocument->qah_approval_completed_by === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->qah_approval_completed_by . ' , ' . $lastDocument->qah_approval_completed_on;
                }
                $history->current = $capa->qah_approval_completed_by . ' , ' . $capa->qah_approval_completed_on;
                if (is_null($lastDocument->qah_approval_completed_by) || $lastDocument->qah_approval_completed_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();
                $capa->update();
                toastr()->success('Document Sent');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }
    
    public function capaCancel(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $capa = Capa::find($id);
            $lastDocument = Capa::find($id);

            if ($capa->stage == 2) {
                $capa->stage = "0";
                $capa->status = "Closed-Cancelled";
                $capa->cancelled_by = Auth::user()->name;
                // $capa->cancelled_on = Carbon::now()->format('d-M-Y');
                $capa->cancelled_on = Carbon::now('Asia/Kolkata')->format('d-M-Y H:i:s T') . 
                ' | GMT: ' . Carbon::now('UTC')->format('d-M-Y H:i:s T');
                $capa->cancel_comment = $request->comment;
                $history = new CapaAuditTrial();
                $history->capa_id = $id;
                $history->activity_type = 'Cancel By,Cancel On';
                $history->action = 'Cancel';
                $history->previous = "";
                $history->current = $capa->cancelled_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state =  $capa->status;
                $history->change_to = "Closed-Cancelled";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Cancelled';
                if (is_null($lastDocument->cancelled_by) || $lastDocument->cancelled_by === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->cancelled_by . ' , ' . $lastDocument->cancelled_on;
                }
                $history->current = $capa->cancelled_by . ' , ' . $capa->cancelled_on;
                if (is_null($lastDocument->cancelled_by) || $lastDocument->cancelled_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();
                $capa->update();
                $history = new CapaHistory();
                $history->type = "Capa";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $capa->stage;
                $history->status = $capa->status;
                $history->save();

                // $list = Helpers::getInitiatorUserList();
                // foreach ($list as $u) {
                //     if($u->q_m_s_divisions_id == $capa->division_id){
                //       $email = Helpers::getInitiatorEmail($u->user_id);
                //       if ($email !== null) {

                //         Mail::send(
                //             'mail.view-mail',
                //             ['data' => $capa],
                //             function ($message) use ($email) {
                //                 $message->to($email)
                //                     ->subject("Cancelled By ".Auth::user()->name);
                //             }
                //          );
                //       }
                //     }
                // }

                toastr()->success('Document Sent');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function capa_qa_more_info(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $capa = Capa::find($id);
            $lastDocument = Capa::find($id);
            if ($capa->stage == 2) {
                $capa->stage = "1";
                $capa->status = "Opened";
                $capa->more_info_required_by = Auth::user()->name;
                // $capa->more_info_required_on = Carbon::now()->format('d-M-Y');
                $capa->more_info_required_on = Carbon::now('Asia/Kolkata')->format('d-M-Y H:i:s T') . 
                ' | GMT: ' . Carbon::now('UTC')->format('d-M-Y H:i:s T');
                $capa->hod_comment1 = $request->comment;

                $history = new CapaAuditTrial();
                $history->capa_id = $id;
                $history->activity_type = 'Not Applicable';
                $history->previous = "Not Applicable";
                $history->action  = "More Information Required";
                $history->current = "Not Applicable";
                $history->action_name = "Not Applicable";
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Opened";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Opened';
                // $history->action_name = 'Update';
                // if (is_null($lastDocument->more_info_required_by) || $lastDocument->more_info_required_by === '') {
                //     $history->previous = "";
                // } else {
                //     $history->previous = $lastDocument->more_info_required_by . ' , ' . $lastDocument->more_info_required_on;
                // }
                // $history->current = $capa->more_info_required_by . ' , ' . $capa->more_info_required_on;
                // if (is_null($lastDocument->more_info_required_by) || $lastDocument->more_info_required_by === '') {
                //     $history->action_name = 'New';
                // } else {
                //     $history->action_name = 'Update';
                // }
                $history->save();
                $capa->update();
                $history = new CapaHistory();
                $history->type = "Capa";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $capa->stage;
                $history->status = $capa->status;
                $history->save();

                toastr()->success('Document Sent');
                return back();
            }

            if ($capa->stage == 3) {
                $capa->stage = "2";
                $capa->status = "Pending CAPA Plan";
                $capa->qa_more_info_required_by = Auth::user()->name;
                // $capa->qa_more_info_required_on = Carbon::now()->format('d-M-Y');
                $capa->more_info_required_on = Carbon::now('Asia/Kolkata')->format('d-M-Y H:i:s T') . 
                ' | GMT: ' . Carbon::now('UTC')->format('d-M-Y H:i:s T');
                $capa->qa_commenta = $request->comment;

                $history = new CapaAuditTrial();
                $history->capa_id = $id;
                $history->activity_type = 'Not Applicable';
                $history->previous = "Not Applicable";
                $history->action  = "More Information Required";
                $history->current = "Not Applicable";
                $history->action_name = "Not Applicable";
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Pending CAPA Plan";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Pending CAPA Plan';
                // $history->action_name = 'Update';
                // if (is_null($lastDocument->qa_more_info_required_by) || $lastDocument->qa_more_info_required_by === '') {
                //     $history->previous = "";
                // } else {
                //     $history->previous = $lastDocument->qa_more_info_required_by . ' , ' . $lastDocument->qa_more_info_required_on;
                // }
                // $history->current = $capa->qa_more_info_required_by . ' , ' . $capa->qa_more_info_required_on;
                // if (is_null($lastDocument->qa_more_info_required_by) || $lastDocument->qa_more_info_required_by === '') {
                //     $history->action_name = 'New';
                // } else {
                //     $history->action_name = 'Update';
                // }
                $history->save();
                $capa->update();
                $history = new CapaHistory();
                $history->type = "Capa";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $capa->stage;
                $history->status = $capa->status;
                $history->save();
                // $list = Helpers::getHodUserList();
                // foreach ($list as $u) {
                //     if($u->q_m_s_divisions_id == $capa->division_id){
                //      $email = Helpers::getInitiatorEmail($u->user_id);
                //      if ($email !== null) {
                //          Mail::send(
                //             'mail.view-mail',
                //             ['data' => $capa],
                //             function ($message) use ($email) {
                //                 $message->to($email)
                //                     ->subject("Document is Send By ".Auth::user()->name);
                //             }
                //         );
                //       }
                //     }
                // }
                toastr()->success('Document Sent');
                return back();
            }

            if ($capa->stage == 4) {
                $capa->stage = "3";
                $capa->status = "CAPA In Progress";
                $capa->app_more_info_required_by = Auth::user()->name;
                // $capa->app_more_info_required_on = Carbon::now()->format('d-M-Y');
                $capa->app_more_info_required_on = Carbon::now('Asia/Kolkata')->format('d-M-Y H:i:s T') . 
                ' | GMT: ' . Carbon::now('UTC')->format('d-M-Y H:i:s T');
                $capa->app_comment = $request->comment;

                $history = new CapaAuditTrial();
                $history->capa_id = $id;
                $history->activity_type = 'Not Applicable';
                $history->previous = "Not Applicable";
                $history->action  = "More Information Required";
                $history->current = "Not Applicable";
                $history->action_name = "Not Applicable";
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "CAPA In Progress";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Rejected';
                // $history->action_name = 'Update';
                // if (is_null($lastDocument->app_more_info_required_by) || $lastDocument->app_more_info_required_by === '') {
                //     $history->previous = "";
                // } else {
                //     $history->previous = $lastDocument->app_more_info_required_by . ' , ' . $lastDocument->app_more_info_required_on;
                // }
                // $history->current = $capa->app_more_info_required_by . ' , ' . $capa->app_more_info_required_on;
                // if (is_null($lastDocument->app_more_info_required_by) || $lastDocument->app_more_info_required_by === '') {
                //     $history->action_name = 'New';
                // } else {
                //     $history->action_name = 'Update';
                // }
                $history->save();
                $capa->update();
                $history = new CapaHistory();
                $history->type = "Capa";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $capa->stage;
                $history->status = $capa->status;
                $history->save();
                toastr()->success('Document Sent');
                return back();
            }
            if ($capa->stage == 6) {
                $capa->stage = "5";
                $capa->status = "QA/CQA Approval";
                $capa->com_more_info_required_by = Auth::user()->name;
                // $capa->com_more_info_required_on = Carbon::now()->format('d-M-Y');
                $capa->com_more_info_required_on = Carbon::now('Asia/Kolkata')->format('d-M-Y H:i:s T') . 
                ' | GMT: ' . Carbon::now('UTC')->format('d-M-Y H:i:s T');
                $capa->com_comment1 = $request->comment;

                $history = new CapaAuditTrial();
                $history->capa_id = $id;
                $history->activity_type = 'Not Applicable';
                $history->previous = "Not Applicable";
                $history->action  = "More Information Required";
                $history->current = "Not Applicable";
                $history->action_name = "Not Applicable";
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "QA/CQA Approval";
                $history->change_from = $lastDocument->status;
                $history->stage = 'QA/CQA Approval';
                // $history->action_name = 'Update';
                // if (is_null($lastDocument->com_more_info_required_by) || $lastDocument->com_more_info_required_by === '') {
                //     $history->previous = "";
                // } else {
                //     $history->previous = $lastDocument->com_more_info_required_by . ' , ' . $lastDocument->com_more_info_required_on;
                // }
                // $history->current = $capa->com_more_info_required_by . ' , ' . $capa->com_more_info_required_on;
                // if (is_null($lastDocument->com_more_info_required_by) || $lastDocument->com_more_info_required_by === '') {
                //     $history->action_name = 'New';
                // } else {
                //     $history->action_name = 'Update';
                // }
                $history->save();
                $capa->update();
                $history = new CapaHistory();
                $history->type = "Capa";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $capa->stage;
                $history->status = $capa->status;
                $history->save();

                toastr()->success('Document Sent');
                return back();
            }
        }
        if ($capa->stage == 7) {
            $capa->stage = "6";
            $capa->status = "CAPA In progress";
            $capa->hod_more_info_required_by = Auth::user()->name;
            // $capa->hod_more_info_required_on = Carbon::now()->format('d-M-Y');
            $capa->hod_more_info_required_on = Carbon::now('Asia/Kolkata')->format('d-M-Y H:i:s T') . 
            ' | GMT: ' . Carbon::now('UTC')->format('d-M-Y H:i:s T');
            $capa->final_hod_comment = $request->comment;

            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Not Applicable';
            $history->previous = "Not Applicable";
            $history->action  = "More Information Required";
            $history->current = "Not Applicable";
            $history->action_name = "Not Applicable";
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "CAPA In progress";
            $history->change_from = $lastDocument->status;
            $history->stage = 'CAPA In progress';
            // $history->action_name = 'Update';
            // if (is_null($lastDocument->hod_more_info_required_by) || $lastDocument->hod_more_info_required_by === '') {
            //     $history->previous = "";
            // } else {
            //     $history->previous = $lastDocument->hod_more_info_required_by . ' , ' . $lastDocument->hod_more_info_required_on;
            // }
            // $history->current = $capa->hod_more_info_required_by . ' , ' . $capa->hod_more_info_required_on;
            // if (is_null($lastDocument->hod_more_info_required_by) || $lastDocument->hod_more_info_required_by === '') {
            //     $history->action_name = 'New';
            // } else {
            //     $history->action_name = 'Update';
            // }
            $history->save();
            $capa->update();
            $history = new CapaHistory();
            $history->type = "Capa";
            $history->doc_id = $id;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->stage_id = $capa->stage;
            $history->status = $capa->status;
            $history->save();

            toastr()->success('Document Sent');
            return back();
        }
        if ($capa->stage == 8) {
            $capa->stage = "7";
            $capa->status = "HOD Final Review";
            $capa->closure_more_info_required_by = Auth::user()->name;
            // $capa->closure_qa_more_info_required_on = Carbon::now()->format('d-M-Y');
            $capa->closure_qa_more_info_required_on = Carbon::now('Asia/Kolkata')->format('d-M-Y H:i:s T') . 
            ' | GMT: ' . Carbon::now('UTC')->format('d-M-Y H:i:s T');
            $capa->closure_qa_comment = $request->comment;

            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Not Applicable';
            $history->previous = "Not Applicable";
            $history->action  = "More Information Required";
            $history->current = "Not Applicable";
            $history->action_name = "Not Applicable";
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "HOD Final Review";
            $history->change_from = $lastDocument->status;
            $history->stage = 'HOD Final Review';
            $history->action_name = 'Update';
            // if (is_null($lastDocument->closure_more_info_required_by) || $lastDocument->closure_more_info_required_by === '') {
            //     $history->previous = "";
            // } else {
            //     $history->previous = $lastDocument->closure_more_info_required_by . ' , ' . $lastDocument->closure_qa_more_info_required_on;
            // }
            // $history->current = $capa->closure_more_info_required_by . ' , ' . $capa->closure_qa_more_info_required_on;
            // if (is_null($lastDocument->closure_more_info_required_by) || $lastDocument->closure_more_info_required_by === '') {
            //     $history->action_name = 'New';
            // } else {
            //     $history->action_name = 'Update';
            // }
            $history->save();
            $capa->update();
            $history = new CapaHistory();
            $history->type = "Capa";
            $history->doc_id = $id;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->stage_id = $capa->stage;
            $history->status = $capa->status;
            $history->save();

            toastr()->success('Document Sent');
            return back();
        }
        if ($capa->stage == 9) {
            $capa->stage = "8";
            $capa->status = "QA/CQA Closure Review";
            $capa->qah_more_info_required_by = Auth::user()->name;
            // $capa->qah_more_info_required_on = Carbon::now()->format('d-M-Y');
            $capa->qah_more_info_required_on = Carbon::now('Asia/Kolkata')->format('d-M-Y H:i:s T') . 
            ' | GMT: ' . Carbon::now('UTC')->format('d-M-Y H:i:s T');
            $capa->qah_comment1 = $request->comment;

            $history = new CapaAuditTrial();
            $history->capa_id = $id;
            $history->activity_type = 'Not Applicable';
            $history->previous = "Not Applicable";
            $history->action  = "More Information Required";
            $history->current = "Not Applicable";
            $history->action_name = "Not Applicable";
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "QA/CQA Closure Review";
            $history->change_from = $lastDocument->status;
            $history->stage = 'QA/CQA Closure Review';
            // $history->action_name = 'Update';
            // if (is_null($lastDocument->qah_more_info_required_by) || $lastDocument->qah_more_info_required_by === '') {
            //     $history->previous = "";
            // } else {
            //     $history->previous = $lastDocument->qah_more_info_required_by . ' , ' . $lastDocument->qah_more_info_required_on;
            // }
            // $history->current = $capa->qah_more_info_required_by . ' , ' . $capa->qah_more_info_required_on;
            // if (is_null($lastDocument->qah_more_info_required_by) || $lastDocument->qah_more_info_required_by === '') {
            //     $history->action_name = 'New';
            // } else {
            //     $history->action_name = 'Update';
            // }
            $history->save();
            $capa->update();
            $history = new CapaHistory();
            $history->type = "Capa";
            $history->doc_id = $id;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->stage_id = $capa->stage;
            $history->status = $capa->status;
            $history->save();

            toastr()->success('Document Sent');
            return back();
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function capa_reject(Request $request, $id)
    {

        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $capa = Capa::find($id);
            $lastDocument = Capa::find($id);


            if ($capa->stage == 2) {
                $capa->stage = "1";
                $capa->status = "Opened";
                // $capa->rejected_by = Auth::user()->name;
                // $capa->rejected_on = Carbon::now()->format('d-M-Y');
                // $capa->update();
                // $history = new CapaHistory();
                // $history->type = "Capa";
                // $history->doc_id = $id;
                // $history->user_id = Auth::user()->id;
                // $history->user_name = Auth::user()->name;
                // $history->stage_id = $lastDocument->stage;
                // $history->status = "Opened";
                $history = new CapaAuditTrial();
                $history->capa_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $capa->qa_more_info_required_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Opened";
                $history->change_from = "Pending CAPA Plan";

                $history->save();
                $capa->update();
                // $list = Helpers::getInitiatorUserList();
                // foreach ($list as $u) {
                //     if($u->q_m_s_divisions_id == $capa->division_id){
                //     $email = Helpers::getInitiatorEmail($u->user_id);
                //     if ($email !== null) {

                //         Mail::send(
                //             'mail.view-mail',
                //             ['data' => $capa],
                //             function ($message) use ($email) {
                //                 $message->to($email)
                //                     ->subject("More Info Required ".Auth::user()->name);
                //             }
                //         );
                //       }
                //     }
                // }
                // $history->save();

                toastr()->success('Document Sent');
                return back();
            }
            if ($capa->stage == 3) {
                $capa->stage = "2";
                $capa->status = "Pending CAPA Plan";
                $capa->qa_more_info_required_by = Auth::user()->name;
                $capa->qa_more_info_required_on = Carbon::now()->format('d-M-Y');
                // $history = new CapaAuditTrial();
                // $history->capa_id = $id;
                // $history->activity_type = 'Activity Log';
                // $history->previous = "";
                // $history->current = $capa->qa_more_info_required_by;
                // $history->comment = $request->comment;
                // $history->user_id = Auth::user()->id;
                // $history->user_name = Auth::user()->name;
                // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                // $history->origin_state = $lastDocument->status;
                // $history->stage = 'Qa More Info Required';
                // $history->save();
                $history = new CapaAuditTrial();
                $history->capa_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action = 'Reject';
                $history->previous = "";
                $history->current = $capa->qa_more_info_required_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Pending CAPA Plan";
                $history->change_from = "CAPA In Progress";
                $history->stage = 'CAPA In Progress';
                $history->action_name = 'Update';

                $history->save();
                $capa->update();
                $history = new CapaHistory();
                $history->type = "Capa";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $capa->stage;
                $history->status = "Pending CAPA Plan<";
                $history->save();
                toastr()->success('Document Sent');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }
    
    public function CapaAuditTrial($id)
    {
        $audit = CapaAuditTrial::where('capa_id', $id)->orderByDESC('id')->paginate();
        $today = Carbon::now()->format('d-m-y');
        $document = Capa::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');
        $data = Capa::find($id);

        // return $audit;

        return view('frontend.capa.audit-trial', compact('audit', 'document', 'today', 'data'));
    }

    public function auditDetails($id)
    {

        $detail = CapaAuditTrial::find($id);

        $detail_data = CapaAuditTrial::where('activity_type', $detail->activity_type)->where('capa_id', $detail->capa_id)->latest()->get();

        $doc = Capa::where('id', $detail->capa_id)->first();

        $doc->origiator_name = User::find($doc->initiator_id);
        return view('frontend.capa.audit-trial-inner', compact('detail', 'doc', 'detail_data'));
    }

    public function child_change_control(Request $request, $id)
    {
        $cft = [];
        $parent_id = $id;
        $parent_type = "CAPA";
        $record = ((RecordNumber::first()->value('counter')) + 1);
        $record = str_pad($record, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('d-M-Y');
        $parent_record = Capa::where('id', $id)->value('record');
        $parent_record = str_pad($parent_record, 4, '0', STR_PAD_LEFT);
        $parent_division_id = Capa::where('id', $id)->value('division_id');
        $parent_initiator_id = Capa::where('id', $id)->value('initiator_id');
        $parent_intiation_date = Capa::where('id', $id)->value('intiation_date');
        $parent_short_description = Capa::where('id', $id)->value('short_description');
        $hod = User::where('role', 4)->get();
        $pre = CC::all();
        $changeControl = OpenStage::find(1);
        if (!empty($changeControl->cft)) $cft = explode(',', $changeControl->cft);
        // return $capa_data;
        if ($request->child_type == "Change_control") {
            $record_number = $record;
            return view('frontend.change-control.new-change-control', compact('cft', 'pre', 'hod', 'parent_short_description', 'parent_initiator_id', 'parent_intiation_date', 'parent_division_id', 'parent_record', 'record_number', 'due_date', 'parent_id', 'parent_type'));
        }

        $old_record = Capa::select('id', 'division_id', 'record')->get();
        if ($request->child_type == "Action_Item") {
            $parentRecord = Capa::where('id', $id)->value('record');
            $parent_name = "CAPA";
            $data = Capa::find($id);
            $old_record = ActionItem::select('id', 'division_id', 'record')->get();
            $expectedParenRecord = Helpers::getDivisionName(session()->get('division')) . "/CAPA/" . date('Y') . "/" . $data->record . "";
            return view('frontend.action-item.action-item', compact('expectedParenRecord', 'old_record', 'parentRecord', 'parent_short_description', 'parent_initiator_id', 'parent_intiation_date', 'parent_name', 'parent_division_id', 'parent_record', 'record', 'due_date', 'parent_id', 'parent_type'));
        }
        // else {
        //     return view('frontend.forms.effectiveness-checkkjkjk', compact('old_record','parent_short_description', 'parent_initiator_id', 'parent_intiation_date', 'parent_division_id', 'parent_record', 'record', 'due_date', 'parent_id', 'parent_type'));
        // }
        if ($request->child_type == "rca") {
            // $cc->originator = User::where('id', $cc->initiator_id)->value('name');
            // $record_number = $record;
            return view('frontend.forms.root-cause-analysis', compact('record', 'due_date', 'parent_id', 'old_record', 'parent_type', 'parent_intiation_date', 'parent_record', 'parent_initiator_id', 'cft'));
        }
        if ($request->child_type == "extension") {
            $parent_name = "CAPA";
            $parent_due_date = "";
            $parent_id = $id;
            $parent_name = $request->$parent_name;
            if ($request->due_date) {
                $parent_due_date = $request->due_date;
            }

            $record = ((RecordNumber::first()->value('counter')) + 1);
            $record = str_pad($record, 4, '0', STR_PAD_LEFT);
            $record_number = $record;
            $relatedRecords = Helpers::getAllRelatedRecords();
            return view('frontend.extension.extension_new', compact('parent_id', 'parent_name', 'relatedRecords', 'record_number', 'parent_due_date', 'parent_type', 'parent_record'));
        }
    }

    public function effectiveness_check(Request $request, $id)
    {
        $record = ((RecordNumber::first()->value('counter')) + 1);
        $record = str_pad($record, 4, '0', STR_PAD_LEFT);
        $parent_id = $id;
        $parent_type = "CAPA";
        $parent_name = "CAPA";
        $parent_name = $request->$parent_name;
        $parent_record = Capa::where('id', $id)->value('record');
        $parent_record = str_pad($parent_record, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        $record_number = $record;
        return view("frontend.forms.effectiveness-check", compact('due_date', 'record_number', 'parent_id', 'parent_type', 'parent_record'));
    }


    public static function singleReport($id)
    {
        $data = Capa::find($id);

        if (!empty($data)) {
            $data->Product_Details = CapaGrid::where('capa_id', $id)->where('type', "Product_Details")->first();
            $data->Instruments_Details = CapaGrid::where('capa_id', $id)->where('type', "Instruments_Details")->first();
            $data->Material_Details = CapaGrid::where('capa_id', $id)->where('type', "Material_Details")->first();
            $data->originator = User::where('id', $data->initiator_id)->value('name');

            $capa_teamIdsArray = explode(',', $data->capa_team);
            $capa_teamNames = User::whereIn('id', $capa_teamIdsArray)->pluck('name')->toArray();
            $capa_teamNamesString = implode(', ', $capa_teamNames);

            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.capa.singleReport', compact('data', 'capa_teamNamesString'))
                ->setOptions([
                    'defaultFont' => 'sans-serif',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'isPhpEnabled' => true,
                ]);
            $pdf->setPaper('A4');
            $pdf->render();
            $canvas = $pdf->getDomPDF()->getCanvas();
            $height = $canvas->get_height();
            $width = $canvas->get_width();
            $canvas->page_script('$pdf->set_opacity(0.1,"Multiply");');
            $canvas->page_text($width / 4, $height / 2, $data->status, null, 25, [0, 0, 0], 2, 6, -20);

            
            $directoryPath = public_path("user/pdf/reg/");
            $filePath = $directoryPath . '/reg' . $id . '.pdf';

            if (!File::isDirectory($directoryPath)) {
                File::makeDirectory($directoryPath, 0755, true, true); // Recursive creation with read/write permissions
            }  

            $pdf->save($filePath);
            return $pdf->stream('CAPA' . $id . '.pdf');
        }
    }
    public function singleReportShow($id)
    {
        $data = Capa::find($id);
        return view('frontend.capa.capa_showpdf', compact('id', 'data'));
    }

    public static function familyReport($id)
    {
        $data = Capa::find($id);

        if (!empty($data)) {
            $data->Product_Details = CapaGrid::where('capa_id', $id)->where('type', "Product_Details")->first();
            $data->Instruments_Details = CapaGrid::where('capa_id', $id)->where('type', "Instruments_Details")->first();
            $data->Material_Details = CapaGrid::where('capa_id', $id)->where('type', "Material_Details")->first();
            $data->originator = User::where('id', $data->initiator_id)->value('name');

            $capa_teamIdsArray = explode(',', $data->capa_team);
            $capa_teamNames = User::whereIn('id', $capa_teamIdsArray)->pluck('name')->toArray();
            $capa_teamNamesString = implode(', ', $capa_teamNames);

            $Extension =  extension_new::where('parent_id', $id)->get();
            $ActionItem =  ActionItem::where('parent_id', $id)->get();
            $EffectivenessCheck =  EffectivenessCheck::where('parent_id', $id)->get();

            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.capa.capa_family_report', compact('data', 'capa_teamNamesString', 'Extension', 'ActionItem', 'EffectivenessCheck'))
                ->setOptions([
                    'defaultFont' => 'sans-serif',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'isPhpEnabled' => true,
                ]);
            $pdf->setPaper('A4');
            $pdf->render();
            $canvas = $pdf->getDomPDF()->getCanvas();
            $height = $canvas->get_height();
            $width = $canvas->get_width();
            $canvas->page_script('$pdf->set_opacity(0.1,"Multiply");');
            $canvas->page_text($width / 4, $height / 2, $data->status, null, 25, [0, 0, 0], 2, 6, -20);
            return $pdf->stream('CAPA' . $id . '.pdf');
        }
    }

    public static function auditReport($id)
    {
        $doc = Capa::find($id);
        if (!empty($doc)) {
            $doc->originator = User::where('id', $doc->initiator_id)->value('name');
            $data = CapaAuditTrial::where('capa_id', $id)->get();
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $data = $data->sortBy('created_at');
            $pdf = PDF::loadview('frontend.capa.auditReport', compact('data', 'doc'))
                ->setOptions([
                    'defaultFont' => 'sans-serif',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'isPhpEnabled' => true,
                ]);
            $pdf->setPaper('A4');
            $pdf->render();
            $canvas = $pdf->getDomPDF()->getCanvas();
            $height = $canvas->get_height();
            $width = $canvas->get_width();
            $canvas->page_script('$pdf->set_opacity(0.1,"Multiply");');
            $canvas->page_text($width / 4, $height / 2, $doc->status, null, 25, [0, 0, 0], 2, 6, -20);
            return $pdf->stream('CAPA-Audit' . $id . '.pdf');
        }
    }



    

    // CSV Export Function
    public function exportCsv(Request $request)
    {
        $query = Capa::query();
    
            if ($request->departmentCapa) {
                $query->where('initiator_Group', $request->departmentCapa);
            }
    
            if ($request->division_idcapa) {
                $query->where('division_id', $request->division_idcapa);
            }
    
            if ($request->CapaInitionThrough) {
                $query->where('initiated_through', $request->CapaInitionThrough);
            }
    
            if ($request->date_fromCapa) {
                $dateFrom = Carbon::parse($request->date_fromCapa)->startOfDay();
                $query->whereDate('intiation_date', '>=', $dateFrom);
            }
    
            if ($request->date_toCapa) {
                $dateTo = Carbon::parse($request->date_toCapa)->endOfDay();
                $query->whereDate('intiation_date', '<=', $dateTo);
            }
            $capa = $query->get();

        $fileName = 'capa_log_report.csv';
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
        ];

        $columns = [
            'Sr. No.', 'CAPA No.', 'Source Details', 'Department', 'CAPA Details',
            'Due Date', 'Recorded By', 'CAPA Extension Date', 'CAPA Closing Date', 'Status'
        ];

        $callback = function () use ($capa, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            if ($capa->isEmpty()) {
                fputcsv($file, ['No records found']);
            } else {
                foreach ($capa as $index => $row) {
                    $data = [
                        $index + 1, // Sr. No.
                        $row->capa_no ?? 'Not Applicable',
                        $row->initiated_through ?? 'Not Applicable',
                        $row->initiator_Group ?? 'Not Applicable',
                        $row->short_description ?? 'Not Applicable',
                        $row->due_date ? Carbon::parse($row->due_date)->format('d-M-Y') : 'Not Applicable',
                        $row->recorded_by ?? 'Not Applicable',
                        $row->capa_extension_date ? Carbon::parse($row->capa_extension_date)->format('d-M-Y') : '-',
                        $row->capa_closing_date ? Carbon::parse($row->capa_closing_date)->format('d-M-Y') : 'Not Applicable',
                        $row->status ?? 'Not Applicable'
                    ];
                    fputcsv($file, $data);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Excel Export Function
    public function exportExcel(Request $request)
    {
        $query = Capa::query();
    
            if ($request->departmentCapa) {
                $query->where('initiator_Group', $request->departmentCapa);
            }
    
            if ($request->division_idcapa) {
                $query->where('division_id', $request->division_idcapa);
            }
    
            if ($request->CapaInitionThrough) {
                $query->where('initiated_through', $request->CapaInitionThrough);
            }
    
            if ($request->date_fromCapa) {
                $dateFrom = Carbon::parse($request->date_fromCapa)->startOfDay();
                $query->whereDate('intiation_date', '>=', $dateFrom);
            }
    
            if ($request->date_toCapa) {
                $dateTo = Carbon::parse($request->date_toCapa)->endOfDay();
                $query->whereDate('intiation_date', '<=', $dateTo);
            }
        $capa = $query->get();


            $fileName = "capa_log_report.xls";
            $headers = [
            "Content-Type" => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
        ];

        $columns = [
            'Sr. No.', 'CAPA No.', 'Source Details', 'Department', 'CAPA Details',
            'Due Date', 'Recorded By', 'CAPA Extension Date', 'CAPA Closing Date', 'Status'
        ];

            $callback = function () use ($capa, $columns) {
            echo '<table border="1">';
            echo '<tr style="font-weight: bold; background-color: #1F4E79; color: #FFFFFF;">';
            foreach ($columns as $column) {
                echo "<th style='padding: 5px;'>" . htmlspecialchars($column) . "</th>";
            }
            echo '</tr>';

            if ($capa->isEmpty()) {
                echo '<tr>';
                echo "<td colspan='" . count($columns) . "' style='text-align: center;'>No records found</td>";
                echo '</tr>';
            } else {
                foreach ($capa as $index => $row) {
                    echo '<tr>';
                    echo "<td style='padding: 5px;'>" . ($index + 1) . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars($row->capa_no ?? 'Not Applicable') . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars($row->initiated_through ?? 'Not Applicable') . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars($row->initiator_Group ?? 'Not Applicable') . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars($row->short_description ?? 'Not Applicable') . "</td>";
                    echo "<td style='padding: 5px;'>" . ($row->due_date ? Carbon::parse($row->due_date)->format('d-M-Y') : 'Not Applicable') . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars($row->recorded_by ?? 'Not Applicable') . "</td>";
                    echo "<td style='padding: 5px;'>" . ($row->capa_extension_date ? Carbon::parse($row->capa_extension_date)->format('d-M-Y') : '-') . "</td>";
                    echo "<td style='padding: 5px;'>" . ($row->capa_closing_date ? Carbon::parse($row->capa_closing_date)->format('d-M-Y') : 'Not Applicable') . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars($row->status ?? 'Not Applicable') . "</td>";
                    echo '</tr>';
                }
            }

            echo '</table>';
        };

        return response()->stream($callback, 200, $headers);
    }

    public function capaActivityLog($id)
    {
        $data = Capa::find($id);
        $Capadata = Capa::find($id);

        

        if (!empty($data)) {
            // $data->Product_Details = CapaGrid::where('capa_id', $id)->where('type', "Product_Details")->first();
            // $data->Instruments_Details = CapaGrid::where('capa_id', $id)->where('type', "Instruments_Details")->first();
            // $data->Material_Details = CapaGrid::where('capa_id', $id)->where('type', "Material_Details")->first();
            // $data->originator = User::where('id', $data->initiator_id)->value('name');

            // $capa_teamIdsArray = explode(',', $data->capa_team);
            // $capa_teamNames = User::whereIn('id', $capa_teamIdsArray)->pluck('name')->toArray();
            // $capa_teamNamesString = implode(', ', $capa_teamNames);

            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.Capa.activity-log', compact('data','Capadata' ))
                ->setOptions([
                    'defaultFont' => 'sans-serif',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'isPhpEnabled' => true,
                ]);
            $pdf->setPaper('A4');
            $pdf->render();
            $canvas = $pdf->getDomPDF()->getCanvas();
            $height = $canvas->get_height();
            $width = $canvas->get_width();
            $canvas->page_script('$pdf->set_opacity(0.1,"Multiply");');
            $canvas->page_text($width / 4, $height / 2, $data->status, null, 25, [0, 0, 0], 2, 6, -20);
            return $pdf->stream('Capa_Activity_log' . $id . '.pdf');
        }
    }
}
