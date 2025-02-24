{{-- @extends('frontend.rcms.layout.main_rcms') --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>This is recall form </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #eca73f;
        box-sizing: border-box;
    }

    .field_style {
        display: block;
        font-size: 0.9rem;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .file-attachment-field {
        display: grid;
        grid-template-columns: 1fr 150px;
        align-items: start;
        gap: 20px;
        margin-bottom: 20px;
    }

    .file-attachment-list {
        background: white;
        border: 1px solid black;
        padding: 5px 10px;
        border-radius: 5px;
        min-height: 70px;
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .main_container {
        padding: 15px 20px;
    }

    #top_head {
        color: papayawhip;
        letter-spacing: 2px;
        font-size: 0.9rem;

    }


    /* Active step */
    .progress-bar .step.active {
        background-color: #000000;
        color: white;
        cursor: pointer;

    }

    /* Hover effect */
    .progress-bar .step:hover {
        /* background-color: #edc3a0; */
        opacity: 0.8;
        color: black;
        cursor: pointer;
    }

    /* Transition effect */
    /* .progress-bar .step:not(.active):hover {
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        cursor: pointer;

    } */

    .progress-bar {
        display: flex;
        justify-content: flex-start;
        flex-wrap: wrap;
        gap: .5%;
        align-items: center;
        flex-direction: row;
    }

    .progress-bar .step {

        text-align: center;
        padding: 6px 26px;
        border-radius: 20px;
        background-color: white;
        color: #eca73f;
        ;
        margin-bottom: 0.5rem
    }

    .progress-bar .step.active {
        background: black;
        color: white;
        font-weight: bold;
    }

    .language {
        font-size: 16px;
        font-weight: bold;
        color: #333;
    }

    .forms_styles {
        box-shadow: 12px 12px 24px #fae1c4, -12px -12px 24px #fde0bf;
        background: #ffffff;
        overflow: hidden;
    }



    .cft_headings1 {
        color: #eba746;
        border-bottom: 2px solid #eba746;
        padding-bottom: 5px;
        margin-bottom: 20px;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .inner_block {
        padding: 1.5rem;
    }

    #btns {
        margin: 1rem 0rem;
        float: right;
    }

    .prev-step {
        width: 5rem;
    }

    button {
        padding: 4px 15px;
        /* margin: 0.1rem 0rem; */
        border-radius: 10px;
        border: 1px solid #ddd;
        font-size: 16px;
        color: white;
        background-color: #eba746
    }

    button:hover {
        padding: 4px 15px;
        border-radius: 10px;
        border: 1px solid #eba746;
        font-size: 16px;
        color: #eba746;
        background-color: white;
        transition: all 0.3s linear;
    }

    .form-step {
        display: none;
    }

    .form-step.active {
        display: block;
    }

    .step {
        transition: background-color 0.3s ease, color 0.3s ease;
    }



    .input_style {
        width: 100%;
        /* border-radius: 3px; */
        padding: 5px 15px;
        font-size: 0.85rem;
        /* color: gray; */
    }

    .add_row_button {
        border-radius: 50%;
        text-align: center;
        line-height: 10px;
        margin-left: 10px;
        border: 1px solid grey;
        background-color: black
    }

    .add_row_button:hover {
        border-radius: 50%;
        text-align: center;
        line-height: 10px;
        margin-left: 10px;
        border: 1px solid grey;
        background-color: white;
        color: black;
    }
</style>




<body>
    <div class="container-fluid main_container">
        @if (isset($res['message']))
            <div class="alert alert-success">
                {{ $res['message'] }}
            </div>
        @endif

        {{-- Top header site divison section start --}}
        <div class="row">
            <div class="col-lg-12">
                <div id="top_head">
                    <strong>Site Division / Project : </strong>
                    <span>{{ Helpers::getDivisionName(session()->get('division')) }}</span><span> / Recall
                        Process</span>
                    <input type="hidden" name="division_id" value="{{ session()->get('division') }}">

                </div>
            </div>
        </div>
        {{-- Top header site divison section start --}}

        {{--  Forms Tabs start --}}
        <div class="row mt-3">
            <div class="col-lg-12 progress-bar">
                <div class="step active">Recall overview</div>
                <div class="step">Product Details</div>
                <div class="step">Affected Batches</div>
                <div class="step">Distribution Details</div>
                <div class="step">Root Cause Analysis</div>
                <div class="step">Recall Actions</div>
                <div class="step">Regulatory Compliance</div>
                <div class="step">Customer Communication</div>
                <div class="step">Financial Impact</div>
                <div class="step">Closure and Reporting</div>
            </div>
        </div>
        {{-- Forms Tabs end --}}


        {{-- select language start --}}
        <div class="row" style="padding: 2.5rem 0rem">
            <div class="col-lg-12 language">
                Select language
            </div>
        </div>
        {{-- select language end --}}


        {{-- Forms start --}}

        @php
            use Carbon\Carbon;
        @endphp

        <div>
            {{-- <form action="{{ route('recall_process', $unique1) }}" method="post"> --}}
            <form action="{{ route('recall_process.send') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="inner_block forms_styles">
                    @if (!empty($parent_id))
                        <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                        <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                    @endif
                    <input type="hidden" name="division_id" value="{{ session()->get('division') }}">

                    {{-- inner items starts --}}

                    {{-- Recall overview starts --}}
                    <div class="form-step active">
                        <div class="cft_headings1">
                            Recall Overview
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="record_no" class="field_style"> Record Number </label>
                                <input type="text"id="record_no" name="record_number" readonly
                                    value="{{ Helpers::getDivisionName(session()->get('division')) }}/Recall Process/{{ date('Y') }}/{{ $record_number }}"
                                    class="input_style" style="color: gray !important" />
                            </div>
                            <div class="col-lg-6">
                                <label for="site_loca" class="field_style"> Site/Location Code </label>
                                <input type="text"id="site_loca" name="site_location"
                                    value="{{ Helpers::getDivisionName(session()->get('division')) }}"
                                    class="input_style" readonly />
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="initi" class="field_style">Initiator</label>
                                <input type="text"id="initi" name="division_code" value="{{ Auth::user()->name }}"
                                    class="input_style" style="color: gray !important" readonly />
                            </div>
                            <div class="col-lg-6">
                                <label for="d_o_ini" class="field_style">Date of Initiation</label>
                                <input type="text"id="d_o_ini" name="intiation_date"
                                    value="{{ Carbon::now()->format('d-M-Y') }}" class="input_style" readonly
                                    style="color: gray !important" />
                            </div>
                        </div>
                        @php
                            $users = DB::table('users')->get();
                        @endphp

                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="assi_to" class="field_style"> Assigned To </label>
                                <select class="input_style" name="assign_to">
                                    {{-- <option default>Select a value</option> --}}
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                    {{-- <option value="himanshu">Himanshu Patil</option> --}}
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="due_date" class="field_style"> Due Date <span style="color: red">*</span>
                                </label>
                                <input type="text"id="due_date" name="due_date"
                                    value="{{ Carbon::now()->addMonth()->subDay()->format('d-M-Y') }}"
                                    class="input_style" readonly />

                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="depart_group" class="field_style"> Department Group </label>

                                <select name="depart_group" id="depart_group" class="input_style">
                                    <option value="">-- Select --</option>
                                    <option value="Quality Assurance Biopharma">
                                        Quality
                                        Assurance Biopharma</option>
                                    <option value="Corporate Quality Assurance">
                                        Corporate Quality Assurance</option>
                                    <option value="Central Quality Control">
                                        Central Quality Control</option>
                                    <option value="Manufacturing">
                                        Manufacturing</option>
                                    <option value="Plasma Sourcing Group">Plasma Sourcing Group</option>
                                    <option value="Central Stores">
                                        Central Stores</option>
                                    <option value="Information Technology Group">
                                        Information Technology Group</option>
                                    <option value="Molecular Medicine">
                                        Molecular Medicine</option>
                                    <option value="Central Laboratory">
                                        Central Laboratory</option>
                                    <option value="Tech Team">Tech Team</option>
                                    <option value="Quality Assurance">
                                        Quality Assurance</option>
                                    <option value="Quality Management">
                                        Quality Management</option>
                                    <option value="IT Administration">IT Administration</option>
                                    <option value="Accounting">
                                        Accounting</option>
                                    <option value="Logistics">
                                        Logistics</option>
                                    <option value="Senior Management">
                                        Senior Management</option>
                                    <option value="Business Administration">
                                        Business Administration</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="depart_group_code" class="field_style">
                                    Department Group Code </label>
                                <input type="text"id="depart_group_code" name="depart_group_code" value=""
                                    class="input_style" readonly />
                            </div>
                        </div>

                        <div class="row mt-4">
                            <label for="recall_id" class="field_style"> Short Description <span
                                    style="color: red">*</span></label>
                            <small style="color: blue;">255 characters remaining </small>
                            <div class="col-lg-12">
                                <input maxlength="255" name="short_description" style="width: 100%" required />
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="batch" class="field_style"> Batch/Lot Number </label>
                                <input type="number" id="batch" name="batch_lot_no" value=""
                                    class="input_style" />
                            </div>
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Recall Classification </label>
                                <input type="text"id="recall_id" name="classification" value=""
                                    class="input_style" />
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Recall Initiation Date </label>
                                <input type="date"id="recall_id" name="init_date" class="input_style"
                                    value="" />
                            </div>
                        </div>

                        <div class="row mt-4">
                            <label for="reason" class="field_style"> Reason for Recall </label>
                            <small style="color: blue">Please insert "NA" in the data field if it does not
                                require
                                completion</small>
                            <div class="col-lg-12">
                                <textarea id="reason" class="mt-3" style="width: 100%" name="rea_for_recall" rows="3"></textarea>

                            </div>
                        </div>

                        <div class="row mt-4">
                            <label for="recall_id" class="field_style"> Recall Scope </label>
                            <small style="color: blue">Please insert "NA" in the data field if it does not
                                require
                                completion</small>
                            <div class="col-lg-12">
                                <textarea id="recall_id" class="mt-3" style="width: 100%" name="recall_scope" rows="3"></textarea>

                            </div>
                        </div>

                        {{-- <div class="row mt-4">
                            <div class="group-input">
                                <label for="Recall Process/Document">Recall Process/Document</label>
                                <div><small class="text-primary">Please Attach all relevant or Attached
                                        File</small></div>
                                <div class="file-attachment-field">
                                    <div class="file-attachment-list" id="recall_attach"></div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input type="file" id="myfile" name="recall_attach[]"
                                            oninput="addMultipleFiles(this, 'pm_procedure_document')" multiple>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        <div class="group-input">
                            <label for="recall_attachment" class="field_style">Recall Attachments</label>
                            <div class="file-attachment-field">
                                <div class="file-attachment-list" id="recall_attachment12">
                                    {{-- @if ($equipment->recall_attach)
                                        @foreach (json_decode($equipment->recall_attach) as $file)
                                            <h6 type="button" class="file-container text-dark"
                                                style="background-color: rgb(243, 242, 240);">
                                                <b>{{ $file }}</b>
                                                <a href="{{ asset('upload/' . $file) }}"
                                                    target="_blank"><i class="fa fa-eye text-primary"
                                                        style="font-size:20px; margin-right:-10px;"></i></a>
                                                        &nbsp;&nbsp;
                                                <a type="button" class="remove-file"
                                                    data-file-name="{{ $file }}"><i
                                                        class="fa-solid fa-circle-xmark"
                                                        style="color:red; font-size:20px;"></i></a>                                                                
                                                        &nbsp;&nbsp;
                                            </h6>
                                        @endforeach                                                            
                                    @endif --}}
                                </div>
                                <div class="add-btn" style="position: relative;margin-top:1rem">
                                    <div
                                        style="background: #f5c27f;color: white;border-radius: 5px;text-align: center;padding: 5px;">
                                        Add</div>
                                    <input type="file" id="myfile" name="recall_attach[]"
                                        onChange="showSelectedFiles(this)" multiple
                                        style="position: absolute;top: 10px;left: 0;width: 100%;z-index: 2;opacity: 0;">
                                </div>
                            </div>
                        </div>

                        <script>
                            function showSelectedFiles(input) {
                                const fileAttachmentList = document.getElementById('recall_attachment12');

                                // Loop through all selected files
                                Array.from(input.files).forEach(file => {
                                    // Check if file is already displayed (Avoid duplicates)
                                    const existingFiles = Array.from(fileAttachmentList.children).map(child => child.querySelector('b')
                                        .textContent);
                                    if (existingFiles.includes(file.name)) {
                                        alert(`${file.name} is already added.`);
                                        return;
                                    }

                                    // Create a new container for each file
                                    const fileContainer = document.createElement('h6');
                                    fileContainer.className = 'file-container text-dark';
                                    // fileContainer.style.backgroundColor = 'rgb(243, 242, 240)';
                                    fileContainer.style.marginBottom = '10px';

                                    // Add file name
                                    const fileName = document.createElement('b');
                                    fileName.textContent = file.name;

                                    // Add "View" button
                                    const viewFileBtn = document.createElement('span');
                                    viewFileBtn.className = 'view-file fa fa-eye text-primary';
                                    viewFileBtn.style.marginLeft = '10px';
                                    viewFileBtn.style.marginRight = '5px';
                                    viewFileBtn.textContent = '';

                                    // Add preview functionality to the "View" button
                                    viewFileBtn.addEventListener('click', () => {
                                        const reader = new FileReader();

                                        reader.onload = function(e) {
                                            if (file.type.startsWith('image/')) {
                                                // If image, show it in a popup
                                                const imgPreview = window.open("", "_blank");
                                                imgPreview.document.write(
                                                    `<img src="${e.target.result}" style="max-width:100%; height:auto;" />`
                                                );
                                            } else if (file.type === 'application/pdf') {
                                                // If PDF, show it in a new tab
                                                const pdfPreview = window.open("", "_blank");
                                                pdfPreview.document.write(
                                                    `<embed src="${e.target.result}" width="100%" height="100%" type="application/pdf">`
                                                );
                                            } else {
                                                // For other files, display content in a new tab
                                                const filePreview = window.open("", "_blank");
                                                filePreview.document.write(`<pre>${e.target.result}</pre>`);
                                            }
                                        };

                                        reader.readAsDataURL(file); // Read file as Data URL
                                    });

                                    // Add "Remove" button
                                    const removeFileBtn = document.createElement('a');
                                    removeFileBtn.className = 'remove-file';
                                    removeFileBtn.innerHTML =
                                        `<i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i>`;
                                    removeFileBtn.style.cursor = 'pointer';

                                    // Remove file logic
                                    removeFileBtn.addEventListener('click', () => {
                                        fileContainer.remove();
                                    });

                                    // Append elements to the container
                                    fileContainer.appendChild(fileName);
                                    fileContainer.appendChild(viewFileBtn);
                                    fileContainer.appendChild(removeFileBtn);

                                    // Add file container to the list
                                    fileAttachmentList.appendChild(fileContainer);
                                });
                            }
                        </script>

                        
                        <div class="col-12">
                            <div class="group-input">
                                <label for="Material Details">
                                    Equipment/Instruments Details<button type="button" name="ann"
                                        id="addequipment">+</button>
                                </label>
                                <table class="table table-bordered" id="equipment_de">
                                    <thead>
                                        <tr>
                                            <th>Row #</th>
                                            <th>Equipment Name</th>
                                            <th>Equipment ID</th>
                                            <th>Equipment Remark</th>
                                            <th>Equipment Comments</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>



                                    <tbody>
                                        <td><input disabled type="text" name="serial_number[]" value="1">
                                        </td>
                                        <td><input type="text" name="equipment[]"></td>
                                        <td><input type="text" name="equipment_instruments[]"></td>
                                        <td><input type="text" name="equipment_remark[]"></td>
                                        <td><input type="text" name="equipment_comments[]"></td>
                                        <td><button type="button" class="removeRowBtn">Remove</button></td>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <script>
                            document.getElementById('addequipment').addEventListener('click', function() {
                                const tableBody = document.querySelector('#equipment_de tbody');
                                const newRow = document.createElement('tr');

                                const rowCount = tableBody.rows.length + 1;

                                newRow.innerHTML = `
                                        <td><input disabled type="text" name="serial_number[]" value="${rowCount}"></td>
                                        <td><input type="text" name="equipment[]"></td>
                                        <td><input type="text" name="equipment_instruments[]"></td>
                                        <td><input type="text" name="equipment_remark[]"></td>
                                        <td><input type="text" name="equipment_comments[]"></td>
                                        <td><button type="button" class="removeRowBtn">Remove</button></td>
                                    `;

                                tableBody.appendChild(newRow);

                                updateRemoveRowListeners();
                            });

                            function updateRemoveRowListeners() {
                                document.querySelectorAll('.removeRowBtn').forEach(button => {
                                    button.addEventListener('click', function() {
                                        this.closest('tr').remove();
                                        updateRowNumbers();
                                    });
                                });
                            }

                            function updateRowNumbers() {
                                document.querySelectorAll('#equipment_de tbody tr').forEach((row, index) => {
                                    row.querySelector('input[name="serial_number[]"]').value = index + 1;
                                });
                            }

                            // Initial call to set up the listeners for the existing row
                            updateRemoveRowListeners();
                        </script>

                        <div id="btns">
                            <button type="submit">Save</button>
                            {{-- <button type="button" class="save_btn_all">Next</button> --}}
                            {{-- <button type="button" class="prev-step">Back</button> --}}
                            <button type="button" class="next-step">Next</button>
                        </div>
                    </div>
                    {{-- Recall overview ends --}}


                    {{-- product details starts --}}
                    <div class="form-step ">
                        <div class="cft_headings1">
                            Product Details
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Product Code </label>
                                <input type="text"id="recall_id" name="produ_code" value=""
                                    class="input_style" />
                            </div>
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Active Pharmaceutical Ingredient (API)
                                </label>
                                <input type="text"id="recall_id" name="acti_phar_ingre" value=""
                                    class="input_style" />
                            </div>
                        </div>


                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Manufacturer Name </label>
                                <input type="text"id="recall_id" name="manufac_name" value=""
                                    class="input_style" />
                            </div>
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Expiry Date </label>
                                <input type="date"id="recall_id" name="expiry_data" value=""
                                    class="input_style" />
                            </div>
                        </div>

                        {{-- add group select --}}
                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="depart_group1" class="field_style"> Add Group </label>
                                <select name="add_group" id="depart_group1" class="input_style">
                                    <option value="">-- Select --</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div id="content_div" style="display:none;">
                                <div class="col-lg-12">
                                    <label for="depart_group1" class="field_style"> Add Group Details
                                        <button type="button" class="add_row_button" id="add_row_button">+</button>
                                        <small style="font-size: 0.8rem;font-weight: 400;cursor: pointer;"
                                            class="text-primary mx-1">(Launch Instruction)
                                        </small>
                                    </label>

                                    <div class="row mt-2 ">
                                        <div class="col-lg-12">
                                            <table id="data_table">
                                                <tr style="background-color: #f5c27f;">
                                                    <th
                                                        style="width:4%;border:1px solid white;;padding:8px;font-size: 0.85rem;">
                                                        Row</th>
                                                    <th
                                                        style="width:12%;border:1px solid white;;padding:8px;font-size: 0.85rem;">
                                                        Name</th>
                                                    <th
                                                        style="width:16%;border:1px solid white;padding:8px;font-size: 0.85rem;">
                                                        ID Number
                                                    </th>
                                                    <th
                                                        style="width:15%;border:1px solid white;;padding:8px;font-size: 0.85rem;">
                                                        Remarks
                                                    </th>
                                                    <th
                                                        style="width:8%;border:1px solid white;;padding:8px;font-size: 0.85rem;">
                                                        Action
                                                    </th>
                                                </tr>

                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <label for="recall_id" class="field_style"> Packaging Details </label>
                            <small style="color: blue">Please insert "NA" in the data field if it does not
                                require
                                completion</small>
                            <div class="col-lg-12">
                                <textarea id="qrm_req" class="mt-3" style="width: 100%" name="packaging_detail" rows="3"></textarea>

                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Strength/Dosage Form </label>
                                <input type="text"id="recall_id" name="dosage_form" value=""
                                    class="input_style" />
                            </div>
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Storage Conditions </label>
                                <input type="text"id="recall_id" name="stora_condi" value=""
                                    class="input_style" />
                            </div>
                        </div>

                        <div id="btns">
                            <button type="submit">Save</button>
                            {{-- <button type="button" class="save_btn_all">Next</button> --}}
                            <button type="button" class="prev-step">Back</button>
                            <button type="button" class="next-step">Next</button>
                        </div>
                    </div>
                    {{-- product details ends --}}


                    {{-- Affected Batches starts --}}
                    <div class="form-step ">
                        <div class="cft_headings1">
                            Affected Batches
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Batch/Lot Number </label>
                                <input type="text"id="recall_id" name="affected_lot_no" value=""
                                    class="input_style" />
                            </div>
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Manufacturing Date </label>
                                <input type="date"id="recall_id" name="affected_manufacturing_date" value=""
                                    class="input_style" />
                            </div>
                        </div>


                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Expiry Date </label>
                                <input type="date"id="recall_id" name="affected_expiry_date" value=""
                                    class="input_style" />
                            </div>
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Quantity Produced </label>
                                <input type="number"id="recall_id" name="quantity_produced" value=""
                                    class="input_style" />
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Quantity Distributed </label>
                                <input type="number"id="recall_id" name="quantity_distri" value=""
                                    class="input_style" />
                            </div>
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Quantity Recalled </label>
                                <input type="number"id="recall_id" name="quantity_recall" value=""
                                    class="input_style" />
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Distribution Channels </label>
                                <input type="text"id="recall_id" name="distribution_channel" value=""
                                    class="input_style" />
                            </div>

                        </div>

                        <div class="row mt-4">
                            <label for="recall_id" class="field_style"> Affected Batch Reason </label>
                            <small style="color: blue">Please insert "NA" in the data field if it does not
                                require
                                completion</small>
                            <div class="col-lg-12">
                                <textarea id="qrm_req" class="mt-3" style="width: 100%" name="affected_batch_reason" rows="3"></textarea>

                            </div>
                        </div>

                        <div id="btns">
                            <button type="submit">Save</button>
                            {{-- <button type="button" class="save_btn_all">Next</button> --}}
                            <button type="button" class="prev-step">Back</button>
                            <button type="button" class="next-step">Next</button>
                        </div>
                    </div>
                    {{-- Affected Batches end --}}


                    {{-- Distribution Details starts --}}
                    <div class="form-step ">
                        <div class="cft_headings1">
                            Distribution Details
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Distributor Name </label>
                                <input type="text"id="recall_id" name="distributor_name" value=""
                                    class="input_style" />
                            </div>
                        </div>

                        <div class="row mt-4">
                            <label for="recall_id" class="field_style"> Distributor Address </label>
                            <small style="color: blue">Please insert "NA" in the data field if it does not
                                require
                                completion</small>
                            <div class="col-lg-12">
                                <textarea id="qrm_req" class="mt-3" style="width: 100%" name="distributor_address" rows="3"></textarea>
                            </div>
                        </div>


                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Shipment Date </label>
                                <input type="date"id="recall_id" name="shipment_date" value=""
                                    class="input_style" />
                            </div>
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Delivery Confirmation </label>
                                <input type="text"id="recall_id" name="delivery_confirm" value=""
                                    class="input_style" />
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Retailer/Pharmacy Name </label>
                                <input type="text"id="recall_id" name="pharmacy_name" value=""
                                    class="input_style" />
                            </div>
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Geographic Region of Distribution </label>
                                <input type="text"id="recall_id" name="geograp_reason_of_distri" value=""
                                    class="input_style" />
                            </div>
                        </div>

                        <div id="btns">
                            <button type="submit">Save</button>
                            {{-- <button type="button" class="save_btn_all">Next</button> --}}
                            <button type="button" class="prev-step">Back</button>
                            <button type="button" class="next-step">Next</button>
                        </div>
                    </div>
                    {{-- Distribution Details end --}}


                    {{-- Root Cause Analysis starts --}}
                    <div class="form-step ">
                        <div class="cft_headings1">
                            Root Cause Analysis
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Investigation ID </label>
                                <input type="text"id="recall_id" name="investi_id" value=""
                                    class="input_style" />
                            </div>
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Detection Date </label>
                                <input type="date"id="recall_id" name="detaction_date" value=""
                                    class="input_style" />
                            </div>
                        </div>

                        <div class="row mt-4">
                            <label for="recall_id" class="field_style"> Root Cause Description </label>
                            <small style="color: blue">Please insert "NA" in the data field if it does not
                                require
                                completion</small>
                            <div class="col-lg-12">
                                <textarea id="qrm_req" class="mt-3" style="width: 100%" name="root_cause_desc" rows="3"></textarea>

                            </div>
                        </div>


                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Expiry Date </label>
                                <input type="date"id="recall_id" name="expiry_date" value=""
                                    class="input_style" />
                            </div>
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Quantity Produced </label>
                                <input type="number"id="recall_id" name="root_quantity_produced" value=""
                                    class="input_style" />
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Quantity Distributed </label>
                                <input type="number"id="recall_id" name="root_quantity_distri" value=""
                                    class="input_style" />
                            </div>
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Quantity Recalled </label>
                                <input type="number"id="recall_id" name="root_quantity_recall" value=""
                                    class="input_style" />
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Distribution Channels </label>
                                <input type="text"id="recall_id" name="root_distri_channel" value=""
                                    class="input_style" />
                            </div>

                        </div>

                        <div class="row mt-4">
                            <label for="recall_id" class="field_style"> Affected Batch Reason </label>
                            <small style="color: blue">Please insert "NA" in the data field if it does not
                                require
                                completion</small>
                            <div class="col-lg-12">
                                <textarea id="qrm_req" class="mt-3" style="width: 100%" name="root_affected_batch_person" rows="3"></textarea>

                            </div>
                        </div>

                        <div id="btns">
                            <button type="submit">Save</button>
                            {{-- <button type="button" class="save_btn_all">Next</button> --}}
                            <button type="button" class="prev-step">Back</button>
                            <button type="button" class="next-step">Next</button>
                        </div>
                    </div>
                    {{-- Root Cause Analysis end --}}


                    {{--  Recall Actions starts --}}
                    <div class="form-step ">
                        <div class="cft_headings1">
                            Recall Actions
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Batch/Lot Number </label>
                                <input type="text"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Manufacturing Date </label>
                                <input type="date"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>
                        </div>


                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Expiry Date </label>
                                <input type="date"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Quantity Produced </label>
                                <input type="number"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Quantity Distributed </label>
                                <input type="number"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Quantity Recalled </label>
                                <input type="number"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Distribution Channels </label>
                                <input type="text"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>

                        </div>

                        <div class="row mt-4">
                            <label for="recall_id" class="field_style"> Affected Batch Reason </label>
                            <small style="color: blue">Please insert "NA" in the data field if it does not
                                require
                                completion</small>
                            <div class="col-lg-12">
                                <textarea id="qrm_req" class="mt-3" style="width: 100%" name="qrm_req" rows="3"></textarea>

                            </div>
                        </div>

                        <div id="btns">
                            <button type="submit">Save</button>
                            {{-- <button type="button" class="save_btn_all">Next</button> --}}
                            <button type="button" class="prev-step">Back</button>
                            <button type="button" class="next-step">Next</button>
                        </div>
                    </div>
                    {{--  Recall Actions end --}}


                    {{--  Regulatory Compliance starts --}}
                    <div class="form-step ">
                        <div class="cft_headings1">
                            Regulatory Compliance
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Batch/Lot Number </label>
                                <input type="text"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Manufacturing Date </label>
                                <input type="date"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>
                        </div>


                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Expiry Date </label>
                                <input type="date"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Quantity Produced </label>
                                <input type="number"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Quantity Distributed </label>
                                <input type="number"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Quantity Recalled </label>
                                <input type="number"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Distribution Channels </label>
                                <input type="text"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>

                        </div>

                        <div class="row mt-4">
                            <label for="recall_id" class="field_style"> Affected Batch Reason </label>
                            <small style="color: blue">Please insert "NA" in the data field if it does not
                                require
                                completion</small>
                            <div class="col-lg-12">
                                <textarea id="qrm_req" class="mt-3" style="width: 100%" name="qrm_req" rows="3"></textarea>

                            </div>
                        </div>


                        <div id="btns">
                            <button type="submit">Save</button>
                            {{-- <button type="button" class="save_btn_all">Next</button> --}}
                            <button type="button" class="prev-step">Back</button>
                            <button type="button" class="next-step">Next</button>
                        </div>
                    </div>
                    {{--  Regulatory Compliance end --}}


                    {{--  Customer Communication starts --}}
                    <div class="form-step ">
                        <div class="cft_headings1">
                            Customer Communication
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Batch/Lot Number </label>
                                <input type="text"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Manufacturing Date </label>
                                <input type="date"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>
                        </div>


                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Expiry Date </label>
                                <input type="date"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Quantity Produced </label>
                                <input type="number"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Quantity Distributed </label>
                                <input type="number"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Quantity Recalled </label>
                                <input type="number"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Distribution Channels </label>
                                <input type="text"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>

                        </div>

                        <div class="row mt-4">
                            <label for="recall_id" class="field_style"> Affected Batch Reason </label>
                            <small style="color: blue">Please insert "NA" in the data field if it does not
                                require
                                completion</small>
                            <div class="col-lg-12">
                                <textarea id="qrm_req" class="mt-3" style="width: 100%" name="qrm_req" rows="3"></textarea>

                            </div>
                        </div>


                        <div id="btns">
                            <button type="button">Save</button>
                            {{-- <button type="button" class="save_btn_all">Next</button> --}}
                            <button type="button" class="prev-step">Back</button>
                            <button type="button" class="next-step">Next</button>
                        </div>
                    </div>
                    {{--  Customer Communication end --}}


                    {{--  Financial Impact starts --}}
                    <div class="form-step ">
                        <div class="cft_headings1">
                            Financial Impact
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Batch/Lot Number </label>
                                <input type="text"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Manufacturing Date </label>
                                <input type="date"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>
                        </div>


                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Expiry Date </label>
                                <input type="date"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Quantity Produced </label>
                                <input type="number"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Quantity Distributed </label>
                                <input type="number"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Quantity Recalled </label>
                                <input type="number"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Distribution Channels </label>
                                <input type="text"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>

                        </div>

                        <div class="row mt-4">
                            <label for="recall_id" class="field_style"> Affected Batch Reason </label>
                            <small style="color: blue">Please insert "NA" in the data field if it does not
                                require
                                completion</small>
                            <div class="col-lg-12">
                                <textarea id="qrm_req" class="mt-3" style="width: 100%" name="qrm_req" rows="3"></textarea>

                            </div>
                        </div>


                        <div id="btns">
                            <button type="button">Save</button>
                            {{-- <button type="button" class="save_btn_all">Next</button> --}}
                            <button type="button" class="prev-step">Back</button>
                            <button type="button" class="next-step">Next</button>
                        </div>
                    </div>
                    {{--  Financial Impact end --}}


                    {{--  Closure and Reporting starts --}}
                    <div class="form-step ">
                        <div class="cft_headings1">
                            Closure and Reporting
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Batch/Lot Number </label>
                                <input type="text"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Manufacturing Date </label>
                                <input type="date"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>
                        </div>


                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Expiry Date </label>
                                <input type="date"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Quantity Produced </label>
                                <input type="number"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Quantity Distributed </label>
                                <input type="number"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Quantity Recalled </label>
                                <input type="number"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <label for="recall_id" class="field_style"> Distribution Channels </label>
                                <input type="text"id="recall_id" name="" value=""
                                    class="input_style" />
                            </div>

                        </div>

                        <div class="row mt-4">
                            <label for="recall_id" class="field_style"> Affected Batch Reason </label>
                            <small style="color: blue">Please insert "NA" in the data field if it does not
                                require
                                completion</small>
                            <div class="col-lg-12">
                                <textarea id="qrm_req" class="mt-3" style="width: 100%" name="qrm_req" rows="3"></textarea>

                            </div>
                        </div>

                        <div id="btns">
                            <button type="button">Save</button>
                            <button type="button" class="prev-step">Back</button>

                        </div>
                    </div>
                    {{--  Closure and Reporting end --}}

                </div>
            </form>
        </div>
        {{-- Forms end --}}

    </div>


    {{-- script starts  --}}
    <script>
        // add_row_button_Start
        document.getElementById('add_row_button').addEventListener('click', function() {
            // Table reference
            const table = document.getElementById('data_table').getElementsByTagName('tbody')[0];

            // Number of rows in the table
            const rowCount = table.rows.length;
            // const rowCount = 0;
            console.log('Rowcount is : ', rowCount);


            // Create a new row
            const newRow = table.insertRow();

            // Insert cells
            const cell1 = newRow.insertCell(0);
            const cell2 = newRow.insertCell(1);
            const cell3 = newRow.insertCell(2);
            const cell4 = newRow.insertCell(3);
            const cell5 = newRow.insertCell(4);

            // Populate cells
            cell2.innerHTML = `<select name="row_data[${rowCount}][name]" class="form-control" name='select_name'>
            <option value="">---Select---</option>
            <option value="John">John</option>
            <option value="Jane">Jane</option>
            <option value="Doe">Doe</option>
        </select>`;
            cell3.innerHTML = `<input type="text" name="row_data[${rowCount}][id]" class="form-control">`;
            cell4.innerHTML =
                `<input type="text" name="row_data[${rowCount}][remark]" class="form-control"  >`;
            cell5.innerHTML =
                `<button type="button" class="btn btn-danger btn-sm remove_row_button">Remove</button>`;
            cell1.innerHTML = rowCount;

            const removeButtons = document.querySelectorAll('.remove_row_button');
            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('tr').remove();
                });
            });
        });

        // add_row_button_end



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
    {{-- script end --}}

    <!-- jQuery Script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // When the department group is selected, set the same value in the code input
            $('#depart_group').change(function() {
                var selectedGroup = $(this).val(); // Get selected department group value
                console.log('selected group is : ', selectedGroup);

                // Custom logic to assign custom value based on selected group
                var customValue = '';

                if (selectedGroup === 'Quality Assurance Biopharma') {
                    customValue = 'QAB';
                } else if (selectedGroup === 'Corporate Quality Assurance') {
                    customValue = 'CQA';
                } else if (selectedGroup === 'Central Quality Control') {
                    customValue = 'CQC';
                } else if (selectedGroup === 'Manufacturing') {
                    customValue = 'Manu';
                } else if (selectedGroup === 'Plasma Sourcing Group') {
                    customValue = 'PSG';
                } else if (selectedGroup === 'Central Stores') {
                    customValue = 'CS';
                } else if (selectedGroup === 'Information Technology Group') {
                    customValue = 'ITG';
                } else if (selectedGroup === 'Molecular Medicine') {
                    customValue = 'MM';
                } else if (selectedGroup === 'Central Laboratory') {
                    customValue = 'CL';
                } else if (selectedGroup === 'Tech Team') {
                    customValue = 'TT';
                } else if (selectedGroup === 'Quality Assurance') {
                    customValue = 'QA';
                } else if (selectedGroup === 'Quality Management') {
                    customValue = 'QM';
                } else if (selectedGroup === 'IT Administration') {
                    customValue = 'IA';
                } else if (selectedGroup === 'Accounting') {
                    customValue = 'ACC';
                } else if (selectedGroup === 'Logistics') {
                    customValue = 'LOG';
                } else if (selectedGroup === 'Senior Management') {
                    customValue = 'SM';
                } else if (selectedGroup === 'Business Administration') {
                    customValue = 'BA';
                } else {
                    customValue = 'Default Custom Value'; // Default value for other cases
                }
                // Set the same value in the department group code input
                $('#depart_group_code').val(customValue);
            });

            $('#depart_group1').change(function() {
                var selectedValue = $(this).val();
                if (selectedValue === 'yes') {
                    $('#content_div').show();
                } else {
                    $('#content_div').hide();
                }
            });
        });
    </script>
</body>

</html>
