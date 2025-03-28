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
        background: #eba746 !important;
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
        {{-- <div class="pr-id">
            New Child
        </div> --}}
        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            {{ Helpers::getDivisionName(session()->get('division')) }} / Action Item
        </div>
    </div>
    @php
        $users = DB::table('users')->get();
    @endphp


    {{-- ! ========================================= --}}
    {{-- !               DATA FIELDS                 --}}
    {{-- ! ========================================= --}}
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
                {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Parent Information</button> --}}
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Post Completion</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Action Approval</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Activity Log</button>
            </div>
            
           <!-- Language Selector Section -->
            <div class="language-sleect d-flex align-items-center" style="margin-left: 3px;">
                <div>Select Language:</div>
             <div class="main-head" id="google_translate_element"></div>
            </div>
    

        <style>
            .tabs-and-language {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 20px;
                padding: 10px 0;
            }

            .cctab {
                display: flex;
                justify-content: flex-start;
                gap: 15px;
            }

            .cctablinks {
                background-color: #f1f1f1;
                border: none;
                padding: 12px 24px;
                cursor: pointer;
                border-radius: 8px;
                font-size: 16px;
                transition: background-color 0.3s ease, color 0.3s ease;
            }

            .cctablinks:hover {
                background-color: #f5c27f;
                color: white;
            }

            .cctablinks.active {
                background-color: #eba746;
                color: white;
                font-weight: bold;
            }

            .language-sleect {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .language-sleect > div {
                font-size: 16px;
                font-weight: bold;
                color: #333;
            }

            .main-head {
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 5px 10px;
                background-color: #f9f9f9;
            }

            @media (max-width: 768px) {
                .tabs-and-language {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .language-sleect {
                    margin-left: 0;
                    gap: 5px;
                }

                .cctab {
                    margin-bottom: 15px;
                }
            }

        </style>

            <form action="{{ route('actionItem.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div id="step-form">
                    @if (!empty($parent_id))
                        <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                        <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                    @endif
                    <!-- Tab content -->
                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="sub-head">
                                General Information
                            </div> <!-- RECORD NUMBER -->
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input"> 
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input disabled type="text" name="record_number"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}/AI/{{ date('Y') }}/{{ $record}}">
                                        {{-- <div class="static">QMS-EMEA/CAPA/{{ date('Y') }}/{{ $record_number }}</div> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">  
                                    <div class="group-input">
                                        <label for="Division Code"><b>Division Code</b></label>
                                        <input disabled type="text" name="division_code"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                        <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                        {{-- <div class="static">{{ Helpers::getDivisionName(session()->get('division')) }}</div> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">  
                                    @if (!empty($cc->id))
                                        <input type="hidden" name="ccId" value="{{ $cc->id }}">
                                    @endif
                                    <div class="group-input">
                                        <label for="originator">Initiator</label>
                                        <input disabled type="text"
                                            value="{{ Auth::user()->name }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Opened">Date of Initiation</label>
                                        {{-- <div class="static">{{ date('d-M-Y') }}</div> --}}
                                        <input disabled type="text"
                                            value="{{ date('d-M-Y') }}"
                                            name="intiation_date">
                                        <input type="hidden" value="{{ date('d-M-Y') }}" name="intiation_date">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input"> 
                                        <label for="RLS Record Number"><b>Parent Record Number</b></label>
                                        <input readonly type="text" name="parent_record_number"
                                            value="{{ $expectedParenRecord ?? 'Not Applicable' }}">
                                        {{-- <div class="static">QMS-EMEA/CAPA/{{ date('Y') }}/{{ $record_number }}</div> --}}
                                    </div>
                                </div>

                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Due Date">Due Date</label>

                                        @if (!empty($cc->due_date))
                                        <div class="static">{{ $cc->due_date }}</div>
                                        @endif
                                    </div>
                                </div> --}}
                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Assigned To <span class="text-danger"></span>
                                        </label>
                                        <select id="select-state" placeholder="Select..." name="assign_to">
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
                                <div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="due-date">Due Date <span class="text-danger"></span></label>
                                        <div class="calenderauditee">
                                            <!-- Display the formatted date in a readonly input -->
                                            <input type="text" id="due_date_display" readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getDueDate(30, true) }}" />
                                           
                                            <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ Helpers::getDueDate(30, false) }}" class="hide-input" readonly />
                                        </div>
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

                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Due Date">Parent Record</label>
                                        @if (!empty($parent_id))
                                            @if($parent_type == "Risk Assesment")
                                                <input type="text" name="parent_record" value="{{ str_pad($parentRecord, 4, '0', STR_PAD_LEFT) }}" readonly >
                                            @elseif($parent_type == "CAPA")
                                                <input type="text" name="parent_record" value="{{ str_pad($parentRecord, 4, '0', STR_PAD_LEFT) }}" readonly >
                                            @elseif($parent_type == "OOS Chemical")
                                                <input type="text" name="parent_record" value="{{ str_pad($parentRecord, 4, '0', STR_PAD_LEFT) }}" readonly >
                                            @elseif($parent_type == "OOT")
                                                <input type="text" name="parent_record" value="{{ str_pad($parentRecord, 4, '0', STR_PAD_LEFT) }}" readonly >
                                            @elseif($parent_type == "Out of Calibration")
                                                <input type="text" name="parent_record" value="{{ str_pad($parentRecord, 4, '0', STR_PAD_LEFT) }}" readonly >
                                            @elseif($parent_type == "External Audit")
                                                <input type="text" name="parent_record" value="{{ str_pad($parentRecord, 4, '0', STR_PAD_LEFT) }}" readonly >
                                            @elseif($parent_type == "Market Complaint")
                                                <input type="text" name="parent_record" value="{{ str_pad($parentRecord, 4, '0', STR_PAD_LEFT) }}" readonly >
                                            @elseif($parent_type == "Management Review")
                                                <input type="text" name="parent_record" value="{{ str_pad($parentRecord, 4, '0', STR_PAD_LEFT) }}" readonly >
                                            @else
                                                <input type="text" name="parent_record" readonly>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                
                                <script>
                                function handleDateInput(dateInput, displayId) {
                                    const date = new Date(dateInput.value);
                                    const options = { day: '2-digit', month: 'short', year: 'numeric' };
                                    document.getElementById(displayId).value = date.toLocaleDateString('en-GB', options).replace(/ /g, '-');
                                }
                                
                                // Call this function initially to ensure the correct format is shown on page load
                                document.addEventListener('DOMContentLoaded', function() {
                                    const dateInput = document.querySelector('input[name="due_date"]');
                                    handleDateInput(dateInput, 'due_date_display');
                                });
                                </script> --}}
                                
                                <style>
                                .hide-input {
                                    display: none;
                                }
                                </style>
                                
                             
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span id="rchars">255</span>
                                        characters remaining
                                        <input id="docname" type="text" name="short_description" maxlength="255" required>
                                    </div>
                                </div>  
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Related Records">Action Item Related Records</label>
                                        <select multiple id="related_records" name="related_records[]"
                                            placeholder="Select Reference Records">

                                            @foreach ($old_record as $new)
                                                <option
                                                    value="{{ Helpers::getDivisionName($new->division_id) . '/AI/' . date('Y') . '/' . Helpers::recordFormat($new->record) }}">
                                                    {{ Helpers::getDivisionName($new->division_id) . '/AI/' . date('Y') . '/' . Helpers::recordFormat($new->record) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="HOD Persons">HOD Persons</label>
                                        <select   name="hod_preson[]" placeholder="Select HOD Persons" data-search="false"
                                            data-silent-initial-value-set="true" id="hod" >
                                            <option value="">select person</option>
                                            @foreach ($users as $value)
                                                
                                                <option value="{{ $value->name }}">{{ $value->name }}</option>

                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Short Description"> Description<span
                                                class="text-danger"></span></label>
                                        <textarea name="description"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Responsible Department">Responsible Department</label>
                                        <select name="departments">
                                        <option value="" >-- Select --</option>
                                            <option value="CQA" >Corporate Quality Assurance</option>
                                            <option value="QA" >Quality Assurance</option>
                                            <option value="QC" >Quality Control</option>
                                            <option value="QM" >Quality Control (Microbiology department)</option>
                                            <option value="PG" >Production General</option>
                                            <option value="PL" >Production Liquid Orals</option>
                                            <option value="PT" >Production Tablet and Powder</option>
                                            <option value="PE" >Production External (Ointment, Gels, Creams and Liquid)</option>
                                            <option value="PC" >Production Capsules</option>
                                            <option value="PI" >Production Injectable</option>
                                            <option value="EN" >Engineering</option>
                                            <option value="HR" >Human Resource</option>
                                            <option value="ST" >Store</option>
                                            <option value="IT" >Electronic Data Processing</option>
                                            <option value="FD" >Formulation  Development</option>
                                            <option value="AL" >Analytical research and Development Laboratory</option>
                                            <option value="PD">Packaging Development</option>
                                            <option value="PU">Purchase Department</option>
                                            <option value="DC">Document Cell</option>
                                            <option value="RA">Regulatory Affairs</option>
                                            <option value="PV">Pharmacovigilance</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="file_attach">File Attachments</label>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="file_attach"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="file_attach[]"
                                                    oninput="addMultipleFiles(this, 'file_attach')" multiple>
                                            </div>
                                        </div>
                                        {{-- <input type="file" name="file_attach[]" multiple> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                                        Exit </a> </button>

                            </div>
                        </div>
                    </div>

                    {{-- <div id="CCForm2" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Action Taken">RLS Record Number</label>
                                        <div class="static">Parent Record Number</div>
                                        <input disabled type="text"
                                            value="{{ Helpers::getDivisionName($parent_division_id) }}/{{ $parent_name }}/2023/{{ Helpers::recordFormat($parent_record) }}">
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
                    </div> --}}

                    <div id="CCForm3" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head col-12">Post Completion</div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="action_taken">Action Taken</label>
                                        <textarea name="action_taken"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="start_date">Actual Start Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="start_date" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"  id="start_date_checkdate" name="start_date" class="hide-input"
                                                oninput="handleDateInput(this, 'start_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-lg-6  new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="end_date">Actual End Date</label>
                                        <div class="calenderauditee">
                                        <input type="text" id="end_date"                             
                                                placeholder="DD-MMM-YYYY" />
                                             <input type="date"  min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="end_date_checkdate" name="end_date" class="hide-input"
                                                oninput="handleDateInput(this, 'end_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                                        </div>
                                   
                                        
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Comments">Comments</label>
                                        <textarea name="comments"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Support_doc">Completion Attachment</label>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Support_doc"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Support_doc[]"
                                                    oninput="addMultipleFiles(this, 'Support_doc')" multiple>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <div id="CCForm4" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">Action Approval</div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="qa_comments">QA Review Comments</label>
                                        <textarea name="qa_comments"></textarea>
                                    </div>
                                </div>
                                
                                <div class="col-12 sub-head">
                                    Extension Justification
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="due-dateextension">Due Date Extension Justification</label>
                                        <textarea name="due_date_extension"></textarea>
                                    </div>
                                </div>
                                
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="file_attach">Action Approval</label>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="final_attach"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="final_attach[]"
                                                    oninput="addMultipleFiles(this, 'final_attach')" multiple>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <div id="CCForm5" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="sub-head">
                                Electronic Signatures
                            </div>
                            <div class="row">
                                    <div class="col-lg-3">
                                        <div class="group-input">
                                            <label for="submitted by">Submitted By</label>
                                            <div class="static"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="group-input">
                                            <label for="submitted on">Submitted On</label>
                                            <div class="Date"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="submitted on">Submitted Comment</label>
                                            <div class="static"></div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="group-input">
                                            <label for="cancelled by">Cancelled By</label>
                                            <div class="static"></div> 
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="group-input">
                                            <label for="cancelled on">Cancelled On</label>
                                            <div class="Date"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="submitted on">Cancelled Comment</label>
                                            <div class="static"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <div class="group-input">
                                            <label for="cancelled by">Acknowledge By</label>
                                            <div class="static"></div> 
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="group-input">
                                            <label for="cancelled on">Acknowledge On</label>
                                            <div class="Date"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="submitted on">Acknowledge Comment</label>
                                            <div class="static"></div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="group-input">
                                            <label for="cancelled by">Work Completion By</label>
                                            <div class="static"></div> 
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="group-input">
                                            <label for="cancelled on">Work Completion On</label>
                                            <div class="Date"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="submitted on">Work Completion Comment</label>
                                            <div class="static"></div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="group-input">
                                            <label for="cancelled by">QA/CQA Verification By</label>
                                            <div class="static"></div> 
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="group-input">
                                            <label for="cancelled on">QA/CQA Verification On</label>
                                            <div class="Date"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="submitted on">QA/CQA Verification Comment</label>
                                            <div class="static"></div>
                                        </div>
                                    </div>

                                    <!-- <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="More information required By">More information required By</label>
                                            <div class="static"></div> 
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="More information required On">More information required On</label>
                                            <div class="Date"></div> 
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="submitted on">Comment</label>
                                            <div class="static"></div>
                                        </div>
                                    </div> -->
                                    <!-- <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="completed by">Completed By</label>
                                            <div class="static"></div> 
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="completed on">Completed On</label>
                                            <div class="Date"></div> 
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="submitted on">Comment</label>
                                            <div class="static"></div>
                                        </div>
                                    </div> -->
                                   
                                </div>
                            <div class="button-block">
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button"> <a class="text-white"
                                        href="{{ url('rcms/qms-dashboard') }}">Exit
                                    </a> </button>
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
            ele: '#related_records, #hod'
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
    <script>
        var maxLength = 255;
        $('#docname').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            $('#rchars').text(textlen);});
    </script>
@endsection
