<!DOCTYPE html>
<html>

<head>
    <style>
        header .header_rcms_bottom {
            display: none;
        }   
        .vscomp-wrapper {
            border: 1px solid #eca035;
            border-radius: 2px;
        } 
        #division_id_capa{
            border: 1px solid #eca035 !important;
            border-radius: 2px !important; 
        } 
        #date_fromcapa{
            border: 1px solid #eca035 !important;
            border-radius: 2px !important;   
        } 
        #date_tocapa{
            border: 1px solid #eca035 !important;
            border-radius: 2px !important;    
        }
        .btn-primary{
            background-color: #eca035 !important;
            border-color: #eca035 !important;
        }
        .btn-primary:hover{
            background-color: #fff !important;
            border-color: #eca035 !important;
            color: #eca035 !important;
        }
        .main-button:hover{
            color: #eca035 !important;  
        }
        .main-button{
            color: #fff !important;  
        }
    </style>
</head>

<body>
                @php
                    use Carbon\Carbon;
                @endphp
              
    <header>
        <table style="position:relative; top: 15px; padding:0;  ">
            <tr>
                <td class="w-50">
                    <div class="header-title">
                        <h3 style="margin-left: 100px;">Complaint Management Log Report</h3>
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

    <!-- Table -->
    <table>
        <thead>
            <tr>
                <th >Sr. No.</th>
                <th >Initiation Date</th>
                <th>Record No.</th>
                <th >Division</th>
                <th >Department Name</th>
                <th>Short Description</th>
                <th >Due Date</th>
                <th>Initiator</th>
                <th>Status</th>
            </tr>
        </thead>
        
    </table>
    @foreach ($paginatedData as $pageIndex => $pageData)

    <div class="table-container" style = "margin:0; padding:0; width:100%" >
    <table>
            <tbody>
                @foreach ($pageData as $index => $doc)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $doc->intiation_date ?: 'Not Applicable' }}</td>
                    <td>{{ $doc->division ? $doc->division->name : 'Not Applicable' }}/CC/{{ date('Y') }}/{{ str_pad($doc->record, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $doc->division ? $doc->division->name : 'Not Applicable' }}</td>
                    <td>{{  Helpers::getNewInitiatorGroupFullName($doc->initiator_group) ?: ' Not Applicable ' }}</td>
                    <td>{{ $doc->description_gi ?: 'Not Applicable' }}</td>
                    <td>{{ $doc->due_date_gi ? \Carbon\Carbon::parse($doc->due_date)->format('d-M-Y') : 'Not Applicable' }}</td>
                    <td>{{ $doc->initiator ? $doc->initiator->name : 'Not Applicable' }}</td>
                    <td>{{ $doc->status ?: 'Not Applicable' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer style="position: fixed; bottom: 0; left: 0; right: 0; background: #fff; border-top: 1px solid #000000; padding-top: 10px;">
        <table class="footer-table" style="width: 100%; text-align: center;">
            <tr>
                <td style="width: 33%; text-align: left;">
                    <strong>Printed By:</strong> 
                    <td>{{ optional($doc->initiator)->name ?: 'Not Applicable' }}</td>
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
