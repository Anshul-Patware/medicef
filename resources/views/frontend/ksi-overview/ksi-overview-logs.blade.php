@extends('frontend.layout.main')

@section('container')
<br>

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

<style>
    .card-title {
        font-weight: bold;
        font-size: 24px;
        color: #eca035;
    }

    thead {
        background-color: #eca035;
        color: #000; 
        text-align: center;
    }

    tbody tr {
        text-align: center;
    }

    tbody tr:nth-child(even) {
        background-color: #f9f4eb;
    }

    .table-bordered {
        border: 1px solid #ddd;
    }

    .table-bordered th, .table-bordered td {
        padding: 12px;
        vertical-align: middle;
    }
 
    .table-responsive {
        max-height: 400px;
        overflow-y: auto;
    }
    
    .text-center {
        font-size: 16px;
        color: #eca035;
    }
</style>


 <div class="container" style="max-width: 1769px;">
    <h3 class="record-analytics-heading">
        <i class="fas fa-chart-bar"></i> KPI Analytics
    </h3>


<h5 class="card-title mt-3" style="text-align: center; font-weight: bold; font-size: 24px; color: #eca035;">{{$process}} Logs, Stage = {{$label}} </h5>

<div class="table-responsive mt-4">
    <table class="table table-bordered table-striped" id="kpiTable" style="border-radius: 10px; overflow: hidden; background-color: #fff;">
        <thead style="background-color: #eca035; color: #000; text-align: center;">
            <tr>
                <th>#</th>
                <th>ID</th>
                <th>Parent ID</th>
                <th>Division</th>
                <th>Process</th>
                <th>Initiated Through</th>
                <th>Short Description</th>
                <th>Date Opened</th>
                <th>Originator</th>
                <th>Due Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="11" class="text-center" style="font-size: 16px; color: #eca035;">Loading data...</td>
            </tr>
        </tbody>
    </table>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    const process = "{{ $process }}";
    const label = "{{ $label }}";
    let url = `{{ route('kpi.logs', ['process' => ':process', 'label' => ':label']) }}`
        .replace(':process', process)
        .replace(':label', label);
        
    if (window.location.href.indexOf('mydemosoftware') !== -1) {
        url = url.replace('http:', 'https:')
    }

    async function fetchAndRenderTable() {

        function formatDate(date) {
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    const formattedDate = new Date(date).toLocaleDateString('en-GB', options);
    return formattedDate;
}


        try {
            const res = await axios.get(url);

            if (res.data.status === 'ok') {
                const data = res.data.body;

                if (data && data.length > 0) {
                    const tableBody = document.querySelector('#kpiTable tbody');
                    tableBody.innerHTML = '';

                    const processRoutes = {
                        "Internal Audit": "{{ route('showInternalAudit', ['id' => 'recordId']) }}",
                        "Change Control": "{{ url('rcms/CC', ['id' => 'recordId']) }}",
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
                        "Calibration Management": "{{ route('showCalibrationDetails', ['id' => 'recordId']) }}",
                    };


                    data.forEach((row, index) => {
                        const tr = document.createElement('tr');
                        const routeName = processRoutes[process];

                        console.log('row', processRoutes[process]);

                        const detailUrl = processRoutes[process]?.replace('recordId', row.id) || '#';
                        console.log(detailUrl);


                        tr.innerHTML = `
                            <td>${index + 1}</td>
                            <td>
                                <a href="${detailUrl}" style="color: rgb(43, 43, 48);">
                                    ${String(row.id).padStart(4, '0')}
                                </a>
                            </td>
                            <td>${row.parent_id || '-'}</td>
                            <td>${row.division || '-'}</td>
                            <td>${row.type || row.form_type || '-'}</td>
                            <td>${row.initiated_through || '-'}</td>
                            <td>${row.short_description || '-'}</td>
                            <td>${formatDate(row.intiation_date) || '-'}</td>
                            <td>${row.originator || '-'}</td>
                            <td>${formatDate(row.due_date) || '-'}</td>
                            <td>${row.status || '-'}</td>
                        `;
                        tableBody.appendChild(tr);
                    });
                } else {
                    document.querySelector('#kpiTable tbody').innerHTML = `
                        <tr>
                            <td colspan="11" class="text-center">No records found.</td>
                        </tr>
                    `;
                }
            } else {
                console.error('Error fetching data:', res.data.message);
                document.querySelector('#kpiTable tbody').innerHTML = `
                    <tr>
                        <td colspan="11" class="text-center">Failed to fetch data.</td>
                    </tr>
                `;
            }
        } catch (err) {
            console.error('Error in API call:', err.message);
            document.querySelector('#kpiTable tbody').innerHTML = `
                <tr>
                    <td colspan="11" class="text-center">Failed to fetch data.</td>
                </tr>
            `;
        }
    }

    fetchAndRenderTable();
</script>

@endsection