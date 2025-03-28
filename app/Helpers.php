<?php
// namespace App;
use App\Models\ActionItem;
use App\Models\Division;
use App\Models\QMSDivision;
use App\Models\User;
use App\Models\OOS_micro;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Mistralys\Diff\Diff;

use Jfcherng\Diff\Differ;
use Jfcherng\Diff\DiffHelper;
use Jfcherng\Diff\Factory\RendererFactory;
use Jfcherng\Diff\Renderer\RendererConstant;

use App\Http\Controllers\ExtensionNewController;
use App\Models\extension_new;
use App\Models\QMSProcess;
use App\Models\Deviation;
use App\Models\LabIncident;

class Helpers
{
    public static function getArrayKey(array $array, $key)
    {
        return $array && is_array($array) && array_key_exists($key, $array) ? $array[$key] : '';
    }

    public static function getSupplierAuditorDepartmentList($division = null) {
        if (!$division) {
            return $SupplierAuditorDepartmentList = DB::table('user_roles')->where(['q_m_s_roles_id' => '37'])->select(['user_id', DB::raw('MAX(q_m_s_divisions_id) as q_m_s_divisions_id')])->groupBy('user_id')->get();
        } else {
            return DB::table('user_roles')->where(['q_m_s_roles_id' => '37', 'q_m_s_divisions_id' => $division])->select('user_id')->distinct()->get();
        }
    }
    public static function getAuditeeDepartmentList($division = null) {
        if (!$division) {
            return $AuditeeDepartmentList = DB::table('user_roles')->where(['q_m_s_roles_id' => '39'])->select(['user_id', DB::raw('MAX(q_m_s_divisions_id) as q_m_s_divisions_id')])->groupBy('user_id')->get();
        } else {
            return DB::table('user_roles')->where(['q_m_s_roles_id' => '39', 'q_m_s_divisions_id' => $division])->select('user_id')->distinct()->get();
        }
    }
    public static function getAuditeesEmail($id)
    {
        $email = null;
        try {
            $email  = User::find($id)->email;            
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve email for user ID ' . $id . ': ' . $e->getMessage());
        }
        return $email;
    }
    public static function getAuditManagerDepartmentList($division = null) {
        if (!$division) {
            return $AuditManagerDepartmentList = DB::table('user_roles')->where(['q_m_s_roles_id' => '13'])->select(['user_id', DB::raw('MAX(q_m_s_divisions_id) as q_m_s_divisions_id')])->groupBy('user_id')->get();
        } else {
            return DB::table('user_roles')->where(['q_m_s_roles_id' => '13', 'q_m_s_divisions_id' => $division])->select('user_id')->distinct()->get();
        }
    }
    public static function getAuditManagerEmail($id)
    {
        $email = null;
        try {
            $email  = User::find($id)->email;            
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve email for user ID ' . $id . ': ' . $e->getMessage());
        }
        return $email;
    }

    public static function getSupplierAuditorEmail($id)
    {
        $email = null;
        try {
            $email  = User::find($id)->email;            
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve email for user ID ' . $id . ': ' . $e->getMessage());
        }
        return $email;
    }
    public static function getAuditeeEmail($id)
    {
        $email = null;
        try {
            $email  = User::find($id)->email;            
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve email for user ID ' . $id . ': ' . $e->getMessage());
        }
        return $email;
    }

    public static function getDefaultResponse()
    {
        $res = [
            'status' => 'ok',
            'message' => 'success',
            'body' => []
        ];

        return $res;
    }

    public static function getAllRelatedRecords()
    {
        $pre = [
            'DEV' => \App\Models\Deviation::class,
            'AP' => \App\Models\AuditProgram::class,
            'AI' => \App\Models\ActionItem::class,
            'Exte' => \App\Models\extension_new::class,
            'Obse' => \App\Models\Observation::class,
            'RCA' => \App\Models\RootCauseAnalysis::class,
            'RA' => \App\Models\RiskAssessment::class,
            'MR' => \App\Models\ManagementReview::class,
            'EA' => \App\Models\Auditee::class,
            'IA' => \App\Models\InternalAudit::class,
            'CAPA' => \App\Models\Capa::class,
            'CC' => \App\Models\CC::class,
            'ND' => \App\Models\Document::class,
            'Lab' => \App\Models\LabIncident::class,
            'EC' => \App\Models\EffectivenessCheck::class,
            'OOSChe' => \App\Models\OOS::class,
            'OOT' => \App\Models\OOT::class,
            'OOC' => \App\Models\OutOfCalibration::class,
            'MC' => \App\Models\MarketComplaint::class,
            'NC' => \App\Models\NonConformance::class,
            'Incident' => \App\Models\Incident::class,
            'FI' => \App\Models\FailureInvestigation::class,
            'ERRATA' => \App\Models\errata::class,
            'OOSMicr' => \App\Models\OOS_micro::class,
            // Add other models as necessary...
        ];

        // Create an empty collection to store the related records
        $relatedRecords = collect();

        // Loop through each model and get the records, adding the process name to each record
        foreach ($pre as $processName => $modelClass) {
            $records = $modelClass::all()->map(function ($record) use ($processName) {
                $record->process_name = $processName; // Attach the process name to each record
                return $record;
            });

            // Merge the records into the collection
            $relatedRecords = $relatedRecords->merge($records);
        }

        return $relatedRecords;
    }

    public static function getCqaDepartmentList($division = null) {
        if (!$division) {
            return $InitiatorUserList = DB::table('user_roles')->where(['q_m_s_roles_id' => '35'])->select(['user_id', DB::raw('MAX(q_m_s_divisions_id) as q_m_s_divisions_id')])->groupBy('user_id')->get();
        } else {
            return DB::table('user_roles')->where(['q_m_s_roles_id' => '35', 'q_m_s_divisions_id' => $division])->select('user_id')->distinct()->get();
        }
    }

    public static function getPurchaseDepartmentList($division = null) {
        if (!$division) {
            return $PurchaseDepartmentList = DB::table('user_roles')->where(['q_m_s_roles_id' => '34'])->select(['user_id', DB::raw('MAX(q_m_s_divisions_id) as q_m_s_divisions_id')])->groupBy('user_id')->get();
        } else {
            return DB::table('user_roles')->where(['q_m_s_roles_id' => '34', 'q_m_s_divisions_id' => $division])->select('user_id')->distinct()->get();
        }
    }

    public static function getFormulationDepartmentList($division = null) {
        if (!$division) {
            return $FormulationDepartmentList = DB::table('user_roles')->where(['q_m_s_roles_id' => '36'])->select(['user_id', DB::raw('MAX(q_m_s_divisions_id) as q_m_s_divisions_id')])->groupBy('user_id')->get();
        } else {
            return DB::table('user_roles')->where(['q_m_s_roles_id' => '36', 'q_m_s_divisions_id' => $division])->select('user_id')->distinct()->get();
        }
    }

    public static function getDueDate($days = 30, $formatDate = true)
    {
        try {

            $date = Carbon::now()->addDays($days);
            $formatted_date = $formatDate ? $date->format("d-F-Y") : $date->format('Y-m-d');
            return $formatted_date;

        } catch (\Exception $e) {
            return "01-Jan-1999";
        }
    }
    // public static function fz($date)
    // {
    //     $date = Carbon::parse($date);
    //     $formatted_date = $date->format("d-M-Y");
    //     return $formatted_date;
    // }
    public static function getdateFormat($date)
    {
        if(empty($date)) {
            return ''; // or any default value you prefer
        }
        // else{
        else{
            $date = Carbon::parse($date);
            $formatted_date = $date->format("d-M-Y");
            return $formatted_date;
        }

    }

    public static function getdateFormat1($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-M-Y H:i');
    }

    public static function isRevised($data)
    {
    {
        if($data  >= 8){
            return 'disabled';
        }else{
            return  '';
        }


    }}

    public static function isRiskAssessment($data)
    {   
        if($data == 0 || $data  >= 7){
            return 'disabled';
        }else{
            return  '';
        }
         
    }
    // public static function getHodUserList(){

    //     return $hodUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'4'])->get();
    // }
    // public static function getQAUserList(){

    //     return $QAUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'7'])->get();
    // }
    // public static function getInitiatorUserList(){


    //     return $InitiatorUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'3'])->get();
    // }
    // public static function getApproverUserList(){


    //     return $ApproverUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'1'])->get();
    // }
    // public static function getReviewerUserList(){


    //     return $ReviewerUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'2'])->get();
    // }
    // public static function getCFTUserList(){


    //     return $CFTUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'5'])->get();
    // }
    // public static function getTrainerUserList(){


    //     return $TrainerUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'6'])->get();
    // }
    // public static function getActionOwnerUserList(){


    //     return $ActionOwnerUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'8'])->get();
    // }
    // public static function getQAHeadUserList(){


    //     return $QAHeadUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'9'])->get();
    // }
    public static function getQCHeadUserList(){

        return $QCHeadUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'10'])->get();
    }
    // public static function getLeadAuditeeUserList(){


    //     return $LeadAuditeeUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'11'])->get();
    // }
    // public static function getLeadAuditorUserList(){


    //     return $LeadAuditorUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'12'])->get();
    // }
    // public static function getAuditManagerUserList(){


    //     return $AuditManagerUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'13'])->get();
    // }
    // public static function getSupervisorUserList(){


    //     return $SupervisorUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'14'])->get();
    // }
    // public static function getResponsibleUserList(){


    //     return $ResponsibleUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'15'])->get();
    // }
    // public static function getWorkGroupUserList(){


    //     return $WorkGroupUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'16'])->get();
    // }
    // public static function getViewUserList(){


    //     return $ViewUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'17'])->get();
    // }
    // public static function getFPUserList(){


    //     return $FPUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'18'])->get();
    // }

    public static function checkRoles($role)
    {

        $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id])->get();
        $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
        if(in_array($role, $userRoleIds)){
            return true;
        }else{
            return false;
        }
        // if (strpos(Auth::user()->role, $role) !== false) {
        //    return true;
        // }else{
        //     return false;
        // }
        // }
    }

    public static function checkTMSRoles($role)
    {

        $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id])->get();
        $userRoleIds = $userRoles->pluck('role_id')->toArray();
        if(in_array($role, $userRoleIds)){
            return true;
        }else{
            return false;
        }
        // if (strpos(Auth::user()->role, $role) !== false) {
        //    return true;
        // }else{
        //     return false;
        // }
    }


    public static function checkRoles_check_reviewers($document)
    {


        if ($document->reviewers) {
            $datauser = explode(',', $document->reviewers);
            for ($i = 0; $i < count($datauser); $i++) {
                if ($datauser[$i] == Auth::user()->id) {
                    return true;
                }
            }
        } else {
            return false;
        }
        }


    public static function checkRoles_check_approvers($document)
    {
        if ($document->approvers) {
            $datauser = explode(',', $document->approvers);
            for ($i = 0; $i < count($datauser); $i++) {
                if ($datauser[$i] == Auth::user()->id) {
                    if($document->stage >= 4){
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        } else {
            return false;
        }
    }


    public static function checkRoles_check_hods($document)
    {
        if ($document->hods) {
            $datauser = explode(',', $document->hods);
            for ($i = 0; $i < count($datauser); $i++) {
                if ($datauser[$i] == Auth::user()->id) {
                    if($document->stage >= 2){
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        }
        return false;
    }

    public static function checkUserRolesApprovers($data)
    {
        $user = User::find($data->id);
        return $user->userRoles()->where('q_m_s_roles_id', 1)->exists();
    }

    public static function checkUserRolesDrafter($data)
    {
        $user = User::find($data->id);
        return $user->userRoles()->where('q_m_s_roles_id', 40)->exists();
    }

    public static function checkUserRolesreviewer($data)
    {
        $user = User::find($data->id);
        return $user->userRoles()->where('q_m_s_roles_id', 2)->exists();
    }

    public static function checkUserRolestrainer($data)
    {
        $user = User::find($data->id);
        return $user->userRoles()->where('q_m_s_roles_id', 6)->exists();
    }

    public static function checkUserRolesassign_to($data)
    {
        if ($data->role) {
            $datauser = explode(',', $data->role);
            for ($i = 0; $i < count($datauser); $i++) {
                if ($datauser[$i] == 4) {
                    return true;
                }
            }
        } else {
            return false;
        }
    }

    public static function checkUserRolesMicrobiology_Person($data)
    {
        if ($data->role) {
            $datauser = explode(',', $data->role);
            for ($i = 0; $i < count($datauser); $i++) {
                if ($datauser[$i] == 5) {
                    return true;
                }
            }
        } else {
            return false;
        }
    }

    public static function divisionNameForQMS($id)
    {
        return QMSDivision::where('id', $id)->value('name');
    }

    public static function year($createdAt)
    {
        return Carbon::parse($createdAt)->format('y');
    }

    public static function getDivisionCode($id)
    {
        $code = '';

        switch ($id) {
            case 1:
                $code = 'CQA';
                break;
            case 2:
                $code = 'P1';
                break;
            case 3:
                $code = 'P2';
                break;
            case 4:
                $code = 'P3';
                break;
            case 5:
                $code = 'P4';
                break;
            case 6:
                $code = 'C1';
                break;
            default:
                break;
        }

        return $code;
    }

    public static function getDivisionName($id)
    {
        $name = DB::table('q_m_s_divisions')->where('id', $id)->where('status', 1)->value('name');
        return $name;
    }
    public static function recordFormat($number)
    {
        return   str_pad($number, 4, '0', STR_PAD_LEFT);
    }
    public static function getInitiatorName($id)
    {
        return   User::where('id',$id)->value('name');
    }
    public static function record($id)
    {
        return   str_pad($id, 5, '0', STR_PAD_LEFT);
    }

    public static function getApproverUserList(){

        return $ApproverUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'1'])->get();
    }
    public static function getReviewerUserList(){

        return $ReviewerUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'2'])->get();
    }
   
    public static function getTrainerUserList(){

        return $TrainerUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'6'])->get();
    }


    /******** Updated User List *********/
    public static function getHodUserList($division = null){
        if (!$division) {
            return $hodUserList = DB::table('user_roles')->where(['q_m_s_roles_id' => '4'])->select(['user_id', DB::raw('MAX(q_m_s_divisions_id) as q_m_s_divisions_id')])->groupBy('user_id')->get();
        } else {
            return DB::table('user_roles')->where(['q_m_s_roles_id' => '4', 'q_m_s_divisions_id' => $division])->select('user_id')->distinct()->get();
        }
    }

    public static function getQAUserList($division = null){
        if (!$division) {
            return $QAUserList = DB::table('user_roles')->where(['q_m_s_roles_id' => '7'])->select(['user_id', DB::raw('MAX(q_m_s_divisions_id) as q_m_s_divisions_id')])->groupBy('user_id')->get();
        } else {
            return DB::table('user_roles')->where(['q_m_s_roles_id' => '7', 'q_m_s_divisions_id' => $division])->select('user_id')->distinct()->get();
        }
    }

    public static function getCftUserList($division = null){
        if (!$division) {
            return DB::table('user_roles')->where(['q_m_s_roles_id' => '5'])->select(['user_id', DB::raw('MAX(q_m_s_divisions_id) as q_m_s_divisions_id')])->groupBy('user_id')->get();
        } else {
            return DB::table('user_roles')->where(['q_m_s_roles_id' => '5', 'q_m_s_divisions_id' => $division])->select('user_id')->distinct()->get();
        }
    }

    public static function getRAUsersList($division = null){
        if (!$division) {
            return DB::table('user_roles')->where(['q_m_s_roles_id' => '50'])->select(['user_id', DB::raw('MAX(q_m_s_divisions_id) as q_m_s_divisions_id')])->groupBy('user_id')->get();
        } else {
            return DB::table('user_roles')->where(['q_m_s_roles_id' => '50', 'q_m_s_divisions_id' => $division])->select('user_id')->distinct()->get();
        }
    }

    public static function getInitiatorUserList($division = null){
        if (!$division) {
            return DB::table('user_roles')->where(['q_m_s_roles_id' => '3'])->select(['user_id', DB::raw('MAX(q_m_s_divisions_id) as q_m_s_divisions_id')])->groupBy('user_id')->get();
        } else {
            return DB::table('user_roles')->where(['q_m_s_roles_id' => '3', 'q_m_s_divisions_id' => $division])->select('user_id')->distinct()->get();
        }
    }

    public static function getQAHeadUserList($division = null){
        if (!$division) {
            return DB::table('user_roles')->where(['q_m_s_roles_id' => '42'])->select(['user_id', DB::raw('MAX(q_m_s_divisions_id) as q_m_s_divisions_id')])->groupBy('user_id')->get();
        } else {
            return DB::table('user_roles')->where(['q_m_s_roles_id' => '42', 'q_m_s_divisions_id' => $division])->select('user_id')->distinct()->get();
        }
    }

    public static function getLeadAuditor($division = null){
        if (!$division) {
            return DB::table('user_roles')->where(['q_m_s_roles_id' => '12'])->select(['user_id', DB::raw('MAX(q_m_s_divisions_id) as q_m_s_divisions_id')])->groupBy('user_id')->get();
        } else {
            return DB::table('user_roles')->where(['q_m_s_roles_id' => '12', 'q_m_s_divisions_id' => $division])->select('user_id')->distinct()->get();
        }
    }


    public static function getAuditee($division = null){
        if (!$division) {
            return DB::table('user_roles')->where(['q_m_s_roles_id' => '72'])->select(['user_id', DB::raw('MAX(q_m_s_divisions_id) as q_m_s_divisions_id')])->groupBy('user_id')->get();
        } else {
            return DB::table('user_roles')->where(['q_m_s_roles_id' => '72', 'q_m_s_divisions_id' => $division])->select('user_id')->distinct()->get();
        }
    }
    public static function getAuditManager($division = null){
        if (!$division) {
            return DB::table('user_roles')->where(['q_m_s_roles_id' => '13'])->select(['user_id', DB::raw('MAX(q_m_s_divisions_id) as q_m_s_divisions_id')])->groupBy('user_id')->get();
        } else {
            return DB::table('user_roles')->where(['q_m_s_roles_id' => '13', 'q_m_s_divisions_id' => $division])->select('user_id')->distinct()->get();
        }
    }

    public static function getLineManagerUserList($division = null){
        if (!$division) {
            return DB::table('user_roles')->where(['q_m_s_roles_id' => '76'])->select(['user_id', DB::raw('MAX(q_m_s_divisions_id) as q_m_s_divisions_id')])->groupBy('user_id')->get();
        } else {
            return DB::table('user_roles')->where(['q_m_s_roles_id' => '76', 'q_m_s_divisions_id' => $division])->select('user_id')->distinct()->get();
        }
    }

    public static function getLeadInvestigatorUserList($division = null){
        if (!$division) {
            return DB::table('user_roles')->where(['q_m_s_roles_id' => '77'])->select(['user_id', DB::raw('MAX(q_m_s_divisions_id) as q_m_s_divisions_id')])->groupBy('user_id')->get();
        } else {
            return DB::table('user_roles')->where(['q_m_s_roles_id' => '77', 'q_m_s_divisions_id' => $division])->select('user_id')->distinct()->get();
        }
    }

    public static function getSafetyOfficerUserList($division = null){
        if (!$division) {
            return DB::table('user_roles')->where(['q_m_s_roles_id' => '78'])->select(['user_id', DB::raw('MAX(q_m_s_divisions_id) as q_m_s_divisions_id')])->groupBy('user_id')->get();
        } else {
            return DB::table('user_roles')->where(['q_m_s_roles_id' => '78', 'q_m_s_divisions_id' => $division])->select('user_id')->distinct()->get();
        }
    }

    public static function getUserEmail($id)
    {
        $email = null;
        try {
            $email  = User::find($id)->email;            
        } catch (\Exception $e) {
            \Log::error('Failed to retrieve email for user ID ' . $id . ': ' . $e->getMessage());
        }
        return $email;
    }

    static function getFullDepartmentName($code)
    {
        $full_department_name = '';

        switch ($code) {
            case 'CQA':
                $full_department_name = "Corporate Quality Assurance";
                break;
            case 'QA':
                $full_department_name = "Quality Assurance";
                break;
            case 'QC':
                $full_department_name = "Quality Control";
                break;
            case 'QM':
                $full_department_name = "Quality Control (Microbiology department)";
                break;
            case 'PG':
                $full_department_name = "Production General";
                break;
            case 'PL':
                $full_department_name = "Production Liquid Orals";
                break;
            case 'PT':
                $full_department_name = "Production Tablet and Powder";
                break;
            case 'PE':
                $full_department_name = "Production External (Ointment, Gels, Creams and Liquid)";
                break;
            case 'PC':
                $full_department_name = "Production Capsules";
                break;
            case 'PI':
                $full_department_name = "Production Injectable";
                break;
            case 'EN':
                $full_department_name = "Engineering";
                break;
            case 'HR':
                $full_department_name = "Human Resource";
                break;
            case 'ST':
                $full_department_name = "Store";
                break;
            case 'IT':
                $full_department_name = "Electronic Data Processing";
                break;
            case 'FD':
                $full_department_name = "Formulation  Development";
                break;
            case 'AL':
                $full_department_name = "Analytical research and Development Laboratory";
                break;
            case 'PD':
                $full_department_name = "Packaging Development";
                break;
            case 'PU':
                $full_department_name = "Purchase Department";
                break;
            case 'DC':
                $full_department_name = "Document Cell";
                break;
            case 'RA':
                $full_department_name = "Regulatory Affairs";
                break; 
            case 'PV':
                $full_department_name = "Pharmacovigilance";
                break;         

            default:
                break;
        }

        return $full_department_name;

    }

    public static function getFullDepartmentTypeName($code)
    {
        $full_document_type_name = '';
    
        switch ($code) {
            case 'SOP':
                $full_document_type_name = "SOP’s (All types)";
                break;
            case 'BOM':
                $full_document_type_name = "Bill of Material";
                break;
            case 'BMR':
                $full_document_type_name = "Batch Manufacturing Record";
                break;
            case 'BPR':
                $full_document_type_name = "Batch Packing Record";
                break;
            case 'SPEC':
                $full_document_type_name = "Specification (All types)";
                break;
            case 'STP':
                $full_document_type_name = "Standard Testing Procedure (All types)";
                break;
            case 'TDS':
                $full_document_type_name = "Test Data Sheet";
                break;
            case 'GTP':
                $full_document_type_name = "General Testing Procedure";
                break;
            case 'PROTO':
                $full_document_type_name = "Protocols (All types)";
                break;
            case 'REPORT':
                $full_document_type_name = "Reports (All types)";
                break;
            case 'SMF':
                $full_document_type_name = "Site Master File";
                break;
            case 'VMP':
                $full_document_type_name = "Validation Master Plan";
                break;
            case 'QM':
                $full_document_type_name = "Quality Manual";
                break;
            default:
                $full_document_type_name = "-";
                break;
        }
    
        return $full_document_type_name;
    }

    static function getDepartments()
    {
        $departments = [
            'CQA' => 'Corporate Quality Assurance',
            'QA' => 'Quality Assurance',
            'QC' => 'Quality Control',
            'QM' => 'Quality Control (Microbiology department)',
            'PG' => 'Production General',
            'PL' => 'Production Liquid Orals',
            'PT' => 'Production Tablet and Powder',
            'PE' => 'Production External (Ointment, Gels, Creams and Liquid)',
            'PC' => 'Production Capsules',
            'PI' => 'Production Injectable',
            'EN' => 'Engineering',
            'HR' => 'Human Resource',
            'ST' => 'Store',
            'IT' => 'Electronic Data Processing',
            'FD' => 'Formulation Development',
            'AL' => 'Analytical research and Development Laboratory',
            'PD' => 'Packaging Development',
            'PU' => 'Purchase Department',
            'DC' => 'Document Cell',
            'RA' => 'Regulatory Affairs',
            'PV' => 'Pharmacovigilance',
        ];
        
        return $departments;
    }


    static function getDocumentTypes()
    {
        $document_types = [
            'SOP' => 'SOP’s (All types)',
            'BOM' => 'Bill of Material',
            'BMR' => 'Batch Manufacturing Record',
            'BPR' => 'Batch Packing Record',
            'SPEC' => 'Specification (All types)',
            'STP' => 'Standard Testing Procedure (All types)',
            'TDS' => 'Test Data Sheet',
            'GTP' => 'General Testing Procedure',
            'PROTO' => 'Protocols (All types)',
            'REPORT' => 'Reports (All types)',
            'SMF' => 'Site Master File',
            'VMP' => 'Validation Master Plan',
            'QM' => 'Quality Manual',
        ];
        
        return $document_types;
    }


     public static function getDueDate123($date, $addDays = false, $format = null)
        {
            try {
                if ($date) {
                    $format = $format ? $format : 'd M Y';
                    $dateInstance = Carbon::parse($date);
                    if ($addDays) {
                        $dateInstance->addDays(30);
                    }
                    return $dateInstance->format($format);
            }
            } catch (\Exception $e) {
                return 'NA';
            }
        }


    public static function getDepartmentWithString($id)
    {
        $response = [];
        if(!empty($id)){
            $response = explode(',',$id);
        }
        return $response;
    }
    public static function getInitiatorEmail($id)
    {


        return   DB::table('users')->where('id',$id)->value('email');
    }

    // Helpers::formatNumberWithLeadingZeros(0)
    public static function formatNumberWithLeadingZeros($number)
    {
        return sprintf('%04d', $number);
    }

    public static function getDepartmentNameWithString($id)
    {
        $response = [];
        $resp = [];
        if(!empty($id)){
            $result = explode(',',$id);
            if(in_array(1,$result)){
                array_push($response, 'QA');
            }
            if(in_array(2,$result)){
                array_push($response, 'QC');
            }
            if(in_array(3,$result)){
                array_push($response, 'R&D');
            }
            if(in_array(4,$result)){
                array_push($response, 'Manufacturing');
            }
            if(in_array(5,$result)){
                array_push($response, 'Warehouse');
            }
            $resp = implode(',',$response);
        }
        return $resp;
    }

    // static function getInitiatorGroups()

    static function getInitiatorGroups()
    {
        $initiator_groups = [
            'CQA' => 'Corporate Quality Assurance',
            'QAB' => 'Quality Assurance Biopharma',
            'CQC' => 'Central Quality Control',
            'MANU' => 'Manufacturing',
            'PSG' => 'Plasma Sourcing Group',
            'CS' => 'Central Stores',
            'ITG' => 'Information Technology Group',
            'MM' => 'Molecular Medicine',
            'CL' => 'Central Laboratory',
            'TT' => 'Tech team',
            'QA' => 'Quality Assurance',
            'QM' => 'Quality Management',
            'IA' => 'IT Administration',
            'ACC' => 'Accounting',
            'LOG' => 'Logistics',
            'SM' => 'Senior Management',
            'BA' => 'Business Administration'
        ];

        return $initiator_groups;


    }

    public static function getInitiatorGroupFullName($shortName)
    {
    {

        switch ($shortName) {
            case 'Corporate Quality Assurance':
                return 'Corporate Quality Assurance';
                break;
            case 'QAB':
                return 'Quality Assurance Biopharma';
                break;
            case 'CQC':
                return 'Central Quality Control';
                break;
            case 'MANU':
                return 'Manufacturing';
                break;
            case 'PSG':
                return 'Plasma Sourcing Group';
                break;
            case 'CS':
                return 'Central Stores';
                break;
            case 'ITG':
                return 'Information Technology Group';
                break;
            case 'MM':
                return 'Molecular Medicine';
                break;
            case 'CL':
                return 'Central Laboratory';
                break;
            case 'TT':
                return 'Tech Team';
                break;
            case 'QA':
                return 'Quality Assurance';
                break;
            case 'QM':
                return 'Quality Management';
                break;
            case 'IA':
                return 'IT Administration';
                break;
            case 'ACC':
                return 'Accounting';
                break;
            case 'LOG':
                return 'Logistics';
                break;
            case 'SM':
                return 'Senior Management';
                break;
            case 'BA':
                return 'Business Administration';
                break;
            default:
                return '';
                break;
        }
    }
    }

    public static function getNewInitiatorGroupFullName($shortName)
    {
        switch ($shortName) {
            case 'CQA':
                return 'Corporate Quality Assurance';
                break;
            case 'QAB':
                return 'Quality Assurance Biopharma';
                break;
            case 'CQC':
                return 'Central Quality Control';
                break;
            case 'MANU':
                return 'Manufacturing';
                break;
            case 'PSG':
                return 'Plasma Sourcing Group';
                break;
            case 'CS':
                return 'Central Stores';
                break;
            case 'ITG':
                return 'Information Technology Group';
                break;
            case 'MM':
                return 'Molecular Medicine';
                break;
            case 'CL':
                return 'Central Laboratory';
                break;
            case 'TT':
                return 'Tech Team';
                break;
            case 'QA':
                return 'Quality Assurance';
                break;
            case 'QM':
                return 'Quality Management';
                break;
            case 'IA':
                return 'IT Administration';
                break;
            case 'ACC':
                return 'Accounting';
                break;
            case 'LOG':
                return 'Logistics';
                break;
            case 'SM':
                return 'Senior Management';
                break;
            case 'BA':
                return 'Business Administration';
                break;
            default:
                return '';
                break;
        }

    }


    static public function userIsQA()
    {
        $isQA = false;

        try {

            $auth_user = auth()->user();

            if ($auth_user && $auth_user->department && $auth_user->department->dc == 'QA') {
                return true;
            }

        } catch (\Exception $e) {
            info('Error in Helpers::userIsQA', [ 'message' => $e->getMessage(), 'obj' => $e ]);
        }

        return $isQA;
    }

    // Helpers::getMicroGridData($micro, 'analyst_training', true, 'response', true, 0)
    public static function getMicroGridData(OOS_micro $micro, $identifier, $getKey = false, $keyName = null, $byIndex = false, $index = 0)
    {
        $res = $getKey ? '' : [];
            try {
                $grid = $micro->grids()->where('identifier', $identifier)->first();

                if($grid && is_array($grid->data)){

                    $res = $grid->data;

                    if ($getKey && !$byIndex) {
                        $res = array_key_exists($keyName, $grid->data) ? $grid->data[$keyName] : '';
                    }

                    if ($getKey && $byIndex && is_array($grid->data[$index])) {
                        $res = array_key_exists($keyName, $grid->data[$index]) ? $grid->data[$index][$keyName] : '';
                    }
                }

            } catch(\Exception $e){

            }
        return $res;
    }

    public static function disabledErrataFields($data)
    {
        if($data == 0 || $data > 5){
            return 'disabled';
        }else{
            return  '';
        }

    }

    public static function disabledMarketComplaintFields($marketcomplaint)
    {
        if($marketcomplaint == 0 || $marketcomplaint > 8){
            return 'disabled';
        }else{
            return  '';
        }

    }

    public static function getDocStatusByStage($stage, $document_training = 'no')
    {
        $status = '';
        $training_required = $document_training == 'yes' ? true : false;
        switch ($stage) {
            case '1':
                $status = 'Initiate';
                break;
            case '2':
                $status = 'Pending Draft Creation';
                break;
            case '3':
                $status = 'HOD Review';
                break;
            case '4':
                $status = 'QA Review';
                break;
            case '5':
                $status = 'Reviewer Review';
                break;
            case '6':
                $status = 'Approver Pending';
                break;
            case '7':
                $status = 'Pending-Traning';
                break;
                case '8':
                    $status = 'Traning Started';
                    break;
            case '9':
                $status = 'Traning Complete';
                break;
            case '10':
                $status = 'Effective';
                break;
            case '11':
                $status = 'Obsolete';
                break;
            case '12':
                $status = 'Closed/Cancel';
                break;
            default:
                # code...
                break;
        }

        return $status;
    }

    public static function compareValues($val1, $val2)
    {
        $html = '-';

        try {

            $val1 = $val1 ? strip_tags($val1) : 'NULL';
            $val2 = $val2 ? strip_tags($val2) : 'NULL';
            
            $diff = Diff::compareStrings($val1, $val2);
            
            
            // $diff->setCompareCharacters(true);

            $html = $diff->toHTML();

            $html = str_replace('<span> </span>', '&nbsp;', $html);
            $html = str_replace('<ins> </ins>', '&nbsp;', $html);
            $html = str_replace('<del> </del>', '&nbsp;', $html);

        } catch (\Exception $e) {

        }

        return $html;
    }
    
    public static function compareValues2($old, $new)
    {
        $html = '-';

        try {

            $old = $old ? $old : '';
            $new = $new ? $new : '';

            $rendererName = 'SideBySide';

            $differOptions = [
                'context' => 3,
                'ignoreCase' => false,
                'ignoreLineEnding' => false,
                'ignoreWhitespace' => false,
                'lengthLimit' => 2000,
                'fullContextIfIdentical' => false,
            ];

            $rendererOptions = [
                'detailLevel' => 'word',
                'language' => 'eng',
                'lineNumbers' => false,
                'separateBlock' => true,
                'showHeader' => true,
                'spacesToNbsp' => false,
                'tabSize' => 4,
                'mergeThreshold' => 0.8,
                'cliColorization' => RendererConstant::CLI_COLOR_AUTO,
                'outputTagAsString' => false,
                'jsonEncodeFlags' => \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE,
                'wordGlues' => [' ', '-'],
                'resultForIdenticals' => null,
                'wrapperClasses' => ['diff-wrapper'],
            ];

            $html = DiffHelper::calculate($old, $new, $rendererName, $differOptions, $rendererOptions);

        } catch (\Exception $e) {

        }

        return $html;
    }

    public static function check_roles($division_id, $process_name, $role_id, $user_id = null)
    {

        $process = QMSProcess::where([
            'division_id' => $division_id,
            'process_name' => $process_name
        ])->first();

        $roleExists = DB::table('user_roles')->where([
            'user_id' => $user_id ? $user_id : Auth::user()->id,
            'q_m_s_divisions_id' => $division_id,
            'q_m_s_processes_id' => $process ? $process->id : 0,
            'q_m_s_roles_id' => $role_id
        ])->first();

        return $roleExists ? true : false;
    }
    public static function getDueDatemonthly($date = null, $addDays = false, $format = null)
    {
        try {
            $format = $format ? $format : 'd-M-Y';
            $dateInstance = $date ? Carbon::parse($date) : Carbon::now();

            if ($addDays) {
                $dateInstance->addDays($addDays);
            } else {
                // Add 30 days instead of adding a month
                $dateInstance->addDays(30);
            }

            return $dateInstance->format($format);
        } catch (\Exception $e) {
            return 'NA';
        }
    }
    public static function getHODDropdown() {
        $hodUserList = DB::table('user_roles')
            ->join('users', 'user_roles.user_id', '=', 'users.id')
            ->where('user_roles.q_m_s_roles_id', '4')
            ->select('users.id', 'users.name')
            ->distinct()
            ->get();

        $dropdown = [];
        foreach ($hodUserList as $hodUser) {
            $dropdown[] = ['id' => $hodUser->id, 'name' => $hodUser->name];
        }

        return $dropdown;
    }

    public static function getChildData($id, $parent_type){
        $count = 0;
        if($parent_type == 'LabIncident')
       {
        $count = extension_new::where('parent_type', 'LabIncident')
        ->where('parent_id', $id)
        ->count();
       }
       elseif($parent_type == 'Deviation')
       {
        $count = extension_new::where('parent_type', 'Deviation')
        ->where('parent_id', $id)
        ->count();
       }
       elseif($parent_type == 'OOC')
       {
        $count = extension_new::where('parent_type', 'OOC')
        ->where('parent_id', $id)
        ->count();
       }
       elseif($parent_type == 'OOT')
       {
        $count = extension_new::where('parent_type', 'OOT')
        ->where('parent_id', $id)
        ->count();
       }
       elseif($parent_type == 'Management Review')
       {
        $count = extension_new::where('parent_type', 'Management Review')
        ->where('parent_id', $id)
        ->count();
       }
       elseif($parent_type == 'CAPA')
       {
        $count = extension_new::where('parent_type', 'CAPA')
        ->where('parent_id', $id)
        ->count();
       }
       elseif($parent_type == 'Action Item')
       {
        $count = extension_new::where('parent_type', 'Action Item')
        ->where('parent_id', $id)
        ->count();
       }
       elseif($parent_type == 'Resampling')
       {
        $count = extension_new::where('parent_type', 'Resampling')
        ->where('parent_id', $id)
        ->count();
       }
       elseif($parent_type == 'Observation')
       {
        $count = extension_new::where('parent_type', 'Observation')
        ->where('parent_id', $id)
        ->count();
       }
       elseif($parent_type == 'RCA')
       {
        $count = extension_new::where('parent_type', 'RCA')
        ->where('parent_id', $id)
        ->count();
       }
       elseif($parent_type == 'Risk Assesment')
       {
        $count = extension_new::where('parent_type', 'Risk Assesment')
        ->where('parent_id', $id)
        ->count();
       }
       elseif($parent_type == 'Management Review')
       {
        $count = extension_new::where('parent_type', 'Management Review')
        ->where('parent_id', $id)
        ->count();
       }
       elseif($parent_type == 'External Audit')
       {
        $count = extension_new::where('parent_type', 'External Audit')
        ->where('parent_id', $id)
        ->count();
       }
       elseif($parent_type == 'Internal Audit')
       {
        $count = extension_new::where('parent_type', 'Internal Audit')
        ->where('parent_id', $id)
        ->count();
       }
       elseif($parent_type == 'Audit Program')
       {
        $count = extension_new::where('parent_type', 'Audit Program')
        ->where('parent_id', $id)
        ->count();
       }
       elseif($parent_type == 'CC')
       {
        $count = extension_new::where('parent_type', 'CC')
        ->where('parent_id', $id)
        ->count();
       }
       elseif($parent_type == 'New Documnet')
       {
        $count = extension_new::where('parent_type', 'New Documnet')
        ->where('parent_id', $id)
        ->count();
       }
       elseif($parent_type == 'Effectiveness Check')
       {
        $count = extension_new::where('parent_type', 'Effectiveness Check')
        ->where('parent_id', $id)
        ->count();
       }
       elseif($parent_type == 'OOS Micro')
       {
        $count = extension_new::where('parent_type', 'OOS Micro')
        ->where('parent_id', $id)
        ->count();
       }
       elseif($parent_type == 'OOS Chemical')
       {
        $count = extension_new::where('parent_type', 'OOS Chemical')
        ->where('parent_id', $id)
        ->count();
       }
       elseif($parent_type == 'Market Complaint')
       {
        $count = extension_new::where('parent_type', 'Market Complaint')
        ->where('parent_id', $id)
        ->count();
       }
       elseif($parent_type == 'Failure Investigation')
       {
        $count = extension_new::where('parent_type', 'Failure Investigation')
        ->where('parent_id', $id)
        ->count();
       }

        return $count;
    }

    public static function checkRoles_check_draft($document)
    {
        if ($document->drafters) {
            $datauser = explode(',', $document->drafters);
            for ($i = 0; $i < count($datauser); $i++) {
                if ($datauser[$i] == Auth::user()->id) {
                    if($document->stage >= 2){
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        } else {
            return false;
        }
    }

    public static function filterRecords($table, $notificationTable, $userId)
    {
        return DB::table($table)
            ->whereExists(function ($query) use ($notificationTable, $table, $userId) {
                $query->select(DB::raw(1))
                    ->from($notificationTable)
                    ->whereRaw("$notificationTable.record_id = $table.id")
                    ->whereRaw("$notificationTable.record_type = $table.form_type")
                    ->where("$notificationTable.to_id", $userId);
            })
            ->get();
    } 

}
