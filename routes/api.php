<?php

use App\Http\Controllers\Api\AllFormsController;
use App\Http\Controllers\Api\ChartController;
use App\Http\Controllers\Api\HelperController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\UserLoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\Api\LogFilterController;
use App\Http\Controllers\Api\MeetingController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('userLogin', [UserLoginController::class, 'loginapi']);
Route::get('/analyticsData', [DashboardController::class, 'analyticsData']);

Route::get('dashboardStatus', [ApiController::class, 'dashboardStatus']);
Route::get('getProfile', [ApiController::class, 'getProfile']);
Route::get('capaStatus', [ApiController::class, 'capaStatus']);

Route::post('/filter-records', [DocumentController::class, 'filterRecord'])->name('record.filter');

Route::post('upload-files', [HelperController::class, 'upload_file'])->name('api.upload.file');

/**
 * CHARTS ROUTES
 */

// ===================================================fetch records====================================================//
Route::get('/fetch-records', [ChartController::class, 'fetch_records_changecontroller'])->name('api.records.cc');
Route::get('/deviation-records', [ChartController::class, 'fetch_records_deviation'])->name('api.records.dv');
Route::get('/capa-records', [ChartController::class, 'fetch_records_capa'])->name('api.records.capa');
Route::get('/action-records', [ChartController::class, 'fetch_records_action'])->name('api.records.action');
Route::get('/due_date_extension-records', [ChartController::class, 'fetch_records_due_date_extension'])->name('api.records.due_date_extension');
Route::get('/auditprogram-records', [ChartController::class, 'fetch_records_auditprogram'])->name('api.records.auditprogram');
Route::get('/GlobalCAPA-records', [ChartController::class, 'fetch_records_GlobalCAPA'])->name('api.records.GlobalCapa');
Route::get('/effectivenesscheck-records', [ChartController::class, 'fetch_records_effectivenesscheck'])->name('api.records.effectivenesscheck');
Route::get('/CalibrationManagement-records', [ChartController::class, 'fetch_records_CalibrationManagement'])->name('api.records.CalibrationManagement');
Route::get('/SupplierAudit-records', [ChartController::class, 'fetch_records_SupplierAudit'])->name('api.records.SupplierAudit');
Route::get('/Supplier-records', [ChartController::class, 'fetch_records_Supplier'])->name('api.records.Supplier');
Route::get('/RootCauseAnalysis-records', [ChartController::class, 'fetch_records_RootCauseAnalysis'])->name('api.records.RootCauseAnalysis');
Route::get('/riskassessment-records', [ChartController::class, 'fetch_records_riskassessment'])->name('api.records.riskassessment');
Route::get('/preventivemaintenance-records', [ChartController::class, 'fetch_records_preventivemaintenance'])->name('api.records.PreventiveMaintenance');
Route::get('/labincident-records', [ChartController::class, 'fetch_records_labincident'])->name('api.records.labincident');
Route::get('/internalaudit-records', [ChartController::class, 'fetch_records_internalaudit'])->name('api.records.internalaudit');
Route::get('/Incident-records', [ChartController::class, 'fetch_records_Incident'])->name('api.records.Incident');
Route::get('/externalaudit-records', [ChartController::class, 'fetch_records_externalaudit'])->name('api.records.externalaudit');
Route::get('/errata-records', [ChartController::class, 'fetch_records_errata'])->name('api.records.errata');
Route::get('/ComplaintManagement-records', [ChartController::class, 'fetch_records_ComplaintManagement'])->name('api.records.ComplaintManagement');
// =========================================charts pdf ======================================================//
Route::get('/generate-pdf', [ChartController::class, 'generatePdf'])->name('generate.pdf');

// ===================================================fetch records====================================================//
Route::get('/charts/process-charts', [ChartController::class, 'process_charts'])->name('api.process.chart');
Route::get('/charts/documents-by-status', [ChartController::class, 'document_status_charts'])->name('api.document_by_status.chart');
Route::get('/charts/overdue-record-distribution', [ChartController::class, 'overdue_records_by_process_chart'])->name('api.overdue_records_by_process_chart.chart');
Route::get('/charts/documents-by-originator', [ChartController::class, 'documents_originator_charts'])->name('api.document.originator.chart');
Route::get('/charts/documents-by-type', [ChartController::class, 'documents_type_charts'])->name('api.document.type.chart');
Route::get('/charts/documents-in-review/{months}', [ChartController::class, 'documents_review_charts'])->name('api.document.review.chart');
Route::get('/charts/documents-in-stage/{stage}', [ChartController::class, 'documents_stage_charts'])->name('api.document.stage.chart');

Route::get('/charts/documents-by-priority', [ChartController::class, 'documentByPriority'])->name('api.document_by_priority.chart');
Route::get('/charts/documents-by-priority-change-control', [ChartController::class, 'documentByPriorityChangeControl'])->name('api.document_by_priority_change_control.chart');
Route::get('/charts/documents-by-priority-global-change-control', [ChartController::class, 'documentByPriorityActionItem'])->name('api.document_by_priority_action_item.chart');
Route::get('/charts/documents-by-priority-action-item', [ChartController::class, 'documentByPriorityGlobalChangeControl'])->name('api.document_by_priority_global_change_control.chart');
Route::get('/charts/global-change-control-stage-distribution', [ChartController::class, 'globalChangeControlStageDistribution'])->name('api.globalChangeControlStageDistribution.chart');
Route::get('/charts/change-control-stage-distribution', [ChartController::class, 'changeControlStageDistribution'])->name('api.changeControlStageDistribution.chart');
Route::get('/charts/action-item-stage-distribution', [ChartController::class, 'actionItemStageDistribution'])->name('api.actionItemStageDistribution.chart');
Route::get('/charts/documents-by-priority-rca', [ChartController::class, 'documentByPriorityRca'])->name('api.document_by_priority_rca.chart');

Route::get('/charts/documents-by-delayed', [ChartController::class, 'documentDelayed'])->name('api.document_by_delayed.chart');
Route::get('/charts/documents-by-delayedChangeControl', [ChartController::class, 'documentDelayedChangeControl'])->name('api.document_by_delayedChangeControl.chart');
Route::get('/charts/documents-by-delayedGlobalChangeControl', [ChartController::class, 'documentDelayedGlobalChangeControl'])->name('api.document_by_delayedGlobalChangeControl.chart');
Route::get('/charts/documents-by-delayedActionItem', [ChartController::class, 'documentDelayedActionItem'])->name('api.document_by_delayedActionItem.chart');
Route::get('/charts/documents-by-site', [ChartController::class, 'siteWiseDocument'])->name('api.document_by_site.chart');
Route::get('/charts/documents-by-siteChangeControl', [ChartController::class, 'siteWiseChangeControlDocument'])->name('api.document_by_siteChangeControl.chart');
Route::get('/charts/documents-by-siteGlobalChangeControl', [ChartController::class, 'siteWiseGlobalChangeControlDocument'])->name('api.document_by_siteGlobalChangeControl.chart');
Route::get('/charts/documents-by-siteActionItem', [ChartController::class, 'siteWiseActionItemDocument'])->name('api.document_by_siteActionItem.chart');

Route::get('/charts/pending-reviewers', [ChartController::class, 'document_pending_review_charts'])->name('api.document.pending.reviewers.chart');
Route::get('/charts/pending-approvers', [ChartController::class, 'document_pending_approve_charts'])->name('api.document.pending.approvers.chart');
Route::get('/charts/pending-hod', [ChartController::class, 'document_pending_hod_charts'])->name('api.document.pending.hod.chart');
Route::get('/charts/pending-training', [ChartController::class, 'document_pending_training_charts'])->name('api.document.pending.training.chart');
Route::get('flow-counts', [ChartController::class, 'getFlowCounts']);
Route::post('/change-control', [LogFilterController::class, 'changecontrol_filter'])->name('api.cccontrol.filter');
Route::post('/prementive-maintenance', [LogFilterController::class, 'Preventive_filter'])->name('api.preventiveM.filter');
Route::post('/errata', [LogFilterController::class, 'errata_filter'])->name('api.errata.filter');
Route::post('/failure-investigation', [LogFilterController::class, 'failureInv_filter'])->name('api.failure.filter');
Route::post('/inernal-audit', [LogFilterController::class, 'internal_audit_filter'])->name('api.internalaudit.filter');
Route::post('/marketcomplaint_data', [LogFilterController::class, 'marketcomplaint_filter'])->name('api.marketcomplaint.filter');
Route::post('/ooc', [LogFilterController::class, 'ooc_filter'])->name('api.ooc.filter');
Route::post('/incident', [LogFilterController::class, 'IncidentFilter'])->name('api.incident.filter');
Route::post('/lab-incident', [LogFilterController::class, 'labincident_filter'])->name('api.laboratoryincident.filter');
Route::post('/acton-item', [LogFilterController::class, 'actonitem_filter'])->name('api.actonitem.filter');
Route::post('/capa', [LogFilterController::class, 'capa_filter'])->name('api.capa.filter');
Route::post('/risk-management', [LogFilterController::class, 'risk_management_filter'])->name('api.riskmanagement.filter');
Route::post('/non-conformance', [LogFilterController::class, 'nonconformance_filter'])->name('api.nonconformance.filter');
Route::post('/oot', [LogFilterController::class, 'OOT_Filter'])->name('api.oot.filter');

Route::get('/test', [AllFormsController::class, 'AllForms']);
Route::get('/Change-ControlLog', [LogFilterController::class, 'printPDFCC'])->name('printReportcc');
Route::get('/print-report', [LogFilterController::class, 'printPDF'])->name('printReport');
Route::get('/print-actionitem', [LogFilterController::class, 'printPDFAction'])->name('printactionReport');
Route::post('/rca', [LogFilterController::class, 'rca_filter'])->name('api.rootcauseanalysis.filter');
Route::get('/print-rca', [LogFilterController::class, 'printPDFRCA'])->name('printPDFrca');
Route::post('/extension', [LogFilterController::class, 'extension_filter'])->name('api.extension.filter');
Route::get('/print-extension', [LogFilterController::class, 'printPDFExtension'])->name('printPDFextension');
Route::post('/effectivness-check', [LogFilterController::class, 'effectivness'])->name('api.effectivness.filter');
Route::get('/print-effectivness', [LogFilterController::class, 'printPDFEffectivenesss'])->name('printPDFeffectivness');
Route::get('/print-riskmt', [LogFilterController::class, 'printPDFriskmt'])->name('printPDFriskmt');
Route::get('/print-nnconfermance', [LogFilterController::class, 'printPDFnnconfermance'])->name('printPDFnnconfermance');
Route::get('/print-oot', [LogFilterController::class, 'printPDFoot'])->name('printPDFoot');
Route::get('/print-errata', [LogFilterController::class, 'printPDFerrata'])->name('printPDFerrata');
Route::get('/print-ooc', [LogFilterController::class, 'printPDFooc'])->name('printPDFooc');
Route::get('/print-labincident', [LogFilterController::class, 'printPDFLab'])->name('printPDFLab');
Route::get('/print-complaintM', [LogFilterController::class, 'printPDFcomplaintM'])->name('printPDFcomplaintM');
Route::get('/print-Incident', [LogFilterController::class, 'printPDFIncident'])->name('printPDFIncident');
Route::get('/print-internalAudit', [LogFilterController::class, 'printPDFInternalAudit'])->name('printPDFInternalAudit');
Route::get('/print-Deviation', [LogFilterController::class, 'printPDFDeviation'])->name('printPDFDeviation');
Route::get('/print-failureI', [LogFilterController::class, 'printPDFFailureInvestigation'])->name('printPDFFailureInvestigation');
Route::get('/print-preventiveM', [LogFilterController::class, 'printpreventiveMPDF'])->name('printpreventiveMPDF');
Route::get('/print-equipmentPdf', [LogFilterController::class, 'printequipmentPdf'])->name('printequipmentPdf');
Route::get('/print-elmM', [LogFilterController::class, 'printelmPDF'])->name('printelmPDF');

Route::post('/filter-document', [LogFilterController::class, 'documentFilter'])->name('api.document.filter');
Route::post('/filter-pendingApprover', [LogFilterController::class, 'pendingApproverData'])->name('api.pendingApprover.filter');

Route::get('/documents', [DocumentController::class, 'getDocList']);
Route::get('division-wise-process', [ChartController::class, 'getDivisionProcessCounts'])->name('division-wise-process');
Route::get('get-deviation-data', [ChartController::class, 'getDeviationData'])->name('get-deviation-data');
Route::get('get-change-control-data', [ChartController::class, 'getChangeControlData'])->name('get-change-control-data');
Route::get('get-action-item-data', [ChartController::class, 'getActionItemData'])->name('get-action-item-data');
Route::get('get-global-change-control-data', [ChartController::class, 'getGlobalChangeControlData'])->name('get-global-change-control-data');
Route::get('get-categorization-data', [ChartController::class, 'getcategorizationData'])->name('get-categorization-data');
Route::get('get-change-control-categorization-data', [ChartController::class, 'getChangeControlCategorizationData'])->name('get-change-control-categorization-data');
Route::get('get-global-change-control-categorization-data', [ChartController::class, 'getGlobalChangeControlCategorizationData'])->name('get-global-change-control-categorization-data');
Route::get('get-action-item-categorization-data', [ChartController::class, 'getActionItemCategorizationData'])->name('get-action-item-categorization-data');


Route::post('/equipment-management', [LogFilterController::class, 'equipmentlifecycle_filter'])->name('api.elmM.filter');
Route::post('/calibration-management', [LogFilterController::class, 'calibrationmanagement_filter'])->name('api.calibrationmanagment.filter');
Route::get('/calibration-managementLog', [LogFilterController::class, 'printPDFCM'])->name('printReportcm');


Route::post('/external-audit', [LogFilterController::class, 'externalaudit_filter'])->name('api.externalaudit.filter');
Route::get('/external-auditpdf', [LogFilterController::class, 'printPDFEA'])->name('printReportea');
Route::post('/global-capa', [LogFilterController::class, 'globalcapa_filter'])->name('api.globalcapa.filter');
Route::get('/global-capapdf', [LogFilterController::class, 'printPDFGCAPA'])->name('printReportglobalcapa');
Route::post('/new-document', [LogFilterController::class, 'newdocument_filter'])->name('api.newdocument.filter');
Route::get('/new-documentpdf', [LogFilterController::class, 'printPDFnewdocument'])->name('printReportnewdocument');

Route::post('/sanction', [LogFilterController::class, 'sanction_filter'])->name('api.sanction.filter');
Route::get('/sanction-logpdf', [LogFilterController::class, 'printPDFsanction'])->name('printReportsanction');


Route::post('/supplier', [LogFilterController::class, 'supplier_filter'])->name('api.supplier.filter');
Route::get('/supplier-logpdf', [LogFilterController::class, 'printPDFsupplier'])->name('printReportsupplier');

Route::post('/supplieraudit', [LogFilterController::class, 'supplieraudit_filter'])->name('api.supplieraudit.filter');
Route::get('/supplier-auditlogpdf', [LogFilterController::class, 'printPDFsupplieraudit'])->name('printReportsupplieraudit');
Route::get('/audit-programpdf', [LogFilterController::class, 'printPDFauditprogrampdf'])->name('printPDFauditprogrampdf');
Route::post('/audit-program', [LogFilterController::class, 'auditprogram_filter'])->name('api.auditprogram.filter');

Route::post('/test', [MeetingController::class, 'create_action_item']);
Route::post('/ehs-event', [LogFilterController::class, 'ehs_filter'])->name('api.ehsevent.filter');
Route::get('/ehs-eventLog', [LogFilterController::class, 'printReportehseventLog'])->name('printReportehseventLog');






//  ====extension==
Route::get('/charts/document_by_priority_extension', [ChartController::class, 'documentByPriorityExtension'])->name('api.document_by_priority_extension.chart');
Route::get('/charts/extension_Stage_Distribution', [ChartController::class, 'stageByPriorityExtension'])->name('api.extension_Stage_Distribution.chart');
Route::get('get-extension-initial-data', [ChartController::class, 'getextensioninitialData'])->name('get-extension-initial-data');
Route::get('get-extension-categorization-data', [ChartController::class, 'GetextensionpostCategoryData'])->name('get-extension-categorization-data');


// capa graph routes
Route::get('capa-initial-categorization', [ChartController::class, 'getCapaInitialCategorization'])->name('capa-initial-categorization');
Route::get('capa-post-categorization', [ChartController::class, 'getCapaPostCategorization'])->name('capa-post-categorization');
Route::get('capa-ontime-delayed-records', [ChartController::class, 'getOnTimeVsDelayedRecords'])->name('capa-ontime-delayed-records');
Route::get('capa-sitewise-records', [ChartController::class, 'getCapaByDivision'])->name('capa-sitewise-records');
Route::get('capa-priority-records', [ChartController::class, 'getCapaPriorityData'])->name('capa-priority-records');
Route::get('capa-status-records', [ChartController::class, 'getCapaByStatus'])->name('capa-status-records');

// global capa routes
Route::get('global-capa-initial-categorization', [ChartController::class, 'getGlobalCapaInitialCategorization'])->name('global-capa-initial-categorization');
Route::get('global-capa-post-categorization', [ChartController::class, 'getGlobalCapaPostCategorization'])->name('global-capa-post-categorization');
Route::get('global-capa-ontime-delayed-records', [ChartController::class, 'getOnTimeVsDelayedRecordsGlobalCapa'])->name('global-capa-ontime-delayed-records');
Route::get('global-capa-sitewise-records', [ChartController::class, 'getGlobalCapaByDivision'])->name('global-capa-sitewise-records');
Route::get('global-capa-priority-records', [ChartController::class, 'getGlobalCapaPriorityData'])->name('global-capa-priority-records');
Route::get('global-capa-status-records', [ChartController::class, 'getGlobalCapaByStatus'])->name('global-capa-status-records');

// Audit Program routes
Route::get('audit-program-initial-categorization', [ChartController::class, 'getAuditProgramInitialCategorization'])->name('audit-program-initial-categorization');
Route::get('audit-program-post-categorization', [ChartController::class, 'getAuditProgramPostCategorization'])->name('audit-program-post-categorization');
Route::get('audit-program-ontime-delayed-records', [ChartController::class, 'getOnTimeVsDelayedRecordsAuditProgram'])->name('audit-program-ontime-delayed-records');
Route::get('audit-program-sitewise-records', [ChartController::class, 'getAuditProgramByDivision'])->name('audit-program-sitewise-records');
Route::get('audit-program-priority-records', [ChartController::class, 'getAuditProgramPriorityData'])->name('audit-program-priority-records');
Route::get('audit-program-status-records', [ChartController::class, 'getAuditProgramByStatus'])->name('audit-program-status-records');

// Calibration Management routes
Route::get('calibration-management-initial-categorization', [ChartController::class, 'getCalibrationManagementInitialCategorization'])->name('calibration-management-initial-categorization');
Route::get('calibration-management-post-categorization', [ChartController::class, 'getCalibrationManagementPostCategorization'])->name('calibration-management-post-categorization');
Route::get('calibration-management-ontime-delayed-records', [ChartController::class, 'getOnTimeVsDelayedRecordsCalibrationManagement'])->name('calibration-management-ontime-delayed-records');
Route::get('calibration-management-sitewise-records', [ChartController::class, 'getCalibrationManagementByDivision'])->name('calibration-management-sitewise-records');
Route::get('calibration-management-priority-records', [ChartController::class, 'getCalibrationManagementPriorityData'])->name('calibration-management-priority-records');
Route::get('calibration-management-status-records', [ChartController::class, 'getCalibrationManagementByStatus'])->name('calibration-management-status-records');

// Effectiveness Check routes
Route::get('effectiveness-check-initial-categorization', [ChartController::class, 'getEffectivenessCheckInitialCategorization'])->name('effectiveness-check-initial-categorization');
Route::get('effectiveness-check-post-categorization', [ChartController::class, 'getEffectivenessCheckPostCategorization'])->name('effectiveness-check-post-categorization');
Route::get('effectiveness-check-ontime-delayed-records', [ChartController::class, 'getOnTimeVsDelayedRecordsEffectivenessCheck'])->name('effectiveness-check-ontime-delayed-records');
Route::get('effectiveness-check-sitewise-records', [ChartController::class, 'getEffectivenessCheckByDivision'])->name('effectiveness-check-sitewise-records');
Route::get('effectiveness-check-priority-records', [ChartController::class, 'getEffectivenessCheckPriorityData'])->name('effectiveness-check-priority-records');
Route::get('effectiveness-check-status-records', [ChartController::class, 'getEffectivenessCheckByStatus'])->name('effectiveness-check-status-records');

// Supplier Audit routes
Route::get('supplier-audit-initial-categorization', [ChartController::class, 'getSupplierAuditInitialCategorization'])->name('supplier-audit-initial-categorization');
Route::get('supplier-audit-post-categorization', [ChartController::class, 'getSupplierAuditPostCategorization'])->name('supplier-audit-post-categorization');
Route::get('supplier-audit-ontime-delayed-records', [ChartController::class, 'getOnTimeVsDelayedRecordsSupplierAudit'])->name('supplier-audit-ontime-delayed-records');
Route::get('supplier-audit-sitewise-records', [ChartController::class, 'getSupplierAuditByDivision'])->name('supplier-audit-sitewise-records');
Route::get('supplier-audit-priority-records', [ChartController::class, 'getSupplierAuditPriorityData'])->name('supplier-audit-priority-records');
Route::get('supplier-audit-status-records', [ChartController::class, 'getSupplierAuditByStatus'])->name('supplier-audit-status-records');

// Supplier routes
Route::get('supplier-initial-categorization', [ChartController::class, 'getSupplierInitialCategorization'])->name('supplier-initial-categorization');
Route::get('supplier-post-categorization', [ChartController::class, 'getSupplierPostCategorization'])->name('supplier-post-categorization');
Route::get('supplier-ontime-delayed-records', [ChartController::class, 'getOnTimeVsDelayedRecordsSupplier'])->name('supplier-ontime-delayed-records');
Route::get('supplier-sitewise-records', [ChartController::class, 'getSupplierByDivision'])->name('supplier-sitewise-records');
Route::get('supplier-priority-records', [ChartController::class, 'getSupplierPriorityData'])->name('supplier-priority-records');
Route::get('supplier-status-records', [ChartController::class, 'getSupplierByStatus'])->name('supplier-status-records');

// Sanction routes
Route::get('sanction-initial-categorization', [ChartController::class, 'getSanctionInitialCategorization'])->name('sanction-initial-categorization');
Route::get('sanction-post-categorization', [ChartController::class, 'getSanctionPostCategorization'])->name('sanction-post-categorization');
Route::get('sanction-ontime-delayed-records', [ChartController::class, 'getOnTimeVsDelayedRecordsSanction'])->name('sanction-ontime-delayed-records');
Route::get('sanction-sitewise-records', [ChartController::class, 'getSanctionByDivision'])->name('sanction-sitewise-records');
Route::get('sanction-priority-records', [ChartController::class, 'getSanctionPriorityData'])->name('sanction-priority-records');
Route::get('sanction-status-records', [ChartController::class, 'getSanctionByStatus'])->name('sanction-status-records');

// Root Cause Analysis routes
Route::get('root-cause-analysis-initial-categorization', [ChartController::class, 'getRootCauseAnalysisInitialCategorization'])->name('root-cause-analysis-initial-categorization');
Route::get('root-cause-analysis-post-categorization', [ChartController::class, 'getRootCauseAnalysisPostCategorization'])->name('root-cause-analysis-post-categorization');
Route::get('root-cause-analysis-ontime-delayed-records', [ChartController::class, 'getOnTimeVsDelayedRecordsRootCauseAnalysis'])->name('root-cause-analysis-ontime-delayed-records');
Route::get('root-cause-analysis-sitewise-records', [ChartController::class, 'getRootCauseAnalysisByDivision'])->name('root-cause-analysis-sitewise-records');
Route::get('root-cause-analysis-priority-records', [ChartController::class, 'getRootCauseAnalysisPriorityData'])->name('root-cause-analysis-priority-records');
Route::get('root-cause-analysis-status-records', [ChartController::class, 'getRootCauseAnalysisByStatus'])->name('root-cause-analysis-status-records');

// Risk Assessment routes
Route::get('risk-assessment-initial-categorization', [ChartController::class, 'getRiskAssessmentInitialCategorization'])->name('risk-assessment-initial-categorization');
Route::get('risk-assessment-post-categorization', [ChartController::class, 'getRiskAssessmentPostCategorization'])->name('risk-assessment-post-categorization');
Route::get('risk-assessment-ontime-delayed-records', [ChartController::class, 'getOnTimeVsDelayedRecordsRiskAssessment'])->name('risk-assessment-ontime-delayed-records');
Route::get('risk-assessment-sitewise-records', [ChartController::class, 'getRiskAssessmentByDivision'])->name('risk-assessment-sitewise-records');
Route::get('risk-assessment-priority-records', [ChartController::class, 'getRiskAssessmentPriorityData'])->name('risk-assessment-priority-records');
Route::get('risk-assessment-status-records', [ChartController::class, 'getRiskAssessmentByStatus'])->name('risk-assessment-status-records');

// Preventive Maintenance routes
Route::get('preventive-maintenance-initial-categorization', [ChartController::class, 'getPreventiveMaintenanceInitialCategorization'])->name('preventive-maintenance-initial-categorization');
Route::get('preventive-maintenance-post-categorization', [ChartController::class, 'getPreventiveMaintenancePostCategorization'])->name('preventive-maintenance-post-categorization');
Route::get('preventive-maintenance-ontime-delayed-records', [ChartController::class, 'getOnTimeVsDelayedRecordsPreventiveMaintenance'])->name('preventive-maintenance-ontime-delayed-records');
Route::get('preventive-maintenance-sitewise-records', [ChartController::class, 'getPreventiveMaintenanceByDivision'])->name('preventive-maintenance-sitewise-records');
Route::get('preventive-maintenance-priority-records', [ChartController::class, 'getPreventiveMaintenancePriorityData'])->name('preventive-maintenance-priority-records');
Route::get('preventive-maintenance-status-records', [ChartController::class, 'getPreventiveMaintenanceByStatus'])->name('preventive-maintenance-status-records');

// Lab Incident routes
Route::get('lab-incident-initial-categorization', [ChartController::class, 'getLabIncidentInitialCategorization'])->name('lab-incident-initial-categorization');
Route::get('lab-incident-post-categorization', [ChartController::class, 'getLabIncidentPostCategorization'])->name('lab-incident-post-categorization');
Route::get('lab-incident-ontime-delayed-records', [ChartController::class, 'getOnTimeVsDelayedRecordsLabIncident'])->name('lab-incident-ontime-delayed-records');
Route::get('lab-incident-sitewise-records', [ChartController::class, 'getLabIncidentByDivision'])->name('lab-incident-sitewise-records');
Route::get('lab-incident-priority-records', [ChartController::class, 'getLabIncidentPriorityData'])->name('lab-incident-priority-records');
Route::get('lab-incident-status-records', [ChartController::class, 'getLabIncidentByStatus'])->name('lab-incident-status-records');

// Internal Audit routes
Route::get('internal-audit-initial-categorization', [ChartController::class, 'getInternalAuditInitialCategorization'])->name('internal-audit-initial-categorization');
Route::get('internal-audit-post-categorization', [ChartController::class, 'getInternalAuditPostCategorization'])->name('internal-audit-post-categorization');
Route::get('internal-audit-ontime-delayed-records', [ChartController::class, 'getOnTimeVsDelayedRecordsInternalAudit'])->name('internal-audit-ontime-delayed-records');
Route::get('internal-audit-sitewise-records', [ChartController::class, 'getInternalAuditByDivision'])->name('internal-audit-sitewise-records');
Route::get('internal-audit-priority-records', [ChartController::class, 'getInternalAuditPriorityData'])->name('internal-audit-priority-records');
Route::get('internal-audit-status-records', [ChartController::class, 'getInternalAuditByStatus'])->name('internal-audit-status-records');

// Lab Incident routes
Route::get('incident-initial-categorization', [ChartController::class, 'getIncidentInitialCategorization'])->name('incident-initial-categorization');
Route::get('incident-post-categorization', [ChartController::class, 'getIncidentPostCategorization'])->name('incident-post-categorization');
Route::get('incident-ontime-delayed-records', [ChartController::class, 'getOnTimeVsDelayedRecordsIncident'])->name('incident-ontime-delayed-records');
Route::get('incident-sitewise-records', [ChartController::class, 'getIncidentByDivision'])->name('incident-sitewise-records');
Route::get('incident-priority-records', [ChartController::class, 'getIncidentPriorityData'])->name('incident-priority-records');
Route::get('incident-status-records', [ChartController::class, 'getIncidentByStatus'])->name('incident-status-records');

// External Audit routes
Route::get('external-audit-initial-categorization', [ChartController::class, 'getExternalAuditInitialCategorization'])->name('external-audit-initial-categorization');
Route::get('external-audit-post-categorization', [ChartController::class, 'getExternalAuditPostCategorization'])->name('external-audit-post-categorization');
Route::get('external-audit-ontime-delayed-records', [ChartController::class, 'getOnTimeVsDelayedRecordsExternalAudit'])->name('external-audit-ontime-delayed-records');
Route::get('external-audit-sitewise-records', [ChartController::class, 'getExternalAuditByDivision'])->name('external-audit-sitewise-records');
Route::get('external-audit-priority-records', [ChartController::class, 'getExternalAuditPriorityData'])->name('external-audit-priority-records');
Route::get('external-audit-status-records', [ChartController::class, 'getExternalAuditByStatus'])->name('external-audit-status-records');

// ERRATA routes
Route::get('errata-initial-categorization', [ChartController::class, 'getErrataInitialCategorization'])->name('errata-initial-categorization');
Route::get('errata-post-categorization', [ChartController::class, 'getErrataPostCategorization'])->name('errata-post-categorization');
Route::get('errata-ontime-delayed-records', [ChartController::class, 'getOnTimeVsDelayedRecordsErrata'])->name('errata-ontime-delayed-records');
Route::get('errata-sitewise-records', [ChartController::class, 'getErrataByDivision'])->name('errata-sitewise-records');
Route::get('errata-priority-records', [ChartController::class, 'getErrataPriorityData'])->name('errata-priority-records');
Route::get('errata-status-records', [ChartController::class, 'getErrataByStatus'])->name('errata-status-records');

// Complaint Management routes
Route::get('complaint-management-initial-categorization', [ChartController::class, 'getComplaintManagementInitialCategorization'])->name('complaint-management-initial-categorization');
Route::get('complaint-management-post-categorization', [ChartController::class, 'getComplaintManagementPostCategorization'])->name('complaintManage-ment-post-categorization');
Route::get('complaint-management-ontime-delayed-records', [ChartController::class, 'getOnTimeVsDelayedRecordsComplaintManagement'])->name('complain-mManagement-ontime-delayed-records');
Route::get('complaint-management-sitewise-records', [ChartController::class, 'getComplaintManagementByDivision'])->name('complaintManagement-sitewi-me-records');
Route::get('complaint-management-priority-records', [ChartController::class, 'getComplaintManagementPriorityData'])->name('complaintManagement-prio-mity-records');
Route::get('complaint-management-status-records', [ChartController::class, 'getComplaintManagementByStatus'])->name('complaintManagement-status-rec-mrds');

// Change Control routes
Route::get('change-control-initial-categorization', [ChartController::class, 'getChangeControlInitialCategorization'])->name('change-control-initial-categorization');
Route::get('change-control-post-categorization', [ChartController::class, 'getChangeControlPostCategorization'])->name('change-control-post-categorization');
Route::get('change-control-ontime-delayed-records', [ChartController::class, 'getOnTimeVsDelayedRecordsChangeControl'])->name('change-control-ontime-delayed-records');
Route::get('change-control-sitewise-records', [ChartController::class, 'getChangeControlByDivision'])->name('change-control-sitewise-records');
Route::get('change-control-priority-records', [ChartController::class, 'getChangeControlPriorityData'])->name('change-control-priority-records');
Route::get('change-control-status-records', [ChartController::class, 'getChangeControlByStatus'])->name('change-control-status-records');



// Deviation routes

Route::get('/charts/deviation-by-classification', [ChartController::class, 'deviation_classification_charts'])->name('api.deviation.chart');
Route::get('/charts/deviation-by-departments', [ChartController::class, 'deviation_departments_charts'])->name('api.deviation_departments.chart');
Route::get('/charts/documents-by-severity', [ChartController::class, 'deviationSeverityLevel'])->name('api.document_by_severity.chart');
Route::get('/charts/documents-by-priority-deviation', [ChartController::class, 'documentByPriorityDeviation'])->name('api.document_by_priority_deviation.chart');
Route::get('/charts/deviation-stage-distribution', [ChartController::class, 'deviationStageDistribution'])->name('api.deviationStageDistribution.chart');
Route::post('/filter-deviation', [LogFilterController::class, 'deviation_filter'])->name('api.deviation.filter');





Route::get('Deviation-initial-categorization', [ChartController::class, 'getDeviationInitialCategorization'])->name('Deviation-initial-categorization');
Route::get('Deviation-post-categorization', [ChartController::class, 'getDeviationPostCategorization'])->name('Deviation-post-categorization');
Route::get('Deviation-ontime-delayed-records', [ChartController::class, 'getOnTimeVsDelayedRecordsDeviation'])->name('Deviation-ontime-delayed-records');
Route::get('Deviation-sitewise-records', [ChartController::class, 'getDeviationByDivision'])->name('Deviation-sitewise-records');
Route::get('Deviation-priority-records', [ChartController::class, 'getDeviationPriorityData'])->name('Deviation-priority-records');
Route::get('Deviation-status-records', [ChartController::class, 'getDeviationByStatus'])->name('Deviation-status-records');

//*********************************************Action item********************************
Route::get('ActionItem-priority-records', [ChartController::class, 'getActionItemPriorityData'])->name('ActionItem-priority-records');

//*********************************************Due Date Extension********************************


Route::get('DuedateExtension-initial-categorization', [ChartController::class, 'getDuedateExtensionInitialCategorization'])->name('DuedateExtension-initial-categorization');
Route::get('DuedateExtension-post-categorization', [ChartController::class, 'getDuedateExtensionPostCategorization'])->name('DuedateExtension-post-categorization');
Route::get('DuedateExtension-ontime-delayed-records', [ChartController::class, 'getOnTimeVsDelayedRecordsDuedateExtension'])->name('DuedateExtension-ontime-delayed-records');
Route::get('DuedateExtension-sitewise-records', [ChartController::class, 'getDuedateExtensionByDivision'])->name('DuedateExtension-sitewise-records');
Route::get('DuedateExtension-priority-records', [ChartController::class, 'getDuedateExtensionPriorityData'])->name('DuedateExtension-priority-records');
Route::get('DuedateExtension-status-records', [ChartController::class, 'getDuedateExtensionByStatus'])->name('DuedateExtension-status-records');
