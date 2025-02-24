<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActionItem;
use App\Models\CC;
use PDF;
use App\Models\GlobalChangeControl;
use App\Models\AuditProgram;
use App\Models\CallibrationDetails;
use App\Models\Capa;
use App\Models\GlobalCapa;
use App\Models\Deviation;
use App\Models\Document;
use App\Models\EffectivenessCheck;
use App\Models\EquipmentLifecycleManagement;
use App\Models\Errata;
use App\Models\extension_new;
use App\Models\ExternalAudit;
use App\Models\Incident;
use App\Models\InternalAudit;
use App\Models\LabIncident;
use App\Models\MarketComplaint;
use App\Models\OOS;
use App\Models\PreventiveMaintenance;
use App\Models\Process;
use App\Models\QMSDivision;
use App\Models\RiskManagement;
use App\Models\RootCauseAnalysis;
use App\Models\Ootc;
use App\Models\Supplier;
use App\Models\SupplierAudit;
use App\Models\User;
use Carbon\Carbon;
use Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeptAnalysisController extends Controller
{

    public function fetchAnalytics(Request $request)
    {
        $tables = [
            'c_c_s' => [
                'group_column' => 'Initiator_Group',
            ],
            'action_items' => [
                'group_column' => 'initiatorGroup',
            ],
            'capas' => [
                'group_column' => 'initiator_Group',
            ],
            'audit_programs' => [
                'group_column' => 'Initiator_Group',
            ],
            // 'callibration_details' => [
            //     'group_column' => 'initiator_group',
            // ],
            'marketcompalints' => [
                'group_column' => 'initiator_group',
            ],
            'deviations' => [
                'group_column' => 'Initiator_Group',
            ],
            // 'effectiveness_checks' => [
            //     'group_column' => 'Initiator_Group',
            // ],
            // 'equipment_lifecycle_information' => [
            //     'group_column' => 'initiator_group',
            // ],
            'erratas' => [
                'group_column' => 'Department',
            ],
            'auditees' => [
                'group_column' => 'Initiator_Group',
            ],
            'global_capas' => [
                'group_column' => 'initiator_Group',
            ],
            'global_change_controls' => [
                'group_column' => 'Initiator_Group',
            ],
            'incidents' => [
                'group_column' => 'Initiator_Group',
            ],
            'internal_audits' => [
                'group_column' => 'Initiator_Group',
            ],
            'lab_incidents' => [
                'group_column' => 'Initiator_Group',
            ],
            // 'preventive_maintenances' => [
            //     'group_column' => 'Initiator_Group',
            // ],
            // 'risk_assessments' => [
            //     'group_column' => 'Initiator_Group',
            // ],
            'root_cause_analyses' => [
                'group_column' => 'initiator_Group',
            ],
            // 'sanctions' => [
            //     'group_column' => 'initiator_Group',
            // ],
            'suppliers' => [
                'group_column' => 'initiation_group',
            ],
            'supplier_audits' => [
                'group_column' => 'Initiator_Group',
            ],
        ];

        $combinedCounts = [];
        $combinedDetails = collect();

        foreach ($tables as $table => $columns) {
            // Fetch counts grouped by the group column
            $counts = DB::table($table)
                ->select($columns['group_column'], DB::raw('COUNT(*) as count'))
                ->groupBy($columns['group_column'])
                ->pluck('count', $columns['group_column'])
                ->toArray();

            // Merge counts
            $combinedCounts = array_merge_recursive($combinedCounts, $counts);

            // Fetch details
            $details = DB::table($table)->get();

            if ($details->isNotEmpty()) {
                $details = $details->map(function ($item) use ($columns) {
                    $item->division = Helpers::divisionNameForQMS($item->division_id);
                    $item->originator = Helpers::getInitiatorName($item->initiator_id);
                    $item->department = $item->{$columns['group_column']}; // Normalize group column for consistency
                    return $item;
                });
            }

            // Merge details
            $combinedDetails = $combinedDetails->merge($details);
        }

        // Normalize merged counts (sum values with the same keys)
        $combinedCounts = array_map(function ($value) {
            return is_array($value) ? array_sum($value) : $value;
        }, $combinedCounts);

        // Return the combined data as a JSON response
        return response()->json([
            'counts' => $combinedCounts,       // Merged counts
            'records' => $combinedDetails,     // Merged rows
        ]);
    }

    public function storeData(Request $request)
    {
        // Store data in session
        session(['chartType' => $request->input('chartType')]);
        session(['dataSet' => $request->input('dataSet')]);

        // Redirect to the view report page
        return redirect()->route('viewDeptAnalysisReport');
    }

    // View report and pass data to the blade file
    public function viewReport()
    {
        // Retrieve data from session
        $chartType = session('chartType', 'default');
        $dataSet = session('dataSet', []);
        return view('frontend.department-analysis.dept-analysis-report', [
            'chartType' => $chartType,
            'dataSet' => $dataSet
        ]);
    }


    public function fetchDueDateAnalytics(Request $request)
    {
        $tables = [
            'c_c_s' => ['due_date_column' => 'due_date', 'group_column' => 'Initiator_Group'],
            'action_items' => ['due_date_column' => 'due_date', 'group_column' => 'initiatorGroup'],
            'capas' => ['due_date_column' => 'due_date', 'group_column' => 'initiator_Group'],
            'audit_programs' => ['due_date_column' => 'due_date', 'group_column' => 'Initiator_Group'],
            // 'callibration_details' => ['due_date_column' => 'due_date', 'group_column' => 'initiator_group'],
            // 'marketcompalints' => ['due_date_column' => 'due_date', 'group_column' => 'initiator_group'],
            'deviations' => ['due_date_column' => 'due_date', 'group_column' => 'Initiator_Group'],
            // 'effectiveness_checks' => ['due_date_column' => 'due_date', 'group_column' => 'Initiator_Group'],
            // 'equipment_lifecycle_information' => ['due_date_column' => 'due_date', 'group_column' => 'Initiator_Group'],
            // 'erratas' => ['due_date_column' => 'due_date', 'group_column' => 'Department'],
            'auditees' => ['due_date_column' => 'due_date', 'group_column' => 'Initiator_Group'],
            'global_capas' => ['due_date_column' => 'due_date', 'group_column' => 'initiator_Group'],
            'global_change_controls' => ['due_date_column' => 'due_date', 'group_column' => 'Initiator_Group'],
            'incidents' => ['due_date_column' => 'due_date', 'group_column' => 'Initiator_Group'],
            'internal_audits' => ['due_date_column' => 'due_date', 'group_column' => 'Initiator_Group'],
            'lab_incidents' => ['due_date_column' => 'due_date', 'group_column' => 'Initiator_Group'],
            // 'preventive_maintenances' => ['due_date_column' => 'due_date', 'group_column' => 'Initiator_Group'],
            // 'risk_assessments' => ['due_date_column' => 'due_date', 'group_column' => 'Initiator_Group'],
            'root_cause_analyses' => ['due_date_column' => 'due_date', 'group_column' => 'initiator_Group'],
            // 'sanctions' => ['due_date_column' => 'due_date', 'group_column' => 'initiator_Group'],
            // 'suppliers' => ['due_date_column' => 'due_date', 'group_column' => 'initiation_group'],
            'supplier_audits' => ['due_date_column' => 'due_date', 'group_column' => 'Initiator_Group'],
        ];

        $dueDateCounts = [
            'on_time' => 0,
            '1-30_days' => 0,
            '30-60_days' => 0,
            '60-100_days' => 0,
            'more_than_100_days' => 0,
        ];

        $combinedDetails = collect();

        foreach ($tables as $table => $columns) {
            $dueDateColumn = $columns['due_date_column'];
            $groupColumn = $columns['group_column']; // Store group_column separately

            // Fetch counts for each category
            $counts = DB::table($table)
                ->select(
                    DB::raw("CASE 
                    WHEN DATEDIFF($dueDateColumn, NOW()) >= 0 THEN 'on_time'
                    WHEN DATEDIFF($dueDateColumn, NOW()) BETWEEN -30 AND 0 THEN '1-30_days'
                    WHEN DATEDIFF($dueDateColumn, NOW()) BETWEEN -60 AND -31 THEN '30-60_days'
                    WHEN DATEDIFF($dueDateColumn, NOW()) BETWEEN -100 AND -61 THEN '60-100_days'
                    ELSE 'more_than_100_days'
                END as due_date_category"),
                    DB::raw('COUNT(*) as count')
                )
                ->groupBy('due_date_category')
                ->pluck('count', 'due_date_category')
                ->toArray();

            // Merge counts into the main array
            foreach ($counts as $category => $count) {
                $dueDateCounts[$category] += $count;
            }

            // Fetch details for all records
            $details = DB::table($table)->get();

            if ($details->isNotEmpty()) {
                $details = $details->map(function ($item) use ($dueDateColumn, $groupColumn) {
                    $item->division = Helpers::divisionNameForQMS($item->division_id);
                    $item->originator = Helpers::getInitiatorName($item->initiator_id);
                    $item->due_days = $this->calculateDaysDue($item->{$dueDateColumn});
                    $item->department = $item->{$groupColumn}; // Use $groupColumn directly
                    $dueDays = $this->calculateDaysDue($item->{$dueDateColumn});
                    if ($dueDays >= 0) {
                        $item->due_date_status = 'on_time';
                    } elseif ($dueDays >= -30) {
                        $item->due_date_status = '1-30_days';
                    } elseif ($dueDays >= -60) {
                        $item->due_date_status = '30-60_days';
                    } elseif ($dueDays >= -100) {
                        $item->due_date_status = '60-100_days';
                    } else {
                        $item->due_date_status = 'more_than_100_days';
                    }
                    return $item;
                });
            }

            // Merge details
            $combinedDetails = $combinedDetails->merge($details);
        }

        // Return the combined data as a JSON response
        return response()->json([
            'counts' => $dueDateCounts,
            'records' => $combinedDetails,
        ]);
    }

    public function storeDueDateData(Request $request)
    {
        // Store data in session
        session(['chartTypeDue' => $request->input('chartTypeDue')]);
        session(['dataSetDue' => $request->input('dataSetDue')]);

        // Redirect to the view report page
        return redirect()->route('viewDueDateAnalysisReport');
    }

    // View report and pass data to the blade file
    public function viewDueDateReport()
    {
        // Retrieve data from session
        $chartType = session('chartTypeDue', 'default');
        $dataSet = session('dataSetDue', []);

        // Check if data is passed correctly
        // You can pass it to the view
        return view('frontend.department-analysis.due-date-analysis-report', [
            'chartTypeDue' => $chartType,
            'dataSetDue' => $dataSet
        ]);
    }

    /**
     * Calculate the number of days due for a record.
     */
    private function calculateDaysDue($dueDate)
    {
        $dueDate = Carbon::parse($dueDate);
        return $dueDate->diffInDays(now(), false); // Returns a negative value if overdue
    }






}

