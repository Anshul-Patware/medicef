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
        background: #4274da57;
    }
</style>

<body>

    <header>
        <table>
            <tr>
                <td class="w-70 head">
                    Preventive Maintenance Single Report
                </td>
                <td class="w-30">
                    <div class="logo">
                        <img src="https://www.cphi-online.com/Medicef%20Logo-comp306798.jpg" alt=""
                            class="w-80">
                    </div>
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <td class="w-30">
                    <strong>Preventive Maintenance No.</strong>
                </td>
                <td class="w-40">
                    {{ $data->division ? $data->division : '-' }}/PM/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                </td>
                <td class="w-30">
                    <strong>Record No.</strong> {{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                </td>
            </tr>
        </table>
    </header>
    <div class="inner-block">
        <div class="content-table">
            <div class="block">
                <div class="block-head">
                    General Information
                </div>
                <table>
                    <tr> {{ $data->created_at }} added by {{ $data->originator }}
                        <th class="w-20">Record Number</th>
                        <td class="w-80">
                            {{ Helpers::divisionNameForQMS($data->division_id) }}/PM/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                        <th class="w-20">Site/Location Code</th>
                        <td class="w-80">
                            @if ($data->division_id)
                                {{ Helpers::getDivisionName($data->division_id) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Initiator</th>
                        <td class="w-80">{{ Auth::user()->name }} </td>
                        <th class="w-20">Date of Initiation</th>
                        <td class="w-80">{{ Helpers::getdateFormat($data->created_at) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Site/Location Code</th>
                        <td class="w-80">{{ $data->division ? $data->division : '-' }}</td>

                        <th class="w-20">Assigned To</th>
                        <td class="w-80">
                            @isset($data->assign_to)
                                {{ Helpers::getInitiatorName($data->assign_to) }}
                            @else
                                Not Applicable
                            @endisset

                    </tr>
                    <tr>
                        <th class="w-20">Due Date</th>
                        <td class="w-80">
                            @if ($data->due_date)
                                {{ Helpers::getdateFormat($data->due_date) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Short Description</th>
                        <td class="w-80" colspan="3">
                            @if ($data->short_description)
                                {{ $data->short_description }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>
                    <tr>
                        <th class="w-20">PM Schedule</th>
                        <td class="w-80">
                            @if ($data->pm_schedule)
                                {{ $data->pm_schedule }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Last Preventive Maintenance Date</th>
                        <td class="w-80">
                            @if ($data->last_pm_date)
                                {{ Helpers::getdateFormat($data->last_pm_date) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>


                    <tr>
                        <th class="w-20">PM Task Description</th>
                        <td class="w-80" colspan="3">
                            @if ($data->pm_task_description)
                                {{ $data->pm_task_description }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Unscheduled or Event Based Preventive Maintenance?</th>
                        <td class="w-80">
                            @if ($data->event_based_PM)
                                {{ $data->event_based_PM }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Next Preventive Maintenance Date</th>
                        <td class="w-80">
                            @if ($data->next_pm_date)
                                {{ Helpers::getdateFormat($data->next_pm_date) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Reason for Unscheduled or Event Based Preventive Maintenance</th>
                        <td class="w-80" colspan="3">
                            @if ($data->eventbased_pm_reason)
                                {{ $data->eventbased_pm_reason }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>


                    <tr>
                        <th class="w-20">Event Reference No.</th>
                        <td class="w-80">
                            @if ($data->PMevent_refernce_no)
                                {{ $data->PMevent_refernce_no }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <div class="border-table">
                    <div class="block-head">
                        PM Procedure Reference/Document
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Batch No</th>
                        </tr>
                        @if ($data->pm_procedure_document)
                            @foreach (json_decode($data->pm_procedure_document) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                            target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="w-20">1</td>
                                <td class="w-20">Not Applicable</td>
                            </tr>
                        @endif

                    </table>
                </div>

                <table>

                    <tr>

                        <th class="w-20">Maintenance Comments/Observations</th>
                        <td class="w-80" colspan="3">
                            @if ($data->maintenance_observation)
                                {{ $data->maintenance_observation }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>

                        <th class="w-20">Parts Replaced During Maintenance</th>
                        <td class="w-80" colspan="3">
                            @if ($data->replaced_parts)
                                {{ $data->replaced_parts }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>

                        <th class="w-20">Performed By</th>
                        <td class="w-80" colspan="3">
                            @if ($data->pm_performed_by)
                                {{ $data->pm_performed_by }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Maintenance Work Order Number</th>
                        <td class="w-80">
                            @if ($data->work_order_number)
                                {{ $data->work_order_number }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">PM Checklist</th>
                        <td class="w-80" colspan="3">
                            @if ($data->pm_checklist)
                                {{ $data->pm_checklist }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Emergency Maintenance Flag</th>
                        <td class="w-80" colspan="3">
                            @if ($data->emergency_flag_maintenance)
                                {{ $data->emergency_flag_maintenance }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Cost of Maintenance</th>
                        <td class="w-80">
                            @if ($data->cost_of_maintenance)
                                {{ $data->cost_of_maintenance }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                </table>
            </div>
            <div class="block">
                <div class="block-head">
                    Activity log
                </div>
                <table>

                    <tr>
                        <th class="w-20">Submit By</th>
                        <td class="w-30">
                            @if ($data->submit_by)
                                {{ $data->submit_by }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Submit On</th>
                        <td class="w-30">
                            @if ($data->submit_on)
                                {{ Helpers::getdateFormat($data->submit_on) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Submit Comment</th>
                        <td class="w-80">
                            @if ($data->submit_comments)
                                {{ $data->submit_comments }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    <tr>

                    <tr>
                        <th class="w-20">Cancelled By</th>
                        <td class="w-30">
                            @if ($data->cancel_By)
                                {{ $data->cancel_By }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Cancelled On</th>
                        <td class="w-30">
                            @if ($data->cancel_On)
                                {{ Helpers::getdateFormat($data->cancel_On) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Cancelled Comment</th>
                        <td class="w-80">
                            @if ($data->cancel_comment)
                                {{ $data->cancel_comment }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    <tr>

                    <tr>
                        <th class="w-20">Supervisor Approval By</th>
                        <td class="w-30">
                            @if ($data->Supervisor_Approval_by)
                                {{ $data->Supervisor_Approval_by }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Supervisor Approval On</th>
                        <td class="w-30">
                            @if ($data->Supervisor_Approval_on)
                                {{ Helpers::getdateFormat($data->Supervisor_Approval_on) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Supervisor Approval Comment</th>
                        <td class="w-80">
                            @if ($data->Supervisor_Approval_comment)
                                {{ $data->Supervisor_Approval_comment }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    <tr>

                    <tr>
                        <th class="w-20">Complete By</th>
                        <td class="w-30">
                            @if ($data->Complete_by)
                                {{ $data->Complete_by }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Complete On</th>
                        <td class="w-30">
                            @if ($data->Complete_on)
                                {{ Helpers::getdateFormat($data->Complete_on) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Complete Comment</th>
                        <td class="w-80">
                            @if ($data->Complete_comment)
                                {{ $data->Complete_comment }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    <tr>

                    <tr>
                        <th class="w-20">Additional Work Required By</th>
                        <td class="w-30">
                            @if ($data->additional_work_by)
                                {{ $data->additional_work_by }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Additional Work Required On</th>
                        <td class="w-30">
                            @if ($data->additional_work_on)
                                {{ Helpers::getdateFormat($data->additional_work_on) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Additional Work Required Comment</th>
                        <td class="w-80">
                            @if ($data->additional_work_comment)
                                {{ $data->additional_work_comment }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    <tr>

                    <tr>
                        <th class="w-20">QA Approval By</th>
                        <td class="w-30">
                            @if ($data->qa_approval_by)
                                {{ $data->qa_approval_by }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">QA Approval On</th>
                        <td class="w-30">
                            @if ($data->qa_approval_on)
                                {{ Helpers::getdateFormat($data->qa_approval_on) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">QA Approval Comment</th>
                        <td class="w-80">
                            @if ($data->qa_approval_comment)
                                {{ $data->qa_approval_comment }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    <tr>

                </table>
            </div>
        </div>
    </div>

    <footer>
        <table>
            <tr>
                <td class="w-30"><strong>Printed On :</strong> {{ date('d-M-Y') }}</td>
                <td class="w-40"><strong>Printed By :</strong> {{ Auth::user()->name }}</td>
            </tr>
        </table>
    </footer>

</body>

</html>
