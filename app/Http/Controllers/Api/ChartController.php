<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActionItem;
use App\Models\CC;
use App\Models\AuditProgram;
use App\Models\CallibrationDetails;
use App\Models\Capa;
use App\Models\Deviation;
use PDF;
use App\Models\Document;
use App\Models\EffectivenessCheck;
use App\Models\EquipmentLifecycleManagement;
// use App\Models\Errata;
use App\Models\Auditee;
use App\Models\extension_new;
use App\Models\ExternalAudit;
use App\Models\GlobalChangeControl;
use App\Models\Incident;
use App\Models\InternalAudit;
use App\Models\GlobalCapa;
use App\Models\LabIncident;
use App\Models\MarketComplaint;
use App\Models\OOS;
use App\Models\PreventiveMaintenance;
use App\Models\Process;
use App\Models\QMSDivision;
use App\Models\RiskAssessment;
use App\Models\RiskManagement;
use App\Models\RootCauseAnalysis;
use App\Models\Ootc;
use App\Models\errata;
use App\Models\Sanction;
use App\Models\Supplier;
use App\Models\SupplierAudit;
use App\Models\User;
use Carbon\Carbon;
use Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function process_charts()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $modelClasses = [
                \App\Models\Extension::class,
                \App\Models\ActionItem::class,
                \App\Models\Observation::class,
                \App\Models\RootCauseAnalysis::class,
                \App\Models\RiskAssessment::class,
                \App\Models\ManagementReview::class,
                \App\Models\InternalAudit::class,
                \App\Models\AuditProgram::class,
                // \App\Models\CAPA::class,
                \App\Models\CC::class,
                \App\Models\Document::class,
                \App\Models\LabIncident::class,
                \App\Models\EffectivenessCheck::class,
                \App\Models\OOS::class,
                \App\Models\OOT::class,
                \App\Models\Ootc::class,
                \App\Models\Deviation::class,
                \App\Models\MarketComplaint::class,
                // \App\Models\NonConformance::class,
                \App\Models\FailureInvestigation::class,
                // \App\Models\ERRATA::class,
                // \App\Models\OOS_micro::class
            ];

            $count = [];

            foreach ($modelClasses as $modelClass) {
                array_push($counts, [
                    'classname' => class_basename($modelClass),
                    'count' => self::getProcessCount($modelClass)
                ]);
            }

            $counts = collect($counts)->filter(function ($count) {
                return $count['count'] > 0;
            });


            $res['body'] = $counts->all();


        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function document_status_charts()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $counts = [
                'Draft' => 0,
                'In-HOD Review' => 0,
                'HOD Review Complete' => 0,
                'In-Review' => 0,
                'Reviewed' => 0,
                'For-Approval' => 0,
                'Approved' => 0,
                'Pending-Traning' => 0,
                'Traning-Complete' => 0,
                'Effective' => 0,
                'Obsolete' => 0,
            ];

            foreach ($counts as $status => $count) {
                $documents_count = Document::where('status', $status)->get()->count();

                $counts[$status] = $documents_count;
            }

            $res['body'] = $counts;


        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function overdue_records_by_process_chart()
    {
        $res = Helpers::getDefaultResponse();

        try {
            $overdueCounts = []; // To store the overdue count for each process
            $currentDate = now()->format('d-m-Y');
            $processTables = [
                'Action Item' => ActionItem::class,
                'Audit Program' => AuditProgram::class,
                'CAPA' => Capa::class,
                'Calibration Management' => CallibrationDetails::class,
                'Change Control' => CC::class,
                // 'Complaint Management' => MarketComplaint::class,
                'Deviation' => Deviation::class,
                // 'Due Date Extension' => extension_new::class,
                'Effectiveness Check' => EffectivenessCheck::class,
                'Equiment Lifecycle Management' => EquipmentLifecycleManagement::class,
                // 'ERRATA' => Errata::class,
                // 'External Audit' => ExternalAudit::class,
                'Global CAPA' => Capa::class,
                'Global Change Control' => CC::class,
                'Incident' => Incident::class,
                'Internal Audit' => InternalAudit::class,
                'Lab Incident' => LabIncident::class,
                // 'New Document' => Document::class,
                'OOS/OOT' => OOS::class,
                'Preventive Maintenance' => PreventiveMaintenance::class,
                'Risk Assessment' => RiskManagement::class,
                'Root Cause Analysis' => RootCauseAnalysis::class,
                'Supplier' => Supplier::class,
                'Supplier Audit' => SupplierAudit::class,
            ];

            foreach ($processTables as $processName => $model) {
                $overdueCount = 0;
                foreach ($model::get() as $entryRecord) {
                    $recordDueDate = \Carbon\Carbon::parse($entryRecord->due_date);
                    $currentDate = \Carbon\Carbon::now();
                    if ($recordDueDate->lessThan($currentDate)) {
                        $overdueCount++;
                    }
                }
                $overdueCounts[$processName] = $overdueCount; // Store the count
            }

            $res['body'] = $overdueCounts;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }



    public function deviation_classification_charts()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                $minor_deviations = Deviation::where('deviations', 'minor')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $major_deviations = Deviation::where('deviations', 'major')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $critical_deviations = Deviation::where('deviations', 'critical')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();


                $monthly_data['month'] = $month->format('M');
                $monthly_data['minor'] = $minor_deviations;
                $monthly_data['major'] = $major_deviations;
                $monthly_data['critical'] = $critical_deviations;

                array_push($data, $monthly_data);

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function deviation_departments_charts()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $departments = ["CQA", "QAB", "CQC", "MANU", "PSG", "CS", "ITG", "MM", "CL", "TT", "QA", "QM", "IA", "ACC", "LOG", "SM", "BA"];

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                foreach ($departments as $department) {
                    $deviations = Deviation::where('Initiator_Group', $department)
                        ->whereDate('created_at', '>=', $month->startOfMonth())
                        ->whereDate('created_at', '<=', $month->endOfMonth())
                        ->get()->count();

                    $data[$department][$month->format('F')] = $deviations;
                }

            }


            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function documents_originator_charts()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = Document::join('users', 'documents.originator_id', '=', 'users.id')
                ->select('documents.originator_id', 'users.name as originator_name', DB::raw('count(*) as document_count'))
                ->groupBy('documents.originator_id', 'users.name')
                ->get();

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function documents_type_charts()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = Document::join('document_types', 'documents.document_type_id', '=', 'document_types.id')
                ->select('document_types.name as document_type_name', DB::raw('count(documents.id) as document_count'))
                ->groupBy('document_types.id', 'document_types.name')
                ->get();

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function documents_review_charts($months)
    {
        $res = Helpers::getDefaultResponse();

        try {

            $today = Carbon::today();
            $monthsLater = $today->copy()->addMonths($months);

            $data = Document::where('next_review_date', '>=', $today)
                ->where('next_review_date', '<=', $monthsLater)
                ->get();

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function documents_stage_charts($stage)
    {
        $res = Helpers::getDefaultResponse();

        try {

            // $data = Document::where('next_review_date', '>=', $today)
            //     ->where('next_review_date', '<=', $monthsLater)
            //     ->get();

            // $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function document_pending_review_charts()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            $pending_review_documents = Document::where('status', 'In-Review')->get();

            foreach ($pending_review_documents as $document) {
                if ($document->reviewers) {
                    $reviewers = explode(',', $document->reviewers);

                    foreach ($reviewers as $reviewer) {

                        $reviewer_name = User::find($reviewer) ? User::find($reviewer)->name : 'NULL';

                        $data[$reviewer_name] = isset($data[$reviewer_name]) ? $data[$reviewer_name] + 1 : 1;
                    }

                }
            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function document_pending_approve_charts()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            $pending_approve_documents = Document::where('status', 'For-Approval')->get();

            foreach ($pending_approve_documents as $document) {
                if ($document->approvers) {
                    $approvers = explode(',', $document->approvers);

                    foreach ($approvers as $approver) {

                        $approver_name = User::find($approver) ? User::find($approver)->name : 'NULL';

                        $data[$approver_name] = isset($data[$approver_name]) ? $data[$approver_name] + 1 : 1;
                    }

                }
            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function document_pending_hod_charts()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            $pending_hod_documents = Document::where('status', 'In-HOD Review')->get();

            foreach ($pending_hod_documents as $document) {
                if ($document->hods) {
                    $hods = explode(',', $document->hods);

                    foreach ($hods as $hod) {

                        $hod_name = User::find($hod) ? User::find($hod)->name : 'NULL';

                        $data[$hod_name] = isset($data[$hod_name]) ? $data[$hod_name] + 1 : 1;
                    }

                }
            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function document_pending_training_charts()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            $pending_training_documents = Document::where('status', 'Pending-Traning')->get();

            foreach ($pending_training_documents as $document) {
                if ($document->trainer) {
                    $trainers = explode(',', $document->trainer);

                    foreach ($trainers as $trainer) {

                        $trainer_name = User::find($trainer) ? User::find($trainer)->name : 'NULL';

                        $data[$trainer_name] = isset($data[$trainer_name]) ? $data[$trainer_name] + 1 : 1;
                    }

                }
            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function deviationSeverityLevel()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                $negligible_deviations = Deviation::where('severity_rate', 'negligible')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $moderate_deviations = Deviation::where('severity_rate', 'moderate')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $major_deviations = Deviation::where('severity_rate', 'major')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $fatal_deviations = Deviation::where('severity_rate', 'fatal')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();


                $monthly_data['month'] = $month->format('M');
                $monthly_data['negligible'] = $negligible_deviations;
                $monthly_data['moderate'] = $moderate_deviations;
                $monthly_data['major'] = $major_deviations;
                $monthly_data['fatal'] = $fatal_deviations;

                array_push($data, $monthly_data);

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function documentByPriority()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                $low_priority = RiskManagement::where('priority_level', 'low')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $medium_priority = RiskManagement::where('priority_level', 'medium')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $high_priority = RiskManagement::where('priority_level', 'high')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();


                $monthly_data['month'] = $month->format('M');
                $monthly_data['low'] = $low_priority;
                $monthly_data['medium'] = $medium_priority;
                $monthly_data['high'] = $high_priority;

                array_push($data, $monthly_data);

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function documentByPriorityDeviation()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                $low_priority = Deviation::where('priority_data', 'low')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $medium_priority = Deviation::where('priority_data', 'medium')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $high_priority = Deviation::where('priority_data', 'high')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();


                $monthly_data['month'] = $month->format('M');
                $monthly_data['low'] = $low_priority;
                $monthly_data['medium'] = $medium_priority;
                $monthly_data['high'] = $high_priority;

                array_push($data, $monthly_data);

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function documentByPriorityChangeControl()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                $low_priority = CC::where('priority_data', 'low')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $medium_priority = CC::where('priority_data', 'medium')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $high_priority = CC::where('priority_data', 'high')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();


                $monthly_data['month'] = $month->format('M');
                $monthly_data['low'] = $low_priority;
                $monthly_data['medium'] = $medium_priority;
                $monthly_data['high'] = $high_priority;

                array_push($data, $monthly_data);

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    // ===================Extension =================
    // public function documentByPriorityExtension()
    // {
    //     $res = Helpers::getDefaultResponse();

    //     try {

    //         $data = [];

    //         for ($i = 5; $i >= 0; $i--) {
    //             $monthly_data = [];
    //             $month = Carbon::now()->subMonths($i);

    //             $low_priority = extension_new::where('priority_data', 'Low')
    //                 ->whereDate('created_at', '>=', $month->startOfMonth())
    //                 ->whereDate('created_at', '<=', $month->endOfMonth())
    //                 ->get()->count();
    //             $medium_priority = extension_new::where('priority_data', 'Medium')
    //                 ->whereDate('created_at', '>=', $month->startOfMonth())
    //                 ->whereDate('created_at', '<=', $month->endOfMonth())
    //                 ->get()->count();
    //             $high_priority = extension_new::where('priority_data', 'High')
    //                 ->whereDate('created_at', '>=', $month->startOfMonth())
    //                 ->whereDate('created_at', '<=', $month->endOfMonth())
    //                 ->get()->count();


    //             $monthly_data['month'] = $month->format('M');
    //             $monthly_data['low'] = $low_priority;
    //             $monthly_data['medium'] = $medium_priority;
    //             $monthly_data['high'] = $high_priority;

    //             array_push($data, $monthly_data);

    //         }

    //         $res['body'] = $data;

    //     } catch (\Exception $e) {
    //         $res['status'] = 'error';
    //         $res['message'] = $e->getMessage();
    //     }

    //     return response()->json($res);
    // }


    // public function stageByPriorityExtension(){
    //     try {
    //         $data = DB::table('extension_news')
    //             ->select('status', DB::raw('count(*) as count'))
    //             ->groupBy('status')
    //             ->get();

    //         $response = [
    //             'labels' => $data->pluck('status'),
    //             'series' => $data->pluck('count')
    //         ];

    //         return response()->json([
    //             'status' => 'ok',
    //             'body' => $response
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $e->getMessage()
    //         ]);
    //     }
    // }
    // =================


    // public function documentByPriorityGlobalChangeControl()
    // {
    //     $res = Helpers::getDefaultResponse();

    //     try {

    //         $data = [];

    //         for ($i = 5; $i >= 0; $i--) {
    //             $monthly_data = [];
    //             $month = Carbon::now()->subMonths($i);

    //             $low_priority = GlobalChangeControl::where('priority_data', 'low')
    //                 ->whereDate('created_at', '>=', $month->startOfMonth())
    //                 ->whereDate('created_at', '<=', $month->endOfMonth())
    //                 ->get()->count();
    //             $medium_priority = GlobalChangeControl::where('priority_data', 'medium')
    //                 ->whereDate('created_at', '>=', $month->startOfMonth())
    //                 ->whereDate('created_at', '<=', $month->endOfMonth())
    //                 ->get()->count();
    //             $high_priority = GlobalChangeControl::where('priority_data', 'high')
    //                 ->whereDate('created_at', '>=', $month->startOfMonth())
    //                 ->whereDate('created_at', '<=', $month->endOfMonth())
    //                 ->get()->count();


    //             $monthly_data['month'] = $month->format('M');
    //             $monthly_data['low'] = $low_priority;
    //             $monthly_data['medium'] = $medium_priority;
    //             $monthly_data['high'] = $high_priority;

    //             array_push($data, $monthly_data);

    //         }

    //         $res['body'] = $data;

    //     } catch (\Exception $e) {
    //         $res['status'] = 'error';
    //         $res['message'] = $e->getMessage();
    //     }

    //     return response()->json($res);
    // }


    public function documentByPriorityGlobalChangeControl()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                $low_priority = GlobalChangeControl::where('priority_data', 'low')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $medium_priority = GlobalChangeControl::where('priority_data', 'medium')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $high_priority = GlobalChangeControl::where('priority_data', 'high')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();


                $monthly_data['month'] = $month->format('M');
                $monthly_data['low'] = $low_priority;
                $monthly_data['medium'] = $medium_priority;
                $monthly_data['high'] = $high_priority;

                array_push($data, $monthly_data);

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    // ===================Extension =================
    public function documentByPriorityExtension()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                $low_priority = extension_new::where('priority_data', 'Low')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $medium_priority = extension_new::where('priority_data', 'Medium')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $high_priority = extension_new::where('priority_data', 'High')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();


                $monthly_data['month'] = $month->format('M');
                $monthly_data['low'] = $low_priority;
                $monthly_data['medium'] = $medium_priority;
                $monthly_data['high'] = $high_priority;

                array_push($data, $monthly_data);

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }


    public function stageByPriorityExtension()
    {
        try {
            $data = DB::table('extension_news')
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get();

            $response = [
                'labels' => $data->pluck('status'),
                'series' => $data->pluck('count')
            ];

            return response()->json([
                'status' => 'ok',
                'body' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getextensioninitialData()
    {
        // Fetching the data from the 'DeviationCategory' model
        $data = extension_new::select('initial_categorization', \DB::raw('count(*) as count'))
            ->groupBy('initial_categorization')  // Group by Deviation_category
            ->get(); // Fetch the grouped data

        // Prepare data in the form of an associative array
        $deviationData = [
            'major' => 0,
            'minor' => 0,
            'critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->initial_categorization == 'major') {
                $deviationData['major'] = $entry->count;
            } elseif ($entry->initial_categorization == 'minor') {
                $deviationData['minor'] = $entry->count;
            } elseif ($entry->initial_categorization == 'critical') {
                $deviationData['critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function GetextensionpostCategoryData()
    {
        // Fetching the data from the 'DeviationCategory' model
        $data = extension_new::select('post_categorization', \DB::raw('count(*) as count'))
            ->groupBy('post_categorization')  // Group by post_categorization
            ->get(); // Fetch the grouped data

        // Prepare data in the form of an associative array
        $deviationData = [
            'major' => 0,
            'minor' => 0,
            'critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->post_categorization == 'major') {
                $deviationData['major'] = $entry->count;
            } elseif ($entry->post_categorization == 'minor') {
                $deviationData['minor'] = $entry->count;
            } elseif ($entry->post_categorization == 'critical') {
                $deviationData['critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }
    // =================

    public function deviationStageDistribution()
    {
        try {
            $data = DB::table('deviations')
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get();

            $response = [
                'labels' => $data->pluck('status'),
                'series' => $data->pluck('count')
            ];

            return response()->json([
                'status' => 'ok',
                'body' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function changeControlStageDistribution()
    {
        try {
            $data = DB::table('c_c_s')
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get();

            $response = [
                'labels' => $data->pluck('status'),
                'series' => $data->pluck('count')
            ];

            return response()->json([
                'status' => 'ok',
                'body' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }


    public function globalChangeControlStageDistribution()
    {
        try {
            $data = DB::table('global_change_controls')
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get();

            $response = [
                'labels' => $data->pluck('status'),
                'series' => $data->pluck('count')
            ];

            return response()->json([
                'status' => 'ok',
                'body' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function documentByPriorityRca()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                $low_priority = RootCauseAnalysis::where('priority_level', 'low')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $medium_priority = RootCauseAnalysis::where('priority_level', 'medium')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $high_priority = RootCauseAnalysis::where('priority_level', 'high')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();


                $monthly_data['month'] = $month->format('M');
                $monthly_data['low'] = $low_priority;
                $monthly_data['medium'] = $medium_priority;
                $monthly_data['high'] = $high_priority;

                array_push($data, $monthly_data);

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function documentDelayed()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                $delayedDoc = Deviation::where('stage', '<', 9)
                    ->where('due_date', '<', Carbon::now())
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();

                $onTimeDoc = Deviation::where('stage', '=', 9)
                    ->where('due_date', '<', Carbon::now())
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();

                $monthly_data['month'] = $month->format('M');
                $monthly_data['delayed'] = $delayedDoc;
                $monthly_data['onTime'] = $onTimeDoc;

                array_push($data, $monthly_data);

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function documentDelayedChangeControl()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                $delayedDoc = CC::where('stage', '<', 9)
                    ->where('due_date', '<', Carbon::now())
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();

                $onTimeDoc = CC::where('stage', '=', 9)
                    ->where('due_date', '<', Carbon::now())
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();

                $monthly_data['month'] = $month->format('M');
                $monthly_data['delayed'] = $delayedDoc;
                $monthly_data['onTime'] = $onTimeDoc;

                array_push($data, $monthly_data);

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function documentDelayedGlobalChangeControl()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                $delayedDoc = GlobalChangeControl::where('stage', '<', 9)
                    ->where('due_date', '<', Carbon::now())
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();

                $onTimeDoc = GlobalChangeControl::where('stage', '=', 9)
                    ->where('due_date', '<', Carbon::now())
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();

                $monthly_data['month'] = $month->format('M');
                $monthly_data['delayed'] = $delayedDoc;
                $monthly_data['onTime'] = $onTimeDoc;

                array_push($data, $monthly_data);

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function siteWiseDocument()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                $corporateDoc = DB::table('deviations')
                    ->join('q_m_s_divisions', 'deviations.division_id', '=', 'q_m_s_divisions.id')
                    ->select('deviations.*', 'q_m_s_divisions.name as division_name')
                    ->whereDate('deviations.created_at', '>=', $month->startOfMonth())
                    ->whereDate('deviations.created_at', '<=', $month->endOfMonth())
                    ->where('q_m_s_divisions.name', 'Corporate')
                    ->get()->count();

                $plantDoc = DB::table('deviations')
                    ->join('q_m_s_divisions', 'deviations.division_id', '=', 'q_m_s_divisions.id')
                    ->select('deviations.*', 'q_m_s_divisions.name as division_name')
                    ->whereDate('deviations.created_at', '>=', $month->startOfMonth())
                    ->whereDate('deviations.created_at', '<=', $month->endOfMonth())
                    ->where('q_m_s_divisions.name', 'Plant')
                    ->get()->count();

                $monthly_data['month'] = $month->format('M');
                $monthly_data['corporate'] = $corporateDoc;
                $monthly_data['plant'] = $plantDoc;

                array_push($data, $monthly_data);

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function siteWiseChangeControlDocument()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                $corporateDoc = DB::table('c_c_s')
                    ->join('q_m_s_divisions', 'c_c_s.division_id', '=', 'q_m_s_divisions.id')
                    ->select('c_c_s.*', 'q_m_s_divisions.name as division_name')
                    ->whereDate('c_c_s.created_at', '>=', $month->startOfMonth())
                    ->whereDate('c_c_s.created_at', '<=', $month->endOfMonth())
                    ->where('q_m_s_divisions.name', 'Corporate')
                    ->get()->count();

                $plantDoc = DB::table('c_c_s')
                    ->join('q_m_s_divisions', 'c_c_s.division_id', '=', 'q_m_s_divisions.id')
                    ->select('c_c_s.*', 'q_m_s_divisions.name as division_name')
                    ->whereDate('c_c_s.created_at', '>=', $month->startOfMonth())
                    ->whereDate('c_c_s.created_at', '<=', $month->endOfMonth())
                    ->where('q_m_s_divisions.name', 'Plant')
                    ->get()->count();

                $monthly_data['month'] = $month->format('M');
                $monthly_data['corporate'] = $corporateDoc;
                $monthly_data['plant'] = $plantDoc;

                array_push($data, $monthly_data);

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function siteWiseGlobalChangeControlDocument()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                $corporateDoc = DB::table('global_change_controls')
                    ->join('q_m_s_divisions', 'global_change_controls.division_id', '=', 'q_m_s_divisions.id')
                    ->select('global_change_controls.*', 'q_m_s_divisions.name as division_name')
                    ->whereDate('global_change_controls.created_at', '>=', $month->startOfMonth())
                    ->whereDate('global_change_controls.created_at', '<=', $month->endOfMonth())
                    ->where('q_m_s_divisions.name', 'Corporate')
                    ->get()->count();

                $plantDoc = DB::table('global_change_controls')
                    ->join('q_m_s_divisions', 'global_change_controls.division_id', '=', 'q_m_s_divisions.id')
                    ->select('global_change_controls.*', 'q_m_s_divisions.name as division_name')
                    ->whereDate('global_change_controls.created_at', '>=', $month->startOfMonth())
                    ->whereDate('global_change_controls.created_at', '<=', $month->endOfMonth())
                    ->where('q_m_s_divisions.name', 'Plant')
                    ->get()->count();

                $monthly_data['month'] = $month->format('M');
                $monthly_data['corporate'] = $corporateDoc;
                $monthly_data['plant'] = $plantDoc;

                array_push($data, $monthly_data);

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }


    public function getFlowCounts()
    {
        $res = ['status' => 'ok', 'body' => []];

        try {
            $flows = [
                'Action Item' => ActionItem::count(),
                'Audit Program' => AuditProgram::count(),
                'CAPA' => Capa::count(),
                'Calibration Management' => CallibrationDetails::count(),
                'Change Control' => CC::count(),
                'Complaint Management' => MarketComplaint::count(),
                'Deviation' => Deviation::count(),
                'Extension' => extension_new::count(),
                'Effectiveness Check' => EffectivenessCheck::count(),
                'Equipment Lifecycle' => EquipmentLifecycleManagement::count(),
                'Errata' => Errata::count(),
                'Global Capa' => Capa::count(),
                'Global Change Control' => CC::count(),
                'Incident' => Incident::count(),
                'Internal Audit' => InternalAudit::count(),
                'LabIncident' => LabIncident::count(),
                'OOS/OOT' => Ootc::count(),
                'Preventive Maintenance' => PreventiveMaintenance::count(),
                'Risk Assesment' => RiskManagement::count(),
                'Root Cause Analysis' => RootCauseAnalysis::count(),
                'Supplier' => Supplier::count(),
                'Supplier Audit' => SupplierAudit::count(),
            ];

            $res['body'] = array_map(function ($flow, $count) {
                return [
                    'name' => $flow,
                    'count' => $count
                ];
            }, array_keys($flows), $flows);

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }


    // Helpers

    static function getProcessCount($model_namespace, $field = null, $value = null)
    {
        try {
            if ($field && $value) {
                return $model_namespace::where($field, $value)->get()->count();
            } else {
                return $model_namespace::get()->count();
            }
        } catch (\Exception $e) {
            return 0;
        }
    }
    public function getDivisionProcessCounts()
    {
        $res = [
            'status' => 'success',
            'message' => null,
            'body' => []
        ];

        try {
            $processes = [


                'Action Item' => 'action_items',
                'Audit Program' => 'audit_programs',
                'CAPA' => 'capas',
                'Calibration Management' => 'out_of_calibrations',
                'Change Control' => 'c_c_s',
                'Complaint Management' => 'marketcompalints',
                'Deviation' => 'deviations',
                'Due Date Extension' => 'extensions',
                'Effectiveness Check' => 'effectiveness_checks',
                'Equipment Lifecycle Management' => 'equipment_lifecycle_information',
                'ERRATA' => 'erratas',
                'External Audit' => 'auditees',
                'Global CAPA' => 'capas',
                'Global Change Control' => 'c_c_s',
                'Incident' => 'incidents',
                'Internal Audit' => 'internal_audits',
                'Lab Incident' => 'lab_incidents',
                'New Document' => 'documents',
                'OOS/OOT' => 'o_o_t_s',
                'Preventive Maintenance' => 'preventive_maintenances',
                'Risk Assessment' => 'risk_assessments',
                'Root Cause Analysis' => 'root_cause_analyses',
                'Supplier' => 'suppliers',
                'Supplier Audit' => 'supplier_audits',

            ];

            $divisions = ['Corporate Quality Assurance (CQA)', 'Plant 1', 'Plant 2', 'Plant 3', 'Plant 4', 'C1'];

            $data = [];

            foreach ($divisions as $division) {
                $divisionData = [
                    'division' => $division,
                    'processCounts' => []
                ];

                foreach ($processes as $processName => $tableName) {
                    $processCount = DB::table($tableName)
                        ->where('division_id', function ($query) use ($division) {
                            $query->select('id')
                                ->from('q_m_s_divisions')
                                ->where('name', $division)
                                ->limit(1);
                        })
                        ->count();

                    $divisionData['processCounts'][] = [
                        'process' => $processName,
                        'count' => $processCount
                    ];
                }

                $data[] = $divisionData;
            }

            $res['body'] = $data;
        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }
    public function getDeviationData()
    {
        // Fetching the data from the 'DeviationCategory' model
        $data = Deviation::select('Deviation_category', \DB::raw('count(*) as count'))
            ->groupBy('Deviation_category')  // Group by Deviation_category
            ->get(); // Fetch the grouped data

        // Prepare data in the form of an associative array
        $deviationData = [
            'major' => 0,
            'minor' => 0,
            'critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->Deviation_category == 'major') {
                $deviationData['major'] = $entry->count;
            } elseif ($entry->Deviation_category == 'minor') {
                $deviationData['minor'] = $entry->count;
            } elseif ($entry->Deviation_category == 'critical') {
                $deviationData['critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }


    public function getChangeControlData()
    {
        // Fetching the data from the 'DeviationCategory' model
        $data = CC::select('severity_level1', \DB::raw('count(*) as count'))
            ->groupBy('severity_level1')  // Group by Deviation_category
            ->get(); // Fetch the grouped data

        // Prepare data in the form of an associative array
        $deviationData = [
            'major' => 0,
            'minor' => 0,
            'critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->severity_level1 == 'major') {
                $deviationData['major'] = $entry->count;
            } elseif ($entry->severity_level1 == 'minor') {
                $deviationData['minor'] = $entry->count;
            } elseif ($entry->severity_level1 == 'critical') {
                $deviationData['critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }


    public function getActionItemData()
    {
        // Fetching the data from the 'DeviationCategory' model
        $data = ActionItem::select('initial_categorization', \DB::raw('count(*) as count'))
            ->groupBy('initial_categorization')  // Group by Deviation_category
            ->get(); // Fetch the grouped data

        // Prepare data in the form of an associative array
        $deviationData = [
            'major' => 0,
            'minor' => 0,
            'critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->initial_categorization == 'major') {
                $deviationData['major'] = $entry->count;
            } elseif ($entry->initial_categorization == 'minor') {
                $deviationData['minor'] = $entry->count;
            } elseif ($entry->initial_categorization == 'critical') {
                $deviationData['critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }


    public function documentDelayedActionItem()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                $delayedDoc = ActionItem::where('stage', '<', 9)
                    ->where('due_date', '<', Carbon::now())
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();

                $onTimeDoc = ActionItem::where('stage', '=', 9)
                    ->where('due_date', '<', Carbon::now())
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();

                $monthly_data['month'] = $month->format('M');
                $monthly_data['delayed'] = $delayedDoc;
                $monthly_data['onTime'] = $onTimeDoc;

                array_push($data, $monthly_data);

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }





    public function siteWiseActionItemDocument()
    {
        // $res = Helpers::getDefaultResponse();

        // try {

        //     $data = [];

        //     for ($i = 5; $i >= 0; $i--) {
        //         $monthly_data = [];
        //         $month = Carbon::now()->subMonths($i);

        //         $corporateDoc = DB::table('action_items')
        //             ->join('q_m_s_divisions', 'action_items.division_id', '=', 'q_m_s_divisions.id')
        //             ->select('action_items.*', 'q_m_s_divisions.name as division_name')
        //             ->whereDate('action_items.created_at', '>=', $month->startOfMonth())
        //             ->whereDate('action_items.created_at', '<=', $month->endOfMonth())
        //             ->where('q_m_s_divisions.name', 'Corporate')
        //             ->get()->count();

        //         $plantDoc = DB::table('action_items')
        //             ->join('q_m_s_divisions', 'action_items.division_id', '=', 'q_m_s_divisions.id')
        //             ->select('action_items.*', 'q_m_s_divisions.name as division_name')
        //             ->whereDate('action_items.created_at', '>=', $month->startOfMonth())
        //             ->whereDate('action_items.created_at', '<=', $month->endOfMonth())
        //             ->where('q_m_s_divisions.name', 'Plant')
        //             ->get()->count();

        //         $monthly_data['month'] = $month->format('M');
        //         $monthly_data['corporate'] = $corporateDoc;
        //         $monthly_data['plant'] = $plantDoc;

        //         array_push($data, $monthly_data);

        //     }

        //     $res['body'] = $data;

        // } catch (\Exception $e) {
        //     $res['status'] = 'error';
        //     $res['message'] = $e->getMessage();
        // }

        // return response()->json($res);

        $data = \DB::table('q_m_s_divisions')
            ->leftJoin('action_items', 'action_items.division_id', '=', 'q_m_s_divisions.id')
            ->select('q_m_s_divisions.name as division_name', \DB::raw('COUNT(action_items.id) as count'))
            ->groupBy('q_m_s_divisions.id', 'q_m_s_divisions.name')
            ->orderBy('q_m_s_divisions.name')
            ->get();

        return response()->json($data);
    }





    public function getActionItemCategorizationData()
    {
        // Fetching the data from the 'DeviationCategory' model
        $data = ActionItem::select('Post_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Post_Categorization')  // Group by bd_domestic
            ->get(); // Fetch the grouped data

        // Prepare data in the form of an associative array
        $deviationData = [
            'major' => 0,
            'minor' => 0,
            'critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->Post_Categorization == 'major') {
                $deviationData['major'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'minor') {
                $deviationData['minor'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'critical') {
                $deviationData['critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }



    public function documentByPriorityActionItem()
    {
        $res = Helpers::getDefaultResponse();

        try {

            $data = [];

            for ($i = 5; $i >= 0; $i--) {
                $monthly_data = [];
                $month = Carbon::now()->subMonths($i);

                $low_priority = ActionItem::where('priority_data', 'low')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $medium_priority = ActionItem::where('priority_data', 'medium')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();
                $high_priority = ActionItem::where('priority_data', 'high')
                    ->whereDate('created_at', '>=', $month->startOfMonth())
                    ->whereDate('created_at', '<=', $month->endOfMonth())
                    ->get()->count();


                $monthly_data['month'] = $month->format('M');
                $monthly_data['low'] = $low_priority;
                $monthly_data['medium'] = $medium_priority;
                $monthly_data['high'] = $high_priority;

                array_push($data, $monthly_data);

            }

            $res['body'] = $data;

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }



    public function actionItemStageDistribution()
    {
        try {
            $data = DB::table('action_items')
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get();

            $response = [
                'labels' => $data->pluck('status'),
                'series' => $data->pluck('count')
            ];

            return response()->json([
                'status' => 'ok',
                'body' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }



    public function getGlobalChangeControlData()
    {
        // Fetching the data from the 'DeviationCategory' model
        $data = GlobalChangeControl::select('severity_level1', \DB::raw('count(*) as count'))
            ->groupBy('severity_level1')  // Group by Deviation_category
            ->get(); // Fetch the grouped data

        // Prepare data in the form of an associative array
        $deviationData = [
            'major' => 0,
            'minor' => 0,
            'critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->severity_level1 == 'major') {
                $deviationData['major'] = $entry->count;
            } elseif ($entry->severity_level1 == 'minor') {
                $deviationData['minor'] = $entry->count;
            } elseif ($entry->severity_level1 == 'critical') {
                $deviationData['critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }
    public function getcategorizationData()
    {
        // Fetching the data from the 'DeviationCategory' model
        $data = Deviation::select('Post_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Post_Categorization')  // Group by Post_Categorization
            ->get(); // Fetch the grouped data

        // Prepare data in the form of an associative array
        $deviationData = [
            'major' => 0,
            'minor' => 0,
            'critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->Post_Categorization == 'major') {
                $deviationData['major'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'minor') {
                $deviationData['minor'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'critical') {
                $deviationData['critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getChangeControlCategorizationData()
    {
        // Fetching the data from the 'DeviationCategory' model
        $data = CC::select('bd_domestic', \DB::raw('count(*) as count'))
            ->groupBy('bd_domestic')  // Group by bd_domestic
            ->get(); // Fetch the grouped data

        // Prepare data in the form of an associative array
        $deviationData = [
            'major' => 0,
            'minor' => 0,
            'critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->bd_domestic == 'major') {
                $deviationData['major'] = $entry->count;
            } elseif ($entry->bd_domestic == 'minor') {
                $deviationData['minor'] = $entry->count;
            } elseif ($entry->bd_domestic == 'critical') {
                $deviationData['critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    /*********** Capa ************/

    public function getCapaInitialCategorization()
    {
        $data = Capa::select('Initial_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Initial_Categorization')  // Group by Initial_Categorization
            ->get(); // Fetch the grouped data

        // Prepare data in the form of an associative array
        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->Initial_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Initial_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Initial_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getCapaPostCategorization()
    {
        $data = Capa::select('Post_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Post_Categorization')
            ->get();

        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->Post_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getOnTimeVsDelayedRecords()
    {
        $today = \Carbon\Carbon::today();

        $onTime = \DB::table('capas')
            ->where('due_date', '>=', $today)
            ->where('status', 'Closed - Done')
            ->count();

        $delayed = \DB::table('capas')
            ->where('due_date', '<', $today)
            ->where('status', '!=', 'Closed - Done')
            ->count();

        return response()->json([
            'On Time' => $onTime,
            'Delayed' => $delayed,
        ]);
    }

    public function getCapaByDivision()
    {
        $data = \DB::table('q_m_s_divisions')
            ->leftJoin('capas', 'capas.division_id', '=', 'q_m_s_divisions.id')
            ->select('q_m_s_divisions.name as division_name', \DB::raw('COUNT(capas.id) as count'))
            ->groupBy('q_m_s_divisions.id', 'q_m_s_divisions.name')
            ->orderBy('q_m_s_divisions.name')
            ->get();

        return response()->json($data);
    }

    public function getCapaPriorityData()
    {
        $data = Capa::select('priority_data', \DB::raw('count(*) as count'))
            ->groupBy('priority_data')
            ->get();

        $deviationData = [
            'High' => 0,
            'Medium' => 0,
            'Low' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->priority_data == 'High') {
                $deviationData['High'] = $entry->count;
            } elseif ($entry->priority_data == 'Medium') {
                $deviationData['Medium'] = $entry->count;
            } elseif ($entry->priority_data == 'Low') {
                $deviationData['Low'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getCapaByStatus()
    {
        $statuses = [
            'Opened',
            'HOD Review',
            'QA/CQA Review',
            'QA/CQA Approval',
            'CAPA In progress',
            'HOD Final Review',
            'QA/CQA Closure Review',
            'QA/CQA Approval',
            'Closed - Done'
        ];

        $data = collect($statuses)->mapWithKeys(function ($status) {
            $count = \DB::table('capas')
                ->where('status', $status)
                ->count();

            return [$status => $count];
        });

        return response()->json($data);
    }

    /*********** Capa ************/


    /*********** Global Capa ************/
    public function getGlobalCapaInitialCategorization()
    {
        $data = GlobalCapa::select('Initial_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Initial_Categorization')  // Group by Initial_Categorization
            ->get(); // Fetch the grouped data

        // Prepare data in the form of an associative array
        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->Initial_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Initial_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Initial_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getGlobalCapaPostCategorization()
    {
        $data = GlobalCapa::select('Post_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Post_Categorization')
            ->get();

        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->Post_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getOnTimeVsDelayedRecordsGlobalCapa()
    {
        $today = \Carbon\Carbon::today();

        $onTime = \DB::table('global_capas')
            ->where('due_date', '>=', $today)
            ->where('status', 'Closed - Done')
            ->count();

        $delayed = \DB::table('global_capas')
            ->where('due_date', '<', $today)
            ->where('status', '!=', 'Closed - Done')
            ->count();

        return response()->json([
            'On Time' => $onTime,
            'Delayed' => $delayed,
        ]);
    }

    public function getGlobalCapaByDivision()
    {
        $data = \DB::table('q_m_s_divisions')
            ->leftJoin('global_capas', 'global_capas.division_id', '=', 'q_m_s_divisions.id')
            ->select('q_m_s_divisions.name as division_name', \DB::raw('COUNT(global_capas.id) as count'))
            ->groupBy('q_m_s_divisions.id', 'q_m_s_divisions.name')
            ->orderBy('q_m_s_divisions.name')
            ->get();

        return response()->json($data);
    }

    public function getGlobalCapaPriorityData()
    {
        $data = GlobalCapa::select('priority_data', \DB::raw('count(*) as count'))
            ->groupBy('priority_data')
            ->get();

        $deviationData = [
            'High' => 0,
            'Medium' => 0,
            'Low' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->priority_data == 'High') {
                $deviationData['High'] = $entry->count;
            } elseif ($entry->priority_data == 'Medium') {
                $deviationData['Medium'] = $entry->count;
            } elseif ($entry->priority_data == 'Low') {
                $deviationData['Low'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getGlobalCapaByStatus()
    {
        $statuses = [
            'Opened',
            'HOD Review',
            'QA/CQA Review',
            'QA/CQA Approval',
            'CAPA In progress',
            'HOD Final Review',
            'QA/CQA Closure Review',
            'QA/CQA Approval',
            'Closed - Done'
        ];

        $data = collect($statuses)->mapWithKeys(function ($status) {
            $count = \DB::table('global_capas')
                ->where('status', $status)
                ->count();

            return [$status => $count];
        });

        return response()->json($data);
    }
    /*********** Global Capa ************/



    /*********** Audit Program ************/
    public function getAuditProgramInitialCategorization()
    {
        $data = AuditProgram::select('initial_categorization', \DB::raw('count(*) as count'))
            ->groupBy('initial_categorization')  // Group by Initial_Categorization
            ->get(); // Fetch the grouped data

        // Prepare data in the form of an associative array
        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->initial_categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->initial_categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->initial_categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getAuditProgramPostCategorization()
    {
        $data = AuditProgram::select('Post_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Post_Categorization')
            ->get();

        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->Post_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getOnTimeVsDelayedRecordsAuditProgram()
    {
        $today = \Carbon\Carbon::today();

        $onTime = \DB::table('audit_programs')
            ->where('due_date', '>=', $today)
            ->where('status', 'Closed - Done')
            ->count();

        $delayed = \DB::table('audit_programs')
            ->where('due_date', '<', $today)
            ->where('status', '!=', 'Closed - Done')
            ->count();

        return response()->json([
            'On Time' => $onTime,
            'Delayed' => $delayed,
        ]);
    }

    public function getAuditProgramByDivision()
    {
        $data = \DB::table('q_m_s_divisions')
            ->leftJoin('audit_programs', 'audit_programs.division_id', '=', 'q_m_s_divisions.id')
            ->select('q_m_s_divisions.name as division_name', \DB::raw('COUNT(audit_programs.id) as count'))
            ->groupBy('q_m_s_divisions.id', 'q_m_s_divisions.name')
            ->orderBy('q_m_s_divisions.name')
            ->get();

        return response()->json($data);
    }

    public function getAuditProgramPriorityData()
    {
        $data = AuditProgram::select('priority_data', \DB::raw('count(*) as count'))
            ->groupBy('priority_data')
            ->get();

        $deviationData = [
            'High' => 0,
            'Medium' => 0,
            'Low' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->priority_data == 'High') {
                $deviationData['High'] = $entry->count;
            } elseif ($entry->priority_data == 'Medium') {
                $deviationData['Medium'] = $entry->count;
            } elseif ($entry->priority_data == 'Low') {
                $deviationData['Low'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getAuditProgramByStatus()
    {
        $statuses = [
            'Opened',
            'HOD Review',
            'QA/CQA Review',
            'QA/CQA Approval',
            'CAPA In progress',
            'HOD Final Review',
            'QA/CQA Closure Review',
            'QA/CQA Approval',
            'Closed - Done'
        ];

        $data = collect($statuses)->mapWithKeys(function ($status) {
            $count = \DB::table('audit_programs')
                ->where('status', $status)
                ->count();

            return [$status => $count];
        });

        return response()->json($data);
    }
    /*********** Audit Program ************/



    /*********** Calibration Management ************/
    public function getCalibrationManagementInitialCategorization()
    {
        $data = CallibrationDetails::select('Initial_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Initial_Categorization')  // Group by Initial_Categorization
            ->get(); // Fetch the grouped data

        // Prepare data in the form of an associative array
        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->Initial_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Initial_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Initial_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getCalibrationManagementPostCategorization()
    {
        $data = CallibrationDetails::select('Post_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Post_Categorization')
            ->get();

        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->Post_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getOnTimeVsDelayedRecordsCalibrationManagement()
    {
        $today = \Carbon\Carbon::today();

        $onTime = \DB::table('callibration_details')
            ->where('due_date', '>=', $today)
            ->where('status', 'Closed - Done')
            ->count();

        $delayed = \DB::table('callibration_details')
            ->where('due_date', '<', $today)
            ->where('status', '!=', 'Closed - Done')
            ->count();

        return response()->json([
            'On Time' => $onTime,
            'Delayed' => $delayed,
        ]);
    }

    public function getCalibrationManagementByDivision()
    {
        $data = \DB::table('q_m_s_divisions')
            ->leftJoin('callibration_details', 'callibration_details.division_id', '=', 'q_m_s_divisions.id')
            ->select('q_m_s_divisions.name as division_name', \DB::raw('COUNT(callibration_details.id) as count'))
            ->groupBy('q_m_s_divisions.id', 'q_m_s_divisions.name')
            ->orderBy('q_m_s_divisions.name')
            ->get();

        return response()->json($data);
    }

    public function getCalibrationManagementPriorityData()
    {
        $data = CallibrationDetails::select('priority_data', \DB::raw('count(*) as count'))
            ->groupBy('priority_data')
            ->get();

        $deviationData = [
            'High' => 0,
            'Medium' => 0,
            'Low' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->priority_data == 'High') {
                $deviationData['High'] = $entry->count;
            } elseif ($entry->priority_data == 'Medium') {
                $deviationData['Medium'] = $entry->count;
            } elseif ($entry->priority_data == 'Low') {
                $deviationData['Low'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getCalibrationManagementByStatus()
    {
        $statuses = [
            'Opened',
            'HOD Review',
            'QA/CQA Review',
            'QA/CQA Approval',
            'CAPA In progress',
            'HOD Final Review',
            'QA/CQA Closure Review',
            'QA/CQA Approval',
            'Closed - Done'
        ];

        $data = collect($statuses)->mapWithKeys(function ($status) {
            $count = \DB::table('callibration_details')
                ->where('status', $status)
                ->count();

            return [$status => $count];
        });

        return response()->json($data);
    }
    /*********** Calibration Management ************/


    /*********** Effectiveness Check ************/
    public function getEffectivenessCheckInitialCategorization()
    {
        $data = EffectivenessCheck::select('Initial_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Initial_Categorization')  // Group by Initial_Categorization
            ->get(); // Fetch the grouped data

        // Prepare data in the form of an associative array
        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->Initial_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Initial_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Initial_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getEffectivenessCheckPostCategorization()
    {
        $data = EffectivenessCheck::select('Post_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Post_Categorization')
            ->get();

        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->Post_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getOnTimeVsDelayedRecordsEffectivenessCheck()
    {
        $today = \Carbon\Carbon::today();

        $onTime = \DB::table('effectiveness_checks')
            ->where('due_date', '>=', $today)
            ->where('status', 'Closed - Done')
            ->count();

        $delayed = \DB::table('effectiveness_checks')
            ->where('due_date', '<', $today)
            ->where('status', '!=', 'Closed - Done')
            ->count();

        return response()->json([
            'On Time' => $onTime,
            'Delayed' => $delayed,
        ]);
    }

    public function getEffectivenessCheckByDivision()
    {
        $data = \DB::table('q_m_s_divisions')
            ->leftJoin('effectiveness_checks', 'effectiveness_checks.division_id', '=', 'q_m_s_divisions.id')
            ->select('q_m_s_divisions.name as division_name', \DB::raw('COUNT(effectiveness_checks.id) as count'))
            ->groupBy('q_m_s_divisions.id', 'q_m_s_divisions.name')
            ->orderBy('q_m_s_divisions.name')
            ->get();

        return response()->json($data);
    }

    public function getEffectivenessCheckPriorityData()
    {
        $data = EffectivenessCheck::select('priority_data', \DB::raw('count(*) as count'))
            ->groupBy('priority_data')
            ->get();

        $deviationData = [
            'High' => 0,
            'Medium' => 0,
            'Low' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->priority_data == 'High') {
                $deviationData['High'] = $entry->count;
            } elseif ($entry->priority_data == 'Medium') {
                $deviationData['Medium'] = $entry->count;
            } elseif ($entry->priority_data == 'Low') {
                $deviationData['Low'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getEffectivenessCheckByStatus()
    {
        $statuses = [
            'Opened',
            'HOD Review',
            'QA/CQA Review',
            'QA/CQA Approval',
            'CAPA In progress',
            'HOD Final Review',
            'QA/CQA Closure Review',
            'QA/CQA Approval',
            'Closed - Done'
        ];

        $data = collect($statuses)->mapWithKeys(function ($status) {
            $count = \DB::table('effectiveness_checks')
                ->where('status', $status)
                ->count();

            return [$status => $count];
        });

        return response()->json($data);
    }
    /*********** effectiveness_checks endss ************/


    /*********** Supplier Audit ************/
    public function getSupplierAuditInitialCategorization()
    {
        $data = SupplierAudit::select('Initial_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Initial_Categorization')  // Group by Initial_Categorization
            ->get(); // Fetch the grouped data

        // Prepare data in the form of an associative array
        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->Initial_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Initial_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Initial_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getSupplierAuditPostCategorization()
    {
        $data = SupplierAudit::select('Post_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Post_Categorization')
            ->get();

        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->Post_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getOnTimeVsDelayedRecordsSupplierAudit()
    {
        $today = \Carbon\Carbon::today();

        $onTime = \DB::table('supplier_audits')
            ->where('due_date', '>=', $today)
            ->where('status', 'Closed - Done')
            ->count();

        $delayed = \DB::table('supplier_audits')
            ->where('due_date', '<', $today)
            ->where('status', '!=', 'Closed - Done')
            ->count();

        return response()->json([
            'On Time' => $onTime,
            'Delayed' => $delayed,
        ]);
    }

    public function getSupplierAuditByDivision()
    {
        $data = \DB::table('q_m_s_divisions')
            ->leftJoin('supplier_audits', 'supplier_audits.division_id', '=', 'q_m_s_divisions.id')
            ->select('q_m_s_divisions.name as division_name', \DB::raw('COUNT(supplier_audits.id) as count'))
            ->groupBy('q_m_s_divisions.id', 'q_m_s_divisions.name')
            ->orderBy('q_m_s_divisions.name')
            ->get();

        return response()->json($data);
    }

    public function getSupplierAuditPriorityData()
    {
        $data = SupplierAudit::select('priority_data', \DB::raw('count(*) as count'))
            ->groupBy('priority_data')
            ->get();

        $deviationData = [
            'High' => 0,
            'Medium' => 0,
            'Low' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->priority_data == 'High') {
                $deviationData['High'] = $entry->count;
            } elseif ($entry->priority_data == 'Medium') {
                $deviationData['Medium'] = $entry->count;
            } elseif ($entry->priority_data == 'Low') {
                $deviationData['Low'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getSupplierAuditByStatus()
    {
        $statuses = [
            'Opened',
            'HOD Review',
            'QA/CQA Review',
            'QA/CQA Approval',
            'CAPA In progress',
            'HOD Final Review',
            'QA/CQA Closure Review',
            'QA/CQA Approval',
            'Closed - Done'
        ];

        $data = collect($statuses)->mapWithKeys(function ($status) {
            $count = \DB::table('supplier_audits')
                ->where('status', $status)
                ->count();

            return [$status => $count];
        });

        return response()->json($data);
    }
    /*********** Supplier Audit endss ************/


    /*********** Supplier ************/
    public function getSupplierInitialCategorization()
    {
        $data = Supplier::select('Initial_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Initial_Categorization')  // Group by Initial_Categorization
            ->get(); // Fetch the grouped data

        // Prepare data in the form of an associative array
        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->Initial_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Initial_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Initial_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getSupplierPostCategorization()
    {
        $data = Supplier::select('Post_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Post_Categorization')
            ->get();

        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->Post_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getOnTimeVsDelayedRecordsSupplier()
    {
        $today = \Carbon\Carbon::today();

        $onTime = \DB::table('suppliers')
            ->where('due_date', '>=', $today)
            ->where('status', 'Closed - Done')
            ->count();

        $delayed = \DB::table('suppliers')
            ->where('due_date', '<', $today)
            ->where('status', '!=', 'Closed - Done')
            ->count();

        return response()->json([
            'On Time' => $onTime,
            'Delayed' => $delayed,
        ]);
    }

    public function getSupplierByDivision()
    {
        $data = \DB::table('q_m_s_divisions')
            ->leftJoin('suppliers', 'suppliers.division_id', '=', 'q_m_s_divisions.id')
            ->select('q_m_s_divisions.name as division_name', \DB::raw('COUNT(suppliers.id) as count'))
            ->groupBy('q_m_s_divisions.id', 'q_m_s_divisions.name')
            ->orderBy('q_m_s_divisions.name')
            ->get();

        return response()->json($data);
    }

    public function getSupplierPriorityData()
    {
        $data = Supplier::select('priority_data', \DB::raw('count(*) as count'))
            ->groupBy('priority_data')
            ->get();

        $deviationData = [
            'High' => 0,
            'Medium' => 0,
            'Low' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->priority_data == 'High') {
                $deviationData['High'] = $entry->count;
            } elseif ($entry->priority_data == 'Medium') {
                $deviationData['Medium'] = $entry->count;
            } elseif ($entry->priority_data == 'Low') {
                $deviationData['Low'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getSupplierByStatus()
    {
        $statuses = [
            'Opened',
            'HOD Review',
            'QA/CQA Review',
            'QA/CQA Approval',
            'CAPA In progress',
            'HOD Final Review',
            'QA/CQA Closure Review',
            'QA/CQA Approval',
            'Closed - Done'
        ];

        $data = collect($statuses)->mapWithKeys(function ($status) {
            $count = \DB::table('suppliers')
                ->where('status', $status)
                ->count();

            return [$status => $count];
        });

        return response()->json($data);
    }
    /*********** Supplier endss ************/


    /*********** Sanction ************/
    public function getSanctionInitialCategorization()
    {
        $data = Sanction::select('Initial_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Initial_Categorization')  // Group by Initial_Categorization
            ->get(); // Fetch the grouped data

        // Prepare data in the form of an associative array
        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->Initial_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Initial_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Initial_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getSanctionPostCategorization()
    {
        $data = Sanction::select('Post_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Post_Categorization')
            ->get();

        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->Post_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getOnTimeVsDelayedRecordsSanction()
    {
        $today = \Carbon\Carbon::today();

        $onTime = \DB::table('sanctions')
            ->where('due_date', '>=', $today)
            ->where('status', 'Closed - Done')
            ->count();

        $delayed = \DB::table('sanctions')
            ->where('due_date', '<', $today)
            ->where('status', '!=', 'Closed - Done')
            ->count();

        return response()->json([
            'On Time' => $onTime,
            'Delayed' => $delayed,
        ]);
    }

    public function getSanctionByDivision()
    {
        $data = \DB::table('q_m_s_divisions')
            ->leftJoin('sanctions', 'sanctions.division_id', '=', 'q_m_s_divisions.id')
            ->select('q_m_s_divisions.name as division_name', \DB::raw('COUNT(sanctions.id) as count'))
            ->groupBy('q_m_s_divisions.id', 'q_m_s_divisions.name')
            ->orderBy('q_m_s_divisions.name')
            ->get();

        return response()->json($data);
    }

    public function getSanctionPriorityData()
    {
        $data = Sanction::select('priority_data', \DB::raw('count(*) as count'))
            ->groupBy('priority_data')
            ->get();

        $deviationData = [
            'High' => 0,
            'Medium' => 0,
            'Low' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->priority_data == 'High') {
                $deviationData['High'] = $entry->count;
            } elseif ($entry->priority_data == 'Medium') {
                $deviationData['Medium'] = $entry->count;
            } elseif ($entry->priority_data == 'Low') {
                $deviationData['Low'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getSanctionByStatus()
    {
        $statuses = [
            'Opened',
            'HOD Review',
            'QA/CQA Review',
            'QA/CQA Approval',
            'CAPA In progress',
            'HOD Final Review',
            'QA/CQA Closure Review',
            'QA/CQA Approval',
            'Closed - Done'
        ];

        $data = collect($statuses)->mapWithKeys(function ($status) {
            $count = \DB::table('sanctions')
                ->where('status', $status)
                ->count();

            return [$status => $count];
        });

        return response()->json($data);
    }
    /*********** Sanction endss ************/



    /*********** Root Cause Analysis ************/
    public function getRootCauseAnalysisInitialCategorization()
    {
        $data = RootCauseAnalysis::select('Initial_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Initial_Categorization')  // Group by Initial_Categorization
            ->get(); // Fetch the grouped data

        // Prepare data in the form of an associative array
        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->Initial_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Initial_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Initial_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getRootCauseAnalysisPostCategorization()
    {
        $data = RootCauseAnalysis::select('Post_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Post_Categorization')
            ->get();

        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->Post_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getOnTimeVsDelayedRecordsRootCauseAnalysis()
    {
        $today = \Carbon\Carbon::today();

        $onTime = \DB::table('root_cause_analyses')
            ->where('due_date', '>=', $today)
            ->where('status', 'Closed - Done')
            ->count();

        $delayed = \DB::table('root_cause_analyses')
            ->where('due_date', '<', $today)
            ->where('status', '!=', 'Closed - Done')
            ->count();

        return response()->json([
            'On Time' => $onTime,
            'Delayed' => $delayed,
        ]);
    }

    public function getRootCauseAnalysisByDivision()
    {
        $data = \DB::table('q_m_s_divisions')
            ->leftJoin('root_cause_analyses', 'root_cause_analyses.division_id', '=', 'q_m_s_divisions.id')
            ->select('q_m_s_divisions.name as division_name', \DB::raw('COUNT(root_cause_analyses.id) as count'))
            ->groupBy('q_m_s_divisions.id', 'q_m_s_divisions.name')
            ->orderBy('q_m_s_divisions.name')
            ->get();

        return response()->json($data);
    }

    public function getRootCauseAnalysisPriorityData()
    {
        $data = RootCauseAnalysis::select('priority_data', \DB::raw('count(*) as count'))
            ->groupBy('priority_data')
            ->get();

        $deviationData = [
            'High' => 0,
            'Medium' => 0,
            'Low' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->priority_data == 'High') {
                $deviationData['High'] = $entry->count;
            } elseif ($entry->priority_data == 'Medium') {
                $deviationData['Medium'] = $entry->count;
            } elseif ($entry->priority_data == 'Low') {
                $deviationData['Low'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getRootCauseAnalysisByStatus()
    {
        $statuses = [
            'Opened',
            'HOD Review',
            'QA/CQA Review',
            'QA/CQA Approval',
            'CAPA In progress',
            'HOD Final Review',
            'QA/CQA Closure Review',
            'QA/CQA Approval',
            'Closed - Done'
        ];

        $data = collect($statuses)->mapWithKeys(function ($status) {
            $count = \DB::table('root_cause_analyses')
                ->where('status', $status)
                ->count();

            return [$status => $count];
        });

        return response()->json($data);
    }
    /*********** RootCauseAnalysis endss ************/


    /*********** Risk Assessment ************/
    public function getRiskAssessmentInitialCategorization()
    {
        $data = RiskManagement::select('initial_categorization', \DB::raw('count(*) as count'))
            ->groupBy('initial_categorization')  // Group by Initial_Categorization
            ->get(); // Fetch the grouped data

        // Prepare data in the form of an associative array
        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->initial_categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->initial_categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->initial_categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getRiskAssessmentPostCategorization()
    {
        $data = RiskManagement::select('Post_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Post_Categorization')
            ->get();

        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->Post_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getOnTimeVsDelayedRecordsRiskAssessment()
    {
        $today = \Carbon\Carbon::today();

        $onTime = \DB::table('risk_management')
            ->where('due_date', '>=', $today)
            ->where('status', 'Closed - Done')
            ->count();

        $delayed = \DB::table('risk_management')
            ->where('due_date', '<', $today)
            ->where('status', '!=', 'Closed - Done')
            ->count();

        return response()->json([
            'On Time' => $onTime,
            'Delayed' => $delayed,
        ]);
    }

    public function getRiskAssessmentByDivision()
    {
        $data = \DB::table('q_m_s_divisions')
            ->leftJoin('risk_management', 'risk_management.division_id', '=', 'q_m_s_divisions.id')
            ->select('q_m_s_divisions.name as division_name', \DB::raw('COUNT(risk_management.id) as count'))
            ->groupBy('q_m_s_divisions.id', 'q_m_s_divisions.name')
            ->orderBy('q_m_s_divisions.name')
            ->get();

        return response()->json($data);
    }

    public function getRiskAssessmentPriorityData()
    {
        $data = RiskManagement::select('priority_data', \DB::raw('count(*) as count'))
            ->groupBy('priority_data')
            ->get();

        $deviationData = [
            'High' => 0,
            'Medium' => 0,
            'Low' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->priority_data == 'High') {
                $deviationData['High'] = $entry->count;
            } elseif ($entry->priority_data == 'Medium') {
                $deviationData['Medium'] = $entry->count;
            } elseif ($entry->priority_data == 'Low') {
                $deviationData['Low'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getRiskAssessmentByStatus()
    {
        $statuses = [
            'Opened',
            'HOD Review',
            'QA/CQA Review',
            'QA/CQA Approval',
            'CAPA In progress',
            'HOD Final Review',
            'QA/CQA Closure Review',
            'QA/CQA Approval',
            'Closed - Done'
        ];

        $data = collect($statuses)->mapWithKeys(function ($status) {
            $count = \DB::table('risk_management')
                ->where('status', $status)
                ->count();

            return [$status => $count];
        });

        return response()->json($data);
    }
    /*********** Risk Assessment endss ************/


    /*********** Preventive Maintenance ************/
    public function getPreventiveMaintenanceInitialCategorization()
    {
        $data = PreventiveMaintenance::select('Initial_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Initial_Categorization')  // Group by Initial_Categorization
            ->get(); // Fetch the grouped data

        // Prepare data in the form of an associative array
        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->Initial_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Initial_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Initial_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getPreventiveMaintenancePostCategorization()
    {
        $data = PreventiveMaintenance::select('Post_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Post_Categorization')
            ->get();

        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->Post_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getOnTimeVsDelayedRecordsPreventiveMaintenance()
    {
        $today = \Carbon\Carbon::today();

        $onTime = \DB::table('preventive_maintenances')
            ->where('due_date', '>=', $today)
            ->where('status', 'Closed - Done')
            ->count();

        $delayed = \DB::table('preventive_maintenances')
            ->where('due_date', '<', $today)
            ->where('status', '!=', 'Closed - Done')
            ->count();

        return response()->json([
            'On Time' => $onTime,
            'Delayed' => $delayed,
        ]);
    }

    public function getPreventiveMaintenanceByDivision()
    {
        $data = \DB::table('q_m_s_divisions')
            ->leftJoin('preventive_maintenances', 'preventive_maintenances.division_id', '=', 'q_m_s_divisions.id')
            ->select('q_m_s_divisions.name as division_name', \DB::raw('COUNT(preventive_maintenances.id) as count'))
            ->groupBy('q_m_s_divisions.id', 'q_m_s_divisions.name')
            ->orderBy('q_m_s_divisions.name')
            ->get();

        return response()->json($data);
    }

    public function getPreventiveMaintenancePriorityData()
    {
        $data = PreventiveMaintenance::select('priority_data', \DB::raw('count(*) as count'))
            ->groupBy('priority_data')
            ->get();

        $deviationData = [
            'High' => 0,
            'Medium' => 0,
            'Low' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->priority_data == 'High') {
                $deviationData['High'] = $entry->count;
            } elseif ($entry->priority_data == 'Medium') {
                $deviationData['Medium'] = $entry->count;
            } elseif ($entry->priority_data == 'Low') {
                $deviationData['Low'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getPreventiveMaintenanceByStatus()
    {
        $statuses = [
            'Opened',
            'HOD Review',
            'QA/CQA Review',
            'QA/CQA Approval',
            'CAPA In progress',
            'HOD Final Review',
            'QA/CQA Closure Review',
            'QA/CQA Approval',
            'Closed - Done'
        ];

        $data = collect($statuses)->mapWithKeys(function ($status) {
            $count = \DB::table('preventive_maintenances')
                ->where('status', $status)
                ->count();

            return [$status => $count];
        });

        return response()->json($data);
    }
    /*********** Preventive Maintenance endss ************/


    /*********** Incident ************/
    public function getIncidentInitialCategorization()
    {
        $data = Incident::select('Initial_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Initial_Categorization')  // Group by Initial_Categorization
            ->get(); // Fetch the grouped data

        // Prepare data in the form of an associative array
        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->Initial_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Initial_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Initial_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getIncidentPostCategorization()
    {
        $data = Incident::select('Post_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Post_Categorization')
            ->get();

        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->Post_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getOnTimeVsDelayedRecordsIncident()
    {
        $today = \Carbon\Carbon::today();

        $onTime = \DB::table('incidents')
            ->where('due_date', '>=', $today)
            ->where('status', 'Closed - Done')
            ->count();

        $delayed = \DB::table('incidents')
            ->where('due_date', '<', $today)
            ->where('status', '!=', 'Closed - Done')
            ->count();

        return response()->json([
            'On Time' => $onTime,
            'Delayed' => $delayed,
        ]);
    }

    public function getIncidentByDivision()
    {
        $data = \DB::table('q_m_s_divisions')
            ->leftJoin('incidents', 'incidents.division_id', '=', 'q_m_s_divisions.id')
            ->select('q_m_s_divisions.name as division_name', \DB::raw('COUNT(incidents.id) as count'))
            ->groupBy('q_m_s_divisions.id', 'q_m_s_divisions.name')
            ->orderBy('q_m_s_divisions.name')
            ->get();

        return response()->json($data);
    }

    public function getIncidentPriorityData()
    {
        $data = Incident::select('priority_data', \DB::raw('count(*) as count'))
            ->groupBy('priority_data')
            ->get();

        $deviationData = [
            'High' => 0,
            'Medium' => 0,
            'Low' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->priority_data == 'High') {
                $deviationData['High'] = $entry->count;
            } elseif ($entry->priority_data == 'Medium') {
                $deviationData['Medium'] = $entry->count;
            } elseif ($entry->priority_data == 'Low') {
                $deviationData['Low'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getIncidentByStatus()
    {
        $statuses = [
            'Opened',
            'HOD Review',
            'QA/CQA Review',
            'QA/CQA Approval',
            'CAPA In progress',
            'HOD Final Review',
            'QA/CQA Closure Review',
            'QA/CQA Approval',
            'Closed - Done'
        ];

        $data = collect($statuses)->mapWithKeys(function ($status) {
            $count = \DB::table('incidents')
                ->where('status', $status)
                ->count();

            return [$status => $count];
        });

        return response()->json($data);
    }
    /*********** Incidents endss ************/



    /*********** Lab Incident ************/
    public function getLabIncidentInitialCategorization()
    {
        $data = LabIncident::select('Initial_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Initial_Categorization')  // Group by Initial_Categorization
            ->get(); // Fetch the grouped data

        // Prepare data in the form of an associative array
        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->Initial_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Initial_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Initial_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getLabIncidentPostCategorization()
    {
        $data = LabIncident::select('Post_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Post_Categorization')
            ->get();

        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->Post_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getOnTimeVsDelayedRecordsLabIncident()
    {
        $today = \Carbon\Carbon::today();

        $onTime = \DB::table('lab_incidents')
            ->where('due_date', '>=', $today)
            ->where('status', 'Closed - Done')
            ->count();

        $delayed = \DB::table('lab_incidents')
            ->where('due_date', '<', $today)
            ->where('status', '!=', 'Closed - Done')
            ->count();

        return response()->json([
            'On Time' => $onTime,
            'Delayed' => $delayed,
        ]);
    }

    public function getLabIncidentByDivision()
    {
        $data = \DB::table('q_m_s_divisions')
            ->leftJoin('lab_incidents', 'lab_incidents.division_id', '=', 'q_m_s_divisions.id')
            ->select('q_m_s_divisions.name as division_name', \DB::raw('COUNT(lab_incidents.id) as count'))
            ->groupBy('q_m_s_divisions.id', 'q_m_s_divisions.name')
            ->orderBy('q_m_s_divisions.name')
            ->get();

        return response()->json($data);
    }

    public function getLabIncidentPriorityData()
    {
        $data = LabIncident::select('priority_data', \DB::raw('count(*) as count'))
            ->groupBy('priority_data')
            ->get();

        $deviationData = [
            'High' => 0,
            'Medium' => 0,
            'Low' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->priority_data == 'High') {
                $deviationData['High'] = $entry->count;
            } elseif ($entry->priority_data == 'Medium') {
                $deviationData['Medium'] = $entry->count;
            } elseif ($entry->priority_data == 'Low') {
                $deviationData['Low'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getLabIncidentByStatus()
    {
        $statuses = [
            'Opened',
            'HOD Review',
            'QA/CQA Review',
            'QA/CQA Approval',
            'CAPA In progress',
            'HOD Final Review',
            'QA/CQA Closure Review',
            'QA/CQA Approval',
            'Closed - Done'
        ];

        $data = collect($statuses)->mapWithKeys(function ($status) {
            $count = \DB::table('lab_incidents')
                ->where('status', $status)
                ->count();

            return [$status => $count];
        });

        return response()->json($data);
    }
    /*********** Lab Incidents endss ************/



    /*********** Internal Audits ************/
    public function getInternalAuditInitialCategorization()
    {
        $data = InternalAudit::select('Initial_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Initial_Categorization')  // Group by Initial_Categorization
            ->get(); // Fetch the grouped data

        // Prepare data in the form of an associative array
        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->Initial_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Initial_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Initial_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getInternalAuditPostCategorization()
    {
        $data = InternalAudit::select('Post_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Post_Categorization')
            ->get();

        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->Post_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getOnTimeVsDelayedRecordsInternalAudit()
    {
        $today = \Carbon\Carbon::today();

        $onTime = \DB::table('internal_audits')
            ->where('due_date', '>=', $today)
            ->where('status', 'Closed - Done')
            ->count();

        $delayed = \DB::table('internal_audits')
            ->where('due_date', '<', $today)
            ->where('status', '!=', 'Closed - Done')
            ->count();

        return response()->json([
            'On Time' => $onTime,
            'Delayed' => $delayed,
        ]);
    }

    public function getInternalAuditByDivision()
    {
        $data = \DB::table('q_m_s_divisions')
            ->leftJoin('internal_audits', 'internal_audits.division_id', '=', 'q_m_s_divisions.id')
            ->select('q_m_s_divisions.name as division_name', \DB::raw('COUNT(internal_audits.id) as count'))
            ->groupBy('q_m_s_divisions.id', 'q_m_s_divisions.name')
            ->orderBy('q_m_s_divisions.name')
            ->get();

        return response()->json($data);
    }

    public function getInternalAuditPriorityData()
    {
        $data = InternalAudit::select('priority_data', \DB::raw('count(*) as count'))
            ->groupBy('priority_data')
            ->get();

        $deviationData = [
            'High' => 0,
            'Medium' => 0,
            'Low' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->priority_data == 'High') {
                $deviationData['High'] = $entry->count;
            } elseif ($entry->priority_data == 'Medium') {
                $deviationData['Medium'] = $entry->count;
            } elseif ($entry->priority_data == 'Low') {
                $deviationData['Low'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getInternalAuditByStatus()
    {
        $statuses = [
            'Opened',
            'HOD Review',
            'QA/CQA Review',
            'QA/CQA Approval',
            'CAPA In progress',
            'HOD Final Review',
            'QA/CQA Closure Review',
            'QA/CQA Approval',
            'Closed - Done'
        ];

        $data = collect($statuses)->mapWithKeys(function ($status) {
            $count = \DB::table('internal_audits')
                ->where('status', $status)
                ->count();

            return [$status => $count];
        });

        return response()->json($data);
    }
    /*********** Internal Audit endss ************/



    /*********** External Audits ************/
    public function getExternalAuditInitialCategorization()
    {
        $data = Auditee::select('initial_categorization', \DB::raw('count(*) as count'))
            ->groupBy('initial_categorization')  // Group by Initial_Categorization
            ->get(); // Fetch the grouped data

        // Prepare data in the form of an associative array
        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->initial_categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->initial_categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->initial_categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getExternalAuditPostCategorization()
    {
        $data = Auditee::select('Post_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Post_Categorization')
            ->get();

        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->Post_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getOnTimeVsDelayedRecordsExternalAudit()
    {
        $today = \Carbon\Carbon::today();

        $onTime = \DB::table('auditees')
            ->where('due_date', '>=', $today)
            ->where('status', 'Closed - Done')
            ->count();

        $delayed = \DB::table('auditees')
            ->where('due_date', '<', $today)
            ->where('status', '!=', 'Closed - Done')
            ->count();

        return response()->json([
            'On Time' => $onTime,
            'Delayed' => $delayed,
        ]);
    }

    public function getExternalAuditByDivision()
    {
        $data = \DB::table('q_m_s_divisions')
            ->leftJoin('auditees', 'auditees.division_id', '=', 'q_m_s_divisions.id')
            ->select('q_m_s_divisions.name as division_name', \DB::raw('COUNT(auditees.id) as count'))
            ->groupBy('q_m_s_divisions.id', 'q_m_s_divisions.name')
            ->orderBy('q_m_s_divisions.name')
            ->get();

        return response()->json($data);
    }

    public function getExternalAuditPriorityData()
    {
        $data = Auditee::select('priority_data', \DB::raw('count(*) as count'))
            ->groupBy('priority_data')
            ->get();

        $deviationData = [
            'High' => 0,
            'Medium' => 0,
            'Low' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->priority_data == 'High') {
                $deviationData['High'] = $entry->count;
            } elseif ($entry->priority_data == 'Medium') {
                $deviationData['Medium'] = $entry->count;
            } elseif ($entry->priority_data == 'Low') {
                $deviationData['Low'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getExternalAuditByStatus()
    {
        $statuses = [
            'Opened',
            'HOD Review',
            'QA/CQA Review',
            'QA/CQA Approval',
            'CAPA In progress',
            'HOD Final Review',
            'QA/CQA Closure Review',
            'QA/CQA Approval',
            'Closed - Done'
        ];

        $data = collect($statuses)->mapWithKeys(function ($status) {
            $count = \DB::table('auditees')
                ->where('status', $status)
                ->count();

            return [$status => $count];
        });

        return response()->json($data);
    }
    /*********** External Audit endss ************/


    /*********** Errata ************/
        public function getErrataInitialCategorization()
        {
            $data = errata::select('initial_categorization', \DB::raw('count(*) as count'))
                ->groupBy('initial_categorization')  // Group by Initial_Categorization
                ->get(); // Fetch the grouped data
    
            // Prepare data in the form of an associative array
            $deviationData = [
                'Major' => 0,
                'Minor' => 0,
                'Critical' => 0
            ];
    
            // Loop through and map the counts to the categories
            foreach ($data as $entry) {
                if ($entry->initial_categorization == 'Major') {
                    $deviationData['Major'] = $entry->count;
                } elseif ($entry->initial_categorization == 'Minor') {
                    $deviationData['Minor'] = $entry->count;
                } elseif ($entry->initial_categorization == 'Critical') {
                    $deviationData['Critical'] = $entry->count;
                }
            }
    
            return response()->json($deviationData);
        }
    
        public function getErrataPostCategorization()
        {
            $data = errata::select('Post_Categorization', \DB::raw('count(*) as count'))
                ->groupBy('Post_Categorization')
                ->get();
    
            $deviationData = [
                'Major' => 0,
                'Minor' => 0,
                'Critical' => 0
            ];
    
            foreach ($data as $entry) {
                if ($entry->Post_Categorization == 'Major') {
                    $deviationData['Major'] = $entry->count;
                } elseif ($entry->Post_Categorization == 'Minor') {
                    $deviationData['Minor'] = $entry->count;
                } elseif ($entry->Post_Categorization == 'Critical') {
                    $deviationData['Critical'] = $entry->count;
                }
            }
    
            return response()->json($deviationData);
        }
    
        public function getOnTimeVsDelayedRecordsErrata()
        {
            $today = \Carbon\Carbon::today();
    
            $onTime = \DB::table('erratas')
                ->where('due_date', '>=', $today)
                ->where('status', 'Closed - Done')
                ->count();
    
            $delayed = \DB::table('erratas')
                ->where('due_date', '<', $today)
                ->where('status', '!=', 'Closed - Done')
                ->count();
    
            return response()->json([
                'On Time' => $onTime,
                'Delayed' => $delayed,
            ]);
        }
    
        public function getErrataByDivision()
        {
            $data = \DB::table('q_m_s_divisions')
                ->leftJoin('erratas', 'erratas.division_id', '=', 'q_m_s_divisions.id')
                ->select('q_m_s_divisions.name as division_name', \DB::raw('COUNT(erratas.id) as count'))
                ->groupBy('q_m_s_divisions.id', 'q_m_s_divisions.name')
                ->orderBy('q_m_s_divisions.name')
                ->get();
    
            return response()->json($data);
        }
    
        public function getErrataPriorityData()
        {
            $data = errata::select('priority_data', \DB::raw('count(*) as count'))
                ->groupBy('priority_data')
                ->get();
    
            $deviationData = [
                'High' => 0,
                'Medium' => 0,
                'Low' => 0
            ];
    
            foreach ($data as $entry) {
                if ($entry->priority_data == 'High') {
                    $deviationData['High'] = $entry->count;
                } elseif ($entry->priority_data == 'Medium') {
                    $deviationData['Medium'] = $entry->count;
                } elseif ($entry->priority_data == 'Low') {
                    $deviationData['Low'] = $entry->count;
                }
            }
    
            return response()->json($deviationData);
        }
    
        public function getErrataByStatus()
        {
            $statuses = [
                'Opened',
                'HOD Review',
                'QA/CQA Review',
                'QA/CQA Approval',
                'CAPA In progress',
                'HOD Final Review',
                'QA/CQA Closure Review',
                'QA/CQA Approval',
                'Closed - Done'
            ];
    
            $data = collect($statuses)->mapWithKeys(function ($status) {
                $count = \DB::table('erratas')
                    ->where('status', $status)
                    ->count();
    
                return [$status => $count];
            });
    
            return response()->json($data);
        }
        /*********** External Audit endss ************/
    



    /*********** ComplaintManagement ************/
    public function getComplaintManagementInitialCategorization()
    {
        $data = MarketComplaint::select('Initial_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Initial_Categorization')  // Group by Initial_Categorization
            ->get(); // Fetch the grouped data

        // Prepare data in the form of an associative array
        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        // Loop through and map the counts to the categories
        foreach ($data as $entry) {
            if ($entry->Initial_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Initial_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Initial_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getComplaintManagementPostCategorization()
    {
        $data = MarketComplaint::select('Post_Categorization', \DB::raw('count(*) as count'))
            ->groupBy('Post_Categorization')
            ->get();

        $deviationData = [
            'Major' => 0,
            'Minor' => 0,
            'Critical' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->Post_Categorization == 'Major') {
                $deviationData['Major'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Minor') {
                $deviationData['Minor'] = $entry->count;
            } elseif ($entry->Post_Categorization == 'Critical') {
                $deviationData['Critical'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getOnTimeVsDelayedRecordsComplaintManagement()
    {
        $today = \Carbon\Carbon::today();

        $onTime = \DB::table('marketcompalints')
            ->where('due_date_gi', '>=', $today)
            ->where('status', 'Closed - Done')
            ->count();

        $delayed = \DB::table('marketcompalints')
            ->where('due_date_gi', '<', $today)
            ->where('status', '!=', 'Closed - Done')
            ->count();

        return response()->json([
            'On Time' => $onTime,
            'Delayed' => $delayed,
        ]);
    }

    public function getComplaintManagementByDivision()
    {
        $data = \DB::table('q_m_s_divisions')
            ->leftJoin('marketcompalints', 'marketcompalints.division_id', '=', 'q_m_s_divisions.id')
            ->select('q_m_s_divisions.name as division_name', \DB::raw('COUNT(marketcompalints.id) as count'))
            ->groupBy('q_m_s_divisions.id', 'q_m_s_divisions.name')
            ->orderBy('q_m_s_divisions.name')
            ->get();

        return response()->json($data);
    }

    public function getComplaintManagementPriorityData()
    {
        $data = MarketComplaint::select('priority_data', \DB::raw('count(*) as count'))
            ->groupBy('priority_data')
            ->get();

        $deviationData = [
            'High' => 0,
            'Medium' => 0,
            'Low' => 0
        ];

        foreach ($data as $entry) {
            if ($entry->priority_data == 'High') {
                $deviationData['High'] = $entry->count;
            } elseif ($entry->priority_data == 'Medium') {
                $deviationData['Medium'] = $entry->count;
            } elseif ($entry->priority_data == 'Low') {
                $deviationData['Low'] = $entry->count;
            }
        }

        return response()->json($deviationData);
    }

    public function getComplaintManagementByStatus()
    {
        $statuses = [
            'Opened',
            'HOD Review',
            'QA/CQA Review',
            'QA/CQA Approval',
            'CAPA In progress',
            'HOD Final Review',
            'QA/CQA Closure Review',
            'QA/CQA Approval',
            'Closed - Done'
        ];

        $data = collect($statuses)->mapWithKeys(function ($status) {
            $count = \DB::table('marketcompalints')
                ->where('status', $status)
                ->count();

            return [$status => $count];
        });

        return response()->json($data);
    }
    /*********** ComplaintManagement endss ************/









   /******************************************************** ChangeControl********************************************/
   public function getChangecontrolInitialCategorization()
   {
       $data = CC::select('severity_level1', \DB::raw('count(*) as count'))
           ->groupBy('severity_level1')  // Group by severity_level1
           ->get(); // Fetch the grouped data

       // Prepare data in the form of an associative array
       $deviationData = [
           'Major' => 0,
           'Minor' => 0,
           'Critical' => 0
       ];

       // Loop through and map the counts to the categories
       foreach ($data as $entry) {
           if ($entry->severity_level1 == 'Major') {
               $deviationData['Major'] = $entry->count;
           } elseif ($entry->severity_level1 == 'Minor') {
               $deviationData['Minor'] = $entry->count;
           } elseif ($entry->severity_level1 == 'Critical') {
               $deviationData['Critical'] = $entry->count;
           }
       }

       return response()->json($deviationData);
   }

   public function getChangeControlPostCategorization()
   {
       $data = CC::select('bd_domestic', \DB::raw('count(*) as count'))
           ->groupBy('bd_domestic')
           ->get();

       $deviationData = [
           'Major' => 0,
           'Minor' => 0,
           'Critical' => 0
       ];

       foreach ($data as $entry) {
           if ($entry->bd_domestic == 'Major') {
               $deviationData['Major'] = $entry->count;
           } elseif ($entry->bd_domestic == 'Minor') {
               $deviationData['Minor'] = $entry->count;
           } elseif ($entry->bd_domestic == 'Critical') {
               $deviationData['Critical'] = $entry->count;
           }
       }

       return response()->json($deviationData);
   }

   public function getOnTimeVsDelayedRecordsChangeControl()
   {
       $today = \Carbon\Carbon::today();

       $onTime = \DB::table('c_c_s')
           ->where('due_date', '>=', $today)
           ->where('status', 'Closed - Done')
           ->count();

       $delayed = \DB::table('c_c_s')
           ->where('due_date', '<', $today)
           ->where('status', '!=', 'Closed - Done')
           ->count();

       return response()->json([
           'On Time' => $onTime,
           'Delayed' => $delayed,
       ]);
   }

   public function getChangeControlByDivision()
   {
       $data = \DB::table('q_m_s_divisions')
           ->leftJoin('c_c_s', 'c_c_s.division_id', '=', 'q_m_s_divisions.id')
           ->select('q_m_s_divisions.name as division_name', \DB::raw('COUNT(c_c_s.id) as count'))
           ->groupBy('q_m_s_divisions.id', 'q_m_s_divisions.name')
           ->orderBy('q_m_s_divisions.name')
           ->get();

       return response()->json($data);
   }

   public function getChangeControlPriorityData()
   {
       $data = CC::select('priority_data', \DB::raw('count(*) as count'))
           ->groupBy('priority_data')
           ->get();

       $deviationData = [
           'High' => 0,
           'Medium' => 0,
           'Low' => 0
       ];

       foreach ($data as $entry) {
           if ($entry->priority_data == 'High') {
               $deviationData['High'] = $entry->count;
           } elseif ($entry->priority_data == 'Medium') {
               $deviationData['Medium'] = $entry->count;
           } elseif ($entry->priority_data == 'Low') {
               $deviationData['Low'] = $entry->count;
           }
       }

       return response()->json($deviationData);
   }

   public function getChangeControlByStatus()
   {
       $statuses = [
           'Opened',
           'HOD Review',
           'QA/CQA Review',
           'QA/CQA Approval',
           'CAPA In progress',
           'HOD Final Review',
           'QA/CQA Closure Review',
           'QA/CQA Approval',
           'Closed - Done'
       ];

       $data = collect($statuses)->mapWithKeys(function ($status) {
           $count = \DB::table('c_c_s')
               ->where('status', $status)
               ->count();

           return [$status => $count];
       });

       return response()->json($data);
   }


//*********************************************Deviation****************************************************************** */


public function getDeviationInitialCategorization()
   {
       $data = Deviation::select('Initial_Categorization', \DB::raw('count(*) as count'))
           ->groupBy('Initial_Categorization')  // Group by Initial_Categorization
           ->get(); // Fetch the grouped data

       // Prepare data in the form of an associative array
       $deviationData = [
           'Major' => 0,
           'Minor' => 0,
           'Critical' => 0
       ];

       // Loop through and map the counts to the categories
       foreach ($data as $entry) {
           if ($entry->Initial_Categorization == 'Major') {
               $deviationData['Major'] = $entry->count;
           } elseif ($entry->Initial_Categorization == 'Minor') {
               $deviationData['Minor'] = $entry->count;
           } elseif ($entry->Initial_Categorization == 'Critical') {
               $deviationData['Critical'] = $entry->count;
           }
       }

       return response()->json($deviationData);
   }

   public function getDeviationPostCategorization()
   {
       $data = Deviation::select('Post_Categorization', \DB::raw('count(*) as count'))
           ->groupBy('Post_Categorization')
           ->get();

       $deviationData = [
           'Major' => 0,
           'Minor' => 0,
           'Critical' => 0
       ];

       foreach ($data as $entry) {
           if ($entry->Post_Categorization == 'Major') {
               $deviationData['Major'] = $entry->count;
           } elseif ($entry->Post_Categorization == 'Minor') {
               $deviationData['Minor'] = $entry->count;
           } elseif ($entry->Post_Categorization == 'Critical') {
               $deviationData['Critical'] = $entry->count;
           }
       }

       return response()->json($deviationData);
   }

   public function getOnTimeVsDelayedRecordsDeviation()
   {
       $today = \Carbon\Carbon::today();

       $onTime = \DB::table('deviations')
           ->where('due_date', '>=', $today)
           ->where('status', 'Closed - Done')
           ->count();

       $delayed = \DB::table('deviations')
           ->where('due_date', '<', $today)
           ->where('status', '!=', 'Closed - Done')
           ->count();

       return response()->json([
           'On Time' => $onTime,
           'Delayed' => $delayed,
       ]);
   }

   public function getDeviationByDivision()
   {
       $data = \DB::table('q_m_s_divisions')
           ->leftJoin('deviations', 'deviations.division_id', '=', 'q_m_s_divisions.id')
           ->select('q_m_s_divisions.name as division_name', \DB::raw('COUNT(deviations.id) as count'))
           ->groupBy('q_m_s_divisions.id', 'q_m_s_divisions.name')
           ->orderBy('q_m_s_divisions.name')
           ->get();

       return response()->json($data);
   }

   public function getDeviationPriorityData()
   {
       $data = Deviation::select('priority_data', \DB::raw('count(*) as count'))
           ->groupBy('priority_data')
           ->get();

       $deviationData = [
           'High' => 0,
           'Medium' => 0,
           'Low' => 0
       ];

       foreach ($data as $entry) {
           if ($entry->priority_data == 'High') {
               $deviationData['High'] = $entry->count;
           } elseif ($entry->priority_data == 'Medium') {
               $deviationData['Medium'] = $entry->count;
           } elseif ($entry->priority_data == 'Low') {
               $deviationData['Low'] = $entry->count;
           }
       }

       return response()->json($deviationData);
   }

   public function getDeviationByStatus()
   {
       $statuses = [
           'Opened',
           'HOD Review',
           'QA/CQA Review',
           'QA/CQA Approval',
           'CAPA In progress',
           'HOD Final Review',
           'QA/CQA Closure Review',
           'QA/CQA Approval',
           'Closed - Done'
       ];

       $data = collect($statuses)->mapWithKeys(function ($status) {
           $count = \DB::table('deviations')
               ->where('status', $status)
               ->count();

           return [$status => $count];
       });

       return response()->json($data);
   }


//************************************Action Item********************************** */





public function getActionItemPriorityData()
{
    $data = ActionItem::select('priority_data', \DB::raw('count(*) as count'))
        ->groupBy('priority_data')
        ->get();

    $deviationData = [
        'High' => 0,
        'Medium' => 0,
        'Low' => 0
    ];

    foreach ($data as $entry) {
        if ($entry->priority_data == 'High') {
            $deviationData['High'] = $entry->count;
        } elseif ($entry->priority_data == 'Medium') {
            $deviationData['Medium'] = $entry->count;
        } elseif ($entry->priority_data == 'Low') {
            $deviationData['Low'] = $entry->count;
        }
    }

    return response()->json($deviationData);
}








//************************************Action Item end********************************** */



//*********************************************Due Date Extension****************************************************************** */


public function getDuedateExtensionInitialCategorization()
   {
       $data = extension_new::select('Initial_Categorization', \DB::raw('count(*) as count'))
           ->groupBy('Initial_Categorization')  // Group by Initial_Categorization
           ->get(); // Fetch the grouped data

       // Prepare data in the form of an associative array
       $deviationData = [
           'Major' => 0,
           'Minor' => 0,
           'Critical' => 0
       ];

       // Loop through and map the counts to the categories
       foreach ($data as $entry) {
           if ($entry->Initial_Categorization == 'Major') {
               $deviationData['Major'] = $entry->count;
           } elseif ($entry->Initial_Categorization == 'Minor') {
               $deviationData['Minor'] = $entry->count;
           } elseif ($entry->Initial_Categorization == 'Critical') {
               $deviationData['Critical'] = $entry->count;
           }
       }

       return response()->json($deviationData);
   }

   public function getDuedateExtensionPostCategorization()
   {
       $data = extension_new::select('Post_Categorization', \DB::raw('count(*) as count'))
           ->groupBy('Post_Categorization')
           ->get();

       $deviationData = [
           'Major' => 0,
           'Minor' => 0,
           'Critical' => 0
       ];

       foreach ($data as $entry) {
           if ($entry->Post_Categorization == 'Major') {
               $deviationData['Major'] = $entry->count;
           } elseif ($entry->Post_Categorization == 'Minor') {
               $deviationData['Minor'] = $entry->count;
           } elseif ($entry->Post_Categorization == 'Critical') {
               $deviationData['Critical'] = $entry->count;
           }
       }

       return response()->json($deviationData);
   }

   public function getOnTimeVsDelayedRecordsDuedateExtension()
   {
       $today = \Carbon\Carbon::today();

       $onTime = \DB::table('extension_news')
           ->where('due_date', '>=', $today)
           ->where('status', 'Closed - Done')
           ->count();

       $delayed = \DB::table('extension_news')
           ->where('due_date', '<', $today)
           ->where('status', '!=', 'Closed - Done')
           ->count();

       return response()->json([
           'On Time' => $onTime,
           'Delayed' => $delayed,
       ]);
   }

 

   
   public function getDuedateExtensionByDivision()
   {
        $data = \DB::table('q_m_s_divisions')
        ->leftJoin('extension_news', 'extension_news.site_location_code', '=', 'q_m_s_divisions.id')
        ->select('q_m_s_divisions.name as division_name', \DB::raw('COUNT(extension_news.id) as count'))
        ->groupBy('q_m_s_divisions.id', 'q_m_s_divisions.name')
        ->orderBy('q_m_s_divisions.name')
        ->get();

      return response()->json($data);
   }

   public function getDuedateExtensionPriorityData()
   {
       $data = extension_new::select('priority_data', \DB::raw('count(*) as count'))
           ->groupBy('priority_data')
           ->get();

       $deviationData = [
           'High' => 0,
           'Medium' => 0,
           'Low' => 0
       ];

       foreach ($data as $entry) {
           if ($entry->priority_data == 'High') {
               $deviationData['High'] = $entry->count;
           } elseif ($entry->priority_data == 'Medium') {
               $deviationData['Medium'] = $entry->count;
           } elseif ($entry->priority_data == 'Low') {
               $deviationData['Low'] = $entry->count;
           }
       }

       return response()->json($deviationData);
   }

   public function getDuedateExtensionByStatus()
   {
       $statuses = [
           'Opened',
           'HOD Review',
           'QA/CQA Review',
           'QA/CQA Approval',
           'CAPA In progress',
           'HOD Final Review',
           'QA/CQA Closure Review',
           'QA/CQA Approval',
           'Closed - Done'
       ];

       $data = collect($statuses)->mapWithKeys(function ($status) {
           $count = \DB::table('extension_news')
               ->where('status', $status)
               ->count();

           return [$status => $count];
       });

       return response()->json($data);
   }


//************************************Due date extension ********************************** */

public function fetch_records_changecontroller()
{
    $data = CC::select(
            'id',
            'division_id',
            'record', 
            'intiation_date', 
            'Initiator_Group', 
            'severity_level1', 
            'short_description', 
            'due_date', 
            'closure_approved_on', 
            'status'
        )
        ->get();
        


    $cc_records = [];
    foreach ($data as $entry) {
        $cc_records[] = [
            'id' => $entry->id ? $entry->id : 'Data not available yet',
            
            'record' => ($entry->division ? $entry->division->name : '-') . 
                        '/CC/' . 
                        date('Y') . '/' . 
                        str_pad($entry->record, 4, '0', STR_PAD_LEFT),
            'intiation_date' => $entry->intiation_date ? $entry->intiation_date : 'Data not available yet',
            'Initiator_Group' => Helpers::getFullDepartmentName($entry->Initiator_Group) ? Helpers::getFullDepartmentName($entry->Initiator_Group) : 'Data not available yet',
            'severity_level1' => $entry->severity_level1 ? $entry->severity_level1 : 'Data not available yet',
            'short_description' => $entry->short_description ? $entry->short_description : 'Data not available yet',
            'due_date' => $entry->due_date ? $entry->due_date : 'Data not available yet',
            'closure_approved_on' => $entry->closure_approved_on ? $entry->closure_approved_on : 'Data not available yet',
            'status' => $entry->status ? $entry->status : 'Data not available yet'
        ];
    }

    return response()->json($cc_records);
}



public function fetch_records_deviation()
{
    $data = Deviation::select(
            'id',
            'division_id',
            'record', 
            'intiation_date', 
            'Initiator_Group', 
            'Deviation_category', 
            'short_description', 
            'due_date', 
            'QA_final_approved_on', 
            'status'
        )
        ->get(); 
        $deviations = [];
        
        foreach ($data as $entry) {
            $deviations[] = [
                'id' => $entry->id ? $entry->id : 'Data not available yet',
                'record' => ($entry->division ? $entry->division->name : '-') . 
                '/Dev/' . 
                date('Y') . '/' . 
                str_pad($entry->record, 4, '0', STR_PAD_LEFT),
                
            'intiation_date' => $entry->intiation_date 
                    ? \Carbon\Carbon::parse($entry->intiation_date)->format('d-M-Y') 
                    : 'Data not available yet',

            'Initiator_Group' => Helpers::getFullDepartmentName($entry->Initiator_Group) ? Helpers::getFullDepartmentName($entry->Initiator_Group) : 'Data not available yet' ,
            'Deviation_category' => $entry->Deviation_category ? $entry->Deviation_category : 'Data not available yet',
            'short_description' => $entry->short_description ? $entry->short_description : 'Data not available yet',
            'due_date' => $entry->due_date ? $entry->due_date : 'Data not available yet',
            'QA_final_approved_on' => $entry->QA_final_approved_on ? $entry->QA_final_approved_on : 'Data not available yet',
            'status' => $entry->status ? $entry->status : 'Data not available yet' 


        ];
    }
    


    return response()->json($deviations);
}


public function fetch_records_action()
{
    $data = ActionItem::select(
            'id',
            'division_id',
            'record', 
            'intiation_date', 
            'departments', 
            'priority_data', 
            'short_description', 
            'due_date', 
            'qa_varification_on', 
            'status'
        )
        ->get(); 
        $actionitem = [];
        
        foreach ($data as $entry) {
            $actionitem[] = [
                'id' => $entry->id ? $entry->id : 'Data not available yet',
                'record' => ($entry->division ? $entry->division->name : '-') . 
                '/Action/' . 
                date('Y') . '/' . 
                str_pad($entry->record, 4, '0', STR_PAD_LEFT),
                
            'intiation_date' => $entry->intiation_date 
                    ? \Carbon\Carbon::parse($entry->intiation_date)->format('d-M-Y') 
                    : 'Data not available yet',

            'departments' => Helpers::getFullDepartmentName($entry->departments) ? Helpers::getFullDepartmentName($entry->departments) : 'Data not available yet' ,
            'priority_data' => $entry->priority_data ? $entry->priority_data : 'Data not available yet',
            'short_description' => $entry->short_description,
            'due_date' => $entry->due_date,
            'qa_varification_on' => $entry->qa_varification_on,
            'status' => $entry->status


        ];
    }
    


    return response()->json($actionitem);
}


public function fetch_records_due_date_extension()
{
    $data = extension_new::select( 
            'id',
            'site_location_code',
            'record', 
            'initiation_date', 
            'initial_categorization', 
            'priority_data', 
            'short_description', 
            'current_due_date', 
            'cqa_approval_on', 
            'status'
        )
        ->get(); 
        $actionitem = [];
        
        foreach ($data as $entry) {
            $actionitem[] = [
                'id' => $entry->id ? $entry->id : 'Data not available yet',
                'record' => ($entry->division ? $entry->division->name : 'Data not available yet') . 
                '/Ext/' . 
                date('Y') . '/' . 
                str_pad($entry->record, 4, '0', STR_PAD_LEFT),
                
            'initiation_date' => $entry->initiation_date 
                    ? \Carbon\Carbon::parse($entry->initiation_date)->format('d-M-Y') 
                    : 'Data not available yet',

            'initial_categorization' => $entry->initial_categorization ? $entry->initial_categorization : 'Data not available yet' ,
            'priority_data' => $entry->priority_data ? $entry->priority_data : 'Data not available yet',
            'short_description' => $entry->short_description ? $entry->short_description : 'Data not available yet',
            'current_due_date' => $entry->current_due_date ? $entry->current_due_date : 'Data not available yet',
            'cqa_approval_on' => $entry->cqa_approval_on ? $entry->cqa_approval_on  : 'Data not available yet' ,
            'status' => $entry->status ? $entry->status : 'Data not available yet'


        ];
    }
    


    return response()->json($actionitem);
}


public function fetch_records_auditprogram()
{
    $data = AuditProgram::select( 
            'id',
            'division_id',
            'record', 
            'intiation_date', 
            'Initiator_Group', 
            'severity1_level', 
            'short_description', 
            'due_date', 
            'Audit_Completed_On', 
            'status'
        )
        ->get(); 
        $auditprogram = [];
        
        foreach ($data as $entry) {
            $auditprogram[] = [
                'id' => $entry->id ? $entry->id : 'Data not available yet',
                'record' => ($entry->division ? $entry->division->name : '-') . 
                '/AP/' . 
                date('Y') . '/' . 
                str_pad($entry->record, 4, '0', STR_PAD_LEFT),
                
            'intiation_date' => $entry->intiation_date 
                    ? \Carbon\Carbon::parse($entry->intiation_date)->format('d-M-Y') 
                    : 'Data not available yet',

            'Initiator_Group' => Helpers::getNewInitiatorGroupFullName($entry->Initiator_Group) ? Helpers::getNewInitiatorGroupFullName($entry->Initiator_Group) : 'Data not available yet',
            'severity1_level' => $entry->severity1_level ? $entry->severity1_level : 'Data not available yet' ,
            'short_description' => $entry->short_description ? $entry->short_description : 'Data not available yet' ,
            'due_date' => $entry->due_date ? $entry->due_date : 'Data not available yet',
            'Audit_Completed_On' => $entry->Audit_Completed_On ? $entry->Audit_Completed_On  : 'Data not available yet' ,
            'status' => $entry->status ? $entry->status : 'Data not available yet'  


        ];
    }
    


    return response()->json($auditprogram);
}

public function fetch_records_capa()
{
    $data = Capa::select(
            'id',
            'division_id',
            'record', 
            'intiation_date', 
            'initiator_Group', 
            'Initial_Categorization', 
            'short_description', 
            'priority_data', 
            'due_date', 
            'qah_approval_completed_on', 
            'status'
        )
        ->get(); 
        $capa = [];
        
        foreach ($data as $entry) {
            $capa[] = [
                'id' => $entry->id ? $entry->id : 'Data not available yet',
               'record' => ($entry->division ? $entry->division->name : '-') . 
                '/CAPA/' . 
                date('Y') . '/' . 
                str_pad($entry->record, 4, '0', STR_PAD_LEFT),
                
            'intiation_date' => $entry->intiation_date 
                    ? \Carbon\Carbon::parse($entry->intiation_date)->format('d-M-Y') 
                    : 'Data not available yet',

            'initiator_Group' => $entry->initiator_Group ? $entry->initiator_Group : 'Data not available yet',
            'Initial_Categorization' => $entry->Initial_Categorization ? $entry->Initial_Categorization : 'Data not available yet' ,
            'short_description' => $entry->short_description ? $entry->short_description : 'Data not available yet' ,
            'priority_data' => $entry->priority_data ? $entry->priority_data : 'Data not available yet' ,
            'due_date' => $entry->due_date ? $entry->due_date : 'Data not available yet',
            'qah_approval_completed_on' => $entry->qah_approval_completed_on ? $entry->qah_approval_completed_on  : 'Data not available yet' ,
            'status' => $entry->status ? $entry->status : 'Data not available yet'  


        ];
    }
    


    return response()->json($capa);
}


// In Process


public function fetch_records_GlobalCAPA()
    {
        $data =GlobalCapa::select(
            'id',
            'division_id',
            'record',
            'intiation_date',
            'initiator_Group',
            'Initial_Categorization',
            'short_description',
            'priority_data',
            'due_date',
            'qah_approval_completed_on',
            'status'
        )->get();

        $capa = [];
        foreach ($data as $entry) {
            $capa[] = [
                'id' => $entry->id ? $entry->id : 'Data not available yet',
                'record' => ($entry->division ? $entry->division->name : '-') .
                    '/GC/' .
                    date('Y') . '/' .
                    str_pad($entry->record, 4, '0', STR_PAD_LEFT),
                'intiation_date' => $entry->intiation_date
                    ? Carbon::parse($entry->intiation_date)->format('d-M-Y')
                    : 'Data not available yet',
                'initiator_Group' => $entry->initiator_Group ?? 'Data not available yet',
                'Initial_Categorization' => $entry->Initial_Categorization ?? 'Data not available yet',
                'short_description' => $entry->short_description ?? 'Data not available yet',
                'priority_data' => $entry->priority_data ?? 'Data not available yet',
                'due_date' => $entry->due_date ?? 'Data not available yet',
                'qah_approval_completed_on' => $entry->qah_approval_completed_on ?? 'Data not available yet',
                'status' => $entry->status ?? 'Data not available yet',
            ];
        }

        return response()->json($capa);
    }

    public function fetch_records_effectivenesscheck()
    {
        $data = EffectivenessCheck::select(
           'id',
            'division_id',
            'record',
            'intiation_date',
            'short_description',
            'due_date',
            'effective_approval_complete_on',
            'status'
        )->get();

        $capa = [];
        foreach ($data as $entry) {
            $capa[] = [
                'id' => $entry->id ? $entry->id : 'Data not available yet',
                'record' => ($entry->division ? $entry->division->name : '-') .
                    '/EC/' .
                    date('Y') . '/' .
                    str_pad($entry->record, 4, '0', STR_PAD_LEFT),
                'intiation_date' => $entry->intiation_date
                    ? Carbon::parse($entry->intiation_date)->format('d-M-Y')
                    : 'Data not available yet',
                'short_description' => $entry->short_description ?? 'Data not available yet',
                'due_date' => $entry->due_date ?? 'Data not available yet',
                'effective_approval_complete_on' => $entry->effective_approval_complete_on ?? 'Data not available yet',
                'status' => $entry->status ?? 'Data not available yet',
            ];
        }

        return response()->json($capa);
    }

    // Repeat the same structure for all the other models

    public function fetch_records_CalibrationManagement()
    {
        $data =CallibrationDetails::select(
            'id',
            'division_id',
            'record',
            'intiation_date',
            'callibration_frequency',
            'short_description',
            'due_date',
            'QA_Approval_on',
            'status'
        )->get();

        $capa = [];
        foreach ($data as $entry) {
            $capa[] = [
                'id' => $entry->id ? $entry->id : 'Data not available yet',
                'record' => ($entry->division ? $entry->division->name : '-') .
                    '/CM/' .
                    date('Y') . '/' .
                    str_pad($entry->record, 4, '0', STR_PAD_LEFT),
                'intiation_date' => $entry->intiation_date
                    ? Carbon::parse($entry->intiation_date)->format('d-M-Y')
                    : 'Data not available yet',
                'callibration_frequency' => $entry->callibration_frequency ?? 'Data not available yet',
                'short_description' => $entry->short_description ?? 'Data not available yet',
                'due_date' => $entry->due_date ?? 'Data not available yet',
                'QA_Approval_on' => $entry->QA_Approval_on ?? 'Data not available yet',
                'status' => $entry->status ?? 'Data not available yet',
            ];
        }

        return response()->json($capa);
    }



    public function fetch_records_SupplierAudit()
    {
        $data = SupplierAudit::select(
            'id',
            'division_id',
            'record',
            'intiation_date',
            'Initiator_Group',
            'severity_level',
            'short_description',
            'due_date',
            'audit_lead_more_info_reqd_on',
            'status'
        )->get();

        $capa = [];
        foreach ($data as $entry) {
            $capa[] = [
                'id' => $entry->id ? $entry->id : 'Data not available yet',
                'record' => ($entry->division ? $entry->division->name : '-') .
                    '/SA/' .
                    date('Y') . '/' .
                    str_pad($entry->record, 4, '0', STR_PAD_LEFT),
                'intiation_date' => $entry->intiation_date
                    ? Carbon::parse($entry->intiation_date)->format('d-M-Y')
                    : 'Data not available yet',
                'Initiator_Group' =>Helpers::getNewInitiatorGroupFullName($entry->Initiator_Group) ?? 'Data not available yet',
                'Initial_Categorization' => $entry->Initial_Categorization ?? 'Data not available yet',
                'short_description' => $entry->short_description ?? 'Data not available yet',
                'severity_level' => $entry->severity_level ?? 'Data not available yet',
                'due_date' => $entry->due_date ?? 'Data not available yet',
                'audit_lead_more_info_reqd_on' => $entry->audit_lead_more_info_reqd_on ?? 'Data not available yet',
                'status' => $entry->status ?? 'Data not available yet',
            ];
        }

        return response()->json($capa);
    }

    public function fetch_records_Supplier()
    {
        $data = Supplier::select(
            'id',
            'division_id',
            'record',
            'intiation_date',
            'initiation_group',
            'short_description',
            'due_date',
            'pendingManufacturerAuditFailed_on',
            'status'
        )->get();

        $capa = [];
        foreach ($data as $entry) {
            $capa[] = [
                'id' => $entry->id ? $entry->id : 'Data not available yet',
                'record' => ($entry->division ? $entry->division->name : '-') .
                    '/Supplier/' .
                    date('Y') . '/' .
                    str_pad($entry->record, 4, '0', STR_PAD_LEFT),
                'intiation_date' => $entry->intiation_date
                    ? Carbon::parse($entry->intiation_date)->format('d-M-Y')
                    : 'Data not available yet',
                'initiation_group' => Helpers::getNewInitiatorGroupFullName($entry->initiation_group) ? Helpers::getNewInitiatorGroupFullName($entry->initiation_group) : 'Data not available yet',
                'Initial_Categorization' => $entry->Initial_Categorization ?? 'Data not available yet',
                'short_description' => $entry->short_description ?? 'Data not available yet',
                'priority_data' => $entry->priority_data ?? 'Data not available yet',
                'due_date' => $entry->due_date ?? 'Data not available yet',
                'pendingManufacturerAuditFailed_on' => $entry->pendingManufacturerAuditFailed_on ?? 'Data not available yet',
                'status' => $entry->status ?? 'Data not available yet',
            ];
        }

        return response()->json($capa);
    }

    public function fetch_records_RootCauseAnalysis()
    {
        $data = RootCauseAnalysis::select(
            'id',
            'division_id',
            'record',
            'intiation_date',
            'initiator_Group',
            'severity_level',
            'short_description',
            'priority_data',
            'due_date',
            'evaluation_complete_on',
            'status'
        )->get();

        $capa = [];
        foreach ($data as $entry) {
            $capa[] = [
                'id' => $entry->id ? $entry->id : 'Data not available yet',
                'record' => ($entry->division ? $entry->division->name : '-') .
                    '/RCA/' .
                    date('Y') . '/' .
                    str_pad($entry->record, 4, '0', STR_PAD_LEFT),
                'intiation_date' => $entry->intiation_date
                    ? Carbon::parse($entry->intiation_date)->format('d-M-Y')
                    : 'Data not available yet',
                'initiator_Group' => Helpers::getFullDepartmentName( $entry->initiator_Group) ?? 'Data not available yet',
                'severity_level' => $entry->severity_level ?? 'Data not available yet',
                'short_description' => $entry->short_description ?? 'Data not available yet',
                'priority_data' => $entry->priority_data ?? 'Data not available yet',
                'due_date' => $entry->due_date ?? 'Data not available yet',
                'evaluation_complete_on' => $entry->evaluation_complete_on ?? 'Data not available yet',
                'status' => $entry->status ?? 'Data not available yet',
            ];
        }

        return response()->json($capa);
    }

    public function fetch_records_riskassessment()
    {
        $data = RiskManagement::select(
            'id',
            'division_id',
            'record',
            'intiation_date',
            'Initiator_Group',
            'severity2_level',
            'short_description',
            'priority_level',
            'due_date',
            'risk_analysis_completed_on',
            'status'
        )->get();

        $capa = [];
        foreach ($data as $entry) {
            $capa[] = [
                'id' => $entry->id ? $entry->id : 'Data not available yet',
                'record' => ($entry->division ? $entry->division->name : '-') .
                    '/RA/' .
                    date('Y') . '/' .
                    str_pad($entry->record, 4, '0', STR_PAD_LEFT),
                'intiation_date' => $entry->intiation_date
                    ? Carbon::parse($entry->intiation_date)->format('d-M-Y')
                    : 'Data not available yet',
                'Initiator_Group' => Helpers::getNewInitiatorGroupFullName($entry->Initiator_Group) ?? 'Data not available yet',
                'severity2_level' => $entry->severity2_level ?? 'Data not available yet',
                'short_description' => $entry->short_description ?? 'Data not available yet',
                'priority_level' => $entry->priority_level ?? 'Data not available yet',
                'due_date' => $entry->due_date ?? 'Data not available yet',
                'risk_analysis_completed_on' => $entry->risk_analysis_completed_on ?? 'Data not available yet',
                'status' => $entry->status ?? 'Data not available yet',
            ];
        }

        return response()->json($capa);
    }

    public function fetch_records_PreventiveMaintenance()
{
    $data = PreventiveMaintenance::select(
            'id',
            'division_id',
            'record', 
            'intiation_date', 
            'short_description', 
            'due_date', 
            'qa_approval_on', 
            'status'
        )
        ->get(); 
    $preventiveMaintenance = [];

    foreach ($data as $entry) {
        $preventiveMaintenance[] = [
            'id' => $entry->id ? $entry->id : 'Data not available yet',
            'record' => ($entry->division ? $entry->division->name : '-') . 
            '/PM/' . 
            date('Y') . '/' . 
            str_pad($entry->record, 4, '0', STR_PAD_LEFT),
            'intiation_date' => $entry->intiation_date 
                    ? \Carbon\Carbon::parse($entry->intiation_date)->format('d-M-Y') 
                    : 'Data not available yet',
            'short_description' => $entry->short_description ?? 'Data not available yet',
            'due_date' => $entry->due_date ?? 'Data not available yet',
            'qa_approval_on' => $entry->qa_approval_on ?? 'Data not available yet',
            'status' => $entry->status ?? 'Data not available yet',
        ];
    }

    return response()->json($preventiveMaintenance);
}

public function fetch_records_labincident()
{
    $data = LabIncident::select(
            'id',
            'division_id',
            'record', 
            'intiation_date', 
            'Initiator_Group', 
            'severity_level2', 
            'priority_data', 
            'short_desc', 
            'due_date', 
            'closure_completed_on', 
            'status'
        )
        ->get(); 
    $labIncident = [];

    foreach ($data as $entry) {
        $labIncident[] = [
            'id' => $entry->id ? $entry->id : 'Data not available yet',
            'record' => ($entry->division ? $entry->division->name : '-') . 
            '/LI/' . 
            date('Y') . '/' . 
            str_pad($entry->record, 4, '0', STR_PAD_LEFT),
            'intiation_date' => $entry->intiation_date 
                    ? \Carbon\Carbon::parse($entry->intiation_date)->format('d-M-Y') 
                    : 'Data not available yet',
            'Initiator_Group' => Helpers::getNewInitiatorGroupFullName($entry->Initiator_Group) ?? 'Data not available yet',
            'severity_level2' => $entry->severity_level2 ?? 'Data not available yet',
            'priority_data' => $entry->priority_data ?? 'Data not available yet',
            'short_desc' => $entry->short_desc ?? 'Data not available yet',
            'due_date' => $entry->due_date ?? 'Data not available yet',
            'closure_completed_on' => $entry->closure_completed_on ?? 'Data not available yet',
            'status' => $entry->status ?? 'Data not available yet',
        ];
    }

    return response()->json($labIncident);
}


public function fetch_records_internalaudit()
{
    $data = InternalAudit::select(
            'id',
            'division_id',
            'record', 
            'intiation_date', 
            'initiator_Group', 
            'severity_level_form', 
            'short_description', 
            'due_date', 
            'audit_lead_more_info_reqd_on', 
            'status'
        )
        ->get(); 
    $internalAudit = [];

    foreach ($data as $entry) {
        $internalAudit[] = [
            'id' => $entry->id ? $entry->id : 'Data not available yet',
            'record' => ($entry->division ? $entry->division->name : '-') . 
            '/InternalAudit/' . 
            date('Y') . '/' . 
            str_pad($entry->record, 4, '0', STR_PAD_LEFT),
            'intiation_date' => $entry->intiation_date 
                    ? \Carbon\Carbon::parse($entry->intiation_date)->format('d-M-Y') 
                    : 'Data not available yet',
            'initiator_Group' => Helpers::getNewInitiatorGroupFullName($entry->initiator_Group) ?? 'Data not available yet',
            'severity_level_form' => $entry->severity_level_form ?? 'Data not available yet',
            'short_description' => $entry->short_description ?? 'Data not available yet',
            'due_date' => $entry->due_date ?? 'Data not available yet',
            'audit_lead_more_info_reqd_on' => $entry->audit_lead_more_info_reqd_on ?? 'Data not available yet',
            'status' => $entry->status ?? 'Data not available yet',
        ];
    }

    return response()->json($internalAudit);
}

public function fetch_records_externalaudit ()
{
    $data = Auditee::select(
            'id',
            'division_id',
            'record', 
            'intiation_date', 
            'Initiator_Group', 
            'severity_level', 
            'short_description', 
            'due_date', 
            'audit_lead_more_info_reqd_on', 
            'status'
        )
        ->get(); 
    $internalAudit = [];

    foreach ($data as $entry) {
        $internalAudit[] = [
            'id' => $entry->id ? $entry->id : 'Data not available yet',
            'record' => ($entry->division ? $entry->division->name : '-') . 
            '/EA/' . 
            date('Y') . '/' . 
            str_pad($entry->record, 4, '0', STR_PAD_LEFT),
            'intiation_date' => $entry->intiation_date 
                    ? \Carbon\Carbon::parse($entry->intiation_date)->format('d-M-Y') 
                    : 'Data not available yet',
            'Initiator_Group' => Helpers::getNewInitiatorGroupFullName($entry->Initiator_Group) ?? 'Data not available yet',
            'severity_level' => $entry->severity_level ?? 'Data not available yet',
            'short_description' => $entry->short_description ?? 'Data not available yet',
            'due_date' => $entry->due_date ?? 'Data not available yet',
            'audit_lead_more_info_reqd_on' => $entry->audit_lead_more_info_reqd_on ?? 'Data not available yet',
            'status' => $entry->status ?? 'Data not available yet',
        ];
    }

    return response()->json($internalAudit);
}


public function fetch_records_Incident()
{
    $data = Incident::select(
            'id',
            'division_id',
            'record', 
            'intiation_date', 
            'Initiator_Group', 
            'Justification_for_categorization', 
            'short_description', 
            'due_date', 
            'QA_final_approved_on', 
            'status'
        )
        ->get(); 
    $incident = [];

    foreach ($data as $entry) {
        $incident[] = [
            'id' => $entry->id ? $entry->id : 'Data not available yet',
            'record' => ($entry->division ? $entry->division->name : '-') . 
            '/Inc/' . 
            date('Y') . '/' . 
            str_pad($entry->record, 4, '0', STR_PAD_LEFT),
            'intiation_date' => $entry->intiation_date 
                    ? \Carbon\Carbon::parse($entry->intiation_date)->format('d-M-Y') 
                    : 'Data not available yet',
            'Initiator_Group' => Helpers::getNewInitiatorGroupFullName($entry->Initiator_Group) ?? 'Data not available yet',
            'Justification_for_categorization' => $entry->Justification_for_categorization ?? 'Data not available yet',
            'short_description' => $entry->short_description ?? 'Data not available yet',
            'due_date' => $entry->due_date ?? 'Data not available yet',
            'QA_final_approved_on' => $entry->QA_final_approved_on ?? 'Data not available yet',
            'status' => $entry->status ?? 'Data not available yet',
        ];
    }

    return response()->json($incident);
}



public function fetch_records_errata()
{
    $data = Errata::select(
            'id',
            'division_id',
            'record', 
            'intiation_date', 
            'Department', 
            'short_description', 
            'due_date', 
            'qa_head_approval_completed_on', 
            'status'
        )
        ->get(); 
    $errata = [];

    foreach ($data as $entry) {
        $errata[] = [
            'id' => $entry->id ? $entry->id : 'Data not available yet',
            'record' => ($entry->division ? $entry->division->name : '-') . 
            '/Errata/' . 
            date('Y') . '/' . 
            str_pad($entry->record, 4, '0', STR_PAD_LEFT),
            'intiation_date' => $entry->intiation_date 
                    ? \Carbon\Carbon::parse($entry->intiation_date)->format('d-M-Y') 
                    : 'Data not available yet',
            'Department' => Helpers::getNewInitiatorGroupFullName($entry->Department) ?? 'Data not available yet',
            'short_description' => $entry->short_description ?? 'Data not available yet',
            'due_date' => $entry->due_date ?? 'Data not available yet',
            'qa_head_approval_completed_on' => $entry->qa_head_approval_completed_on ?? 'Data not available yet',
            'status' => $entry->status ?? 'Data not available yet',
        ];
    }

    return response()->json($errata);
}



// public function fetch_records_ComplaintManagement()
// {
//     $data = MarketComplaint::select(
//             'record', 
//             'intiation_date', 
//             'initiator_Group', 
//             'Initial_Categorization', 
//             'short_description', 
//             'priority_data', 
//             'due_date', 
//             'qah_approval_completed_on', 
//             'status'
//         )
//         ->get(); 
//     $complaintManagement = [];

//     foreach ($data as $entry) {
//         $complaintManagement[] = [
//             'record' => ($entry->division ? $entry->division->name : '-') . 
//             '/CM/' . 
//             date('Y') . '/' . 
//             str_pad($entry->record, 4, '0', STR_PAD_LEFT),
//             'intiation_date' => $entry->intiation_date 
//                     ? \Carbon\Carbon::parse($entry->intiation_date)->format('d-M-Y') 
//                     : 'Data not available yet',
//             'initiator_Group' => $entry->initiator_Group ?? 'Data not available yet',
//             'Initial_Categorization' => $entry->Initial_Categorization ?? 'Data not available yet',
//             'short_description' => $entry->short_description ?? 'Data not available yet',
//             'priority_data' => $entry->priority_data ?? 'Data not available yet',
//             'due_date' => $entry->due_date ?? 'Data not available yet',
//             'qah_approval_completed_on' => $entry->qah_approval_completed_on ?? 'Data not available yet',
//             'status' => $entry->status ?? 'Data not available yet',
//         ];
//     }

//     return response()->json($complaintManagement);
// }

public function fetch_records_ComplaintManagement()
{
    $data = MarketComplaint::select(
            'id',
            'division_id',
            'record', 
            'intiation_date', 
            'initiator_group', 
            'categorization_of_complaint_gi', 
            'description_gi', 
            'due_date_gi', 
            'closed_done_on', 
            'status'
        )
        ->get(); 
    $complaintManagement = [];

    foreach ($data as $entry) {
        $complaintManagement[] = [
            'id' => $entry->id ? $entry->id : 'Data not available yet',
            'record' => ($entry->division ? $entry->division->name : '-') . 
            '/CM/' . 
            date('Y') . '/' . 
            str_pad($entry->record, 4, '0', STR_PAD_LEFT),
            'intiation_date' => $entry->intiation_date 
                    ? \Carbon\Carbon::parse($entry->intiation_date)->format('d-M-Y') 
                    : 'Data not available yet',
            'initiator_group' => Helpers::getNewInitiatorGroupFullName($entry->initiator_group) ?? 'Data not available yet',
            'categorization_of_complaint_gi' => $entry->categorization_of_complaint_gi ?? 'Data not available yet',
            'description_gi' => $entry->description_gi ?? 'Data not available yet',
            'due_date_gi' => $entry->due_date_gi ?? 'Data not available yet',
            'closed_done_on' => $entry->closed_done_on ?? 'Data not available yet',
            'status' => $entry->status ?? 'Data not available yet',
        ];
    }

    return response()->json($complaintManagement);
}

public function generatePdf()
{
    $data = MarketComplaint::select(
            'id',
            'division_id',
            'record', 
            'intiation_date', 
            'initiator_group', 
            'categorization_of_complaint_gi', 
            'description_gi', 
            'due_date_gi', 
            'closed_done_on', 
            'status'
        )
        ->get(); 

    $complaintManagement = [];
    foreach ($data as $entry) {
        $complaintManagement[] = [
            'id' => $entry->id ?? 'Data not available yet',
            'record' => ($entry->division ? $entry->division->name : '-') . 
            '/CM/' . 
            date('Y') . '/' . 
            str_pad($entry->record, 4, '0', STR_PAD_LEFT),
            'intiation_date' => $entry->intiation_date 
                    ? \Carbon\Carbon::parse($entry->intiation_date)->format('d-M-Y') 
                    : 'Data not available yet',
            'initiator_group' => Helpers::getNewInitiatorGroupFullName($entry->initiator_group) ?? 'Data not available yet',
            'categorization_of_complaint_gi' => $entry->categorization_of_complaint_gi ?? 'Data not available yet',
            'description_gi' => $entry->description_gi ?? 'Data not available yet',
            'due_date_gi' => $entry->due_date_gi ?? 'Data not available yet',
            'closed_done_on' => $entry->closed_done_on ?? 'Data not available yet',
            'status' => $entry->status ?? 'Data not available yet',
        ];
    }

    $complaintManagement = collect($complaintManagement);  // Convert to collection
    $rowsPerPage = 7;
    $totalRows = $complaintManagement->count();  // Now works on collection
    $totalPages = ceil($totalRows / $rowsPerPage);
    $paginatedData = $complaintManagement->chunk($rowsPerPage);

    $pdf = PDF::loadView('frontend.forms.Logs.chart_complaint_management_pdf', compact('complaintManagement','totalRows','totalPages','paginatedData'));

    
    return $pdf->stream('report.pdf');
}






}






 