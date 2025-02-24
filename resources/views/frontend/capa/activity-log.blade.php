<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>VidyaGxP - Software</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>

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
        border: 1px solid black;
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
        background: #4274da57;
    }
</style>

<body>

    <header>
        <table>
            <tr>
                <td class="w-70 head">
                    Activity Log
                </td>
                <td class="w-30">
                    <div class="logo">
                        <img src="https://www.cphi-online.com/Medicef%20Logo-comp306798.jpg" alt="" class="w-50">
                    </div>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="w-30">
                    <strong>Activity Log No.</strong>
                </td>
                <td class="w-40">
                    {{ Helpers::getDivisionName($data->division_id) }}/CAPA/{{ $data->created_at->format('Y') }}/{{ $data->record ? str_pad($data->record, 4, '0', STR_PAD_LEFT) : '' }}
                </td>
                <td class="w-30">
                    <strong>Record No.</strong> {{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                </td>
            </tr>
        </table>
    </header>

    <footer>
        <table>
            <tr>
                <td class="w-30">
                    <strong>Printed On :</strong> {{ date('d-M-Y') }}
                </td>
                <td class="w-40">
                    <strong>Printed By :</strong> {{ Auth::user()->name }}
                </td>

            </tr>
        </table>
    </footer>

    <div class="inner-block">
        <div class="content-table">
            <div class="block">
                <div class="block-head">Activity Log</div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <!-- Initiate Calibration By and On -->
                            <tr>
                                <td>
                                    <strong style="color: #4274da">Propose Plan By:</strong><br>
                                    {{ $Capadata->plan_proposed_by }}
                                </td>
                                <td>
                                    <strong style="color: #4274da">Propose Plan On:</strong><br>
                                    @php
                                        $initiateTime = $Capadata->plan_proposed_on;
                                        $timeArray = explode(' | ', $initiateTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #4274da">Propose Plan Comment:</strong><br>
                                    {{ $Capadata->comment ?? 'Not Applicable' }}
                                </td>
                            </tr>
    
                           
                            <tr>
                                <td>
                                    <strong style="color: #4274da">Cancelled By:</strong><br>
                                    {{ $Capadata->cancelled_by }}
                                </td>
                                <td>
                                    <strong style="color: #4274da">Cancelled On:</strong><br>
                                    @php
                                        $withinLimitsTime = $Capadata->cancelled_on;
                                        $timeArray = explode(' | ', $withinLimitsTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #4274da">Cancel Comment:</strong><br>
                                    {{ $Capadata->cancel_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>
    
                            
                            <tr>
                                <td>
                                    <strong style="color: #4274da">HOD Review Completed By:</strong><br>
                                    {{ $Capadata->hod_review_completed_by }}
                                </td>
                                <td>
                                    <strong style="color: #4274da">HOD Review Completed On:</strong><br>
                                    @php
                                        $outOfLimitsTime = $Capadata->hod_review_completed_on;
                                        $timeArray = explode(' | ', $outOfLimitsTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #4274da">HOD Review Completed Comment:</strong><br>
                                    {{ $Capadata->hod_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>
    
                            
                            <tr>
                                <td>
                                    <strong style="color: #4274da">QA/CQA Review Completed By:</strong><br>
                                    {{ $Capadata->qa_review_completed_by }}
                                </td>
                                <td>
                                    <strong style="color: #4274da">QA Review Completed On:</strong><br>
                                    @php
                                        $completeActionsTime = $Capadata->qa_review_completed_on;
                                        $timeArray = explode(' | ', $completeActionsTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #4274da">QA/CQA Review Completed Comment:</strong><br>
                                    {{ $Capadata->qa_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>
    
                           
                            <tr>
                                <td>
                                    <strong style="color: #4274da">Approved By:</strong><br>
                                    {{ $Capadata->approved_by }}
                                </td>
                                <td>
                                    <strong style="color: #4274da">Approved On:</strong><br>
                                    @php
                                        $additionalWorkTime = $Capadata->approved_on;
                                        $timeArray = explode(' | ', $additionalWorkTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #4274da">Approved Comment:</strong><br>
                                    {{ $Capadata->approved_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>
    
                           
                            <tr>
                                <td>
                                    <strong style="color: #4274da">Completed By:</strong><br>
                                    {{ $Capadata->completed_by }}
                                </td>
                                <td>
                                    <strong style="color: #4274da">Completed On:</strong><br>
                                    @php
                                        $qaApprovalTime = $Capadata->completed_on;
                                        $timeArray = explode(' | ', $qaApprovalTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #4274da">Completed Comment:</strong><br>
                                    {{ $Capadata->com_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>
    
                           
                            <tr>
                                <td>
                                    <strong style="color: #4274da">HOD Final Review Completed By:</strong><br>
                                    {{ $Capadata->hod_final_review_completed_by }}
                                </td>
                                <td>
                                    <strong style="color: #4274da">HOD Final Review Completed On:</strong><br>
                                    @php
                                        $cancelTime = $Capadata->hod_final_review_completed_on;
                                        $timeArray = explode(' | ', $cancelTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #4274da">HOD Final Review Completed Comment:</strong><br>
                                    {{ $Capadata->final_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong style="color: #4274da">QA/CQA Closure Review Completed By:</strong><br>
                                    {{ $Capadata->qa_review_completed_by }}
                                </td>
                                <td>
                                    <strong style="color: #4274da">QA/CQA Closure Review Completed On:</strong><br>
                                    @php
                                        $cancelTime = $Capadata->qa_review_completed_on;
                                        $timeArray = explode(' | ', $cancelTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #4274da">QA/CQA Closure Review Completed Comment:</strong><br>
                                    {{ $Capadata->qa_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong style="color: #4274da">QA/CQA Approval Completed By:</strong><br>
                                    {{ $Capadata->qah_approval_completed_by }}
                                </td>
                                <td>
                                    <strong style="color: #4274da">QA/CQA Approval Completed On:</strong><br>
                                    @php
                                        $cancelTime = $Capadata->qah_approval_completed_on;
                                        $timeArray = explode(' | ', $cancelTime);
                                        $timeInIST = $timeArray[0] ?? 'No IST Time Available';
                                        $timeInGMT = $timeArray[1] ?? 'No GMT Time Available';
                                        $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                        echo $isIndia ? $timeInIST : $timeInGMT;
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong style="color: #4274da">QA/CQA Approval Completed Comment:</strong><br>
                                    {{ $Capadata->qah_comment ?? 'Not Applicable' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</body>

</html>
