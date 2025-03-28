@extends('frontend.rcms.layout.main_rcms')
@section('rcms_container')

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <hr>
    <style>
        header .header_rcms_bottom {
            display: none;
        }      
    </style>


    <div id="rcms-desktop" style = 'background: white;'>
        

        <div class="main-content">
            <div class="container-fluid">
                <div class="process-tables-list">
                    {{-- <div class="process-table active" id="internal-audit">
                        <div class="mt-1 mb-2 bg-white" style="height: 55px; display: flex; justify-content: space-between; align-items: center;border-bottom: none;"> --}}
                        
     
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

       
       <!-- Include Bootstrap CSS -->




<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>



<!-- Bootstrap and jQuery scripts for the dropdown to work -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
              
                        <div>
                            <div class="row justify-content-center">
                                    <div class="active text-center" onclick="openTab('internal-audit', this)" 
                                        style="padding: 12px; cursor: pointer; 
                                            border-top: 2px solid #000; 
                                            border-bottom: 2px solid #000;">
                                        <strong>Due Date Extension Log</strong>

                            </div>
                                </div>
                            </div>
                        </div>

                        </div>

                        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.7.2/axios.min.js" crossorigin="anonymous"></script>
                    </div>

                    <div class="scope-bar d-flex justify-content-end py-1">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 80px;">
                                Export
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{ route('export.csv') }}">CSV Export</a>
                                <a class="dropdown-item" href="{{ route('export.excel') }}">Excel Export</a>
                                <a class="dropdown-item" href="#" onclick="printTable()">Print</a>
                            </div>
                        </div>
                    </div>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

                        @php
                        $department = [
                            'CQA' => "Corporate Quality Assurance",
                            'QA'  => "Quality Assurance",
                            'QC'  => "Quality Control",
                            'QM'  => "Quality Control (Microbiology department)",
                            'PG'  => "Production General",
                            'PL'  => "Production Liquid Orals",
                            'PT'  => "Production Tablet and Powder",
                            'PE'  => "Production External (Ointment, Gels, Creams and
                            Liquid)",
                            'PC'  => "Production Capsules",
                            'PI'  => "Production Injectable",
                            'EN'  => "Engineering",
                            'HR'  => "Human Resource",
                            'ST'  => "Store",
                            'IT'  => "Electronic Data Processing",
                            'FD'  => "Formulation Development",
                            'AL'  => "Analytical research and Development Laboratory",
                            'PD'  => "Packaging Development",
                            'PU'  => "Purchase Department",
                            'DC'  => "Document Cell",
                            'RA'  => "Regulatory Affairs",
                            'PV'  => "Pharmacovigilance",
                                                 
                            ];

                                                    @endphp
                        <div class="container-fluid">
                            <div class="process-tables-list">
                                <div class="process-table active" id="internal-audit">
                                    <div class="mt-1 mb-2 bg-white" style="height: auto; padding: 10px; margin: 5px;">
                                        <div class="d-flex align-items-center">
                                            <div class="filter-bar row">
                                                <!-- Department Filter -->
                                                <div class="col-md-3 mb-3">
                                                    <label for="initiator_group">Department:</label>
                                                    <select multiple name="initiator_group[]" id="initiator_group" data-search="false" data-silent-initial-value-set="true">
                                                        @if (!empty($department))
                                                            @foreach (collect($department)->sort() as $code => $dpt)
                                                            <option value="{{ $code }}">{{ $dpt }}</option>    
                                                            @endforeach
                                                        @endif
                                                    </select>

                                                </div>
                                                



                        
                                                <!-- Initiator Filter -->
                                                @php
                                                $users = DB::table('users')->get();
                                                @endphp
                                                <div class="col-md-3 mb-3">
                                                    <label for="initiator">Initiator:</label>
                                                    <select class="custom-select" multiple name="initiator" id="initiator_id">
                                                        <option value="">Select Initiator</option>
                                                        @foreach($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                        
                                                <!-- Division Filter -->
                                                <div class="col-md-2 mb-3">
                                                    <label for="division_id">Division:</label>
                                                    <select class="custom-select" id="division_id_cc">
                                                        <option value="">Select Option</option>
                                                        <option value="1">Corporate</option>
                                                        <option value="2">Plant</option>
                                                    </select>
                                                </div>
                        
                                                <!-- Start Date Filter -->
                                                <div class="col-md-2 mb-3">
                                                    <label for="date_from_deviation">Start Date:</label>
                                                    <input type="date" class="custom-select" id="date_fromCc">
                                                </div>
                        
                                                <!-- End Date Filter -->
                                                <div class="col-md-2 mb-3">
                                                    <label for="date_to_deviation">End Date:</label>
                                                    <input type="date" class="custom-select" id="date_toCc">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        


                <style>
                th.sortable {
                    cursor: pointer;
                    /* color: #007bff; */
                }
                th.sortable:hover {
                    
                }
                .spinner-border {
                    display: none;
                }
            </style>



<div id="rcms-desktop">
    <div class="main-content">
        <div class="container-fluid" style="padding: 0; border:solid 1px; background-color: #fff;">
            <div class="process-tables-list">
                <div class="process-table active" id="internal-audit">
                    <div class="scroll-container">
                        <div class="table-block">
                            <!-- Search Bar -->
                            <div style="padding: 10px; display: flex; justify-content: space-between; align-items: center; gap: 5px;">
                                <div>
                                    <select id="dateFilter" onchange="filterByDueDate()" style="padding: 10px; border: 1px solid #000; border-radius: 5px; font-size: 14px;">
                                        <option value="">Filter by</option>
                                        <option value="weekly">Weekly</option>
                                        <option value="monthly">Monthly</option>
                                        <option value="yearly">Yearly</option>
                                    </select>
                                </div>
                                <div style="position: relative; width: 300px;">
                                    <input 
                                        type="text" 
                                        id="searchBar" 
                                        placeholder="Search..." 
                                        onkeyup="filterTable()" 
                                        style="padding: 10px 35px 10px 10px; width: 100%; border: 1px solid #000; border-radius: 5px; font-size: 14px;"
                                    >
                                    <span 
                                        style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: #000; font-size: 16px; cursor: pointer;">
                                        🔍
                                    </span>
                                </div>
                            </div>
                            
                          
                            <div class="table-responsive" style="height: 500px; overflow-y: auto; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                <table class="table table-bordered table-hover" style="background-color: #fff; border-collapse: collapse; text-align: left;">
                                    <thead style="background-color: #797979; color: #000;">
                                        <tr>
                                            <th class="sortable" onclick="sortTable('id')">Sr. No.</th>
                                            <th class="sortable" onclick="sortTable('created_at')">Initiation Date</th>
                                            <th>Record No.</th>
                                            <th class="sortable" onclick="sortTable('Initiator_Group')">Division</th>
                                            <th class="sortable" onclick="sortTable('Initiator_Group')">Department Name</th>
                                            <th>Short Description</th>
                                            <th class="sortable" onclick="sortTable('due_date')">Due Date</th>
                                            <th>Initiator</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableData">
                                        @include('frontend.forms.Logs.filterData.auditprogram_data')
                                    </tbody>
                                </table>
                                <!-- Loader -->
                                <div id="loader" style="display: none; text-align: center; margin: 20px;">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>

                                  <!-- No Data Message -->
                            <div id="noDataMessage" style="display: none; text-align: center; margin: 20px; font-size: 16px; font-weight: bold; color: red;">
                                No Data Available
                            </div>
                                <div style="margin-top: 10px; display: flex; justify-content: center;">
                                    <div class="spinner-border text-primary" role="status" id="spinner">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.spinner-border {
    width: 3rem;
    height: 3rem;
    border: 0.3em solid #ccc;
    border-top: 0.3em solid #007bff;
    border-radius: 50%;
    animation: spinner 0.6s linear infinite;
}

@keyframes spinner {
    to {
        transform: rotate(360deg);
    }
}

</style>



<script>
    function filterTable() {
        const input = document.getElementById('searchBar');
        const filter = input.value.toLowerCase();
        const table = document.querySelector('#tableData');
        const rows = table.getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            let match = false;

            for (let j = 0; j < cells.length; j++) {
                if (cells[j].innerText.toLowerCase().indexOf(filter) > -1) {
                    match = true;
                    break;
                }
            }

         
            rows[i].style.display = match ? '' : 'none';
        }
    }
</script>

<script>
function filterByDueDate() {
    const filterType = document.getElementById('dateFilter').value;
    const table = document.getElementById('tableData');
    const rows = table.getElementsByTagName('tr');
    const today = new Date();
    let dataAvailable = false;

    const loader = document.getElementById('loader');
    loader.style.display = 'block';
    document.getElementById('noDataMessage').style.display = 'none';

    setTimeout(() => {
        for (let i = 0; i < rows.length; i++) {
            const dueDateCell = rows[i].getElementsByTagName('td')[6]; // Adjust column index if necessary
            if (dueDateCell) {
                const dueDate = new Date(dueDateCell.textContent.trim());
                let showRow = false;

                if (filterType === 'weekly') {
                    const nextWeek = new Date(today);
                    nextWeek.setDate(today.getDate() + 7);
                    showRow = dueDate >= today && dueDate <= nextWeek;
                } else if (filterType === 'monthly') {
                    const nextMonth = new Date(today);
                    nextMonth.setMonth(today.getMonth() + 1);
                    showRow = dueDate >= today && dueDate <= nextMonth;
                } else if (filterType === 'yearly') {
                    const nextYear = new Date(today);
                    nextYear.setFullYear(today.getFullYear() + 1);
                    showRow = dueDate >= today && dueDate <= nextYear;
                } else {
                    showRow = true; 
                }

                if (showRow) {
                    rows[i].style.display = '';
                    dataAvailable = true;
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }
        loader.style.display = 'none';

        if (!dataAvailable) {
            document.getElementById('noDataMessage').style.display = 'block';
        } else {
            document.getElementById('noDataMessage').style.display = 'none';
        }
    }, 500); // Simulate delay for loading
}

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.7.2/axios.min.js"></script>
<script>
    let sortState = {
        column: '',
        order: 'asc'
    };
    async function sortTable(column) {
        sortState.order = (sortState.column === column && sortState.order === 'asc') ? 'desc' : 'asc';
        sortState.column = column;

        document.getElementById('spinner').style.display = 'inline-block';

        try {
            const postUrl = "{{ route('api.cccontrol.filter') }}";
            const res = await axios.post(postUrl, {
                ...filterData,
                sort_column: sortState.column,
                sort_order: sortState.order
            });

            if (res.data.status === 'ok') {
                document.getElementById('tableData').innerHTML = res.data.body;
            } else {
                console.error('Error in response:', res.data);
            }
        } catch (err) {
            console.log('Error in sortTable:', err.message);
        }

        document.getElementById('spinner').style.display = 'none';
    }
</script>
<script>
    $(document).ready(function(){
        const filterData = {
            department_changecontrol: [],
            division_id_changecontrol: null,
            period_changecontrol: null,
            initiator_id_changecontrol: [],
            date_fromCc: null,
            date_toCc: null,
            sort_column: '',
            sort_order: ''
        };
    
        $('#initiator_group').change(function() {
            filterData.department_changecontrol = this.value;
            filterRecords();
        });
    
        $('#division_id_cc').change('change', function() {
            filterData.division_id_changecontrol = this.value;
            filterRecords();
        });
    
        document.getElementById('initiator_id').addEventListener('change', function() {
            filterData.initiator_id_changecontrol = this.value;
            filterRecords();
        });
    
        document.getElementById('date_fromCc').addEventListener('change', function() {
            filterData.date_fromCc = this.value;
            filterRecords();
        });
    
        document.getElementById('date_toCc').addEventListener('change', function() {
            filterData.date_toCc = this.value;
            filterRecords();
        });
    // ===============local=============
        async function filterRecords() {
            document.getElementById('tableData').innerHTML = '';
            document.getElementById('spinner').style.display = 'inline-block';
    
            try {
                const postUrl = "{{ route('api.cccontrol.filter') }}";
                const res = await axios.post(postUrl, filterData);
    
                if (res.data.status === 'ok') {
                    document.getElementById('tableData').innerHTML = res.data.body;
                } else {
                    console.error('Error in response:', res.data);
                }
            } catch (err) {
                console.log('Error in filterRecords:', err.message);
            }
    
            document.getElementById('spinner').style.display = 'none';
        }
    })

// ============================= Live Server Working Function ==========================//

</script>
<script>
     function printTable() {
    const department = document.getElementById('initiator_group').value;
    const changerelateTo = document.getElementById('division_id_cc').value;
    const Initiator = document.getElementById('initiator_id').value;
    const dateFrom = document.getElementById('date_fromCc').value;
    const dateTo = document.getElementById('date_toCc').value;
    let RadioActivtiyCCC = '';
    const selectedCategory = document.querySelector('input[name="Change_related_category"]:checked');
    if (selectedCategory) {
        RadioActivtiyCCC = selectedCategory.value; // Set the value here
    }
    let RadioActivtiyTCC = '';
    const selectedCategorytcc = document.querySelector('input[name="Type_of_change"]:checked');
    if (selectedCategorytcc) {
        RadioActivtiyTCC = selectedCategorytcc.value; // Set the value here
    }
    const url = `/api/Change-ControlLog?department=${department}&changerelateTo=${changerelateTo}&Initiator=${Initiator}&dateFrom=${dateFrom}&dateTo=${dateTo}&RadioActivtiyTCC=${RadioActivtiyTCC}`;
    
    window.open(url, '_blank');

}
    </script>
    <script>
VirtualSelect.init({
            ele: ' #initiator_group , #initiator_id'
        });
$(document).ready(function() {
    $('#initiator_group').select2({
        placeholder: "Select Audit Team",  // Set placeholder text
        allowClear: true                   // Allow clearing the selection
    });
});
</script>
@endsection
