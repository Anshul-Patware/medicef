@extends('frontend.layout.main')
@section('container')
    @php
        $users = DB::table('users')->select('id', 'name')->get();

    @endphp

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>


    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }

        .sub-main-head {
            display: flex;
            justify-content: space-evenly;
        }

        .Activity-type {
            margin-bottom: 7px;
        }

        /* .sub-head {
                            margin-left: 280px;
                            margin-right: 280px;
                            color: #4274da;
                            border-bottom: 2px solid #4274da;
                            padding-bottom: 5px;
                            margin-bottom: 20px;
                            font-weight: bold;
                            font-size: 1.2rem;

                        } */

        .create-entity {
            background: #323c50;
            padding: 10px 15px;
            color: white;
            margin-bottom: 20px;

        }

        .bottom-buttons {
            display: flex;
            justify-content: flex-end;
            margin-right: 300px;
            margin-top: 50px;
            gap: 20px;
        }

        .launch_extension {
            background: #4274da;
            color: white;
            border: 0;
            padding: 4px 15px;
            border: 1px solid #4274da;
            transition: all 0.3s linear;
        }

        .main_head_modal {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* .modal-header{
                            background: gainsboro !important;
                        } */
        .main_head_modal li {
            margin-bottom: 10px;
        }

        .extension_modal_signature {
            display: block;
            width: 100%;
            border: 1px solid #837f7f;
            border-radius: 5px;
        }

        iframe#\:2\.container {
            /* display: none; */
            height: 0px !important;
            background: #4274da !important;
        }

        img.goog-te-gadget-icon {
            display: none;
        }

        .skiptranslate.goog-te-gadget {
            margin-bottom: 0px;
        }

        div#google_translate_element {
            border: none;
        }

        .VIpgJd-ZVi9od-aZ2wEe-wOHMyf.VIpgJd-ZVi9od-aZ2wEe-wOHMyf-ti6hGc {
            display: none;
        }
    </style>
    <style>
        .calenderauditee {
            position: relative;
        }

        .new-date-data-field input.hide-input {
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
        }

        .new-date-data-field input {
            border: 1px solid grey;
            border-radius: 5px;
            padding: 5px 15px;
            display: block;
            width: 100%;
            background: white;
        }

        .calenderauditee input::-webkit-calendar-picker-indicator {
            width: 100%;
        }

        .text-danger {
            margin-top: -22px;
            padding: 4px;
            margin-bottom: 3px;
        }

        /* .saveButton:disabled{
                                background: black!important;
                                border:  black!important;

                            } */
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        .calenderauditee {
            position: relative;
        }

        .new-date-data-field input.hide-input {
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
        }

        .new-date-data-field input {
            border: 1px solid grey;
            border-radius: 5px;
            padding: 5px 15px;
            display: block;
            width: 100%;
            background: white;
        }

        .calenderauditee input::-webkit-calendar-picker-indicator {
            width: 100%;
        }
    </style>

    <script>
        function otherController(value, checkValue, blockID) {
            let block = document.getElementById(blockID)
            let blockTextarea = block.getElementsByTagName('textarea')[0];
            let blockLabel = block.querySelector('label span.text-danger');
            if (value === checkValue) {
                blockLabel.classList.remove('d-none');
                blockTextarea.setAttribute('required', 'required');
            } else {
                blockLabel.classList.add('d-none');
                blockTextarea.removeAttribute('required');
            }
        }
    </script>
    <script>
        function addAuditAgenda(tableId) {
            var table = document.getElementById(tableId);
            var currentRowCount = table.rows.length;
            var newRow = table.insertRow(currentRowCount);
            newRow.setAttribute("id", "row" + currentRowCount);
            var cell1 = newRow.insertCell(0);
            cell1.innerHTML = currentRowCount;

            var cell2 = newRow.insertCell(1);
            cell2.innerHTML = "<input type='text'>";

            var cell3 = newRow.insertCell(2);
            cell3.innerHTML = "<input type='date'>";

            var cell4 = newRow.insertCell(3);
            cell4.innerHTML = "<input type='time'>";

            var cell5 = newRow.insertCell(4);
            cell5.innerHTML = "<input type='date'>";

            var cell6 = newRow.insertCell(5);
            cell6.innerHTML = "<input type='time'>";

            var cell7 = newRow.insertCell(6);
            cell7.innerHTML =
                // '<select name="auditor"><option value="">-- Select --</option><option value="1">Amit Guru</option></select>'

                var cell8 = newRow.insertCell(7);
            cell8.innerHTML =
                // '<select name="auditee"><option value="">-- Select --</option><option value="1">Amit Guru</option></select>'

                var cell9 = newRow.insertCell(8);
            cell9.innerHTML = "<input type='text'>";
            for (var i = 1; i < currentRowCount; i++) {
                var row = table.rows[i];
                row.cells[0].innerHTML = i;
            }
        }
    </script>
    <!-- <script>
        function addWhyField(con_class, name) {
            let mainBlock = document.querySelector('.why-why-chart')
            let container = mainBlock.querySelector(`.${con_class}`)
            let textarea = document.createElement('textarea')
            textarea.setAttribute('name', name);
            container.append(textarea)
        }
    </script> -->

    <script>
        console.log('Script working')
        $(document).ready(function() {

            let auditForm = document.getElementById('auditform');

            function submitForm() {
                document.querySelectorAll('.saveAuditFormBtn').forEach(function(button) {
                    button.disabled = true;
                })

                document.querySelectorAll('.auditFormSpinner').forEach(function(spinner) {
                    spinner.style.display = 'flex';
                })

                auditForm.submit();
            }

            $('#ChangesaveButton0011').click(function() {
                document.getElementById('formNameField').value = 'general';
                submitForm();
            });


        });
        // ==================================

        wow = new WOW({
            boxClass: 'wow', // default
            animateClass: 'animated', // default
            offset: 0, // default
            mobile: true, // default
            live: true // default
        })
        wow.init();
    </script>

    <script>
        $(document).ready(function() {
            $('#internalaudit-table').click(function(e) {
                function generateTableRow(serialNumber) {
                    var users = @json($users);
                    console.log(users);
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="audit[]"></td>' +
                        '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"> <input type="text" id="scheduled_start_date' +
                        serialNumber +
                        '" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="scheduled_start_date[]" id="scheduled_start_date' +
                        serialNumber +
                        '_checkdate" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"  class="hide-input" oninput="handleDateInput(this, `scheduled_start_date' +
                    serialNumber + '`);checkDate(`scheduled_start_date' + serialNumber +
                    '_checkdate`,`scheduled_end_date' + serialNumber +
                    '_checkdate`)" /></div></div></div></td>' +

                        '<td><input type="time" name="scheduled_start_time[]"></td>' +
                        '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"> <input type="text" id="scheduled_end_date' +
                        serialNumber +
                        '" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="scheduled_end_date[]" id="scheduled_end_date' +
                        serialNumber +
                        '_checkdate" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, `scheduled_end_date' +
                    serialNumber + '`);checkDate(`scheduled_start_date' + serialNumber +
                    '_checkdate`,`scheduled_end_date' + serialNumber +
                    '_checkdate`)" /></div></div></div></td>' +
                        '<td><input type="time" name="scheduled_end_time[]"></td>' +


                        '<td><select name="auditor[]">' +
                        '<option value="">Select a value</option>';

                    for (var i = 0; i < users.length; i++) {
                        html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    }

                    html += '</select></td>' +
                        '<td><select name="auditee[]">' +
                        '<option value="">Select a value</option>';

                    for (var i = 0; i < users.length; i++) {
                        html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    }
                    html += '</select></td>' +
                        '<td><input type="text" name="remarks[]"></td>' +
                        '</tr>';

                    return html;
                }

                var tableBody = $('#internalaudit tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#ObservationAdd').click(function(e) {
                function generateTableRow(serialNumber) {
                    var users = @json($users);

                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td> <select name="facility_name[]" id="facility_name">  <option value="">-- Select --</option>  <option value="Facility">Facility</option>  <option value="Equipment"> Equipment</option> <option value="Instrument">Instrument</option></select> </td>' +
                        '<td><input type="text" name="IDnumber[]"></td>' +
                        '<td><input type="text" name="Remarks[]"></td>' +
                        '<td><button class="removeRowBtn">Remove</button></td>' +


                        '</tr>';

                    for (var i = 0; i < users.length; i++) {
                        html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    }

                    html += '</select></td>' +

                        '</tr>';

                    return html;
                }

                var tableBody = $('#onservation-field-table tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#ReferenceDocument').click(function(e) {
                function generateTableRow(serialNumber) {
                    var users = @json($users);

                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="Number[]"></td>' +
                        '<td><input type="text" name="ReferenceDocumentName[]"></td>' +
                        '<td><input type="text" name="Document_Remarks[]"></td>' +
                        '<td><button class="removeRowBtn">Remove</button></td>' +


                        '</tr>';

                    for (var i = 0; i < users.length; i++) {
                        html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    }

                    html += '</select></td>' +

                        '</tr>';

                    return html;
                }

                var tableBody = $('#ReferenceDocument_details tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
        $(document).on('click', '.remove-file', function() {
            $(this).closest('div').remove();
            console.log('removing')
        })
    </script>

    <script>
        $(document).ready(function() {
            $('#Product_Details').click(function(e) {
                function generateTableRow(serialNumber) {
                    var users = @json($users);

                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="product_name[]"></td>' +
                        '<td> <input type="text" name="product_stage[]" id=""></td>' +
                        '<td><input type="text" name="batch_no[]"></td>' +
                        '<td><button class="removeRowBtn">Remove</button></td>' +
                        // '<td> <input type="text" name="product_stage[]" id=""> <option value="">-- Select --</option> <option value="">1 <option value="">2</option> <option value="">3</option><option value="">4</option> <option value="">5</option><option value="">6</option> <option value="">7</option> <option value="">8</option><option value="">9</option><option value="">Final</option> </select></td>' +




                        '</tr>';

                    for (var i = 0; i < users.length; i++) {
                        html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    }

                    html += '</select></td>' +

                        '</tr>';

                    return html;
                }

                var tableBody = $('#Product_Details_Details tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>
    <script>
        $(document).on('click', '.removeRowBtn', function() {
            $(this).closest('tr').remove();
        })
    </script>

    <script>
        $(document).ready(function() {
            let investigationTeamIndex = 1;
            $('#addInvestigationTeam').click(function(e) {
                function generateTableRow(serialNumber) {
                    var users = @json($users);
                    var userOptionsHtml = '';
                    users.forEach(user => {
                        userOptionsHtml = userOptionsHtml.concat(
                            `<option value="${user.id}">${user.name}</option>`)
                    });

                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td> <select name="investigationTeam[' + investigationTeamIndex +
                        '][teamMember]" > <option value="">-- Select --</option>' + userOptionsHtml +
                        ' </select> </td>' +
                        ' <td><input type="text" name="investigationTeam[' + investigationTeamIndex +
                        '][responsibility]"></td>' +
                        '<td><input type="text" name="investigationTeam[' + investigationTeamIndex +
                        '][remarks]"></td>' +
                        '<td><button type="text" class="removeRowBtn">Remove</button></td>' +
                        '</tr>';
                    '</tr>';

                    docIndex++;
                    return html;
                }
                var tableBody = $('#investigationDetailAddTable tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            let rootCauseIndex = 1;
            $('#rootCauseAdd').click(function(e) {
                function generateTableRow(serialNumber) {
                    var users = @json($users);

                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td> <select name="rootCauseData[' + rootCauseIndex +
                        '][rootCauseCategory]" id=""> <option value="">-- Select --</option><option value="">name   </option> </select></td>' +
                        '<td><select name="rootCauseData[' + rootCauseIndex +
                        '][rooCauseSubCategory]" id=""><option value="">-- Select --</option><option value="">name</option>  </select></td>' +
                        '<td><input type="text" class="Document_Remarks" name="rootCauseData[' +
                        rootCauseIndex + '][ifOthers]"></td>' +
                        '<td><input type="text" class="Document_Remarks" name="rootCauseData[' +
                        rootCauseIndex + '][probability]"></td>' +
                        '<td><input type="text" class="Document_Remarks" name="rootCauseData[' +
                        rootCauseIndex + '][remarks]"></td>' +
                        '<td><button type="text" class="removeRowBtn" ">Remove</button></td>' +

                        '</tr>';

                    rootCauseIndex++;
                    return html;
                }

                var tableBody = $('#rootCauseAddTable tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#risk_matrix_details').click(function(e) {
                function generateTableRow(serialNumber) {
                    var users = @json($users);

                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" class="Document_Remarks" name="Risk_Assessment[]"></td>' +
                        '<td><input type="text" class="Document_Remarks" name="Review_Schedule[]"></td>' +
                        '<td><input type="text" class="Document_Remarks" name="Actual_Reviewed[]"></td>' +
                        '<td><input type="text" class="Document_Remarks" name="Recorded_By[]"></td>' +
                        '<td><input type="text" class="Document_Remarks" name="Remarks[]"></td>' +
                        '<td><button type="text" class="removeRowBtn" ">Remove</button></td>' +

                        '</tr>';

                    for (var i = 0; i < users.length; i++) {
                        html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    }

                    html += '</select></td>' +

                        '</tr>';

                    return html;
                }

                var tableBody = $('#risk_matrix_details_details tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>
    <script>
        function calculateDueDate() {
            const initiationDateInput = document.getElementById('intiation_date');
            const deviationCategorySelect = document.getElementById('Deviation_category');
            const dueDateInput = document.getElementById('due_date');

            if (initiationDateInput.value && deviationCategorySelect.value) {
                const initiationDate = new Date(initiationDateInput.value);
                let dueDate = new Date(initiationDate);

                switch (deviationCategorySelect.value) {
                    case 'minor':
                        dueDate.setDate(dueDate.getDate() + 15);
                        break;
                    case 'major':
                        dueDate.setDate(dueDate.getDate() + 30);
                        break;
                    case 'critical':
                        dueDate.setDate(dueDate.getDate() + 45);
                        break;
                    default:
                        dueDate = null;
                        break;
                }

                if (dueDate) {
                    const day = String(dueDate.getDate()).padStart(2, '0');
                    const monthNames = [
                        'January', 'February', 'March', 'April', 'May', 'June',
                        'July', 'August', 'September', 'October', 'November', 'December'
                    ];
                    const month = monthNames[dueDate.getMonth()];
                    const year = dueDate.getFullYear();
                    dueDateInput.value = `${day}-${month}-${year}`;
                }
            }
        }

        document.getElementById('intiation_date').addEventListener('change', calculateDueDate);
        document.getElementById('Deviation_category').addEventListener('change', calculateDueDate);
    </script>



    {{-- Top Header in page --}}
    <div class="form-field-head">
        <div class="division-bar">
            <strong>Site Division/Project</strong>:
            {{ Helpers::getDivisionName(session()->get('division')) }}/Deviation
        </div>
    </div>



    {{-- ======================================
                    DATA FIELDS
    ======================================= --}}

    <div id="change-control-fields">
        <div class="container-fluid">

            <script type="text/javascript">
                function googleTranslateElementInit() {
                    new google.translate.TranslateElement({
                        pageLanguage: 'en',
                        includedLanguages: 'en,es,fr,de,zh,hi,ar,pt,ja,ru',
                        layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                    }, 'google_translate_element');
                }
            </script>
            <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
            </script>
            <script>
                $(document).ready(function() {
                    setTimeout(() => {
                        $('body').css('top', '0');
                    }, 5000);
                })
            </script>

            {{-- header tabs link --}}
            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm8')">HOD Review</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">QA Initial Review</button>
                <button class="cctablinks " onclick="openCity(event, 'CCForm7')">CFT</button>
                <button class="cctablinks " id="Investigation_button"
                    onclick="openCity(event, 'CCForm9')">Investigation</button>
                <button id="QRM_button" class="cctablinks" onclick="openCity(event, 'CCForm11')">QRM</button>

                <button id="CAPA_button" class="cctablinks" onclick="openCity(event, 'CCForm10')">CAPA</button>
                {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Investigation & CAPA</button> --}}
                <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Initiator Update</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm5')">QAH/Designee Approval</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm12')">Extension</button>

                <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Activity Log</button>
            </div>

            {{-- language selection --}}
            <div class="language-sleect d-flex" style="align-items: center; gap: 20px; margin-left: 20px;">
                <div>Select Language </div>
                <div class="main-head" id="google_translate_element"></div>
            </div>

            {{-- forms starts here --}}
            <form id="auditform" action="{{ route('deviationstore') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="form_name" id="formNameField" value="">
                <div id="step-form">

                    <!-- General information content -->

                    @if ($errors->any())
                        @foreach ($errors as $error)
                            <div class="text-danger">{{ $error }}</div>
                        @endforeach
                    @endif

                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                @if (!empty($parent_id))
                                    <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                                    <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                                    <input type="hidden" name="parent_record" value="{{ $parent_record }}">
                                @endif
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input disabled type="text" name="record_number"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}/DEV/{{ date('Y') }}/{{ $record_number }}">

                                        {{-- <div class="static">QMS-EMEA/CAPA/{{ date('Y') }}/{{ $record_number }}</div> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Site/Location Code</b></label>
                                        <input disabled type="text" name="division_code"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                        <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Initiator</b></label>
                                        {{-- <div class="static">{{ Auth::user()->name }}</div> --}}
                                        <input disabled type="text" value="{{ Auth::user()->name }}">

                                    </div>
                                </div>


                                @php
                                    // Calculate the due date (30 days from the initiation date)
                                    $initiationDate = date('Y-m-d'); // Current date as initiation date
                                    $dueDate = date('Y-m-d', strtotime($initiationDate . '+30 days')); // Due date
                                @endphp



                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date of Initiation"><b>Date of Initiation</b></label>
                                        <input readonly type="text" value="{{ date('d-M-Y') }}"
                                            style="background-color: light-dark(rgba(239, 239, 239, 0.3), rgba(59, 59, 59, 0.3))">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Due Date"> Due Date <span class="text-danger">*</span></label>
                                        <div><small class="text-primary">If revising Due Date, kindly mention revision
                                                reason in "Due Date Extension Justification" data field.</small></div>
                                        <div class="calenderauditee">
                                            <input disabled type="text" id="due_date" readonly placeholder="DD-MMM-YYYY"
                                                required />
                                            <input type="date" name="due_date" required
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'due_date')" />
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    function calculateDueDate() {
                                        const initiationDateInput = document.getElementById('intiation_date');
                                        const deviationCategorySelect = document.getElementById('Deviation_category');
                                        const dueDateInput = document.getElementById('due_date');

                                        if (initiationDateInput.value && deviationCategorySelect.value) {
                                            const initiationDate = new Date(initiationDateInput.value);
                                            let dueDate = new Date(initiationDate);

                                            switch (deviationCategorySelect.value) {
                                                case 'minor':
                                                    dueDate.setDate(dueDate.getDate() + 15);
                                                    break;
                                                case 'major':
                                                    dueDate.setDate(dueDate.getDate() + 30);
                                                    break;
                                                case 'critical':
                                                    dueDate.setDate(dueDate.getDate() + 30);
                                                    break;
                                                default:
                                                    dueDate = null;
                                                    break;
                                            }

                                            if (dueDate) {
                                                const day = String(dueDate.getDate()).padStart(2, '0');
                                                const monthNames = [
                                                    'January', 'February', 'March', 'April', 'May', 'June',
                                                    'July', 'August', 'September', 'October', 'November', 'December'
                                                ];
                                                const month = monthNames[dueDate.getMonth()];
                                                const year = dueDate.getFullYear();
                                                dueDateInput.value = `${day}-${month}-${year}`;
                                            }
                                        }
                                    }

                                    document.getElementById('intiation_date').addEventListener('change', calculateDueDate);
                                    document.getElementById('Deviation_category').addEventListener('change', calculateDueDate);
                                </script>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="initiator-group">Initiation Department<span
                                                class = "text-danger">*</span></label>
                                        <select name="Initiator_Group" id="initiator_group">
                                            <option value="NA">Select Department</option>
                                            <option value="CQA">Corporate Quality Assurance</option>
                                            <option value="QA">Quality Assurance</option>
                                            <option value="QC">Quality Control</option>
                                            <option value="QM">Quality Control (Microbiology department)</option>
                                            <option value="PG">Production General</option>
                                            <option value="PL">Production Liquid Orals</option>
                                            <option value="PT">Production Tablet and Powder</option>
                                            <option value="PE">Production External (Ointment, Gels, Creams and Liquid)
                                            </option>
                                            <option value="PC">Production Capsules</option>
                                            <option value="PI">Production Injectable</option>
                                            <option value="EN">Engineering</option>
                                            <option value="HR">Human Resource</option>
                                            <option value="ST">Store</option>
                                            <option value="IT">Electronic Data Processing</option>
                                            <option value="FD">Formulation Development</option>
                                            <option value="AL">Analytical research and Development Laboratory</option>
                                            <option value="PD">Packaging Development</option>
                                            <option value="PU">Purchase Department</option>
                                            <option value="DC">Document Cell</option>
                                            <option value="RA">Regulatory Affairs</option>
                                            <option value="PV">Pharmacovigilance</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span id="rchars">255 Characters
                                            remaining</span>
                                        <div class="relative-container">
                                            <input type="text" class="mic-input" name="short_description"
                                                id="docname" maxlength="255" required>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                        @error('short_description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ----------hod Review-------- -->
                    <div id="CCForm8" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                @if (!empty($parent_id))
                                    <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                                    <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                                    <input type="hidden" name="parent_record" value="{{ $parent_record }}">
                                @endif
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input disabled type="text" name="record_number"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}/DEV/{{ date('Y') }}/{{ $record_number }}">

                                        {{-- <div class="static">QMS-EMEA/CAPA/{{ date('Y') }}/{{ $record_number }}</div> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Site/Location Code</b></label>
                                        <input disabled type="text" name="division_code"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                        <input type="hidden" name="division_id"
                                            value="{{ session()->get('division') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Initiator</b></label>
                                        {{-- <div class="static">{{ Auth::user()->name }}</div> --}}
                                        <input disabled type="text" value="{{ Auth::user()->name }}">

                                    </div>
                                </div>


                                @php
                                    // Calculate the due date (30 days from the initiation date)
                                    $initiationDate = date('Y-m-d'); // Current date as initiation date
                                    $dueDate = date('Y-m-d', strtotime($initiationDate . '+30 days')); // Due date
                                @endphp



                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date of Initiation"><b>Date of Initiation</b></label>
                                        <input readonly type="text" value="{{ date('d-M-Y') }}"
                                            style="background-color: light-dark(rgba(239, 239, 239, 0.3), rgba(59, 59, 59, 0.3))">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Due Date"> Due Date <span class="text-danger">*</span></label>
                                        <div><small class="text-primary">If revising Due Date, kindly mention revision
                                                reason in "Due Date Extension Justification" data field.</small></div>
                                        <div class="calenderauditee">
                                            <input disabled type="text" id="due_date" readonly
                                                placeholder="DD-MMM-YYYY" required />
                                            <input type="date" name="due_date" required
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'due_date')" />
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    function calculateDueDate() {
                                        const initiationDateInput = document.getElementById('intiation_date');
                                        const deviationCategorySelect = document.getElementById('Deviation_category');
                                        const dueDateInput = document.getElementById('due_date');

                                        if (initiationDateInput.value && deviationCategorySelect.value) {
                                            const initiationDate = new Date(initiationDateInput.value);
                                            let dueDate = new Date(initiationDate);

                                            switch (deviationCategorySelect.value) {
                                                case 'minor':
                                                    dueDate.setDate(dueDate.getDate() + 15);
                                                    break;
                                                case 'major':
                                                    dueDate.setDate(dueDate.getDate() + 30);
                                                    break;
                                                case 'critical':
                                                    dueDate.setDate(dueDate.getDate() + 30);
                                                    break;
                                                default:
                                                    dueDate = null;
                                                    break;
                                            }

                                            if (dueDate) {
                                                const day = String(dueDate.getDate()).padStart(2, '0');
                                                const monthNames = [
                                                    'January', 'February', 'March', 'April', 'May', 'June',
                                                    'July', 'August', 'September', 'October', 'November', 'December'
                                                ];
                                                const month = monthNames[dueDate.getMonth()];
                                                const year = dueDate.getFullYear();
                                                dueDateInput.value = `${day}-${month}-${year}`;
                                            }
                                        }
                                    }

                                    document.getElementById('intiation_date').addEventListener('change', calculateDueDate);
                                    document.getElementById('Deviation_category').addEventListener('change', calculateDueDate);
                                </script>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="initiator-group">Initiation Department<span
                                                class = "text-danger">*</span></label>
                                        <select name="Initiator_Group" id="initiator_group">
                                            <option value="NA">Select Department</option>
                                            <option value="CQA">Corporate Quality Assurance</option>
                                            <option value="QA">Quality Assurance</option>
                                            <option value="QC">Quality Control</option>
                                            <option value="QM">Quality Control (Microbiology department)</option>
                                            <option value="PG">Production General</option>
                                            <option value="PL">Production Liquid Orals</option>
                                            <option value="PT">Production Tablet and Powder</option>
                                            <option value="PE">Production External (Ointment, Gels, Creams and Liquid)
                                            </option>
                                            <option value="PC">Production Capsules</option>
                                            <option value="PI">Production Injectable</option>
                                            <option value="EN">Engineering</option>
                                            <option value="HR">Human Resource</option>
                                            <option value="ST">Store</option>
                                            <option value="IT">Electronic Data Processing</option>
                                            <option value="FD">Formulation Development</option>
                                            <option value="AL">Analytical research and Development Laboratory</option>
                                            <option value="PD">Packaging Development</option>
                                            <option value="PU">Purchase Department</option>
                                            <option value="DC">Document Cell</option>
                                            <option value="RA">Regulatory Affairs</option>
                                            <option value="PV">Pharmacovigilance</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span id="rchars">255 Characters
                                            remaining</span>
                                        <div class="relative-container">
                                            <input type="text" class="mic-input" name="short_description"
                                                id="docname" maxlength="255" required>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                        @error('short_description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="HOD Remarks">HOD Remarks</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does
                                                not require completion</small></div>
                                        <textarea class="tiny" name="HOD_Remarks" id="summernote-4"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">HOD Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="initial_file"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="HOD_Attachments" name="initial_file[]"
                                                    oninput="addMultipleFiles(this, 'initial_file')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="button-block">
                                <button type="submit" style=" justify-content: center; width: 4rem; margin-left: 1px;"
                                    class="saveButton">Save </button>
                                <a href="/rcms/qms-dashboard"
                                    style=" justify-content: center; width: 4rem; margin-left: 1px;">
                                    <button type="button"
                                        style=" justify-content: center; width: 4rem; margin-left: 1px;"
                                        class="backButton">Back</button>
                                </a>
                                <button type="button" style=" justify-content: center; width: 4rem; margin-left: 1px;"
                                    class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button" style=" justify-content: center; width: 4rem; margin-left: 1px;">
                                    <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                                <!-- <a style="  justify-content: center; width: 10rem; margin-left: 1px;" type="button"
                                                                class="button  launch_extension" data-bs-toggle="modal"
                                                                data-bs-target="#launch_extension">
                                                                Launch Extension
                                                            </a> -->
                                {{-- <a type="button" class="button  launch_extension" data-bs-toggle="modal"
                                        data-bs-target="#effectivenss_extension">
                                        Launch Effectiveness Check
                                    </a> --}}
                            </div>
                        </div>
                    </div>

                    
                    <div>
                        <button type="submit">Save</button>
                    </div>
                </div>
            </form>

            <script>
                VirtualSelect.init({
                    ele: '#Facility, #Group, #Audit, #Auditee ,#related_records ,#audit_type, #investigation_approach'
                });

                function openCity(evt, cityName) {
                    var i, cctabcontent, cctablinks;
                    cctabcontent = document.getElementsByClassName("cctabcontent");
                    for (i = 0; i < cctabcontent.length; i++) {
                        cctabcontent[i].style.display = "none";
                    }
                    cctablinks = document.getElementsByClassName("cctablinks");
                    for (i = 0; i < cctablinks.length; i++) {
                        cctablinks[i].className = cctablinks[i].className.replace(" active", "");
                    }
                    document.getElementById(cityName).style.display = "block";
                    evt.currentTarget.className += " active";
                }



                function openCity(evt, cityName) {
                    var i, cctabcontent, cctablinks;
                    cctabcontent = document.getElementsByClassName("cctabcontent");
                    for (i = 0; i < cctabcontent.length; i++) {
                        cctabcontent[i].style.display = "none";
                    }
                    cctablinks = document.getElementsByClassName("cctablinks");
                    for (i = 0; i < cctablinks.length; i++) {
                        cctablinks[i].className = cctablinks[i].className.replace(" active", "");
                    }
                    document.getElementById(cityName).style.display = "block";
                    evt.currentTarget.className += " active";

                    // Find the index of the clicked tab button
                    const index = Array.from(cctablinks).findIndex(button => button === evt.currentTarget);

                    // Update the currentStep to the index of the clicked tab
                    currentStep = index;
                }

                const saveButtons = document.querySelectorAll(".saveButton");
                const nextButtons = document.querySelectorAll(".nextButton");
                const form = document.getElementById("step-form");
                const stepButtons = document.querySelectorAll(".cctablinks");
                const steps = document.querySelectorAll(".cctabcontent");
                let currentStep = 0;

                function nextStep() {
                    // Check if there is a next step
                    if (currentStep < steps.length - 1) {
                        // Hide current step
                        steps[currentStep].style.display = "none";

                        // Show next step
                        steps[currentStep + 1].style.display = "block";

                        // Add active class to next button
                        stepButtons[currentStep + 1].classList.add("active");

                        // Remove active class from current button
                        stepButtons[currentStep].classList.remove("active");

                        // Update current step
                        currentStep++;
                    }
                }

                function previousStep() {
                    // Check if there is a previous step
                    if (currentStep > 0) {
                        // Hide current step
                        steps[currentStep].style.display = "none";

                        // Show previous step
                        steps[currentStep - 1].style.display = "block";

                        // Add active class to previous button
                        stepButtons[currentStep - 1].classList.add("active");

                        // Remove active class from current button
                        stepButtons[currentStep].classList.remove("active");

                        // Update current step
                        currentStep--;
                    }
                }
            </script>
        </div>
    </div>
@endsection
