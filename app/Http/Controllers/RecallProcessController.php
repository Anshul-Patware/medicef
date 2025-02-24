<?php

namespace App\Http\Controllers;

use App\Models\RecallGrid;
use App\Models\RecallProcecss;
use App\Models\RecallProcessAudit;
use Illuminate\Http\Request;
use App\Models\RecordNumber;
use App\Models\RoleGroup;
use App\Models\User;
use Carbon\Carbon;
use Helpers;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PDF;
use Illuminate\Support\Facades\File;

class RecallProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        // dd($record_number);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        return view('frontend.recall_process.recall_process_index', compact('record_number'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        if (!$request->short_description) {
            toastr()->error("Short description is required");
            return redirect()->back()->withInput();
        }
        $equipment = new RecallProcecss();
        $equipment->form_type = "Recall Process";
        // $equipment->record = ((RecordNumber::first()->value('counter')) + 1);
        $equipment->record = (DB::table('record_numbers')->value('counter') + 1);

        $equipment->initiator_id = Auth::user()->id;
        $equipment->division_id = $request->division_id;
        $equipment->division_code = $request->division_code;
        $equipment->intiation_date = $request->intiation_date;

        // $equipment->form_type = $request->form_type;
        $equipment->record_number = $request->record_number;
        $equipment->parent_id = $request->parent_id;
        $equipment->parent_type = $request->parent_type;
        $equipment->assign_to = $request->assign_to;
        $equipment->due_date = $request->due_date;
        $equipment->short_desc = $request->short_description;
        $equipment->depart_group = $request->depart_group;
        $equipment->depart_group_code = $request->depart_group_code;
        $equipment->batch_lot_no = $request->batch_lot_no;
        $equipment->recall_classifi = $request->classification;
        $equipment->recall_init_date = $request->init_date;
        $equipment->reason_for_recall = $request->rea_for_recall;
        $equipment->recall_scope = $request->recall_scope;

        $equipment->status = 'Opened';
        $equipment->stage = 1;
      
        $files = [];
        if (!empty($request->recall_attach)) {            
            if ($request->hasfile('recall_attach')) {                
                foreach ($request->file('recall_attach') as $file) {
                    $name = $request->name . 'recall_attach-' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;                    

                    // $file_name = $file->getClientOriginalName();
                    // $attach_names[] = $file_name;

                }
            }
        }
        $equipment->recall_attach = json_encode($files);
        // dd($equipment->recall_attach);
        // dd($files);

        $equipment->save();

        $data3 = new RecallGrid();
        $data3->recallprocess_id = $equipment->id;
        $data3->type = "Equipment_Details";
        if (!empty($request->equipment)) {
            $data3->equipment_name = serialize($request->equipment);
        }
        if (!empty($request->equipment_instruments)) {
            $data3->equipment_id= serialize($request->equipment_instruments);
        }
        if(!empty($request->equipment_remark)){
            $data3->equipment_remark = serialize($request->equipment_remark);
        }
        if (!empty($request->equipment_comments)) {
            $data3->equipment_comments = serialize($request->equipment_comments);
        }
        $data3->save();

        if (!empty($request->record_number)) {
            $history = new RecallProcessAudit();
            $history->recallprocess_id = $equipment->id;
            $history->activity_type = 'Record Number';
            $history->previous = "Null";
            $history->current = $request->record_number;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->depart_group)) {
            $history = new RecallProcessAudit();
            $history->recallprocess_id = $equipment->id;
            $history->activity_type = 'Department Group';
            $history->previous = "Null";
            $history->current = $request->depart_group;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->depart_group_code)) {
            $history = new RecallProcessAudit();
            $history->recallprocess_id = $equipment->id;
            $history->activity_type = 'Department Group Code';
            $history->previous = "Null";
            $history->current = $request->depart_group_code;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->site_location)) {
            $history = new RecallProcessAudit();
            $history->recallprocess_id = $equipment->id;
            $history->activity_type = 'Site/Location Code';
            $history->previous = "Null";
            $history->current = $request->site_location;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        // for initiator
        if (!empty($request->division_code)) {
            $history = new RecallProcessAudit();
            $history->recallprocess_id = $equipment->id;
            $history->activity_type = 'Initiator';
            $history->previous = "Null";
            $history->current = $request->division_code;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->originator_id)) {
            $history = new RecallProcessAudit();
            $history->recallprocess_id = $equipment->id;
            $history->activity_type = 'Initiator';
            $history->previous = "Null";
            $history->current = $request->originator_id;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->intiation_date)) {
            $history = new RecallProcessAudit();
            $history->recallprocess_id = $equipment->id;
            $history->activity_type = 'Date of Initiation';
            $history->previous = "Null";
            $history->current =Helpers::getdateFormat($request->intiation_date);
            // $history->current = $request->intiation_date;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->assign_to)) {
            $history = new RecallProcessAudit();
            $history->recallprocess_id = $equipment->id;
            $history->activity_type = 'Assign to';
            $history->previous = "Null";
            $history->current = $request->assign_to;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->due_date)) {
            $history = new RecallProcessAudit();
            $history->recallprocess_id = $equipment->id;
            $history->activity_type = 'Due Date';
            $history->previous = "Null";
            $history->current =Helpers::getdateFormat($request->due_date);
            // $history->current = $request->due_date;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->short_description)) {
            $history = new RecallProcessAudit();
            $history->recallprocess_id = $equipment->id;
            $history->activity_type = 'Short Description';
            $history->previous = "Null";
            $history->current = $request->short_description;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->batch_lot_no)) {
            $history = new RecallProcessAudit();
            $history->recallprocess_id = $equipment->id;
            $history->activity_type = 'Batch/Lot Number';
            $history->previous = "Null";
            $history->current = $request->batch_lot_no;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->classification)) {
            $history = new RecallProcessAudit();
            $history->recallprocess_id = $equipment->id;
            $history->activity_type = 'Recall Classification';
            $history->previous = "Null";
            $history->current = $request->classification;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->init_date)) {
            $history = new RecallProcessAudit();
            $history->recallprocess_id = $equipment->id;
            $history->activity_type = 'Recall Initiation Date ';
            $history->previous = "Null";
            $history->current =Helpers::getdateFormat($request->init_date);
            // $history->current = $request->init_date;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->rea_for_recall)) {
            $history = new RecallProcessAudit();
            $history->recallprocess_id = $equipment->id;
            $history->activity_type = 'Reason for Recall';
            $history->previous = "Null";
            $history->current = $request->rea_for_recall;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }


        if (!empty($request->recall_scope)) {
            $history = new RecallProcessAudit();
            $history->recallprocess_id = $equipment->id;
            $history->activity_type = 'Recall Scope';
            $history->previous = "Null";
            $history->current = $request->recall_scope;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->recall_attach)) {
            $history = new RecallProcessAudit();
            $history->recallprocess_id = $equipment->id;
            $history->activity_type = 'Attachment';
            $history->previous = "Null";
            $history->current = implode(', ',$files);
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();

        toastr()->success("Record is Create Successfully");
        return redirect(url('rcms/qms-dashboard'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = RecallProcecss::find($id);
        $equipment  = RecallProcecss::find($id);

        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $equipment->record = str_pad($equipment->record, 4, '0', STR_PAD_LEFT);
        $equipment->assign_to_name = User::where('id', $equipment->assign_id)->value('name');
        $equipment->initiator_name = User::where('id', $equipment->initiator_id)->value('name');
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        $data3 = RecallGrid::where('recallprocess_id', $id)->where('type', "Equipment_Details")->first();
        return view('frontend.recall_process.recall_view', compact('data', 'equipment', 'record_number','data3'));
        // return view('frontend.recall_process.recall_view1', compact('data', 'equipment', 'record_number',));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // return view('frontend.recall_process.recall_view');
        // return "something something!!!";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $lastDocument = RecallProcecss::find($id);
        $equipment = RecallProcecss::find($id);

        $equipment->assign_to = $request->assign_to;        
        $equipment->due_date =Helpers::getdateFormat($request->due_date);
        $equipment->short_desc = $request->short_description;
        $equipment->depart_group = $request->depart_group;
        $equipment->depart_group_code = $request->depart_group_code;
        $equipment->batch_lot_no = $request->batch_lot_no;
        $equipment->recall_classifi = $request->classification;
        $equipment->recall_init_date = $request->init_date;
        // $equipment->recall_init_date =Helpers::getdateFormat($request->init_date);
        $equipment->reason_for_recall = $request->rea_for_recall;
        $equipment->recall_scope = $request->recall_scope;
        $equipment->short_desc = $request->short_description;
        // $equipment->recall_attach = $request->recall_attach;
        if (!empty($request->recall_attach)) {            
            $files = [];
            if ($request->hasfile('recall_attach')) {                
                foreach ($request->file('recall_attach') as $file) {
                    $name = $request->name . 'recall_attach-' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;                    
                }
            }
            $equipment->recall_attach = json_encode($files);
        }
        $equipment->save();


        if ($lastDocument->short_desc != $equipment->short_desc) {
            $history = new RecallProcessAudit();
            $history->recallprocess_id = $id;
            $history->activity_type = 'Short Description';
            $history->previous = $lastDocument->short_desc;
            $history->current = $equipment->short_desc;
            // $history->comment = $request->short_description_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDocument->recall_attach != $equipment->recall_attach) {
            $history = new RecallProcessAudit();
            $history->recallprocess_id = $id;
            $history->activity_type = 'Attachment';
            $history->previous = $lastDocument->recall_attach;
            $history->current = $equipment->recall_attach;
            // $history->comment = $request->short_description_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDocument->assign_to != $equipment->assign_to) {
            $history = new RecallProcessAudit();
            $history->recallprocess_id = $id;
            $history->activity_type = 'Assign to';
            $history->previous = $lastDocument->assign_to;
            $history->current = $equipment->assign_to;
            // $history->comment = $request->short_description_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDocument->depart_group != $equipment->depart_group) {
            $history = new RecallProcessAudit();
            $history->recallprocess_id = $id;
            $history->activity_type = 'Department Group';
            $history->previous = $lastDocument->depart_group;
            $history->current = $equipment->depart_group;
            // $history->comment = $request->short_description_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDocument->depart_group_code != $equipment->depart_group_code) {
            $history = new RecallProcessAudit();
            $history->recallprocess_id = $id;
            $history->activity_type = 'Department Group Code';
            $history->previous = $lastDocument->depart_group_code;
            $history->current = $equipment->depart_group_code;
            // $history->comment = $request->depart_group_code;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDocument->batch_lot_no != $equipment->batch_lot_no) {
            $history = new RecallProcessAudit();
            $history->recallprocess_id = $id;
            $history->activity_type = 'Batch/Lot Number';
            $history->previous = $lastDocument->batch_lot_no;
            $history->current = $equipment->batch_lot_no;
            // $history->comment = $request->depart_group_code;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastDocument->recall_classifi != $equipment->recall_classifi) {
            $history = new RecallProcessAudit();
            $history->recallprocess_id = $id;
            $history->activity_type = 'Recall Classification';
            $history->previous = $lastDocument->recall_classifi;
            $history->current = $equipment->recall_classifi;
            // $history->comment = $request->depart_group_code;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDocument->recall_init_date != $equipment->recall_init_date) {
            $history = new RecallProcessAudit();
            $history->recallprocess_id = $id;
            $history->activity_type = 'Recall Initiation Date';
            $history->previous = Helpers::getdateFormat($lastDocument->recall_init_date);
            $history->current = Helpers::getdateFormat($equipment->recall_init_date);
            // $history->comment = $request->depart_group_code;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDocument->reason_for_recall != $equipment->reason_for_recallr) {
            $history = new RecallProcessAudit();
            $history->recallprocess_id = $id;
            $history->activity_type = 'Reason for Recall ';
            $history->previous = $lastDocument->reason_for_recall;
            $history->current = $equipment->reason_for_recall;
            // $history->comment = $request->depart_group_code;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDocument->recall_scope != $equipment->recall_scope) {
            $history = new RecallProcessAudit();
            $history->recallprocess_id = $id;
            $history->activity_type = 'Recall Scope';
            $history->previous = $lastDocument->recall_scope;
            $history->current = $equipment->recall_scope;
            // $history->comment = $request->depart_group_code;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }


        toastr()->success('Record is update successfully');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function RecallProcessStateChange(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $equipment = RecallProcecss::find($id);
            $lastDocument = RecallProcecss::find($id);

            if ($equipment->stage == 1) {
                $equipment->stage = "2";
                $equipment->status = "Supervisor Review";
                $equipment->submit_by = Auth::user()->name;
                $equipment->submit_on = Carbon::now()->format('d-M-Y');
                $equipment->submit_comments = $request->comment;


                $history = new RecallProcessAudit();
                $history->recallprocess_id = $id;
                $history->activity_type = 'Submit By ,Submit On';
                if (is_null($lastDocument->submit_by) || $lastDocument->submit_by === "") {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->submit_by . ',' . $lastDocument->submit_on;
                }
                $history->current = $equipment->submit_by . ' , ' . $equipment->submit_on;

                if (is_null($lastDocument->submit_by) || $lastDocument->submit_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }

                $history->comment = $request->comment;
                $history->action = 'submit';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Supervisor Review";
                $history->change_from = $lastDocument->status;
                $history->save();

                $equipment->update();
                toastr()->success('Document sent');
                return back();
            }

            if ($equipment->stage == 2) {
                $equipment->stage = "3";
                $equipment->status = "Work in Progress";
                $equipment->Supervisor_Approval_by = Auth::user()->name;
                $equipment->Supervisor_Approval_on = Carbon::now()->format('d-M-Y');
                $equipment->Supervisor_Approval_comment = $request->comment;
                $equipment->update();

                $history = new RecallProcessAudit();
                $history->recallprocess_id = $id;
                $history->activity_type = 'Supervisor Approval By ,Supervisor Approval On';
                if (is_null($lastDocument->Supervisor_Approval_by) || $lastDocument->Supervisor_Approval_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->Supervisor_Approval_by . ' , ' . $lastDocument->Supervisor_Approval_on;
                }
                $history->current = $equipment->Supervisor_Approval_by . ' , ' . $equipment->Supervisor_Approval_on;
                if (is_null($lastDocument->Supervisor_Approval_by) || $lastDocument->Supervisor_Approval_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = $request->comment;
                $history->action = 'Supervisor Approval';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Work in Progress";
                $history->change_from = $lastDocument->status;

                $history->save();
                $equipment->update();
                toastr()->success('Document sent');
                return back();
            }

            if ($equipment->stage == 3) {
                $equipment->stage = "4";
                $equipment->status = "Pending QA Approval";
                $equipment->Complete_by = Auth::user()->name;
                $equipment->Complete_on = Carbon::now()->format('d-M-Y');
                $equipment->Complete_comment = $request->comment;


                $history = new RecallProcessAudit();
                $history->recallprocess_id = $id;
                $history->activity_type = 'Complete By ,Complete On';
                if (is_null($lastDocument->Complete_by) || $lastDocument->Complete_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->Complete_by . ' , ' . $lastDocument->Complete_on;
                }
                $history->current = $equipment->Complete_by . ' , ' . $equipment->Complete_on;
                if (is_null($lastDocument->Complete_by) || $lastDocument->Complete_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = $request->comment;
                $history->action = 'Complete';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Pending QA Approval";
                $history->change_from = $lastDocument->status;

                $history->save();

                $equipment->update();
                toastr()->success('Document sent');
                return back();
            }

            if ($equipment->stage == 4) {
                $equipment->stage = "5";
                $equipment->status = "Pending QA Approval";
                $equipment->qa_approval_by = Auth::user()->name;
                $equipment->qa_approval_on = Carbon::now()->format('d-M-Y');
                $equipment->qa_approval_comment = $request->comment;


                $history = new RecallProcessAudit();
                $history->recallprocess_id = $id;
                $history->activity_type = 'QA Approval By ,QA Approval On';
                if (is_null($lastDocument->Complete_by) || $lastDocument->Complete_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->Complete_by . ' , ' . $lastDocument->Complete_on;
                }
                $history->current = $equipment->Complete_by . ' , ' . $equipment->Complete_on;
                if (is_null($lastDocument->Complete_by) || $lastDocument->Complete_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->previous = "";
                $history->current = $equipment->submit_by;
                $history->comment = $request->comment;
                $history->action = 'QA Approval';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Pending QA Approval";
                $history->change_from = $lastDocument->status;

                $history->save();

                $equipment->update();
                toastr()->success('Document sent');
                return back();
            }
        } else {
            toastr()->error('E-signature not match');
            return back();
        }
    }

    public function RecallProcessAuditTrail(Request $request, $id)
    {
        // return "Recall Process Audit Trail Page";
        $audit = RecallProcessAudit::where('recallprocess_id', $id)->orderByDESC('id')->paginate();
        $today = Carbon::now()->format('d-m-y');
        $document = RecallProcecss::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');
        $data = RecallProcecss::find($id);

        return view('frontend.recall_process.recall_process_audit', compact('audit', 'today', 'document', 'data'));
    }

    public function recall_process_audit_report($id)
    {


        $doc = RecallProcecss::find($id);
        if (!empty($doc)) {
            $doc->originator = User::where('id', $doc->initiator_id)->value('name');
            $data = RecallProcessAudit::where('recallprocess_id', $id)->get();
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $data = $data->sortBy('created_at');
            $pdf = PDF::loadview('frontend.recall_process.recall_process_audit_report_pdf', compact('data', 'doc'))
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
            return $pdf->stream('Recall-Audit' . $id . '.pdf');
        }
    }

    public function recall_process_single_report($id)
    {
        $data = RecallProcecss::find($id);

        if (!empty($data)) {
            // $data->Product_Details = CapaGrid::where('capa_id', $id)->where('type', "Product_Details")->first();
            // $data->Instruments_Details = CapaGrid::where('capa_id', $id)->where('type', "Instruments_Details")->first();
            // $data->Material_Details = CapaGrid::where('capa_id', $id)->where('type', "Material_Details")->first();
            // $data->originator = User::where('id', $data->initiator_id)->value('name');

            // $capa_teamIdsArray = explode(',', $data->capa_team);
            // $capa_teamNames = User::whereIn('id', $capa_teamIdsArray)->pluck('name')->toArray();
            // $capa_teamNamesString = implode(', ', $capa_teamNames);
            // $doc->originator = User::where('id', $doc->initiator_id)->value('name');
            $recall_audit = RecallProcessAudit::where('recallprocess_id', $id)->get();

            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.recall_process.recall_process_single_report_pdf', compact('data'))
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
}
