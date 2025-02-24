@extends('frontend.layout.main')

@section('container')

<div class="container mt-4">
<style> 
.container {
    max-width: 1355px;
    margin: 0 auto;
}

th{
        min-width: 250px !important;
}


h5 {
    font-weight: bold;
    color: #333;
}


.card {
    background-color: #fff;
    border: 1px solid #dee2e6;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

.card .form-label {
    font-weight: bold;
    color: #495057;
}

.card .form-select, 
.card .form-control {
    border-radius: 4px;
    border: 1px solid #ced4da;
}

/* Buttons */
.btn-primary {
    background-color: #eca035;
    border-color: #eca035;
    color: #fff;
}

.btn-primary:hover {
    background-color: #eca035;
    border-color: #eca035;
}

.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
    color: #fff;
}

.btn-secondary:hover {
    background-color: #5a6268;
    border-color: #545b62;
}

.btn-outline-secondary {
    color: #6c757d;
    border-color: #6c757d;
}

.btn-outline-secondary:hover {
    color: #fff;
    background-color: #6c757d;
    border-color: #6c757d;
}

/* Table Section */
.table {
    border-collapse: collapse;
    margin: 20px 0;
    font-size: 16px;
    min-width: 100%;
    background-color: #fff;
}

.table th,
.table td {
    border: 1px solid #000;
    padding: 5px;
    text-align: center;
}

.table th {
    background-color: #eca035;
    color: #000;
    font-weight: bold;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f8f9fa;
}

/* Graph Section */
#AuditProgramInitialCategorization,
#AuditProgramInitialCategorizationDue {
    background-color: #fff;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 15px;
}

/* Loader */
#loader,
#loaderDue {
    margin: 20px auto;
}

.spinner-border {
    width: 3rem;
    height: 3rem;
}

/* Pagination */
.text-center .btn-sm {
    font-size: 14px;
    padding: 5px 10px;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .card .row {
        flex-direction: column;
    }

    .d-flex {
        flex-direction: column;
    }

    .btn {
        width: 100%;
        margin-bottom: 10px;
    }
}


.nav-tabs .nav-link {
    font-size: 16px; 
    color: black !important; 
    border: 1px solid #00000059;
    display: flex;
    align-items: center;
    gap: 8px; 
    font-weight: bold;
    border-radius: 10px;
}

.nav-tabs .nav-link i {
    font-size: 18px;
    color: #646464;
}

.nav-tabs .nav-link.active {
    background-color: #eca035;
    border-color: #ddd #ddd #fff;
    color: black !important;
    font-weight: bold;
    border-radius: 10px;
}

.nav-tabs .nav-link:hover {
    background-color: #eca035; 
    text-decoration: none;
 
}
.chart-due-btn.active {
    background-color: #eca035; 
    color: white;
}

.chart-buttons-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 20px; 
}

.text-end {
    text-align: right; 
}

.chart-due-btn {
    padding: 10px 15px;
    font-size: 16px;
    border-radius: 5px;
}


</style>

<style>
    .record-analytics-heading {
        display: flex;
        align-items: center;
        font-size: 1.8rem;
        font-weight: bold;
        color: #eca035; 
        margin-bottom: 20px;
        padding: 15px; 
        border: 2px solid #eca035; 
        border-radius: 10px; 
        text-align: center;
    }

    .record-analytics-heading i {
        margin-right: 10px;
        color: #eca035;
    }

    .card-text {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .card-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
        text-align: center;
    }

    .process-list {
        margin-top: 20px;
        list-style-type: none;
        padding: 0;
    }

    .process-item {
        font-size: 1.2rem;
        margin: 5px 0;
    }

    .process-count {
        display: inline-block;
        background-color: #eca035;
        color: white;
        font-weight: bold;
        padding: 5px 10px;
        border-radius: 5px;
        margin-left: 10px;
    }
</style>

<div class="container" style="max-width: 1769px;">
    <h3 class="record-analytics-heading">
        <i class="fas fa-chart-bar"></i> Department Analysis & Due Date Analysis
    </h3>

</div>
<br>

    <!-- Tabs Section -->
    <div class="container">
        <ul class="nav nav-tabs d-flex justify-content-center" id="analysisTabs" style="margin-bottom: 20px;>
            <li class="nav-item">
                <a class="nav-link active" id="departmentTab" data-bs-toggle="tab" href="#departmentAnalysis" style="padding: 12px 24px; font-size: 18px; color: #fff; font-weight: bold; border: 2px solid  rgb(51, 51, 51);; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: all 0.3s ease-in-out;">
                    <i class="fas fa-chart-bar"></i> Department Analysis
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="dueDateTab" data-bs-toggle="tab" href="#dueDateAnalysis"style="padding: 12px 24px; font-size: 18px; color: #fff; font-weight: bold;  border: 2px solid  rgb(51, 51, 51);; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: all 0.3s ease-in-out;">
                    <i class="fas fa-calendar-alt"></i> Due Date Analysis
                </a>
            </li>
        </ul>
    </div>
<br>    

    <!-- Tab Content -->
    <div class="tab-content mt-4">
        <!-- Department Analysis Content -->
        <div class="tab-pane fade show active" id="departmentAnalysis">
            <div class="container mt-4">

                <!-- Filter Section -->
                <div class="card mb-4 p-3">
                    <div class="row gx-2 gy-2">
                        <!-- Department Filter -->
                        <div class="col-12 col-md-2">
                            <label for="filterDepartment" class="form-label">Department</label>
                            <select id="filterDepartment" class="form-select">
                                <option value="">All Departments</option>
                            </select>
                        </div>

                        <!-- Division Filter -->
                        <div class="col-12 col-md-2">
                            <label for="filterDivision" class="form-label">Division</label>
                            <select id="filterDivision" class="form-select">
                                <option value="">All Divisions</option>
                            </select>
                        </div>

                        <!-- Process Filter -->
                        <div class="col-12 col-md-2">
                            <label for="filterProcess" class="form-label">Process</label>
                            <select id="filterProcess" class="form-select">
                                <option value="">All Processes</option>
                            </select>
                        </div>


                        <!-- Start Date Filter -->
                        <div class="col-12 col-md-3">
                            <label for="startInitDate" class="form-label">Start Date</label>
                            <input type="date" id="startInitDate" class="form-control">
                        </div>

                        <!-- End Date Filter -->
                        <div class="col-12 col-md-3">
                            <label for="endInitDate" class="form-label">End Date</label>
                            <input type="date" id="endInitDate" class="form-control">
                        </div>
                    </div>

                    <!-- Filter Buttons -->
                    <div class="row gx-2 mt-3 justify-content-center">
                        <div class="col-12 col-md-2 d-flex align-items-center">
                            <button id="applyFilters" class="btn btn-primary w-100">Apply</button>
                        </div>
                        <div class="col-12 col-md-2 d-flex align-items-center">
                            <button id="resetFilters" class="btn btn-secondary w-100">Reset</button>
                        </div>
                        <div class="col-12 col-md-2 d-flex align-items-center">
                            <button id="refreshPage" class="btn btn-success w-100">Refresh</button>
                        </div>
                    </div>

                </div>


                <div class="container">
                    <div class="row justify-content-center align-items-center">
                    <!-- Chart Buttons in the center -->
                    {{-- <div class="d-flex"> --}}
                        <div class="col-12 col-md-8">
                        <button class="btn btn-outline-secondary chart-btn me-2" data-chart="column" title="Bar Chart">
                            <i class="bi bi-bar-chart"></i>
                        </button>
                        <button class="btn btn-outline-secondary chart-btn me-2" data-chart="pie" title="Pie Chart">
                            <i class="bi bi-pie-chart"></i>
                        </button>
                        <button class="btn btn-outline-secondary chart-btn me-2" data-chart="line" title="Line Chart">
                            <i class="bi bi-graph-up"></i>
                        </button>
                        <button class="btn btn-outline-secondary chart-btn" data-chart="scatter" title="Scatter Chart">
                            <i class="bi bi-cloud"></i>
                        </button>
                    </div>

                    
                    <div class="col-12 col-md-4 d-flex justify-content-end">
                    <!-- Generate Report Button on the right -->
                    <form id="navigateForm" method="POST" action="{{ route('storeDeptAnalysisDataset') }}">
                        @csrf
                        <input hidden name="chartType" value="" id="chartTypeInput"> <!-- Example: Chart type -->
                        <input hidden name="dataSet" id="dataSetInput" value="">
                        <!-- Dataset will be set dynamically -->
                        <div style="text-align: right;">
                            <button id="generateReportBtn" class="btn btn-primary">
                                <i class="bi bi-file-earmark-bar-graph" style="margin-right: 5px;"></i> Generate Report
                            </button>
                    </form>
                </div>
            </div>
        </div>
<br>



                <!-- Loader Section -->
                <div id="loader" class="text-center" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <!-- Graph Section -->
                <div id="AuditProgramInitialCategorization" style="width: 100%; height: 500px;"></div>

                <!-- Table Section -->
                <div class="mt-4">
                    <h5 class="text-center">Record Details</h5>
                    <div class="table-responsive" style="margin: 0 15px;">
                        <table class="table table-bordered table-striped text-center w-100">
                           <thead>
                                <tr>
                                    <th style=" min-width: 60px !important;">S. No</th>
                                    <th>Record ID</th>
                                    <th>Process</th>
                                    <th>Division</th>
                                    <th>Department</th>
                                    <th>Originator</th>
                                    <th>Date Opened</th>
                                    <th>Date Closed</th>
                                    <th>Due Date</th>
                                    <th>Days Due</th>
                                    <th>Created At</th>
                                    <th>Status</th>
                                    <th>Priority</th>
                                    <th>Initial Category</th>
                                    <th>Final Category</th>
                                    <th>Root Cause Category</th>
                                    <th>Root Cause Sub-Category</th>
                                </tr>
                            </thead>
                            <tbody id="recordsTableBody"></tbody>
                        </table>
                    </div>
                </div>


                <!-- Pagination -->
                <div class="text-center mt-3 mb-3">
                    <button id="prevPage" class="btn btn-sm btn-secondary me-2">Previous</button>
                    <span id="pageInfo" class="mx-2"></span>
                    <button id="nextPage" class="btn btn-sm btn-secondary">Next</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Due Date Analysis Content -->
    <div class="tab-pane fade" id="dueDateAnalysis">
        <div class="container mt-4">

            <!-- Filter Section -->
            <div class="card mb-4 p-3">
                <div class="row gx-2 gy-2">
                    <!-- Department Filter -->
                    <div class="col-12 col-md-2">
                        <label for="filterDueDepartment" class="form-label">Department</label>
                        <select id="filterDueDepartment" class="form-select">
                            <option value="">All Departments</option>
                        </select>
                    </div>

                    <!-- Division Filter -->
                    <div class="col-12 col-md-2">
                        <label for="filterDueDivision" class="form-label">Division</label>
                        <select id="filterDueDivision" class="form-select">
                            <option value="">All Divisions</option>
                        </select>
                    </div>

                    <!-- Process Filter -->
                    <div class="col-12 col-md-2">
                        <label for="filterDueProcess" class="form-label">Process</label>
                        <select id="filterDueProcess" class="form-select">
                            <option value="">All Processes</option>
                        </select>
                    </div>


                    <!-- Start Date Filter -->
                    <div class="col-12 col-md-3">
                        <label for="startDueDate" class="form-label">Due Date From</label>
                        <input type="date" id="startDueDate" class="form-control">
                    </div>

                    <!-- End Date Filter -->
                    <div class="col-12 col-md-3">
                        <label for="endDueDate" class="form-label">Due Date Till</label>
                        <input type="date" id="endDueDate" class="form-control">
                    </div>
                </div>

                <!-- Filter Buttons -->
                <div class="row gx-2 mt-3 justify-content-center">
                    <div class="col-12 col-md-2 d-flex align-items-center">
                        <button id="applyDueFilters" class="btn btn-primary w-100">Apply</button>
                    </div>
                    <div class="col-12 col-md-2 d-flex align-items-center">
                        <button id="resetDueFilters" class="btn btn-secondary w-100">Reset</button>
                    </div>
                    <div class="col-12 col-md-2 d-flex align-items-center">
                        <button id="refreshPage1" class="btn btn-success w-100">Refresh</button>
                    </div>
                </div>

            </div>

            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <!-- Chart Buttons - Centered -->
                    <div class="col-12 col-md-8">
                        <button class="btn btn-outline-secondary chart-due-btn me-2" data-chart="column" title="Bar Chart">
                            <i class="bi bi-bar-chart"></i>
                        </button>
                        <button class="btn btn-outline-secondary chart-due-btn me-2" data-chart="pie" title="Pie Chart">
                            <i class="bi bi-pie-chart"></i>
                        </button>
                        <button class="btn btn-outline-secondary chart-due-btn me-2" data-chart="line" title="Line Chart">
                            <i class="bi bi-graph-up"></i>
                        </button>
                        <button class="btn btn-outline-secondary chart-due-btn" data-chart="scatter" title="Scatter Chart">
                            <i class="bi bi-cloud"></i>
                        </button>
                    </div>
            
                    <!-- Generate Report Button - Right Side -->
                    <div class="col-12 col-md-4 d-flex justify-content-end">
                        <form id="navigateDueForm" method="POST" action="{{ route('storeDueDateAnalysisDataset') }}">
                            @csrf
                            <input hidden name="chartTypeDue" value="" id="chartTypeInputDue">
                            <input hidden name="dataSetDue" id="dataSetInputDue" value="">
            
                            <button id="generateDueReportBtn" class="btn btn-primary">
                                <i class="bi bi-file-earmark-bar-graph" style="margin-right: 5px;"></i> Generate Report
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            
              <br>



            <!-- Loader Section -->
            <div id="loaderDue" class="text-center" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>

            <!-- Graph Section -->
            <div id="AuditProgramInitialCategorizationDue" style="width: 100%; height: 500px;"></div>

            <!-- Table Section -->
            <div class="mt-4">
                <h5 class="text-center">Record Details</h5>
                <div class="table-responsive" style="margin: 0 15px;">
                    <table class="table table-bordered table-striped text-center w-100">
                        <thead>
                            <tr>
                                <th>S. No</th>
                                <th>Record ID</th>
                                <th>Process</th>
                                <th>Division</th>
                                <th>Department</th>
                                <th>Originator</th>
                                <th>Date Opened</th>
                                <th>Date Closed</th>
                                <th>Due Date</th>
                                <th>Days Due</th>
                                <th>Created At</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Initial Category</th>
                                <th>Final Category</th>
                                <th>Root Cause Category</th>
                                <th>Root Cause Sub-Category</th>
                            </tr>
                        </thead>
                        <tbody id="recordsTableBodyDue"></tbody>
                    </table>
                </div>
            </div>


            <!-- Pagination -->
            <div class="text-center mt-3 mb-3">
                <button id="prevPageDue" class="btn btn-sm btn-secondary me-2">Previous</button>
                <span id="pageInfoDue" class="mx-2"></span>
                <button id="nextPageDue" class="btn btn-sm btn-secondary">Next</button>
            </div>
        </div>
    </div>

</div>

<!-- Include Highcharts Scripts -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
    document.querySelectorAll('.chart-due-btn').forEach(button => {
    button.addEventListener('click', function() {
        document.querySelectorAll('.chart-due-btn').forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');
    });
});

</script>

<script>
    let currentPage = 1;
    const recordsPerPage = 5;
    let allRecords = [];
    let filteredRecords = [];
    let currentChartType = 'column'; // Default chart type

    // Function to calculate days due
    // function calculateDaysDue(dueDate) {
    //     const today = new Date();
    //     const due = new Date(dueDate);
    //     return Math.ceil((due - today) / (1000 * 60 * 60 * 24));
    // }
    function calculateDaysDue(dueDate) {
    const today = new Date();
    const due = new Date(dueDate);
    const diffDays = Math.ceil((due - today) / (1000 * 60 * 60 * 24));

    if (diffDays < 0) {
        return { days: `Overdue (${Math.abs(diffDays)})`, color: 'red' }; // Show "Overdue (number)"
    } else if (diffDays <= 7) {
        return { days: diffDays, color: 'orange' }; // Under 7 days
    } else {
        return { days: diffDays, color: 'green' }; // More than 7 days
    }
}

    // Function to format date as dd-mm-yy
    // function formatDate(dateString) {
    //     const date = new Date(dateString);
    //     const day = String(date.getDate()).padStart(2, '0');
    //     const month = String(date.getMonth() + 1).padStart(2, '0');
    //     const year = String(date.getFullYear()).slice(-2);
    //     return `${day}-${month}-${year}`;
    // }

    function formatDate(date) {
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    const formattedDate = new Date(date).toLocaleDateString('en-GB', options);
    return formattedDate;
}

    function prepareFormType(formType) {
        switch (formType) {
            case 'CC':
                return 'Change Control'
                break;
        
            default:
                return formType
                break;
        }
    }
    // Render table
    function renderTable(records, page) {
        const tableBody = document.getElementById('recordsTableBody');
        tableBody.innerHTML = '';

        const processRoutes = {
            "Internal Audit": "{{ route('showInternalAudit', ['id' => 'recordId']) }}",
            "CC": "{{ url('rcms/CC', ['id' => 'recordId']) }}",
            "Global Change Control": "{{ url('rcms/global-cc-edit', ['id' => 'recordId']) }}",
            "Global Capa":"{{ url('globalCapaShow', ['id' => 'recordId']) }}",
            "Audit Program": "{{ url('showAuditProgram', ['id' => 'recordId']) }}",
            "Supplier": "{{ url('rcms/supplier-show', ['id' => 'recordId']) }}",
            "Supplier Audit": "{{ route('showSupplierAudit', ['id' => 'recordId']) }}",
            "Complaint Management": "{{ route('marketcomplaint.marketcomplaint_view', ['id' => 'recordId']) }}",
            "Risk Assessment": "{{ route('showRiskManagement', ['id' => 'recordId']) }}",
            "Equipment Lifecycle": "{{ route('showEquipmentInfo', ['id' => 'recordId']) }}",
            "Lab Incident": "{{ route('ShowLabIncident', ['id' => 'recordId']) }}",
            "Incident": "{{ route('incident-show', ['id' => 'recordId']) }}",
            "External Audit": "{{ route('showExternalAudit', ['id' => 'recordId']) }}",
            "Action Item": "{{ url('rcms/actionItem', ['id' => 'recordId']) }}",
            "Extension": "{{ url('extension_newshow', ['id' => 'recordId']) }}",
            "Effectiveness Check": "{{ url('effectiveness.show', ['id' => 'recordId']) }}",
            "CAPA": "{{ url('capashow', ['id' => 'recordId']) }}",
            "Preventive Maintenance": "{{ route('showpreventive', ['id' => 'recordId']) }}",
            "Deviation": "{{ route('devshow', ['id' => 'recordId']) }}",
            "Root Cause Analysis": "{{ route('root_show', ['id' => 'recordId']) }}",
            "Calibration Details": "{{ route('showCalibrationDetails', ['id' => 'recordId']) }}",
        };

        const start = (page - 1) * recordsPerPage;
        const end = start + recordsPerPage;

        const paginatedRecords = records.slice(start, end);

        paginatedRecords.forEach((record, index) => {

            let formType;
            if (record.form_type) {
                formType = record.form_type;
            } else if (record.type) {
                formType = record.type;
            } else {
                formType = 'N/A';
            }

            let InitialCategorization;
            if (record.Initial_Categorization) {
                InitialCategorization = record.Initial_Categorization;
            } else if (record.severity1_level) {
                InitialCategorization = record.severity1_level;
            } else {
                InitialCategorization = 'N/A';
            }

            formType = prepareFormType(formType)

            const detailUrl = `#`;
            const { days, color } = calculateDaysDue(record.due_date);
            tableBody.innerHTML += `
                <tr>
                    <td>${start + index + 1}</td>
                    <td><a href="${detailUrl}" style="color: rgb(43, 43, 48);">${String(record.id).padStart(4, '0')}</a></td>
                    <td>${formType}</td>
                    <td>${record.division}</td>
                    <td>${record.department}</td>
                    <td>${record.originator}</td>
                    <td>${formatDate(record.intiation_date)}</td>
                    <td>${'-'}</td>
                    <td>${formatDate(record.due_date)}</td>
                    <td style="color: ${color}; font-weight: bold;">${days}</td> <!-- Only show days value here -->
                    <td>${formatDate(record.created_at)}</td>
                    <td>${record.status || '-'}</td>
                    <td>${record.priority_data || '-'}</td>
                    <td>${InitialCategorization || '-'}</td>
                    <td>${record.Post_Categorization || '-'}</td>
                    <td>${record.rcc || '-'}</td>
                    <td>${record.rcsc || '-'}</td>
                </tr>`;
        });

        const totalPages = Math.ceil(records.length / recordsPerPage);
        document.getElementById('pageInfo').innerText = `Page ${currentPage} of ${totalPages}`;
    }

    // Render graph based on selected chart type
    function renderGraph(records, chartType = 'column') {
        const counts = {};
        records.forEach(record => {
            counts[record.department] = (counts[record.department] || 0) + 1;
        });

        const categories = Object.keys(counts);
        const values = Object.values(counts);

        // Prepare Pie chart data
        const pieData = categories.map((category, index) => {
            return { name: category, y: values[index] };
        });

        Highcharts.chart('AuditProgramInitialCategorization', {
            chart: { type: chartType },
            title: { text: 'Department Analytics' },
            xAxis: chartType !== 'pie' ? { categories } : null, // No xAxis for pie chart
            yAxis: chartType !== 'pie' ? { title: { text: 'Count' } } : null, // No yAxis for pie chart
            series: chartType === 'pie'
                ? [{ name: 'Departments', colorByPoint: true, data: pieData }]
                : [{ name: 'Departments', data: values }],
            credits: { enabled: false }
        });
    }

    fetch('/api/capa-by-department-analytics')
        .then(res => res.json())
        .then(data => {
            document.getElementById('loader').style.display = 'none';
            allRecords = data.records;
            filteredRecords = allRecords;

            // Step 1: Extract unique values
            const departments = [...new Set(allRecords.map(record => record.department))];
            const divisions = [...new Set(allRecords.map(record => record.division))];
            const processes = [...new Set(allRecords.map(record => record.form_type || record.type))];

            // Step 2: Populate dropdowns
            const populateDropdown = (dropdownId, items) => {
                const dropdown = document.getElementById(dropdownId);
                items.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item;
                    option.textContent = item;
                    dropdown.appendChild(option);
                });
            };

            populateDropdown('filterDepartment', departments);
            populateDropdown('filterDivision', divisions);
            populateDropdown('filterProcess', processes);

            // Step 3: Render initial table and graph
            renderTable(filteredRecords, currentPage);
            renderGraph(filteredRecords);

            // Event Listeners
            document.getElementById('applyFilters').addEventListener('click', applyFilters);
            document.getElementById('resetFilters').addEventListener('click', resetFilters);

            document.getElementById('nextPage').addEventListener('click', () => {
                if ((currentPage * recordsPerPage) < filteredRecords.length) {
                    currentPage++;
                    renderTable(filteredRecords, currentPage);
                }
            });

            document.getElementById('prevPage').addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    renderTable(filteredRecords, currentPage);
                }
            });

            document.querySelectorAll('.chart-btn').forEach(button => {
                button.addEventListener('click', () => {
                    currentChartType = button.getAttribute('data-chart');
                    renderGraph(filteredRecords, currentChartType);
                });
            });
        })
        .catch(err => console.error(err));

    // Updated filter logic
    function applyFilters() {
        const department = document.getElementById('filterDepartment').value;
        const division = document.getElementById('filterDivision').value;
        const process = document.getElementById('filterProcess').value;
        const startInitDate = document.getElementById('startInitDate').value;
        const endInitDate = document.getElementById('endInitDate').value;

        filteredRecords = allRecords.filter(record => {
            return (!department || record.department === department) &&
                (!division || record.division === division) &&
                (!process || record.form_type === process) &&
                (!startInitDate || new Date(record.intiation_date) >= new Date(startInitDate)) &&
                (!endInitDate || new Date(record.intiation_date) <= new Date(endInitDate));
        });

        currentPage = 1;
        renderTable(filteredRecords, currentPage);
        renderGraph(filteredRecords, currentChartType);
    }

    function resetFilters() {
        document.querySelectorAll('select, input').forEach(input => input.value = '');
        filteredRecords = allRecords;
        currentPage = 1;
        renderTable(filteredRecords, currentPage);
        renderGraph(filteredRecords, currentChartType);
    }


    document.getElementById('generateReportBtn').addEventListener('click', (e) => {
        e.preventDefault(); // Prevent immediate form submission

        // Set chartTypeInput and dataSet in the form inputs
        document.getElementById('chartTypeInput').value = currentChartType;
        document.getElementById('dataSetInput').value = JSON.stringify(filteredRecords);

        // Submit the form after setting the values
        document.getElementById('navigateForm').submit();
    });


</script>


<script>
    let allDueCounts = [];
    let currentPageDue = 1;
    const recordsPerPageDue = 5;
    let allDueRecords = [];
    let filteredDueRecords = [];
    let currentDueChartType = 'column'; // Default chart type

    // Function to calculate days due
    // function calculateDaysDue(dueDate) {
    //     const today = new Date();
    //     const due = new Date(dueDate);
    //     return Math.ceil((due - today) / (1000 * 60 * 60 * 24));
    // }

    function calculateDaysDue(dueDate) {
    const today = new Date();
    const due = new Date(dueDate);
    const diffDays = Math.ceil((due - today) / (1000 * 60 * 60 * 24));

    if (diffDays < 0) {
        return { days: `Overdue (${Math.abs(diffDays)})`, color: 'red' }; // Show "Overdue (number)"
    } else if (diffDays <= 7) {
        return { days: diffDays, color: 'orange' }; // Under 7 days
    } else {
        return { days: diffDays, color: 'green' }; // More than 7 days
    }
}


    // Function to format date as dd-mm-yy
    // function formatDate(dateString) {
    //     const date = new Date(dateString);
    //     const day = String(date.getDate()).padStart(2, '0');
    //     const month = String(date.getMonth() + 1).padStart(2, '0');
    //     const year = String(date.getFullYear()).slice(-2);
    //     return `${day}-${month}-${year}`;
    // }
function formatDate(date) {
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    const formattedDate = new Date(date).toLocaleDateString('en-GB', options);
    return formattedDate;
}

    function prepareFormType(formType) {
            switch (formType) {
                case 'CC':
                    return 'Change Control'
                    break;
            
                default:
                    return formType
                    break;
            }
        }

    // Render table
    function renderDueTable(records, page) {
        const tableBody = document.getElementById('recordsTableBodyDue');
        tableBody.innerHTML = '';

        const processRoutes = {
            "Internal Audit": "{{ route('showInternalAudit', ['id' => 'recordId']) }}",
            "CC": "{{ url('rcms/CC', ['id' => 'recordId']) }}",
            "Global Change Control": "{{ url('rcms/global-cc-edit', ['id' => 'recordId']) }}",
            "Global Capa":"{{ url('globalCapaShow', ['id' => 'recordId']) }}",
            "Audit Program": "{{ url('showAuditProgram', ['id' => 'recordId']) }}",
            "Supplier": "{{ url('rcms/supplier-show', ['id' => 'recordId']) }}",
            "Supplier Audit": "{{ route('showSupplierAudit', ['id' => 'recordId']) }}",
            "Complaint Management": "{{ route('marketcomplaint.marketcomplaint_view', ['id' => 'recordId']) }}",
            "Risk Assessment": "{{ route('showRiskManagement', ['id' => 'recordId']) }}",
            "Equipment Lifecycle": "{{ route('showEquipmentInfo', ['id' => 'recordId']) }}",
            "Lab Incident": "{{ route('ShowLabIncident', ['id' => 'recordId']) }}",
            "Incident": "{{ route('incident-show', ['id' => 'recordId']) }}",
            "External Audit": "{{ route('showExternalAudit', ['id' => 'recordId']) }}",
            "Action Item": "{{ url('rcms/actionItem', ['id' => 'recordId']) }}",
            "Extension": "{{ url('extension_newshow', ['id' => 'recordId']) }}",
            "Effectiveness Check": "{{ url('effectiveness.show', ['id' => 'recordId']) }}",
            "CAPA": "{{ url('capashow', ['id' => 'recordId']) }}",
            "Preventive Maintenance": "{{ route('showpreventive', ['id' => 'recordId']) }}",
            "Deviation": "{{ route('devshow', ['id' => 'recordId']) }}",
            "Root Cause Analysis": "{{ route('root_show', ['id' => 'recordId']) }}",
            "Calibration Details": "{{ route('showCalibrationDetails', ['id' => 'recordId']) }}",
        };

        const start = (page - 1) * recordsPerPageDue;
        const end = start + recordsPerPageDue;

        const paginatedRecords = records.slice(start, end);

        paginatedRecords.forEach((record, index) => {

            let formType;
            if (record.form_type) {
                formType = record.form_type;
            } else if (record.type) {
                formType = record.type;
            } else {
                formType = 'N/A';
            }

            let InitialCategorization;
            if (record.Initial_Categorization) {
                InitialCategorization = record.Initial_Categorization;
            } else if (record.severity1_level) {
                InitialCategorization = record.severity1_level;
            } else {
                InitialCategorization = 'N/A';
            }

            formType = prepareFormType(formType)


            const detailUrl = `#`;
            const { days, color } = calculateDaysDue(record.due_date);
            tableBody.innerHTML += `
                <tr>
                    <td>${start + index + 1}</td>
                    <td><a href="${detailUrl}" style="color: rgb(43, 43, 48);">${String(record.id).padStart(4, '0')}</a></td>
                    <td>${formType}</td>
                    <td>${record.division}</td>
                    <td>${record.department}</td>
                    <td>${record.originator}</td>
                    <td>${formatDate(record.intiation_date)}</td>
                    <td>${'-'}</td>
                    <td>${formatDate(record.due_date)}</td>
                    <td style="color: ${color}; font-weight: bold;">${days}</td> <!-- Only show days value here -->
                    <td>${formatDate(record.created_at)}</td>
                    <td>${record.status || '-'}</td>
                    <td>${record.priority_data || '-'}</td>
                    <td>${InitialCategorization || '-'}</td>
                    <td>${record.Post_Categorization || '-'}</td>
                    <td>${record.rcc || '-'}</td>
                    <td>${record.rcsc || '-'}</td>
                </tr>`;
        });

        const totalPages = Math.ceil(records.length / recordsPerPageDue);
        document.getElementById('pageInfoDue').innerText = `Page ${currentPageDue} of ${totalPages}`;
    }

    // Render graph based on selected chart type
    function renderDueGraph(records, chartTypeDue = 'column') {
        const counts = {};
        records.forEach(record => {
            counts[record.due_date_status] = (counts[record.due_date_status] || 0) + 1;
        });

        const categories = Object.keys(counts);
        const values = Object.values(counts);

        // Prepare Pie chart data
        const pieData = categories.map((category, index) => {
            return { name: category, y: values[index] };
        });

        Highcharts.chart('AuditProgramInitialCategorizationDue', {
            chart: { type: chartTypeDue },
            title: { text: 'Due-Date Analytics' },
            xAxis: chartTypeDue !== 'pie' ? { categories } : null, // No xAxis for pie chart
            yAxis: chartTypeDue !== 'pie' ? { title: { text: 'Count' } } : null, // No yAxis for pie chart
            series: chartTypeDue === 'pie'
                ? [{ colorByPoint: true, data: pieData }]
                : [{ data: values }],
            credits: { enabled: false }
        });
    }

    fetch('/api/capa-by-due-date-analytics')
        .then(res => res.json())
        .then(data => {
            document.getElementById('loaderDue').style.display = 'none';
            allDueRecords = data.records;
            allDueCounts = data.counts
            filteredDueRecords = allDueRecords;

            // Step 1: Extract unique values
            const departments = [...new Set(allDueRecords.map(record => record.department))];
            const divisions = [...new Set(allDueRecords.map(record => record.division))];
            const processes = [...new Set(allDueRecords.map(record => record.form_type))];

            // Step 2: Populate dropdowns
            const populateDropdown = (dropdownId, items) => {
                const dropdown = document.getElementById(dropdownId);
                items.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item;
                    option.textContent = item;
                    dropdown.appendChild(option);
                });
            };

            populateDropdown('filterDueDepartment', departments);
            populateDropdown('filterDueDivision', divisions);
            populateDropdown('filterDueProcess', processes);

            // Step 3: Render initial table and graph
            renderDueTable(filteredDueRecords, currentPageDue);
            renderDueGraph(filteredDueRecords);

            // Event Listeners
            document.getElementById('applyDueFilters').addEventListener('click', applyDueFilters);
            document.getElementById('resetDueFilters').addEventListener('click', resetDueFilters);
            document.getElementById('refreshPage').addEventListener('click', function () {
                location.reload(); // Reloads the current page
            });

              document.getElementById('refreshPage1').addEventListener('click', function () {
                location.reload(); // Reloads the current page
            });


            document.getElementById('nextPageDue').addEventListener('click', () => {
                if ((currentPageDue * recordsPerPageDue) < filteredDueRecords.length) {
                    currentPageDue++;
                    renderDueTable(filteredDueRecords, currentPageDue);
                }
            });

            document.getElementById('prevPageDue').addEventListener('click', () => {
                if (currentPageDue > 1) {
                    currentPageDue--;
                    renderDueTable(filteredDueRecords, currentPageDue);
                }
            });

            document.querySelectorAll('.chart-due-btn').forEach(button => {
                button.addEventListener('click', () => {
                    currentDueChartType = button.getAttribute('data-chart');
                    renderDueGraph(filteredDueRecords, currentDueChartType);
                });
            });
        })
        .catch(err => console.error(err));

    // Updated filter logic
    function applyDueFilters() {
        const department = document.getElementById('filterDueDepartment').value;
        const division = document.getElementById('filterDueDivision').value;
        const process = document.getElementById('filterDueProcess').value;
        const startInitDate = document.getElementById('startDueDate').value;
        const endInitDate = document.getElementById('endDueDate').value;

        filteredDueRecords = allDueRecords.filter(record => {
            return (!department || record.department === department) &&
                (!division || record.division === division) &&
                (!process || record.form_type === process) &&
                (!startInitDate || new Date(record.due_date) >= new Date(startInitDate)) &&
                (!endInitDate || new Date(record.due_date) <= new Date(endInitDate));
        });

        currentDuePage = 1;
        renderDueTable(filteredDueRecords, currentPageDue);
        renderDueGraph(filteredDueRecords, currentDueChartType);
    }

    function resetDueFilters() {
        document.querySelectorAll('select, input').forEach(input => input.value = '');
        filteredDueRecords = allDueRecords;
        currentPageDue = 1;
        renderDueTable(filteredDueRecords, currentPageDue);
        renderDueGraph(filteredDueRecords, currentDueChartType);
    }


    document.getElementById('generateDueReportBtn').addEventListener('click', (e) => {
        e.preventDefault(); // Prevent immediate form submission

        // Set chartTypeInput and dataSet in the form inputs
        document.getElementById('chartTypeInputDue').value = currentDueChartType;
        document.getElementById('dataSetInputDue').value = JSON.stringify(filteredDueRecords);

        // Submit the form after setting the values
        document.getElementById('navigateDueForm').submit();
    });


</script>

@endsection