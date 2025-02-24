<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Management Report</title>
    <style>
        @page {
            margin: 20px;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fa;
            color: #1f1515;
        }

        /* Container for table and header */
        .table-container {
            position: relative;
            top: 2%;
            /* padding: 2%; */
            background-color: #fff;
            border-radius: 8px;
            /* box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); */
            margin-bottom: 20px;
            /* width: 98%; */
            margin-left: 1%;
            margin-right: 1%;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th, td {
            border: 1px solid #000;
            padding: 12px 15px;
            text-align: center;
            font-size: 14px;
            color: #000;
        }

        th {
            background-color: #929090;
            color: #fff;
            font-weight: bold;
            text-align: center;
        }

        td {
            background-color: #f9f9f9;
        }

        tr:nth-child(even) td {
            background-color: #f2f2f2;
        }

        footer {
            position: relative;
            padding: 20px 0;
            text-align: center;
            font-size: 12px;
            margin-top: 30px;
        }

        footer td {
            padding: 8px;
        }

        .footer-table td {
            padding-left: 15px;
            padding-right: 15px;
        }

        /* Header Styling */
        header {
            width: 100%;
            background-color: #fff;
            /* padding: 20px 0; */
            border-bottom: 2px solid #e0e0e0;
        }

        header table {
            width: 100%;
            /* padding: 0 20px; */
        }

        header .w-50 {
            /* width: 50%; */
            text-align: left;
        }

        .logo img {
            max-width: 150px;
            max-height: 80px;
            margin-right: 180px;
        }

        .header-title {
            font-size: 22px;
            font-weight: bold;
            color: #000;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            th, td {
                font-size: 12px;
                padding: 8px;
            }

            .logo img {
                max-width: 120px;
            }

            .header-title {
                font-size: 18px;
            }
        }

        .page-number:before {
            content: "Page : " counter(page);
        }
    </style>
</head>
<body>

    <header>
        <table>
            <tr>
                <td class="w-50">
                    <div class="header-title">
                        <h3>Complaint Management Report</h3>
                    </div>
                </td>
                <td class="w-50" style="text-align: right;">
                    <div class="logo">
                        <img src="https://www.medicefpharma.com/wp-content/uploads/2020/06/medicef-logo-new1.png" alt="Logo">
                    </div>
                </td>
            </tr>
        </table>
    </header>

    @foreach ($paginatedData as $pageIndex => $pageData)
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Sr No.</th>
                        <th>Unique Id</th>
                        <th>Record No.</th>
                        <th>Initiation Date</th>
                        <th>Department</th>
                        <th>Categorization of Complaint</th>
                        <th>Short Description</th>
                        <th>Due Date</th>
                        <th>Closed on</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pageData as $index => $complaint)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $complaint['id'] }}</td>
                            <td>{{ $complaint['record'] }}</td>
                            <td>{{ $complaint['intiation_date'] }}</td>
                            <td>{{ $complaint['initiator_group'] }}</td>
                            <td>{{ $complaint['categorization_of_complaint_gi'] }}</td>
                            <td>{{ $complaint['description_gi'] }}</td>
                            <td>{{ $complaint['due_date_gi'] }}</td>
                            <td>{{ $complaint['closed_done_on'] }}</td>
                            <td>{{ $complaint['status'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <footer>
            <table class="footer-table" style="width: 100%; text-align: center;">
                <tr>
                    <td style="width: 33%; text-align: left;">
                        <strong>Printed By:</strong>
                        {{ optional($complaint['initiator_group'])->name ?: 'Not Available' }}
                    </td>
                    <td style="width: 33%; text-align: center;">
                        <strong>Printed on:</strong> {{ date('d-M-Y') }}
                    </td>
                    <td style="text-align: right;">Page {{ $pageIndex + 1 }} of {{ $totalPages }}</td>
                </tr>
            </table>
        </footer>

        @if (!$loop->last)
            <div style="page-break-after: always;"></div>
        @endif
    @endforeach

</body>
</html>
