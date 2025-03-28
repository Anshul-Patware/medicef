@extends('frontend.layout.main')
@section('container')
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
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

    <div class="form-field-head">
        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            {{ Helpers::getDivisionName(session()->get('division')) }} / Root Cause Analysis
            {{-- KSA / Root Cause Analysis   --}}
            {{-- EHS-North America --}}
        </div>
    </div>

    @php
        $users = DB::table('users')->get();
    @endphp

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
                <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Investigation</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm4')">QA Review</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Investigation & Root Cause</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm10')">HOD Final Review</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm11')">QA Final Review</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm12')">QAH/CQAH Final Review</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Activity Log</button>
            </div>

            <div class="language-sleect d-flex" style="align-items: center; gap: 20px; margin-left: 20px;">
                <div>Select Language </div>
            <div class="main-head" id="google_translate_element"></div>
            </div>

            <form action="{{ route('root_store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div id="step-form">
                    @if (!empty($parent_id))
                        <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                        <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                    @endif

                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input disabled type="text" name="record_number"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}/RCA/{{ date('Y') }}/{{ $record_number }}">

                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Site/Location Code </b></label>
                                        <input readonly type="text" name="division_code"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                        <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                        {{-- <div class="static">{{ Helpers::getDivisionName(session()->get('division')) }}</div> --}}
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="originator">Initiator</label>
                                        <input readonly type="text" name="originator_id"
                                            value="{{ Auth::user()->name }}" />
                                    </div>
                                </div>

                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="date-opened">Date Opened </label>
                                        <div><small class="text-primary">When was this Investigation record opened?</small>
                                        </div>
                                        <input type="text" name="date_opened" value="{{date('d-M-Y')}}" readonly>
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="date_opened">

                                    </div>
                                </div> --}}
                                <div class="col-lg-6">
                                    <div class="group-input ">
                                        <label for="Date Due"><b>Date of Initiation</b></label>
                                        <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                        <input type="hidden" value="{{ date('d-m-Y') }}" name="intiation_date">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator Group">Initiator Department </label>
                                        <select name="initiator_Group" id="initiator_group">
                                            <option value="">Select Department</option>
                                            <option value="CQA">Corporate Quality Assurance</option>
                                            <option value="QA">Quality Assurance</option>
                                            <option value="QC">Quality Control</option>
                                            <option value="QM">Quality Control (Microbiology department)</option>
                                            <option value="PG">Production General</option>
                                            <option value="PL">Production Liquid Orals</option>
                                            <option value="PT">Production Tablet and Powder</option>
                                            <option value="PE">Production External (Ointment, Gels, Creams and Liquid)</option>
                                            <option value="PC">Production Capsules</option>
                                            <option value="PI">Production Injectable</option>
                                            <option value="EN">Engineering</option>
                                            <option value="HR">Human Resource</option>
                                            <option value="ST">Store</option>
                                            <option value="EP">Electronic Data Processing</option>
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
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator Group Code">Initiator Department Code</label>
                                        <input type="text" name="initiator_group_code" id="initiator_group_code"
                                            value="" readonly>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span id="rchars">255</span>
                                        characters remaining
                                        <div class="relative-container">
                                        <input id="docname" type="text" name="short_description" maxlength="255"
                                            required>
                                        @component('frontend.forms.language-model')
                                        @endcomponent
                                        </div>
                                    </div>
                                </div>

                                {{--<div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="due-date">Due Date <span class="text-danger"></span></label>
                                        <div class="calenderauditee">
                                            <!-- Display the formatted date in a readonly input -->
                                            <input type="text" id="due_date_display" readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getDueDate(30, true) }}" />
                                           
                                            <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ Helpers::getDueDate(30, false) }}" class="hide-input" readonly />
                                        </div>
                                    </div>
                                </div>--}}

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="severity-level">Severity Level</label>
                                        <span class="text-primary">Severity levels in a QMS record gauge issue seriousness,
                                            guiding priority for corrective actions. Ranging from low to high, they ensure
                                            quality standards and mitigate critical risks.</span>
                                        <select name="severity_level">
                                            <option value="">-- Select --</option>
                                            <option value="minor">Minor</option>
                                            <option value="major">Major</option>
                                            <option value="critical">Critical</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="priority_data Department">Priority</label>
                                        <select name="priority_data" id="priority_data">
                                            <option value="">--Select--</option>
                                            <option value="High" >High</option>
                                            <option value="Medium" >Medium</option>
                                            <option value="Low" >Low</option>
                                        </select>
                                    </div>
                                </div>
                                {{--  <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Assigned To
                                        </label>
                                        <select id="select-state" placeholder="Select..." name="assign_to" required>
                                            <option value="">Select a value</option>
                                            @foreach ($users as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('assign_to')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>  --}}

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="assign_to">Department Head <span class="text-danger">*</span></label>
                                        <select id="assign_to" name="assign_to" required class="form-control">
                                            <option value="">Select a value</option>
                                            @foreach ($users as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('assign_to')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="qa_reviewer">QA Reviewer <span class="text-danger">*</span></label>
                                        <select id="qa_reviewer" name="qa_reviewer" required class="form-control">
                                            <option value="">Select a value</option>
                                            @foreach ($users as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('qa_reviewer')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Due Date"> Due Date </label>
                                        <div><small class="text-primary">If revising Due Date, kindly mention revision
                                                reason in "Due Date Extension Justification" data field.</small></div>
                                        <div class="calenderauditee">
                                            <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY"
                                                value="{{ Helpers::getDueDatemonthly(null, false, 'd-M-Y') }}" />
                                            <input type="date" name="due_date"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'due_date')"
                                                value="{{ Helpers::getDueDatemonthly(null, false, 'Y-m-d') ?? '' }}" />
                                        </div>

                                        {{-- <input type="hidden" value="{{ $due_date }}" name="due_date">
                                        <input disabled type="text" value="{{ Helpers::getdateFormat($due_date) }}"> --}}
                                        {{-- <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                            value="" name="due_date"> --}}
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator Group">Initiated Through</label>
                                        <div><small class="text-primary">Please select related information</small></div>
                                        <select name="initiated_through"
                                            onchange="otherController(this.value, 'others', 'initiated_through_req')">
                                            <option value="">-- select --</option>
                                            <option value="recall">Recall</option>
                                            <option value="return">Return</option>
                                            <option value="deviation">Deviation</option>
                                            <option value="complaint">Complaint</option>
                                            <option value="regulatory">Regulatory</option>
                                            <option value="lab-incident">Lab Incident</option>
                                            <option value="improvement">Improvement</option>
                                            <option value="others">Others</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input" id="initiated_through_req">
                                        <label for="If Other">Others<span class="text-danger d-none">*</span></label>
                                        <div class="relative-container">
                                        <textarea name="initiated_if_other"></textarea>
                                        @component('frontend.forms.language-model')
                                        @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Type">Type</label>
                                        <select name="Type" id="Type">
                                            <option value="">-- Select --</option>
                                            <option value="Process">Process</option>
                                            <option value="Document">Document</option>
                                            <option value="Equipment">Equipment</option>
                                            <option value="Instrument">Instrument</option>

                                            <option value="Facilities">Facilities</option>
                                            <option value="Other">Other</option>
                                            <option value="Stability">Stability</option>
                                            <option value="Raw Material">Raw Material</option>
                                            <option value="Clinical Production">Clinical Production</option>
                                            <option value="Commercial Production">Commercial Production</option>
                                            <option value="Labeling">Labeling</option>
                                            <option value="Laboratory">Laboratory</option>
                                            <option value="Utilities">Utilities</option>
                                            <option value="Validation">Validation</option>
                                        </select>
                                    </div>
                                </div>
                                {{--  <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="priority_level">Priority Level</label>
                                        <div><small class="text-primary">Choose high if Immidiate actions are
                                                </small></div>
                                        <select name="priority_level">
                                            <option value="0">-- Select --</option>
                                            <option value="low">Low</option>
                                            <option value="medium">Medium</option>
                                            <option value="high">High</option>
                                        </select>
                                    </div>
                                </div>  --}}
                                {{-- <div class="col-lg-6"> --}}
                                {{-- <div class="group-input">
                                        <label for="investigators">Additional Investigators</label>
                                        <select  name="investigators" placeholder="Select Investigators"
                                            data-search="false" data-silent-initial-value-set="true" id="investigators">
                                            <option value="">Select Investigators</option>
                                            <option value="1">Amit Guru</option>
                                            <option value="2">Shaleen Mishra</option>
                                            <option value="3">Madhulika Mishra</option>
                                            <option value="4">Amit Patel</option>
                                            <option value="5">Harsh Mishra</option>
                                        </select>
                                    </div> --}}
                                {{-- </div> --}}
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="department">Responsible Department </label>
                                        <select multiple name="departments[]" placeholder="Select Department(s)"
                                            data-search="false" data-silent-initial-value-set="true" id="department">
                                            <option value="Work Instruction">Work Instruction</option>
                                            <option value="Quality Assurance">Quality Assurance</option>
                                            <option value="Specifications">Specifications</option>
                                            <option value="Production">Production</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="sub-head">Investigation details</div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="description">Description</label>
                                        <div class="relative-container">
                                        <textarea name="description" class="tiny"></textarea>
                                        @component('frontend.forms.language-model')
                                        @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="comments">Comments</label>
                                        <div class="relative-container">
                                        <textarea name="comments" class="tiny"></textarea>
                                        @component('frontend.forms.language-model')
                                        @endcomponent
                                    </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Inv Attachments">Initial Attachment</label>
                                        <div>
                                            <small class="text-primary">
                                                Please Attach all relevant or supporting documents
                                            </small>
                                        </div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="root_cause_initial_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile"
                                                    name="root_cause_initial_attachment[]"
                                                    oninput="addMultipleFiles(this, 'root_cause_initial_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="severity-level">Sevrity Level</label>
                                        <select name="severity-level">
                                            <option value="0">-- Select --</option>
                                            <option value="minor">Minor</option>
                                            <option value="major">Major</option>
                                            <option value="critical">Critical</option>
                                        </select>
                                    </div>
                                </div> --}}
                                {{--  <div class="col-12">
                                    <div class="group-input">
                                        <label for="related_url">Related URL</label>
                                        <input type="url" name="related_url" />
                                    </div>
                                </div>  --}}
                            </div>
                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                                <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>
                    <div id="CCForm5" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="objective">Objective</label>
                                        <div class="relative-container">
                                        <textarea name="objective" class="tiny"></textarea>
                                        @component('frontend.forms.language-model')
                                        @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="scope">Scope</label>
                                        <div class="relative-container">
                                        <textarea name="scope" class="tiny"></textarea>
                                        @component('frontend.forms.language-model')
                                        @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="problem_statement">Problem Statement</label>
                                        <div class="relative-container">
                                        <textarea name="problem_statement_rca" class="tiny"></textarea>
                                        @component('frontend.forms.language-model')
                                        @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="requirement">Background</label>
                                        <div class="relative-container">
                                        <textarea name="requirement" class="tiny"></textarea>
                                        @component('frontend.forms.language-model')
                                        @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="immediate_action">Immediate Action</label>
                                        <div class="relative-container">
                                        <textarea name="immediate_action" class="tiny"></textarea>
                                        @component('frontend.forms.language-model')
                                        @endcomponent
                                        </div>
                                    </div>
                                </div>
                                {{--<div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="investigation_team">Investigation Team</label>
                                        <select id="investigation_team" name="investigation_team[]" class="form-control"
                                            multiple>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('investigation_team')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>--}}


                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="investigation_team">Investigation Team<span class="text-danger">*</span></label>
                                        <select name="investigation_team[]" id="investigation_team" multiple>
                                            @if ($users->isNotEmpty())
                                                @foreach ($users as $value)
                                                    <option value='{{ $value->name }}'>{{ $value->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('investigation_team')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="root-cause-methodology">Root Cause Methodology</label>
                                        <select name="root_cause_methodology[]" multiple data-search="false"
                                            data-silent-initial-value-set="true" id="root-cause-methodology">
                                            <option value="Why-Why Chart">Why-Why Chart</option>
                                            <option value="Failure Mode and Effect Analysis">Failure Mode and Effect
                                                Analysis</option>
                                            <option value="Fishbone or Ishikawa Diagram">Fishbone or Ishikawa Diagram
                                            </option>
                                            <option value="Is/Is Not Analysis">Is/Is Not Analysis</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="root_cause">
                                            Root Cause
                                            <button type="button"
                                                onclick="add4Input('root-cause-first-table')">+</button>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="root-cause-first-table">
                                                <thead>
                                                    <tr>
                                                        <th style="width:5%">Row #</th>
                                                        <th>Root Cause Category</th>
                                                        <th>Root Cause Sub-Category</th>
                                                        <th>Probability</th>
                                                        <th>Remarks</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <td><input disabled type="text" name="serial_number[]"
                                                            value="1">
                                                    </td>
                                                    <td><input type="text" name="Root_Cause_Category[]"></td>
                                                    <td><input type="text" name="Root_Cause_Sub_Category[]"></td>
                                                    <td><input type="text" name="Probability[]"></td>
                                                    <td><input type="text" name="Remarks[]"></td>
                                                    <td><button type="text" class="removeRowBtn">Remove</button></td>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                {{--  <div class="col-12 sub-head"></div>  --}}
                                <div class="col-12 mb-4" id="fmea-section" style="display:none;">
                                    <div class="group-input">
                                        <label for="agenda">
                                            Failure Mode and Effect Analysis
                                            <button type="button" name="agenda"
                                                onclick="addRootCauseAnalysisRiskAssessment('risk-assessment-risk-management')">+</button>
                                            <span class="text-primary" style="font-size: 0.8rem; font-weight: 400;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" style="width: 200%"
                                                id="risk-assessment-risk-management">
                                                <thead>
                                                    <tr>
                                                        <th>Row #</th>
                                                        <th>Risk Factor</th>
                                                        <th>Risk element </th>
                                                        <th>Probable cause of risk element</th>
                                                        <th>Existing Risk Controls</th>
                                                        <th>Initial Severity- H(3)/M(2)/L(1)</th>
                                                        <th>Initial Probability- H(3)/M(2)/L(1)</th>
                                                        <th>Initial Detectability- H(1)/M(2)/L(3)</th>
                                                        <th>Initial RPN</th>
                                                        <th>Risk Acceptance (Y/N)</th>
                                                        <th>Proposed Additional Risk control measure (Mandatory for Risk
                                                            elements having RPN>4)</th>
                                                        <th>Residual Severity- H(3)/M(2)/L(1)</th>
                                                        <th>Residual Probability- H(3)/M(2)/L(1)</th>
                                                        <th>Residual Detectability- H(1)/M(2)/L(3)</th>
                                                        <th>Residual RPN</th>
                                                        <th>Risk Acceptance (Y/N)</th>
                                                        <th>Mitigation proposal (Mention either CAPA reference number, IQ,
                                                            OQ or
                                                            PQ)
                                                        </th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                {{--  <div class="col-12 sub-head"></div>  --}}
                                <div class="col-12" id="fishbone-section" style="display:none;">
                                    <div class="group-input">
                                        <label for="fishbone">
                                            Fishbone or Ishikawa Diagram
                                            <button type="button" name="agenda"
                                                onclick="addFishBone('.top-field-group', '.bottom-field-group')">+</button>
                                            <button type="button" name="agenda" class="fishbone-del-btn"
                                                onclick="deleteFishBone('.top-field-group', '.bottom-field-group')">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#fishbone-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <div class="fishbone-ishikawa-diagram">
                                            <div class="left-group">
                                                <div class="grid-field field-name">
                                                    <div>Measurement</div>
                                                    <div>Materials</div>
                                                    <div>Methods</div>
                                                </div>
                                                <div class="top-field-group">
                                                    <div class="grid-field fields top-field">
                                                        <div><input type="text" name="measurement[]"></div>
                                                        <div><input type="text" name="materials[]"></div>
                                                        <div><input type="text" name="methods[]"></div>
                                                    </div>
                                                </div>
                                                <div class="mid"></div>
                                                <div class="bottom-field-group">
                                                    <div class="grid-field fields bottom-field">
                                                        <div><input type="text" name="environment[]"></div>
                                                        <div><input type="text" name="manpower[]"></div>
                                                        <div><input type="text" name="machine[]"></div>
                                                    </div>
                                                </div>
                                                <div class="grid-field field-name">
                                                    <div>Environment</div>
                                                    <div>Manpower</div>
                                                    <div>Machine</div>
                                                </div>
                                            </div>
                                            <div class="right-group">
                                                <div class="field-name">
                                                    Problem Statement
                                                </div>
                                                <div class="field">
                                                    <textarea name="problem_statement"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--  <div class="col-12 sub-head"></div>  --}}
                                <div class="col-12" id="why-why-chart-section" style="display:none;">
                                    <div class="group-input">
                                        <label for="why-why-chart">
                                            Why-Why Chart
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#why_chart-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <div class="why-why-chart">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <!-- Problem Statement -->
                                                    <tr style="background: #f4bb22">
                                                        <th style="width:150px;">Problem Statement :</th>
                                                        <td>
                                                            <textarea name="why_problem_statement"></textarea>
                                                        </td>
                                                    </tr>

                                                    <!-- Why 1 -->
                                                    <tr class="why-row">
                                                        <th style="width:150px; color: #393cd4;">
                                                            Why 1
                                                            <span onclick="addWhyField('why_1_block', 'why_1[]')">+</span>
                                                        </th>
                                                        <td>
                                                            <div class="why_1_block">
                                                                <div class="why-field-wrapper">
                                                                    <textarea name="why_1[]"></textarea>
                                                                    <button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="removeWhyField(this)">Remove</button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- Why 2 -->
                                                    <tr class="why-row">
                                                        <th style="width:150px; color: #393cd4;">
                                                            Why 2
                                                            <span onclick="addWhyField('why_2_block', 'why_2[]')">+</span>
                                                        </th>
                                                        <td>
                                                            <div class="why_2_block">
                                                                <div class="why-field-wrapper">
                                                                    <textarea name="why_2[]"></textarea>
                                                                    <button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="removeWhyField(this)">Remove</button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- Why 3 -->
                                                    <tr class="why-row">
                                                        <th style="width:150px; color: #393cd4;">
                                                            Why 3
                                                            <span onclick="addWhyField('why_3_block', 'why_3[]')">+</span>
                                                        </th>
                                                        <td>
                                                            <div class="why_3_block">
                                                                <div class="why-field-wrapper">
                                                                    <textarea name="why_3[]"></textarea>
                                                                    <button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="removeWhyField(this)">Remove</button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- Why 4 -->
                                                    <tr class="why-row">
                                                        <th style="width:150px; color: #393cd4;">
                                                            Why 4
                                                            <span onclick="addWhyField('why_4_block', 'why_4[]')">+</span>
                                                        </th>
                                                        <td>
                                                            <div class="why_4_block">
                                                                <div class="why-field-wrapper">
                                                                    <textarea name="why_4[]"></textarea>
                                                                    <button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="removeWhyField(this)">Remove</button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- Why 5 -->
                                                    <tr class="why-row">
                                                        <th style="width:150px; color: #393cd4;">
                                                            Why 5
                                                            <span onclick="addWhyField('why_5_block', 'why_5[]')">+</span>
                                                        </th>
                                                        <td>
                                                            <div class="why_5_block">
                                                                <div class="why-field-wrapper">
                                                                    <textarea name="why_5[]"></textarea>
                                                                    <button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="removeWhyField(this)">Remove</button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- Root Cause -->
                                                    <tr style="background: #0080006b;">
                                                        <th style="width:150px;">Root Cause :</th>
                                                        <td>
                                                            <textarea name="why_root_cause"></textarea>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- JavaScript to handle dynamic field addition and removal -->
                                <script>
                                    function addWhyField(containerClass, fieldName) {
                                        // Select the container to add the new textarea
                                        let container = document.querySelector('.' + containerClass);

                                        // Create the textarea
                                        let textarea = document.createElement('textarea');
                                        textarea.name = fieldName;

                                        // Create the remove button
                                        let removeButton = document.createElement('button');
                                        removeButton.type = 'button';
                                        removeButton.className = 'btn btn-danger btn-sm';
                                        removeButton.innerText = 'Remove';
                                        removeButton.onclick = function() {
                                            removeWhyField(this);
                                        };

                                        // Create a wrapper for the textarea and the remove button
                                        let fieldWrapper = document.createElement('div');
                                        fieldWrapper.classList.add('why-field-wrapper');
                                        fieldWrapper.style.marginBottom = '10px'; // Optional for better spacing
                                        fieldWrapper.appendChild(textarea);
                                        fieldWrapper.appendChild(removeButton);

                                        // Append the new field wrapper to the container
                                        container.appendChild(fieldWrapper);
                                    }

                                    function removeWhyField(button) {
                                        // Get the wrapper div and remove it
                                        let fieldWrapper = button.parentNode;
                                        fieldWrapper.remove();
                                    }
                                </script>





                                {{--  <div class="col-12 sub-head"></div>  --}}
                                <div class="col-12" id="is-is-not-section" style="display:none;">
                                    <div class="group-input">
                                        <label for="why-why-chart">
                                            Is/Is Not Analysis
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#is_is_not-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <div class="why-why-chart">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>&nbsp;</th>
                                                        <th>Will Be</th>
                                                        <th>Will Not Be</th>
                                                        <th>Rationale</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th style="background: #0039bd85">What</th>
                                                        <td>
                                                            <textarea name="what_will_be"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="what_will_not_be"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="what_rationable"></textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="background: #0039bd85">Where</th>
                                                        <td>
                                                            <textarea name="where_will_be"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="where_will_not_be"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="where_rationable"></textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="background: #0039bd85">When</th>
                                                        <td>
                                                            <textarea name="when_will_be"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="when_will_not_be"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="when_rationable"></textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="background: #0039bd85">Coverage</th>
                                                        <td>
                                                            <textarea name="coverage_will_be"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="coverage_will_not_be"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="coverage_rationable"></textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="background: #0039bd85">Who</th>
                                                        <td>
                                                            <textarea name="who_will_be"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="who_will_not_be"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="who_rationable"></textarea>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                                <div class="button-block">
                                    <button type="submit" class="saveButton">Save</button>
                                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                    <button type="button">
                                        <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit</a>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div id="CCForm4" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            {{-- <div class="sub-head">
                                CFT Feedback
                            </div> --}}
                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="comments">QA Review Comments</label>
                                        <div class="relative-container">
                                        <textarea name="cft_comments_new" class="tiny"></textarea>
                                        @component('frontend.forms.language-model')
                                                @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Inv Attachments">QA Review Attachment</label>
                                        <div>
                                            <small class="text-primary">
                                                Please Attach all relevant or supporting documents
                                            </small>
                                        </div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="cft_attchament_new"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="cft_attchament_new[]"
                                                    oninput="addMultipleFiles(this, 'cft_attchament_new')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="comments">Final Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="cft_attchament_new"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="cft_attchament_new[]"
                                                    oninput="addMultipleFiles(this, 'cft_attchament_new')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                                {{-- <div class="row">
                                <div class="sub-head">
                                    Concerned Group Feedback
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="comments">QA Comments</label>
                                        <textarea name="qa_comments_new"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="comments">QA Head Designee Comments</label>
                                        <textarea name="designee_comments_new"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="comments">Warehouse Comments</label>
                                        <textarea name="Warehouse_comments_new"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="comments">Engineering Comments</label>
                                        <textarea name="Engineering_comments_new"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="comments">Instrumentation Comments</label>
                                        <textarea name="Instrumentation_comments_new"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="comments">Validation Comments</label>
                                        <textarea name="Validation_comments_new"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="comments">Others Comments</label>
                                        <textarea name="Others_comments_new"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="comments">Group Comments</label>
                                        <textarea name="Group_comments_new"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="group-attachments">Group Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="group_attachments_new"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="group_attachments_new[]"
                                                    oninput="addMultipleFiles(this, 'group_attachments_new')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                                <div class="button-block">
                                    <button type="submit" class="saveButton">Save</button>
                                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                    <button type="button"> <a class="text-white"
                                            href="{{ url('rcms/qms-dashboard') }}">
                                            Exit </a> </button>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="CCForm2" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                {{-- <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="investigation_tool">Investigation Tool</label>
                                        <textarea name="investigation_tool"></textarea>
                                    </div>
                                </div> --}}
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="impact_risk_assessment">Impact / Risk Assessment</label>
                                        <div class="relative-container">
                                        <textarea name="impact_risk_assessment" class="tiny"></textarea>
                                        @component('frontend.forms.language-model')
                                        @endcomponent
                                    </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="capa">CAPA</label>
                                        <div class="relative-container">
                                        <textarea name="capa" class="tiny"></textarea>
                                        @component('frontend.forms.language-model')
                                                @endcomponent
                                    </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="root_cause">Root Cause</label>
                                        <div class="relative-container">
                                        <textarea name="root_cause" class="tiny"></textarea>
                                        @component('frontend.forms.language-model')
                                        @endcomponent
                                    </div>
                                </div>
                                </div>





                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="root_cause_description">Root Cause Description</label>
                                        <div class="relative-container">
                                        <textarea name="root_cause_description_rca" class="tiny"></textarea>
                                        @component('frontend.forms.language-model')
                                        @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="investigation_summary">Investigation Summary</label>
                                        <div class="relative-container">
                                        <textarea name="investigation_summary_rca" class="tiny"></textarea>
                                        @component('frontend.forms.language-model')
                                        @endcomponent
                                        </div>
                                    </div>
                                </div>

                                {{--  <div class="col-lg-12">
                                                <div class="group-input">
                                                    <label for="investigation_summary">Investigation Summary</label>
                                                    <textarea name="investigation_summary"></textarea>
                                                </div>
                                            </div>
                                        </div>  --}}

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Inv Attachments">Investigation Attachment
                                            <div>
                                                <small class="text-primary">
                                                    Please Attach all relevant or supporting documents
                                                </small>
                                            </div>
                                            <div class="file-attachment-field">
                                                <div class="file-attachment-list" id="root_cause_initial_attachment_rca">
                                                </div>
                                                <div class="add-btn">
                                                    <div>Add</div>
                                                    <input type="file" id="myfile"
                                                        name="root_cause_initial_attachment_rca[]"
                                                        oninput="addMultipleFiles(this, 'root_cause_initial_attachment_rca')"
                                                        multiple>
                                                </div>
                                            </div>
                                    </div>
                                </div>







                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>
                    <div id="CCForm10" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            {{-- <div class="sub-head">
                                CFT Feedback
                            </div> --}}
                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="comments"> HOD Final Review Comments</label>
                                        <div class="relative-container">
                                        <textarea name="hod_final_comments" class="tiny"></textarea>
                                        @component('frontend.forms.language-model')
                                        @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Inv Attachments">HOD Final Review Attachment</label>
                                        <div>
                                            <small class="text-primary">
                                                Please Attach all relevant or supporting documents
                                            </small>
                                        </div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="hod_final_attachments"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="hod_final_attachments[]"
                                                    oninput="addMultipleFiles(this, 'hod_final_attachments')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="button-block">
                                    <button type="submit" class="saveButton">Save</button>
                                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                    <button type="button"> <a class="text-white"
                                            href="{{ url('rcms/qms-dashboard') }}">
                                            Exit </a> </button>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="CCForm11" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            {{-- <div class="sub-head">
                                CFT Feedback
                            </div> --}}
                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="comments"> QA Final Review Comments</label>
                                        <div class="relative-container">
                                        <textarea name="qa_final_comments" class="tiny"></textarea>
                                        @component('frontend.forms.language-model')
                                                @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Inv Attachments">QA Final Review Attachment</label>
                                        <div>
                                            <small class="text-primary">
                                                Please Attach all relevant or supporting documents
                                            </small>
                                        </div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="qa_final_attachments"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="qa_final_attachments[]"
                                                    oninput="addMultipleFiles(this, 'qa_final_attachments')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="button-block">
                                    <button type="submit" class="saveButton">Save</button>
                                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                    <button type="button"> <a class="text-white"
                                            href="{{ url('rcms/qms-dashboard') }}">
                                            Exit </a> </button>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="CCForm12" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            {{-- <div class="sub-head">
                                CFT Feedback
                            </div> --}}
                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="comments"> QAH/CQAH Final Review Comments</label>
                                        <div class="relative-container">
                                        <textarea name="qah_final_comments" class="tiny"></textarea>
                                        @component('frontend.forms.language-model')
                                                @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Inv Attachments">QAH/CQAH Final Review Attachment</label>
                                        <div>
                                            <small class="text-primary">
                                                Please Attach all relevant or supporting documents
                                            </small>
                                        </div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="qah_final_attachments"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="qah_final_attachments[]"
                                                    oninput="addMultipleFiles(this, 'qah_final_attachments')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="button-block">
                                    <button type="submit" class="saveButton">Save</button>
                                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                    <button type="button"> <a class="text-white"
                                            href="{{ url('rcms/qms-dashboard') }}">
                                            Exit </a> </button>

                                </div>
                            </div>
                        </div>
                    </div>







                    <div id="CCForm3" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="acknowledge_by">Acknowledge By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="acknowledge_on">Acknowledge On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="ack_comments">Acknowledge Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Audit Mgr.more Info Reqd By">More Info Req.wff
                                            By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="More_Info_ack_on">More Info Req.
                                            On</label>
                                        <div class="static"></div>
                                    </div>
                                </div> --}}


                                {{-- <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="More_Info_ack_comment">Comments</label>
                                        <div class="static"></div>
                                    </div>
                                </div> --}}

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="HOD_Review_Complete_By">HOD Review Complete By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="HOD_Review_Complete_On">HOD Review Complete On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Comments">HOD Review Complete Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="More_Info_hrc_by">More Info Req.
                                            By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="More_Info_hrc_on">More Info Req.
                                            On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>


                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="More_Info_hrc_comment">Comments</label>
                                        <div class="static"></div>
                                    </div>
                                </div> --}}
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="QQQA_Review_Complete_By">QA/CQA Review Complete By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="QQQA_Review_Complete_On">QA/CQA Review Complete On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Comments">QA/CQA Review Complete Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="More_Info_qac_by">More Info Req.
                                            By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="More_Info_qac_on">More Info Req.
                                            On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>


                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="More_Info_qac_comment">Comments</label>
                                        <div class="static"></div>
                                    </div>
                                </div> --}}
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="submitted_by">Submit By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="submitted_on">Submit On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Comments">Submit Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="More_Info_sub_by">More Info Req.
                                            By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="More_Info_sub_on">More Info Req.
                                            On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>


                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="More_Info_sub_comment">Comments</label>
                                        <div class="static"></div>
                                    </div>
                                </div> --}}

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="HOD_Final_Review_Complete_By">HOD Final Review Complete By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="HOD_Final_Review_Complete_On">HOD Final Review Complete On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Comments">HOD Final Review Complete Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="More_Info_hfr_by">More Info Req.
                                            By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="More_Info_hfr_on">More Info Req.
                                            On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>


                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="More_Info_hfr_comment">Comments</label>
                                        <div class="static"></div>
                                    </div>
                                </div> --}}
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Final_QA_Review_Complete_By">Final QA/CQA Review Complete By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Final_QA_Review_Complete_On">Final QA/CQA Review Complete On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Comments">Final QA/CQA Review Complete Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>

                                {{-- <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="qA_review_complete_by">More Info Req.
                                            By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="qA_review_complete_on">More Info Req.
                                            On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>


                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="qA_review_complete_comment">Comments</label>
                                        <div class="static"></div>
                                    </div>
                                </div> --}}
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="evaluation_complete_by">QAH/CQAH Closure By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="evaluation_complete_on">QAH/CQAH Closure On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="evalution_Closure_comment">QAH/CQAH Closure Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Cancelled By">Cancel By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Cancelled On">Cancel On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Comments">Cancel Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                {{-- <button type="submit" class="saveButton">Save</button> --}}
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                {{-- <button type="submit">Submit</button> --}}
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <style>
        #step-form>div {
            display: none
        }

        #step-form>div:nth-child(1) {
            display: block;
        }
    </style>

    <script>
        VirtualSelect.init({
            ele: '#investigators, #department, #root-cause-methodology,#investigation_team'
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

        function add4Input(tableId) {
            var table = document.getElementById(tableId);
            var currentRowCount = table.rows.length;
            var newRow = table.insertRow(currentRowCount);
            newRow.setAttribute("id", "row" + currentRowCount);
            var cell1 = newRow.insertCell(0);
            cell1.innerHTML = currentRowCount;

            var cell2 = newRow.insertCell(1);
            cell2.innerHTML = "<input type='text' name='Root_Cause_Category[]'>";

            var cell3 = newRow.insertCell(2);
            cell3.innerHTML = "<input type='text' name='Root_Cause_Sub_Category[]'>";

            var cell4 = newRow.insertCell(3);
            cell4.innerHTML = "<input type='text' name='Probability[]'>";

            var cell5 = newRow.insertCell(4);
            cell5.innerHTML = "<input type='text' name='Remarks[]'>";

            let cell6 = newRow.insertCell(5);
            cell6.innerHTML = "<button type='text' class='removeRowBtn' name='Action[]' readonly>Remove</button>";

            for (var i = 1; i < currentRowCount; i++) {
                var row = table.rows[i];
                row.cells[0].innerHTML = i;
            }
        }

        function addRootCauseAnalysisRiskAssessment(tableId) {
            var table = document.getElementById(tableId);
            var currentRowCount = table.rows.length;
            var newRow = table.insertRow(currentRowCount);
            newRow.setAttribute("id", "row" + currentRowCount);
            var cell1 = newRow.insertCell(0);
            cell1.innerHTML = currentRowCount;

            var cell2 = newRow.insertCell(1);
            cell2.innerHTML = "<input name='risk_factor[]' type='text'>";

            var cell3 = newRow.insertCell(2);
            cell3.innerHTML = "<input name='risk_element[]' type='text'>";

            var cell4 = newRow.insertCell(3);
            cell4.innerHTML = "<input name='problem_cause[]' type='text'>";

            var cell5 = newRow.insertCell(4);
            cell5.innerHTML = "<input name='existing_risk_control[]' type='text'>";

            var cell6 = newRow.insertCell(5);
            cell6.innerHTML =
                "<select onchange='calculateInitialResult(this)' class='fieldR' name='initial_severity[]'><option value=''>-- Select --</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>";

            var cell7 = newRow.insertCell(6);
            cell7.innerHTML =
                "<select onchange='calculateInitialResult(this)' class='fieldP' name='initial_probability[]'><option value=''>-- Select --</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>";

            var cell8 = newRow.insertCell(7);
            cell8.innerHTML =
                "<select onchange='calculateInitialResult(this)' class='fieldN' name='initial_detectability[]'><option value=''>-- Select --</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>";

            var cell9 = newRow.insertCell(8);
            cell9.innerHTML = "<input name='initial_rpn[]' type='text' class='initial-rpn' readonly>";
            
            var cell10 = newRow.insertCell(9);
            cell10.innerHTML =
                "<select name='risk_acceptance[]'><option value=''>-- Select --</option><option value='N'>N</option><option value='Y'>Y</option></select>";

            var cell11 = newRow.insertCell(10);
            cell11.innerHTML = "<input name='risk_control_measure[]' type='text'>";

            var cell12 = newRow.insertCell(11);
            cell12.innerHTML =
                "<select onchange='calculateResidualResult(this)' class='residual-fieldR' name='residual_severity[]'><option value=''>-- Select --</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>";

            var cell13 = newRow.insertCell(12);
            cell13.innerHTML =
                "<select onchange='calculateResidualResult(this)' class='residual-fieldP' name='residual_probability[]'><option value=''>-- Select --</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>";

            var cell14 = newRow.insertCell(13);
            cell14.innerHTML =
                "<select onchange='calculateResidualResult(this)' class='residual-fieldN' name='residual_detectability[]'><option value=''>-- Select --</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>";

            var cell15 = newRow.insertCell(14);
            cell15.innerHTML = "<input name='residual_rpn[]' type='text' class='residual-rpn' >";

            var cell16 = newRow.insertCell(15);
            cell16.innerHTML =
                "<select name='risk_acceptance2[]'><option value=''>-- Select --</option><option value='N'>N</option><option value='Y'>Y</option></select>";

            var cell17 = newRow.insertCell(16);
            cell17.innerHTML = "<input name='mitigation_proposal[]' type='text'>";

            var cell18 = newRow.insertCell(17);
            cell18.innerHTML = "<button type='text' class='removeRowBtn' name='Action[]' readonly>Remove</button>";

            for (var i = 1; i < currentRowCount; i++) {
                var row = table.rows[i];
                row.cells[0].innerHTML = i;
            }
        }
    </script>

    <script>
        function addFishBone(top, bottom) {
            let mainBlock = document.querySelector('.fishbone-ishikawa-diagram');
            let topBlock = mainBlock.querySelector(top)
            let bottomBlock = mainBlock.querySelector(bottom)

            let topField = document.createElement('div')
            topField.className = 'grid-field fields top-field'

            let measurement = document.createElement('div')
            let measurementInput = document.createElement('input')
            measurementInput.setAttribute('type', 'text')
            measurementInput.setAttribute('name', 'measurement[]')
            measurement.append(measurementInput)
            topField.append(measurement)

            let materials = document.createElement('div')
            let materialsInput = document.createElement('input')
            materialsInput.setAttribute('type', 'text')
            materialsInput.setAttribute('name', 'materials[]')
            materials.append(materialsInput)
            topField.append(materials)

            let methods = document.createElement('div')
            let methodsInput = document.createElement('input')
            methodsInput.setAttribute('type', 'text')
            methodsInput.setAttribute('name', 'methods[]')
            methods.append(methodsInput)
            topField.append(methods)

            topBlock.prepend(topField)

            let bottomField = document.createElement('div')
            bottomField.className = 'grid-field fields bottom-field'

            let environment = document.createElement('div')
            let environmentInput = document.createElement('input')
            environmentInput.setAttribute('type', 'text')
            environmentInput.setAttribute('name', 'environment[]')
            environment.append(environmentInput)
            bottomField.append(environment)

            let manpower = document.createElement('div')
            let manpowerInput = document.createElement('input')
            manpowerInput.setAttribute('type', 'text')
            manpowerInput.setAttribute('name', 'manpower[]')
            manpower.append(manpowerInput)
            bottomField.append(manpower)

            let machine = document.createElement('div')
            let machineInput = document.createElement('input')
            machineInput.setAttribute('type', 'text')
            machineInput.setAttribute('name', 'machine[]')
            machine.append(machineInput)
            bottomField.append(machine)

            bottomBlock.append(bottomField)
        }

        function deleteFishBone(top, bottom) {
            let mainBlock = document.querySelector('.fishbone-ishikawa-diagram');
            let topBlock = mainBlock.querySelector(top)
            let bottomBlock = mainBlock.querySelector(bottom)
            if (topBlock.firstChild) {
                topBlock.removeChild(topBlock.firstChild);
            }
            if (bottomBlock.lastChild) {
                bottomBlock.removeChild(bottomBlock.lastChild);
            }
        }
    </script>

    <script>
        function addWhyField(con_class, name) {
            let mainBlock = document.querySelector('.why-why-chart')
            let container = mainBlock.querySelector(`.${con_class}`)
            let textarea = document.createElement('textarea')
            textarea.setAttribute('name', name);
            container.append(textarea)
        }
    </script>

    <script>
        function calculateInitialResult(selectElement) {
            let row = selectElement.closest('tr');
            let R = parseFloat(row.querySelector('.fieldR').value) || 0;
            let P = parseFloat(row.querySelector('.fieldP').value) || 0;
            let N = parseFloat(row.querySelector('.fieldN').value) || 0;
            let result = R * P * N;
            row.querySelector('.initial-rpn').value = result;
        }
    </script>

    <script>
        function calculateResidualResult(selectElement) {
            let row = selectElement.closest('tr');
            let R = parseFloat(row.querySelector('.residual-fieldR').value) || 0;
            let P = parseFloat(row.querySelector('.residual-fieldP').value) || 0;
            let N = parseFloat(row.querySelector('.residual-fieldN').value) || 0;
            let result = R * P * N;
            row.querySelector('.residual-rpn').value = result;
        }
    </script>
    <script>
        document.getElementById('initiator_group').addEventListener('change', function() {
            var selectedValue = this.value;
            document.getElementById('initiator_group_code').value = selectedValue;
        });

        function setCurrentDate(item) {
            if (item == 'yes') {
                $('#effect_check_date').val('{{ date('d-M-Y') }}');
            } else {
                $('#effect_check_date').val('');
            }
        }
    </script>
    <script>
        document.getElementById('initiator_group').addEventListener('change', function() {
            var selectedValue = this.value;
            document.getElementById('initiator_group_code').value = selectedValue;
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const removeButtons = document.querySelectorAll('.remove-file');

            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const fileName = this.getAttribute('data-file-name');
                    const fileContainer = this.closest('.file-container');

                    // Hide the file container
                    if (fileContainer) {
                        fileContainer.style.display = 'none';
                    }
                });
            });
        });
    </script>

    <script>
        $(document).on('click', '.removeRowBtn', function() {
            $(this).closest('tr').remove();
        })
    </script>
    <script>
        var maxLength = 255;
        $('#docname').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            $('#rchars').text(textlen);
        });
    </script>



    <script>
        $(document).ready(function() {
            $('#root-cause-methodology').on('change', function() {
                var selectedValues = $(this).val();
                $('#why-why-chart-section').hide();
                $('#fmea-section').hide();
                $('#fishbone-section').hide();
                $('#is-is-not-section').hide();

                if (selectedValues.includes('Why-Why Chart')) {
                    $('#why-why-chart-section').show();
                }
                if (selectedValues.includes('Failure Mode and Effect Analysis')) {
                    $('#fmea-section').show();
                }
                if (selectedValues.includes('Fishbone or Ishikawa Diagram')) {
                    $('#fishbone-section').show();
                }
                if (selectedValues.includes('Is/Is Not Analysis')) {
                    $('#is-is-not-section').show();
                }
            });
        });
    </script>
@endsection
