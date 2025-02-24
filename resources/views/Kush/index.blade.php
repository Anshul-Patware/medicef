<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-Step Form</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
    body {
        font-family: Arial, sans-serif;
        /* background: linear-gradient(to right, #eca73f, #fad0c4); */
        background: #eca73f;
        color: #333;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 95%;
        margin: 50px auto;
        padding: 20px;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .progress-bar {
        display: flex;
        justify-content: space-between;
        gap: .5%;
        align-items: center;
        margin-bottom: 20px;
        flex-direction: row;
    }

    .progress-bar .step {
        width: 30%;
        text-align: center;
        padding: 10px;
        border-radius: 20px;
        background: #eee;
        color: #555;
    }

    .progress-bar .step.active {
        background: #6a67ce;
        color: #fff;
    }

    .form-step {
        display: none;
    }

    .form-step.active {
        display: block;
    }

    input,
    textarea,
    button {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border-radius: 5px;
        border: 1px solid #ddd;
        font-size: 16px;
    }

    button {
        background: #6a67ce;
        color: #fff;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background: #5a57b7;
    }

    /* Active step */
    .progress-bar .step.active {
        background-color: #000000;
        color: white;
        cursor: pointer;

    }

    /* Hover effect */
    .progress-bar .step:hover {
        background-color: #79a3d0;
        color: white;
        cursor: pointer;
    }

    /* Transition effect */
    .progress-bar .step:not(.active):hover {
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        cursor: pointer;

    }

    .prev-step {
        width: 30%
    }

    .next-step {

        width: 30%
    }

    .save_btn_all {
        width: 30%
    }
</style>

<style>
    .save_btn {
        width: 49%;
    }

    #next_btn {
        width: 49%;
    }
</style>

<body>
    {{-- {{dd($data)}} --}}
    <div class="row">
        <div class="col-lg-2">
            <a href="{{ route('kush') }}" style="text-decoration: none;color:white">Back</a></button>
        </div>
    </div>
    <div class="container">
        <div class="progress-bar">
            <div class="step active">General Information</div>
            <div class="step">HOD review</div>
            <div class="step">QA Initial Review</div>
            <div class="step">CFT</div>
            <div class="step">Initiator Update</div>
            <div class="step">QAH/Designee Approval</div>
            <div class="step">Extension</div>
            <div class="step">Activity Log</div>
        </div>

        <form id="multiStepForm">
            <!-- Step 1 -->
            {{-- <x-form_1  :data="$data" /> --}}
            @foreach ($data as $record)
                <div class="form-step active">
                    <h2 id='head'>General Information</h2>
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="firstName" class="heading_style">First Name</label>
                            <input type="text" id="firstName" name="firstName" value="{{ $record->first_name }}"
                                required>
                        </div>

                        <div class="col-lg-6">
                            <label for="lastName" class="heading_style">Last Name</label>
                            <input type="text" id="lastName" name="lastName" value="{{ $record->last_name }}"
                                required>
                        </div>

                        <div class="col-lg-6">
                            <label for="email">Email</label>
                            <input type="email" id="email" value="{{ $email ?? '' }}" name="email" required
                                readonly style="color: gray">

                        </div>
                        <div class="col-lg-6">
                            <label for="phone">Phone Number</label>
                            <input type="text" id="phone" name="phone" value="{{ $record->phone }}">
                        </div>

                        <div class="col-lg-6">
                            <label for="depart">Department</label>
                            <input type="text" id="depart" name="depart" value="{{ $record->depart }}" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="course">Course</label>
                            <input type="text" id="course" name="course" value="{{ $record->course }}" required>
                        </div>


                        <div class="col-lg-6">
                            <label for="roll">Roll No</label>
                            <input type="text" id="roll" name="rollno" value="{{ $record->rollno }}" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="contact">Contact</label>
                            <input type="text" id="contact" name="contact" value="{{ $record->contact }}" required>
                        </div>

                        <div class="col-lg-6">
                            <label for="branch">Branch</label>
                            <input type="text" id="branch" name="branch" value="{{ $record->branch }}"required>
                        </div>

                        <div class="col-lg-6">
                            <label for="category">Category</label>
                            <input type="text" id="category" name="category" value="{{ $record->category }}"
                                required>
                        </div>


                        <div class="col-lg-6">
                            <label for="address">Address</label>
                            <textarea id="address" name="address" rows="3">{{ $record->address }}</textarea>
                        </div>
                        <div class="col-lg-6">
                            <!-- Attachment -->
                            <label for="profilePic">Upload Profile Picture</label>
                            <input type="file" id="profilePics" name="profilePic" required multiple>
                        </div>
                    </div>
                    <button type="button" class="save_btn" onclick="submitform(1)">Save Step 1</button>
                    <button type="button" id="next_btn" class="next-step">Next</button>
            @endforeach

    </div>



    {{-- second form 2 --}}
    @foreach ($data as $record)
        <div class="form-step">
            <h2>HOD Review</h2>
            @csrf
            <label for="company" class="heading_style">Company Name</label>
            <input type="text" id="company" name="company" value="{{ $record->company_name }}" required>

            <label for="company" class="heading_style">Join Date</label>
            <input type="date" id="join_date" name="join_date" value="{{ $record->join_date }}" required>


            <label for="jobTitle">Job Title</label>
            <input type="text" id="jobTitle" name="jobTitle" value="{{ $record->job_type }}" required>

            <label for="experience">Years of Experience</label>
            <input type="number" id="experience" name="experience" value="{{ $record->experience }}">

            <!-- Additional fields -->
            <label for="skills" class="heading_style">Skills</label>
            <textarea id="skills" name="skills" rows="3">{{ $record->skill }}</textarea>

            <!-- Attachment -->
            <label for="resume">Upload Resume</label>
            <input type="file" id="resume" name="resume" required multiple>

            <div id="btns">
                <button type="button" class="prev-step">Previous</button>
                <button type="button" onclick="submitform(2)" class="save_btn_all">Save step 2</button>
                <button type="button" class="next-step">Next</button>
            </div>

            <div class="col-lg-6" style="display: none">
                <input type="email" id="email" value="{{ $email ?? '' }}" name="email" required readonly>

            </div>
    @endforeach
    </div>

    <style>
        #btns {
            display: flex;
            justify-content: space-around;
        }

        .heading_style {
            font-size: 0.9rem;
            font-weight: bold;
        }

        label {
            font-size: 0.9rem;
            font-weight: bold;
        }
    </style>


    {{-- QA Initial Review form 3 --}}
    <div class="form-step">
        <h2>QA Initial Review</h2>
        <label for="init_dev_cate" class="heading_style">Initial Deviation Category</label>
        <div class="mt-1">
            {{-- <input type="text" id="init_dev_cate" name="init_dev_cate" required> --}}
            <select name="init_dev_cate" class="col-lg-12 mt-1 mb-3 " id="init_dev_cate">
                <option value="">--select--</option>
                <option value="minor">Minor</option>
                <option value="major">Major</option>
                <option value="critical">critical</option>
            </select>


            <div class="row mt-3">
                <div class="col-lg-6">
                    <label for="inves_req" class="heading_style"> Investigation Required ? </label>
                    <div>
                        <select name="inves_req" class="col-lg-12 mt-1 mb-3 " id="inves_req">
                            <option value="">--select--</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-6">

                    <label for="capa_req" class="heading_style">CAPA Required ?</label>
                    <div>
                        {{-- <input type="text" id="capa_req" name="capa_req" required> --}}
                        <select name="capa_req" class="col-lg-12 mt-1 mb-3 " id="capa_req">
                            <option value="">--select--</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Additional fields -->
            <div class="row">
                <div class="col-lg-6">
                    <label for="qrm_req" class="heading_style">QRM Required ?</label>
                    <div>
                        <select name="qrm_req" class="col-lg-12 mt-1 mb-3 " id="qrm_req">
                            <option value="">--select--</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                </div>

            </div>

            <label for="qrm_req" class="mt-3 heading_style">
                Justification for Categorization</label><br>
            <small style="color: blue">Please insert "NA" in the data field if it does not require
                completion</small>
            <textarea id="qrm_req" class="mt-3" name="qrm_req" rows="3"></textarea>

            {{-- QA Initial Remarks --}}
            <label for="qrm_req" class="mt-3 heading_style">
                QA Initial Remarks</label><br>
            <small style="color: blue">Please insert "NA" in the data field if it does not require
                completion</small>
            <textarea id="qrm_req" class="mt-3" name="qrm_req" rows="3"></textarea>

            {{-- Initial Attachment --}}
            <label for="qrm_req" class="mt-3 heading_style">
                QA Initial Attachments</label><br>
            <small style="color: blue">Please insert "NA" in the data field if it does not require
                completion</small>
            <textarea id="qrm_req" class="mt-3" name="qrm_req" rows="3"></textarea>
            <div id="btns">
                <button type="button" class="prev-step">Previous</button>
                <button type="button" class="save_btn_all" onclick="submitform(3)">Save</button>
                <button type="button" class="next-step">Next</button>
            </div>
        </div>
    </div>

    {{-- CFT form 4 --}}
    <div class="form-step">
        <h2>CFT</h2>
        <div class="cft_headings1 mt-3">
            Production
        </div>

        <div class="col-lg-6">
            <label for="prod_revi_requi" class="heading_style mb-2">Production Review Required ?</label>
            <div>
                <select id="prod_revi_requi" class="col-lg-12 mb-4">
                    <option>--Select--</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
        </div>

        <div class="cft_headings1 mt-3">
            Warehouse
        </div>

        <div class="col-lg-6">
            <label for="ware_revi_requi" class="heading_style mb-2">Warehouse Review Required ? ?</label>
            <div>
                <select id="ware_revi_requi" class="col-lg-12 mb-4">
                    <option>--Select--</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
        </div>


        <div class="cft_headings1 mt-3">
            Quality Control
        </div>

        <div class="col-lg-6">
            <label for="quali_contr_per" class="heading_style mb-2">Quality Control Person</label>
            <div>
                <select id="quali_contr_per" class="col-lg-12 mb-4">
                    <option>--Select--</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
        </div>


        <div class="cft_headings1 mt-3">
            Quality Assurance
        </div>

        <div class="col-lg-6">
            <label for="quali_contr_per" class="heading_style mb-2">Quality Assurance</label>
            <div>
                <select id="quali_contr_per" class="col-lg-12 mb-4">
                    <option>--Select--</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
        </div>

        <div class="cft_headings1 mt-3">
            Quality Assurance
        </div>

        <div class="col-lg-6">
            <label for="quali_contr_per" class="heading_style mb-2">Quality Assurance Review Required ?</label>
            <div>
                <select id="quali_contr_per" class="col-lg-12 mb-4">
                    <option>--Select--</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
        </div>

        <div class="cft_headings1 mt-3">
            Engineering
        </div>

        <div class="col-lg-6">
            <label for="quali_contr_per" class="heading_style mb-2">Engineering Review Required ?</label>
            <div>
                <select id="quali_contr_per" class="col-lg-12 mb-4">
                    <option>--Select--</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
        </div>


        <div class="cft_headings1 mt-3">
            Analytical Development Laboratory
        </div>

        <div class="col-lg-6">
            <label for="quali_contr_per" class="heading_style mb-2">Analytical Development Laboratory Review Required
                ?</label>
            <div>
                <select id="quali_contr_per" class="col-lg-12 mb-4">
                    <option>--Select--</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
        </div>

        <div class="cft_headings1 mt-3">
            Process Development Laboratory / Kilo Lab
        </div>

        <div class="col-lg-6">
            <label for="quali_contr_per" class="heading_style mb-2">Process Development Laboratory / Kilo Lab Review
                Required ?</label>
            <div>
                <select id="quali_contr_per" class="col-lg-12 mb-4">
                    <option>--Select--</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
        </div>


        <div id="btns">
            <button type="button" class="prev-step">Previous</button>
            <button type="button" class="save_btn_all">Save</button>
            <button type="button" class="next-step">Next</button>
        </div>
    </div>


    {{-- Initiator update form 5 --}}
    <div class="form-step">
        <h2>Initiator update</h2>

        {{-- qa evaluation --}}
        <label for="qa_eval" class="mt-3 heading_style">
            QA Evaluation</label><br>
        <small style="color: blue">Please insert "NA" in the data field if it does not require
            completion</small>
        <textarea id="qa_eval" class="mt-3" name="qa_eval" rows="3"></textarea>

        {{-- Initiator Additional Attachments --}}
        <label for="ini_add_atta" class="mt-3 heading_style">
            Initiator Additional Attachments</label><br>
        <small style="color: blue">Please Attach all relevant or supporting documents</small>
        <textarea id="ini_add_atta" class="mt-3" name="ini_add_atta" rows="3"></textarea>

        {{-- buttons --}}
        <div id="btns">
            <button type="button" class="prev-step">Previous</button>
            <button type="button" class="save_btn_all">Save</button>
            <button type="button" class="next-step">Next</button>
        </div>

    </div>

    <style>
        #btns {
            display: flex;
            justify-content: space-around;
        }

        .cft_headings {
            color: #eba746;
            border-bottom: 2px solid #eba746;
            padding-bottom: 5px;
            margin-bottom: 3px;
            font-weight: bold;
        }

        .cft_headings1 {
            color: #eba746;
            border-bottom: 2px solid #eba746;
            padding-bottom: 5px;
            margin-bottom: 3px;
            font-weight: bold;
            font-size: 1.2rem;
        }
    </style>

    <style>
        #btns {
            display: flex;
            justify-content: space-around;
        }
    </style>

    {{--  QAH/Designee Approval form 6 --}}
    <div class="form-step">
        <h2>QAH/Designee Approval</h2>
        <label for="post_cate_of_devi" class="heading_style">Post Categorization Of Deviation</label>
        <div class="mt-1">
            <small style="color: blue">Please Refer Intial deviation category before updating.</small>
            <select name="post_cate_of_devi" class="col-lg-12 mt-1 mb-3 " id="post_cate_of_devi">
                <option value="">--select--</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
                <option value="critical">critical</option>
            </select>




            <label for="jus_for_revi_cate" class="mt-3 heading_style">
                Justification for Revised Category</label><br>
            <small style="color: blue">Please insert "NA" in the data field if it does not require completion</small>
            <textarea id="jus_for_revi_cate" class="mt-3" name="jus_for_revi_cate" rows="3"></textarea>

            <label for="clo_comm" class="mt-3 heading_style">
                Closure Comments</label><br>
            <textarea id="clo_comm" class="mt-1" name="clo_comm" rows="3"></textarea>

            <label for="dispo_of_batch" class="mt-3 heading_style">
                Disposition of Batch</label><br>
            <textarea id="dispo_of_batch" class="mt-1" name="dispo_of_batch" rows="3"></textarea>

            <label for="jus_for_revi_cate" class="mt-3 heading_style">
                Closure Attachments </label><br>
            <small style="color: blue">Please Attach all relevant or supporting documents</small>
            <textarea id="jus_for_revi_cate" class="mt-3" name="jus_for_revi_cate" rows="3"></textarea>

            <div id="btns">
                <button type="button" class="prev-step">Previous</button>
                <button type="button" class="save_btn_all">Save</button>
                <button type="button" class="next-step">Next</button>
            </div>
        </div>

        <style>
            #btns {
                display: flex;
                justify-content: space-around;
            }
        </style>




        <style>
            #btns {
                display: flex;
                justify-content: space-around;
            }
        </style>

        </form>

    </div>


    {{-- Extension form 7 --}}
    <div class="form-step">
        <h2>Extension</h2>
        <div class="cft_headings">
            Deviation Extension
        </div>

        <div class="col-lg-6">
            <label for="prod_revi_requi" class="heading_style mb-2">Proposed Due Date (Deviation)</label>
            <div>
                <input type="date" placeholder="DD_MM_YYYY" />
            </div>
        </div>

        <label for="exte_justi" class="mt-3 heading_style">
            Extension Justification (Deviation)</label><br>
        <small style="color: blue">Please insert "NA" in the data field if it does not require completion</small>
        <textarea id="exte_justi" class="mt-3" name="exte_justi" rows="3"></textarea>

        <div class="row mt-3">
            <div class="col-lg-6">
                <label for="dev_ext_com_by" class="heading_style"> Deviation Extension Completed By </label>
                <div>
                    <select name="dev_ext_com_by" class="col-lg-12 mt-1 mb-3 " id="dev_ext_com_by">
                        <option value="">--select--</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
            </div>

            <div class="col-lg-6">

                <label for="dev_ext_com_on" class="heading_style">Deviation Extension Completed On</label>
                <div>
                    <select name="dev_ext_com_on" class="col-lg-12 mt-1 mb-3 " id="dev_ext_com_on">
                        <option value="">--select--</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
            </div>

        </div>

        {{-- capa extension --}}
        <div class="cft_headings mt-5">
            CAPA Extension
        </div>

        <div class="col-lg-6">
            <label for="prod_revi_requi" class="heading_style mb-2">Proposed Due Date (CAPA)</label>
            <div>
                <input type="date" placeholder="DD_MM_YYYY" />
            </div>
        </div>

        <label for="exte_justi" class="mt-3 heading_style">
            Extension Justification (CAPA)</label><br>
        <small style="color: blue">Please insert "NA" in the data field if it does not require completion</small>
        <textarea id="exte_justi" class="mt-3" name="exte_justi" rows="3"></textarea>

        <div class="row mt-3">
            <div class="col-lg-6">
                <label for="dev_ext_com_by" class="heading_style"> CAPA Extension Completed By </label>
                <div>
                    <select name="dev_ext_com_by" class="col-lg-12 mt-1 mb-3 " id="dev_ext_com_by">
                        <option value="">--select--</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
            </div>

            <div class="col-lg-6">

                <label for="dev_ext_com_on" class="heading_style">CAPA Extension Completed On</label>
                <div>
                    <select name="dev_ext_com_on" class="col-lg-12 mt-1 mb-3 " id="dev_ext_com_on">
                        <option value="">--select--</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
            </div>

        </div>


        {{-- Quality Risk Management Extension  --}}
        <div class="cft_headings mt-5">
            Quality Risk Management Extension
        </div>

        <div class="col-lg-6">
            <label for="prod_revi_requi" class="heading_style mb-2">Proposed Due Date (Quality Risk
                Management)</label>
            <div>
                <input type="date" placeholder="DD_MM_YYYY" />
            </div>
        </div>

        <label for="exte_justi" class="mt-3 heading_style">
            Extension Justification (Quality Risk Management)</label><br>
        <small style="color: blue">Please insert "NA" in the data field if it does not require completion</small>
        <textarea id="exte_justi" class="mt-3" name="exte_justi" rows="3"></textarea>

        <div class="row mt-3">
            <div class="col-lg-6">
                <label for="qua_ris_man_exte" class="heading_style"> Quality Risk Management Extension Completed By
                </label>
                <div>
                    <select name="qua_ris_man_exte" class="col-lg-12 mt-1 mb-3 " id="qua_ris_man_exte">
                        <option value="">--select--</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
            </div>

            <div class="col-lg-6">

                <label for="qua_ris_man_exte_comp_on" class="heading_style">Quality Risk Management Extension
                    Completed
                    On</label>
                <div>
                    <select name="qua_ris_man_exte_comp_on" class="col-lg-12 mt-1 mb-3 "
                        id="qua_ris_man_exte_comp_on">
                        <option value="">--select--</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
            </div>
        </div>

        <div id="btns">
            <button type="button" class="prev-step">Previous</button>
            <button type="button" class="save_btn_all">Save</button>
            <button type="button" class="next-step">Next</button>
        </div>
    </div>


    {{-- activity form 8 --}}
    <div class="form-step">
        <h2>Activity Log</h2>

        <div class="cft_headings1">
            Submission
        </div>
        <div class="row mt-3">
            <div class="col-lg-6">
                <label for="submit_by" class="mb-2">Submit By:-</label>
                <div class="static"></div>
            </div>

            <div class="col-lg-6">
                <label for="submit_on" class="mb-2">Submit on:-</label>
                <div class="static"></div>
            </div>

            <div class="col-lg-12 mt-3">
                <label for="submit_comm" class="mb-2">Submit Comments:-</label>
                <div class="static"></div>
            </div>
        </div>


        {{-- hod review completed --}}
        <div class="cft_headings1 mt-3">
            HOD Review Completed
        </div>
        <div class="row mt-3">
            <div class="col-lg-6">
                <label for="submit_by" class="mb-2">HOD Review Complete By:-</label>
                <div class="static"></div>
            </div>

            <div class="col-lg-6">
                <label for="submit_on" class="mb-2">HOD Review Complete on:-</label>
                <div class="static"></div>
            </div>

            <div class="col-lg-12 mt-3">
                <label for="submit_comm" class="mb-2">HOD Review Complete Comments:-</label>
                <div class="static"></div>
            </div>
        </div>


        {{-- Activity tab --> QA Initial Review Completed  --}}
        <div class="cft_headings1 mt-3">
            QA Initial Review Completed
        </div>
        <div class="row mt-3">
            <div class="col-lg-6">
                <label for="submit_by" class="mb-2">QA Initial Review Complete By:-</label>
                <div class="static"></div>
            </div>

            <div class="col-lg-6">
                <label for="submit_on" class="mb-2">QA Initial Review Complete on:-</label>
                <div class="static"></div>
            </div>

            <div class="col-lg-12 mt-3">
                <label for="submit_comm" class="mb-2">QA Initial Review Comments:-</label>
                <div class="static"></div>
            </div>
        </div>

        {{-- Activity Tab --> CFT Review Complete --}}
        <div class="cft_headings1 mt-3">
            CFT Review Complete
        </div>
        <div class="row mt-3">
            <div class="col-lg-6">
                <label for="submit_by" class="mb-2">CFT Review Complete By:-</label>
                <div class="static"></div>
            </div>

            <div class="col-lg-6">
                <label for="submit_on" class="mb-2">CFT Review Complete on:-</label>
                <div class="static"></div>
            </div>

            <div class="col-lg-12 mt-3">
                <label for="submit_comm" class="mb-2">CFT Review Comments:-</label>
                <div class="static"></div>
            </div>
        </div>

        {{-- Activity Tab --> Initiator Update --}}
        <div class="cft_headings1 mt-3">
            Initiator Update
        </div>
        <div class="row mt-3">
            <div class="col-lg-6">
                <label for="submit_by" class="mb-2">Initiator Update Complete By:-</label>
                <div class="static"></div>
            </div>

            <div class="col-lg-6">
                <label for="submit_on" class="mb-2">Initiator Update Complete on:-</label>
                <div class="static"></div>
            </div>

            <div class="col-lg-12 mt-3">
                <label for="submit_comm" class="mb-2">Initiator Update Comments:-</label>
                <div class="static"></div>
            </div>
        </div>

        {{-- Activity Tab --> QA Final Review Completed --}}
        <div class="cft_headings1 mt-3">
            QA Final Review Completed
        </div>
        <div class="row mt-3">
            <div class="col-lg-6">
                <label for="submit_by" class="mb-2">QA Final Review Complete By:-</label>
                <div class="static"></div>
            </div>

            <div class="col-lg-6">
                <label for="submit_on" class="mb-2">QA Final Review Complete on:-</label>
                <div class="static"></div>
            </div>

            <div class="col-lg-12 mt-3">
                <label for="submit_comm" class="mb-2">QA Final Review Comments:-</label>
                <div class="static"></div>
            </div>
        </div>


        {{-- Activity Tab --> Approved --}}
        <div class="cft_headings1 mt-3">
            Approved
        </div>
        <div class="row mt-3">
            <div class="col-lg-6">
                <label for="submit_by" class="mb-2">Approved By:-</label>
                <div class="static"></div>
            </div>

            <div class="col-lg-6">
                <label for="submit_on" class="mb-2">Approved on:-</label>
                <div class="static"></div>
            </div>

            <div class="col-lg-12 mt-3">
                <label for="submit_comm" class="mb-2">Approved Comments:-</label>
                <div class="static"></div>
            </div>
        </div>

        <div id="btns">
            <button type="button" class="prev-step">Previous</button>
            <button type="button" class="save_btn_all">Save all</button>
            {{-- <button type="button" class="next-step">Next</button> --}}
        </div>

    </div>

    </div>

    <script>
        const formSteps = document.querySelectorAll('.form-step');
        const nextBtns = document.querySelectorAll('.next-step');
        const prevBtns = document.querySelectorAll('.prev-step');
        const progressSteps = document.querySelectorAll('.progress-bar .step');

        let currentStep = 0;


        // Function to show the correct step
        function updateFormStep(stepIndex) {
            // Hide all form steps
            formSteps.forEach((step, index) => {
                step.classList.remove('active');
                progressSteps[index].classList.remove('active');
            });

            // Show the selected form step
            formSteps[stepIndex].classList.add('active');
            progressSteps[stepIndex].classList.add('active');

            currentStep = stepIndex;
        }

        // Add click event to progress steps
        progressSteps.forEach((progressStep, index) => {
            progressStep.addEventListener('click', () => {
                updateFormStep(index);
            });
        });

        // Add click event to Next buttons
        document.querySelectorAll('.next-step').forEach((btn) => {
            btn.addEventListener('click', () => {
                if (currentStep < formSteps.length - 1) {
                    updateFormStep(currentStep + 1);
                }
            });
        });

        // Add click event to Previous buttons
        document.querySelectorAll('.prev-step').forEach((btn) => {
            btn.addEventListener('click', () => {
                if (currentStep > 0) {
                    updateFormStep(currentStep - 1);
                }
            });
        });
    </script>


    <script>
        function submitform(step) {
            let formData = new FormData();

            if (step === 1) {
                let firstName = document.getElementById('firstName').value;
                let lastName = document.getElementById('lastName').value;
                let email = document.getElementById('email').value;
                let phone = document.getElementById('phone').value;
                let address = document.getElementById('address').value;
                let depart = document.getElementById('depart').value;
                let course = document.getElementById('course').value;
                let rollno = document.getElementById('roll').value;
                let contact = document.getElementById('contact').value;
                let branch = document.getElementById('branch').value;
                let category = document.getElementById('category').value;
                let files = document.getElementById('profilePics').value;

                // Check if all required fields are filled
                if (!firstName || !lastName || !email || !phone || !address || !depart || !course || !rollno || !contact ||
                    !branch || !category || !files) {
                    alert('Please fill all the fields');
                    return; // Stop the function if any field is empty
                }

                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                formData.append('firstName', firstName);
                formData.append('lastName', lastName);
                formData.append('email', email);
                formData.append('phone', phone);
                formData.append('address', address);
                formData.append('depart', depart);
                formData.append('course', course);
                formData.append('rollno', rollno);
                formData.append('contact', contact);
                formData.append('branch', branch);
                formData.append('category', category);

                let profilePic = document.getElementById('profilePics').files;
                if (profilePic.length > 0) {
                    for (let i = 0; i < profilePic.length; i++) {
                        formData.append('profilePic[]', profilePic[i]);
                    }
                }
            } else if (step === 2) {

                // Get form fields
                let company = document.getElementById('company').value;
                let job = document.getElementById('jobTitle').value;
                let join_date = document.getElementById('join_date').value;
                let expe = document.getElementById('experience').value;
                let skill = document.getElementById('skills').value;
                let resume = document.getElementById('resume').value;
                let email = document.getElementById('email').value;

                // Check if all required fields are filled
                if (!company || !job || !expe || !skill || !resume || !join_date) {
                    alert('Please fill all the fields');
                    return; // Stop the function if any field is empty
                }

                // let formData = new FormData();
                let profilePic = document.getElementById('resume').files;

                if (profilePic.length > 0) {
                    for (let i = 0; i < profilePic.length; i++) {
                        formData.append('attachment[]', profilePic[i]);
                    }
                }

                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                formData.append('comp_name', company);
                formData.append('join_date', join_date);
                formData.append('job', job);
                formData.append('experience', expe);
                formData.append('skill', skill);
                formData.append('email', email);


                let attachments = document.getElementById('resume').files;
                if (attachments.length > 0) {
                    for (let i = 0; i < attachments.length; i++) {
                        formData.append('attachment[]', attachments[i]);
                    }
                }
            }

            fetch(`/save-step-${step}`, {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.message) {
                        alert(data.message);
                        window.location.href = "http://127.0.0.1:8000/kush";
                    } else {
                        alert('Error occurred');
                    }
                })
                .catch(err => alert('Request failed'));
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>
