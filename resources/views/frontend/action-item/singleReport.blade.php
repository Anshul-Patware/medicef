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

    .head-number {
        font-weight: bold;
        font-size: 13px;
        padding-left: 10px;
    }

    .div-data {
        font-size: 13px;
        padding-left: 10px;
        margin-bottom: 10px;
    }
</style>

<body>

    <header>
        <table>
            <tr>
                <td class="w-70 head">
                    Action-Item Single Report
                </td>
                <td class="w-20">
                    <div class="logo">
                        <img src="https://www.cphi-online.com/Medicef%20Logo-comp306798.jpg" alt="" class="w-70">
                    </div>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="w-30">
                    <strong> Action-Item No.</strong>
                </td>
                <td class="w-40">
                    {{ Helpers::divisionNameForQMS($data->division_id) }}/AI/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
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
                {{-- <td class="w-30">
                    <strong>Page :</strong> 1 of 1
                </td> --}}
            </tr>
        </table>
    </footer>


    <div class="inner-block">
        <div class="content-table">
            <div class="block">
                <div class="block-head">
                    General Information
                </div>
                <table>
                    <tr>
                        <th class="w-20">Record Number</th>
                        <td class="w-30">
                            @if ($data->record)
                                {{ Helpers::divisionNameForQMS($data->division_id) }}/AI/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Division Code</th>
                        <td class="w-30">
                            @if ($data->division_id)
                                {{ Helpers::getDivisionName($data->division_id) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr> {{ $data->created_at }} added by {{ $data->originator }}
                        <th class="w-20">Initiator</th>
                        <td class="w-30">{{ Helpers::getInitiatorName($data->initiator_id) }}</td>
                        <th class="w-20">Date of Initiation</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->created_at) }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Parent Record Number</th>
                        <td class="w-30">
                            @if ($data->parent_record_number)
                                {{ $data->parent_record_number }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Assigned To</th>
                        <td class="w-30">
                            @if ($data->assign_to)
                                {{ Helpers::getInitiatorName($data->assign_to) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>


                    <tr>
                        <th class="w-20">Due Date</th>
                        <td class="w-30">
                            @if ($data->due_date)
                                {{ Helpers::getdateFormat($data->due_date) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Priority</th>
                        <td class="w-30">
                            @if ($data->priority_data)
                                {{ $data->priority_data }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <label class="head-number" for="Short Description">Short Description</label>
                <div class="div-data">
                    @if ($data->short_description)
                        {{ $data->short_description }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <label class="head-number" for="Action Item Related Records">Action Item Related Records</label>
                <div class="div-data">
                    @if ($data->Reference_Recores1)
                        {{ str_replace(',', ', ', $data->Reference_Recores1) }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <table>
                    <tr>
                        <th class="w-20">HOD Persons</th>
                        <td class="w-80">
                            @if ($data->hod_preson)
                                {{ $data->hod_preson }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th class="w-20">Responsible Department</th>
                        <td class="w-80">
                            @if ($data->departments)
                                {{ Helpers::getFullDepartmentName($data->departments) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <label class="head-number" for="Description">Description</label>
                <div class="div-data">
                    @if ($data->description)
                        {{ $data->description }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <div class="block-head">
                    File Attachments
                </div>
                <div class="border-table">
                    <table>
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">File</th>
                        </tr>
                        @if ($data->file_attach)
                            @php $files = json_decode($data->file_attach); @endphp
                            @if (count($files) > 0)
                                @foreach ($files as $key => $file)
                                    <tr>
                                        <td class="w-20">{{ $key + 1 }}</td>
                                        <td class="w-60"><a href="{{ asset('upload/' . $file) }}"
                                                target="_blank"><b>{{ $file }}</b></a></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="w-20">1</td>
                                    <td class="w-60">Not Applicable</td>
                                </tr>
                            @endif
                        @else
                            <tr>
                                <td class="w-20">1</td>
                                <td class="w-60">Not Applicable</td>
                            </tr>
                        @endif
                    </table>
                </div>

            </div>

            <div class="block">
                <div class="block-head">
                    Post Completion
                </div>

                <label class="head-number" for="Action Taken">Action Taken</label>
                <div class="div-data">
                    @if ($data->action_taken)
                        {{ $data->action_taken }}
                    @else
                        Not Applicable
                    @endif
                </div>
                <table>
                    <tr>
                        <th class="w-20">Action Start Date</th>
                        <td class="w-30">
                            @if ($data->start_date)
                                {{ Helpers::getdateFormat($data->start_date) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Actual End Date</th>
                        <td class="w-30">
                            @if ($data->end_date)
                                {{ Helpers::getdateFormat($data->end_date) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <label class="head-number" for="Comments">Comments</label>
                <div class="div-data">
                    @if ($data->comments)
                        {{ $data->comments }}
                    @else
                        Not Applicable
                    @endif
                </div>


                <div class="block-head">
                    Completion Attachments
                </div>
                <div class="border-table">
                    <table>
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">File</th>
                        </tr>
                        @if ($data->Support_doc)
                            @php $files = json_decode($data->Support_doc); @endphp
                            @if (count($files) > 0)
                                @foreach ($files as $key => $file)
                                    <tr>
                                        <td class="w-20">{{ $key + 1 }}</td>
                                        <td class="w-60"><a href="{{ asset('upload/' . $file) }}"
                                                target="_blank"><b>{{ $file }}</b></a></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="w-20">1</td>
                                    <td class="w-60">Not Applicable</td>
                                </tr>
                            @endif
                        @else
                            <tr>
                                <td class="w-20">1</td>
                                <td class="w-60">Not Applicable</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>

            <div class="block">
                <div class="block-head">
                    Action Approval
                </div>

                <label class="head-number" for="QA Review Comments">QA Review Comments</label>
                <div class="div-data">
                    @if ($data->qa_comments)
                        {{ $data->qa_comments }}
                    @else
                        Not Applicable
                    @endif
                </div>

            </div>

            <div class="block">
                <div class="block-head">
                    Extension Justification
                </div>
                <table>
                    <tr>
                        <th class="w-20">Due Date Extension Justification</th>
                        <td class="w-80">
                            @if ($data->due_date_extension)
                                {{ $data->due_date_extension }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <div class="block-head">
                    Action Approval Attachment
                </div>
                <div class="border-table">
                    <table>
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">File</th>
                        </tr>
                        @if ($data->final_attach)
                            @php $files = json_decode($data->final_attach); @endphp
                            @if (count($files) > 0)
                                @foreach ($files as $key => $file)
                                    <tr>
                                        <td class="w-20">{{ $key + 1 }}</td>
                                        <td class="w-60"><a href="{{ asset('upload/' . $file) }}"
                                                target="_blank"><b>{{ $file }}</b></a></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="w-20">1</td>
                                    <td class="w-60">Not Applicable</td>
                                </tr>
                            @endif
                        @else
                            <tr>
                                <td class="w-20">1</td>
                                <td class="w-60">Not Applicable</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>

            <div class="block" style="margin-top: 15px;">
                <div class="block-head">
                    Activity Log
                </div>
                <table>
                    <tr>
                        <th class="w-20">Submitted By</th>
                        <td class="w-80">{{ $data->submitted_by }}</td>
                        <th class="w-20">Submitted On</th>
                        <td class="w-80">{{ $data->submitted_on }}</td>
                        <th class="w-20">Submitted Comment</th>
                        <td class="w-80">{{ $data->submitted_comment }}</td>
                    </tr>


                    <tr>
                        <th class="w-20">Cancelled By</th>
                        <td class="w-80">{{ $data->cancelled_by }}</td>
                        <th class="w-20">Cancelled On</th>
                        <td class="w-80">{{ $data->cancelled_on }}</td>
                        <th class="w-20">Cancelled Comment</th>
                        <td class="w-80">{{ $data->cancelled_comment }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Acknowledge By</th>
                        <td class="w-80">{{ $data->acknowledgement_by }}</td>
                        <th class="w-20">Acknowledge On</th>
                        <td class="w-80">{{ $data->acknowledgement_on }}</td>
                        <th class="w-20">Acknowledge Comment</th>
                        <td class="w-80">{{ $data->acknowledgement_comment }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Work Completion By</th>
                        <td class="w-80">{{ $data->work_completion_by }}</td>
                        <th class="w-20">Work Completion On</th>
                        <td class="w-80">{{ $data->work_completion_on }}</td>
                        <th class="w-20">Work Completion Comment</th>
                        <td class="w-80">{{ $data->work_completion_comment }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">QA/CQA Verification By</th>
                        <td class="w-80">{{ $data->qa_varification_by }}</td>
                        <th class="w-20">QA/CQA Verification On</th>
                        <td class="w-80">{{ $data->qa_varification_on }}</td>
                        <th class="w-20">QA/CQA Verification Comment</th>
                        <td class="w-80">{{ $data->qa_varification_comment }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>


</body>

</html>
