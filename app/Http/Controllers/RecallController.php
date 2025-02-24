<?php

namespace App\Http\Controllers;

use App\Models\Recall;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RecallController extends Controller
{
    public $unique1;
    protected $res;
    public function __construct()
    {
        $this->res = [
            'message' => '',
        ];
    }

    protected function setresponse($message = [])
    {
        $this->res['message'] = $message;
    }

    public function dashboard()
    {
        $all_data = DB::table('recalls')->get()->all();        
        return view('frontend.recall.recall_dashboard', compact('all_data'))->with('status', 'user created successfully');
    }


    public function index($id)
    {
        global $unique1;
        $unique1 = $id;
        // dd($unique1);
        return view('frontend.recall.recall_index', compact('unique1'));
    }

    public function store(Request $request, $id)
    {
        // Log::info($request->all());
        // Convert the date format from 'd-M-Y' to 'Y-m-d'

        // dd($request->all());

        $dateOfInit = Carbon::createFromFormat('d-M-Y', $request->input('d_o_ini'))->format('Y-m-d');

        $due_date = Carbon::createFromFormat('d-M-Y', $request->input('due_date'))->format('Y-m-d');

        // $recal_init_date = Carbon::createFromFormat('Y-M-D', $request->input('init_date'))->format('Y-m-d');
        // dd($recal_init_date);
        // $id = $request->input('record_no');        
        $multi_data = $request->input('row_data');
        Log::info('Raw Row Data: ' . print_r($multi_data, true));
        $jsonData = json_encode($multi_data);
        // Log::info('JSON Data: ' . $jsonData);
        // dd($jsonData);
        // Use updateOrCreate method
        $user = Recall::updateOrCreate(
            ['id' => $id],
            [
                'rec_no' => $request->input('record_no'),
                'date_of_init' => $dateOfInit,
                'loca_code' => $request->input('site_location'),
                'init' => $request->input('initi'),
                'date_of_init' => $dateOfInit,
                'assign_to' => $request->input('assi_to'),
                'due_date' => $due_date,
                'depart_group'  =>  $request->input('depart_group'),
                'depart_group_code' => $request->input('depart_group_code'),
                'short_desc' => $request->input('short_desc'),
                'batch_lot_no' => $request->input('batch_lot_no'),
                'recall_classifi' => $request->input('classification'),
                'recall_init_date' => $request->input('init_date'),
                'reason_for_recall' => $request->input('rea_for_recall'),
                'recall_scope' => $request->input('recall_scope'),

                // second form fields
                'produ_code' => $request->input('produ_code'),
                'acti_phar_ingre' => $request->input('acti_phar_ingre'),
                'manufac_name' => $request->input('manufac_name'),
                'expiry_data' => $request->input('expiry_data'),
                'add_group' => $request->input('add_group'),
                'add_group_detail' => $jsonData,                 
                'packaging_detail' => $request->input('packaging_detail'),
                'dosage_form' => $request->input('dosage_form'),
                'stora_condi' => $request->input('stora_condi'),
                'affected_lot_no' => $request->input('affected_lot_no'),
                'affected_manufacturing_date' => $request->input('affected_manufacturing_date'),
                'affected_expiry_date' => $request->input('affected_expiry_date'),
                'quantity_produced' => $request->input('quantity_produced'),
                'quantity_distri' => $request->input('quantity_distri'),
                'quantity_recall' => $request->input('quantity_recall'),
                'distribution_channel' => $request->input('distribution_channel'),
                'affected_batch_reason' => $request->input('affected_batch_reason'),
                'distributor_name' => $request->input('distributor_name'),
                'distributor_address' => $request->input('distributor_address'),
                'shipment_date' => $request->input('shipment_date'),
                'delivery_confirm' => $request->input('delivery_confirm'),
                'pharmacy_name' => $request->input('pharmacy_name'),
                'geograp_reason_of_distri' => $request->input('geograp_reason_of_distri'),
                'investi_id' => $request->input('investi_id'),
                'detaction_date' => $request->input('detaction_date'),
                'root_cause_desc' => $request->input('root_cause_desc'),
                'expiry_date' => $request->input('expiry_date'),
                'root_quantity_produced' => $request->input('root_quantity_produced'),
                'root_quantity_distri' => $request->input('root_quantity_distri'),
                'root_quantity_recall' => $request->input('root_quantity_recall'),
                'root_distri_channel' => $request->input('root_distri_channel'),
                'root_affected_batch_person' => $request->input('root_affected_batch_person'),

            ]
        ); 
        Log::info('Inserted User: ' . print_r($user, true));
        return redirect('recall_dash');
        // return redirect()->route('recall_update_id', $id);
    }

    public function update(Request $request)
    {
        $id = $request->query('id');  //
        // dd($id);
        // $all_data = DB::table('recalls')->get($id)->all();
        $data = Recall::where('id', $id)->firstOrFail();        
        $data12 = $data->add_group_detail; 
        // dd($data12);
        $json_data = json_decode($data12,true);
        // dd($json_data);
        // dd($all_data);
        return view('frontend.recall.recall_update', compact('data','json_data'));
    }

    public function update1(Request $request, $id)
    {
        // $id = $request->query('id');  //
        // dd($id);
        // $all_data = DB::table('recalls')->get($id)->all();
        $data = Recall::where('id', $id)->firstOrFail();
        // dd($all_data);
        
        // dd($all_data);
        return view('frontend.recall.recall_update', compact('data'));
    }
}
