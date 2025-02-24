<?php

namespace App\Http\Controllers\rcms;

use App\Http\Controllers\Controller;
use App\Models\RecordNumber;
use App\Models\ActionItem;
use App\Models\RootAuditTrial;
use App\Models\RootCFt;
use App\Models\RoleGroup;

use App\Models\RiskAssesmentGrid;
use App\Models\CapaGrid;
use App\Models\RootCauseAnalysis;
use App\Models\RootCauseAnalysesGrid;
use App\Models\NotificationUser;
use App\Models\RootCauseAnalysisHistory;
use App\Models\Capa;
use App\Models\OpenStage;
use App\Models\User;
use Helpers;
use Illuminate\Support\Facades\Mail;
use App\Models\RootcauseAnalysisDocDetails;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

 class RootCauseController extends Controller
{
    public function rootcause()
    {
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        return view("frontend.forms.root-cause-analysis", compact('due_date', 'record_number'));
    }

    public function root_store(Request $request)
    { 

    //  dd($request->all());

        $lastDocument='Null';
        if (!$request->short_description) {
           toastr()->error("Short description is required");
             return redirect()->back();
        }
        $root = new RootCauseAnalysis();
        $root->form_type = "Root Cause Analysis"; 
        $root->parent_id = $request->parent_id;
        $root->parent_type = $request->parent_type;
        $root->originator_id = $request->originator_id;
        $root->date_opened = $request->date_opened;
        $root->division_id = $request->division_id;
        $root->priority_level = $request->priority_level;
        $root->severity_level = $request->severity_level;
        $root->priority_data = $request->priority_data;
        $root->short_description =($request->short_description);
        $root->assigned_to = $request->assigned_to;
        $root->assign_to = $request->assign_to;
        $root->root_cause_description = $request->root_cause_description;
        $root->due_date = $request->due_date;
        $root->cft_comments_new = $request->cft_comments_new;
        $root->hod_final_comments = $request->hod_final_comments;
        $root->qa_final_comments = $request->qa_final_comments;
        $root->qah_final_comments = $request->qah_final_comments;
         $root->Type= $request->Type;
        
         $root->investigators = $request->investigators;
        // $root->investigators = implode(',', $request->investigators);
        $root->initiated_through = $request->initiated_through;
        $root->initiated_if_other = $request->initiated_if_other;
        // $root->department = $request->department;
        $root->department = implode(',', $request->departments);
        $root->description = ($request->description);
        $root->comments = ($request->comments);
        $root->related_url = ($request->related_url);
        $root->root_cause_methodology = implode(',', $request->root_cause_methodology);
        //Fishbone or Ishikawa Diagram 
        if (!empty($request->measurement  )) {
            $root->measurement = serialize($request->measurement);
        }
        if (!empty($request->materials  )) {
            $root->materials = serialize($request->materials);
        }
        if (!empty($request->environment  )) {
            $root->environment = serialize($request->environment);
        }
        if (!empty($request->manpower  )) {
            $root->manpower = serialize($request->manpower);
        }
        if (!empty($request->machine  )) {
            $root->machine = serialize($request->machine);
        }
        if (!empty($request->methods)) {
            $root->methods = serialize($request->methods);
        }
        $root->problem_statement = ($request->problem_statement);
        // Why-Why Chart (Launch Instruction) Problem Statement 
        if (!empty($request->why_problem_statement)) {
            $root->why_problem_statement = $request->why_problem_statement;
        }
        if (!empty($request->why_1  )) {
            $root->why_1 = serialize($request->why_1);
        }
        if (!empty($request->why_2  )) {
            $root->why_2 = serialize($request->why_2);
        }
        if (!empty($request->why_3  )) {
            $root->why_3 = serialize($request->why_3);
        }
        if (!empty($request->why_4 )) {
            $root->why_4 = serialize($request->why_4);
        }
        if (!empty($request->why_5  )) {
            $root->why_5 = serialize($request->why_5);
        }
        if (!empty($request->why_root_cause)) {
            $root->why_root_cause = $request->why_root_cause;
        }

        // Is/Is Not Analysis (Launch Instruction)
        $root->what_will_be = ($request->what_will_be);
        $root->what_will_not_be = ($request->what_will_not_be);
        $root->what_rationable = ($request->what_rationable);

        $root->where_will_be = ($request->where_will_be);
        $root->where_will_not_be = ($request->where_will_not_be);
        $root->where_rationable = ($request->where_rationable);

        $root->when_will_be = ($request->when_will_be);
        $root->when_will_not_be = ($request->when_will_not_be);
        $root->when_rationable = ($request->when_rationable);

        $root->coverage_will_be = ($request->coverage_will_be);
        $root->coverage_will_not_be = ($request->coverage_will_not_be);
        $root->coverage_rationable = ($request->coverage_rationable);

        $root->who_will_be = ($request->who_will_be);
        $root->who_will_not_be = ($request->who_will_not_be);
        $root->who_rationable = ($request->who_rationable);
        
        $root->investigation_summary = ($request->investigation_summary);
        // $root->zone = ($request->zone);
        // $root->country = ($request->country);
        // $root->state = ($request->state);
        // $root->city = ($request->city);
        $root->submitted_by = ($request->submitted_by);

        if (!empty($request->Root_Cause_Category  )) {
            $root->Root_Cause_Category = serialize($request->Root_Cause_Category);
        }
        if (!empty($request->Root_Cause_Sub_Category)) {
            $root->Root_Cause_Sub_Category= serialize($request->Root_Cause_Sub_Category);
        }
        if (!empty($request->Probability)) {
            $root->Probability = serialize($request->Probability);
        }
        if (!empty($request->Remarks)) {
            $root->Remarks = serialize($request->Remarks);
        }

        if (!empty($request->initial_rpn)) {
            $root->initial_rpn = serialize($root->initial_rpn);
        }

        $root->record = ((RecordNumber::first()->value('counter')) + 1);
        $root->initiator_id = Auth::user()->id;
        $root->division_code = $request->division_code;
        $root->intiation_date = $request->intiation_date;
        $root->initiator_Group = $request->initiator_Group;
        $root->initiator_group_code = $request->initiator_group_code;
        $root->short_description = $request->short_description;
        $root->due_date = $request->due_date;
        $root->assign_to = $request->assign_to;
        $root->Sample_Types = $request->Sample_Types;
        if (!empty($request->root_cause_initial_attachment)) {
            $files = [];
            if ($request->hasfile('root_cause_initial_attachment')) {
                foreach ($request->file('root_cause_initial_attachment') as $file) {
                    $name = $request->name . 'root_cause_initial_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $root->root_cause_initial_attachment = json_encode($files);
        }
        if (!empty($request->cft_attchament_new)) {
            $files = [];
            if ($request->hasfile('cft_attchament_new')) {
                foreach ($request->file('cft_attchament_new') as $file) {
                    $name = $request->name . 'cft_attchament_new' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $root->cft_attchament_new = json_encode($files);
        }
        
        //Failure Mode and Effect Analysis+

        if (!empty($request->risk_factor)) {
            $root->risk_factor = serialize($request->risk_factor);
        }
        if (!empty($request->risk_element)) {
            $root->risk_element = serialize($request->risk_element);
        }
        if (!empty($request->problem_cause)) {
            $root->problem_cause = serialize($request->problem_cause);
        }
        if (!empty($request->existing_risk_control)) {
            $root->existing_risk_control = serialize($request->existing_risk_control);
        }
        if (!empty($request->initial_severity)) {
            $root->initial_severity = serialize($request->initial_severity);
        }
        if (!empty($request->initial_detectability)) {
            $root->initial_detectability = serialize($request->initial_detectability);
        }
        if (!empty($request->initial_probability)) {
            $root->initial_probability = serialize($request->initial_probability);
        }
        if (!empty($request->initial_rpn)) {
            $root->initial_rpn = serialize($request->initial_rpn);
        }
        if (!empty($request->risk_acceptance)) {
            $root->risk_acceptance = serialize($request->risk_acceptance);
        }
        if (!empty($request->risk_control_measure)) {
            $root->risk_control_measure = serialize($request->risk_control_measure);
        }
        if (!empty($request->residual_severity)) {
            $root->residual_severity = serialize($request->residual_severity);
        }
        if (!empty($request->residual_probability)) {
            $root->residual_probability = serialize($request->residual_probability);
        }
        if (!empty($request->residual_detectability)) {
            $root->residual_detectability = serialize($request->residual_detectability);
        }
        if (!empty($request->residual_rpn)) {
            $root->residual_rpn = serialize($request->residual_rpn);
        }
        if (!empty($request->risk_acceptance2)) {
            $root->risk_acceptance2 = serialize($request->risk_acceptance2);
        }
        if (!empty($request->mitigation_proposal)) {
            $root->mitigation_proposal = serialize($request->mitigation_proposal);
        }
      
        
        //observation changes
        $root->objective = $request->objective;
        $root->scope = $request->scope;
        $root->problem_statement_rca = $request->problem_statement_rca;
        $root->requirement = $request->requirement;
        $root->immediate_action = $request->immediate_action;
      //  $root->investigation_team = implode(',', $request->investigation_team);
        
      if (is_array($request->investigation_team)) {
        $root->investigation_team = implode(',', $request->investigation_team);
          }
        $root->investigation_tool = $request->investigation_tool;
        $root->root_cause = $request->root_cause;

        $root->impact_risk_assessment = $request->impact_risk_assessment;
        $root->capa = $request->capa;
        $root->root_cause_description_rca = $request->root_cause_description_rca;
        $root->investigation_summary_rca = $request->investigation_summary_rca;
     
        $root->qa_reviewer = $request->qa_reviewer;



        $root->qa_cqa_approval_comment = $request->qa_cqa_approval_comment;


        if (!empty($request->qa_cqa_approval_attach)) {
            $files = [];
            if ($request->hasfile('qa_cqa_approval_attach')) {
                foreach ($request->file('qa_cqa_approval_attach') as $file) {
                    $name = $request->name . 'qa_cqa_approval_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $root->qa_cqa_approval_attach = json_encode($files);
        }


        if (!empty($request->root_cause_initial_attachment_rca)) {
            $files = [];
            if ($request->hasfile('root_cause_initial_attachment_rca')) {
                foreach ($request->file('root_cause_initial_attachment_rca') as $file) {
                    $name = $request->name . 'root_cause_initial_attachment_rca' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $root->root_cause_initial_attachment_rca = json_encode($files);
        }
           if (!empty($request->qah_final_attachments)) {
            $files = [];
            if ($request->hasfile('qah_final_attachments')) {
                foreach ($request->file('qah_final_attachments') as $file) {
                    $name = $request->name . 'qah_final_attachments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $root->qah_final_attachments = json_encode($files);
        }
          if (!empty($request->hod_final_attachments)) {
            $files = [];
            if ($request->hasfile('hod_final_attachments')) {
                foreach ($request->file('hod_final_attachments') as $file) {
                    $name = $request->name . 'hod_final_attachments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $root->hod_final_attachments = json_encode($files);
        }
          if (!empty($request->qa_final_attachments)) {
            $files = [];
            if ($request->hasfile('qa_final_attachments')) {
                foreach ($request->file('qa_final_attachments') as $file) {
                    $name = $request->name . 'qa_final_attachments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $root->qa_final_attachments = json_encode($files);
        }


        $root->status = 'Opened';
        $root->stage = 1;
        $root->save();
        // -------------------------------------------------------
        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        
        $record->update();

        // $userNotification = new NotificationUser();
        // $userNotification->record_id = $root->id;
        // $userNotification->record_type = "Root Cause Analysis";
        // $userNotification->to_id = Auth::user()->id;
        // $userNotification->save();
        

  
        if(!empty($root->record))
    {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Record Number';
        $history->previous = "Null";
        $history->current = Helpers::getDivisionName(session()->get('division')) . "/RCA/" . date('Y') . "/" . str_pad($root->record, 4, '0', STR_PAD_LEFT);
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->intiation_date))
    {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Date of Initiation';
        $history->previous = "Null";
        $history->current =  Helpers::getdateFormat($request->intiation_date);
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }
    if(!empty($request->originator_id))
    {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Initiator';
        $history->previous = "Null";
        $history->current = $request->originator_id;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }
    if(!empty($request->division_code)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Site/Location Code';
        $history->previous = "Null";
        $history->current = $root->division_code;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create'; 
        $history->save();
    }

    if(!empty($request->short_description))
    {
      

        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Short Description';
        $history->previous = "Null";
        $history->current = $root->short_description;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }
    if(!empty($request->due_date))
    {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Due Date';
        $history->previous = "Null";
        $history->current = Helpers::getdateFormat( $root->due_date);
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->initiator_Group)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Initiator Department';
        $history->previous = "Null";
        $history->current = Helpers::getFullDepartmentName($root->initiator_Group);
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->initiator_Group))
    {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Initiator Department Code';
        $history->previous = "Null";
        $history->current = $root->initiator_Group;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->severity_level))
    {
      
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Severity Level';
        $history->previous = "Null";
        $history->current = $root->severity_level;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->assign_to)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Department Head ';
        $history->previous = "Null";
        $history->current = Helpers::getInitiatorName ($root->assign_to);
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to =   "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }


    if(!empty($request->qa_reviewer)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'QA Reviewer';
        $history->previous = "Null";
        $history->current = Helpers::getInitiatorName($root->qa_reviewer);
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }
    
     if(!empty($request->initiated_through)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Initiated Through';
        $history->previous = "Null";
        $history->current = $root->initiated_through;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
        $history->save();
    }

    if(!empty($request->initiated_if_other)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others';
        $history->previous = "Null";
        $history->current = $root->initiated_if_other;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
        $history->save();
    }

    if(!empty($request->Type)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Type';
        $history->previous = "Null";
        $history->current = $root->Type;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();
    }

    if(!empty($request->priority_data)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Priority';
        $history->previous = "Null";
        $history->current = $root->priority_data;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
        $history->save();
    }

    if(!empty($root->department)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Responsible Department';
        $history->previous = "Null";
        $history->current = $root->department;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
        $history->save();
    }


    if(!empty($request->description)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Description';
        $history->previous = "Null";
        $history->current =  $root->description;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';    
        $history->save();
    }

    if(!empty($request->comments)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Comments';
        $history->previous = "Null";
        $history->current =  $root->comments;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
        $history->save();
    }

    if(!empty($request->root_cause_initial_attachment)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Initial Attachment';
        $history->previous = "Null";
        $history->current =  str_replace(',', ', ', $root->root_cause_initial_attachment);
        //empty($root->root_cause_initial_attachment) ? null:$root->root_cause_initial_attachment;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';     
        $history->save();
    }

    if(!empty($request->root_cause_initial_attachment_rca)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Investigation Attachment';
        $history->previous = "Null";
        $history->current = str_replace(',', ', ', $root->root_cause_initial_attachment_rca);
        //empty($root->root_cause_initial_attachment) ? null:$root->root_cause_initial_attachment;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';     
        $history->save();
    }

    if(!empty($request->objective)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Objective';
        $history->previous = "Null";
        $history->current = $root->objective;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';     
        $history->save();
    }

    if(!empty($request->scope)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Scope';
        $history->previous = "Null";
        $history->current = $root->scope;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';     
        $history->save();
    }

    if(!empty($request->problem_statement_rca)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Problem Statement';
        $history->previous = "Null";
        $history->current = $root->problem_statement_rca;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';     
        $history->save();
    }

    if(!empty($request->requirement)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Background';
        $history->previous = "Null";
        $history->current = $root->requirement;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';     
        $history->save();
    }

    if(!empty($request->immediate_action)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Immediate Action';
        $history->previous = "Null";
        $history->current = $root->immediate_action;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';     
        $history->save();
    }

    if(!empty($root->investigation_team)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Investigation Team';
        $history->previous = "Null";
        $history->current =  $root->investigation_team;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';     
        $history->save();
    }

    if(!empty($root->root_cause_methodology)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Root Cause Methodology';
        $history->previous = "Null";
        $history->current = $root->root_cause_methodology;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';     
        $history->save();
    }

    if(!empty($request->related_url)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Related URL';
        $history->previous = "Null";
        $history->current = $root->related_url;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';     
        $history->save();
    }

    

//    $lastDocument = RootAuditTrial::where('root_id', $root->id)->orderBy('created_at', 'desc')->first();

//  if ($lastDocument->root_cause_methodology != $root->root_cause_methodology|| !empty($request->comment)) {

//        $history = new RootAuditTrial();
//        $history->root_id = $root->id;
//        $history->activity_type = 'Root Cause Methodology';
//        $history->previous = $lastDocument->root_cause_methodology;
//        $history->current = $root->root_cause_methodology;
//        $history->comment = $request->comment;
//        $history->user_id = Auth::user()->id;
//        $history->user_name = Auth::user()->name;
//        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
//        $history->origin_state = $lastDocument->status;
//        $history->change_to =   "Opened";
//        $history->change_from = "Initiation";
//        $history->action_name = 'Create';
//        $history->save();
//    }
  

    if(!empty($request->root_cause_description_rca))
    {

        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Root Cause Description';
        $history->previous = "Null";
        $history->current = $root->root_cause_description_rca;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();

    }


    if(!empty($request->investigation_summary_rca))
    {

        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Investigation Summary';
        $history->previous = "Null";
        $history->current = $root->investigation_summary_rca;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();

    }


    if(!empty($request->cft_comments_new)){

        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'QA Review Comments';
        $history->previous = "Null";
        $history->current = $root->cft_comments_new;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();

    }
       if(!empty($request->hod_final_comments))
    {

        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'HOD Final Review Comments';
        $history->previous = "Null";
        $history->current = $root->hod_final_comments;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();

    }
       if(!empty($request->hod_final_attachments))
    {

        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'HOD Final Review Attachment';
        $history->previous = "Null";
        $history->current = str_replace(',', ', ', $root->hod_final_attachments);
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();

    }

    if(!empty($request->qa_final_comments)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'QA Final Review Comments';
        $history->previous = "Null";
        $history->current =  $root->qa_final_comments;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
        $history->save();

    }

       if(!empty($request->qa_final_attachments))
    {

        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'QA Final Review Attachment';
        $history->previous = "Null";
        $history->current = str_replace(',', ', ', $root->qa_final_attachments);
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();

    }
           if(!empty($request->qah_final_comments))
    {

        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'QAH/CQAH Final Review Comments';
        $history->previous = "Null";
        $history->current =  $root->qah_final_comments;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();

    }
       if(!empty($request->qah_final_attachments))
    {

        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'QAH/CQAH Final Review Attachment';
        $history->previous = "Null";
        $history->current = str_replace(',', ', ', $root->qah_final_attachments);
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();

    }


    if(!empty($request->cft_attchament_new))
    {

        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'QA Review Attachment';
        $history->previous = "Null";
        $history->current = str_replace(',', ', ', $root->cft_attchament_new);
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';
     
        $history->save();

    }

    if(!empty($request->root_cause)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Root Cause';
        $history->previous = "Null";
        $history->current = $root->root_cause;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';   
        $history->save();

    }

    if(!empty($request->impact_risk_assessment)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Impact / Risk Assessment';
        $history->previous = "Null";
        $history->current =  $root->impact_risk_assessment;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';   
        $history->save();

    }

    if(!empty($request->capa)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'CAPA';
        $history->previous = "Null";
        $history->current =  $root->capa;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to = "Opened";
        $history->change_from = "Null";
        $history->action_name = 'Create';   
        $history->save();

    }
//--------------------------------------------------------------------------
// $lastDocument = RootAuditTrial::where('root_id', $root->id)->orderBy('created_at', 'desc')->first();
    

// $failure_mode_grid = [
//     'risk_factor' => 'Risk Factor',
//     'risk_element' => 'Risk element',
//     'problem_cause' => 'Probable cause of risk element',
//     'existing_risk_control' => 'Existing Risk Controls',
//     'initial_severity' => 'Initial Severity',
//     'initial_probability' => 'Initial Probability',
//     'initial_detectability' => 'Initial Detectability',
//     'initial_rpn' => 'Initial RPN',
//     'risk_acceptance' => 'Risk Acceptance',
//     'risk_control_measure' => 'Proposed Additional Risk control measure',
//     'residual_severity' => 'Residual Severity',
//     'residual_probability' => 'Residual Probability',
//     'residual_detectability' => 'Residual Detectability',
//     'residual_rpn' => 'Residual RPN',
//     'risk_acceptance2' => 'Risk Acceptance',
//     'mitigation_proposal' => 'Mitigation proposal',
// ];

// foreach ($failure_mode_grid as $key => $value) {
//     if (!empty($request->$key)) {
//         $currentValue = $request->$key;

//         // If the current value is an array, convert it to a comma-separated string
//         if (is_array($currentValue)) {
//             $currentValue = implode(', ', $currentValue);
//         }

//         // Get previous value from the last document
//         $previousValue = !empty($lastDocument->$key) ? $lastDocument->$key : '';

//         // Compare the values, if same and no comment, don't save
//         if ($previousValue != $currentValue || !empty($request->comment)) {
//             $history = new RootAuditTrial();
//             $history->root_id = $root->id;
//             $history->activity_type = $value;
//             $history->previous = $previousValue; // Store the previous value
//             $history->current = $currentValue;
//                   $history->comment = "Not Applicable"; // Add comment if required
//             $history->user_id = Auth::user()->id;
//             $history->user_name = Auth::user()->name;
//             $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
//             $history->origin_state = $root->status;
//             $history->change_to = "Opened";
//            $history->change_from = "Initiation";
//             $history->action_name = 'Create';

//             $history->save();
//         }
//     }
// }
  
//     $root_case_grid = [
//         'Root_Cause_Category' => ' Root Cause Category',
//         'Root_Cause_Sub_Category' => 'Root Cause Sub Category',
//         'Probability' => 'Probability',
//         'Remarks' => 'Remarks',
        
//     ];
    
//     foreach ($root_case_grid as $key => $value) {
//         if (!empty($request->$key)) {
//             $currentValue = $request->$key;
    
//             // If the current value is an array, convert it to a comma-separated string
//             if (is_array($currentValue)) {
//                 $currentValue = implode(', ', $currentValue);
//             }
    
//             // Get previous value from the last document
//             $previousValue = !empty($lastDocument->$key) ? $lastDocument->$key : '';
    
//             // Compare the values, if same and no comment, don't save
//             if ($previousValue != $currentValue || !empty($request->comment)) {
//                 $history = new RootAuditTrial();
//                 $history->root_id = $root->id;
//                 $history->activity_type = $value;
//                 $history->previous = $previousValue; // Store the previous value
//                 $history->current = $currentValue;
//                       $history->comment = "Not Applicable"; // Add comment if required
//                 $history->user_id = Auth::user()->id;
//                 $history->user_name = Auth::user()->name;
//                 $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
//                 $history->origin_state = $root->status;
//                 $history->change_to = "Opened";
//                $history->change_from = "Initiation";
//                 $history->action_name = 'Create';
    
//                 $history->save();
//             }
//         }
//     }
  
    
//    // $lastDocument = RootAuditTrial::where('root_id', $root->id)->orderBy('created_at', 'desc')->first();

//     $Fishbone_or_ishikawa_diagram = [
//         'measurement' => 'Measurement',
//         'materials' => 'Materials ',
//         'methods' => 'Methods ',
//         'environment' => 'Environment ',
//         'manpower' => 'Manpower ',
//         'machine' => 'Machine ',
//         'problem_statement' => 'Problem Statement ',
//     ];
    
//     foreach ($Fishbone_or_ishikawa_diagram as $key => $value) {
//         if (!empty($request->$key)) {
//             $currentValue = $request->$key;
    
//             // If the current value is an array, convert it to a comma-separated string
//             if (is_array($currentValue)) {
//                 $currentValue = implode(', ', $currentValue);
//             }
    
//             // Get previous value from the last document
//             $previousValue = !empty($lastDocument->$key) ? $lastDocument->$key : '';
    
//             // Compare the values, if same and no comment, don't save
//             if ($previousValue != $currentValue || !empty($request->comment)) {
//                 $history = new RootAuditTrial();
//                 $history->root_id = $root->id;
//                 $history->activity_type = $value;
//                 $history->previous = $previousValue; // Store the previous value
//                 $history->current = $currentValue;
//                       $history->comment = "Not Applicable"; // Add comment if required
//                 $history->user_id = Auth::user()->id;
//                 $history->user_name = Auth::user()->name;
//                 $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
//                 $history->origin_state = $root->status;
//                 $history->change_to = "Opened";
//                $history->change_from = "Initiation";
//                 $history->action_name = 'Create';
    
//                 $history->save();
//             }
//         }
//     }
    


    
//     $why_why_chart  = [
//         'why_problem_statement' => 'Problem Statement',
//         'why_1' => ' Why 1',
//         'why_2' => '  Why 2',
//         'why_3' => '  Why 3',
//         'why_4' => '  Why 4',
//         'why_5' => '  Why 5',
//         'why_root_cause' => 'Root Cause',
//     ];
//     foreach ($why_why_chart as $key => $value) {
//         if (!empty($request->$key)) {
//             $currentValue = $request->$key;
    
//             // If the current value is an array, convert it to a comma-separated string
//             if (is_array($currentValue)) {
//                 $currentValue = implode(', ', $currentValue);
//             }
    
//             // Get previous value from the last document
//             $previousValue = !empty($lastDocument->$key) ? $lastDocument->$key : '';
    
//             // Compare the values, if same and no comment, don't save
//             if ($previousValue != $currentValue || !empty($request->comment)) {
//                 $history = new RootAuditTrial();
//                 $history->root_id = $root->id;
//                 $history->activity_type = $value;
//                 $history->previous = $previousValue; // Store the previous value
//                 $history->current = $currentValue;
//                       $history->comment = "Not Applicable"; // Add comment if required
//                 $history->user_id = Auth::user()->id;
//                 $history->user_name = Auth::user()->name;
//                 $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
//                 $history->origin_state = $root->status;
//                 $history->change_to = "Opened";
//                $history->change_from = "Initiation";
//                 $history->action_name = 'Create';
    
//                 $history->save();
//             }
//         }
//     }
  

//     $is_is_not_analysis  = [
//         'what_will_be' => ' What / Will Be',
//         'what_will_not_be' => 'what / Will Not Be',
//         'what_rationable' => 'what / Rational',

//         'where_will_be' => ' Where / Will Be',
//         'where_will_not_be' => ' Where / Will Not Be',
//         'where_rationable' => ' Where / Rational',

//         'when_will_be' => ' When / Will Be',
//         'when_will_not_be' => 'When / Will Not Be ',
//         'when_rationable' => 'When / Retional ',

//         'coverage_will_be' => 'Coverage / Will Be',
//         'coverage_will_not_be' => 'Coverage / Will Not Be',
//         'coverage_rationable' => 'Coverage / Retional',

//         'who_will_be' => 'Who / will Be ',
//         'who_will_not_be' => 'Who / Will Not Be',
//         'who_rationable' => ' Who / Retional',
//     ];
    
//     foreach ($is_is_not_analysis as $key => $value) {
//         if (!empty($request->$key)) {
//             $currentValue = $request->$key;
    
//             // If the current value is an array, convert it to a comma-separated string
//             if (is_array($currentValue)) {
//                 $currentValue = implode(', ', $currentValue);
//             }
    
//             // Get previous value from the last document
//             $previousValue = !empty($lastDocument->$key) ? $lastDocument->$key : '';
    
//             // Compare the values, if same and no comment, don't save
//             if ($previousValue != $currentValue || !empty($request->comment)) {
//                 $history = new RootAuditTrial();
//                 $history->root_id = $root->id;
//                 $history->activity_type = $value;
//                 $history->previous = $previousValue; // Store the previous value
//                 $history->current = $currentValue;
//                       $history->comment = "Not Applicable"; // Add comment if required
//                 $history->user_id = Auth::user()->id;
//                 $history->user_name = Auth::user()->name;
//                 $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
//                 $history->origin_state = $root->status;
//                 $history->change_to = "Opened";
//                $history->change_from = "Initiation";
//                 $history->action_name = 'Create';
    
//                 $history->save();
//             }
//         }
//     }
   
        // $history = new RootAuditTrial();
        // $history->root_id = $root->id;
        // $history->activity_type = 'Sample Types';
        // $history->previous = "Null";
        // $history->current = $root->Sample_Types;
        //       $history->comment = "Not Applicable";
        // $history->user_id = Auth::user()->id;
        // $history->user_name = Auth::user()->name;
        // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        // $history->origin_state = $root->status;
        // $history->change_to =   "Opened";
        // $history->change_from = "Initiator";
        // $history->action_name = 'Create';
     
        // $history->save();
 

        // $history = new RootAuditTrial();
        // $history->root_id = $root->id;
        // $history->activity_type = 'Investigators';
        // $history->previous = "Null";
        // $history->current = $root->investigators;
        //       $history->comment = "Not Applicable";
        // $history->user_id = Auth::user()->id;
        // $history->user_name = Auth::user()->name;
        // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        // $history->origin_state = $root->status;
        // $history->change_to =   "Opened";
        // $history->change_from = "Initiator";
        // $history->action_name = 'Create';
     
        // $history->save();

        // $history = new RootAuditTrial();
        // $history->root_id = $root->id;
        // $history->activity_type = 'Attachments';
        // $history->previous = "Null";
        // $history->current = empty($root->cft_attchament_new) ? null : $root->cft_attchament_new;
        //       $history->comment = "Not Applicable";
        // $history->user_id = Auth::user()->id;
        // $history->user_name = Auth::user()->name;
        // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        // $history->origin_state = $root->status;
        // $history->change_to =   "Opened";
        // $history->change_from = "Initiator";
        // $history->action_name = 'Create';
     
        // $history->save();

        // $history = new RootAuditTrial();
        // $history->root_id = $root->id;
        // $history->activity_type = 'Comments';
        // $history->previous = "Null";
        // $history->current = $root->comments;
        //       $history->comment = "Not Applicable";
        // $history->user_id = Auth::user()->id;
        // $history->user_name = Auth::user()->name;
        // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        // $history->origin_state = $root->status;
        // $history->change_to =   "Opened";
        // $history->change_from = "Initiator";
        // $history->action_name = 'Create';
     
        // $history->save();

        // $history = new RootAuditTrial();
        // $history->root_id = $root->id;
        // $history->activity_type = 'Lab Inv Concl';
        // $history->previous = "Null";
        // $history->current = $root->lab_inv_concl;
        //       $history->comment = "Not Applicable";
        // $history->user_id = Auth::user()->id;
        // $history->user_name = Auth::user()->name;
        // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        // $history->origin_state = $root->status;
        // $history->change_to =   "Opened";
        // $history->change_from = "Initiator";
        // $history->action_name = 'Create';
     
        // $history->save();

        // $history = new RootAuditTrial();
        // $history->root_id = $root->id;
        // $history->activity_type = 'lab Inv Attach';
        // $history->previous = "Null";
        // $history->current = $root->lab_inv_attach;
        //       $history->comment = "Not Applicable";
        // $history->user_id = Auth::user()->id;
        // $history->user_name = Auth::user()->name;
        // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        // $history->origin_state = $root->status;
        // $history->change_to =   "Opened";
        // $history->change_from = "Initiator";
        // $history->action_name = 'Create';
     
        // $history->save();

        // $history = new RootAuditTrial();
        // $history->root_id = $root->id;
        // $history->activity_type = 'Qc Head Comments';
        // $history->previous = "Null";
        // $history->current = $root->qc_head_comments;
        //       $history->comment = "Not Applicable";
        // $history->user_id = Auth::user()->id;
        // $history->user_name = Auth::user()->name;
        // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        // $history->origin_state = $root->status;
        // $history->change_to =   "Opened";
        // $history->change_from = "Initiator";
        // $history->action_name = 'Create';
     
        // $history->save();

        // $history = new RootAuditTrial();
        // $history->root_id = $root->id;
        // $history->activity_type = 'Inv Attach';
        // $history->previous = "Null";
        // $history->current = $root->inv_attach;
        //       $history->comment = "Not Applicable";
        // $history->user_id = Auth::user()->id;
        // $history->user_name = Auth::user()->name;
        // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        // $history->origin_state = $root->status;
        // $history->change_to =   "Opened";
        // $history->change_from = "Initiator";
        // $history->action_name = 'Create';
     
        // $history->save();

        // if (!empty($root->due_date)) {
        // $history = new RootAuditTrial();
        // $history->root_id = $root->id;
        // $history->activity_type = 'Due Date';
        // $history->previous = "Null";
        // $history->current = $root->due_date;
        //       $history->comment = "Not Applicable";
        // $history->user_id = Auth::user()->id;
        // $history->user_name = Auth::user()->name;
        // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        // $history->origin_state = $root->status;
        // $history->change_to =   "Opened";
        // $history->change_from = "Initiator";
        // $history->action_name = 'Create';
     
        // $history->save();

        // }


         /* CFT Data Feilds Start */

         $Cft = new RootCFt();
         $Cft->root_cause_analyses_id = $root->id;
         $Cft->Production_Review = $request->Production_Review;
         $Cft->Production_person = $request->Production_person;
         $Cft->Production_assessment = $request->Production_assessment;
         $Cft->Production_feedback = $request->Production_feedback;
         $Cft->production_on = $request->production_on;
         $Cft->production_by = $request->production_by;
 
         $Cft->RA_Review = $request->RA_Review;
         $Cft->RA_Comments = $request->RA_Comments;
         $Cft->RA_person = $request->RA_person;
         $Cft->RA_assessment = $request->RA_assessment;
         $Cft->RA_feedback = $request->RA_feedback;
         $Cft->RA_attachment = $request->RA_attachment;
         $Cft->RA_by = $request->RA_by;
         $Cft->RA_on = $request->RA_on;
 
         $Cft->Production_Table_Review = $request->Production_Table_Review;
         $Cft->Production_Table_Person = $request->Production_Table_Person;
         $Cft->Production_Table_Assessment = $request->Production_Table_Assessment;
         $Cft->Production_Table_Feedback = $request->Production_Table_Feedback;
         $Cft->Production_Table_Attachment = $request->Production_Table_Attachment;
         $Cft->Production_Table_By = $request->Production_Table_By;
         $Cft->Production_Table_On = $request->Production_Table_On;
 
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
 
         $Cft->Analytical_Development_review = $request->Analytical_Development_review;
         $Cft->Analytical_Development_person = $request->Analytical_Development_person;
         $Cft->Analytical_Development_assessment = $request->Analytical_Development_assessment;
         $Cft->Analytical_Development_feedback = $request->Analytical_Development_feedback;
         $Cft->Analytical_Development_by = $request->Analytical_Development_by;
         $Cft->Analytical_Development_on = $request->Analytical_Development_on;
 
         $Cft->Kilo_Lab_review = $request->Kilo_Lab_review;
         $Cft->Kilo_Lab_person = $request->Kilo_Lab_person;
         $Cft->Kilo_Lab_assessment = $request->Kilo_Lab_assessment;
         $Cft->Kilo_Lab_feedback = $request->Kilo_Lab_feedback;
         $Cft->Kilo_Lab_attachment_by = $request->Kilo_Lab_attachment_by;
         $Cft->Kilo_Lab_attachment_on = $request->Kilo_Lab_attachment_on;
 
         $Cft->Technology_transfer_review = $request->Technology_transfer_review;
         $Cft->Technology_transfer_person = $request->Technology_transfer_person;
         $Cft->Technology_transfer_assessment = $request->Technology_transfer_assessment;
         $Cft->Technology_transfer_feedback = $request->Technology_transfer_feedback;
         $Cft->Technology_transfer_by = $request->Technology_transfer_by;
         $Cft->Technology_transfer_on = $request->Technology_transfer_on;
 
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
 
         $Cft->Project_management_review = $request->Project_management_review;
         $Cft->Project_management_person = $request->Project_management_person;
         $Cft->Project_management_assessment = $request->Project_management_assessment;
         $Cft->Project_management_feedback = $request->Project_management_feedback;
         $Cft->Project_management_by = $request->Project_management_by;
         $Cft->Project_management_on = $request->Project_management_on;
 
         $Cft->ProductionLiquid_Review = $request->ProductionLiquid_Review;
         $Cft->ProductionLiquid_person = $request->ProductionLiquid_person;
         $Cft->ProductionLiquid_assessment = $request->ProductionLiquid_assessment;
         $Cft->ProductionLiquid_feedback = $request->ProductionLiquid_feedback;
         $Cft->ProductionLiquid_by = $request->ProductionLiquid_by;
         $Cft->ProductionLiquid_on = $request->ProductionLiquid_on;
 
         $Cft->Project_management_review = $request->Project_management_review;
         $Cft->Project_management_person = $request->Project_management_person;
         $Cft->Project_management_assessment = $request->Project_management_assessment;
         $Cft->Project_management_feedback = $request->Project_management_feedback;
         $Cft->Project_management_by = $request->Project_management_by;
         $Cft->Project_management_on = $request->Project_management_on;
 
         $Cft->Store_Review = $request->Store_Review;
         $Cft->Store_person = $request->Store_person;
         $Cft->Store_assessment = $request->Store_assessment;
         $Cft->Store_feedback = $request->Store_feedback;
         $Cft->Store_by = $request->Store_by;
         $Cft->Store_on = $request->Store_on;
 
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
 
         $Cft->ContractGiver_Review = $request->ContractGiver_Review;
         $Cft->ContractGiver_person = $request->ContractGiver_person;
         $Cft->ContractGiver_assessment = $request->ContractGiver_assessment;
         $Cft->ContractGiver_feedback = $request->ContractGiver_feedback;
         $Cft->ContractGiver_by = $request->ContractGiver_by;
         $Cft->ContractGiver_on = $request->ContractGiver_on;
         
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
        toastr()->success("Record is created Successfully");
        return redirect(url('rcms/qms-dashboard'));
    }




    public function root_update(Request $request, $id)

    //  dd(root_update);

    {
       //       dd($request->all());

        
        if (!$request->short_description) {
            toastr()->error("Short description is required");
            return redirect()->back();
        }

        
        $lastDocument =  RootCauseAnalysis::find($id);
        $root =  RootCauseAnalysis::find($id);

        $lastDocCft = RootCFt::where('root_cause_analyses_id', $id)->first();
        $lastCft = RootCFt::where('root_cause_analyses_id', $root->id)->first();
       
        $root->initiator_Group = $request->initiator_Group;
        $root->initiator_group_code = $request->initiator_group_code;
        $root->initiated_through = $request->initiated_through;
        $root->initiated_if_other = ($request->initiated_if_other);
        $root->short_description = $request->short_description;
        $root->due_date =  $request->filled('due_date')  ? $request->due_date : $root->due_date;
        $root->severity_level= $request->severity_level;
        $root->priority_data = $request->priority_data;
        $root->Type= ($request->Type);
        $root->priority_level = ($request->priority_level);
        // $root->department = ($request->department);
        $root->department = implode(',', $request->departments);
        $root->description = ($request->description);
        $root->investigation_summary = ($request->investigation_summary);
        $root->root_cause_description = ($request->root_cause_description);
        $root->cft_comments_new = ($request->cft_comments_new);
         $root->hod_final_comments = $request->hod_final_comments;
        $root->qa_final_comments = $request->qa_final_comments;
        $root->qah_final_comments = $request->qah_final_comments;
        
         $root->investigators = ($request->investigators);
        $root->related_url = ($request->related_url);
        // $root->investigators = implode(',', $request->investigators);
        $root->root_cause_methodology = implode(',', $request->root_cause_methodology);

       // dd($root->root_cause_methodology);
        // $root->country = ($request->country);
        $root->assign_to = $request->assign_to;
        $root->Sample_Types = $request->Sample_Types;
         
        // Root Cause +
        if (!empty($request->Root_Cause_Category  )) {
            $root->Root_Cause_Category = serialize($request->Root_Cause_Category);
        }
        if (!empty($request->Root_Cause_Sub_Category)) {
            $root->Root_Cause_Sub_Category= serialize($request->Root_Cause_Sub_Category);
        }
        if (!empty($request->Probability)) {
            $root->Probability = serialize($request->Probability);
        }
        if (!empty($request->Remarks)) {
            $root->Remarks = serialize($request->Remarks);
        }
        if (!empty($request->why_problem_statement)) {
            $root->why_problem_statement = $request->why_problem_statement;
        } 
        if (!empty($request->why_1  )) {
            $root->why_1 = serialize($request->why_1);
        }
        if (!empty($request->why_2  )) {
            $root->why_2 = serialize($request->why_2);
        }
        if (!empty($request->why_3  )) {
            $root->why_3 = serialize($request->why_3);
        }
        if (!empty($request->why_4 )) {
            $root->why_4 = serialize($request->why_4);
        }
        if (!empty($request->why_5  )) {
            $root->why_5 = serialize($request->why_5);
        }
        if (!empty($request->why_root_cause)) {
            $root->why_root_cause = $request->why_root_cause;
        }

         // Is/Is Not Analysis (Launch Instruction)
         $root->what_will_be = ($request->what_will_be);
         $root->what_will_not_be = ($request->what_will_not_be);
         $root->what_rationable = ($request->what_rationable);
 
         $root->where_will_be = ($request->where_will_be);
         $root->where_will_not_be = ($request->where_will_not_be);
         $root->where_rationable = ($request->where_rationable);
 
         $root->when_will_be = ($request->when_will_be);
         $root->when_will_not_be = ($request->when_will_not_be);
         $root->when_rationable = ($request->when_rationable);
 
         $root->coverage_will_be = ($request->coverage_will_be);
         $root->coverage_will_not_be = ($request->coverage_will_not_be);
         $root->coverage_rationable = ($request->coverage_rationable);
 
         $root->who_will_be = ($request->who_will_be);
         $root->who_will_not_be = ($request->who_will_not_be);
         $root->who_rationable = ($request->who_rationable);
         
        //observation changes
        $root->objective = $request->objective;
        $root->scope = $request->scope;
        $root->problem_statement_rca = $request->problem_statement_rca;
        $root->requirement = $request->requirement;
        $root->immediate_action = $request->immediate_action;
      //  $root->investigation_team = implode(',', $request->investigation_team);
      if (is_array($request->investigation_team)) {
        $root->investigation_team = implode(',', $request->investigation_team);
          }
        $root->investigation_tool = $request->investigation_tool;
        $root->root_cause = $request->root_cause;

        $root->impact_risk_assessment = $request->impact_risk_assessment;
        $root->capa = $request->capa;
        $root->root_cause_description_rca = $request->root_cause_description_rca;
        $root->investigation_summary_rca = $request->investigation_summary_rca;
       
        $root->qa_reviewer = $request->qa_reviewer;
        $root->qa_cqa_approval_comment = $request->qa_cqa_approval_comment;


        if (!empty($request->qa_cqa_approval_attach)) {
            $files = [];
            if ($request->hasfile('qa_cqa_approval_attach')) {
                foreach ($request->file('qa_cqa_approval_attach') as $file) {
                    $name = $request->name . 'qa_cqa_approval_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $root->qa_cqa_approval_attach = json_encode($files);
        }



        if (!empty($request->root_cause_initial_attachment_rca)) {
            $files = [];
            if ($request->hasfile('root_cause_initial_attachment_rca')) {
                foreach ($request->file('root_cause_initial_attachment_rca') as $file) {
                    $name = $request->name . 'root_cause_initial_attachment_rca' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $root->root_cause_initial_attachment_rca = json_encode($files);
        }



        if (!empty($request->root_cause_initial_attachment)) {
            $files = [];
            if ($request->hasfile('root_cause_initial_attachment')) {
                foreach ($request->file('root_cause_initial_attachment') as $file) {
                    $name = $request->name . 'root_cause_initial_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $root->root_cause_initial_attachment = json_encode($files);
        }

        if (!empty($request->cft_attchament_new)) {
            $files = [];
            if ($request->hasfile('cft_attchament_new')) {
                foreach ($request->file('cft_attchament_new') as $file) {
                    $name = $request->name . 'cft_attchament_new' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $root->cft_attchament_new = json_encode($files);
        }
          if (!empty($request->qah_final_attachments)) {
            $files = [];
            if ($request->hasfile('qah_final_attachments')) {
                foreach ($request->file('qah_final_attachments') as $file) {
                    $name = $request->name . 'qah_final_attachments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $root->qah_final_attachments = json_encode($files);
        }
          if (!empty($request->hod_final_attachments)) {
            $files = [];
            if ($request->hasfile('hod_final_attachments')) {
                foreach ($request->file('hod_final_attachments') as $file) {
                    $name = $request->name . 'hod_final_attachments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $root->hod_final_attachments = json_encode($files);
        }
          if (!empty($request->qa_final_attachments)) {
            $files = [];
            if ($request->hasfile('qa_final_attachments')) {
                foreach ($request->file('qa_final_attachments') as $file) {
                    $name = $request->name . 'qa_final_attachments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $root->qa_final_attachments = json_encode($files);
        }

        
        // $root->investigators = json_encode($request->investigators);
        $root->submitted_by = $request->submitted_by;
        
        $root->comments = $request->comments;
        $root->lab_inv_concl = $request->lab_inv_concl;
        //Failure Mode and Effect Analysis+

        if (!empty($request->risk_factor)) {
            $root->risk_factor = serialize($request->risk_factor);
        }
        if (!empty($request->risk_element)) {
            $root->risk_element = serialize($request->risk_element);
        }
        if (!empty($request->problem_cause)) {
            $root->problem_cause = serialize($request->problem_cause);
        }
        if (!empty($request->existing_risk_control)) {
            $root->existing_risk_control = serialize($request->existing_risk_control);
        }
        if (!empty($request->initial_severity)) {
            $root->initial_severity = serialize($request->initial_severity);
        }
        if (!empty($request->initial_detectability)) {
            $root->initial_detectability = serialize($request->initial_detectability);
        }
        if (!empty($request->initial_probability)) {
            $root->initial_probability = serialize($request->initial_probability);
        }
        if (!empty($request->initial_rpn)) {
            $root->initial_rpn = serialize($request->initial_rpn);
        }
        if (!empty($request->risk_acceptance)) {
            $root->risk_acceptance = serialize($request->risk_acceptance);
        }
        if (!empty($request->risk_control_measure)) {
            $root->risk_control_measure = serialize($request->risk_control_measure);
        }
        if (!empty($request->residual_severity)) {
            $root->residual_severity = serialize($request->residual_severity);
        }
        if (!empty($request->residual_probability)) {
            $root->residual_probability = serialize($request->residual_probability);
        }
        if (!empty($request->residual_detectability)) {
            $root->residual_detectability = serialize($request->residual_detectability);
        }
        if (!empty($request->residual_rpn)) {
            $root->residual_rpn = serialize($request->residual_rpn);
        }
        if (!empty($request->risk_acceptance2)) {
            $root->risk_acceptance2 = serialize($request->risk_acceptance2);
        }
        if (!empty($request->mitigation_proposal)) {
            $root->mitigation_proposal = serialize($request->mitigation_proposal);
        }

        // Fishbone or Ishikawa Diagram +  (Launch Instruction)

        if (!empty($request->measurement)) {
            $root->measurement = serialize($request->measurement);
        }
        if (!empty($request->materials)) {
            $root->materials = serialize($request->materials);
        }
        if (!empty($request->methods)) {
            $root->methods = serialize($request->methods);
        }
        if (!empty($request->environment)) {
            $root->environment = serialize($request->environment);
        }
        if (!empty($request->manpower)) {
            $root->manpower = serialize($request->manpower);
        }
        if (!empty($request->machine)) {
            $root->machine = serialize($request->machine);
        }
        if (!empty($request->problem_statement)) {
            $root->problem_statement = $request->problem_statement;
            
        }


        $root->update(); 



    
        if ($lastDocument->initiator_Group != $root->initiator_Group || !empty($request->comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Initiator Department';
            $history->previous = Helpers::getFullDepartmentName($lastDocument->initiator_Group);
            $history->current = Helpers::getFullDepartmentName($root->initiator_Group);
            $history->comment = $request->comment;  
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->initiator_Group) || $lastDocument->initiator_Group === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->initiator_Group != $root->initiator_Group || !empty($request->comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Initiator Department Code';
            $history->previous = $lastDocument->initiator_Group;
            $history->current = $root->initiator_Group;
            $history->comment = $request->comment;  
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->initiator_Group) || $lastDocument->initiator_Group === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->short_description != $root->short_description || !empty($request->comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Short Description';
            $history->previous = $lastDocument->short_description;
            $history->current = $root->short_description;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->short_description) || $lastDocument->short_description === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

           

            $history->save();
        }


        if ($lastDocument->description != $root->description || !empty($request->comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Description';
            $history->previous = $lastDocument->description;
            $history->current = $root->description;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->description) || $lastDocument->description === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->comments != $root->comments || !empty($request->comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Comments';
            $history->previous = $lastDocument->comments;
            $history->current = $root->comments;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->comments) || $lastDocument->comments === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
            $history->save();
        }

        if ($lastDocument->assign_to != $root->assign_to || !empty($request->comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Department Head';
            $history->previous = Helpers::getInitiatorName ($root->assign_to);
            $history->current = Helpers::getInitiatorName ($root->assign_to);
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->assign_to) || $lastDocument->assign_to === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

           

            $history->save();
        }


        if ($lastDocument->qa_reviewer != $root->qa_reviewer || !empty($request->comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'QA Reviewer';
            $history->previous = Helpers::getInitiatorName($lastDocument->qa_reviewer);
            $history->current = Helpers::getInitiatorName($root->qa_reviewer);
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->qa_reviewer) || $lastDocument->qa_reviewer === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

           

            $history->save();
        }


        if ($lastDocument->severity_level != $root->severity_level || !empty ($request->comment)) {
            // return 'history';
            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Severity Level';
            $history->previous =  $lastDocument->severity_level;
            $history->current = $root->severity_level;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
                if (is_null($lastDocument->severity_level) || $lastDocument->severity_level === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

            $history->save();

        
        }


        if ($lastDocument->due_date != $root->due_date || !empty($request->comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Due Date';
            $history->previous = Helpers::getdateFormat( $lastDocument->due_date);
            $history->current = Helpers::getdateFormat( $root->due_date);
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->due_date) || $lastDocument->due_date === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

           

            $history->save();
        }

     //---------------------------------------------------------------------------

     if ($lastDocument->initiated_through != $root->initiated_through || !empty($request->comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Initiated Through';
        $history->previous = $lastDocument->initiated_through;
        $history->current = $root->initiated_through;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->initiated_through) || $lastDocument->initiated_through === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

       

        $history->save();
    }




     if ($lastDocument->initiated_if_other != $root->initiated_if_other || !empty($request->comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Others';
        $history->previous = $lastDocument->initiated_if_other;
        $history->current = $root->initiated_if_other;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->initiated_if_other) || $lastDocument->initiated_if_other === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

       

        $history->save();
    }


    


     if ($lastDocument->Type != $root->Type || !empty($request->comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Type';
        $history->previous = $lastDocument->Type;
        $history->current = $root->Type;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->Type) || $lastDocument->Type === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

       

        $history->save();
    }

    
    if ($lastDocument->priority_data != $root->priority_data|| !empty($request->comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Priority';
        $history->previous = $lastDocument->priority_data;
        $history->current = $root->priority_data;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->priority_data) || $lastDocument->priority_data === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

       

        $history->save();
    }

    if ($lastDocument->department != $root->department|| !empty($request->comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Responsible Department';
        $history->previous = $lastDocument->department;
        $history->current = $root->department;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->department) || $lastDocument->department === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

        $history->save();

    }   
    

    
    if ($lastDocument->root_cause_initial_attachment != $root->root_cause_initial_attachment|| !empty($request->comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Initial Attachment';
        $history->previous = str_replace(',', ', ', $lastDocument->root_cause_initial_attachment);
        $history->current = str_replace(',', ', ', $root->root_cause_initial_attachment);
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->root_cause_initial_attachment) || $lastDocument->root_cause_initial_attachment === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

       

        $history->save();

    }   
    if ($lastDocument->related_url != $root->related_url || !empty($request->comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Related URL';
        $history->previous = $lastDocument->related_url;
        $history->current = $root->related_url;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->related_url) || $lastDocument->related_url === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

       

        $history->save();
    }

    if ($lastDocument->root_cause_methodology != $root->root_cause_methodology|| !empty($request->comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Root Cause Methodology';
        $history->previous = $lastDocument->root_cause_methodology;
        $history->current = $root->root_cause_methodology;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->root_cause_methodology) || $lastDocument->root_cause_methodology === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

       

        $history->save();
    }


    
    //if ($lastDocument->root_cause_description != $root->root_cause_description|| !empty($request->comment)) {

    //    $history = new RootAuditTrial();
    //    $history->root_id = $id;
    //    $history->activity_type = 'Root Cause Description';
    //    $history->previous = $lastDocument->root_cause_description;
    //    $history->current = $root->root_cause_description;
    //    $history->comment = $request->comment;
    //    $history->user_id = Auth::user()->id;
    //    $history->user_name = Auth::user()->name;
    //    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //    $history->origin_state = $lastDocument->status;
    //    $history->change_to =   "Not Applicable";
    //    $history->change_from = $lastDocument->status;
    //        if (is_null($lastDocument->root_cause_description) || $lastDocument->root_cause_description === '') {
    //            $history->action_name = "New";
    //        } else {
    //            $history->action_name = "Update";
    //        }

    
    //    $history->save();
    //}



    
    //if ($lastDocument->investigation_summary != $root->investigation_summary|| !empty($request->comment)) {

    //    $history = new RootAuditTrial();
    //    $history->root_id = $id;
    //    $history->activity_type = 'Investigation Summary';
    //    $history->previous = $lastDocument->investigation_summary;
    //    $history->current = $root->investigation_summary;
    //    $history->comment = $request->comment;
    //    $history->user_id = Auth::user()->id;
    //    $history->user_name = Auth::user()->name;
    //    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //    $history->origin_state = $lastDocument->status;
    //    $history->change_to =   "Not Applicable";
    //    $history->change_from = $lastDocument->status;
    //        if (is_null($lastDocument->investigation_summary) || $lastDocument->investigation_summary === '') {
    //            $history->action_name = "New";
    //        } else {
    //            $history->action_name = "Update";
    //        }

       

    //    $history->save();
    //}


    if ($lastDocument->cft_comments_new != $root->cft_comments_new|| !empty($request->comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'QA Review Comments';
        $history->previous = $lastDocument->cft_comments_new;
        $history->current = $root->cft_comments_new;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->cft_comments_new) || $lastDocument->cft_comments_new === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

       

        $history->save();
    }
    if ($lastDocument->cft_attchament_new != $root->cft_attchament_new|| !empty($request->comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'QA Review Attachment';
        $history->previous = str_replace(',', ', ', $lastDocument->cft_attchament_new);
        $history->current = str_replace(',', ', ', $root->cft_attchament_new);
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->cft_attchament_new) || $lastDocument->cft_attchament_new === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

       

        $history->save();
    }

    //if ($lastDocument->cft_attchament_new != $root->cft_attchament_new|| !empty($request->comment)) {

    //    $history = new RootAuditTrial();
    //    $history->root_id = $id;
    //    $history->activity_type = 'Final Attachment';
    //    $history->previous = $lastDocument->cft_attchament_new;
    //    $history->current = $root->cft_attchament_new;
    //    $history->comment = $request->comment;
    //    $history->user_id = Auth::user()->id;
    //    $history->user_name = Auth::user()->name;
    //    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //    $history->origin_state = $lastDocument->status;
    //    $history->change_to =   "Not Applicable";
    //    $history->change_from = $lastDocument->status;
    //        if (is_null($lastDocument->cft_attchament_new) || $lastDocument->cft_attchament_new === '') {
    //            $history->action_name = "New";
    //        } else {
    //            $history->action_name = "Update";
    //        }

       

    //    $history->save();
    //}


    if ($lastDocument->root_cause_initial_attachment_rca != $root->root_cause_initial_attachment_rca|| !empty($request->comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Investigation Attachment';
        $history->previous = str_replace(',', ', ', $lastDocument->root_cause_initial_attachment_rca);
        $history->current = str_replace(',', ', ', $root->root_cause_initial_attachment_rca);
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->root_cause_initial_attachment_rca) || $lastDocument->root_cause_initial_attachment_rca === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }

       

        $history->save();
    }



    if ($lastDocument->objective != $root->objective || !empty($request->comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Objective';
        $history->previous = $lastDocument->objective;
        $history->current = $root->objective;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->objective) || $lastDocument->objective === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

       

        $history->save();
    }


    if ($lastDocument->scope != $root->scope || !empty($request->comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Scope';
        $history->previous = $lastDocument->scope;
        $history->current = $root->scope;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->scope) || $lastDocument->scope === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }
        $history->save();
    }

    if ($lastDocument->problem_statement_rca != $root->problem_statement_rca || !empty($request->comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Problem Statement';
        $history->previous = $lastDocument->problem_statement_rca;
        $history->current = $root->problem_statement_rca;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->problem_statement_rca) || $lastDocument->problem_statement_rca === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }
        $history->save();
    }


    if ($lastDocument->requirement != $root->requirement || !empty($request->comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Background';
        $history->previous = $lastDocument->requirement;
        $history->current = $root->requirement;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->requirement) || $lastDocument->requirement === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

       

        $history->save();
    }

    

    if ($lastDocument->immediate_action != $root->immediate_action || !empty($request->comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Immediate Action';
        $history->previous = $lastDocument->immediate_action;
        $history->current = $root->immediate_action;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->immediate_action) || $lastDocument->immediate_action === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

       

        $history->save();
    }

    

    if ($lastDocument->investigation_team != $root->investigation_team || !empty($request->comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Investigation Team';
        $history->previous = $lastDocument->investigation_team;
        $history->current = $root->investigation_team;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->investigation_team) || $lastDocument->investigation_team === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

        $history->save();
    }


    
    if ($lastDocument->investigation_tool != $root->investigation_tool || !empty($request->comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Investigation Tool';
        $history->previous = $lastDocument->investigation_tool;
        $history->current = $root->investigation_tool;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->investigation_tool) || $lastDocument->investigation_tool === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

       

        $history->save();
    }

    
    if ($lastDocument->root_cause != $root->root_cause || !empty($request->comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Root Cause';
        $history->previous = $lastDocument->root_cause;
        $history->current = $root->root_cause;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->root_cause) || $lastDocument->root_cause === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

       

        $history->save();
    }


    
    if ($lastDocument->impact_risk_assessment != $root->impact_risk_assessment || !empty($request->comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Impact / Risk Assessment';
        $history->previous = $lastDocument->impact_risk_assessment;
        $history->current = $root->impact_risk_assessment;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->impact_risk_assessment) || $lastDocument->impact_risk_assessment === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

       

        $history->save();
    }




    
    if ($lastDocument->capa != $root->capa || !empty($request->comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Capa';
        $history->previous = $lastDocument->capa;
        $history->current = $root->capa;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->capa) || $lastDocument->capa === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

       

        $history->save();
    }

    
    if ($lastDocument->root_cause_description_rca != $root->root_cause_description_rca || !empty($request->comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Root Cause Description';
        $history->previous = $lastDocument->root_cause_description_rca;
        $history->current = $root->root_cause_description_rca;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->root_cause_description_rca) || $lastDocument->root_cause_description_rca === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

       

        $history->save();
    }

    
    if ($lastDocument->investigation_summary_rca != $root->investigation_summary_rca || !empty($request->comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Investigation Summary';
        $history->previous = $lastDocument->investigation_summary_rca;
        $history->current = $root->investigation_summary_rca;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->investigation_summary_rca) || $lastDocument->investigation_summary_rca === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

       

        $history->save();
    }
     if ($lastDocument->hod_final_comments != $root->hod_final_comments || !empty($request->comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'HOD Final Review Comments';
        $history->previous = $lastDocument->hod_final_comments;
        $history->current = $root->hod_final_comments;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->hod_final_comments) || $lastDocument->hod_final_comments === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

       

        $history->save();
    }
     if ($lastDocument->hod_final_attachments != $root->hod_final_attachments || !empty($request->comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'HOD Final Review Attachment';
        $history->previous = str_replace(',', ', ', $lastDocument->hod_final_attachments);
        $history->current = str_replace(',', ', ', $root->hod_final_attachments);
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->hod_final_attachments) || $lastDocument->hod_final_attachments === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }
        $history->save();
    }



       if ($lastDocument->qa_final_comments != $root->qa_final_comments || !empty($request->comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'QA Final Review Comments';
        $history->previous = $lastDocument->qa_final_comments;
        $history->current = $root->qa_final_comments;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->qa_final_comments) || $lastDocument->qa_final_comments === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

       

        $history->save();
    }
     if ($lastDocument->qa_final_attachments != $root->qa_final_attachments || !empty($request->comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'QA Final Review Attachment';
        $history->previous = str_replace(',', ', ', $lastDocument->qa_final_attachments);
        $history->current = str_replace(',', ', ', $root->qa_final_attachments);
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->qa_final_attachments) || $lastDocument->qa_final_attachments === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

       

        $history->save();
    }
       if ($lastDocument->qah_final_comments != $root->qah_final_comments || !empty($request->comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'QAH/CQAH Final Review Comments';
        $history->previous = $lastDocument->qah_final_comments;
        $history->current = $root->qah_final_comments;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->qah_final_comments) || $lastDocument->qah_final_comments === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

       

        $history->save();
    }
     if ($lastDocument->qah_final_attachments != $root->qah_final_attachments || !empty($request->comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'QAH/CQAH Final Review Attachment';
        $history->previous = str_replace(',', ', ', $lastDocument->qa_final_attachments);
        $history->current = str_replace(',', ', ', $root->qah_final_attachments);
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->change_to =   "Not Applicable";
        $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->qah_final_attachments) || $lastDocument->qah_final_attachments === '') {
            $history->action_name = "New";
        } else {
            $history->action_name = "Update";
        }

       

        $history->save();
    }
    // $lastDocument = RootAuditTrial::where('root_id', $root->id)->orderBy('created_at', 'desc')->first();

    // $Fishbone_or_ishikawa_diagram = [
    //     'measurement' => 'Measurement ',
    //     'materials' => 'Materials ',
    //     'methods' => 'Methods ',
    //     'environment' => 'Environment ',
    //     'manpower' => 'Manpower ',
    //     'machine' => 'Machine',
    //     'problem_statement' => 'Problem Statement ',
    // ];
    
    // foreach ($Fishbone_or_ishikawa_diagram as $key => $value) {
    //     // Get the current value from the request
    //     $currentValue = !empty($request->$key) ? (is_array($request->$key) ? implode(', ', $request->$key) : $request->$key) : '';
    
    //     // Get the previous value from the last document
    //     if ($lastDocument) {
    //         $previousValue = !empty($lastDocument->$key) ? (is_array($lastDocument->$key) ? implode(', ', $lastDocument->$key) : $lastDocument->$key) : '';
    //     } else {
    //         $previousValue = '';
    //     }
    
    //     // Only proceed if current value is not empty and different from previous value or comment is provided
    //     if ($currentValue !== '' && ($previousValue != $currentValue || !empty($request->comment))) {
    //         $history = new RootAuditTrial();
    //         $history->root_id = $root->id;
    //         $history->activity_type = $value;
    //         $history->previous = $previousValue;
    //         $history->current = $currentValue;
    //         $history->comment = !empty($request->comment) ? $request->comment : 'NA';
    //         $history->user_id = Auth::user()->id;
    //         $history->user_name = Auth::user()->name;
    //         $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //         $history->origin_state = $lastDocument ? $lastDocument->status : '';
    //         $history->change_to = 'Opened';
    //         $history->change_from = $lastDocument ? $lastDocument->status : 'Initiator';
    //         $history->action_name = 'Create';
    
    //         $history->save();
    //     }
    // }
    

//     $lastDocument = RootAuditTrial::where('root_id', $root->id)->orderBy('created_at', 'desc')->first();

// $why_why_chart = [
//     'why_problem_statement' => 'Problem Statement',
//     'why_1' => 'Why 1',
//     'why_2' => 'Why 2',
//     'why_3' => 'Why 3',
//     'why_4' => 'Why 4',
//     'why_5' => 'Why 5',
//     'why_root_cause' => 'Root Cause',
// ];

// foreach ($why_why_chart as $key => $value) {
//     // Get the current value from the request
//     $currentValue = !empty($request->$key) ? (is_array($request->$key) ? implode(', ', $request->$key) : $request->$key) : '';

//     // Get the previous value from the last document
//     if ($lastDocument) {
//         $previousValue = !empty($lastDocument->$key) ? (is_array($lastDocument->$key) ? implode(', ', $lastDocument->$key) : $lastDocument->$key) : '';
//     } else {
//         $previousValue = '';
//     }

//     // Only proceed if current value is not empty and different from previous value or comment is provided
//     if ($currentValue !== '' && ($previousValue != $currentValue || !empty($request->comment))) {
//         $history = new RootAuditTrial();
//         $history->root_id = $root->id;
//         $history->activity_type = $value;
//         $history->previous = $previousValue;
//         $history->current = $currentValue;
//         $history->comment = !empty($request->comment) ? $request->comment : 'NA';
//         $history->user_id = Auth::user()->id;
//         $history->user_name = Auth::user()->name;
//         $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
//         $history->origin_state = $lastDocument ? $lastDocument->status : '';
//         $history->change_to = 'Not Applicable';
//         $history->change_from = $lastDocument ? $lastDocument->status : 'Initiator';
//         $history->action_name = 'Update';

//         $history->save();
//     }
// }


  
//     $is_is_not_analysis  = [
//         'what_will_be' => ' What / Will Be',
//         'what_will_not_be' => 'what / Will Not Be',
//         'what_rationable' => 'what / Rational',

//         'where_will_be' => ' Where / Will Be',
//         'where_will_not_be' => ' Where / Will Not Be',
//         'where_rationable' => ' Where / Rational',

//         'when_will_be' => ' When / Will Be',
//         'when_will_not_be' => 'When / Will Not Be ',
//         'when_rationable' => 'When / Retional ',

//         'coverage_will_be' => 'Coverage / Will Be',
//         'coverage_will_not_be' => 'Coverage / Will Not Be',
//         'coverage_rationable' => 'Coverage / Retional',

//         'who_will_be' => 'Who / will Be ',
//         'who_will_not_be' => 'Who / Will Not Be',
//         'who_rationable' => ' Who / Retional',
//     ];
    
//     foreach ($is_is_not_analysis as $key => $value) {
//         // Get the current and previous values
//         $currentValue = !empty($request->$key) ? (is_array($request->$key) ? implode(', ', $request->$key) : $request->$key) : '';
//         $previousValue = !empty($lastDocument->$key) ? (is_array($lastDocument->$key) ? implode(', ', $lastDocument->$key) : $lastDocument->$key) : '';
    
//         // Compare the values
//         if ($previousValue != $currentValue || !empty($request->comment)) {
//             $history = new RootAuditTrial();
//             $history->root_id = $id;
//             $history->activity_type = $value;
//             $history->previous = $previousValue;
//             $history->current = $currentValue;
//             $history->comment = $request->comment;
//             $history->user_id = Auth::user()->id;
//             $history->user_name = Auth::user()->name;
//             $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
//             $history->origin_state = $lastDocument->status;
//             $history->change_to = "Not Applicable";
//             $history->change_from = $lastDocument->status;
//             $history->action_name = 'Update';
    
//             $history->save();
//         }
//     }
    

  
//     $lastDocument = RootAuditTrial::where('root_id', $root->id)->orderBy('created_at', 'desc')->first();

//     $root_case_grid = [
//         'Root_Cause_Category' => 'Root Cause Category',
//         'Root_Cause_Sub_Category' => 'Root Cause Sub Category',
//         'Probability' => 'Probability',
//         'Remarks' => 'Remarks',
//     ];
    
//     foreach ($root_case_grid as $key => $value) {
//         // Get the current value from the request
//         $currentValue = !empty($request->$key) ? (is_array($request->$key) ? implode(', ', $request->$key) : $request->$key) : '';
    
//         // Get the previous value from the last document
//         if ($lastDocument) {
//             $previousValue = !empty($lastDocument->$key) ? (is_array($lastDocument->$key) ? implode(', ', $lastDocument->$key) : $lastDocument->$key) : '';
//         } else {
//             $previousValue = '';
//         }
    
//         // Only proceed if current value is not empty and different from previous value or comment is provided
//         if ($currentValue !== '' && ($previousValue != $currentValue || !empty($request->comment))) {
//             $history = new RootAuditTrial();
//             $history->root_id = $root->id;
//             $history->activity_type = $value;
//             $history->previous = $previousValue;
//             $history->current = $currentValue;
//             $history->comment = !empty($request->comment) ? $request->comment : 'NA';
//             $history->user_id = Auth::user()->id;
//             $history->user_name = Auth::user()->name;
//             $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
//             $history->origin_state = $lastDocument ? $lastDocument->status : '';
//             $history->change_to = 'Not Applicable';
//             $history->change_from = $lastDocument ? $lastDocument->status : 'Initiator';
//             $history->action_name = 'Update';
    
//             $history->save();
//         }
//     }
     



//     $failure_mode_grid = [
//         'risk_factor' => 'Risk Factor',
//         'risk_element' => 'Risk element',
//         'problem_cause' => 'Probable cause of risk element',
//         'existing_risk_control' => 'Existing Risk Controls',
//         'initial_severity' => 'Initial Severity',
//         'initial_probability' => 'Initial Probability',
//         'initial_detectability' => 'Initial Detectability',
//         'initial_rpn' => 'Initial RPN',
//         'risk_acceptance' => 'Risk Acceptance',
//         'risk_control_measure' => 'Proposed Additional Risk control measure',
//         'residual_severity' => 'Residual Severity',
//         'residual_probability' => 'Residual Probability',
//         'residual_detectability' => 'Residual Detectability',
//         'residual_rpn' => 'Residual RPN',
//         'risk_acceptance2' => 'Risk Acceptance',
//         'mitigation_proposal' => 'Mitigation proposal',
//     ];
    
//     foreach ($failure_mode_grid as $key => $value) {
//         // Get the current and previous values
//         $currentValue = !empty($request->$key) ? (is_array($request->$key) ? implode(', ', $request->$key) : $request->$key) : '';
//         $previousValue = !empty($lastDocument->$key) ? (is_array($lastDocument->$key) ? implode(', ', $lastDocument->$key) : $lastDocument->$key) : '';
    
//         // Compare the values
//         if ($previousValue != $currentValue || !empty($request->comment)) {
//             $history = new RootAuditTrial();
//             $history->root_id = $id;
//             $history->activity_type = $value;
//             $history->previous = $previousValue;
//             $history->current = $currentValue;
//             $history->comment = $request->comment;
//             $history->user_id = Auth::user()->id;
//             $history->user_name = Auth::user()->name;
//             $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
//             $history->origin_state = $lastDocument->status;
//             $history->change_to = "Not Applicable";
//             $history->change_from = $lastDocument->status;
//             $history->action_name = 'Update';
    
//             $history->save();
//         }
//     }
    


        //---------------------------------------------------------------
        // if ($lastDocument->investigators != $root->investigators || !empty($request->comment)) {

        //     $history = new RootAuditTrial();
        //     $history->root_id = $id;
        //     $history->activity_type = 'Investigators';
        //     $history->previous = $lastDocument->investigators;
        //     $history->current = $root->investigators;
        //     $history->comment = $request->investigators_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     $history->action_name = 'Update';
           

        //     $history->save();
        // }
        // if ($lastDocument->cft_attchament_new != $root->cft_attchament_new || !empty($request->comment)) {

        //     $history = new RootAuditTrial();
        //     $history->root_id = $id;
        //     $history->activity_type = 'Attachments';
        //     $history->previous = $lastDocument->attachments;
        //     $history->current = $root->attachments;
        //     $history->comment = $request->attachments_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     $history->action_name = 'Update';
           

        //     $history->save();
        // }
        // if ($lastDocument->comments != $root->comments || !empty($request->comment)) {

        //     $history = new RootAuditTrial();
        //     $history->root_id = $id;
        //     $history->activity_type = 'Comments';
        //     $history->previous = $lastDocument->comments;
        //     $history->current = $root->comments;
        //     $history->comment = $request->comments_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     $history->action_name = 'Update';
           

        //     $history->save();
        // }
        // if ($lastDocument->lab_inv_concl != $root->lab_inv_concl || !empty($request->comment)) {

        //     $history = new RootAuditTrial();
        //     $history->root_id = $id;
        //     $history->activity_type = 'Lab Inv Concl';
        //     $history->previous = $lastDocument->lab_inv_concl;
        //     $history->current = $root->lab_inv_concl;
        //     $history->comment = $request->lab_inv_concl_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     $history->action_name = 'Update';
           

        //     $history->save();
        // }
        // if ($lastDocument->lab_inv_attach != $root->lab_inv_attach || !empty($request->comment)) {

        //     $history = new RootAuditTrial();
        //     $history->root_id = $id;
        //     $history->activity_type = 'lab Inv Attach';
        //     $history->previous = $lastDocument->lab_inv_attach;
        //     $history->current = $root->lab_inv_attach;
        //     $history->comment = $request->lab_inv_attach_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     $history->action_name = 'Update';
           

        //     $history->save();
        // }
        // if ($lastDocument->qc_head_comments != $root->qc_head_comments || !empty($request->comment)) {

        //     $history = new RootAuditTrial();
        //     $history->root_id = $id;
        //     $history->activity_type = 'Qc Head Comments';
        //     $history->previous = $lastDocument->qc_head_comments;
        //     $history->current = $root->qc_head_comments;
        //     $history->comment = $request->qc_head_comments_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     $history->action_name = 'Update';
           

        //     $history->save();
        // }
        // if ($lastDocument->inv_attach != $root->inv_attach || !empty($request->comment)) {

        //     $history = new RootAuditTrial();
        //     $history->root_id = $id;
        //     $history->activity_type = 'Inv Attach';
        //     $history->previous = $lastDocument->inv_attach;
        //     $history->current = $root->inv_attach;
        //     $history->comment = $request->inv_attach_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     $history->action_name = 'Update';
           

        //     $history->save();
        // }
        // if ($lastDocument->due_date != $root->due_date || !empty($request->comment)) {

        //     $history = new RootAuditTrial();
        //     $history->root_id = $id;
        //     $history->activity_type = 'Due Date';
        //     $history->previous = $lastDocument->due_date;
        //     $history->current = $root->due_date;
        //     $history->comment = $request->due_date_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     $history->action_name = 'Update';
           

        //     $history->save();
        // }
        // if ($lastDocument->due_date != $root->due_date || !empty($request->comment)) {

        //     $history = new RootAuditTrial();
        //     $history->root_id = $id;
        //     $history->activity_type = 'Due Date';
        //     $history->previous = $lastDocument->due_date;
        //     $history->current = $root->due_date;
        //     $history->comment = $request->due_date_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //     $history->action_name = 'Update';
           

        //     $history->save();
        // }


           /*********** CFT Code starts **********/
           if($root->stage == 3 || $root->stage == 4 ){

            $Cft = RootCFt::withoutTrashed()->where('root_cause_analyses_id', $id)->first();
            dd($Cft);
            if($Cft && $root->stage == 4 ){
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


            $IsCFTRequired = RootCaseAnalysisCftResponse::withoutTrashed()->where(['is_required' => 1, 'root_cause_analyses_id' => $id])->latest()->first();
            $cftUsers = DB::table('rca_cft')->where(['root_cause_analyses_id' => $id])->first();
            $columns = ['Production_person', 'Quality_Control_Person', 'Warehouse_person', 'Engineering_person', 'ResearchDevelopment_person', 'RegulatoryAffair_person', 'CQA_person', 'Microbiology_person', 'QualityAssurance_person','SystemIT_person', 'Human_Resource_person','Other1_person','Other2_person','Other3_person','Other4_person','Other5_person'];
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



        $areRaAttachSame = $lastDocCft->RA_attachment == json_encode($request->RA_attachment);
        $areQAAttachSame = $lastDocCft->Quality_Assurance_attachment == json_encode($request->Quality_Assurance_attachment);
        $arePTAttachSame = $lastDocCft->Production_Table_Attachment == json_encode($request->Production_Table_Attachment);
        $arePlAttachSame = $lastDocCft->ProductionLiquid_attachment == json_encode($request->ProductionLiquid_attachment);
        $arePiAttachSame = $lastDocCft->Production_Injection_Attachment == json_encode($request->Production_Injection_Attachment);
        $areStoreAttachSame = $lastDocCft->Store_attachment == json_encode($request->Store_attachment);
        $areQcAttachSame = $lastDocCft->Quality_Control_attachment == json_encode($request->Quality_Control_attachment);
        $areRdAttachSame = $lastDocCft->ResearchDevelopment_attachment == json_encode($request->ResearchDevelopment_attachment);
        $areEngAttachSame = $lastDocCft->Engineering_attachment == json_encode($request->Engineering_attachment);
        $areHrAttachSame = $lastDocCft->Human_Resource_attachment == json_encode($request->Human_Resource_attachment);
        $areMicroAttachSame = $lastDocCft->Microbiology_attachment == json_encode($request->Microbiology_attachment);
        $areRegAffairAttachSame = $lastDocCft->RegulatoryAffair_attachment == json_encode($request->RegulatoryAffair_attachment);
        $areCQAAttachSame = $lastDocCft->CorporateQualityAssurance_attachment == json_encode($request->CorporateQualityAssurance_attachment);
        $areSafetyAttachSame = $lastDocCft->Environment_Health_Safety_attachment == json_encode($request->Environment_Health_Safety_attachment);
        $areItAttachSame = $lastDocCft->Information_Technology_attachment == json_encode($request->Information_Technology_attachment);
        $areContractGiverAttachSame = $lastDocCft->ContractGiver_attachment == json_encode($request->ContractGiver_attachment);
        $areOther1AttachSame = $lastDocCft->Other1_attachment == json_encode($request->Other1_attachment);
        $areOther2AttachSame = $lastDocCft->Other2_attachment == json_encode($request->Other2_attachment);
        $areOther3AttachSame = $lastDocCft->Other3_attachment == json_encode($request->Other3_attachment);
        $areOther4AttachSame = $lastDocCft->Other4_attachment == json_encode($request->Other4_attachment);
        $areOther5AttachSame = $lastDocCft->Other5_attachment == json_encode($request->Other5_attachment);


            
        toastr()->success("Record is update Successfully");
        return back();
    }
    public function root_show($id)
    {
        $data = RootCauseAnalysis::find($id);
        if(empty($data)) {
            toastr()->error('Invalid ID.');
            return back();
        }
        $data->record = str_pad($data->record, 4, '0', STR_PAD_LEFT);
        $data->assign_to_name = User::where('id', $data->assign_to)->value('name');
        $data->initiator_name = User::where('id', $data->initiator_id)->value('name');
        $data1 = RootCFt::where('root_cause_analyses_id', $id)->latest()->first();
          return view('frontend.root-cause-analysis.root_cause_analysisView', compact(
            'data','data1'
        ));
    }



   
    public function root_send_stage_second(Request $request, $id)
    {

        //return "Hello";
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $root = RootCauseAnalysis::find($id);
            $lastDocument =  RootCauseAnalysis::find($id);
            if ($root->stage == 3) {
                $root->stage = "5";
                $root->status = "QA/CQA Approval";
                $root->root_send_stage_second_by= Auth::user()->name;
                $root->root_send_stage_second_on= Carbon::now()->format('d-M-Y');

                $root->root_send_stage_second_comment = $request->comment;
                    
                $history = new RootAuditTrial();
                $history->root_id = $id;
                $history->activity_type = 'CFT Review Not Required By, CFT Review Not Required On';
                $history->previous ="Initial QA/CQA Review";
                $history->current = $root->root_send_stage_second_by;
                $history->comment = $request->comment;
                $history->action = 'CFT Review Not Required';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "QA/CQA Approval";
                $history->change_from = $lastDocument->status;
                $history->action_name = 'Update';
                $history->stage = 'QA/CQA Approval';
                if (is_null($lastDocument->root_send_stage_second_by) || $lastDocument->root_send_stage_second_by === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->root_send_stage_second_by . ' , ' . $lastDocument->root_send_stage_second_on;
                }
                $history->current = $root->root_send_stage_second_by . ' , ' . $root->root_send_stage_second_on;
                if (is_null($lastDocument->root_send_stage_second_by) || $lastDocument->root_send_stage_second_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                

                $history->save();
                $root->save();
                toastr()->success('Document Sent');
                return back();

            }

        }
    }   

    public function root_send_stage(Request $request, $id)
    {


        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $root = RootCauseAnalysis::find($id);
            $lastDocument =  RootCauseAnalysis::find($id);
            $updateCFT = RootCFt::where('root_cause_analyses_id', $id)->latest()->first();
            $cftDetails = RootCaseAnalysisCftResponse::withoutTrashed()->where(['status' => 'In-progress', 'root_cause_analyses_id' => $id])->distinct('cft_user_id')->count();
        
             if ($root->stage == 1) {
                $root->stage = "2";
                $root->status = 'HOD Review';
                $root->acknowledge_by = Auth::user()->name;
                $root->acknowledge_on = Carbon::now()->format('d-M-Y');
                $root->ack_comments = $request->comment;

                $history = new RootAuditTrial();
                $history->root_id = $id;
                $history->activity_type = 'Acknowledge By, Acknowledge On';
                $history->previous ="Opened";
                $history->current = $root->acknowledge_by;
                $history->comment = $request->comment;
                $history->action = 'Acknowledge';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "HOD Review";
                $history->change_from = $lastDocument->status;
                $history->action_name = 'Update';
                
                $history->stage = 'HOD Review';
                if (is_null($lastDocument->acknowledge_by) || $lastDocument->acknowledge_by === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->acknowledge_by . ' , ' . $lastDocument->acknowledge_on;
                }
                $history->current = $root->acknowledge_by . ' , ' . $root->acknowledge_on;
                if (is_null($lastDocument->acknowledge_by) || $lastDocument->acknowledge_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();

                /********** Notification User **********/
                $list = Helpers::getHodUserList($root->division_id);
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                $userId = $users->pluck('id')->implode(',');

                if(!empty($users)){
                    try {
                        $history = new RootAuditTrial();
                        $history->root_id = $id;
                        $history->activity_type = "Not Applicable";
                        $history->previous = "Not Applicable";
                        $history->current = "Not Applicable";
                        $history->action = 'Notification';
                        $history->comment = "";
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = "Not Applicable";
                        $history->change_to = "Not Applicable";
                        $history->change_from = "Opened";
                        $history->stage = "";
                        $history->action_name = "";
                        $history->mailUserId = $userId;
                        $history->role_name = "Initiator";
                        $history->save();
                    } catch (\Throwable $e) {
                        \Log::error('Mail failed to send: ' . $e->getMessage());
                    }
                }


                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $root->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Root Cause Analysis",
                        'division_id' => $root->division_id,
                        'short_description' => $root->short_description,
                        'initiator_id' => $root->initiator_id,
                        'due_date' => $root->due_date,
                        'record' => $root->record,
                        'site' => "RCA",
                        'comment' => $request->comments,
                        'status' => $root->status,
                        'stage' => $root->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                foreach ($list as $u) {
                    $email = Helpers::getUserEmail($u->user_id);
                        if ($email !== null) {
                        try {
                            Mail::send(
                                'mail.view-mail',
                                ['data' => $root, 'site' => "RCA", 'history' => "Acknowledge", 'process' => 'Root Cause Analysis', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                function ($message) use ($email, $root) {
                                    $message->to($email)
                                    ->subject("Medicef Notification: Root Cause Analysis, Record #" . str_pad($root->record, 4, '0', STR_PAD_LEFT) . " - Activity: Acknowledge Performed");
                                }
                            );
                        } catch(\Exception $e) {
                            info('Error sending mail', [$e]);
                        }
                    }
                }


                $root->update();
                toastr()->success('Document Sent');
                return back();
            }
             if ($root->stage == 2) {
                $root->stage = "3";
                $root->status = 'Initial QA/CQA Review';
                $root->HOD_Review_Complete_By = Auth::user()->name;
                $root->HOD_Review_Complete_On = Carbon::now()->format('d-M-Y');
                $root->HOD_Review_Complete_Comment = $request->comment;

                $history = new RootAuditTrial();
                $history->root_id = $id;
                $history->activity_type = 'HOD Review Complete By, HOD Review Complete On';
                $history->previous ="HOD Review";
                $history->current = $root->HOD_Review_Complete_By;
                $history->comment = $request->comment;
                $history->action = 'HOD Review Complete';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Initial QA/CQA Review";
                $history->change_from = $lastDocument->status;
                $history->action_name = 'Update';
                $history->stage = 'Initial QA/CQA Review';
                if (is_null($lastDocument->HOD_Review_Complete_By) || $lastDocument->HOD_Review_Complete_By === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->HOD_Review_Complete_By . ' , ' . $lastDocument->HOD_Review_Complete_On;
                }
                $history->current = $root->HOD_Review_Complete_By . ' , ' . $root->HOD_Review_Complete_On;
                if (is_null($lastDocument->HOD_Review_Complete_By) || $lastDocument->HOD_Review_Complete_By === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();

                 /********** Notification User **********/
                 $list = Helpers::getQAUserList($root->division_id);

                 $userIds = collect($list)->pluck('user_id')->toArray();
                 $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                 $userId = $users->pluck('id')->implode(',');
 
                 if(!empty($users)){
                     try {
                         $history = new RootAuditTrial();
                         $history->root_id = $id;
                         $history->activity_type = "Not Applicable";
                         $history->previous = "Not Applicable";
                         $history->current = "Not Applicable";
                         $history->action = 'Notification';
                         $history->comment = "";
                         $history->user_id = Auth::user()->id;
                         $history->user_name = Auth::user()->name;
                         $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                         $history->origin_state = "Not Applicable";
                         $history->change_to = "Not Applicable";
                         $history->change_from = "HOD Review";
                         $history->stage = "";
                         $history->action_name = "";
                         $history->mailUserId = $userId;
                         $history->role_name = "HOD";
                         $history->save();
                     } catch (\Throwable $e) {
                         \Log::error('Mail failed to send: ' . $e->getMessage());
                     }
                 }
 
 
                 foreach ($users as $userValue) {
                     DB::table('notifications')->insert([
                         'activity_id' => $root->id,
                         'activity_type' => "Notification",
                         'from_id' => Auth::user()->id,
                         'user_name' => $userValue->name,
                         'to_id' => $userValue->id,
                         'process_name' => "Root Cause Analysis",
                         'division_id' => $root->division_id,
                         'short_description' => $root->short_description,
                         'initiator_id' => $root->initiator_id,
                         'due_date' => $root->due_date,
                         'record' => $root->record,
                         'site' => "RCA",
                         'comment' => $request->comments,
                         'status' => $root->status,
                         'stage' => $root->stage,
                         'created_at' => Carbon::now(),
                     ]);
                 }
 
                 foreach ($list as $u) {
                     $email = Helpers::getUserEmail($u->user_id);
                         if ($email !== null) {
                         try {
                             Mail::send(
                                 'mail.view-mail',
                                 ['data' => $root, 'site' => "RCA", 'history' => "HOD Review Complete", 'process' => 'Root Cause Analysis', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                 function ($message) use ($email, $root) {
                                     $message->to($email)
                                     ->subject("Medicef Notification: Root Cause Analysis, Record #" . str_pad($root->record, 4, '0', STR_PAD_LEFT) . " - Activity: HOD Review Complete Performed");
                                 }
                             );
                         } catch(\Exception $e) {
                             info('Error sending mail', [$e]);
                         }
                     }
                 }


                

                $root->update();
                toastr()->success('Document Sent');
                return back();
            }



            
            if ($root->stage == 3) {

                $getCftData = RootCFt::where('root_cause_analyses_id', $id)->first();

                $columns = [
                    'Production_person', 'Quality_Control_Person', 'Warehouse_person', 'Engineering_person',
                    'ResearchDevelopment_person', 'RegulatoryAffair_person', 'CQA_person', 'Microbiology_person',
                    'QualityAssurance_person', 'SystemIT_person', 'Human_Resource_person', 'Other1_person',
                    'Other2_person', 'Other3_person', 'Other4_person', 'Other5_person'
                ];

                $userIds = [];
                foreach ($columns as $field) {
                    if (!empty($getCftData->$field) && is_numeric($getCftData->$field)) {
                        $userIds[] = $getCftData->$field;
                    }
                }

                $userIds = array_unique($userIds);
                if (empty($userIds)) {
                    throw new \Exception("No valid user IDs found in the Cft data.");
                }

                $users = User::whereIn('id', $userIds)->get();
                if ($users->isEmpty()) {
                    throw new \Exception("No users found for the given IDs.");
                }

                // foreach ($users as $user) {
                //     Mail::to($user->email)->send(new CftMail($user));
                // }

                $root->stage = "4";
                $root->status = "CFT Assessment";

                $stage = new RootCaseAnalysisCftResponse();
                $stage->root_cause_analyses_id = $id;
                $stage->cft_user_id = Auth::user()->id;
                $stage->status = "CFT Required";
                
                $stage->comment = $request->comment;
                $stage->is_required = 1;
                $stage->save();



                $root->stage = "4";
                $root->status = "QA/CQA Review Complete";
                $root->QQQA_Review_Complete_By= Auth::user()->name;
                $root->QQQA_Review_Complete_On= Carbon::now()->format('d-M-Y');
                $root->QAQQ_Review_Complete_comment = $request->comment;

                $history = new RootAuditTrial();
                $history->root_id = $id;
                $history->activity_type = 'QA/CQA Review Complete By, QA/CQA Review Complete On';
                $history->previous ="HOD Review Complete";
                $history->current = $root->QQQA_Review_Complete_By;
                $history->comment = $request->comment;
                $history->action = 'QA/CQA Review Complete';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "QA/CQA Review Complete";
                $history->change_from = $lastDocument->status;
                $history->action_name = 'Update';
                $history->stage = 'QA/CQA Review Complete';
                if (is_null($lastDocument->QQQA_Review_Complete_By) || $lastDocument->QQQA_Review_Complete_By === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->QQQA_Review_Complete_By . ' , ' . $lastDocument->QQQA_Review_Complete_On;
                }
                $history->current = $root->QQQA_Review_Complete_By . ' , ' . $root->QQQA_Review_Complete_On;
                if (is_null($lastDocument->QQQA_Review_Complete_By) || $lastDocument->QQQA_Review_Complete_By === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                

                $history->save();
            
                $list = Helpers::getInitiatorUserList($root->division_id);
                 
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                $userId = $users->pluck('id')->implode(',');

                if(!empty($users)){
                    try {
                        $history = new RootAuditTrial();
                        $history->root_id = $id;
                        $history->activity_type = "Not Applicable";
                        $history->previous = "Not Applicable";
                        $history->current = "Not Applicable";
                        $history->action = 'Notification';
                        $history->comment = "";
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = "Not Applicable";
                        $history->change_to = "Not Applicable";
                        $history->change_from = "Initial QA/CQA Review";
                        $history->stage = "";
                        $history->action_name = "";
                        $history->mailUserId = $userId;
                        $history->role_name = "QA/CQA";
                        $history->save();
                    } catch (\Throwable $e) {
                        \Log::error('Mail failed to send: ' . $e->getMessage());
                    }
                }


                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $root->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Root Cause Analysis",
                        'division_id' => $root->division_id,
                        'short_description' => $root->short_description,
                        'initiator_id' => $root->initiator_id,
                        'due_date' => $root->due_date,
                        'record' => $root->record,
                        'site' => "RCA",
                        'comment' => $request->comments,
                        'status' => $root->status,
                        'stage' => $root->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                foreach ($list as $u) {
                    $email = Helpers::getUserEmail($u->user_id);
                        if ($email !== null) {
                        try {
                            Mail::send(
                                'mail.view-mail',
                                ['data' => $root, 'site' => "RCA", 'history' => "QA/CQA Review Complete", 'process' => 'Root Cause Analysis', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                function ($message) use ($email, $root) {
                                    $message->to($email)
                                    ->subject("Medicef Notification: Root Cause Analysis, Record #" . str_pad($root->record, 4, '0', STR_PAD_LEFT) . " - Activity: QA/CQA Review Complete Performed");
                                }
                            );
                        } catch(\Exception $e) {
                            info('Error sending mail', [$e]);
                        }
                    }
                }


                $root->update();
                toastr()->success('Document Sent');
                return back();
            }










            if ($root->stage == 4) {

                $IsCFTRequired = RootCFt::withoutTrashed()->where(['is_required' => 1, 'root_cause_analyses_id' => $id])->latest()->first();
                $cftUsers = DB::table('rca_cft')->where(['root_cause_analyses_id' => $id])->first();

                /****** CFT Person ******/
                $columns = ['Production_person', 'Quality_Control_Person', 'Warehouse_person', 'Engineering_person', 'ResearchDevelopment_person', 'RegulatoryAffair_person', 'CQA_person', 'Microbiology_person', 'QualityAssurance_person','SystemIT_person','Human_Resource_person','Other1_person','Other2_person','Other3_person','Other4_person','Other5_person'];
                // Initialize an array to store the values

                $valuesArray = [];

                // Iterate over the columns and retrieve the values
                foreach ($columns as $index => $column) {
                    $value = $cftUsers->$column;
                    if ($index == 0 && $cftUsers->$column == Auth::user()->id) {
                        $updateCFT->Production_by = Auth::user()->name;
                        $updateCFT->production_on = Carbon::now()->format('Y-m-d');

                         $history = new RootAuditTrial();
                        $history->root_id = $id;
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
                    
                         $history = new RootAuditTrial();
                          $history->root_id = $id;
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
                         $history = new RootAuditTrial();
                       $history->root_id = $id;
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
                         $history = new RootAuditTrial();
                           $history->root_id = $id;
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
                         $history = new RootAuditTrial();
                              $history->root_id = $id;
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

                    if($index == 5 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->RegulatoryAffair_by = Auth::user()->name;
                        $updateCFT->RegulatoryAffair_on = Carbon::now()->format('Y-m-d');
                         $history = new RootAuditTrial();
                         $history->root_id = $id;
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

                    
                    if($index == 6 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->CQA_by = Auth::user()->name;
                        $updateCFT->CQA_on = Carbon::now()->format('Y-m-d');
                         $history = new RootAuditTrial();
                          $history->root_id = $id;
                        $history->activity_type = 'CQA Completed By, CQA Completed On';
                        if(is_null($lastDocument->CQA_by) || $lastDocument->CQA_on == ''){
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->CQA_by. ' ,' . Helpers::getdateFormat($lastDocument->CQA_on);
                        }
                        $history->action='CFT Review Complete';
                        $history->current = $updateCFT->CQA_by. ',' . Helpers::getdateFormat($updateCFT->CQA_on);
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';
                        if(is_null($lastDocument->CQA_by) || $lastDocument->CQA_on == ''){
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->save();
                    }
                    
                    if($index == 7 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Microbiology_by = Auth::user()->name;
                        $updateCFT->Microbiology_on = Carbon::now()->format('Y-m-d');
                         $history = new RootAuditTrial();
                         $history->root_id = $id;
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

                    if($index == 8 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->QualityAssurance_by = Auth::user()->name;
                        $updateCFT->QualityAssurance_on = Carbon::now()->format('Y-m-d');
                         $history = new RootAuditTrial();
                          $history->root_id = $id;
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

                    if($index == 9 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->SystemIT_by = Auth::user()->name;
                        $updateCFT->SystemIT_on = Carbon::now()->format('Y-m-d');
                         $history = new RootAuditTrial();
                $history->root_id = $id;
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

                    if($index == 10 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Human_Resource_by = Auth::user()->name;
                        $updateCFT->Human_Resource_on = Carbon::now()->format('Y-m-d');
                         $history = new RootAuditTrial();
                         $history->root_id = $id;
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

                    if($index == 11 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Other1_by = Auth::user()->name;
                        $updateCFT->Other1_on = Carbon::now()->format('Y-m-d');
                         $history = new RootAuditTrial();
                            $history->root_id = $id;
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

                    if($index == 12 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Other2_by = Auth::user()->name;
                        $updateCFT->Other2_on = Carbon::now()->format('Y-m-d');
                         $history = new RootAuditTrial();
                        $history->root_id = $id;
                        $history->activity_type = 'Other 2 Completed By, Other 2 Completed On';
                        if(is_null($lastDocument->Other2_by) || $lastDocument->Other2_on == ''){
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->Other2_by. ' ,' . Helpers::getdateFormat($lastDocument->Other2_on);
                        }
                        $history->action='CFT Review Complete';
                        $history->current = $updateCFT->Other2_by. ',' . Helpers::getdateFormat($updateCFT->Other2_on);
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';
                        if(is_null($lastDocument->Other2_by) || $lastDocument->Other2_on == ''){
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->save();
                    }

                    if($index == 13 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Other3_by = Auth::user()->name;
                        $updateCFT->Other3_on = Carbon::now()->format('Y-m-d');
                         $history = new RootAuditTrial();
                         $history->root_id = $id;
                        $history->activity_type = 'Other 3 Completed By, Other 3 Completed On';
                        if(is_null($lastDocument->Other3_by) || $lastDocument->Other3_on == ''){
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->Other3_by. ' ,' . Helpers::getdateFormat($lastDocument->Other3_on);
                        }
                        $history->action='CFT Review Complete';
                        $history->current = $updateCFT->Other3_by. ',' . Helpers::getdateFormat($updateCFT->Other3_on);
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';
                        if(is_null($lastDocument->Other3_by) || $lastDocument->Other3_on == ''){
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->save();
                    }

                    if($index == 14 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Other4_by = Auth::user()->name;
                        $updateCFT->Other4_on = Carbon::now()->format('Y-m-d');
                         $history = new RootAuditTrial();
                        $history->root_id = $id;
                        $history->activity_type = 'Other 4 Completed By, Other 4 Completed On';
                        if(is_null($lastDocument->Other4_by) || $lastDocument->Other4_on == ''){
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->Other4_by. ' ,' . Helpers::getdateFormat($lastDocument->Other4_on);
                        }
                        $history->action='CFT Review Complete';
                        $history->current = $updateCFT->Other4_by. ',' . Helpers::getdateFormat($updateCFT->Other4_on);
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';
                        if(is_null($lastDocument->Other4_by) || $lastDocument->Other4_on == ''){
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->save();
                    }

                    if($index == 15 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Other5_by = Auth::user()->name;
                        $updateCFT->Other5_on = Carbon::now()->format('Y-m-d');
                         $history = new RootAuditTrial();
                          $history->root_id = $id;
                        $history->activity_type = 'Other 5 Completed By, Other 5 Completed On';
                        if(is_null($lastDocument->Other5_by) || $lastDocument->Other5_on == ''){
                            $history->previous = "";
                        } else {
                            $history->previous = $lastDocument->Other5_by. ' ,' . Helpers::getdateFormat($lastDocument->Other5_on);
                        }
                        $history->action='CFT Review Complete';
                        $history->current = $updateCFT->Other5_by. ',' . Helpers::getdateFormat($updateCFT->Other5_on);
                        $history->user_id = Auth::user()->name;
                        $history->user_name = Auth::user()->name;
                        $history->change_to = "Not Applicable";
                        $history->change_from = $lastDocument->status;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = 'CFT Review';
                        if(is_null($lastDocument->Other5_by) || $lastDocument->Other5_on == ''){
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->save();
                    }
                    $updateCFT->update();

                    // Check if the value is not null and not equal to 0
                    if ($value != null && $value != 0) {
                        $valuesArray[] = $value;
                    }
                }
                if ($IsCFTRequired) {
                    if (count(array_unique($valuesArray)) == ($cftDetails + 1)) {
                        $stage = new RootCFt();
                        $stage->root_cause_analyses_id = $id;
                        $stage->cft_user_id = Auth::user()->id;
                        $stage->status = "Completed";
                        $stage->comment = $request->comments;
                        $stage->save();
                    } else {
                        $stage = new RootCFt();
                        $stage->root_cause_analyses_id = $id;
                        $stage->cft_user_id = Auth::user()->id;
                        $stage->status = "In-progress";
                        $stage->comment = $request->comments;
                        $stage->save();
                    }
                }
                
                $checkCFTCount = RootCFt::withoutTrashed()->where(['status' => 'Completed', 'root_cause_analyses_id' => $id])->count();
                $Cft = RootCFt::withoutTrashed()->where('root_cause_analyses_id', $id)->first();
                
                if (!$IsCFTRequired || $checkCFTCount) {
                    $root->stage = "5";
                    $root->status = "QA/CQA Approval";                
                    $root->cft_review_by = Auth::user()->name;
                    $root->cft_review_on = Carbon::now()->format('d-M-Y');
                    $root->cft_review_comment = $request->comments;

                     $history = new RootAuditTrial();
                $history->root_id = $id;

                    $history->activity_type = 'CFT Review Complete By, CFT Review Complete On';
                    if (is_null($lastDocument->cft_review_by) || $lastDocument->cft_review_by === '') {
                        $history->previous = "NULL";
                    } else {
                        $history->previous = $lastDocument->cft_review_by . ' , ' . $lastDocument->cft_review_on;
                    }
                    $history->current = $root->cft_review_by . ' , ' . $root->cft_review_on;
                    if (is_null($lastDocument->cft_review_by) || $lastDocument->cft_review_on === '') {
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
                    $history->change_to = "QA/CQA Approval";
                    $history->change_from = $lastDocument->status;
                    $history->stage = 'Plan Proposed';
                    $history->save();
                       
                    $root->update();
                }
                toastr()->success('Sent QA/CQA Approval');
                return back();
            }








            //------------chnages by Ashish-----------------------

            if ($root->stage == 5) {
                $root->stage = "6";
                $root->status = "Investigation in Progress";
                $root->QQQA_Review_Complete_By= Auth::user()->name;
                $root->QQQA_Review_Complete_On= Carbon::now()->format('d-M-Y');
                $root->QAQQ_Review_Complete_comment = $request->comment;

                $history = new RootAuditTrial();
                $history->root_id = $id;
                $history->activity_type = 'QA Review Complete By, QA Review Complete On';
                $history->previous ="Initial QA/CQA Review";
                $history->current = $root->QQQA_Review_Complete_By;
                $history->comment = $request->comment;
                $history->action = 'QA Review Complete';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Investigation in Progress";
                $history->change_from = $lastDocument->status;
                $history->action_name = 'Update';
                $history->stage = 'Investigation in Progress';
                if (is_null($lastDocument->QQQA_Review_Complete_By) || $lastDocument->QQQA_Review_Complete_By === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->QQQA_Review_Complete_By . ' , ' . $lastDocument->QQQA_Review_Complete_On;
                }
                $history->current = $root->QQQA_Review_Complete_By . ' , ' . $root->QQQA_Review_Complete_On;
                if (is_null($lastDocument->QQQA_Review_Complete_By) || $lastDocument->QQQA_Review_Complete_By === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                

                $history->save();
            
                $list = Helpers::getInitiatorUserList($root->division_id);
                 
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                $userId = $users->pluck('id')->implode(',');

                if(!empty($users)){
                    try {
                        $history = new RootAuditTrial();
                        $history->root_id = $id;
                        $history->activity_type = "Not Applicable";
                        $history->previous = "Not Applicable";
                        $history->current = "Not Applicable";
                        $history->action = 'Notification';
                        $history->comment = "";
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = "Not Applicable";
                        $history->change_to = "Not Applicable";
                        $history->change_from = "Initial QA/CQA Review";
                        $history->stage = "";
                        $history->action_name = "";
                        $history->mailUserId = $userId;
                        $history->role_name = "QA/CQA";
                        $history->save();
                    } catch (\Throwable $e) {
                        \Log::error('Mail failed to send: ' . $e->getMessage());
                    }
                }


                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $root->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Root Cause Analysis",
                        'division_id' => $root->division_id,
                        'short_description' => $root->short_description,
                        'initiator_id' => $root->initiator_id,
                        'due_date' => $root->due_date,
                        'record' => $root->record,
                        'site' => "RCA",
                        'comment' => $request->comments,
                        'status' => $root->status,
                        'stage' => $root->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                foreach ($list as $u) {
                    $email = Helpers::getUserEmail($u->user_id);
                        if ($email !== null) {
                        try {
                            Mail::send(
                                'mail.view-mail',
                                ['data' => $root, 'site' => "RCA", 'history' => "QA/CQA Review Complete", 'process' => 'Root Cause Analysis', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                function ($message) use ($email, $root) {
                                    $message->to($email)
                                    ->subject("Medicef Notification: Root Cause Analysis, Record #" . str_pad($root->record, 4, '0', STR_PAD_LEFT) . " - Activity: QA/CQA Review Complete Performed");
                                }
                            );
                        } catch(\Exception $e) {
                            info('Error sending mail', [$e]);
                        }
                    }
                }


                $root->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($root->stage == 6) {
                $root->stage = "7";
                $root->status = 'HOD Final Review';
                $root->submitted_by = Auth::user()->name;
                $root->submitted_on = Carbon::now()->format('d-M-Y');
                $root->qa_comments_new = $request->comment;

                $history = new RootAuditTrial();
                $history->root_id = $id;
                $history->activity_type = 'Submited By, Submited On';
                $history->previous ="Investigation in Progress";
                $history->current = $root->submitted_by;
                $history->comment = $request->comment;
                $history->action = 'Submit';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "HOD Final Review";
                $history->change_from = $lastDocument->status;
                $history->action_name = 'Update';
                $history->stage = 'HOD Final Review';
                if (is_null($lastDocument->submitted_by) || $lastDocument->submitted_by === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->submitted_by . ' , ' . $lastDocument->submitted_on;
                }
                $history->current = $root->submitted_by . ' , ' . $root->submitted_on;
                if (is_null($lastDocument->submitted_by) || $lastDocument->submitted_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();

                $list = Helpers::getHodUserList($root->division_id);
                 
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                $userId = $users->pluck('id')->implode(',');

                if(!empty($users)){
                    try {
                        $history = new RootAuditTrial();
                        $history->root_id = $id;
                        $history->activity_type = "Not Applicable";
                        $history->previous = "Not Applicable";
                        $history->current = "Not Applicable";
                        $history->action = 'Notification';
                        $history->comment = "";
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = "Not Applicable";
                        $history->change_to = "Not Applicable";
                        $history->change_from = "Investigation In progress";
                        $history->stage = "";
                        $history->action_name = "";
                        $history->mailUserId = $userId;
                        $history->role_name = "Initiator";
                        $history->save();
                    } catch (\Throwable $e) {
                        \Log::error('Mail failed to send: ' . $e->getMessage());
                    }
                }


                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $root->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Root Cause Analysis",
                        'division_id' => $root->division_id,
                        'short_description' => $root->short_description,
                        'initiator_id' => $root->initiator_id,
                        'due_date' => $root->due_date,
                        'record' => $root->record,
                        'site' => "RCA",
                        'comment' => $request->comments,
                        'status' => $root->status,
                        'stage' => $root->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                foreach ($list as $u) {
                    $email = Helpers::getUserEmail($u->user_id);
                        if ($email !== null) {
                        try {
                            Mail::send(
                                'mail.view-mail',
                                ['data' => $root, 'site' => "RCA", 'history' => "Submit", 'process' => 'Root Cause Analysis', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                function ($message) use ($email, $root) {
                                    $message->to($email)
                                    ->subject("Medicef Notification: Root Cause Analysis, Record #" . str_pad($root->record, 4, '0', STR_PAD_LEFT) . " - Activity: Submit Performed");
                                }
                            );
                        } catch(\Exception $e) {
                            info('Error sending mail', [$e]);
                        }
                    }
                }



                $root->update();
                toastr()->success('Document Sent');
                return back();
            }



            
            // if ($root->stage == 3) {
            //     $root->stage = "4";
            //     $root->status = "Pending  Review";
            //     $root->submitted_by = Auth::user()->name;
            //     $root->submitted_on = Carbon::now()->format('d-M-Y');



            //     $history = new RootAuditTrial();
            //     $history->root_id = $id;
            //     $history->activity_type = 'Activity Log';
            //     $history->previous ="Pending QA Review";
            //     $history->current = $root->submitted_by;
            //     $history->comment = $request->comment;
            //     $history->action = 'QA Review Complete';
            //     $history->user_id = Auth::user()->id;
            //     $history->user_name = Auth::user()->name;
            //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //     $history->origin_state = $lastDocument->status;
            //     $history->change_to =   "Not Applicable";
            //     $history->change_from = $lastDocument->status;
            //     $history->action_name = 'Update';
            //     $history->stage = 'Pending QA Review';
            //     $history->save();
            //     $root->update();
            //     toastr()->success('Document Sent');
            //     return back();
            // }
            
            // if ($root->stage == 4) {
            //     $root->stage = "5";
            //     $root->status = 'Pending QA Review';

            //     $root->submitted_by = Auth::user()->name;
            //     $root->submitted_on = Carbon::now()->format('d-M-Y');

            //     $history = new RootAuditTrial();
            //     $history->root_id = $id;
            //     $history->activity_type = 'Activity Log';
            //     $history->previous ="Pending QA Review";
            //     $history->current = $root->submitted_by;
            //     $history->comment = $request->comment;
            //     $history->action = 'Approved';
            //     $history->user_id = Auth::user()->id;
            //     $history->user_name = Auth::user()->name;
            //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //     $history->origin_state = $lastDocument->status;
            //     $history->change_to =   "Not Applicable";
            //     $history->change_from = $lastDocument->status;
            //     $history->action_name = 'Update';
            //     $history->stage = 'Pending QA Review';
              
            //     $history->save();








            //     $root->update();
            //     toastr()->success('Document Sent');
            //     return back();
            // }
            if ($root->stage == 7) {
                $root->stage = "8";
                $root->status = "Final QA/CQA Review";
                $root->HOD_Final_Review_Complete_By = Auth::user()->name;
                $root->HOD_Final_Review_Complete_On = Carbon::now()->format('d-M-Y');
                $root->HOD_Final_Review_Complete_Comment = $request->comment;

                $history = new RootAuditTrial();
                $history->root_id = $id;
                $history->activity_type = 'HOD Final Review Complete By, HOD Final Review Complete On';
                $history->previous = "HOD Final Review";
                $history->current = $root->HOD_Final_Review_Complete_By;
                $history->action = 'HOD Final Review Complete';
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Final QA/CQA Review";
                $history->change_from = $lastDocument->status;
                $history->stage='Final QA/CQA Review';
                $history->action_name = 'Update';
                if (is_null($lastDocument->HOD_Final_Review_Complete_By) || $lastDocument->HOD_Final_Review_Complete_By === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->HOD_Final_Review_Complete_By . ' , ' . $lastDocument->HOD_Final_Review_Complete_On;
                }
                $history->current = $root->HOD_Final_Review_Complete_By . ' , ' . $root->HOD_Final_Review_Complete_On;
                if (is_null($lastDocument->HOD_Final_Review_Complete_By) || $lastDocument->HOD_Final_Review_Complete_By === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();

                $list = Helpers::getQAUserList($root->division_id);
                 
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                $userId = $users->pluck('id')->implode(',');

                if(!empty($users)){
                    try {
                        $history = new RootAuditTrial();
                        $history->root_id = $id;
                        $history->activity_type = "Not Applicable";
                        $history->previous = "Not Applicable";
                        $history->current = "Not Applicable";
                        $history->action = 'Notification';
                        $history->comment = "";
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = "Not Applicable";
                        $history->change_to = "Not Applicable";
                        $history->change_from = "HOD Final Review";
                        $history->stage = "";
                        $history->action_name = "";
                        $history->mailUserId = $userId;
                        $history->role_name = "HOD";
                        $history->save();
                    } catch (\Throwable $e) {
                        \Log::error('Mail failed to send: ' . $e->getMessage());
                    }
                }


                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $root->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Root Cause Analysis",
                        'division_id' => $root->division_id,
                        'short_description' => $root->short_description,
                        'initiator_id' => $root->initiator_id,
                        'due_date' => $root->due_date,
                        'record' => $root->record,
                        'site' => "RCA",
                        'comment' => $request->comments,
                        'status' => $root->status,
                        'stage' => $root->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                foreach ($list as $u) {
                    $email = Helpers::getUserEmail($u->user_id);
                        if ($email !== null) {
                        try {
                            Mail::send(
                                'mail.view-mail',
                                ['data' => $root, 'site' => "RCA", 'history' => "HOD Final Review Complete", 'process' => 'Root Cause Analysis', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                function ($message) use ($email, $root) {
                                    $message->to($email)
                                    ->subject("Medicef Notification: Root Cause Analysis, Record #" . str_pad($root->record, 4, '0', STR_PAD_LEFT) . " - Activity: HOD Final Review Complete Performed");
                                }
                            );
                        } catch(\Exception $e) {
                            info('Error sending mail', [$e]);
                        }
                    }
                }


                $root->update();
                toastr()->success('Document Sent');
                return back();
            }
               if ($root->stage == 8) {
                $root->stage = "9";
                $root->status = "QAH/CQAH Final Review";
                $root->Final_QA_Review_Complete_By = Auth::user()->name;
                $root->Final_QA_Review_Complete_On = Carbon::now()->format('d-M-Y');
                $root->Final_QA_Review_Complete_Comment = $request->comment;
             

                $history = new RootAuditTrial();
                $history->root_id = $id;
                $history->activity_type = 'Final QA/CQA Review Complete By, Final QA/CQA Review Complete On';
                // $history->previous = $lastDocument;
                $history->current = $root->Final_QA_Review_Complete_By;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->action = 'Final QA/CQA Review Complete';
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_to =   "QAH/CQAH Final Review";
                $history->change_from = $lastDocument->status;
                $history->action_name = 'Update';

                $history->stage='QAH/CQAH Final Review';
                if (is_null($lastDocument->Final_QA_Review_Complete_By) || $lastDocument->Final_QA_Review_Complete_By === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->Final_QA_Review_Complete_By . ' , ' . $lastDocument->Final_QA_Review_Complete_On;
                }
                $history->current = $root->Final_QA_Review_Complete_By . ' , ' . $root->Final_QA_Review_Complete_On;
                if (is_null($lastDocument->Final_QA_Review_Complete_By) || $lastDocument->Final_QA_Review_Complete_By === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();

                $list = Helpers::getQAUserList($root->division_id);
                 
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                $userId = $users->pluck('id')->implode(',');

                if(!empty($users)){
                    try {
                        $history = new RootAuditTrial();
                        $history->root_id = $id;
                        $history->activity_type = "Not Applicable";
                        $history->previous = "Not Applicable";
                        $history->current = "Not Applicable";
                        $history->action = 'Notification';
                        $history->comment = "";
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = "Not Applicable";
                        $history->change_to = "Not Applicable";
                        $history->change_from = "HOD Final Review";
                        $history->stage = "";
                        $history->action_name = "";
                        $history->mailUserId = $userId;
                        $history->role_name = "QA/CQA";
                        $history->save();
                    } catch (\Throwable $e) {
                        \Log::error('Mail failed to send: ' . $e->getMessage());
                    }
                }


                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $root->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Root Cause Analysis",
                        'division_id' => $root->division_id,
                        'short_description' => $root->short_description,
                        'initiator_id' => $root->initiator_id,
                        'due_date' => $root->due_date,
                        'record' => $root->record,
                        'site' => "RCA",
                        'comment' => $request->comments,
                        'status' => $root->status,
                        'stage' => $root->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                foreach ($list as $u) {
                    $email = Helpers::getUserEmail($u->user_id);
                        if ($email !== null) {
                        try {
                            Mail::send(
                                'mail.view-mail',
                                ['data' => $root, 'site' => "RCA", 'history' => "HOD Final Review Complete", 'process' => 'Root Cause Analysis', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                function ($message) use ($email, $root) {
                                    $message->to($email)
                                    ->subject("Medicef Notification: Root Cause Analysis, Record #" . str_pad($root->record, 4, '0', STR_PAD_LEFT) . " - Activity: HOD Final Review Complete Performed");
                                }
                            );
                        } catch(\Exception $e) {
                            info('Error sending mail', [$e]);
                        }
                    }
                }

                $root->update();
                toastr()->success('Document Sent');
                return back();
            }


            if ($root->stage == 9) {
                $root->stage = "10";
                $root->status = "Closed - Done";
                $root->evaluation_complete_by = Auth::user()->name;
                $root->evaluation_complete_on = Carbon::now()->format('d-M-Y');
                $root->evalution_Closure_comment = $request->comment;
                $history = new RootAuditTrial();
                $history->root_id = $id;
                $history->activity_type = 'QAH/CQAH Closure By,QAH/CQAH Closure On';
                $history->previous = $lastDocument->submitted_by;
                $history->current = $root->evaluation_complete_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->action = 'QAH/CQAH Closure';
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                // $history->origin_state = $lastDocument->status;
                $history->change_to =   "Closed - Done";
                $history->change_from = $lastDocument->status;
                $history->action_name = 'Update';
               // $history->stage = 'Completed';
              
               
                $history->stage='Closed - Done';
                if (is_null($lastDocument->evaluation_complete_by) || $lastDocument->evaluation_complete_by === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->evaluation_complete_by . ' , ' . $lastDocument->evaluation_complete_on;
                }
                $history->current = $root->evaluation_complete_by . ' , ' . $root->evaluation_complete_on;
                if (is_null($lastDocument->evaluation_complete_by) || $lastDocument->evaluation_complete_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();
                $root->update();

                $list = Helpers::getQAUserList($root->division_id);
                 
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                $userId = $users->pluck('id')->implode(',');

                if(!empty($users)){
                    try {
                        $history = new RootAuditTrial();
                        $history->root_id = $id;
                        $history->activity_type = "Not Applicable";
                        $history->previous = "Not Applicable";
                        $history->current = "Not Applicable";
                        $history->action = 'Notification';
                        $history->comment = "";
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = "Not Applicable";
                        $history->change_to = "Not Applicable";
                        $history->change_from = "QAH/CQAH Final Review";
                        $history->stage = "";
                        $history->action_name = "";
                        $history->mailUserId = $userId;
                        $history->role_name = "CQA/QA Head";
                        $history->save();
                    } catch (\Throwable $e) {
                        \Log::error('Mail failed to send: ' . $e->getMessage());
                    }
                }


                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $root->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Root Cause Analysis",
                        'division_id' => $root->division_id,
                        'short_description' => $root->short_description,
                        'initiator_id' => $root->initiator_id,
                        'due_date' => $root->due_date,
                        'record' => $root->record,
                        'site' => "RCA",
                        'comment' => $request->comments,
                        'status' => $root->status,
                        'stage' => $root->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                foreach ($list as $u) {
                    $email = Helpers::getUserEmail($u->user_id);
                        if ($email !== null) {
                        try {
                            Mail::send(
                                'mail.view-mail',
                                ['data' => $root, 'site' => "RCA", 'history' => "Final QA/CQA Review Complete", 'process' => 'Root Cause Analysis', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                function ($message) use ($email, $root) {
                                    $message->to($email)
                                    ->subject("Medicef Notification: Root Cause Analysis, Record #" . str_pad($root->record, 4, '0', STR_PAD_LEFT) . " - Activity: Final QA/CQA Review Complete Performed");
                                }
                            );
                        } catch(\Exception $e) {
                            info('Error sending mail', [$e]);
                        }
                    }
                }

                $list = Helpers::getInitiatorUserList($root->division_id);
                 
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                $userId = $users->pluck('id')->implode(',');

                if(!empty($users)){
                    try {
                        $history = new RootAuditTrial();
                        $history->root_id = $id;
                        $history->activity_type = "Not Applicable";
                        $history->previous = "Not Applicable";
                        $history->current = "Not Applicable";
                        $history->action = 'Notification';
                        $history->comment = "";
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = "Not Applicable";
                        $history->change_to = "Not Applicable";
                        $history->change_from = "QAH/CQAH Final Review";
                        $history->stage = "";
                        $history->action_name = "";
                        $history->mailUserId = $userId;
                        $history->role_name = "CQA/QA Head";
                        $history->save();
                    } catch (\Throwable $e) {
                        \Log::error('Mail failed to send: ' . $e->getMessage());
                    }
                }


                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $root->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Root Cause Analysis",
                        'division_id' => $root->division_id,
                        'short_description' => $root->short_description,
                        'initiator_id' => $root->initiator_id,
                        'due_date' => $root->due_date,
                        'record' => $root->record,
                        'site' => "RCA",
                        'comment' => $request->comments,
                        'status' => $root->status,
                        'stage' => $root->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                foreach ($list as $u) {
                    $email = Helpers::getUserEmail($u->user_id);
                        if ($email !== null) {
                        try {
                            Mail::send(
                                'mail.view-mail',
                                ['data' => $root, 'site' => "RCA", 'history' => "HOD Final Review Complete", 'process' => 'Root Cause Analysis', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                function ($message) use ($email, $root) {
                                    $message->to($email)
                                    ->subject("Medicef Notification: Root Cause Analysis, Record #" . str_pad($root->record, 4, '0', STR_PAD_LEFT) . " - Activity: HOD Final Review Complete Performed");
                                }
                            );
                        } catch(\Exception $e) {
                            info('Error sending mail', [$e]);
                        }
                    }
                }

                $list = Helpers::getHodUserList($root->division_id);
                 
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                $userId = $users->pluck('id')->implode(',');

                if(!empty($users)){
                    try {
                        $history = new RootAuditTrial();
                        $history->root_id = $id;
                        $history->activity_type = "Not Applicable";
                        $history->previous = "Not Applicable";
                        $history->current = "Not Applicable";
                        $history->action = 'Notification';
                        $history->comment = "";
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = "Not Applicable";
                        $history->change_to = "Not Applicable";
                        $history->change_from = "QAH/CQAH Final Review";
                        $history->stage = "";
                        $history->action_name = "";
                        $history->mailUserId = $userId;
                        $history->role_name = "CQA/QA Head";
                        $history->save();
                    } catch (\Throwable $e) {
                        \Log::error('Mail failed to send: ' . $e->getMessage());
                    }
                }


                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $root->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Root Cause Analysis",
                        'division_id' => $root->division_id,
                        'short_description' => $root->short_description,
                        'initiator_id' => $root->initiator_id,
                        'due_date' => $root->due_date,
                        'record' => $root->record,
                        'site' => "RCA",
                        'comment' => $request->comments,
                        'status' => $root->status,
                        'stage' => $root->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                foreach ($list as $u) {
                    $email = Helpers::getUserEmail($u->user_id);
                        if ($email !== null) {
                        try {
                            Mail::send(
                                'mail.view-mail',
                                ['data' => $root, 'site' => "RCA", 'history' => "QAH/CQAH Closure", 'process' => 'Root Cause Analysis', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                function ($message) use ($email, $root) {
                                    $message->to($email)
                                    ->subject("Medicef Notification: Root Cause Analysis, Record #" . str_pad($root->record, 4, '0', STR_PAD_LEFT) . " - Activity: QAH/CQAH Closure Performed");
                                }
                            );
                        } catch(\Exception $e) {
                            info('Error sending mail', [$e]);
                        }
                    }
                }

    
                toastr()->success('Document Sent');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }


    public function root_Cancel(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $root = RootCauseAnalysis::find($id);
            $lastDocument =  RootCauseAnalysis::find($id);
            $data =  RootCauseAnalysis::find($id);

            $root->stage = "0";
            $root->status = "Closed-Cancelled";
            $root->cancelled_by = Auth::user()->name;
            $root->cancelled_on = Carbon::now()->format('d-M-Y');
            $root->cancel_comment = $request->comment;

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Cancelled By,Cancelled On';
            // $history->previous = $lastDocument->cancelled_by;
            $history->previous = "";
            $history->current = $root->cancelled_by;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->action = "Cancel";
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
             $history->origin_state = $lastDocument->status;
             $history->change_to =   "Closed-Cancelled";
             $history->change_from = $lastDocument->status;
              
            $history->stage='Cancelled ';
            if (is_null($lastDocument->cancelled_by) || $lastDocument->cancelled_by === '') {
                $history->previous = "";
            } else {
                $history->previous = $lastDocument->cancelled_by . ' , ' . $lastDocument->cancelled_on;
            }
            $history->current = $root->cancelled_by . ' , ' . $root->cancelled_on;
            if (is_null($lastDocument->cancelled_by) || $lastDocument->cancelled_by === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }
            $history->save();
        //     $list = Helpers::getQAUserList();
        //     foreach ($list as $u) {
        //         if($u->q_m_s_divisions_id == $root->division_id){
        //             $email = Helpers::getInitiatorEmail($u->user_id);
        //              if ($email !== null) {
                  
        //               Mail::send(
        //                   'mail.view-mail',
        //                    ['data' => $root],
        //                 function ($message) use ($email) {
        //                     $message->to($email)
        //                         ->subject("Document sent ".Auth::user()->name);
        //                 }
        //               );
        //             }
        //      } 
        //   }


        $list = Helpers::getQAUserList($root->division_id);
                 
        $userIds = collect($list)->pluck('user_id')->toArray();
        $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
        $userId = $users->pluck('id')->implode(',');

        if(!empty($users)){
            try {
                $history = new RootAuditTrial();
                $history->root_id = $id;
                $history->activity_type = "Not Applicable";
                $history->previous = "Not Applicable";
                $history->current = "Not Applicable";
                $history->action = 'Notification';
                $history->comment = "";
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = "Not Applicable";
                $history->change_to = "Not Applicable";
                $history->change_from = "Opened";
                $history->stage = "";
                $history->action_name = "";
                $history->mailUserId = $userId;
                $history->role_name = "Initiator";
                $history->save();
            } catch (\Throwable $e) {
                \Log::error('Mail failed to send: ' . $e->getMessage());
            }
        }


        foreach ($users as $userValue) {
            DB::table('notifications')->insert([
                'activity_id' => $root->id,
                'activity_type' => "Notification",
                'from_id' => Auth::user()->id,
                'user_name' => $userValue->name,
                'to_id' => $userValue->id,
                'process_name' => "Root Cause Analysis",
                'division_id' => $root->division_id,
                'short_description' => $root->short_description,
                'initiator_id' => $root->initiator_id,
                'due_date' => $root->due_date,
                'record' => $root->record,
                'site' => "RCA",
                'comment' => $request->comments,
                'status' => $root->status,
                'stage' => $root->stage,
                'created_at' => Carbon::now(),
            ]);
        }

        foreach ($list as $u) {
            $email = Helpers::getUserEmail($u->user_id);
                if ($email !== null) {
                try {
                    Mail::send(
                        'mail.view-mail',
                        ['data' => $root, 'site' => "RCA", 'history' => "Cancel", 'process' => 'Root Cause Analysis', 'comment' => $request->comments, 'user' => Auth::user()->name],
                        function ($message) use ($email, $root) {
                            $message->to($email)
                            ->subject("Medicef Notification: Root Cause Analysis, Record #" . str_pad($root->record, 4, '0', STR_PAD_LEFT) . " - Activity: Cancel Performed");
                        }
                    );
                } catch(\Exception $e) {
                    info('Error sending mail', [$e]);
                }
            }
        }

                $list = Helpers::getHodUserList($root->division_id);
                 
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                $userId = $users->pluck('id')->implode(',');

                if(!empty($users)){
                    try {
                        $history = new RootAuditTrial();
                        $history->root_id = $id;
                        $history->activity_type = "Not Applicable";
                        $history->previous = "Not Applicable";
                        $history->current = "Not Applicable";
                        $history->action = 'Notification';
                        $history->comment = "";
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = "Not Applicable";
                        $history->change_to = "Not Applicable";
                        $history->change_from = "Opened";
                        $history->stage = "";
                        $history->action_name = "";
                        $history->mailUserId = $userId;
                        $history->role_name = "Initiator";
                        $history->save();
                    } catch (\Throwable $e) {
                        \Log::error('Mail failed to send: ' . $e->getMessage());
                    }
                }


                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $root->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Root Cause Analysis",
                        'division_id' => $root->division_id,
                        'short_description' => $root->short_description,
                        'initiator_id' => $root->initiator_id,
                        'due_date' => $root->due_date,
                        'record' => $root->record,
                        'site' => "RCA",
                        'comment' => $request->comments,
                        'status' => $root->status,
                        'stage' => $root->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                foreach ($list as $u) {
                    $email = Helpers::getUserEmail($u->user_id);
                        if ($email !== null) {
                        try {
                            Mail::send(
                                'mail.view-mail',
                                ['data' => $root, 'site' => "RCA", 'history' => "QAH/CQAH Closure", 'process' => 'Root Cause Analysis', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                function ($message) use ($email, $root) {
                                    $message->to($email)
                                    ->subject("Medicef Notification: Root Cause Analysis, Record #" . str_pad($root->record, 4, '0', STR_PAD_LEFT) . " - Activity: QAH/CQAH Closure Performed");
                                }
                            );
                        } catch(\Exception $e) {
                            info('Error sending mail', [$e]);
                        }
                    }
                }



            $root->update();
            $history = new RootCauseAnalysisHistory();
            $history->type = "Root Cause Analysis";
            $history->doc_id = $id;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->stage_id = $root->stage;
            $history->status = $root->status;
            $history->save();
            toastr()->success('Document Sent');
            return back();
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function root_reject(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $capa = RootCauseAnalysis::find($id);
            $lastDocument =  RootCauseAnalysis::find($id);

             if ($capa->stage == 2) {
                $capa->stage = "1";
                $capa->status = "Opened";

                $capa->More_Info_ack_by = Auth::user()->name;
                $capa->More_Info_ack_on = Carbon::now()->format('d-M-Y');
                $capa->More_Info_ack_comment = $request->comment;

                $history = new RootAuditTrial();    
                $history->root_id = $id;
                //$history->previous = "Not Applicable";
                //$history->current ="Not Applicable";
                $history->activity_type = 'More Info Required By, More Info Required On';

                if (is_null($lastDocument->More_Info_ack_by) || $lastDocument->More_Info_ack_by === '') {
                    $history->previous = "";
                } else {
                    $history->previous = $lastDocument->More_Info_ack_by . ' , ' . $lastDocument->More_Info_ack_on;
                }
                $history->current = $capa->More_Info_ack_by . ' , ' . $capa->More_Info_ack_on;

                $history->comment = $request->comment;
                $history->action  = "More Information Required";
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Opened";
                $history->change_from = $lastDocument->status;
                //$history->action_name ="Not Applicable";

                if (is_null($lastDocument->More_Info_ack_by) || $lastDocument->More_Info_ack_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name ="Update";
                }

                $history->stage='Opened';
                $history->save();

                $list = Helpers::getInitiatorUserList($capa->division_id);
                 
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                $userId = $users->pluck('id')->implode(',');

                if(!empty($users)){
                    try {
                        $history = new RootAuditTrial();
                        $history->root_id = $id;
                        $history->activity_type = "Not Applicable";
                        $history->previous = "Not Applicable";
                        $history->current = "Not Applicable";
                        $history->action = 'Notification';
                        $history->comment = "";
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = "Not Applicable";
                        $history->change_to = "Not Applicable";
                        $history->change_from = "HOD Review";
                        $history->stage = "";
                        $history->action_name = "";
                        $history->mailUserId = $userId;
                        $history->role_name = "HOD";
                        $history->save();
                    } catch (\Throwable $e) {
                        \Log::error('Mail failed to send: ' . $e->getMessage());
                    }
                }


                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $capa->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Root Cause Analysis",
                        'division_id' => $capa->division_id,
                        'short_description' => $capa->short_description,
                        'initiator_id' => $capa->initiator_id,
                        'due_date' => $capa->due_date,
                        'record' => $capa->record,
                        'site' => "RCA",
                        'comment' => $request->comments,
                        'status' => $capa->status,
                        'stage' => $capa->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                foreach ($list as $u) {
                    $email = Helpers::getUserEmail($u->user_id);
                        if ($email !== null) {
                        try {
                            Mail::send(
                                'mail.view-mail',
                                ['data' => $capa, 'site' => "RCA", 'history' => "More Info Required", 'process' => 'Root Cause Analysis', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                function ($message) use ($email, $capa) {
                                    $message->to($email)
                                    ->subject("Medicef Notification: Root Cause Analysis, Record #" . str_pad($capa->record, 4, '0', STR_PAD_LEFT) . " - Activity: More Info Required Performed");
                                }
                            );
                        } catch(\Exception $e) {
                            info('Error sending mail', [$e]);
                        }
                    }
                }

                
                $capa->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($capa->stage == 3) {
                $capa->stage = "2";
                $capa->status = "HOD Review";

                $capa->More_Info_hrc_by = Auth::user()->name;
                $capa->More_Info_hrc_on = Carbon::now()->format('d-M-Y');
                $capa->More_Info_hrc_comment = $request->comment;

                // $capa->cft_comments_new = $request->comment;

                    $history = new RootAuditTrial();    
                    $history->root_id = $id;
                    //$history->previous = "Not Applicable";
                    //$history->current ="Not Applicable";
                    $history->activity_type = 'More Info Required By, More Info Required On';

                    if (is_null($lastDocument->More_Info_hrc_by) || $lastDocument->More_Info_hrc_by === '') {
                        $history->previous = "";
                    } else {
                        $history->previous = $lastDocument->More_Info_hrc_by . ' , ' . $lastDocument->More_Info_hrc_on;
                    }
                    $history->current = $capa->More_Info_hrc_by . ' , ' . $capa->More_Info_hrc_on;

                    $history->comment = $request->comment;
                    $history->action  = "More Information Required";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to =   "HOD Review";
                    $history->change_from = $lastDocument->status;
                    $history->action_name ="Not Applicable";
                    $history->stage='HOD Review';

                     
                     if (is_null($lastDocument->More_Info_hrc_by) || $lastDocument->More_Info_hrc_by === '') {
                         $history->action_name = 'New';
                     } else {
                         $history->action_name ="Update";
                     }
                    $history->save();


                $list = Helpers::getHodUserList($capa->division_id);
                 
                $userIds = collect($list)->pluck('user_id')->toArray();
                $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                $userId = $users->pluck('id')->implode(',');

                if(!empty($users)){
                    try {
                        $history = new RootAuditTrial();
                        $history->root_id = $id;
                        $history->activity_type = "Not Applicable";
                        $history->previous = "Not Applicable";
                        $history->current = "Not Applicable";
                        $history->action = 'Notification';
                        $history->comment = "";
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = "Not Applicable";
                        $history->change_to = "Not Applicable";
                        $history->change_from = "Initial QA/CQA Review";
                        $history->stage = "";
                        $history->action_name = "";
                        $history->mailUserId = $userId;
                        $history->role_name = "QA/CQA";
                        $history->save();
                    } catch (\Throwable $e) {
                        \Log::error('Mail failed to send: ' . $e->getMessage());
                    }
                }


                foreach ($users as $userValue) {
                    DB::table('notifications')->insert([
                        'activity_id' => $capa->id,
                        'activity_type' => "Notification",
                        'from_id' => Auth::user()->id,
                        'user_name' => $userValue->name,
                        'to_id' => $userValue->id,
                        'process_name' => "Root Cause Analysis",
                        'division_id' => $capa->division_id,
                        'short_description' => $capa->short_description,
                        'initiator_id' => $capa->initiator_id,
                        'due_date' => $capa->due_date,
                        'record' => $capa->record,
                        'site' => "RCA",
                        'comment' => $request->comments,
                        'status' => $capa->status,
                        'stage' => $capa->stage,
                        'created_at' => Carbon::now(),
                    ]);
                }

                foreach ($list as $u) {
                    $email = Helpers::getUserEmail($u->user_id);
                        if ($email !== null) {
                        try {
                            Mail::send(
                                'mail.view-mail',
                                ['data' => $capa, 'site' => "RCA", 'history' => "More Info Required", 'process' => 'Root Cause Analysis', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                function ($message) use ($email, $capa) {
                                    $message->to($email)
                                    ->subject("Medicef Notification: Root Cause Analysis, Record #" . str_pad($capa->record, 4, '0', STR_PAD_LEFT) . " - Activity: More Info Required Performed");
                                }
                            );
                        } catch(\Exception $e) {
                            info('Error sending mail', [$e]);
                        }
                    }
                }



                $capa->update();


                toastr()->success('Document Sent');
                return back();
            }
            if ($capa->stage == 4) {
                $capa->stage = "3";
                $capa->status = "QA/CQA Review";

                $capa->More_Info_qac_by = Auth::user()->name;
                $capa->More_Info_qac_on = Carbon::now()->format('d-M-Y');
                $capa->More_Info_qac_comment = $request->comment;

                    $history = new RootAuditTrial();    
                    $history->root_id = $id;
                    $history->activity_type = 'More Info Required By, More Info Required On';
                    //$history->previous = "Not Applicable";
                    //$history->current ="Not Applicable";

                    if (is_null($lastDocument->More_Info_qac_by) || $lastDocument->More_Info_qac_by === '') {
                        $history->previous = "";
                    } else {
                        $history->previous = $lastDocument->More_Info_qac_by . ' , ' . $lastDocument->More_Info_qac_on;
                    }
                    $history->current = $capa->More_Info_qac_by . ' , ' . $capa->More_Info_qac_on;

                    $history->comment = $request->comment;
                    $history->action  = "More Information Required";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to =   "QA/CQA Review";
                    $history->change_from = $lastDocument->status;
                    //$history->action_name ="Not Applicable";
                    $history->stage='QA/CQA Review';
                    
                     if (is_null($lastDocument->More_Info_qac_by) || $lastDocument->More_Info_qac_by === '') {
                         $history->action_name = 'New';
                     } else {
                         $history->action_name ="Update";
                     }
                    $history->save();

                    $list = Helpers::getQAUserList($capa->division_id);
                 
                    $userIds = collect($list)->pluck('user_id')->toArray();
                    $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                    $userId = $users->pluck('id')->implode(',');
    
                    if(!empty($users)){
                        try {
                            $history = new RootAuditTrial();
                            $history->root_id = $id;
                            $history->activity_type = "Not Applicable";
                            $history->previous = "Not Applicable";
                            $history->current = "Not Applicable";
                            $history->action = 'Notification';
                            $history->comment = "";
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = "Not Applicable";
                            $history->change_to = "Not Applicable";
                            $history->change_from = "Investigation In progress";
                            $history->stage = "";
                            $history->action_name = "";
                            $history->mailUserId = $userId;
                            $history->role_name = "Initiator";
                            $history->save();
                        } catch (\Throwable $e) {
                            \Log::error('Mail failed to send: ' . $e->getMessage());
                        }
                    }
    
    
                    foreach ($users as $userValue) {
                        DB::table('notifications')->insert([
                            'activity_id' => $capa->id,
                            'activity_type' => "Notification",
                            'from_id' => Auth::user()->id,
                            'user_name' => $userValue->name,
                            'to_id' => $userValue->id,
                            'process_name' => "Root Cause Analysis",
                            'division_id' => $capa->division_id,
                            'short_description' => $capa->short_description,
                            'initiator_id' => $capa->initiator_id,
                            'due_date' => $capa->due_date,
                            'record' => $capa->record,
                            'site' => "RCA",
                            'comment' => $request->comments,
                            'status' => $capa->status,
                            'stage' => $capa->stage,
                            'created_at' => Carbon::now(),
                        ]);
                    }
    
                    foreach ($list as $u) {
                        $email = Helpers::getUserEmail($u->user_id);
                            if ($email !== null) {
                            try {
                                Mail::send(
                                    'mail.view-mail',
                                    ['data' => $capa, 'site' => "RCA", 'history' => "More Info Required", 'process' => 'Root Cause Analysis', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                    function ($message) use ($email, $capa) {
                                        $message->to($email)
                                        ->subject("Medicef Notification: Root Cause Analysis, Record #" . str_pad($capa->record, 4, '0', STR_PAD_LEFT) . " - Activity: More Info Required Performed");
                                    }
                                );
                            } catch(\Exception $e) {
                                info('Error sending mail', [$e]);
                            }
                        }
                    }

                    

                $capa->update();

                toastr()->success('Document Sent');
                return back();
            }
            if ($capa->stage == 5) {
                $capa->stage = "4";
                $capa->status = "Investigation in Progress";

                $capa->More_Info_sub_by = Auth::user()->name;
                $capa->More_Info_sub_on = Carbon::now()->format('d-M-Y');
                $capa->More_Info_sub_comment = $request->comment;

                    $history = new RootAuditTrial();    
                    $history->root_id = $id;
                    $history->activity_type = 'More Info Required By, More Info Required On';
                    //$history->previous = "Not Applicable";
                    //$history->current ="Not Applicable";

                    if (is_null($lastDocument->More_Info_sub_by) || $lastDocument->More_Info_sub_by === '') {
                        $history->previous = "";
                    } else {
                        $history->previous = $lastDocument->More_Info_sub_by . ' , ' . $lastDocument->More_Info_sub_on;
                    }
                    $history->current = $capa->More_Info_sub_by . ' , ' . $capa->More_Info_sub_on;
                    
                    $history->comment = $request->comment;
                    $history->action  = "More Information Required";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to =   "Investigation in Progress";
                    $history->change_from = $lastDocument->status;
                    //$history->action_name ="Not Applicable";
                    $history->stage='Investigation in Progress';
                     
                     if (is_null($lastDocument->More_Info_sub_by) || $lastDocument->More_Info_sub_by === '') {
                         $history->action_name = 'New';
                     } else {
                         $history->action_name ="Update";
                     }
                    $history->save();

                    $list = Helpers::getInitiatorUserList($capa->division_id);
                 
                    $userIds = collect($list)->pluck('user_id')->toArray();
                    $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                    $userId = $users->pluck('id')->implode(',');
    
                    if(!empty($users)){
                        try {
                            $history = new RootAuditTrial();
                            $history->root_id = $id;
                            $history->activity_type = "Not Applicable";
                            $history->previous = "Not Applicable";
                            $history->current = "Not Applicable";
                            $history->action = 'Notification';
                            $history->comment = "";
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = "Not Applicable";
                            $history->change_to = "Not Applicable";
                            $history->change_from = "HOD Final Review";
                            $history->stage = "";
                            $history->action_name = "";
                            $history->mailUserId = $userId;
                            $history->role_name = "HOD";
                            $history->save();
                        } catch (\Throwable $e) {
                            \Log::error('Mail failed to send: ' . $e->getMessage());
                        }
                    }
    
    
                    foreach ($users as $userValue) {
                        DB::table('notifications')->insert([
                            'activity_id' => $capa->id,
                            'activity_type' => "Notification",
                            'from_id' => Auth::user()->id,
                            'user_name' => $userValue->name,
                            'to_id' => $userValue->id,
                            'process_name' => "Root Cause Analysis",
                            'division_id' => $capa->division_id,
                            'short_description' => $capa->short_description,
                            'initiator_id' => $capa->initiator_id,
                            'due_date' => $capa->due_date,
                            'record' => $capa->record,
                            'site' => "RCA",
                            'comment' => $request->comments,
                            'status' => $capa->status,
                            'stage' => $capa->stage,
                            'created_at' => Carbon::now(),
                        ]);
                    }
    
                    foreach ($list as $u) {
                        $email = Helpers::getUserEmail($u->user_id);
                            if ($email !== null) {
                            try {
                                Mail::send(
                                    'mail.view-mail',
                                    ['data' => $capa, 'site' => "RCA", 'history' => "More Info Required", 'process' => 'Root Cause Analysis', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                    function ($message) use ($email, $capa) {
                                        $message->to($email)
                                        ->subject("Medicef Notification: Root Cause Analysis, Record #" . str_pad($capa->record, 4, '0', STR_PAD_LEFT) . " - Activity: More Info Required Performed");
                                    }
                                );
                            } catch(\Exception $e) {
                                info('Error sending mail', [$e]);
                            }
                        }
                    }


                $capa->update();

                toastr()->success('Document Sent');
                return back();
            }
                if ($capa->stage == 6) {
                $capa->stage = "5";
                $capa->status = "HOD Final Review";

                $capa->More_Info_hfr_by = Auth::user()->name;
                $capa->More_Info_hfr_on = Carbon::now()->format('d-M-Y');
                $capa->More_Info_hfr_comment = $request->comment;

                    $history = new RootAuditTrial();    
                    $history->root_id = $id;
                    $history->activity_type = 'More Info Required By, More Info Required On';
                    //$history->previous = "Not Applicable";
                    //$history->current ="Not Applicable";

                    if (is_null($lastDocument->More_Info_hfr_by) || $lastDocument->More_Info_hfr_by === '') {
                        $history->previous = "";
                    } else {
                        $history->previous = $lastDocument->More_Info_hfr_by . ' , ' . $lastDocument->More_Info_hfr_on;
                    }
                    $history->current = $capa->More_Info_hfr_by . ' , ' . $capa->More_Info_hfr_on;

                    $history->comment = $request->comment;
                    $history->action  = "More Information Required";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to =   "HOD Final Review";
                    $history->change_from = $lastDocument->status;
                    //$history->action_name ="Not Applicable";
                    $history->stage='HOD Final Review';
                     
                     if (is_null($lastDocument->More_Info_hfr_by) || $lastDocument->More_Info_hfr_by === '') {
                         $history->action_name = 'New';
                     } else {
                         $history->action_name ="Update";
                     }
                     $history->save();

                     $list = Helpers::getHodUserList($capa->division_id);
                 
                     $userIds = collect($list)->pluck('user_id')->toArray();
                     $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                     $userId = $users->pluck('id')->implode(',');
     
                     if(!empty($users)){
                         try {
                             $history = new RootAuditTrial();
                             $history->root_id = $id;
                             $history->activity_type = "Not Applicable";
                             $history->previous = "Not Applicable";
                             $history->current = "Not Applicable";
                             $history->action = 'Notification';
                             $history->comment = "";
                             $history->user_id = Auth::user()->id;
                             $history->user_name = Auth::user()->name;
                             $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                             $history->origin_state = "Not Applicable";
                             $history->change_to = "Not Applicable";
                             $history->change_from = "Final QA/CQA Review";
                             $history->stage = "";
                             $history->action_name = "";
                             $history->mailUserId = $userId;
                             $history->role_name = "QA/CQA";
                             $history->save();
                         } catch (\Throwable $e) {
                             \Log::error('Mail failed to send: ' . $e->getMessage());
                         }
                     }
     
     
                     foreach ($users as $userValue) {
                         DB::table('notifications')->insert([
                             'activity_id' => $capa->id,
                             'activity_type' => "Notification",
                             'from_id' => Auth::user()->id,
                             'user_name' => $userValue->name,
                             'to_id' => $userValue->id,
                             'process_name' => "Root Cause Analysis",
                             'division_id' => $capa->division_id,
                             'short_description' => $capa->short_description,
                             'initiator_id' => $capa->initiator_id,
                             'due_date' => $capa->due_date,
                             'record' => $capa->record,
                             'site' => "RCA",
                             'comment' => $request->comments,
                             'status' => $capa->status,
                             'stage' => $capa->stage,
                             'created_at' => Carbon::now(),
                         ]);
                     }
     
                     foreach ($list as $u) {
                         $email = Helpers::getUserEmail($u->user_id);
                             if ($email !== null) {
                             try {
                                 Mail::send(
                                     'mail.view-mail',
                                     ['data' => $capa, 'site' => "RCA", 'history' => "More Info Required", 'process' => 'Root Cause Analysis', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                     function ($message) use ($email, $capa) {
                                         $message->to($email)
                                         ->subject("Medicef Notification: Root Cause Analysis, Record #" . str_pad($capa->record, 4, '0', STR_PAD_LEFT) . " - Activity: More Info Required Performed");
                                     }
                                 );
                             } catch(\Exception $e) {
                                 info('Error sending mail', [$e]);
                             }
                         }
                     }

                $capa->update();

                toastr()->success('Document Sent');
                return back();
            }
                    if ($capa->stage == 7) {
                    $capa->stage = "6";
                    $capa->status = "Final QA/CQA Review";

                    $capa->qA_review_complete_by = Auth::user()->name;
                    $capa->qA_review_complete_on = Carbon::now()->format('d-M-Y');
                    $capa->qA_review_complete_comment = $request->comment;
                    $history = new RootAuditTrial();    
                    $history->root_id = $id;
                    $history->activity_type = 'More Info Required By, More Info Required On';
                    //$history->previous = "Not Applicable";
                    //$history->current ="Not Applicable";

                    if (is_null($lastDocument->qA_review_complete_by) || $lastDocument->qA_review_complete_by === '') {
                        $history->previous = "";
                    } else {
                        $history->previous = $lastDocument->qA_review_complete_by . ' , ' . $lastDocument->qA_review_complete_on;
                    }
                    $history->current = $capa->qA_review_complete_by . ' , ' . $capa->qA_review_complete_on;

                    $history->comment = $request->comment;
                    $history->action  = "More Information Required";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to =   "Final QA/CQA Review";
                    $history->change_from = $lastDocument->status;
                    //$history->action_name ="Not Applicable";
                    $history->stage='Final QA/CQA Review';
                     
                     if (is_null($lastDocument->qA_review_complete_by) || $lastDocument->qA_review_complete_by === '') {
                         $history->action_name = 'New';
                     } else {
                         $history->action_name ="Update";
                     }
                    $history->save();

                    $list = Helpers::getQAHeadUserList($capa->division_id);
                 
                    $userIds = collect($list)->pluck('user_id')->toArray();
                    $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                    $userId = $users->pluck('id')->implode(',');
    
                    if(!empty($users)){
                        try {
                            $history = new RootAuditTrial();
                            $history->root_id = $id;
                            $history->activity_type = "Not Applicable";
                            $history->previous = "Not Applicable";
                            $history->current = "Not Applicable";
                            $history->action = 'Notification';
                            $history->comment = "";
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = "Not Applicable";
                            $history->change_to = "Not Applicable";
                            $history->change_from = "QAH/CQAH Final Review";
                            $history->stage = "";
                            $history->action_name = "";
                            $history->mailUserId = $userId;
                            $history->role_name = "CQA/QA Head";
                            $history->save();
                        } catch (\Throwable $e) {
                            \Log::error('Mail failed to send: ' . $e->getMessage());
                        }
                    }
    
    
                    foreach ($users as $userValue) {
                        DB::table('notifications')->insert([
                            'activity_id' => $capa->id,
                            'activity_type' => "Notification",
                            'from_id' => Auth::user()->id,
                            'user_name' => $userValue->name,
                            'to_id' => $userValue->id,
                            'process_name' => "Root Cause Analysis",
                            'division_id' => $capa->division_id,
                            'short_description' => $capa->short_description,
                            'initiator_id' => $capa->initiator_id,
                            'due_date' => $capa->due_date,
                            'record' => $capa->record,
                            'site' => "RCA",
                            'comment' => $request->comments,
                            'status' => $capa->status,
                            'stage' => $capa->stage,
                            'created_at' => Carbon::now(),
                        ]);
                    }
    
                    foreach ($list as $u) {
                        $email = Helpers::getUserEmail($u->user_id);
                            if ($email !== null) {
                            try {
                                Mail::send(
                                    'mail.view-mail',
                                    ['data' => $capa, 'site' => "RCA", 'history' => "More Info Required", 'process' => 'Root Cause Analysis', 'comment' => $request->comments, 'user' => Auth::user()->name],
                                    function ($message) use ($email, $capa) {
                                        $message->to($email)
                                        ->subject("Medicef Notification: Root Cause Analysis, Record #" . str_pad($capa->record, 4, '0', STR_PAD_LEFT) . " - Activity: More Info Required Performed");
                                    }
                                );
                            } catch(\Exception $e) {
                                info('Error sending mail', [$e]);
                            }
                        }
                    }

                $capa->update();

                toastr()->success('Document Sent');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }


    public static function RootActivityPdf($id){

        $data = RootCauseAnalysis::find($id);
        if (!empty ($data)) {

            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();

            $pdf = PDF::loadview('frontend.root-cause-analysis.root_activity_pdf', compact('data'))
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
                File::makeDirectory($directoryPath, 0755, true, true);
            }  
    
            $pdf->save($filePath);
            return $pdf->stream('Root Cause Analysis' . $id . '.pdf');
        }
    }



    public function rootAuditTrial($id)
    {
        $audit = RootAuditTrial::where('root_id', $id)->orderByDESC('id')->paginate(5);
        $today = Carbon::now()->format('d-m-y');
        $document = RootCauseAnalysis::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');

        return view("frontend.root-cause-analysis.new_root_AuditTrail", compact('audit', 'document', 'today'));
    }

    public function auditDetailsroot($id)
    {

        $detail = RootAuditTrial::find($id);

        $detail_data = RootAuditTrial::where('activity_type', $detail->activity_type)->where('root_id', $detail->root_id)->latest()->get();

        $doc = RootCauseAnalysis::where('id', $detail->root_id)->first();

        $doc->origiator_name = User::find($doc->initiator_id);
        return view("frontend.root-cause-analysis.root-audit-trial-inner", compact('detail', 'doc', 'detail_data'));
    }

    public static function singleReport($id)
    {    
        $data = RootCauseAnalysis::find($id);
        if (!empty($data)) {
            $teamData = explode(',', $data->investigation_team);
            $users = User::whereIn('id', $teamData)->pluck('name');
            $userNames = $users->implode(', ');

            $data->originator_id = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.root-cause-analysis.singleReport', compact('data','userNames'))
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
            return $pdf->stream('Root-cause' . $id . '.pdf');
        }
    }

    public function singleReportShow($id)
    {
        $data = ActionItem::find($id);
        return view('frontend.root-cause-analysis.rca_showpdf', compact('id', 'data'));
    }
    public function child_r_c_a(Request $request, $id)
    {
        $parent_id = $id;
        $parent_initiator_id = RootCauseAnalysis::where('id', $id)->value('initiator_id');
        $parent_type = "Action-Item";
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $parent_record = $record_number;
        $currentDate = Carbon::now();
        $parent_intiation_date = $currentDate;
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('d-M-Y');
        $old_record = RootCauseAnalysis::select('id', 'division_id', 'record')->get();
        $record=$record_number;
        return view('frontend.action-item.action-item', compact('parent_intiation_date','parent_initiator_id','parent_record', 'record', 'due_date', 'parent_id', 'parent_type','old_record'));
    }
      public function RCAChildRoot(Request $request ,$id)
    {
        $cc = RootCauseAnalysis::find($id);
               $cft = [];
               $parent_id = $id;
               $parent_type = "Capa";
               $old_record = Capa::select('id', 'division_id', 'record')->get();
               $record_number = ((RecordNumber::first()->value('counter')) + 1);
               $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
               $parent_record =  ((RecordNumber::first()->value('counter')) + 1);
               $parent_record = str_pad($parent_record, 4, '0', STR_PAD_LEFT);
               $currentDate = Carbon::now();
               $parent_intiation_date = Capa::where('id', $id)->value('intiation_date');
               $parent_initiator_id = $id;


               $formattedDate = $currentDate->addDays(30);
               $due_date = $formattedDate->format('d-M-Y');
               $oocOpen = OpenStage::find(1);
               if (!empty($oocOpen->cft)) $cft = explode(',', $oocOpen->cft);


               if ($request->revision == "capa-child") {
                $cc->originator = User::where('id', $cc->initiator_id)->value('name');
                $record = $record_number;
                $old_records = $old_record;
                return view('frontend.forms.capa', compact('record_number', 'due_date', 'parent_id', 'parent_type', 'old_records', 'cft'));
                }

               if ($request->revision == "Action-Item") {
                $record = $record_number;
                $old_record = ActionItem::select('id', 'division_id', 'record')->get();

                $expectedParenRecord = Helpers::getDivisionName(session()->get('division')) . "/RCA/" . date('Y') . "/" . $cc->record . "";

                   $cc->originator = User::where('id', $cc->initiator_id)->value('name');
                   return view('frontend.action-item.action-item', compact('record', 'due_date', 'parent_id', 'parent_type','parent_intiation_date','parent_record','parent_initiator_id', 'old_record', 'expectedParenRecord'));
               }



    }

    public static function auditReport($id)
    {
        $doc = RootCauseAnalysis::find($id);
        if (!empty($doc)) {
            $doc->originator_id = User::where('id', $doc->initiator_id)->value('name');
            $data = RootAuditTrial::where('root_id', $id)->get();
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.root-cause-analysis.auditReport', compact('data', 'doc'))
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
            return $pdf->stream('Root-Audit' . $id . '.pdf');
        }
    }


        public static function familyReport($id){

            $data = RootCauseAnalysis::find($id);

            if (!empty($data)) {
                $data->originator_id = User::where('id', $data->initiator_id)->value('name');
                $pdf = App::make('dompdf.wrapper');
                $time = Carbon::now();

                $capa_teamIdsArray = explode(',', $data->capa_team);
                $capa_teamNames = User::whereIn('id', $capa_teamIdsArray)->pluck('name')->toArray();
                $capa_teamNamesString = implode(', ', $capa_teamNames);

                $ActionItem =  ActionItem::where('parent_id', $id)->get();

                $capa =  Capa::where('parent_id', $id)->get();

                // $capa->Product_Details = CapaGrid::where('capa_id', $id)->where('type', "Product_Details")->first();
                // $capa->Instruments_Details = CapaGrid::where('capa_id', $id)->where('type', "Instruments_Details")->first();
                // $capa->Material_Details = CapaGrid::where('capa_id', $id)->where('type', "Material_Details")->first();





                $pdf = App::make('dompdf.wrapper');
                $time = Carbon::now();
                $pdf = PDF::loadview('frontend.root-cause-analysis.root_family_report', compact('data','ActionItem','capa'))
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

 // CSV Export Function for RCA Log
 public function exportCsv(Request $request)
 {
    $query = RootCauseAnalysis::query();

    if ($request->departmentrca) {
        $query->where('initiator_Group', $request->departmentrca);
    }

    if ($request->division_rca) {
        $query->where('division_id', $request->division_rca);
    }

    if ($request->date_fromrca) {
        $dateFrom = Carbon::parse($request->date_fromrca)->startOfDay();
        $query->whereDate('created_at', '>=', $dateFrom);
    }

    if ($request->date_torca) {
        $dateTo = Carbon::parse($request->date_torca)->endOfDay();
        $query->whereDate('created_at', '<=', $dateTo);
    }

    // Apply Sorting if Specified
    if ($request->sort_column && $request->sort_order) {
        $query->orderBy($request->sort_column, $request->sort_order);
    }

    $rootcause = $query->get();

     $fileName = 'rca_log_report.csv';
     $headers = [
         "Content-Type" => "text/csv",
         "Content-Disposition" => "attachment; filename=\"$fileName\"",
     ];

     $columns = [
         'Sr. No.', 'RCA No.', 'Department', 'Division', 'Details',
         'Date Created', 'Assigned To', 'Status'
     ];

     $callback = function () use ($rootcause, $columns) {
         $file = fopen('php://output', 'w');
         fputcsv($file, $columns);

         if ($rootcause->isEmpty()) {
             fputcsv($file, ['No records found']);
         } else {
             foreach ($rootcause as $index => $row) {
                 $data = [
                     $index + 1, // Sr. No.
                     $row->rca_no ?? 'Not Applicable',
                     $row->initiator_Group ?? 'Not Applicable',
                     $row->division_id ?? 'Not Applicable',
                     $row->details ?? 'Not Applicable',
                     $row->created_at ? Carbon::parse($row->created_at)->format('d-M-Y') : 'Not Applicable',
                     $row->assigned_to ?? 'Not Applicable',
                     $row->status ?? 'Not Applicable'
                 ];
                 fputcsv($file, $data);
             }
         }

         fclose($file);
     };

     return response()->stream($callback, 200, $headers);
 }

 // Excel Export Function for RCA Log
 public function exportExcel(Request $request)
 {
 $query = RootCauseAnalysis::query();

        if ($request->departmentrca) {
            $query->where('initiator_Group', $request->departmentrca);
        }

        if ($request->division_rca) {
            $query->where('division_id', $request->division_rca);
        }

        if ($request->date_fromrca) {
            $dateFrom = Carbon::parse($request->date_fromrca)->startOfDay();
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($request->date_torca) {
            $dateTo = Carbon::parse($request->date_torca)->endOfDay();
            $query->whereDate('created_at', '<=', $dateTo);
        }

        // Apply Sorting if Specified
        if ($request->sort_column && $request->sort_order) {
            $query->orderBy($request->sort_column, $request->sort_order);
        }

        $rootcause = $query->get();
        
     $fileName = "rca_log_report.xls";
     $headers = [
         "Content-Type" => "application/vnd.ms-excel",
         "Content-Disposition" => "attachment; filename=\"$fileName\"",
     ];

     $columns = [
         'Sr. No.', 'RCA No.', 'Department', 'Division', 'Details',
         'Date Created', 'Assigned To', 'Status'
     ];

     $callback = function () use ($rootcause, $columns) {
         echo '<table border="1">';
         echo '<tr style="font-weight: bold; background-color: #1F4E79; color: #FFFFFF;">';
         foreach ($columns as $column) {
             echo "<th style='padding: 5px;'>" . htmlspecialchars($column) . "</th>";
         }
         echo '</tr>';

         if ($rootcause->isEmpty()) {
             echo '<tr>';
             echo "<td colspan='" . count($columns) . "' style='text-align: center;'>No records found</td>";
             echo '</tr>';
         } else {
             foreach ($rootcause as $index => $row) {
                 echo '<tr>';
                 echo "<td style='padding: 5px;'>" . ($index + 1) . "</td>";
                 echo "<td style='padding: 5px;'>" . htmlspecialchars($row->rca_no ?? 'Not Applicable') . "</td>";
                 echo "<td style='padding: 5px;'>" . htmlspecialchars($row->initiator_Group ?? 'Not Applicable') . "</td>";
                 echo "<td style='padding: 5px;'>" . htmlspecialchars($row->division_id ?? 'Not Applicable') . "</td>";
                 echo "<td style='padding: 5px;'>" . htmlspecialchars($row->details ?? 'Not Applicable') . "</td>";
                 echo "<td style='padding: 5px;'>" . ($row->created_at ? Carbon::parse($row->created_at)->format('d-M-Y') : 'Not Applicable') . "</td>";
                 echo "<td style='padding: 5px;'>" . htmlspecialchars($row->assigned_to ?? 'Not Applicable') . "</td>";
                 echo "<td style='padding: 5px;'>" . htmlspecialchars($row->status ?? 'Not Applicable') . "</td>";
                 echo '</tr>';
             }
         }

         echo '</table>';
     };

     return response()->stream($callback, 200, $headers);
 }


}
