

{{-- <h1>{{$chartTypeDue}}</h1>
<h1>{{$dataSetDue}}</h1> --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .w-10 {
            width: 10%;
        }

        .w-20 {
            width: 20%;
        }

        .w-25 {
            width: 25%;
        }

        .w-30 {
            width: 30%;
        }

        .w-40 {
            width: 40%;
        }

        .w-50 {
            width: 50%;
        }

        .w-60 {
            width: 60%;
        }

        .w-70 {
            width: 70%;
        }

        .w-80 {
            width: 80%;
        }

        .w-90 {
            width: 90%;
        }

        .w-100 {
            width: 100%;
        }

        .h-100 {
            height: 100%;
        }

        header table,
        header th,
        header td,
        footer table,
        footer th,
        footer td,
        .border-table table,
        .border-table th,
        .border-table td {
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 0.9rem;
            vertical-align: middle;
        }

        table {
            width: 100%;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        footer .head,
        header .head {
            text-align: center;
            font-weight: bold;
            font-size: 1.2rem;
        }

        @page {
            size: A4;
            margin-top: 160px;
            margin-bottom: 60px;
        }

        header {
            position: fixed;
            top: -140px;
            left: 0;
            width: 100%;
            display: block;
            text-align: center;
            padding: 20px;
            background-color: #4274da;
            color: white;
        }

        footer {
            width: 100%;
            position: fixed;
            display: block;
            bottom: -40px;
            left: 0;
            font-size: 0.9rem;
        }

        footer td {
            text-align: center;
        }

        .inner-block {
            padding: 10px;
            margin-top: 25px;
        }

        .inner-block tr {
            font-size: 0.8rem;
        }

        .inner-block .block {
            margin-bottom: 30px;
        }

        .inner-block .block-head {
            font-weight: bold;
            font-size: 1.1rem;
            padding-bottom: 5px;
            border-bottom: 2px solid #4274da;
            margin-bottom: 10px;
            color: #4274da;
        }

        .inner-block th,
        .inner-block td {
            vertical-align: baseline;
        }

        .table_bg {
            /* background: #4274da57; */
            background-color: #eca035;
        }

        /* Style for Logos */
        .logo {
            height: 50px;
            margin: 0 20px;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .report-title {
            text-align: center;
            font-size: 1.6rem;
            font-weight: bold;
        }

        .report-details {
            font-size: 1.1rem;
            margin-top: 10px;
        }
    </style>
    <style>
        .inner-block {
    padding: 20px;
    background-color: #f9f9f9;
}

.content-table {
    margin: 0 auto;
    width: 95%;
}

.block {
    background-color: #fff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.block-head {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
}

.border-table {
    display: flex;
    flex-direction: column;
    gap: 20px; /* Space between table sections */
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

thead {
    background-color: #eea847; /* Orange background for the header */
    color: #000000;
}

th, td {
    padding: 12px;
    text-align: left;
    border: 1px solid #ddd;
}

th {
    font-weight: bold;
}

td {
    font-size: 14px;
}

#AuditProgramInitialCategorizationDue {
    width: 100%;
    height: 500px;
    background-color: #f2f2f2;
    margin-bottom: 20px;
}

    </style>
</head>


<body>
 
  
    <div class="inner-block">
        <div class="content-table">
            <div class="block">
                <div class="block-head">
                   Analysis Report
                </div>

                <div id="AuditProgramInitialCategorizationDue" style="width: 100%; height: 500px;"></div>

        
                <div class="border-table">
                    <table>
                        <thead>
                            <tr class="table_bg">
                                <th style="width: 50px;">S. No</th>
                                <th style="width: 240px;">Record ID</th>
                                <th style="width: 240px;">Process</th>
                                <th style="width: 240px;">Division</th>
                                <th style="width: 240px;">Department</th>
                            </tr>
                        </thead>
                        <tbody id="recordsTableBody"></tbody>
                    </table>
                    <table>
                        <thead>
                            <tr class="table_bg">
                                <th style="width: 50px;">S. No</th>
                                <th style="width: 240px;">Originator</th>
                                <th style="width: 240px;">Date Opened</th>
                                <th style="width: 240px;">Date Closed</th>
                                <th style="width: 240px;">Due Date</th>
                            </tr>
                        </thead>
                        <tbody id="recordsTableBody2"></tbody>
                    </table>
                    <table>
                        <thead>
                            <tr class="table_bg">
                                <th style="width: 50px;">S. No</th>
                                <th style="width: 240px;">Days Due</th>
                                <th style="width: 240px;">Created At</th>
                                <th style="width: 240px;">Status</th>
                                <th style="width: 240px;">Priority</th>
                               
                            </tr>
                        </thead>
                        <tbody id="recordsTableBody3"></tbody>
                    </table>
                    <table>
                        <thead>
                            <tr class="table_bg">
                                <th style="width: 50px;">S. No</th>
                                <th style="width: 240px;">Initial Category</th>
                                <th style="width: 240px;">Final Category</th>
                                <th style="width: 240px;">Root Cause Category</th>
                                <th style="width: 240px;">Root Cause Sub-Category</th>
                            </tr>
                        </thead>
                        <tbody id="recordsTableBody4"></tbody>
                    </table>
                    <div id="pageInfo"></div>
                </div>
            </div>
        </div>
    </div>
 
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>

    let chartTypeDue = `{{ $chartTypeDue }}`;
    let dataSetDue = @json($dataSetDue);
    const recordsPerPage = 5;
    let currentPage = 1;

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

     function renderTable(records, page) {
        const start = (page - 1) * recordsPerPage;
        const end = start + recordsPerPage;
        const detailUrl = `#`;

        let recordIndex = 1;

        let table1 = document.getElementById('recordsTableBody');
        let table2 = document.getElementById('recordsTableBody2');
        let table3 = document.getElementById('recordsTableBody3');
        let table4 = document.getElementById('recordsTableBody4');

        table1.innerHTML = '';
        table2.innerHTML = '';
        table3.innerHTML = '';
        table4.innerHTML = '';

        records.forEach((record, index) => {

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
        const { days, color } = calculateDaysDue(record.due_date);


            try {

                table1.innerHTML += `
                <tr>
                    <td>${recordIndex}</td>
                    <td><a href="${detailUrl}" style="color: rgb(43, 43, 48);">${String(record.id).padStart(4, '0')}</a></td>
                    <td>${formType}</td>
                    <td>${record.division}</td>
                    <td>${record.department}</td>
                </tr>`;
                table2.innerHTML += `
                <tr>
                    <td>${recordIndex}</td>
                    <td>${record.originator}</td>
                    <td>${formatDate(record.intiation_date)}</td>
                    <td>${'-'}</td>
                    <td>${formatDate(record.due_date)}</td>
                </tr>`;
                table3.innerHTML += `
                <tr>
                    <td>${recordIndex}</td>
                    <td style="color: ${color}; font-weight: bold;">${days}</td> <!-- Only show days value here -->
                    <td>${formatDate(record.created_at)}</td>
                    <td>${record.status || '-'}</td>
                    <td>${record.priority_data || '-'}</td>
                </tr>`;
                table4.innerHTML += `
                <tr>
                    <td>${recordIndex}</td>
                    <td>${InitialCategorization || '-'}</td>
                    <td>${record.Post_Categorization || '-'}</td>
                    <td>${record.rcc || '-'}</td>
                    <td>${record.rcsc || '-'}</td>
                </tr>`;

            } catch (err) {
                console.log('error in renderTable', err.message);
            }

            recordIndex++;
        })

        // const tableBody = document.getElementById('recordsTableBody');
        // tableBody.innerHTML = '';

        // const start = (page - 1) * recordsPerPage;
        // const end = start + recordsPerPage;

        // const paginatedRecords = records.slice(start, end);

        // paginatedRecords.forEach((record, index) => {
        //     const detailUrl = `#`;
        //     tableBody.innerHTML += `
        //         <tr>
        //             <td>${start + index + 1}</td>
        //             <td><a href="${detailUrl}" style="color: rgb(43, 43, 48);">${String(record.id).padStart(4, '0')}</a></td>
        //             <td>${record.form_type}</td>
        //             <td>${record.division}</td>
        //             <td>${record.department}</td>
        //             <td>${record.originator}</td>
        //             <td>${formatDate(record.intiation_date)}</td>
        //             <td>${'-'}</td>
        //             <td>${formatDate(record.due_date)}</td>
        //             <td>${calculateDaysDue(record.due_date)}</td>
        //             <td>${formatDate(record.created_at)}</td>
        //             <td>${record.status || '-'}</td>
        //             <td>${record.priority_data || '-'}</td>
        //             <td>${record.Initial_Categorization || '-'}</td>
        //             <td>${record.Post_Categorization || '-'}</td>
        //             <td>${record.rcc || '-'}</td>
        //             <td>${record.rcsc || '-'}</td>
        //         </tr>`;
        // });

        // const totalPages = Math.ceil(records.length / recordsPerPage);
        // document.getElementById('pageInfo').innerText = `Page ${currentPage} of ${totalPages}`;
    }

    // Render graph based on selected chart type
    // function renderGraph(records, chartTypeDue = 'column') {
    //     const counts = {};
    //     records.forEach(record => {
    //         counts[record.department] = (counts[record.department] || 0) + 1;
    //     });

    //     const categories = Object.keys(counts);
    //     const values = Object.values(counts);

    //     // Prepare Pie chart data
    //     const pieData = categories.map((category, index) => {
    //         return { name: category, y: values[index] };
    //     });

    //     Highcharts.chart('AuditProgramInitialCategorizationDue', {
    //         chart: { type: chartTypeDue },
    //         title: { text: 'Department Analytics' },
    //         xAxis: chartTypeDue !== 'pie' ? { categories } : null, // No xAxis for pie chart
    //         yAxis: chartTypeDue !== 'pie' ? { title: { text: 'Counts' } } : null, // No yAxis for pie chart
    //         series: chartTypeDue === 'pie'
    //             ? [{ name: 'Departments', colorByPoint: true, data: pieData }]
    //             : [{ name: 'Departments', data: values }],
    //         credits: { enabled: false }
    //     });
    // }

    function renderDueGraph(records, chartTypeDue = 'column') {
        const counts = {};
        records.forEach(record => {
            counts[record.due_date_status ] = (counts[record.due_date_status ] || 0) + 1;
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
            yAxis: chartTypeDue !== 'pie' ? { title: { text: 'Counts' } } : null, // No yAxis for pie chart
            series: chartTypeDue === 'pie'
                ? [{ colorByPoint: true, data: pieData }]
                : [{ data: values }],
            credits: { enabled: false }
        });
    }

    function formatDate(date) {
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    const formattedDate = new Date(date).toLocaleDateString('en-GB', options);
    return formattedDate;
}

        // Initial data rendering
        if (Array.isArray(JSON.parse(dataSetDue))) {
            renderTable(JSON.parse(dataSetDue));
            renderDueGraph(JSON.parse(dataSetDue), chartTypeDue);
        } else {
            console.error('Invalid dataSetDue: ', dataSetDue);
        }


</script>

    {{-- <footer>
        <table>
            <tr>
                <td class="w-30"><strong>Printed On :</strong> {{ date('d-M-Y') }}</td>
                <td class="w-40"><strong>Printed By :</strong> {{ Auth::user()->name }}</td>
            </tr>
        </table>
    </footer> --}}

</body>

</html>
