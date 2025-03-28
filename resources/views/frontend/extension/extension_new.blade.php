@extends('frontend.layout.main')
@section('container')
    @php
        $users = DB::table('users')->select('id', 'name')->where('active', 1)->get();
        $userRoles = DB::table('user_roles')->select('user_id')->where('q_m_s_roles_id', 4)->distinct()->get();
        $departments = DB::table('departments')->select('id', 'name')->get();
        $divisions = DB::table('q_m_s_divisions')->select('id', 'name')->get();

        $userIds = DB::table('user_roles')->where('q_m_s_roles_id', 4)->distinct()->pluck('user_id');

        // Step 3: Use the plucked user_id values to get the names from the users table
        $userNames = DB::table('users')->whereIn('id', $userIds)->pluck('name');

        // If you need both id and name, use the select method and get
        $userDetails = DB::table('users')->whereIn('id', $userIds)->select('id', 'name')->get();
        // dd ($userIds,$userNames, $userDetails);
    @endphp
    <style>

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
        
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }

        

    </style>
    </style>

    <script>
        $(document).ready(function() {
            $('#ObservationAdd').click(function(e) {
                function generateTableRow(serialNumber) {

                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="jobResponsibilities[' + serialNumber +
                        '][serial]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="jobResponsibilities[' + serialNumber +
                        '][job]"></td>' +
                        '<td><input type="text" class="Document_Remarks" name="jobResponsibilities[' +
                        serialNumber + '][remarks]"></td>' +


                        '</tr>';

                    return html;
                }

                var tableBody = $('#job-responsibilty-table tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>
    <div class="form-field-head">

        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            {{ Helpers::getDivisionName(session()->get('division')) }} /
            {{-- {{ Helpers::getDivisionName($data->division_id) }} / --}}
            Extension
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
            <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
            <script>
                $(document).ready(function() {
                    setTimeout(() => {
                        $('body').css('top', '0');
                    }, 5000);
                })
            </script>
            <!-- Tab links -->
            <div class="cctab">

                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
                <button class="cctablinks " onclick="openCity(event, 'CCForm2')">HOD Review</button>
                <button class="cctablinks " onclick="openCity(event, 'CCForm3')">QA Approval</button>

                <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Activity Log</button>
               
            </div>
            <div class="language-sleect d-flex" style="align-items: center; gap: 20px; margin-left: 20px;">
                <div>Select Language</div>
            <div class="main-head" id="google_translate_element"></div>
            </div>
            <form action="{{ route('extension_new.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Tab content -->
                <div id="step-form">
                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                @if (!empty($parent_id))
                                    <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                                    <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                                    {{-- <input type="hidden" name="parent_record" id="parent_record" value="{{ $parent_record }}"> --}}
                                @endif
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input type="hidden" name="record" value="{{ $record_number }}">
                                        <input disabled type="text" name="record_number"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}/Ext/{{ date('y') }}/{{ $record_number }}">
                                        {{-- <div class="static">QMS-EMEA/CAPA/{{ date('Y') }}/{{ $record_number }}</div> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Site/Location Code</b></label>
                                        <input disabled type="text" name="site_location_code"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                        <input type="hidden" name="site_location_code"
                                            value="{{ session()->get('division') }}">
                                        {{-- <div class="static">{{ Helpers::getDivisionName(session()->get('division')) }}</div> --}}
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Initiator</b></label>
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
                                            name="initiation_date_new" id="initiation_date"
                                            style="background-color: light-dark(rgba(239, 239, 239, 0.3), rgba(59, 59, 59, 0.3))">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="initiation_date">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span class="text-danger">*</span></label>
                                        <span id="rchars">255</span> Characters remaining
                                        <div class="relative-container">
                                            <input id="docname" type="text" name="short_description" maxlength="255" required>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                    {{-- @error('short_description')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror --}}
                                </div>
                                
                                <script>
                                    var maxLength = 255;
                                    $('#docname').keyup(function() {
                                        var textlen = maxLength - $(this).val().length;
                                        $('#rchars').text(textlen);
                                    });
                                </script>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Assigned To">HOD Reviewer</label>
                                        <select id="choices-multiple-remove" class="choices-multiple-reviewe"
                                            name="reviewers" placeholder="Select Reviewers">
                                            <option value="">-- Select --</option>


                                            @if (!empty(Helpers::getHODDropdown()))
                                                @foreach (Helpers::getHODDropdown() as $lan)
                                                    <option value="{{ $lan['id'] }}">
                                                        {{ $lan['name'] }}
                                                    </option>
                                                @endforeach
                                            @endif

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="priority_data Department">Priority</label>
                                        <select name="priority_data" id="priority_data">
                                            <option value="">--Select--</option>
                                            <option value="High" >High</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="severity-level">Initial Categorization</label>
                                      
                                        <select name="initial_categorization" id="initial_categorization">
                                            <option value="">-- Select --</option>
                                            <option value="minor">Minor</option>
                                            <option value="major">Major</option>
                                            <option value="critical">Critical</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="related_records">Related Records</label>
                                        <select multiple name="related_records[]" placeholder="Select Reference Records"
                                            data-silent-initial-value-set="true" id="related_records">

                                            @foreach ($relatedRecords as $records)
                                                <option
                                                    value="{{ Helpers::getDivisionName(
                                                        $records->division_id || $records->division || $records->division_code || $records->site_location_code,
                                                    ) .
                                                        '/' .
                                                        $records->process_name .
                                                        '/' .
                                                        date('Y') .
                                                        '/' .
                                                        Helpers::recordFormat($records->record) }}">
                                                    {{ Helpers::getDivisionName(
                                                        $records->division_id || $records->division || $records->division_code || $records->site_location_code,
                                                    ) .
                                                        '/' .
                                                        $records->process_name .
                                                        '/' .
                                                        date('Y') .
                                                        '/' .
                                                        Helpers::recordFormat($records->record) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('related_records')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Assigned To">QA Approval</label>
                                        <select id="choices-multiple-remove-but" class="choices-multiple-reviewer"
                                            name="approvers" placeholder="Select Approvers">
                                            <option value="">-- Select --</option>

                                            @if (!empty($users))
                                                @foreach ($users as $lan)
                                                    @if (Helpers::checkUserRolesApprovers($lan))
                                                        <option value="{{ $lan->id }}">
                                                            {{ $lan->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Actual Start Date">Current Due Date (Parent)</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="start_date" readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="current_due_date"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                                class="hide-input" oninput="handleDateInput(this, 'start_date')" />
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        function updateProposedDueDateMin() {
                                            var currentDueDateInput = document.querySelector('input[name="current_due_date"]');
                                            var proposedDueDateInput = document.querySelector('input[name="proposed_due_date"]');

                                            if (currentDueDateInput && proposedDueDateInput) {
                                                var currentDueDateValue = currentDueDateInput.value;
                                                if (currentDueDateValue) {
                                                    proposedDueDateInput.setAttribute('min', currentDueDateValue);
                                                } else {
                                                    proposedDueDateInput.setAttribute('min', new Date().toISOString().split('T')[0]);
                                                }
                                            }
                                        }
                                        updateProposedDueDateMin();
                                        document.querySelector('input[name="current_due_date"]').addEventListener('change',
                                            updateProposedDueDateMin);
                                    });
                                </script>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Actual Start Date">Proposed Due Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="test_date" readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="proposed_due_date"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                                class="hide-input" oninput="handleDateInput(this, 'test_date')" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Description</label>
                                        <div class="relative-container">
                                            <textarea name="description" id="description" cols="30"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                    {{-- @error('short_description')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror --}}
                                </div>
                                
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Justification / Reason</label>
                                        <div class="relative-container">
                                            <textarea name="justification_reason" id="justification_reason" cols="30"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                    {{-- @error('short_description')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror --}}
                                </div>
                                
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Guideline Attachment">Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="file_attachment_extension"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="file_attachment_extension[]"
                                                    oninput="addMultipleFiles(this, 'file_attachment_extension')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton01" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>


                                <button type="button"> <a href="{{ url('TMS') }}" class="text-white">
                                        Exit </a> </button>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- reviewer content -->
                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Assigned To">HOD Remarks</label>
                                    <div class="relative-container">
                                        <textarea name="reviewer_remarks" id="reviewer_remarks" cols="30"></textarea>
                                        @component('frontend.forms.language-model')
                                        @endcomponent
                                    </div>
                                </div>
                            </div>
                            

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="HOD Attachment">HOD Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_attachment_reviewer"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="file_attachment_reviewer[]"
                                                oninput="addMultipleFiles(this, 'file_attachment_reviewer')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="button-block">
                            <button type="submit" id="ChangesaveButton02" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>


                            <button type="button"> <a href="{{ url('TMS') }}" class="text-white">
                                    Exit </a> </button>
                        </div>
                    </div>
                </div>
                <!-- Approver-->
                <div id="CCForm3" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="priority_data Department">Post Categorization</label>
                                    <select name="post_categorization" id="post_categorization">
                                        <option value="">--Select--</option>
                                        <option value="major">Major</option>
                                        <option value="minor">Minor</option>
                                        <option value="critical">Critical</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Assigned To">QA Remarks</label>
                                    <div class="relative-container">
                                        <textarea name="approver_remarks" id="approver_remarks" cols="30"></textarea>
                                        @component('frontend.forms.language-model')
                                        @endcomponent
                                    </div>
                                </div>
                            </div>
                            

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Guideline Attachment">QA Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_attachment_approver"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="file_attachment_approver[]"
                                                oninput="addMultipleFiles(this, 'file_attachment_approver')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="button-block">
                            <button type="submit" id="ChangesaveButton02" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>

                            <button type="button"> <a href="{{ url('TMS') }}" class="text-white">
                                    Exit </a> </button>
                        </div>
                    </div>
                </div>
                <!-- Activity Log content -->
                <div id="CCForm6" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Activated By">Submit By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Activated On">Submit On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Activated On">Comment</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for=" Rejected By">Cancel By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Rejected On">Cancel On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Rejected On">Comment</label>
                                    <div class="static"></div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for=" Rejected By">More Information Required By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Rejected On">More Information Required On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Rejected On">Comment</label>
                                    <div class="static"></div>
                                </div>
                            </div>


                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for=" Rejected By">Review By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Rejected On">Review On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Rejected On">Comment</label>
                                    <div class="static"></div>
                                </div>
                            </div>


                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for=" Rejected By">Reject By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Rejected On">Reject On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Rejected On">Comment</label>
                                    <div class="static"></div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for=" Rejected By">More Information Required By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Rejected On">More Information Required On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Rejected On">Comment</label>
                                    <div class="static"></div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for=" Rejected By">Send for CQA By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Rejected On">Send for CQA On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Rejected On">Comment</label>
                                    <div class="static"></div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for=" Rejected By"> Approved By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Rejected On"> Approved On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Rejected On">Comment</label>
                                    <div class="static"></div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for=" Rejected By"> CQA Approval Complete By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Rejected On"> CQA Approval Complete On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Rejected On">Comment</label>
                                    <div class="static"></div>
                                </div>
                            </div>

                        </div>
                        {{-- <div class="button-block">
                        <button type="submit" class="saveButton">Save</button>
                        <a href="/rcms/qms-dashboard">
                            <button type="button" class="backButton">Back</button>
                        </a>
                        <button type="submit">Submit</button>
                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                Exit </a> </button>
                    </div> --}}


                        <div class="button-block">
                            <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>

                            <button type="button">
                                <a href="{{ url('TMS') }}" class="text-white">
                                    Exit </a> </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
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

    {{--  <script>
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

        const saveButtons = document.querySelectorAll('.saveButton1');
        const form = document.getElementById('step-form');
    </script>  --}}
    <script>
        VirtualSelect.init({
            ele: '#Facility, #Group, #Audit, #Auditee ,#relatedRecords, #designee, #hod,#related_records'
        });
    </script>
@endsection
