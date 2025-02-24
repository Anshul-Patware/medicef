@extends('frontend.layout.main')
@section('container')
    @php
        $users = DB::table('users')->get();
        $Allusers = DB::table('users')->select('id', 'name')->get();
    @endphp
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }
        .remove-file  {
            color: white;
            cursor: pointer;
            margin-left: 10px;
        }

        .remove-file :hover {
            color: white;
        }
    </style>
    <style>
       .sticky-buttons div {
            background: #4274da;
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            border-radius: 0 5px 5px 0;
        }
 .sticky-buttons {
            position: fixed;
            top: 50%;
            left: 0;
            transform: translate(0, -50%);
            display: grid;
            gap: 10px;
            z-index: 5;
        }
 .btn-position{
        top:50%;
        left:50%;
        transform:translate(-50%, -50%);
        position:absolute;
        }
   .modal.right.fade.in .modal-dialog {
    right:0 !important;
    transform: translateX(-50%);
    }

.modal.right .modal-content {
height:100%;
overflow:auto;
border-radius:0;
}

 .modal.right .modal-dialog {
        position: fixed;
        margin: auto;
        height: 100%;
        -webkit-transform: translate3d(0%, 0, 0);
        -ms-transform: translate3d(0%, 0, 0);
        -o-transform: translate3d(0%, 0, 0);
        transform: translate3d(0%, 0, 0);
        }

.modal.right.fade.in .modal-dialog {
transform: translateX(0%);
}
.modal.right.fade .modal-dialog {

-webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
-moz-transition: opacity 0.3s linear, right 0.3s ease-out;
-o-transition: opacity 0.3s linear, right 0.3s ease-out;
transition: opacity 0.3s linear, right 0.3s ease-out;
width: 340px;
}
                
    
   .modal.right .modal-header {
    background-color:#4274da; 
    display: flex;
    justify-content: center;
    color:#fff
}
    .modal.right .modal-header::after {content:""; display:inline-block;}
    .modal.right .close {text-shadow:none; opacity:1; color:#ff4d4d; font-size:26px}
/*  form-control  */
    
    .form-control {border-radius:0; box-shadow:none}
    .form-control:focus {box-shadow:none}
    
    
/*  Button  */

    
    .btn {border-radius:0}

    .down-logo {
    display: flex;
    justify-content: center;
}
.dawn_arrow {
    /* position: absolute; */
    top: 100%;
    left: 50%;
    transform: rotate(90deg) translate(-12%, 23px);
    width: 50px;
    height: 50px;
    margin-left: 42px;
}

        /* scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
          }
          
          ::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            -webkit-border-radius: 15px;
            border-radius: 15px;
          }
          
          ::-webkit-scrollbar-thumb {
            -webkit-border-radius: 15px;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.3);
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.5);
          }
          
          ::-webkit-scrollbar-thumb:window-inactive {
            background: rgba(255, 255, 255, 0.3);
          }
    
            .mini_buttons{
                /* background: #1aa71a; */
                display: flex;
                border: 1px solid;
                padding: 5px;
                width: 250px;
                border-radius: 10px;
                justify-content: center;
            }
            .button-box .active{
                background: #1aa71a;
                display: flex;
                border: 1px solid;
                border-radius: 10px;
                padding: 7px;
                width: 250px;
                justify-content: center;
            }
            .main-new-workflow{
                display: flex;
                justify-content: center;
            }
            .state-block .top-block {
                background: #4274da;
                color: white;
                display: grid;
                grid-template-columns: repeat(4, 1fr);
            }
            .state-block .top-block div {
                padding: 10px 20px;
                border-right: 1px dashed #ffffff;
                font-size: 0.9rem;
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
        .sticky-buttons div {
             background: #de8d0a;
             /*background: #4274da;*/
             width: 40px;
             height: 40px;
             display: grid;
             place-items: center;
             border-radius: 0 5px 5px 0;
         }
            .sticky-buttons {
                        position: fixed;
                        top: 50%;
                        left: 0;
                        transform: translate(0, -50%);
                        display: grid;
                        gap: 10px;
                        z-index: 5;
                    }
            .btn-position{
                    top:50%;
                    left:50%;
                    transform:translate(-50%, -50%);
                    position:absolute;
                    }
                .modal.right.fade.in .modal-dialog {
                right:0 !important;
                transform: translateX(-50%);
                }
            
            .modal.right .modal-content {
            height:100%;
            overflow:auto;
            border-radius:0;
            }
            
            .modal.right .modal-dialog {
                    position: fixed;
                    margin: auto;
                    height: 100%;
                    -webkit-transform: translate3d(0%, 0, 0);
                    -ms-transform: translate3d(0%, 0, 0);
                    -o-transform: translate3d(0%, 0, 0);
                    transform: translate3d(0%, 0, 0);
                    }
            
            .modal.right.fade.in .modal-dialog {
            transform: translateX(0%);
            }
            .modal.right.fade .modal-dialog {
            
            -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
            -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
            -o-transition: opacity 0.3s linear, right 0.3s ease-out;
            transition: opacity 0.3s linear, right 0.3s ease-out;
            width: 340px;
            }
                            
                
                .modal.right .modal-header {
                background-color:#eba746; 
                display: flex;
                justify-content: center;
                color:#fff
            }
                .modal.right .modal-header::after {content:""; display:inline-block;}
                .modal.right .close {text-shadow:none; opacity:1; color:#ff4d4d; font-size:26px}
            /*  form-control  */
                
                .form-control {border-radius:0; box-shadow:none}
                .form-control:focus {box-shadow:none}
                
                
            /*  Button  */
            
                
                .btn {border-radius:0}
            
                .down-logo {
                display: flex;
                justify-content: center;
            }
            .dawn_arrow {
                /* position: absolute; */
                top: 100%;
                left: 50%;
                transform: rotate(90deg) translate(-12%, 23px);
                width: 50px;
                height: 50px;
                margin-left: 42px;
            }
            
                    /* scrollbar */
                    ::-webkit-scrollbar {
                        width: 5px;
                        height: 5px;
                    }
                    
                    ::-webkit-scrollbar-track {
                        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
                        -webkit-border-radius: 15px;
                        border-radius: 15px;
                    }
                    
                    ::-webkit-scrollbar-thumb {
                        -webkit-border-radius: 15px;
                        border-radius: 15px;
                        background: rgba(255, 255, 255, 0.3);
                        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.5);
                    }
                    
                    ::-webkit-scrollbar-thumb:window-inactive {
                        background: rgba(255, 255, 255, 0.3);
                    }
                
                        .mini_buttons{
                            /* background: #1aa71a; */
                            display: flex;
                            border: 1px solid;
                            padding: 5px;
                            width: 250px;
                            border-radius: 10px;
                            justify-content: center;
                        }
                        .button-box .active{
                            background: #1aa71a;
                            display: flex;
                            border: 1px solid;
                            border-radius: 10px;
                            padding: 7px;
                            width: 250px;
                            justify-content: center;
                        }
                        .main-new-workflow{
                            display: flex;
                            justify-content: center;
                        }
                        .state-block .top-block {
                            background: #4274da;
                            color: white;
                            display: grid;
                            grid-template-columns: repeat(4, 1fr);
                        }
                        .state-block .top-block div {
                            padding: 10px 20px;
                            border-right: 1px dashed #ffffff;
                            font-size: 0.9rem;
                        }

                    </style>


    <script>
        function addMultipleFiles(input, block_id) {
            let block = document.getElementById(block_id);
            block.innerHTML = "";
            let files = input.files;
            for (let i = 0; i < files.length; i++) {
                let div = document.createElement('div');
                div.innerHTML += files[i].name;
                let viewLink = document.createElement("a");
                viewLink.href = URL.createObjectURL(files[i]);
                viewLink.textContent = "View";
                div.appendChild(viewLink);
                block.appendChild(div);
            }
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

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

    <div class="form-field-head">
        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            {{ Helpers::getDivisionName($data->division_id) }}/ CAPA
        </div>
    </div>

    {{-- ---------------------- --}}
    <div id="change-control-view">
        <div class="container-fluid">

            <div class="inner-block state-block">
                <div class="language-sleect d-flex" style="align-items: center; gap: 20px; margin-left: 20px;">
                    <div>Select Language </div>
                <div class="main-head" id="google_translate_element"></div>
                </div>
                            
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
                <div class="d-flex justify-content-between align-items-center">
                    <div class="main-head">Record Workflow </div>

                    <div class="d-flex" style="gap:20px;">
                        <?php
                        $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => $data->division_id])->get();
                        $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();

                        $cftUsers = DB::table('capa_cfts')
                                    ->where(['capa_id' => $data->id])
                                    ->first();
                                    
                                $columns = [
                                    'Production_person',
                                    'Quality_Control_Person',
                                    'Warehouse_person',
                                    'Engineering_person',
                                    'ResearchDevelopment_person',
                                    'RegulatoryAffair_person',
                                    'CQA_person',
                                    'Microbiology_person',
                                    'QualityAssurance_person',
                                    'SystemIT_person',
                                    'Human_Resource_person',
                                    'Other1_person',
                                ];

                                $valuesArray = [];

                                foreach ($columns as $column) {
                                    $value = $cftUsers->$column;
                                    if ($value !== null && $value != 0) {
                                        $valuesArray[] = $value;
                                    }
                                }
                                $cftCompleteUser = DB::table('capa_cft_responses')
                                    ->whereIn('status', ['In-progress', 'Completed'])
                                    ->where('capa_id', $data->id)
                                    ->where('cft_user_id', Auth::user()->id)
                                    ->whereNull('deleted_at')
                                    ->first();
                       ?>
                        {{-- <button class="button_theme1" onclick="window.print();return false;"
                            class="new-doc-btn">Print</button> --}}
                            {{-- <button class="button_theme1"> <a class="text-white" href="{{ url('CapaAuditTrial', $data->id) }}">
                                Audit Trail </a> </button> --}}
                            <a class="button_theme1 text-white" href="{{ url('CapaAuditTrial', $data->id) }}">
                                Audit Trail
                            </a>

                        @if ($data->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                            <a href="#signature-modal"><button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Propose Plan
                            </button> </a>
                            
                        @elseif($data->stage == 2 && (in_array(4, $userRoleIds) || in_array(18, $userRoleIds)))
                           <a href="#modal1"> <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#modal1">
                                More Info Required
                            </button></a>
                            <a href="#signature-modal"><button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                HOD Review Complete
                            </button></a>
                            <a href="#child-modal1"> <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal1">
                                Child
                            </button></a>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                            {{-- <a href="#cancel-modal"><button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button></a> --}}
                            {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal1">
                                Child
                            </button> --}}
                        @elseif($data->stage == 3 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                              <a href="#modal1"> <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#modal1">
                               More Info Required
                            </button></a>
                           <a href="#signature-modal"> <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            QA/CQA Review Complete
                            </button></a>
                            <a href="#child-modal"><button id="major" type="button" class="button_theme1" data-bs-toggle="modal"
                                data-bs-target="#child-modal">
                                Child
                            </button></a>
                            {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal1">
                                Child
                            </button> --}}
                         @elseif($data->stage == 4 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                          <a href="#signature-modal">  <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Approved
                            </button></a>
                            <a href="#child-modal"><button id="major" type="button" class="button_theme1" data-bs-toggle="modal"
                                data-bs-target="#signature-modal">
                                CFT Review Complete

                            </button></a>
                            <a href="#modal1"> <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#modal1">
                                 More Info Required
                              </button></a>

                        @elseif($data->stage == 5 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                          <a href="#signature-modal">  <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Approved
                            </button></a>
                            <a href="#child-modal"><button id="major" type="button" class="button_theme1" data-bs-toggle="modal"
                                data-bs-target="#child-modal">
                                Child
                            </button></a>
                            <a href="#modal1"> <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#modal1">
                                 More Info Required
                              </button></a>

                        @elseif($data->stage == 6 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                           <a href="#signature-modal"> <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                 Complete
                            </button></a>
                            {{-- <a href="#modal1"> <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#modal1">
                                 More Info Required
                              </button></a> --}}
                            <a href="#child-modal"><button id="major" type="button" class="button_theme1" data-bs-toggle="modal"
                                data-bs-target="#child-modal">
                                Child
                            </button></a>
                            
                        @elseif($data->stage == 7 && (in_array(4, $userRoleIds) || in_array(18, $userRoleIds)))
                           
                            <a href="#signature-modal"> <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                HOD Final Review Complete

                           </button></a>
                           <a href="#modal1"> <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#modal1">
                                More Info Required
                             </button></a>
                             <a href="#child-modal1"> <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal1">
                                Child
                            </button></a>
                             @elseif($data->stage == 8 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                             
                              <a href="#signature-modal"> <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                QA/CQA Closure Review Complete
  
                             </button></a>
                             <a href="#modal1"> <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#modal1">
                                  More Info Required
                               </button></a>
                               <a href="#child-modal"><button id="major" type="button" class="button_theme1" data-bs-toggle="modal"
                                data-bs-target="#child-modal">
                                Child
                            </button></a>
                            @elseif($data->stage == 9 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                             
                            <a href="#signature-modal"> <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                QA/CQA Approval  Complete

                           </button></a>
                           
                           <a href="#modal1"> <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#modal1">
                                More Info Required
                           </button></a>
                           <a href="#child-modal1"> <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal1">
                            Child
                        </button></a>
                           @elseif($data->stage == 10 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                           
                         <a href="#child-modal"><button id="major" type="button" class="button_theme1" data-bs-toggle="modal"
                             data-bs-target="#child-modal1l">
                             Child
                         </button></a>

                        @endif
                         <a class="button_theme1 text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                            </a>
                    </div>
                </div>

            <!-- ----- -------------------- -->
            
            <!-- ---- -------------------- -->

                <div class="status">
                    <div class="head">Current Status</div>
                    @if ($data->stage == 0)
                        <div class="progress-bars">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>
                    @else
                        <div class="progress-bars">
                            @if ($data->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif

                            @if ($data->stage >= 2)
                                <div class="active">HOD Review</div>
                            @else
                                <div class="">HOD Review</div>
                            @endif

                            @if ($data->stage >= 3)
                                <div class="active">QA/CQA Review</div>
                            @else
                                <div class="">QA/CQA Review</div>
                            @endif
                            @if ($data->stage >= 4)
                                <div class="active">CFT Review</div>
                            @else
                                <div class="">CFT Review</div>
                            @endif

                            @if ($data->stage >= 5)
                                <div class="active">QA/CQA Approval</div>
                            @else
                                <div class="">QA/CQA Approval</div>
                            @endif


                            @if ($data->stage >= 6)
                                <div class="active">CAPA In progress</div>
                            @else
                                <div class="">CAPA In progress</div>
                            @endif
                            @if ($data->stage >= 7)
                                <div class="active">HOD Final Review</div>
                            @else
                                <div class="">HOD Final Review</div>
                            @endif
                            @if ($data->stage >= 8)
                            <div class="active">QA/CQA Closure Review</div>
                                @else
                            <div class="">QA/CQA Closure Review</div>
                            @endif
                            @if ($data->stage >= 9)
                            <div class="active">QAH/CQAH Approval </div>
                               @else
                            <div class="">QAH/CQAH Approval </div>
                              @endif
                              @if ($data->stage >= 10)
                              <div class="bg-danger">Closed - Done</div>
                          @else
                              <div class="">Closed - Done</div>
                          @endif
                    @endif


                </div>


                <div class="top-block mt-2">
                    <div><strong> Record Name:&nbsp;</strong>CAPA</div>
                    <div><strong> Site:&nbsp;</strong>{{  Helpers::getDivisionName(session()->get('division')) }}</div>
                    <div><strong> Current Status:&nbsp;</strong>{{ $data->status }}</div>
                    <div><strong> Initiated By:&nbsp;</strong>{{ Helpers::getInitiatorName($data->initiator_id) }}</div>
                </div>
                
                {{-- @endif --}}
                {{-- ---------------------------------------------------------------------------------------- --}}
            </div>
            <div class="modal right fade" id="myModal3" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-titles ml-10">Action Item Workflow</h4>
                        </div>
                        <div  style="" class="modal-body main-new-workflow">
                            <Div class="button-box">
                                @if ($data->stage == 0)
                                <div class="">
                                    <div class="mini_buttons  bg-danger">Closed-Cancelled</div>
                                @else
                                @if ($data->stage >= 1)
                                <div  class="active">
                                    Opened
                                </div>
                                @else
                                <div class="mini_buttons">Opened</div>
                                @endif
                                <div class="down-logo">
                                    <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..." class="w-100 h-100">
                                </div>
                                @if ($data->stage >= 2)

                                <div  class="active">
                                    HOD Review
                                </div> 
                                @else
                                <div  class="mini_buttons">
                                    HOD Review
                                </div>
                                @endif
                                <div class="down-logo">
                                    <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                        class="w-100 h-100">
    
                                </div>
                                @if ($data->stage >= 3)
                                <div  class="active">
                                    QA/CQA Review
                                </div>
                                @else
                                <div  class="mini_buttons">
                                    QA/CQA Review
                                </div>
                                @endif
                                <div class="down-logo">
                                    <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                        class="w-100 h-100">
    
                                </div>
                                @if ($data->stage >= 4)

                                <div  class="active">
                                    QA/CQA Approval
                                </div>
                                @else
                                <div  class="mini_buttons">
                                    QA/CQA Approval
                                </div>
                                @endif

                                <div class="down-logo">
                                    <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                        class="w-100 h-100">
    
                                </div>
                                @if ($data->stage >= 5)

                                <div  class="active">
                                    CAPA In progress
                                </div>
                                @else
                                <div  class="mini_buttons">
                                    CAPA In progress
                                </div>
                                @endif

                                <div class="down-logo">
                                    <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                        class="w-100 h-100">
    
                                </div>
                                @if ($data->stage >= 6)

                                <div  class="active">
                                    HOD Final Review
                                </div>
                                @else
                                <div  class="mini_buttons">
                                    HOD Final Review
                                </div>
                                @endif

                                <div class="down-logo">
                                    <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                        class="w-100 h-100">
    
                                </div>
                                @if ($data->stage >= 7)

                                <div  class="active">
                                    QA/CQA Closure Review
                                </div>
                                @else
                                <div  class="mini_buttons">
                                    QA/CQA Closure Review
                                </div>
                                @endif

                                <div class="down-logo">
                                    <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                        class="w-100 h-100">
    
                                </div>
                                @if ($data->stage >= 8)

                                <div  class="active">
                                    QAH/CQAH Approval
                                </div>
                                @else
                                <div  class="mini_buttons">
                                    QAH/CQAH Approval
                                </div>
                                @endif

                                <div class="down-logo">
                                    <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                        class="w-100 h-100">
    
                                </div>
                                @if ($data->stage >= 9)
                                <div class=" mini_buttons bg-danger">Closed - Done</div>
                            @else
                                <div class="mini_buttons">Closed - Done </div>
                            @endif
                            @endif    
                            </Div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <div class="control-list">

            {{-- ======================================
                    DATA FIELDS
            ======================================= --}}
            <div id="change-control-fields">
                <div class="container-fluid">

                    <!-- Tab links -->
                    <div class="cctab">
                        <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Equipment/Material Info</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm4')">CAPA Details</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm11')">HOD Review</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm12')">QA/CQA Review</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm16')">CFT</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm17')">QA/CQA Approval</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm5')">CAPA Closure</button>
                        {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm8')">Additional Information</button> --}}
                        {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm7')">Group Comments</button> --}}
                        <button class="cctablinks" onclick="openCity(event, 'CCForm13')">HOD Final Review</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm14')">QA/CQA Closure Review</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm15')">QAH/CQAH Approval</button>

                        <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Activity Log</button>
                    </div>

                    <form action="{{ route('capaUpdate', $data->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div id="step-form">

                            <!-- General information content -->
                            <div id="CCForm1" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        {{-- <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="RLS Record Number">Record Number</label>
                                                <input disabled type="text" name="record_number"
                                                    value="{{ Helpers::getDivisionName($data->division_id) }}/CAPA/{{ Helpers::year($data->created_at) }}/{{ $data->record_number ? str_pad($data->record_number->record_number, 4, "0", STR_PAD_LEFT ) : '1' }}">
                                                {{-- <div class="static"></div> --}}
                                            {{-- </div> --}}
                                        {{-- </div> --}}

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="RLS Record Number"><b>Record Number</b></label>
                                                    <input disabled type="text" name="record" id="record"
                                                    value="{{ Helpers::getDivisionName($data->division_id) }}/CAPA/{{ date('Y') }}/{{ $data->record}}">
                                            </div>
                                        </div>
                                        
                                        {{-- <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Division Code">Site/Location Code</label>
                                                <input disabled type="text" name="division_code"
                                                    value="{{ Helpers::getDivisionName($data->division_id) }}">
                                              
                                            </div>
                                        </div> --}}
                                        {{-- <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Division Code">Site/Location Code</label>
                                                <input readonly type="text" name="division_code"  id="division_code"
                                                    value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                                <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                                {{-- <div class="static">{{ Helpers::getDivisionName(session()->get('division')) }}</div> 
                                            </div>
                                        </div> --}}
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Site/Location Code</b></label>
                                                <input readonly type="text" name="division_code"
                                                    value="{{ Helpers::getDivisionName($data->division_id) }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Initiator">Initiator</label>
                                                <input disabled type="text" name="initiator_id"
                                                    value="{{ $data->initiator_name }}">
                                                {{-- <div class="static"> </div> --}}
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due"><b>Date of Initiation</b></label>
                                                @php
                                                    $formattedDate = \Carbon\Carbon::parse($data->intiation_date)->format('j-F-Y');
                                                @endphp
                                                <input disabled type="text" value="{{ $formattedDate }}" name="intiation_date_display">
                                                <input type="hidden" value="{{ date('d-m-Y') }}" name="intiation_date">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="group-input">
                                                <label for="search">
                                                    Assigned To <span class="text-danger"></span>
                                                </label>
                                                <select id="select-state" placeholder="Select..." name="assign_to"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : ''}} >
                                                    <option value="">Select a value</option>
                                                    @foreach ($users as $value)
                                                        <option {{ $data->assign_to == $value->name ? 'selected' : '' }}
                                                            value="{{ $value->name }}">{{ $value->name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                        <!-- <div class="col-md-6">
                                            <div class="group-input">
                                                <label for="due-date">Due Date <span class="text-danger">*</span></label>
                                                <div><small class="text-primary">If revising Due Date, kindly mention revision reason in "Due Date Extension Justification" data field.</small></div>
                                                @if (!empty($revised_date))
                                                <input readonly type="text"
                                                value="{{ Helpers::getdateFormat($revised_date) }}">
                                                @else
                                                <input disabled type="text"
                                                value="{{ Helpers::getdateFormat($data->due_date) }}">
                                                @endif

                                            </div>
                                        </div> -->
                                        {{-- <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="due-date">Due Date <span class="text-danger"></span></label>
                                        <div><small class="text-primary">If revising Due Date, kindly mention revision reason in "Due Date Extension Justification" data field.</small></div>
                                        <input readonly type="text"
                                            value="{{ Helpers::getdateFormat($data->due_date) }}"
                                            name="due_date"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : ''}}>
                                        {{-- <input type="text" value="{{ $data->due_date }}" name="due_date"> --}}
                                        {{-- <div class="static"> {{ $due_date }}</div> --}}

                                    {{-- </div>
                                </div> --}} 
                                
                                <div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="due-date">Due Date <span class="text-danger">*</span></label>
                                        <div class="calenderauditee">
                                            <!-- Format ki hui date dikhane ke liye readonly input -->
                                            <input  type="text" id="due_date_display" readonly placeholder="DD-MM-YYYY" value="{{ Helpers::getDueDate123($data->intiation_date, true) }}" />
                                            <!-- Hidden input date format ke sath -->
                                            <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ Helpers::getDueDate123($data->intiation_date, true, 'Y-m-d') }}" class="hide-input" readonly />
                                        </div>
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
                                    </script>
                                    
                                    <style>
                                    .hide-input {
                                        display: none;
                                    }
                                    </style>
                                    
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Initiator Group">Department Group </label>
                                                <select name="initiator_Group" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}
                                                     id="initiator_group">
                                                     <option value="">-- Select --</option>
                                                    <option value="CQA"
                                                        @if ($data->initiator_group_code== 'CQA') selected @endif>Corporate Quality Assurance</option>
                                                    <option value="QAB"
                                                        @if ($data->initiator_group_code== 'QAB') selected @endif>Quality Assurance Biopharma</option>
                                                    <option value="CQC"
                                                        @if ($data->initiator_group_code== 'CQC') selected @endif>Central Quality Control</option>
                                                    <option value="CQC"
                                                        @if ($data->initiator_group_code== 'CQC') selected @endif>Manufacturing
                                                    </option>
                                                    <option value="PSG"
                                                        @if ($data->initiator_group_code== 'PSG') selected @endif>Plasma Sourcing Group</option>
                                                    <option value="CS"
                                                        @if ($data->initiator_group_code== 'CS') selected @endif>Central Stores</option>
                                                    <option value="ITG"
                                                        @if ($data->initiator_group_code== 'ITG') selected @endif>Information Technology Group</option>
                                                    <option value="MM"
                                                        @if ($data->initiator_group_code== 'MM') selected @endif>Molecular Medicine</option>
                                                    <option value="CL"
                                                        @if ($data->initiator_group_code== 'CL') selected @endif>Central Laboratory</option>
                                                    <option value="TT"
                                                        @if ($data->initiator_group_code== 'TT') selected @endif>Tech Team</option>
                                                    <option value="QA"
                                                        @if ($data->initiator_group_code== 'QA') selected @endif>Quality Assurance</option>
                                                    <option value="QM"
                                                        @if ($data->initiator_group_code== 'QM') selected @endif>Quality Management</option>
                                                    <option value="IA"
                                                        @if ($data->initiator_group_code== 'IA') selected @endif>IT Administration</option>
                                                    <option value="ACC"
                                                        @if ($data->initiator_group_code== 'ACC') selected @endif>Accounting
                                                    </option>
                                                    <option value="LOG"
                                                        @if ($data->initiator_group_code== 'LOG') selected @endif>Logistics
                                                    </option>
                                                    <option value="SM"
                                                        @if ($data->initiator_group_code== 'SM') selected @endif>Senior Management</option>
                                                    <option value="BA"
                                                        @if ($data->initiator_group_code== 'BA') selected @endif>Business Administration</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Initiator Group Code">Department Group Code</label>
                                                <input readonly type="text" name="initiator_group_code"{{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}
                                                    value="{{ $data->initiator_group_code}}" id="initiator_group_code"
                                                    readonly>
                                                {{-- <div class="static"></div> --}}
                                            </div>
                                        </div>
                                        {{-- <div class="col-12">
                                            <div class="group-input">
                                                <label for="Short Description">Short Description <span
                                                        class="text-danger">*</span></label>
                                                        <div><small class="text-primary">Please mention brief summary</small></div>
                                                <textarea name="short_description"{{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>{{ $data->short_description }}</textarea>
                                            </div>
                                        </div> --}}
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Short Description">Short Description<span
                                                        class="text-danger">*</span></label><span id="rchars">255</span>
                                                characters remaining

                                                <input name="short_description"   id="docname" type="text" value="{{ $data->short_description }}"    maxlength="255" required  {{ $data->stage == 0 || $data->stage == 6 ? "disabled" : "" }} type="text">
                                            </div>
                                            <p id="docnameError" style="color:red">**Short Description is required</p>

                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="priority_data">Priority</label>
                                                <select name="priority_data" placeholder="Select Reference Records"
                                                    data-search="false" data-silent-initial-value-set="true"
                                                    id="priority_data">
                                                    <option value="">--Select--</option>
                                                    <option {{ $data->priority_data == 'High' ? 'selected' : '' }}
                                                        value="High">High</option>
                                                    <option {{ $data->priority_data == 'Medium' ? 'selected' : '' }}
                                                        value="Medium">Medium</option>
                                                    <option {{ $data->priority_data == 'Low' ? 'selected' : '' }}
                                                        value="Low">Low</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="priority_data Department">Initial Categorization</label>
                                                <select name="Initial_Categorization" id="Initial_Categorization">
                                                    <option value="">--Select--</option>
                                                    <option value="Major" {{ $data->Initial_Categorization == 'Major' ? 'selected' : '' }}>Major</option>
                                                    <option value="Minor" {{ $data->Initial_Categorization == 'Minor' ? 'selected' : '' }}>Minor</option>
                                                    <option value="Critical" {{ $data->Initial_Categorization == 'Critical' ? 'selected' : '' }}>Critical</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Product">Product Name</label>
                                                <input  type="text" id="product_name" name="product_name"  {{ $data->stage == 0 || $data->stage == 13 ? 'disabled' : '' }} value="{{ $data->product_name }}" maxlength="255">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="CAPA Source & Number">CAPA Source & Number</label>
                                                <input  type="number" id="capa_source_number" name="capa_source_number"  {{ $data->stage == 0 || $data->stage == 13 ? 'disabled' : '' }} value="{{ $data->capa_source_number }}" maxlength="255">
                                            </div>
                                        </div>
                                       
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Initiator Group">Initiated Through</label>
                                                <div><small class="text-primary">Please select related information</small></div>
                                                <select name="initiated_through"{{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}
                                                    onchange="otherController(this.value, 'others', 'initiated_through_req')">
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option @if ($data->initiated_through == 'internal_audit') selected @endif
                                                        value="internal_audit">Internal Audit</option>
                                                        <option @if ($data->initiated_through == 'external_audit') selected @endif
                                                        value="external_audit">External Audit</option>
                                                    <option @if ($data->initiated_through == 'recall') selected @endif
                                                        value="recall">Recall</option>
                                                    <option @if ($data->initiated_through == 'return') selected @endif
                                                        value="return">Return</option>
                                                    <option @if ($data->initiated_through == 'deviation') selected @endif
                                                        value="deviation">Deviation</option>
                                                    <option @if ($data->initiated_through == 'complaint') selected @endif
                                                        value="complaint">Complaint</option>
                                                    <option @if ($data->initiated_through == 'regulatory') selected @endif
                                                        value="regulatory">Regulatory</option>
                                                    <option @if ($data->initiated_through == 'lab-incident') selected @endif
                                                        value="lab-incident">Lab Incident</option>
                                                    <option @if ($data->initiated_through == 'improvement') selected @endif
                                                        value="improvement">Improvement</option>
                                                    <option @if ($data->initiated_through == 'process_product') selected @endif
                                                        value="process_product">Process/Product</option>
                                                    <option @if ($data->initiated_through == 'supplier') selected @endif
                                                         value="supplier">Supplier</option>
                                                    <option @if ($data->initiated_through == 'gmp_invastigation') selected @endif
                                                    value="gmp_invastigation">GMP Investigation</option>
                                                    <option @if ($data->initiated_through == 'discreoancy_nc') selected @endif
                                                        value="discreoancy_nc">Discrepancy/NC</option>
                                                    <option @if ($data->initiated_through == 'change_control') selected @endif
                                                         value="change_control">Change Control</option>
                                                    <option @if ($data->initiated_through == 'utility_quipment_system') selected @endif
                                                            value="utility_quipment_system">Utility/Equipment/System</option>
                                                    <option @if ($data->initiated_through == 'oos') selected @endif
                                                             value="oos">OOS</option>
                                                        <option @if ($data->initiated_through == 'product_failure') selected @endif
                                                            value="product_failure">Product Failure</option>
                                                            <option @if ($data->initiated_through == 'apqr') selected @endif
                                                                value="apqr">APQR</option>
                                                    <option @if ($data->initiated_through == 'others') selected @endif
                                                        value="others">Others</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input" id="initiated_through_req">
                                                <label for="initiated_through">Others<span
                                                        class="text-danger d-none">*</span></label>
                                                <textarea name="initiated_through_req"{{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}> {{ $data->initiated_through_req }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="repeat">Repeat</label>
                                                <div><small class="text-primary">Please select yes if it is has recurred in past six months</small></div>
                                                <select name="repeat"{{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}
                                                    onchange="otherController(this.value, 'Yes', 'repeat_nature')">
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option @if ($data->repeat == 'Yes') selected @endif
                                                        value="Yes">Yes</option>
                                                    <option @if ($data->repeat == 'No') selected @endif
                                                        value="No">No</option>
                                                    <option @if ($data->repeat == 'NA') selected @endif
                                                        value="NA">NA</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input" id="repeat_nature">
                                                <label for="repeat_nature">Repeat Nature<span
                                                        class="text-danger d-none">*</span></label>
                                                <textarea name="repeat_nature"{{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>{{ $data->repeat_nature }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Problem Description">Problem Description</label>
                                                <textarea name="problem_description"{{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>{{ $data->problem_description }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="CAPA Team">CAPA Team</label>
                                                <select {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}
                                                    multiple id="Audit" placeholder="Select..." name="capa_team[]">
                                                    @foreach ($users as $value)
                                                     {{-- <option {{ $data->capa_team == $value->id ? 'selected' : '' }}  value="{{ $value->id }}">{{ $value->name }}</option>  --}}
                                                        <option value="{{ $value->id }}"{{ in_array($value->id, explode(',', $data->capa_team)) ? 'selected' : '' }}>
                                                                   {{ $value->name }}
                                                        </option>
                                                    @endforeach
                                                </select>


                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Reference Records">Reference Records</label>
                                                <select {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}
                                                    multiple id="capa_related_record" name="capa_related_record[]"
                                                    id="">
                                                    @if (!empty($old_record))
                                                    @foreach ($old_record as $new)
                                                    @php
                                                                $recordValue =
                                                                    Helpers::getDivisionName($new->division_id) .
                                                                    '/AI/' .
                                                                    date('Y') .
                                                                    '/' .
                                                                    Helpers::recordFormat($new->record);
                                                                $selected = in_array(
                                                                    $recordValue,
                                                                    explode(',', $data->capa_related_record),
                                                                )
                                                                    ? 'selected'
                                                                    : '';
                                                            @endphp
                                                       <option value="{{ $recordValue }}" {{ $selected }}>
                                                        {{ $recordValue }}
                                                    </option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                      
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Initial Observation">Initial Observation</label>

                                                <textarea name="initial_observation" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>{{ $data->initial_observation }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Interim Containnment">Interim Containnment</label>
                                                <select name="interim_containnment"
                                                    onchange="otherController(this.value, 'required', 'containment_comments')"
                                                    {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option
                                                        {{ $data->interim_containnment == 'required' ? 'selected' : '' }}
                                                        value="required">Required</option>
                                                    <option
                                                        {{ $data->interim_containnment == 'not-required' ? 'selected' : '' }}
                                                        value="not-required">Not Required</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input" id="containment_comments">
                                                <label for="Containment Comments">
                                                    Containment Comments <span class="text-danger d-none">*</span>
                                                </label>
                                                <textarea name="containment_comments" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>{{ $data->containment_comments }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="CAPA Attachments">CAPA Attachment</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                {{-- <input type="file" id="myfile" name="capa_attachment"
                                                    {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}> --}}
                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="capa_attachment">

                                                        {{-- @if (is_array($data->capa_attachment)) --}}
                                                        @if ($data->capa_attachment)
                                                            @foreach (json_decode($data->capa_attachment) as $file)
                                                                <h6 type="button" class="file-container text-dark"
                                                                    style="background-color: rgb(243, 242, 240);">
                                                                    <b>{{ $file }}</b>
                                                                    <a href="{{ asset('upload/' . $file) }}"
                                                                        target="_blank"><i class="fa fa-eye text-primary"
                                                                            style="font-size:20px; margin-right:-10px;"></i></a>
                                                                    <a type="button" class="remove-file"
                                                                        data-file-name="{{ $file }}"><i
                                                                            class="fa-solid fa-circle-xmark"
                                                                            style="color:red; font-size:20px;"></i></a>
                                                                </h6>
                                                            @endforeach
                                                        {{-- @endif --}}
                                                        @endif
                                                    </div>
                                                    <div class="add-btn">
                                                        <div>Add</div>
                                                        <input
                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}
                                                            type="file" id="myfile" name="capa_attachment[]"
                                                            oninput="addMultipleFiles(this, 'capa_attachment')" multiple>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="col-12">
                                            <div class="group-input">
                                                <label for="CAPA QA Comments">CAPA QA Review </label>
                                                <textarea name="capa_qa_comments" {{ $data->stage == 3  ? 'required' : '' } {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>{{ $data->capa_qa_comments }}</textarea>
                                            </div>
                                        </div> --}}

                                        <div class="col-12 sub-head">
                                            Investigation & Root Cause Analysis Summary 
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Details">Investigation </label>
                                                {{-- <input type="text" name="investigation" value="{{ $data->investigation }}"> --}}
                                                <textarea name="investigation" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>{{ $data->investigation }}</textarea>
                                            </div>
                                            <div class="group-input">
                                                <label for="Details">Root Cause Analysis  </label>
                                                {{-- <input type="text" name="rcadetails" value="{{ $data->rcadetails }}"> --}}
                                                <textarea name="rcadetails" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>{{ $data->rcadetails }}</textarea>

                                            </div>
                                        </div>


                                    </div>
                                    <div class="button-block">
                                        <button type="submit" id="ChangesaveButton" class="saveButton"
                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}> Save</button>
                                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a class="text-white"
                                                href="{{ url('rcms/qms-dashboard') }}"> Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Information content -->
                            <div id="CCForm2" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        {{-- <div class="col-12 sub-head">
                                            Product Details
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Product Details">
                                                    Product Details<button type="button" name="ann"
                                                    id="product"
                                                        {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>+</button>
                                                </label>
                                                <table class="table table-bordered" id="product_details">
                                                    <thead>
                                                        <tr>
                                                            <th>Row #</th>
                                                            <th>Product Name</th>
                                                            <th>Batch No./Lot No./AR No.</th>
                                                            <th>Manufacturing Date</th>
                                                            <th>Date Of Expiry</th>
                                                            <th>Batch Disposition Decision</th>
                                                            <th>Remark</th>
                                                            <th>Batch Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                        @if ($data1->product_name)
                                                        @foreach (unserialize($data1->product_name) as $key => $temps)
                                                        <tr>
                                                            <td><input type="text" name="serial_number[]"
                                                                    value="{{ $key + 1 }}"></td>
                                                            <td><input type="text" name="product_name[]"
                                                                    value="{{ unserialize($data1->product_name)[$key] ? unserialize($data1->product_name)[$key] : '' }}">
                                                            </td>
                                                            <td><input type="text" name="batch_no[]"
                                                                    value="{{ unserialize($data1->batch_no)[$key] ? unserialize($data1->batch_no)[$key] : '' }}">
                                                            </td>
                                                            <td><input type="text" name="mfg_date[]"
                                                                    value="{{ unserialize($data1->mfg_date)[$key] ? unserialize($data1->mfg_date)[$key] : '' }}">
                                                            </td>
                                                            <td><input type="text" name="expiry_date[]"
                                                                    value="{{ unserialize($data1->expiry_date)[$key] ? unserialize($data1->expiry_date)[$key] : '' }}">
                                                            </td>
                                                            <td><input type="text" name="batch_desposition[]"
                                                                    value="{{ unserialize($data1->batch_desposition)[$key] ? unserialize($data1->batch_desposition)[$key] : '' }}">
                                                            </td>
                                                            <td><input type="text" name="remark[]"
                                                                    value="{{ unserialize($data1->remark)[$key] ? unserialize($data1->remark)[$key] : '' }}">
                                                            </td>
                                                            <td><input type="text" name="batch_status[]"
                                                                    value="{{ unserialize($data1->batch_status)[$key] ? unserialize($data1->batch_status)[$key] : '' }}">
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        @endif

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div> --}}
                                        



                                        {{-- new added product table --}}
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="severity-level">Severity Level</label>
                                                <span class="text-primary">Severity levels in a QMS record gauge issue seriousness, guiding priority for corrective actions. Ranging from low to high, they ensure quality standards and mitigate critical risks.</span>
                                                <select {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }} name="severity_level_form">
                                                    <option  value="">-- Select --</option>
                                                    <option @if ($data->severity_level_form=='minor') selected @endif value="minor">Minor</option>
                                                    <option @if ($data->severity_level_form=='major') selected @endif value="major">Major</option>
                                                    <option @if ($data->severity_level_form=='critical') selected @endif value="critical">Critical</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 sub-head">
                                            Product Material Details
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Material Details">
                                                    Product Material Details
                                                    <button type="button" name="ann" id="material" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>+</button>
                                                </label>
                                                <table class="table table-bordered" id="productmaterial">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 40px">Row #</th>
                                                            <th>Product Material Name</th>
                                                            <th>Product Batch No./Lot No./AR No.</th>
                                                            <th>Product Manufacturing Date</th>
                                                            <th>Product Date Of Expiry</th>
                                                            <th>Product Batch Disposition Decision</th>
                                                            <th>Product Remark</th>
                                                            <th>Product Batch Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (!empty($data2->material_name))
                                                                @foreach (unserialize($data2->material_name) as $key => $material_name)
                                                                    <tr>
                                                                        <td><input disabled type="text" name="serial_number[]" value="{{ $key + 1 }}"></td>
                                                                        <td><input type="text" name="material_name[]" value="{{ $material_name }}"></td>
                                                                        {{-- <td>
                                                                            <select name="material_name[]" class="material_name" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                                <option value="" >-- Select value --</option>
                                                                                <option value="PLACEBEFOREBIMATOPROSTOPH.SOLO.01%W/" {{ $material_name == 'PLACEBEFOREBIMATOPROSTOPH.SOLO.01%W/' ? 'selected' : '' }}>PLACEBEFOREBIMATOPROSTOPH.SOLO.01%W/</option>
                                                                                <option value="BIMATOPROSTANDTIMOLOLMALEATEEDSOLUTION" {{ $material_name == 'BIMATOPROSTANDTIMOLOLMALEATEEDSOLUTION' ? 'selected' : '' }}>BIMATOPROSTANDTIMOLOLMALEATEEDSOLUTION</option>
                                                                                <option value="CAFFEINECITRATEORALSOLUTION USP 60MG/3ML" {{ $material_name == 'CAFFEINECITRATEORALSOLUTION USP 60MG/3ML' ? 'selected' : '' }}>CAFFEINECITRATEORALSOLUTION USP 60MG/3ML</option>
                                                                                <option value="BRIMONIDINE TART. OPH SOL 0.1%W/V (CB)" {{ $material_name == 'BRIMONIDINE TART. OPH SOL 0.1%W/V (CB)' ? 'selected' : '' }}>BRIMONIDINE TART. OPH SOL 0.1%W/V (CB)</option>
                                                                                <option value="DORZOLAMIDEPFREE20MG/MLEDSOLSINGLEDOSECO" {{ $material_name == 'DORZOLAMIDEPFREE20MG/MLEDSOLSINGLEDOSECO' ? 'selected' : '' }}>DORZOLAMIDEPFREE20MG/MLEDSOLSINGLEDOSECO</option>
                                                                            </select>
                                                                        </td> --}}
                                                                        <td><input type="text" name="material_batch_no[]" value="{{ unserialize($data2->material_batch_no)[$key] ?? '' }}"></td>
                                                                        {{-- <td>
                                                                            <select name="material_batch_no[]" class="batch_no" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                                <option value="">select value</option>
                                                                                <option value="DCAU0030" {{ unserialize($data2->material_batch_no)[$key] == 'DCAU0030' ? 'selected' : '' }}>DCAU0030</option>
                                                                                <option value="BDZH0007" {{ unserialize($data2->material_batch_no)[$key] == 'BDZH0007' ? 'selected' : '' }}>BDZH0007</option>
                                                                                <option value="BDZH0006" {{ unserialize($data2->material_batch_no)[$key] == 'BDZH0006' ? 'selected' : '' }}>BDZH0006</option>
                                                                                <option value="BJJH0004A" {{ unserialize($data2->material_batch_no)[$key] == 'BJJH0004A' ? 'selected' : '' }}>BJJH0004A</option>
                                                                                <option value="DCAU0036" {{ unserialize($data2->material_batch_no)[$key] == 'DCAU0036' ? 'selected' : '' }}>DCAU0036</option>
                                                                            </select>
                                                                        </td> --}}
                                                                        <td><input type="month" name="material_mfg_date[]" value="{{ unserialize($data2->material_mfg_date)[$key] ?? '' }}" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}></td>
                                                                        <td><input type="month" name="material_expiry_date[]" value="{{ unserialize($data2->material_expiry_date)[$key] ?? '' }}" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}></td>
                                                                        <td><input type="text" name="material_batch_desposition[]" value="{{ unserialize($data2->material_batch_desposition)[$key] ?? '' }}" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}></td>
                                                                        <td><input type="text" name="material_remark[]" value="{{ unserialize($data2->material_remark)[$key] ?? '' }}" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}></td>
                                                                        {{-- <td><input type="text" name="material_batch_status[]" value="{{ unserialize($data2->material_batch_status)[$key] ?? '' }}"></td> --}}
                                                                        <td>
                                                                            <select name="material_batch_status[]" class="batch_status" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                                <option value="">-- Select value --</option>
                                                                                <option value="Hold" {{ unserialize($data2->material_batch_status)[$key] == 'Hold' ? 'selected' : '' }}>Hold</option>
                                                                                <option value="Release" {{ unserialize($data2->material_batch_status)[$key] == 'Release' ? 'selected' : '' }}>Release</option>
                                                                                <option value="quarantine" {{ unserialize($data2->material_batch_status)[$key] == 'quarantine' ? 'selected' : '' }}>Quarantine</option>
                                                                            </select>
                                                                        </td>
                                                                        <td><button type="button" class="removeRowBtn" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>Remove</button></td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <script>productmaterial
                                            $(document).ready(function () {
                                                $('#material').click(function (e) {
                                                    e.preventDefault();
                                                    
                                                    // Clone the first row
                                                    var newRow = $('#productmaterial tbody tr:first').clone();
                                                    
                                                    // Update the serial number
                                                    var lastSerialNumber = parseInt($('#productmaterial tbody tr:last input[name="serial_number[]"]').val());
                                                    newRow.find('input[name="serial_number[]"]').val(lastSerialNumber + 1);
                                                    
                                                    // Clear inputs in the new row
                                                    newRow.find('input[name="material_name[]"]').val('');
                                                    newRow.find('input[name="material_batch_no[]"]').val('');
                                                    newRow.find('input[name="material_mfg_date[]"]').val('');
                                                    newRow.find('input[name="material_expiry_date[]"]').val('');
                                                    newRow.find('input[name="material_batch_desposition[]"]').val('');
                                                    newRow.find('input[name="material_remark[]"]').val('');
                                                    newRow.find('input[name="material_batch_status[]"]').val('');
                                                    
                                                    // Clear selected options in the new row
                                                    newRow.find('select').prop('selectedIndex', 0);
                                                    
                                                    // Append the new row to the table body
                                                    $('#productmaterial tbody').append(newRow);
                                                });
                                                
                                                // Remove row functionality
                                                $(document).on('click', '.removeRowBtn', function() {
                                                    $(this).closest('tr').remove();
                                                    
                                                    // Update serial numbers after removing a row
                                                    $('#productmaterial tbody tr').each(function(index) {
                                                        $(this).find('input[name="serial_number[]"]').val(index + 1);
                                                    });
                                                });
                                            });
                                        </script>
                                        
                                        
                                        {{-- new added product table --}}

                                    
                                        {{-- <script>
                                            $(document).ready(function() {
                                                $('#add-row-btn').click(function() {
                                                    addRow('root-cause-first-table');
                                                });
                                    
                                                $(document).on('click', '.removeRowBtn', function() {
                                                    $(this).closest('tr').remove();
                                                    updateSerialNumbers();
                                                });
                                    
                                                updateSerialNumbers();
                                            });
                                    
                                            function addRow(tableId) {
                                                var table = document.getElementById(tableId);
                                                var tbody = table.getElementsByTagName('tbody')[0];
                                                var currentRowCount = tbody.rows.length;
                                    
                                                var newRow = tbody.insertRow(currentRowCount);
                                    
                                                var cell1 = newRow.insertCell(0);
                                                cell1.innerHTML = '<input disabled type="text" name="serial_number[]" value="' + (currentRowCount + 1) + '">';
                                    
                                                var cell2 = newRow.insertCell(1);
                                                cell2.innerHTML = '<input type="text" name="material_name[]">';
                                    
                                                var cell3 = newRow.insertCell(2);
                                                cell3.innerHTML = '<input type="text" name="material_batch_no[]">';
                                    
                                                var cell4 = newRow.insertCell(3);
                                                cell4.innerHTML = '<input type="text" name="material_mfg_date[]">';
                                    
                                                var cell5 = newRow.insertCell(4);
                                                cell5.innerHTML = '<input type="text" name="material_expiry_date[]">';
                                    
                                                var cell6 = newRow.insertCell(5);
                                                cell6.innerHTML = '<input type="text" name="material_batch_desposition[]">';
                                    
                                                var cell7 = newRow.insertCell(6);
                                                cell7.innerHTML = '<input type="text" name="material_remark[]">';
                                    
                                                var cell8 = newRow.insertCell(7);
                                                cell8.innerHTML = '<input type="text" name="material_batch_status[]">';
                                    
                                                var cell9 = newRow.insertCell(8);
                                                cell9.innerHTML = '<button type="button" class="removeRowBtn">Remove</button>';
                                    
                                                updateSerialNumbers();
                                            }
                                    
                                            function updateSerialNumbers() {
                                                var table = document.getElementById('root-cause-first-table').getElementsByTagName('tbody')[0];
                                                for (var i = 0; i < table.rows.length; i++) {
                                                    table.rows[i].cells[0].getElementsByTagName('input')[0].value = i + 1;
                                                }
                                            }
                                        </script> --}}
                                        
                                        
                                        
                                        
                                        
                                        <div class="col-12 sub-head">
                                            Equipment/Instruments Details
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Material Details">
                                                    Equipment/Instruments Details<button type="button" name="ann"
                                                       id="equipment_add_new"
                                                        {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>+</button>
                                                </label>
                                                <table class="table table-bordered" id="equi_details_new_n">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 40px">Row #</th>
                                                            <th>Equipment/Instruments Name</th>
                                                            <th>Equipment/Instruments ID</th>
                                                            <th>Equipment/Instruments Comments</th>
                                                            <th>Action</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($data3 && $data3->equipment)
                                                        @foreach (unserialize($data3->equipment) as $key => $temps)
                                                            <tr>
                                                                <td>
                                                                    <input type="" name="serial_number[]" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}
                                                                           value="{{ $key + 1 }}" disabled>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="equipment[]" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}
                                                                           value="{{ unserialize($data3->equipment)[$key] ?? '' }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="equipment_instruments[]" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}
                                                                           value="{{ unserialize($data3->equipment_instruments)[$key] ?? '' }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="equipment_comments[]" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}
                                                                           value="{{ unserialize($data3->equipment_comments)[$key] ?? '' }}">
                                                                </td>
                                                                <td>
                                                                    <button type="button" class="removeRowBtn" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>Remove</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                    
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <script>
                                            $(document).ready(function () {
                                                $('#equipment_add_new').click(function (e) {
                                                    e.preventDefault();
                                                    
                                                    // Clone the first row
                                                    var newRow = $('#equi_details_new_n tbody tr:first').clone();
                                                    
                                                    // Update the serial number
                                                    var lastSerialNumber = parseInt($('#equi_details_new_n tbody tr:last input[name="serial_number[]"]').val());
                                                    newRow.find('input[name="serial_number[]"]').val(lastSerialNumber + 1);
                                                    
                                                    // Clear inputs in the new row
                                                    newRow.find('input[name="equipment[]"]').val('');
                                                    newRow.find('input[name="equipment_instruments[]"]').val('');
                                                    newRow.find('input[name="equipment_comments[]"]').val('');
                                                    
                                                    // Append the new row to the table body
                                                    $('#equi_details_new_n tbody').append(newRow);
                                           
                                                
                                                // Remove row functionality
                                                $(document).on('click', '.removeRowBtn', function() {
                                                    $(this).closest('tr').remove();
                                                    
                                                  
                                                });
                                                  // Update serial numbers after removing a row
                                                  $('#equi_details_new_n tbody tr').each(function(index) {
                                                        $(this).find('input[name="serial_number[]"]').val(index + 1);
                                                    });
                                            });
                                        });
                                        </script>
                                        

                                        <div class="col-12 sub-head">
                                            Other type CAPA Details
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Details">Details</label>
                                                {{-- <input type="text" name="details_new"
                                                    {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}
                                                    value="{{ $data->details_new }}"> --}}
                                                    <textarea name="details_new" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>{{ $data->details_new }}</textarea>

                                            </div>
                                        </div>
                                      
                                        {{-- <div class="col-12">
                                            <div class="group-input">
                                                <label for="Comments"> CAPA QA Review </label>
                                                <textarea name="capa_qa_comments2" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>{{ $data->capa_qa_comments2 }}</textarea>
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton"
                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>Save</button>
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a class="text-white"
                                                href="{{ url('rcms/qms-dashboard') }}"> Exit </a> </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Capa Detais-->
                            <div id="CCForm4" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="search">
                                            CAPA Type<span class="text-danger"></span>
                                        </label>
                                        <select id="select-state" placeholder="Select..." name="capa_type"{{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                            <option value="">Select a value</option>
                                            <option {{ $data->capa_type == "Corrective Action" ? 'selected' : '' }} value="Corrective Action">Corrective Action</option>
                                            <option {{ $data->capa_type == "Preventive Action" ? 'selected' : '' }} value="Preventive Action">Preventive Action</option>
                                            <option {{ $data->capa_type == "Corrective & Preventive Action"  ? 'selected' : '' }} value="Corrective & Preventive Action">Corrective & Preventive Action</option>

                                        </select>
                                        @error('assign_to')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Corrective Action">Corrective Action</label>
                                                <textarea name="corrective_action" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>{{ $data->corrective_action }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Preventive Action">Preventive Action</label>
                                                <textarea name="preventive_action" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>{{ $data->preventive_action }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Closure Attachments">File Attachment</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting
                                                        documents</small></div>
                                                {{-- <input multiple type="file" id="myfile" name="closure_attachment[]"> --}}
                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="capafileattachement">
                                                        @if ($data->capafileattachement)
                                                        @foreach (json_decode($data->capafileattachement) as $file)
                                                            <h6 type="button" class="file-container text-dark"
                                                                style="background-color: rgb(243, 242, 240);">
                                                                <b>{{ $file }}</b>
                                                                <a href="{{ asset('upload/' . $file) }}"
                                                                    target="_blank"><i class="fa fa-eye text-primary"
                                                                        style="font-size:20px; margin-right:-10px;"></i></a>
                                                                <a type="button" class="remove-file"
                                                                    data-file-name="{{ $file }}"><i
                                                                        class="fa-solid fa-circle-xmark"
                                                                        style="color:red; font-size:20px;"></i></a>
                                                            </h6>
                                                        @endforeach
                                                    {{-- @endif --}}
                                                    @endif
                                                    </div>
                                                    <div class="add-btn">
                                                        <div>Add</div>
                                                        <input type="file" id="qafile" name="capafileattachement[]"
                                                            oninput="addMultipleFiles(this, 'capafileattachement')" multiple {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton"
                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>Save</button>
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a class="text-white"
                                                href="{{ url('rcms/qms-dashboard') }}"> Exit </a> </button>
                                    </div>
                                </div>
                            </div>
                       



                            <!-- Project Study content -->
                          
                              




{{-- ===========================================HOd reviwe tab ============= tab --}}

<div id="CCForm11" class="inner-block cctabcontent">
    <div class="inner-block-content">
        <div class="row">
            <div class="col-12">
                <div class="group-input">
                    <label for="QA Review & Closure">HOD Remark @if($data->stage == 2) <span class="text-danger">*</span>@endif</label>
                    <textarea name="hod_remarks" {{ $data->stage == 2  ? 'required' : '' }} {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>{{ $data->hod_remarks}}</textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="group-input">
                    <label for="Closure Attachments">HOD Attachment</label>
                    <div><small class="text-primary">Please Attach all relevant or supporting
                            documents</small>
                        </div>
                    {{-- <input multiple type="file" id="myfile" name="closure_attachment[]"> --}}
                    <div class="file-attachment-field">
                        <div class="file-attachment-list" id="hod_attachment">
                            @if ($data->hod_attachment)
                            @foreach (json_decode($data->hod_attachment) as $file)
                                <h6 type="button" class="file-container text-dark"
                                    style="background-color: rgb(243, 242, 240);">
                                    <b>{{ $file }}</b>
                                    <a href="{{ asset('upload/' . $file) }}"
                                        target="_blank"><i class="fa fa-eye text-primary"
                                            style="font-size:20px; margin-right:-10px;"></i></a>
                                    <a type="button" class="remove-file"
                                        data-file-name="{{ $file }}"><i
                                            class="fa-solid fa-circle-xmark"
                                            style="color:red; font-size:20px;"></i></a>
                                </h6>
                            @endforeach
                        {{-- @endif --}}
                        @endif
                        </div>
                        <div class="add-btn">
                            <div>Add</div>
                            <input type="file" id="myfile" name="hod_attachment[]"
                                oninput="addMultipleFiles(this, 'hod_attachment')" multiple {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="col-12 sub-head">
                Effectiveness Check Details
            </div> -->
            <!-- <div class="col-12">
                <div class="group-input">
                    <label for="Effectiveness Check Required">Effectiveness Check
                        Required?</label>
                    <select name="effect_check" onChange="setCurrentDate(this.value)">
                        <option value="">Enter Your Selection Here</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
            </div> -->
            <!-- <div class="col-6 new-date-data-field">
                <div class="group-input input-date">
                    <label for="EffectCheck Creation Date">Effectiveness Check Creation Date</label>
                    {{-- <input type="date" name="effect_check_date"> --}}
                    <div class="calenderauditee">
                        <input type="text" name="effect_check_date" id="effect_check_date" readonly
                            placeholder="DD-MMM-YYYY" />
                        <input type="date" name="effect_check_date" class="hide-input"
                            oninput="handleDateInput(this, 'effect_check_date')" />
                    </div>
                </div>
            </div> -->
            <!-- <div class="col-6">
                <div class="group-input">
                    <label for="Effectiveness_checker">Effectiveness Checker</label>
                    <select id="select-state" placeholder="Select..." name="Effectiveness_checker">
                        <option value="">Select a person</option>
                        @foreach ($users as $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div> -->
            <!-- <div class="col-12">
                <div class="group-input">
                    <label for="effective_check_plan">Effectiveness Check Plan</label>
                    <textarea name="effective_check_plan"></textarea>
                </div>
            </div> -->
           
          
        </div>
        <div class="button-block">
            <button type="submit" class="saveButton" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>Save</button>
           <button type="button" class="backButton" onclick="previousStep()">Back</button>
            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
        </div>
    </div>
</div>
<!-- CFT  Tab -->
                     <div id="CCForm16" class="inner-block cctabcontent">
                                    <div class="inner-block-content">
                                        <div class="row">

                                            <div class="sub-head">
                                                Production
                                            </div>
                                            @php
                                                $data1 = DB::table('capa_cfts')
                                                    ->where('capa_id', $data->id)
                                                    ->first();
                                            @endphp
                                            <script>
                                                $(document).ready(function() {
                                                    @if($data1->Production_Review !== 'yes')
                                                        $('.p_erson').hide();
                                                        $('[name="Production_Review"]').change(function() {
                                                            if ($(this).val() === 'yes') {
                                                                $('.p_erson').show();
                                                                $('.p_erson span').show();
                                                            } else {
                                                                $('.p_erson').hide();
                                                                $('.p_erson span').hide();
                                                            }
                                                        });
                                                    @endif
                                                });
                                            </script>
                                            @if($data->stage == 3 || $data->stage == 4)
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="Production Review">Production Review Required ?<span class="text-danger">*</span></label>
                                                        <select name="Production_Review" id="Production_Review" required @if ($data->stage == 4) disabled @endif>
                                                            <option value="">-- Select --</option>
                                                            <option @if($data1->Production_Review == "yes") selected @endif value="yes">Yes</option>
                                                            <option @if($data1->Production_Review == "no") selected @endif value="no">No</option>
                                                            <option @if($data1->Production_Review == "na") selected @endif value="na">NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                @php
                                                    $userRoles = DB::table('user_roles')
                                                    ->where([
                                                        'q_m_s_roles_id' => 22,
                                                        'q_m_s_divisions_id' => $data->division_id,
                                                    ])->get();
                                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get();
                                                @endphp
                                                <div class="col-lg-6 p_erson">
                                                    <div class="group-input">
                                                        <label for="Production person">Production Person <span id="asteriskPT1"
                                                                    style="display: {{ $data1->Production_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                                                    class="text-danger">*</span></label>
                                                        <select name="Production_person" id="Production_person" @if ($data->stage == 4) disabled @endif>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @if($data1->Production_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Any Other Specify -->
                                                <div class="col-md-12 mb-3 p_erson">
                                                    <div class="group-input">
                                                        <label for="Production_assessment">Production Assessment<span id="asteriskPT2"
                                                                    style="display: {{ $data1->Production_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                                                    class="text-danger">*</span></label>
                                                                    <textarea  name="Production_assessment" id="summernote-17" @if ($data1->Production_Review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->Production_person) && Auth::user()->id != $data1->Production_person)) disabled @endif>{{ $data1->Production_assessment }}</textarea>                                              


                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 p_erson">
                                                    <div class="group-input">
                                                        <label for="Production assessment">Production Feedback <span id="asteriskPT2"
                                                                    style="display: {{ $data1->Production_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                                                    class="text-danger">*</span></label>
                                                        <div><small class="text-primary">Please insert "NA" in the data field if it does
                                                                not require completion</small></div>
                                                                <textarea  name="Production_feedback" id="summernote-17" @if ($data1->Production_Review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->Production_person) && Auth::user()->id != $data1->Production_person)) disabled @endif>{{ $data1->Production_feedback }}</textarea>                                              

                                                      
                                                    </div>
                                                </div>


                                                <div class="col-12 p_erson">
                                                    <div class="group-input">
                                                        <label for="Production Tablet attachment">Production Attachments</label>
                                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                                documents</small></div>
                                                        <div class="file-attachment-field">
                                                            <div readonly class="file-attachment-list" id="production_attachment">
                                                                @if ($data1->production_attachment)
                                                                    @foreach (json_decode($data1->production_attachment) as $file)
                                                                        <h6 type="button" class="file-container text-dark"
                                                                            style="background-color: rgb(243, 242, 240);">
                                                                            <b>{{ $file }}</b>
                                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                                                    class="fa fa-eye text-primary"
                                                                                    style="font-size:20px; margin-right:-10px;"></i></a>
                                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                                    class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                                        </h6>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div class="add-btn">
                                                                <div>Add</div>
                                                                <input {{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }} type="file"
                                                                    id="myfile"
                                                                    name="production_attachment[]"{{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }}
                                                                    oninput="addMultipleFiles(this, 'production_attachment')" multiple>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-3 p_erson">
                                                    <div class="group-input">
                                                        <label for="Production Tablet Completed By">Production Completed By</label>
                                                        <input readonly type="text" value="{{ $data1->Production_by }}"
                                                            name="Production_by"{{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }} id="Production_by">
                                                    </div>
                                                </div>

                                                <div class="col-6 mb-3 p_erson new-date-data-field">
                                                    <div class="group-input input-date">
                                                        <label for="Production Tablet Completed On">Production Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="production_on" readonly
                                                                placeholder="DD-MMM-YYYY"
                                                                value="{{ Helpers::getdateFormat($data1->production_on) }}" />
                                                            <input readonly type="date" name="production_on"
                                                                min="{{ \Carbon\Carbon::now()->format('d-M-Y') }}" value=""
                                                                class="hide-input"
                                                                oninput="handleDateInput(this, 'production_on')" />
                                                        </div>
                                                        @error('production_on')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="Production Review">Production Review  ?</label>
                                                        <select name="Production_Review" id="Production_Review" disabled>
                                                            <option value="">-- Select --</option>
                                                            <option @if($data1->Production_Review == "yes") selected @endif value="yes">Yes</option>
                                                            <option @if($data1->Production_Review == "no") selected @endif value="no">No</option>
                                                            <option @if($data1->Production_Review == "na") selected @endif value="na">NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                @php
                                                    $userRoles = DB::table('user_roles')
                                                    ->where([
                                                        'q_m_s_roles_id' => 22,
                                                        'q_m_s_divisions_id' => $data->division_id,
                                                    ])->get();
                                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                                @endphp

                                                <div class="col-lg-6 p_erson">
                                                    <div class="group-input">
                                                        <label for="Production person">Production Person</label>
                                                       <span style="display: {{ $data1->Production_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}"
                                                                    class="text-danger">*</span></label>
                                                        <select name="Production_person" id="Production_person" disabled @if ($data->stage == 4) readonly @endif>
                                                        <!-- <select name="Production_person" id="Production_person" readonly> -->
                                                            <option value="">-- Select --</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @if($data1->Production_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Any Other Specify -->
                                                <div class="col-md-12 mb-3 p_erson">
                                                    <div class="group-input">
                                                        <label for="Production_assessment">Production Assessment</label>
                                                        <textarea  name="Production_feedback" id="summernote-17" @if ($data1->Production_Review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->Production_person) && Auth::user()->id != $data1->Production_person)) disabled @endif>{{ $data1->Production_feedback }}</textarea>                                              

                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 p_erson">
                                                    <div class="group-input">
                                                        <label for="Production assessment">Production Feedback</label>
                                                        <div><small class="text-primary">Please insert "NA" in the data field if it does
                                                                not require completion</small></div>
                                                                <textarea  name="Production_feedback" id="summernote-17" @if ($data1->Production_Review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->Production_person) && Auth::user()->id != $data1->Production_person)) disabled @endif>{{ $data1->Production_feedback }}</textarea>                                              
                                                    </div>
                                                </div>

                                                <div class="col-12 p_erson">
                                                    <div class="group-input">
                                                        <label for="Production Tablet attachment">Production Attachments</label>
                                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                                documents</small></div>
                                                        <div class="file-attachment-field">
                                                            <div readonly class="file-attachment-list" id="production_attachment">
                                                                @if ($data1->production_attachment)
                                                                    @foreach (json_decode($data1->production_attachment) as $file)
                                                                        <h6 type="button" class="file-container text-dark"
                                                                            style="background-color: rgb(243, 242, 240);">
                                                                            <b>{{ $file }}</b>
                                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                                                    class="fa fa-eye text-primary"
                                                                                    style="font-size:20px; margin-right:-10px;"></i></a>
                                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                                    class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                                        </h6>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div class="add-btn">
                                                                <div>Add</div>
                                                                <input readonly {{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }} type="file"
                                                                    id="myfile" name="production_attachment[]" oninput="addMultipleFiles(this, 'production_attachment')"
                                                                    multiple>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3 p_erson">
                                                    <div class="group-input">
                                                        <label for="Production Tablet Completed By">Production Completed By</label>
                                                        <input readonly type="text" value="{{ $data1->Production_by }}" name="Production_by" id="Production_by">
                                                    </div>
                                                </div>
                                                <div class="col-6 mb-3 p_erson new-date-data-field">
                                                    <div class="group-input input-date">
                                                        <label for="Production Tablet Completed On">Production Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="production_on" readonly
                                                                placeholder="DD-MMM-YYYY"
                                                                value="{{ Helpers::getdateFormat($data1->production_on) }}" />
                                                            <input readonly type="date" name="production_on"
                                                                min="{{ \Carbon\Carbon::now()->format('d-M-Y') }}" value=""
                                                                class="hide-input"
                                                                oninput="handleDateInput(this, 'production_on')" />
                                                        </div>
                                                        @error('production_on')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            <!-- Quality Control Department -->
                                            <div class="sub-head">
                                                Quality Control
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    @if($data1->Quality_review !== 'yes')
                                                        $('.quality_control').hide();
                                                        $('[name="Quality_review"]').change(function() {
                                                            if ($(this).val() === 'yes') {
                                                                $('.quality_control').show();
                                                                $('.quality_control span').show();
                                                            } else {
                                                                $('.quality_control').hide();
                                                                $('.quality_control span').hide();
                                                            }
                                                        });
                                                    @endif
                                                });
                                            </script>

                                            @php
                                                $data1 = DB::table('capa_cfts')->where('capa_id', $data->id)->first();
                                            @endphp

                                            @if($data->stage == 3 || $data->stage == 4)

                                                <!-- Quality Control Review Required -->
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="Quality Control Review Required">Quality Control Review Required ?<span class="text-danger">*</span></label>
                                                        <select name="Quality_review" id="Quality_review"  required @if ($data->stage == 4) disabled @endif>
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" @if($data1->Quality_review == "yes") selected @endif>Yes</option>
                                                            <option value="no" @if($data1->Quality_review == "no") selected @endif>No</option>
                                                            <option value="na" @if($data1->Quality_review == "na") selected @endif>NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                @php
                                                    $userRoles = DB::table('user_roles')
                                                    ->where([
                                                        'q_m_s_roles_id' => 24,
                                                        'q_m_s_divisions_id' => $data->division_id,
                                                    ])->get();
                                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get();

                                                @endphp
      
                                                <!-- Quality Control Person -->
                                                <div class="col-lg-6 quality_control">
                                                    <div class="group-input">
                                                        <label for="Quality Control Person">Quality Control Person <span  class="text-danger" style="display: {{ $data1->Quality_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}">*</span></label>
                                                        <select name="Quality_Control_Person" id="Quality_Control_Person" @if ($data->stage == 4) readonly @endif>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @if($data1->Quality_Control_Person == $user->id) selected @endif>{{ $user->name }}</option>
                                                            @endforeach
                                                           
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Any Other Specify -->
                                                <div class="col-md-12 mb-3 quality_control">
                                                    <div class="group-input">
                                                        <label for="Quality_Control_assessment">Quality Control Assessment <span class="text-danger" style="display: {{ $data1->Quality_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}">*</span></label>
                                                        <textarea  name="Quality_Control_assessment" id="summernote-17" @if ($data1->Quality_review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->Quality_Control_Person) && Auth::user()->id != $data1->Quality_Control_Person)) disabled @endif>{{ $data1->Quality_Control_assessment }}</textarea>                                              
                                                       </div>
                                                </div>

                                                <div class="col-md-12 mb-3 quality_control">
                                                    <div class="group-input">
                                                        <label for="Quality_Control_feedback">Quality Control Feedback <span class="text-danger" style="display: {{ $data1->Quality_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}">*</span></label>
                                                        <textarea  name="Quality_Control_feedback" id="summernote-17" @if ($data1->Quality_review == 'yes' && $data->stage == 4) required @endif
                                                        @if ($data->stage == 3 || (isset($data1->Quality_Control_Person) && Auth::user()->id != $data1->Quality_Control_Person)) disabled @endif>{{ $data1->Quality_Control_feedback }}</textarea>                                                 
                                                     </div>
                                                </div>


                                                <div class="col-12 quality_control">
                                                    <div class="group-input">
                                                        <label for="Production Tablet attachment">Quality Control Attachments</label>
                                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                                documents</small></div>
                                                        <div class="file-attachment-field">
                                                            <div readonly class="file-attachment-list" id="Quality_Control_attachment">
                                                                @if ($data1->Quality_Control_attachment)
                                                                    @foreach (json_decode($data1->Quality_Control_attachment) as $file)
                                                                        <h6 type="button" class="file-container text-dark"
                                                                            style="background-color: rgb(243, 242, 240);">
                                                                            <b>{{ $file }}</b>
                                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                                                    class="fa fa-eye text-primary"
                                                                                    style="font-size:20px; margin-right:-10px;"></i></a>
                                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                                    class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                                        </h6>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div class="add-btn">
                                                                <div>Add</div>
                                                                <input {{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }} type="file"
                                                                    id="myfile"
                                                                    name="Quality_Control_attachment[]"{{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }}
                                                                    oninput="addMultipleFiles(this, 'Quality_Control_attachment')" multiple>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Completed By -->
                                                <div class="col-md-6 mb-3 quality_control">
                                                    <div class="group-input">
                                                        <label for="productionfeedback">Quality Control Review Completed By</label>
                                                        <input readonly type="text" value="{{ $data1->Quality_Control_by }}" name="Quality_Control_by">
                                                    </div>
                                                </div>

                                                <!-- Completed On -->
                                                <div class="col-lg-6 new-date-data-field quality_control">
                                                    <div class="group-input input-date">
                                                        <label for="Quality Control Review Completed On">Quality Control Review Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="Quality_Control_on" readonly placeholder="DD-MM-YYYY" value="{{ Helpers::getdateFormat($data1->Quality_Control_on) }}" />
                                                            <input readonly type="date" name="Quality_Control_on" min="{{ \Carbon\Carbon::now()->format('d-M-Y') }}" class="hide-input"
                                                                oninput="handleDateInput(this, 'Quality_Control_on')" />
                                                        </div>
                                                    </div>
                                                </div>

                                            @else
                                                <!-- Else block for readonly fields when the stage is not 3 or 4 -->

                                                <!-- Quality Control Review Required -->
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="Quality Control Review Required">Quality Control Review Required ?</label>
                                                        <select name="Quality_review" id="Quality_review" disabled>
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" @if($data1->Quality_review == "yes") selected @endif>Yes</option>
                                                            <option value="no" @if($data1->Quality_review == "no") selected @endif>No</option>
                                                            <option value="na" @if($data1->Quality_review == "na") selected @endif>NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Quality Control Person -->
                                                <div class="col-lg-6 quality_control">
                                                    <div class="group-input">
                                                        <label for="Quality Control Person">Quality Control Person</label>
                                                        <select name="Quality_Control_Person" id="Quality_Control_Person" disabled>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @if($data1->Quality_Control_Person == $user->id) selected @endif>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Quality Control Assessment -->
                                                <div class="col-md-12 mb-3 quality_control">
                                                    <div class="group-input">
                                                        <label for="Quality_Control_assessment">Quality Control Assessment</label>
                                                        <textarea  name="Quality_Control_assessment" id="summernote-17" disabled>{{ $data1->Quality_Control_assessment }}</textarea>
                                                    </div>
                                                </div>

                                                <!-- Quality Control Feedback -->
                                                <div class="col-md-12 mb-3 quality_control">
                                                    <div class="group-input">
                                                        <label for="Quality_Control_feedback">Quality Control Feedback</label>
                                                        <textarea  name="Quality_Control_feedback" id="summernote-17" disabled>{{ $data1->Quality_Control_feedback }}</textarea>
                                                    </div>
                                                </div>

                                                <!-- Attachments -->
                                                <div class="col-lg-12 quality_control">
                                                    <div class="group-input">
                                                        <label for="Quality Control Attachments">Quality Control Attachments</label>
                                                        <div class="file-attachment-list" id="Quality_Control_attachment">
                                                            @if ($data1->Quality_Control_attachment)
                                                                @foreach (json_decode($data1->Quality_Control_attachment) as $file)
                                                                    <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                        <b>{{ $file }}</b>
                                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                                        <a type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                                    </h6>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Completed By -->
                                                <div class="col-md-6 mb-3 quality_control">
                                                    <div class="group-input">
                                                        <label for="productionfeedback">Quality Control Review Completed By</label>
                                                        <input readonly type="text" value="{{ $data1->Quality_Control_by }}" name="Quality_Control_by">
                                                    </div>
                                                </div>

                                                <!-- Completed On -->
                                                <div class="col-lg-6 new-date-data-field quality_control">
                                                    <div class="group-input input-date">
                                                        <label for="Quality Control Review Completed On">Quality Control Review Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="Quality_Control_on" readonly placeholder="DD-MM-YYYY" value="{{ Helpers::getdateFormat($data1->Quality_Control_on) }}" />
                                                            <input readonly type="date" name="Quality_Control_on" min="{{ \Carbon\Carbon::now()->format('d-M-Y') }}" class="hide-input"
                                                                oninput="handleDateInput(this, 'Quality_Control_on')" />
                                                        </div>
                                                    </div>
                                                </div>

                                            @endif

                                            <div class="sub-head">
                                                Warehouse
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    @if($data1->Warehouse_review !== 'yes')
                                                        $('.warehouse').hide();
                                                        $('[name="Warehouse_review"]').change(function() {
                                                            if ($(this).val() === 'yes') {
                                                                $('.warehouse').show();
                                                                $('.warehouse span').show();
                                                            } else {
                                                                $('.warehouse').hide();
                                                                $('.warehouse span').hide();
                                                            }
                                                        });
                                                    @endif
                                                });
                                            </script>

                                            @php
                                                $data1 = DB::table('capa_cfts')->where('capa_id', $data->id)->first();
                                            @endphp

                                            @if($data->stage == 3 || $data->stage == 4)
                                                <!-- Warehouse Review Required -->
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="Warehouse Review">Warehouse Review Required ?<span class="text-danger">*</span></label>
                                                        <select name="Warehouse_review" id="Warehouse_review" required @if ($data->stage == 4) disabled @endif>
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" @if($data1->Warehouse_review == "yes") selected @endif>Yes</option>
                                                            <option value="no" @if($data1->Warehouse_review == "no") selected @endif>No</option>
                                                            <option value="na" @if($data1->Warehouse_review == "na") selected @endif>NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                @php
                                                    $userRoles = DB::table('user_roles')
                                                    ->where([
                                                        'q_m_s_roles_id' => 23,
                                                        'q_m_s_divisions_id' => $data->division_id,
                                                    ])->get();
                                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get();
                                                @endphp

                                                <!-- Warehouse Person -->
                                                <div class="col-lg-6 warehouse">
                                                    <div class="group-input">
                                                        <label for="Warehouse Person">Warehouse Person <span class="text-danger" style="display: {{ $data1->Warehouse_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}">*</span></label>
                                                        <select name="Warehouse_person" id="Warehouse_person" @if ($data->stage == 4) disabled @endif>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @if($data1->Warehouse_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Any Other Specify -->
                                                <div class="col-md-12 mb-3 warehouse">
                                                    <div class="group-input">
                                                        <label for="Warehouse_assessment">Warehouse Assessment <span class="text-danger" style="display: {{ $data1->Warehouse_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}">*</span></label>
                                                        <textarea  name="Warehouse_assessment" id="summernote-17" @if ($data1->Warehouse_review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->Warehouse_person) && Auth::user()->id != $data1->Warehouse_person)) disabled @endif>{{ $data1->Warehouse_assessment }}</textarea>                                              

                                                      
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 warehouse">
                                                    <div class="group-input">
                                                        <label for="Warehouse_feedback">Warehouse Feedback <span class="text-danger" style="display: {{ $data1->Warehouse_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}">*</span></label>
                                                        <textarea  name="Warehouse_feedback" id="summernote-17" @if ($data1->Warehouse_review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->Warehouse_person) && Auth::user()->id != $data1->Warehouse_person)) disabled @endif>{{ $data1->Warehouse_feedback }}</textarea>                                              
                                                       
                                                    </div>
                                                </div>

                                                <div class="col-12 warehouse">
                                                    <div class="group-input">
                                                        <label for="Production Tablet attachment">Warehouse Attachments</label>
                                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                                documents</small></div>
                                                        <div class="file-attachment-field">
                                                            <div readonly class="file-attachment-list" id="Warehouse_attachment">
                                                                @if ($data1->Warehouse_attachment)
                                                                    @foreach (json_decode($data1->Warehouse_attachment) as $file)
                                                                        <h6 type="button" class="file-container text-dark"
                                                                            style="background-color: rgb(243, 242, 240);">
                                                                            <b>{{ $file }}</b>
                                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                                                    class="fa fa-eye text-primary"
                                                                                    style="font-size:20px; margin-right:-10px;"></i></a>
                                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                                    class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                                        </h6>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div class="add-btn">
                                                                <div>Add</div>
                                                                <input {{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }} type="file"
                                                                    id="myfile"
                                                                    name="Warehouse_attachment[]"{{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }}
                                                                    oninput="addMultipleFiles(this, 'Warehouse_attachment')" multiple>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Completed By -->
                                                <div class="col-md-6 mb-3 warehouse">
                                                    <div class="group-input">
                                                        <label for="Warehouse_by">Warehouse Review Completed By</label>
                                                        <input readonly type="text" value="{{ $data1->Warehouse_by }}" name="Warehouse_by">
                                                    </div>
                                                </div>

                                                <!-- Completed On -->
                                                <div class="col-lg-6 new-date-data-field warehouse">
                                                    <div class="group-input input-date">
                                                        <label for="Warehouse_on">Warehouse Review Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="Warehouse_on" readonly placeholder="DD-MM-YYYY" value="{{ Helpers::getdateFormat($data1->Warehouse_on) }}" />
                                                            <input readonly type="date" name="Warehouse_on" min="{{ \Carbon\Carbon::now()->format('d-M-Y') }}" class="hide-input"
                                                                oninput="handleDateInput(this, 'Warehouse_on')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            @else

                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="Warehouse Review">Warehouse Review Required ?</label>
                                                        <select name="Warehouse_review" id="Warehouse_review" disabled>
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" @if($data1->Warehouse_review == "yes") selected @endif>Yes</option>
                                                            <option value="no" @if($data1->Warehouse_review == "no") selected @endif>No</option>
                                                            <option value="na" @if($data1->Warehouse_review == "na") selected @endif>NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Warehouse Person -->
                                                <div class="col-lg-6 warehouse">
                                                    <div class="group-input">
                                                        <label for="Warehouse Person">Warehouse Person</label>
                                                        <select name="Warehouse_person" id="Warehouse_person" disabled>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @if($data1->Warehouse_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Warehouse Assessment -->
                                                <div class="col-md-12 mb-3 warehouse">
                                                    <div class="group-input">
                                                        <label for="Warehouse_assessment">Warehouse Assessment</label>
                                                        <textarea  name="Warehouse_assessment" id="summernote-17" @if ($data1->Warehouse_review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->Warehouse_person) && Auth::user()->id != $data1->Warehouse_person)) disabled @endif>{{ $data1->Warehouse_assessment }}</textarea>                                              

                                                    </div>
                                                </div>

                                                <!-- Warehouse Feedback -->
                                                <div class="col-md-12 mb-3 warehouse">
                                                    <div class="group-input">
                                                        <label for="Warehouse_assessment">Warehouse Feedback</label>
                                                        <textarea  name="Warehouse_feedback" id="summernote-17" @if ($data1->Warehouse_review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->Warehouse_person) && Auth::user()->id != $data1->Warehouse_person)) disabled @endif>{{ $data1->Warehouse_feedback }}</textarea>                                              

                                                    </div>
                                                </div>

                                                <!-- Attachments -->
                                                <div class="col-lg-12 warehouse">
                                                    <div class="group-input">
                                                        <label for="Warehouse_attachment">Warehouse Attachments</label>
                                                        <div class="file-attachment-list" id="Warehouse_attachment">
                                                            @if ($data1->Warehouse_attachment)
                                                                @foreach (json_decode($data1->Warehouse_attachment) as $file)
                                                                    <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                        <b>{{ $file }}</b>
                                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                                        <a type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                                    </h6>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="add-btn">
                                                            <div>Add</div>
                                                            <input readonly type="file" id="myfile" name="Warehouse_attachment[]" oninput="addMultipleFiles(this, 'Warehouse_attachment')" multiple>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Completed By -->
                                                <div class="col-md-6 mb-3 warehouse">
                                                    <div class="group-input">
                                                        <label for="Warehouse_by">Warehouse Review Completed By</label>
                                                        <input readonly type="text" value="{{ $data1->Warehouse_by }}" name="Warehouse_by">
                                                    </div>
                                                </div>

                                                <!-- Completed On -->
                                                <div class="col-lg-6 new-date-data-field warehouse">
                                                    <div class="group-input input-date">
                                                        <label for="Warehouse_on">Warehouse Review Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="Warehouse_on" readonly placeholder="DD-MM-YYYY" value="{{ Helpers::getdateFormat($data1->Warehouse_on) }}" />
                                                            <input readonly type="date" name="Warehouse_on" min="{{ \Carbon\Carbon::now()->format('d-M-Y') }}" class="hide-input"
                                                                oninput="handleDateInput(this, 'Warehouse_on')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                        
                                            <!-- Engineering Department -->
                                            <div class="sub-head">
                                                Engineering
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    @if($data1->Engineering_review !== 'yes')
                                                        $('.engineering').hide();
                                                        $('[name="Engineering_review"]').change(function() {
                                                            if ($(this).val() === 'yes') {
                                                                $('.engineering').show();
                                                                $('.engineering span').show();
                                                            } else {
                                                                $('.engineering').hide();
                                                                $('.engineering span').hide();
                                                            }
                                                        });
                                                    @endif
                                                });
                                            </script>

                                            @php
                                                $data1 = DB::table('capa_cfts')->where('capa_id', $data->id)->first();
                                            @endphp

                                            @if($data->stage == 3 || $data->stage == 4)

                                                <!-- Engineering Review Required -->
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="Engineering Review Required">Engineering Review Required ?<span class="text-danger">*</span></label>
                                                        <select name="Engineering_review" id="Engineering_review" required @if ($data->stage == 4) disabled @endif>
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" @if($data1->Engineering_review == "yes") selected @endif>Yes</option>
                                                            <option value="no" @if($data1->Engineering_review == "no") selected @endif>No</option>
                                                            <option value="na" @if($data1->Engineering_review == "na") selected @endif>NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                @php
                                                    $userRoles = DB::table('user_roles')
                                                    ->where([
                                                        'q_m_s_roles_id' => 25,
                                                        'q_m_s_divisions_id' => $data->division_id,
                                                    ])->get();
                                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get();
                                                @endphp

                                                <!-- Engineering Person -->
                                                <div class="col-lg-6 engineering">
                                                    <div class="group-input">
                                                        <label for="Engineering Person">Engineering Person <span class="text-danger" style="display: {{ $data1->Engineering_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}">*</span></label>
                                                        <select name="Engineering_person" id="Engineering_person" @if ($data->stage == 4) disabled @endif>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @if($data1->Engineering_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Impact Assessment -->
                                                <div class="col-md-12 mb-3 engineering">
                                                    <div class="group-input">
                                                        <label for="Impact Assessment4">Engineering Assessment<span class="text-danger" style="display: {{ $data1->Engineering_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}">*</span></label>
                                                        <textarea  name="Engineering_assessment" id="summernote-17" @if ($data1->Engineering_review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->Engineering_person) && Auth::user()->id != $data1->Engineering_person)) disabled @endif>{{ $data1->Engineering_assessment }}</textarea>                                              

                                                    </div>
                                                </div>

                                                <!-- Feedback -->
                                                <div class="col-md-12 mb-3 engineering">
                                                    <div class="group-input">
                                                        <label for="Impact Assessment4">Engineering Feedback<span class="text-danger" style="display: {{ $data1->Engineering_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}">*</span></label>
                                                        <textarea  name="Engineering_feedback" id="summernote-17" @if ($data1->Engineering_review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->Engineering_person) && Auth::user()->id != $data1->Engineering_person)) disabled @endif>{{ $data1->Engineering_feedback }}</textarea>                                              

                                                    </div>
                                                </div>

                                                <div class="col-12 engineering">
                                                    <div class="group-input">
                                                        <label for="Production Tablet attachment">Engineering Attachments</label>
                                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                                documents</small></div>
                                                        <div class="file-attachment-field">
                                                            <div readonly class="file-attachment-list" id="Engineering_attachment">
                                                                @if ($data1->Engineering_attachment)
                                                                    @foreach (json_decode($data1->Engineering_attachment) as $file)
                                                                        <h6 type="button" class="file-container text-dark"
                                                                            style="background-color: rgb(243, 242, 240);">
                                                                            <b>{{ $file }}</b>
                                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                                                    class="fa fa-eye text-primary"
                                                                                    style="font-size:20px; margin-right:-10px;"></i></a>
                                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                                    class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                                        </h6>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div class="add-btn">
                                                                <div>Add</div>
                                                                <input {{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }} type="file"
                                                                    id="myfile"
                                                                    name="Engineering_attachment[]"{{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }}
                                                                    oninput="addMultipleFiles(this, 'Engineering_attachment')" multiple>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Engineering Review Completed By -->
                                                <div class="col-md-6 mb-3 engineering">
                                                    <div class="group-input">
                                                        <label for="Engineering Review Completed By">Engineering Review Completed By</label>
                                                        <input readonly type="text" value="{{ $data1->Engineering_by }}" name="Engineering_by">
                                                    </div>
                                                </div>

                                                <!-- Engineering Review Completed On -->
                                                <div class="col-lg-6 new-date-data-field engineering">
                                                    <div class="group-input input-date">
                                                        <label for="Engineering Review Completed On">Engineering Review Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="Engineering_on" readonly placeholder="DD-MM-YYYY" value="{{ Helpers::getdateFormat($data1->Engineering_on) }}" />
                                                            <input readonly type="date" name="Engineering_on" min="{{ \Carbon\Carbon::now()->format('d-M-Y') }}" class="hide-input"
                                                                oninput="handleDateInput(this, 'Engineering_on')" />
                                                        </div>
                                                    </div>
                                                </div>

                                            @else
                                                <!-- Else block for readonly fields when the stage is not 3 or 4 -->

                                                <!-- Engineering Review Required -->
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="Engineering Review Required">Engineering Review Required ?</label>
                                                        <select name="Engineering_review" id="Engineering_review" disabled>
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" @if($data1->Engineering_review == "yes") selected @endif>Yes</option>
                                                            <option value="no" @if($data1->Engineering_review == "no") selected @endif>No</option>
                                                            <option value="na" @if($data1->Engineering_review == "na") selected @endif>NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Engineering Person -->
                                                <div class="col-lg-6 engineering">
                                                    <div class="group-input">
                                                        <label for="Engineering Person">Engineering Person</label>
                                                        <select name="Engineering_person" id="Engineering_person" disabled>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @if($data1->Engineering_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Impact Assessment -->
                                                <div class="col-md-12 mb-3 engineering">
                                                    <div class="group-input">
                                                        <label for="Impact Assessment4">Engineering Assessment</label>
                                                        <textarea  name="Engineering_assessment" id="summernote-17" @if ($data1->Engineering_review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->Engineering_person) && Auth::user()->id != $data1->Engineering_person)) disabled @endif>{{ $data1->Engineering_assessment }}</textarea>                                              
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 engineering">
                                                    <div class="group-input">
                                                        <label for="Impact Assessment4">Engineering Feedback</label>
                                                        <textarea  name="Engineering_feedback" id="summernote-17" @if ($data1->Engineering_review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->Engineering_person) && Auth::user()->id != $data1->Engineering_person)) disabled @endif>{{ $data1->Engineering_feedback }}</textarea>                                              
                                                        
                                                    </div>
                                                </div>

                                                <div class="col-12 engineering">
                                                    <div class="group-input">
                                                        <label for="Production Tablet attachment">Engineering Attachments</label>
                                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                                documents</small></div>
                                                        <div class="file-attachment-field">
                                                            <div readonly class="file-attachment-list" id="Engineering_attachment">
                                                                @if ($data1->Engineering_attachment)
                                                                    @foreach (json_decode($data1->Engineering_attachment) as $file)
                                                                        <h6 type="button" class="file-container text-dark"
                                                                            style="background-color: rgb(243, 242, 240);">
                                                                            <b>{{ $file }}</b>
                                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                                                    class="fa fa-eye text-primary"
                                                                                    style="font-size:20px; margin-right:-10px;"></i></a>
                                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                                    class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                                        </h6>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div class="add-btn">
                                                                <div>Add</div>
                                                                <input readonly {{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }} type="file"
                                                                    id="myfile"
                                                                    name="Engineering_attachment[]"{{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }}
                                                                    oninput="addMultipleFiles(this, 'Engineering_attachment')" multiple>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Engineering Review Completed By -->
                                                <div class="col-md-6 mb-3 engineering">
                                                    <div class="group-input">
                                                        <label for="Engineering Review Completed By">Engineering Review Completed By</label>
                                                        <input readonly type="text" value="{{ $data1->Engineering_by }}" name="Engineering_by">
                                                    </div>
                                                </div>

                                                <!-- Engineering Review Completed On -->
                                                <div class="col-lg-6 new-date-data-field engineering">
                                                    <div class="group-input input-date">
                                                        <label for="Engineering Review Completed On">Engineering Review Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="Engineering_on" readonly placeholder="DD-MM-YYYY" value="{{ Helpers::getdateFormat($data1->Engineering_on) }}" />
                                                            <input readonly type="date" name="Engineering_on" min="{{ \Carbon\Carbon::now()->format('d-M-Y') }}" class="hide-input"
                                                                oninput="handleDateInput(this, 'Engineering_on')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif


                                            <!-- Research & Development Department -->
                                            <div class="sub-head">
                                                Research & Development
                                            </div>

                                            <script>
                                                $(document).ready(function() {
                                                    @if($data1->ResearchDevelopment_Review !== 'yes')
                                                        $('.researchDevelopment').hide();
                                                        $('[name="ResearchDevelopment_Review"]').change(function() {
                                                            if ($(this).val() === 'yes') {
                                                                $('.researchDevelopment').show();
                                                                $('.researchDevelopment span').show();
                                                            } else {
                                                                $('.researchDevelopment').hide();
                                                                $('.researchDevelopment span').hide();
                                                            }
                                                        });
                                                    @endif
                                                });
                                            </script>

                                            @php
                                                $data1 = DB::table('capa_cfts')->where('capa_id', $data->id)->first();
                                                $userRoles = DB::table('user_roles')
                                                    ->where([
                                                        'q_m_s_roles_id' => 55,
                                                        'q_m_s_divisions_id' => $data->division_id,
                                                    ])->get();
                                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                            @endphp

                                            @if($data->stage == 3 || $data->stage == 4)
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="Research Development">Research Development Review Required ?<span class="text-danger">*</span></label>
                                                        <select name="ResearchDevelopment_Review" id="ResearchDevelopment_Review"required @if ($data->stage == 4) disabled @endif>
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" @if($data1->ResearchDevelopment_Review == "yes") selected @endif>Yes</option>
                                                            <option value="no" @if($data1->ResearchDevelopment_Review == "no") selected @endif>No</option>
                                                            <option value="na" @if($data1->ResearchDevelopment_Review == "na") selected @endif>NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 researchDevelopment">
                                                    <div class="group-input">
                                                        <label for="Research Development Person">Research Development Person</label>
                                                        <select name="ResearchDevelopment_person" class="ResearchDevelopment_person" id="ResearchDevelopment_person" @if ($data->stage == 4) disabled @endif>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @if($data1->ResearchDevelopment_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Any Other Specify -->
                                                <div class="col-md-12 mb-3 researchDevelopment">
                                                    <div class="group-input">
                                                        <label for="ResearchDevelopment_assessment">Research Development Assessment</label>
                                                        <textarea  name="ResearchDevelopment_assessment" id="summernote-17" @if ($data1->ResearchDevelopment_Review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->ResearchDevelopment_person) && Auth::user()->id != $data1->ResearchDevelopment_person)) disabled @endif>{{ $data1->ResearchDevelopment_assessment }}</textarea>                                              

                                                    </div>
                                                </div>

                                                <!-- Impact Assessment -->
                                                <div class="col-md-12 mb-3 researchDevelopment">
                                                    <div class="group-input">
                                                        <label for="Research Development assessment">Research Development Feedback</label>
                                                        <textarea  name="ResearchDevelopment_feedback" id="summernote-17" @if ($data1->ResearchDevelopment_Review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->ResearchDevelopment_person) && Auth::user()->id != $data1->ResearchDevelopment_person)) disabled @endif>{{ $data1->ResearchDevelopment_feedback }}</textarea>                                              

                                                    </div>
                                                </div>

                                                <div class="col-12 researchDevelopment">
                                                    <div class="group-input">
                                                        <label for="Production Tablet attachment">Research Development Attachments</label>
                                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                                documents</small></div>
                                                        <div class="file-attachment-field">
                                                            <div readonly class="file-attachment-list" id="ResearchDevelopment_attachment">
                                                                @if ($data1->ResearchDevelopment_attachment)
                                                                    @foreach (json_decode($data1->ResearchDevelopment_attachment) as $file)
                                                                        <h6 type="button" class="file-container text-dark"
                                                                            style="background-color: rgb(243, 242, 240);">
                                                                            <b>{{ $file }}</b>
                                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                                                    class="fa fa-eye text-primary"
                                                                                    style="font-size:20px; margin-right:-10px;"></i></a>
                                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                                    class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                                        </h6>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div class="add-btn">
                                                                <div>Add</div>
                                                                <input {{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }} type="file"
                                                                    id="myfile"
                                                                    name="ResearchDevelopment_attachment[]"{{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }}
                                                                    oninput="addMultipleFiles(this, 'ResearchDevelopment_attachment')" multiple>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Research Development Completed By -->
                                                <div class="col-md-6 mb-3 researchDevelopment">
                                                    <div class="group-input">
                                                        <label for="Research Development Completed By">Research Development Completed By</label>
                                                        <input readonly type="text" name="ResearchDevelopment_by" value="{{ $data1->ResearchDevelopment_by }}">
                                                    </div>
                                                </div>

                                                <!-- Research Development Completed On -->
                                                <div class="col-lg-6 researchDevelopment">
                                                    <div class="group-input">
                                                        <label for="Research Development Completed On">Research Development Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="ResearchDevelopment_on" readonly placeholder="DD-MM-YYYY" value="{{ Helpers::getdateFormat($data1->ResearchDevelopment_on) }}" />
                                                            <input readonly type="date" name="ResearchDevelopment_on" min="{{ \Carbon\Carbon::now()->format('d-M-Y') }}" class="hide-input"
                                                            oninput="handleDateInput(this, 'ResearchDevelopment_on')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="Research Development">Research Development Review Required ?</label>
                                                        <select name="ResearchDevelopment_Review" id="ResearchDevelopment_Review" disabled>
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" @if($data1->ResearchDevelopment_Review == "yes") selected @endif>Yes</option>
                                                            <option value="no" @if($data1->ResearchDevelopment_Review == "no") selected @endif>No</option>
                                                            <option value="na" @if($data1->ResearchDevelopment_Review == "na") selected @endif>NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Research Development Person -->
                                                <div class="col-lg-6 researchDevelopment">
                                                    <div class="group-input">
                                                        <label for="Research Development Person">Research Development Person</label>
                                                        <select name="ResearchDevelopment_person" id="ResearchDevelopment_person" disabled>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @if($data1->ResearchDevelopment_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Any Other Specify -->
                                                <div class="col-md-12 mb-3 researchDevelopment">
                                                    <div class="group-input">
                                                        <label for="ResearchDevelopment_assessment">Research Development Assessment</label>
                                                        <textarea  name="ResearchDevelopment_assessment" id="summernote-17" @if ($data1->ResearchDevelopment_Review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->ResearchDevelopment_person) && Auth::user()->id != $data1->ResearchDevelopment_person)) disabled @endif>{{ $data1->ResearchDevelopment_assessment }}</textarea>                                              
                                                    </div>
                                                </div>

                                                <!-- Impact Assessment -->
                                                <div class="col-md-12 mb-3 researchDevelopment">
                                                    <div class="group-input">
                                                        <label for="Research Development assessment">Research Development Feedback</label>
                                                        <textarea  name="ResearchDevelopment_feedback" id="summernote-17" @if ($data1->ResearchDevelopment_Review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->ResearchDevelopment_person) && Auth::user()->id != $data1->ResearchDevelopment_person)) disabled @endif>{{ $data1->ResearchDevelopment_feedback }}</textarea>                                              

                                                    </div>
                                                </div>

                                                <div class="col-12 researchDevelopment">
                                                    <div class="group-input">
                                                        <label for="Production Tablet attachment">Research Development Attachments</label>
                                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                                documents</small></div>
                                                        <div class="file-attachment-field">
                                                            <div readonly class="file-attachment-list" id="ResearchDevelopment_attachment">
                                                                @if ($data1->ResearchDevelopment_attachment)
                                                                    @foreach (json_decode($data1->ResearchDevelopment_attachment) as $file)
                                                                        <h6 type="button" class="file-container text-dark"
                                                                            style="background-color: rgb(243, 242, 240);">
                                                                            <b>{{ $file }}</b>
                                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                                                    class="fa fa-eye text-primary"
                                                                                    style="font-size:20px; margin-right:-10px;"></i></a>
                                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                                    class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                                        </h6>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div class="add-btn">
                                                                <div>Add</div>
                                                                <input readonly {{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }} type="file"
                                                                    id="myfile"
                                                                    name="ResearchDevelopment_attachment[]"{{ $data->stage == 0 || $data->stage == 8 ? 'readonly' : '' }}
                                                                    oninput="addMultipleFiles(this, 'ResearchDevelopment_attachment')" multiple>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Research Development Completed By -->
                                                <div class="col-md-6 mb-3 researchDevelopment">
                                                    <div class="group-input">
                                                        <label for="Research Development Completed By">Research Development Completed By</label>
                                                        <input readonly type="text" name="ResearchDevelopment_by" value="{{ $data1->ResearchDevelopment_by }}">
                                                    </div>
                                                </div>

                                                <!-- Research Development Completed On -->
                                                <div class="col-lg-6 researchDevelopment">
                                                    <div class="group-input">
                                                        <label for="Research Development Completed On">Research Development Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="ResearchDevelopment_on" readonly placeholder="DD-MM-YYYY" value="{{ Helpers::getdateFormat($data1->ResearchDevelopment_on) }}" />
                                                            <input readonly type="date" name="ResearchDevelopment_on" min="{{ \Carbon\Carbon::now()->format('d-M-Y') }}" class="hide-input"
                                                            oninput="handleDateInput(this, 'ResearchDevelopment_on')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Regulatory Affair Department -->
                                            <div class="sub-head">
                                                Regulatory Affair
                                            </div>
                                            @php
                                                $data1 = DB::table('capa_cfts')
                                                    ->where('capa_id', $data->id)
                                                    ->first();
                                            @endphp
                                            <script>
                                                $(document).ready(function() {
                                                    @if($data1->RegulatoryAffair_Review !== 'yes')
                                                        $('.RegulatoryAffair').hide();
                                                        $('[name="RegulatoryAffair_Review"]').change(function() {
                                                            if ($(this).val() === 'yes') {
                                                                $('.RegulatoryAffair').show();
                                                                $('.RegulatoryAffair span').show();
                                                            } else {
                                                                $('.RegulatoryAffair').hide();
                                                                $('.RegulatoryAffair span').hide();
                                                            }
                                                        });
                                                    @endif
                                                });
                                            </script>

                                            @if($data->stage == 3 || $data->stage == 4)
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="RegulatoryAffair">Regulatory Affair Required ?<span class="text-danger">*</span></label>
                                                        <select name="RegulatoryAffair_Review" id="RegulatoryAffair_Review" required @if($data->stage == 4) disabled @endif>
                                                            <option value="">-- Select --</option>
                                                            <option @if($data1->RegulatoryAffair_Review == 'yes') selected @endif value="yes">Yes</option>
                                                            <option @if($data1->RegulatoryAffair_Review == 'no') selected @endif value="no">No</option>
                                                            <option @if($data1->RegulatoryAffair_Review == 'na') selected @endif value="na">NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                @php
                                                    $userRoles = DB::table('user_roles')
                                                        ->where([
                                                            'q_m_s_roles_id' => 57,
                                                            'q_m_s_divisions_id' => $data->division_id,
                                                        ])->get();
                                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); 
                                                @endphp

                                                <div class="col-lg-6 RegulatoryAffair">
                                                    <div class="group-input">
                                                        <label for="Regulatory Affair notification">Regulatory Affair Person</label>
                                                        <select name="RegulatoryAffair_person" id="RegulatoryAffair_person" @if($data->stage == 4) readonly @endif>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @if($data1->RegulatoryAffair_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 RegulatoryAffair">
                                                    <div class="group-input">
                                                        <label for="Regulatory Affair assessment">Regulatory Affair Assessment</label>
                                                        <textarea  name="RegulatoryAffair_assessment" id="summernote-17" @if ($data1->RegulatoryAffair_Review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->RegulatoryAffair_person) && Auth::user()->id != $data1->RegulatoryAffair_person)) disabled @endif>{{ $data1->RegulatoryAffair_assessment }}</textarea>                                              
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 RegulatoryAffair">
                                                    <div class="group-input">
                                                        <label for="Regulatory Affair assessment">Regulatory Affair Feedback</label>
                                                        <textarea  name="RegulatoryAffair_feedback" id="summernote-17" @if ($data1->RegulatoryAffair_Review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->RegulatoryAffair_person) && Auth::user()->id != $data1->RegulatoryAffair_person)) disabled @endif>{{ $data1->RegulatoryAffair_feedback }}</textarea>                                              

                                                    </div>
                                                </div>

                                                <div class="col-12 RegulatoryAffair">
                                                    <div class="group-input">
                                                        <label for="Regulatory Affair attachment">Regulatory Affair Attachments</label>
                                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                        <div class="file-attachment-field">
                                                            <div class="file-attachment-list" id="RegulatoryAffair_attachment">
                                                                @if($data1->RegulatoryAffair_attachment)
                                                                    @foreach(json_decode($data1->RegulatoryAffair_attachment) as $file)
                                                                        <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                            <b>{{ $file }}</b>
                                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary"
                                                                                    style="font-size: 20px; margin-right: -10px;"></i></a>
                                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                                    class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i></a>
                                                                        </h6>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div class="add-btn">
                                                                <div>Add</div>
                                                                <input type="file" id="myfile" name="RegulatoryAffair_attachment[]" multiple 
                                                                    @if($data->stage == 0 || $data->stage == 8) readonly @endif 
                                                                    oninput="addMultipleFiles(this, 'RegulatoryAffair_attachment')">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-3 RegulatoryAffair">
                                                    <div class="group-input">
                                                        <label for="Regulatory Affair Completed By">Regulatory Affair Completed By</label>
                                                        <input readonly type="text" name="RegulatoryAffair_by" value="{{ $data1->RegulatoryAffair_by }}">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 new-date-data-field RegulatoryAffair">
                                                    <div class="group-input input-date">
                                                        <label for="Regulatory Affair Completed On">Regulatory Affair Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="RegulatoryAffair_on" readonly placeholder="DD-MM-YYYY" 
                                                                value="{{ Helpers::getdateFormat($data1->RegulatoryAffair_on) }}" />
                                                            <input readonly type="date" name="RegulatoryAffair_on" class="hide-input" 
                                                                oninput="handleDateInput(this, 'RegulatoryAffair_on')" />
                                                        </div>
                                                    </div>
                                                </div>

                                            @else
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="RegulatoryAffair">Regulatory Affair Required?</label>
                                                        <select name="RegulatoryAffair_Review" id="RegulatoryAffair_Review" disabled>
                                                            <option value="">-- Select --</option>
                                                            <option @if($data1->RegulatoryAffair_Review == 'yes') selected @endif value="yes">Yes</option>
                                                            <option @if($data1->RegulatoryAffair_Review == 'no') selected @endif value="no">No</option>
                                                            <option @if($data1->RegulatoryAffair_Review == 'na') selected @endif value="na">NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 RegulatoryAffair">
                                                    <div class="group-input">
                                                        <label for="Regulatory Affair notification">Regulatory Affair Person</label>
                                                        <select name="RegulatoryAffair_person" id="RegulatoryAffair_person" disabled>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @if($data1->RegulatoryAffair_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 RegulatoryAffair">
                                                    <div class="group-input">
                                                        <label for="Regulatory Affair assessment">Regulatory Affair Assessment</label>
                                                        <textarea  name="RegulatoryAffair_assessment" id="summernote-17" @if ($data1->RegulatoryAffair_Review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->RegulatoryAffair_person) && Auth::user()->id != $data1->RegulatoryAffair_person)) disabled @endif>{{ $data1->RegulatoryAffair_assessment }}</textarea>                                              
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 RegulatoryAffair">
                                                    <div class="group-input">
                                                        <label for="Regulatory Affair assessment">Regulatory Affair Feedback</label>
                                                        <textarea  name="RegulatoryAffair_feedback" id="summernote-17" @if ($data1->RegulatoryAffair_Review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->RegulatoryAffair_person) && Auth::user()->id != $data1->RegulatoryAffair_person)) disabled @endif>{{ $data1->RegulatoryAffair_feedback }}</textarea>                                              

                                                    </div>
                                                </div>

                                                <div class="col-12 RegulatoryAffair">
                                                    <div class="group-input">
                                                        <label for="Regulatory Affair attachment">Regulatory Affair Attachments</label>
                                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                        <div class="file-attachment-field">
                                                            <div class="file-attachment-list" id="RegulatoryAffair_attachment">
                                                                @if($data1->RegulatoryAffair_attachment)
                                                                    @foreach(json_decode($data1->RegulatoryAffair_attachment) as $file)
                                                                        <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                            <b>{{ $file }}</b>
                                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary"
                                                                                    style="font-size: 20px; margin-right: -10px;"></i></a>
                                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                                    class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i></a>
                                                                        </h6>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div class="add-btn">
                                                                <div>Add</div>
                                                                <input readonly type="file" id="myfile" name="RegulatoryAffair_attachment[]" multiple 
                                                                    @if($data->stage == 0 || $data->stage == 8) readonly @endif
                                                                    oninput="addMultipleFiles(this, 'RegulatoryAffair_attachment')">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-3 RegulatoryAffair">
                                                    <div class="group-input">
                                                        <label for="Regulatory Affair Completed By">Regulatory Affair Completed By</label>
                                                        <input readonly type="text" name="RegulatoryAffair_by" readonly value="{{ $data1->RegulatoryAffair_by }}">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 new-date-data-field RegulatoryAffair">
                                                    <div class="group-input input-date">
                                                        <label for="Regulatory Affair Completed On">Regulatory Affair Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="RegulatoryAffair_on" readonly placeholder="DD-MM-YYYY" 
                                                                value="{{ Helpers::getdateFormat($data1->RegulatoryAffair_on) }}" />
                                                            <input readonly type="date" name="RegulatoryAffair_on" class="hide-input" 
                                                                oninput="handleDateInput(this, 'RegulatoryAffair_on')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif


                                            <!-- CQA Department -->
                                                @php
                                                    $data1 = DB::table('capa_cfts')
                                                        ->where('capa_id', $data->id)
                                                        ->first();
                                                @endphp
                                                <div class="sub-head">
                                                    CQA
                                                </div>
                                                <script>
                                                    $(document).ready(function() {
                                                        @if($data1->CQA_Review !== 'yes')
                                                            $('.cqa_person').hide();
                                                            $('[name="CQA_Review"]').change(function() {
                                                                if ($(this).val() === 'yes') {
                                                                    $('.cqa_person').show();
                                                                    $('.cqa_person span').show();
                                                                } else {
                                                                    $('.cqa_person').hide();
                                                                    $('.cqa_person span').hide();
                                                                }
                                                            });
                                                        @endif
                                                    });
                                                </script>

                                            @if($data->stage == 3 || $data->stage == 4)

                                                <!-- CQA Review -->
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="CQA Review">CQA Review Required ?<span class="text-danger">*</span></label>
                                                        <select name="CQA_Review" id="CQA_Review"required @if($data->stage == 4) disabled @endif>
                                                            <option value="">-- Select --</option>
                                                            <option @if($data1->CQA_Review == 'yes') selected @endif value="yes">Yes</option>
                                                            <option @if($data1->CQA_Review == 'no') selected @endif value="no">No</option>
                                                            <option @if($data1->CQA_Review == 'na') selected @endif value="na">NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                @php
                                                    $userRoles = DB::table('user_roles')
                                                        ->where([
                                                            'q_m_s_roles_id' => 58,
                                                            'q_m_s_divisions_id' => $data->division_id,
                                                        ])->get();
                                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); 
                                                @endphp

                                                <!-- CQA Person -->
                                                <div class="col-lg-6 cqa_person">
                                                    <div class="group-input">
                                                        <label for="CQA person">CQA Person</label>
                                                        <select name="CQA_person" id="CQA_person" @if($data->stage == 4) readonly @endif>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @if($data1->CQA_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- CQA Comment -->
                                                <div class="col-md-12 mb-3 cqa_person">
                                                    <div class="group-input">
                                                        <label for="CQA assessment">CQA Assessment</label>
                                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                        <textarea  name="CorporateQualityAssurance_assessment" id="summernote-17" @if ($data1->CQA_Review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->CQA_person) && Auth::user()->id != $data1->CQA_person)) disabled @endif>{{ $data1->CorporateQualityAssurance_assessment }}</textarea>                                              


                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 cqa_person">
                                                    <div class="group-input">
                                                        <label for="CQA assessment">CQA Feedback</label>
                                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                        <textarea  name="CorporateQualityAssurance_feedback" id="summernote-17" @if ($data1->CQA_Review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->CQA_person) && Auth::user()->id != $data1->CQA_person)) disabled @endif>{{ $data1->CorporateQualityAssurance_feedback }}</textarea>                                              

                                                       
                                                    </div>
                                                </div>

                                                <!-- CQA Attachments -->
                                                <div class="col-lg-12 cqa_person">
                                                    <div class="group-input">
                                                        <label for="CQA attachment">CQA Attachments</label>
                                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                        <div class="file-attachment-field">
                                                            <div class="file-attachment-list" id="CQA_attachment">
                                                                @if($data1->CQA_attachment)
                                                                    @foreach(json_decode($data1->CQA_attachment) as $file)
                                                                        <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                            <b>{{ $file }}</b>
                                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary"
                                                                                    style="font-size: 20px; margin-right: -10px;"></i></a>
                                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                                    class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i></a>
                                                                        </h6>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div class="add-btn">
                                                                <div>Add</div>
                                                                <input type="file" id="myfile" name="CQA_attachment[]" multiple 
                                                                    @if($data->stage == 0 || $data->stage == 8) readonly @endif 
                                                                    oninput="addMultipleFiles(this, 'CQA_attachment')">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- CQA Review Completed By -->
                                                <div class="col-md-6 mb-3 cqa_person">
                                                    <div class="group-input">
                                                        <label for="CQA Review Completed By">CQA Review Completed By</label>
                                                        <input readonly type="text" name="CQA_by" value="{{ $data1->CQA_by }}">
                                                    </div>
                                                </div>

                                                <!-- CQA Review Completed On -->
                                                <div class="col-lg-6 new-date-data-field cqa_person">
                                                    <div class="group-input input-date">
                                                        <label for="CQA Review Completed On">CQA Review Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="CQA_on" readonly placeholder="DD-MM-YYYY" 
                                                                value="{{ Helpers::getdateFormat($data1->CQA_on) }}" />
                                                            <input readonly type="date" name="CQA_on" class="hide-input" 
                                                                oninput="handleDateInput(this, 'CQA_on')" />
                                                        </div>
                                                    </div>
                                                </div>

                                            @else

                                                <!-- CQA Review (Disabled) -->
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="CQA Review">CQA Review Required?</label>
                                                        <select name="CQA_Review" id="CQA_Review" disabled>
                                                            <option value="">-- Select --</option>
                                                            <option @if($data1->CQA_Review == 'yes') selected @endif value="yes">Yes</option>
                                                            <option @if($data1->CQA_Review == 'no') selected @endif value="no">No</option>
                                                            <option @if($data1->CQA_Review == 'na') selected @endif value="na">NA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- CQA Person (Disabled) -->
                                                <div class="col-lg-6 cqa_person">
                                                    <div class="group-input">
                                                        <label for="CQA person">CQA Person</label>
                                                        <select name="CQA_person" id="CQA_person" disabled>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @if($data1->CQA_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- CQA Comment (Disabled) -->
                                                <div class="col-md-12 mb-3 cqa_person">
                                                    <div class="group-input">
                                                        <label for="CQA assessment">CQA Assessment</label>
                                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                        <textarea  name="CorporateQualityAssurance_assessment" id="summernote-17" @if ($data1->CQA_Review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->CQA_person) && Auth::user()->id != $data1->CQA_person)) disabled @endif>{{ $data1->CorporateQualityAssurance_assessment }}</textarea>                                              
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 cqa_person">
                                                    <div class="group-input">
                                                        <label for="CQA assessment">CQA Feedback</label>
                                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                        <textarea  name="CorporateQualityAssurance_feedback" id="summernote-17" @if ($data1->CQA_Review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->CQA_person) && Auth::user()->id != $data1->CQA_person)) disabled @endif>{{ $data1->CorporateQualityAssurance_feedback }}</textarea>                                              

                                                    </div>
                                                </div>

                                                <!-- CQA Attachments (Disabled) -->
                                                <div class="col-lg-12 cqa_person">
                                                    <div class="group-input">
                                                        <label for="CQA attachment">CQA Attachments</label>
                                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                        <div class="file-attachment-field">
                                                            <div class="file-attachment-list" id="CQA_attachment">
                                                                @if($data1->CQA_attachment)
                                                                    @foreach(json_decode($data1->CQA_attachment) as $file)
                                                                        <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                            <b>{{ $file }}</b>
                                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary"
                                                                                    style="font-size: 20px; margin-right: -10px;"></i></a>
                                                                            <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                                    class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i></a>
                                                                        </h6>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- CQA Review Completed By (Disabled) -->
                                                <div class="col-md-6 mb-3 cqa_person">
                                                    <div class="group-input">
                                                        <label for="CQA Review Completed By">CQA Review Completed By</label>
                                                        <input readonly type="text" value="{{ $data1->CQA_by }}" name="CQA_by" readonly>
                                                    </div>
                                                </div>

                                                <!-- CQA Review Completed On (Disabled) -->
                                                <div class="col-lg-6 new-date-data-field cqa_person">
                                                    <div class="group-input input-date">
                                                        <label for="CQA Review Completed On">CQA Review Completed On</label>
                                                        <div class="calenderauditee">
                                                            <input type="text" id="CQA_on" readonly placeholder="DD-MM-YYYY"
                                                                value="{{ Helpers::getdateFormat($data1->CQA_on) }}" />
                                                            <input readonly type="date" name="CQA_on" class="hide-input" readonly />
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Microbiology Department -->
                                            @php
                                                $data1 = DB::table('capa_cfts')
                                                    ->where('capa_id', $data->id)
                                                    ->first();
                                            @endphp
                                            <div class="sub-head">
                                                Microbiology
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    @if($data1->Microbiology_Review !== 'yes')
                                                        $('.microbiology_person').hide();
                                                        $('[name="Microbiology_Review"]').change(function() {
                                                            if ($(this).val() === 'yes') {
                                                                $('.microbiology_person').show();
                                                                $('.microbiology_person span').show();
                                                            } else {
                                                                $('.microbiology_person').hide();
                                                                $('.microbiology_person span').hide();
                                                            }
                                                        });
                                                    @endif
                                                });
                                            </script>
                                            @if($data->stage == 3 || $data->stage == 4)

                                            <!-- Microbiology Review -->
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="Microbiology Review">Microbiology Review Required ?<span class="text-danger">*</span></label>
                                                    <select name="Microbiology_Review" id="Microbiology_Review" required  @if($data->stage == 4) disabled @endif>
                                                        <option value="">-- Select --</option>
                                                        <option @if($data1->Microbiology_Review == 'yes') selected @endif value="yes">Yes</option>
                                                        <option @if($data1->Microbiology_Review == 'no') selected @endif value="no">No</option>
                                                        <option @if($data1->Microbiology_Review == 'na') selected @endif value="na">NA</option>
                                                    </select>
                                                </div>
                                            </div>

                                            @php
                                                $userRoles = DB::table('user_roles')
                                                    ->where([
                                                        'q_m_s_roles_id' => 56,
                                                        'q_m_s_divisions_id' => $data->division_id,
                                                    ])->get();
                                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); 
                                            @endphp

                                            <!-- Microbiology Person -->
                                            <div class="col-lg-6 microbiology_person">
                                                <div class="group-input">
                                                    <label for="Microbiology person">Microbiology Person</label>
                                                    <select name="Microbiology_person" id="Microbiology_person" @if($data->stage == 4) readonly @endif>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}" @if($data1->Microbiology_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Microbiology Comment -->
                                            <div class="col-md-12 mb-3 microbiology_person">
                                                <div class="group-input">
                                                    <label for="Microbiology comment">Microbiology Assessment</label>
                                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                    <textarea  name="Microbiology_assessment" id="summernote-17" @if ($data1->Microbiology_Review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->Microbiology_person) && Auth::user()->id != $data1->Microbiology_person)) disabled @endif>{{ $data1->Microbiology_assessment }}</textarea>                                              

                                                 
                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-3 microbiology_person">
                                                <div class="group-input">
                                                    <label for="Microbiology comment">Microbiology Feedback</label>
                                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                    <textarea  name="Microbiology_feedback" id="summernote-17" @if ($data1->Microbiology_Review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->Microbiology_person) && Auth::user()->id != $data1->Microbiology_person)) disabled @endif>{{ $data1->Microbiology_feedback }}</textarea>                                              


                                                </div>
                                            </div>

                                            <!-- Microbiology Attachments -->
                                            <div class="col-lg-12 microbiology_person">
                                                <div class="group-input">
                                                    <label for="Microbiology attachment">Microbiology Attachments</label>
                                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                    <div class="file-attachment-field">
                                                        <div class="file-attachment-list" id="Microbiology_attachment">
                                                            @if($data1->Microbiology_attachment)
                                                                @foreach(json_decode($data1->Microbiology_attachment) as $file)
                                                                    <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                        <b>{{ $file }}</b>
                                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary"
                                                                                style="font-size: 20px; margin-right: -10px;"></i></a>
                                                                        <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                                class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i></a>
                                                                    </h6>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="add-btn">
                                                            <div>Add</div>
                                                            <input type="file" id="myfile" name="Microbiology_attachment[]" multiple 
                                                                @if($data->stage == 0 || $data->stage == 8) readonly @endif 
                                                                oninput="addMultipleFiles(this, 'Microbiology_attachment')">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Microbiology Review Completed By -->
                                            <div class="col-md-6 mb-3 microbiology_person">
                                                <div class="group-input">
                                                    <label for="Microbiology Review Completed By">Microbiology Review Completed By</label>
                                                    <input readonly type="text" name="Microbiology_by" value="{{ $data1->Microbiology_by }}">
                                                </div>
                                            </div>

                                            <!-- Microbiology Review Completed On -->
                                            <div class="col-lg-6 new-date-data-field microbiology_person">
                                                <div class="group-input input-date">
                                                    <label for="Microbiology Review Completed On">Microbiology Review Completed On</label>
                                                    <div class="calenderauditee">
                                                        <input type="text" id="Microbiology_on" readonly placeholder="DD-MM-YYYY" 
                                                            value="{{ Helpers::getdateFormat($data1->Microbiology_on) }}" />
                                                        <input readonly type="date" name="Microbiology_on" class="hide-input" 
                                                            oninput="handleDateInput(this, 'Microbiology_on')" />
                                                    </div>
                                                </div>
                                            </div>

                                            @else

                                            <!-- Microbiology Review (Disabled) -->
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="Microbiology Review">Microbiology Review Required?</label>
                                                    <select name="Microbiology_Review" id="Microbiology_Review" disabled>
                                                        <option value="">-- Select --</option>
                                                        <option @if($data1->Microbiology_Review == 'yes') selected @endif value="yes">Yes</option>
                                                        <option @if($data1->Microbiology_Review == 'no') selected @endif value="no">No</option>
                                                        <option @if($data1->Microbiology_Review == 'na') selected @endif value="na">NA</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Microbiology Person (Disabled) -->
                                            <div class="col-lg-6 microbiology_person">
                                                <div class="group-input">
                                                    <label for="Microbiology person">Microbiology Person</label>
                                                    <select name="Microbiology_person" id="Microbiology_person" disabled>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}" @if($data1->Microbiology_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Microbiology Comment (Disabled) -->
                                            <div class="col-md-12 mb-3 microbiology_person">
                                                <div class="group-input">
                                                    <label for="Microbiology comment">Microbiology Assessment</label>
                                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                    <textarea  name="Microbiology_assessment" id="summernote-17" @if ($data1->Microbiology_Review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->Microbiology_person) && Auth::user()->id != $data1->Microbiology_person)) disabled @endif>{{ $data1->Microbiology_assessment }}</textarea>                                              
                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-3 microbiology_person">
                                                <div class="group-input">
                                                    <label for="Microbiology comment">Microbiology Feedback</label>
                                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                    <textarea  name="Microbiology_feedback" id="summernote-17" @if ($data1->Microbiology_Review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->Microbiology_person) && Auth::user()->id != $data1->Microbiology_person)) disabled @endif>{{ $data1->Microbiology_feedback }}</textarea>                                              

                                                </div>
                                            </div>

                                            <!-- Microbiology Attachments (Disabled) -->
                                            <div class="col-lg-12 microbiology_person">
                                                <div class="group-input">
                                                    <label for="Microbiology attachment">Microbiology Attachments</label>
                                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                    <div class="file-attachment-list" id="Microbiology_attachment">
                                                        @if($data1->Microbiology_attachment)
                                                            @foreach(json_decode($data1->Microbiology_attachment) as $file)
                                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                    <b>{{ $file }}</b>
                                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary"
                                                                            style="font-size: 20px; margin-right: -10px;"></i></a>
                                                                    <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                            class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i></a>
                                                                </h6>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Microbiology Review Completed By (Disabled) -->
                                            <div class="col-md-6 mb-3 microbiology_person">
                                                <div class="group-input">
                                                    <label for="Microbiology Review Completed By">Microbiology Review Completed By</label>
                                                    <input readonly type="text" name="Microbiology_by" value="{{ $data1->Microbiology_by }}">
                                                </div>
                                            </div>

                                            <!-- Microbiology Review Completed On (Disabled) -->
                                            <div class="col-lg-6 new-date-data-field microbiology_person">
                                                <div class="group-input input-date">
                                                    <label for="Microbiology Review Completed On">Microbiology Review Completed On</label>
                                                    <div class="calenderauditee">
                                                        <input type="text" id="Microbiology_on" readonly placeholder="DD-MM-YYYY" 
                                                            value="{{ Helpers::getdateFormat($data1->Microbiology_on) }}" />
                                                        <input readonly type="date" name="Microbiology_on" class="hide-input" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            <!-- Sysyem IT Department -->
                                            @php
                                                $data1 = DB::table('capa_cfts')
                                                    ->where('capa_id', $data->id)
                                                    ->first();
                                            @endphp
                                            <div class="sub-head">
                                                System IT
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    @if($data1->SystemIT_Review !== 'yes')
                                                    $('.systemit_person').hide();

                                                    $('[name="SystemIT_Review"]').change(function() {
                                                        if ($(this).val() === 'yes') {
                                                            $('.systemit_person').show();
                                                            $('.systemit_person span').show();
                                                        } else {
                                                            $('.systemit_person').hide();
                                                            $('.systemit_person span').hide();
                                                        }
                                                    });
                                                    @endif
                                                });
                                            </script>
                                            @if($data->stage == 3 || $data->stage == 4)

                                            <!-- System IT Review -->
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="System IT Review">System IT Review Required ?<span class="text-danger">*</span></label>
                                                    <select name="SystemIT_Review" id="SystemIT_Review"required @if($data->stage == 4) disabled @endif>
                                                        <option value="">-- Select --</option>
                                                        <option @if($data1->SystemIT_Review == 'yes') selected @endif value="yes">Yes</option>
                                                        <option @if($data1->SystemIT_Review == 'no') selected @endif value="no">No</option>
                                                        <option @if($data1->SystemIT_Review == 'na') selected @endif value="na">NA</option>
                                                    </select>
                                                </div>
                                            </div>

                                            @php
                                                $userRoles = DB::table('user_roles')
                                                    ->where([
                                                        'q_m_s_roles_id' => 32,
                                                        'q_m_s_divisions_id' => $data->division_id,
                                                    ])->get();
                                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get();
                                            @endphp

                                            <!-- System IT Person -->
                                            <div class="col-lg-6 systemit_person">
                                                <div class="group-input">
                                                    <label for="System IT person">System IT Person</label>
                                                    <select name="SystemIT_person" id="SystemIT_person" @if($data->stage == 4) readonly @endif>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}" @if($data1->SystemIT_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- System IT Comment -->
                                            <div class="col-md-12 mb-3 systemit_person">
                                                <div class="group-input">
                                                    <label for="System IT comment">System IT Comment</label>
                                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                    <textarea class="{{ $data->stage == 3 || (isset($data1->SystemIT_person) && Auth::user()->id != $data1->SystemIT_person) ? 'tiny-disable' : 'tiny' }}" name="SystemIT_comment" id="summernote-19"
                                                        @if($data1->SystemIT_Review == 'yes' && $data->stage == 4) required @endif
                                                        @if($data->stage == 3 || (isset($data1->SystemIT_person) && Auth::user()->id != $data1->SystemIT_person)) readonly @endif>{{ $data1->SystemIT_comment }}</textarea>
                                                </div>
                                            </div>

                                            <!-- System IT Attachments -->
                                            <div class="col-lg-12 systemit_person">
                                                <div class="group-input">
                                                    <label for="System IT attachment">System IT Attachments</label>
                                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                    <div class="file-attachment-field">
                                                        <div class="file-attachment-list" id="SystemIT_attachment">
                                                            @if($data1->SystemIT_attachment)
                                                                @foreach(json_decode($data1->SystemIT_attachment) as $file)
                                                                    <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                        <b>{{ $file }}</b>
                                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size: 20px; margin-right: -10px;"></i></a>
                                                                        <a type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i></a>
                                                                    </h6>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="add-btn">
                                                            <div>Add</div>
                                                            <input type="file" id="myfile" name="SystemIT_attachment[]" multiple
                                                                @if($data->stage == 0 || $data->stage == 8) readonly @endif
                                                                oninput="addMultipleFiles(this, 'SystemIT_attachment')">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- System IT Review Completed By -->
                                            <div class="col-md-6 mb-3 systemit_person">
                                                <div class="group-input">
                                                    <label for="System IT Review Completed By">System IT Review Completed By</label>
                                                    <input readonly type="text" name="SystemIT_by" value="{{ $data1->SystemIT_by }}">
                                                </div>
                                            </div>

                                            <!-- System IT Review Completed On -->
                                            <div class="col-lg-6 new-date-data-field systemit_person">
                                                <div class="group-input input-date">
                                                    <label for="System IT Review Completed On">System IT Review Completed On</label>
                                                    <div class="calenderauditee">
                                                        <input type="text" id="SystemIT_on" readonly placeholder="DD-MM-YYYY"
                                                            value="{{ Helpers::getdateFormat($data1->SystemIT_on) }}" />
                                                        <input readonly type="date" name="SystemIT_on" class="hide-input"
                                                            oninput="handleDateInput(this, 'SystemIT_on')" />
                                                    </div>
                                                </div>
                                            </div>

                                            @else

                                            <!-- System IT Review (Disabled) -->
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="System IT Review">System IT Review Required?</label>
                                                    <select name="SystemIT_Review" id="SystemIT_Review" disabled>
                                                        <option value="">-- Select --</option>
                                                        <option @if($data1->SystemIT_Review == 'yes') selected @endif value="yes">Yes</option>
                                                        <option @if($data1->SystemIT_Review == 'no') selected @endif value="no">No</option>
                                                        <option @if($data1->SystemIT_Review == 'na') selected @endif value="na">NA</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- System IT Person (Disabled) -->
                                            <div class="col-lg-6 systemit_person">
                                                <div class="group-input">
                                                    <label for="System IT person">System IT Person</label>
                                                    <select name="SystemIT_person" id="SystemIT_person" disabled>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}" @if($data1->SystemIT_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- System IT Comment (Disabled) -->
                                            <div class="col-md-12 mb-3 systemit_person">
                                                <div class="group-input">
                                                    <label for="System IT comment">System IT Comment</label>
                                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                    <textarea class="{{ $data->stage == 3 || (isset($data1->SystemIT_person) && Auth::user()->id != $data1->SystemIT_person) ? 'tiny-disable' : 'tiny' }}" name="SystemIT_comment" id="summernote-19" readonly>{{ $data1->SystemIT_comment }}</textarea>
                                                </div>
                                            </div>

                                            <!-- System IT Attachments (Disabled) -->
                                            <div class="col-lg-12 systemit_person">
                                                <div class="group-input">
                                                    <label for="System IT attachment">System IT Attachments</label>
                                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                    <div class="file-attachment-list" id="SystemIT_attachment">
                                                        @if($data1->SystemIT_attachment)
                                                            @foreach(json_decode($data1->SystemIT_attachment) as $file)
                                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                    <b>{{ $file }}</b>
                                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size: 20px; margin-right: -10px;"></i></a>
                                                                    <a type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i></a>
                                                                </h6>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- System IT Review Completed By (Disabled) -->
                                            <div class="col-md-6 mb-3 systemit_person">
                                                <div class="group-input">
                                                    <label for="System IT Review Completed By">System IT Review Completed By</label>
                                                    <input readonly type="text" name="SystemIT_by" value="{{ $data1->SystemIT_by }}" readonly>
                                                </div>
                                            </div>

                                            <!-- System IT Review Completed On (Disabled) -->
                                            <div class="col-lg-6 new-date-data-field systemit_person">
                                                <div class="group-input input-date">
                                                    <label for="System IT Review Completed On">System IT Review Completed On</label>
                                                    <div class="calenderauditee">
                                                        <input type="text" id="SystemIT_on" readonly placeholder="DD-MM-YYYY"
                                                            value="{{ Helpers::getdateFormat($data1->SystemIT_on) }}" />
                                                        <input readonly type="date" name="SystemIT_on" class="hide-input" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                            @endif


                                            <!-- Quality Assurance Department -->
                                            @php
                                                $data1 = DB::table('capa_cfts')
                                                    ->where('capa_id', $data->id)
                                                    ->first();
                                            @endphp
                                            <div class="sub-head">
                                                Quality Assurance
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    @if($data1->Quality_Assurance_Review !== 'yes')
                                                    $('.quality_assurance').hide();

                                                    $('[name="Quality_Assurance_Review"]').change(function() {
                                                        if ($(this).val() === 'yes') {
                                                            $('.quality_assurance').show();
                                                            $('.quality_assurance span').show();
                                                        } else {
                                                            $('.quality_assurance').hide();
                                                            $('.quality_assurance span').hide();
                                                        }
                                                    });
                                                    @endif
                                                });
                                            </script>

                                            @if($data->stage == 3 || $data->stage == 4)
                                            <!-- Quality Assurance Review -->
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="Customer notification">Quality Assurance Review Required ?<span class="text-danger">*</span></label>
                                                    <select name="Quality_Assurance_Review" id="QualityAssurance_review" required @if($data->stage == 4) disabled @endif>
                                                        <option value="">-- Select --</option>
                                                        <option @if($data1->Quality_Assurance_Review == 'yes') selected @endif value="yes">Yes</option>
                                                        <option @if($data1->Quality_Assurance_Review == 'no') selected @endif value="no">No</option>
                                                        <option @if($data1->Quality_Assurance_Review == 'na') selected @endif value="na">NA</option>
                                                    </select>
                                                </div>
                                            </div>

                                            @php
                                                $userRoles = DB::table('user_roles')
                                                    ->where([
                                                        'q_m_s_roles_id' => 26,
                                                        'q_m_s_divisions_id' => $data->division_id,
                                                    ])->get();
                                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get();
                                            @endphp

                                            <!-- Quality Assurance Person -->
                                            <div class="col-lg-6 quality_assurance">
                                                <div class="group-input">
                                                    <label for="Quality Assurance Person">Quality Assurance Person</label>
                                                    <select name="QualityAssurance_person" id="QualityAssurance_person" @if($data->stage == 4) readonly @endif>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}" @if($data1->QualityAssurance_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Quality Assurance Comment -->
                                            <div class="col-md-12 mb-3 quality_assurance">
                                                <div class="group-input">
                                                    <label for="Impact Assessment3">Quality Assurance Assessment</label>
                                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                    <textarea  name="QualityAssurance_assessment" id="summernote-17" @if ($data1->Quality_Assurance_Review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->QualityAssurance_person) && Auth::user()->id != $data1->QualityAssurance_person)) disabled @endif>{{ $data1->QualityAssurance_assessment }}</textarea>                                              


                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-3 quality_assurance">
                                                <div class="group-input">
                                                    <label for="Impact Assessment3">Quality Assurance Feedback</label>
                                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                    <textarea  name="QualityAssurance_feedback" id="summernote-17" @if ($data1->Quality_Assurance_Review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->QualityAssurance_person) && Auth::user()->id != $data1->QualityAssurance_person)) disabled @endif>{{ $data1->QualityAssurance_feedback }}</textarea>                                              

                                                </div>
                                            </div>

                                            <!-- Quality Assurance Attachments -->
                                            <div class="col-lg-12 quality_assurance">
                                                <div class="group-input">
                                                    <label for="Quality Assurance Attachments">Quality Assurance Attachments</label>
                                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                    <div class="file-attachment-field">
                                                        <div class="file-attachment-list" id="Quality_Assurance_attachment">
                                                            @if($data1->Quality_Assurance_attachment)
                                                                @foreach(json_decode($data1->Quality_Assurance_attachment) as $file)
                                                                    <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                        <b>{{ $file }}</b>
                                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary"
                                                                                style="font-size: 20px; margin-right: -10px;"></i></a>
                                                                        <a type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark"
                                                                                style="color: red; font-size: 20px;"></i></a>
                                                                    </h6>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="add-btn">
                                                            <div>Add</div>
                                                            <input type="file" id="myfile" name="Quality_Assurance_attachment[]" multiple
                                                                @if($data->stage == 0 || $data->stage == 8) readonly @endif
                                                                oninput="addMultipleFiles(this, 'Quality_Assurance_attachment')">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Quality Assurance Review Completed By -->
                                            <div class="col-md-6 mb-3 quality_assurance">
                                                <div class="group-input">
                                                    <label for="Quality Assurance Review Completed By">Quality Assurance Review Completed By</label>
                                                    <input readonly type="text" name="QualityAssurance_by" value="{{ $data1->QualityAssurance_by }}">
                                                </div>
                                            </div>

                                            <!-- Quality Assurance Review Completed On -->
                                            <div class="col-lg-6 new-date-data-field quality_assurance">
                                                <div class="group-input input-date">
                                                    <label for="Quality Assurance Review Completed On">Quality Assurance Review Completed On</label>
                                                    <div class="calenderauditee">
                                                        <input type="text" id="QualityAssurance_on" readonly placeholder="DD-MM-YYYY"
                                                            value="{{ Helpers::getdateFormat($data1->QualityAssurance_on) }}" />
                                                        <input readonly type="date" name="QualityAssurance_on" class="hide-input"
                                                            oninput="handleDateInput(this, 'QualityAssurance_on')" />
                                                    </div>
                                                </div>
                                            </div>

                                            @else

                                            <!-- Quality Assurance Review (Disabled) -->
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="Customer notification">Quality Assurance Review Required?</label>
                                                    <select name="Quality_Assurance_Review" id="QualityAssurance_review" disabled>
                                                        <option value="">-- Select --</option>
                                                        <option @if($data1->Quality_Assurance_Review == 'yes') selected @endif value="yes">Yes</option>
                                                        <option @if($data1->Quality_Assurance_Review == 'no') selected @endif value="no">No</option>
                                                        <option @if($data1->Quality_Assurance_Review == 'na') selected @endif value="na">NA</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Quality Assurance Person (Disabled) -->
                                            <div class="col-lg-6 quality_assurance">
                                                <div class="group-input">
                                                    <label for="Quality Assurance Person">Quality Assurance Person</label>
                                                    <select name="QualityAssurance_person" id="QualityAssurance_person" disabled>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}" @if($data1->QualityAssurance_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Quality Assurance Comment (Disabled) -->
                                            <div class="col-md-12 mb-3 quality_assurance">
                                                <div class="group-input">
                                                    <label for="Impact Assessment3">Quality Assurance Assessment</label>
                                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                    <textarea  name="QualityAssurance_assessment" id="summernote-17" @if ($data1->Quality_Assurance_Review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->QualityAssurance_person) && Auth::user()->id != $data1->QualityAssurance_person)) disabled @endif>{{ $data1->QualityAssurance_assessment }}</textarea>                                              

                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-3 quality_assurance">
                                                <div class="group-input">
                                                    <label for="Impact Assessment3">Quality Assurance Feedback</label>
                                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                    <textarea  name="QualityAssurance_feedback" id="summernote-17" @if ($data1->Quality_Assurance_Review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->QualityAssurance_person) && Auth::user()->id != $data1->QualityAssurance_person)) disabled @endif>{{ $data1->QualityAssurance_feedback }}</textarea>                                              

                                                </div>
                                            </div>

                                            <!-- Quality Assurance Attachments (Disabled) -->
                                            <div class="col-lg-12 quality_assurance">
                                                <div class="group-input">
                                                    <label for="Quality Assurance Attachments">Quality Assurance Attachments</label>
                                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                    <div class="file-attachment-list" id="Quality_Assurance_attachment">
                                                        @if($data1->Quality_Assurance_attachment)
                                                            @foreach(json_decode($data1->Quality_Assurance_attachment) as $file)
                                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                    <b>{{ $file }}</b>
                                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary"
                                                                            style="font-size: 20px; margin-right: -10px;"></i></a>
                                                                    <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                                                            class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i></a>
                                                                </h6>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Quality Assurance Review Completed By (Disabled) -->
                                            <div class="col-md-6 mb-3 quality_assurance">
                                                <div class="group-input">
                                                    <label for="Quality Assurance Review Completed By">Quality Assurance Review Completed By</label>
                                                    <input readonly type="text" name="QualityAssurance_by" value="{{ $data1->QualityAssurance_by }}" readonly>
                                                </div>
                                            </div>

                                            <!-- Quality Assurance Review Completed On (Disabled) -->
                                            <div class="col-lg-6 new-date-data-field quality_assurance">
                                                <div class="group-input input-date">
                                                    <label for="Quality Assurance Review Completed On">Quality Assurance Review Completed On</label>
                                                    <div class="calenderauditee">
                                                        <input type="text" id="QualityAssurance_on" readonly placeholder="DD-MM-YYYY"
                                                            value="{{ Helpers::getdateFormat($data1->QualityAssurance_on) }}" />
                                                        <input readonly type="date" name="QualityAssurance_on" class="hide-input" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                            @endif


                                            <!-- Human Resource & Administration Department -->
                                            @php
                                                $data1 = DB::table('capa_cfts')
                                                    ->where('capa_id', $data->id)
                                                    ->first();
                                            @endphp
                                            <div class="sub-head">
                                                Human Resource & Administration
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    
                                                    @if($data1->Human_Resource_review !== 'yes')
                                                    $('.human_resources').hide();

                                                    $('[name="Human_Resource_review"]').change(function() {
                                                        if ($(this).val() === 'yes') {
                                                            $('.human_resources').show();
                                                            $('.human_resources span').show();
                                                        } else {
                                                            $('.human_resources').hide();
                                                            $('.human_resources span').hide();
                                                        }
                                                    });
                                                    @endif
                                                });
                                            </script>

                                            @if($data->stage == 3 || $data->stage == 4)

                                            <!-- Human Resource & Administration Review -->
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="Administration Review Required">Human Resource & Administration Review Required ?<span class="text-danger">*</span></label>
                                                    <select name="Human_Resource_review" id="Human_Resource_review" required @if($data->stage == 4) disabled @endif>
                                                        <option value="">-- Select --</option>
                                                        <option @if($data1->Human_Resource_review == 'yes') selected @endif value="yes">Yes</option>
                                                        <option @if($data1->Human_Resource_review == 'no') selected @endif value="no">No</option>
                                                        <option @if($data1->Human_Resource_review == 'na') selected @endif value="na">NA</option>
                                                    </select>
                                                </div>
                                            </div>

                                            @php
                                                $userRoles = DB::table('user_roles')
                                                    ->where([
                                                        'q_m_s_roles_id' => 31,
                                                        'q_m_s_divisions_id' => $data->division_id,
                                                    ])->get();
                                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get();
                                            @endphp

                                            <!-- Human Resource & Administration Person -->
                                            <div class="col-lg-6 human_resources">
                                                <div class="group-input">
                                                    <label for="Administration Person">Human Resource & Administration Person</label>
                                                    <select name="Human_Resource_person" id="Human_Resource_person" @if($data->stage == 4) readonly @endif>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}" @if($data1->Human_Resource_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Human Resource & Administration Comment -->
                                            <div class="col-md-12 mb-3 human_resources">
                                                <div class="group-input">
                                                    <label for="Impact Assessment9">Human Resource & Administration Assessment</label>
                                                    <textarea  name="Human_Resource_assessment" id="summernote-17" @if ($data1->Human_Resource_review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->Human_Resource_person) && Auth::user()->id != $data1->Human_Resource_person)) disabled @endif>{{ $data1->Human_Resource_assessment }}</textarea>                                              

                                                    
                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-3 human_resources">
                                                <div class="group-input">
                                                    <label for="Impact Assessment9">Human Resource & Administration Feedback</label>
                                                    <textarea  name="Human_Resource_feedback" id="summernote-17" @if ($data1->Human_Resource_review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->Human_Resource_person) && Auth::user()->id != $data1->Human_Resource_person)) disabled @endif>{{ $data1->Human_Resource_feedback }}</textarea>                                              


                                                </div>
                                            </div>

                                            <!-- Human Resource & Administration Attachments -->
                                            <div class="col-lg-12 human_resources">
                                                <div class="group-input">
                                                    <label for="Audit Attachments">Human Resource & Administration Attachments</label>
                                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                    <div class="file-attachment-field">
                                                        <div class="file-attachment-list" id="Human_Resource_attachment">
                                                            @if($data1->Human_Resource_attachment)
                                                                @foreach(json_decode($data1->Human_Resource_attachment) as $file)
                                                                    <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                        <b>{{ $file }}</b>
                                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                                            <i class="fa fa-eye text-primary" style="font-size: 20px; margin-right: -10px;"></i>
                                                                        </a>
                                                                        <a type="button" class="remove-file" data-file-name="{{ $file }}">
                                                                            <i class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i>
                                                                        </a>
                                                                    </h6>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="add-btn">
                                                            <div>Add</div>
                                                            <input type="file" id="myfile" name="Human_Resource_attachment[]" multiple
                                                                @if($data->stage == 0 || $data->stage == 8) readonly @endif
                                                                oninput="addMultipleFiles(this, 'Human_Resource_attachment')">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Human Resource & Administration Review Completed By -->
                                            <div class="col-md-6 mb-3 human_resources">
                                                <div class="group-input">
                                                    <label for="Administration Review Completed By">Human Resource & Administration Review Completed By</label>
                                                    <input readonly type="text" name="Human_Resource_by" value="{{ $data1->Human_Resource_by }}">
                                                </div>
                                            </div>

                                            <!-- Human Resource & Administration Review Completed On -->
                                            <div class="col-lg-6 new-date-data-field human_resources">
                                                <div class="group-input input-date">
                                                    <label for="Administration Review Completed On">Human Resource & Administration Review Completed On</label>
                                                    <div class="calenderauditee">
                                                        <input type="text" id="Human_Resource_on" readonly placeholder="DD-MM-YYYY"
                                                            value="{{ Helpers::getdateFormat($data1->Human_Resource_on) }}" />
                                                        <input readonly type="date" name="Human_Resource_on" class="hide-input"
                                                            oninput="handleDateInput(this, 'Human_Resource_on')" />
                                                    </div>
                                                </div>
                                            </div>

                                            @else

                                            <!-- Human Resource & Administration Review (Disabled) -->
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="Administration Review Required">Human Resource & Administration Review Required?</label>
                                                    <select name="Human_Resource_review" id="Human_Resource_review" disabled>
                                                        <option value="">-- Select --</option>
                                                        <option @if($data1->Human_Resource_review == 'yes') selected @endif value="yes">Yes</option>
                                                        <option @if($data1->Human_Resource_review == 'no') selected @endif value="no">No</option>
                                                        <option @if($data1->Human_Resource_review == 'na') selected @endif value="na">NA</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            @php 
                                                $usersList = DB::table('users')->get();
                                            @endphp
                                            <!-- Human Resource & Administration Person (Disabled) -->
                                            <div class="col-lg-6 human_resources">
                                                <div class="group-input">
                                                    <label for="Administration Person">Human Resource & Administration Person</label>
                                                    <select name="Human_Resource_person" id="Human_Resource_person" disabled>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($usersList as $user)
                                                            <option value="{{ $user->id }}" @if($data1->Human_Resource_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Human Resource & Administration Comment (Disabled) -->
                                            <div class="col-md-12 mb-3 human_resources">
                                                <div class="group-input">
                                                    <label for="Impact Assessment9">Human Resource & Administration Assessment</label>
                                                    <textarea  name="Human_Resource_assessment" id="summernote-17" @if ($data1->Human_Resource_review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->Human_Resource_person) && Auth::user()->id != $data1->Human_Resource_person)) disabled @endif>{{ $data1->Human_Resource_assessment }}</textarea>                                              
                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-3 human_resources">
                                                <div class="group-input">
                                                    <label for="Impact Assessment9">Human Resource & Administration Feedback</label>
                                                    <textarea  name="Human_Resource_feedback" id="summernote-17" @if ($data1->Human_Resource_review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->Human_Resource_person) && Auth::user()->id != $data1->Human_Resource_person)) disabled @endif>{{ $data1->Human_Resource_feedback }}</textarea>                                              

                                                </div>
                                            </div>

                                            <!-- Human Resource & Administration Attachments (Disabled) -->
                                            <div class="col-lg-12 human_resources">
                                                <div class="group-input">
                                                    <label for="Audit Attachments">Human Resource & Administration Attachments</label>
                                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                    <div class="file-attachment-list" id="Human_Resource_attachment">
                                                        @if($data1->Human_Resource_attachment)
                                                            @foreach(json_decode($data1->Human_Resource_attachment) as $file)
                                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                    <b>{{ $file }}</b>
                                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                                        <i class="fa fa-eye text-primary" style="font-size: 20px; margin-right: -10px;"></i>
                                                                    </a>
                                                                    <a type="button" class="remove-file" data-file-name="{{ $file }}">
                                                                        <i class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i>
                                                                    </a>
                                                                </h6>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Human Resource & Administration Review Completed By (Disabled) -->
                                            <div class="col-md-6 mb-3 human_resources">
                                                <div class="group-input">
                                                    <label for="Administration Review Completed By">Human Resource & Administration Review Completed By</label>
                                                    <input readonly type="text" name="Human_Resource_by" value="{{ $data1->Human_Resource_by }}" readonly>
                                                </div>
                                            </div>

                                            <!-- Human Resource & Administration Review Completed On (Disabled) -->
                                            <div class="col-lg-6 new-date-data-field human_resources">
                                                <div class="group-input input-date">
                                                    <label for="Administration Review Completed On">Human Resource & Administration Review Completed On</label>
                                                    <div class="calenderauditee">
                                                        <input type="text" id="Human_Resource_on" readonly placeholder="DD-MM-YYYY"
                                                            value="{{ Helpers::getdateFormat($data1->Human_Resource_on) }}" />
                                                        <input readonly type="date" name="Human_Resource_on" class="hide-input" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            <!-- Other's 1 Department -->
                                            @php
                                                $data1 = DB::table('capa_cfts')
                                                    ->where('capa_id', $data->id)
                                                    ->first();
                                            @endphp
                                            <div class="sub-head">
                                                Other's 1 ( Additional Person Review From Departments If Required)
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    @if($data1->Other2_review !== 'yes')
                                                    $('.other1_reviews').hide();

                                                    $('[name="Other1_review"]').change(function() {
                                                        if ($(this).val() === 'yes') {
                                                            $('.other1_reviews').show();
                                                            $('.other1_reviews span').show();
                                                        } else {
                                                            $('.other1_reviews').hide();
                                                            $('.other1_reviews span').hide();
                                                        }
                                                    });
                                                    @endif
                                                });
                                            </script>
                                            @if($data->stage == 3 || $data->stage == 4)

                                            <!-- Other's 1 Review -->
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="Customer notification">Other's 1 Review Required ?</label>
                                                    <select name="Other1_review" id="Other1_review" required @if($data->stage == 4) disabled @endif>
                                                        <option value="">-- Select --</option>
                                                        <option @if($data1->Other1_review == 'yes') selected @endif value="yes">Yes</option>
                                                        <option @if($data1->Other1_review == 'no') selected @endif value="no">No</option>
                                                        <option @if($data1->Other1_review == 'na') selected @endif value="na">NA</option>
                                                    </select>
                                                </div>
                                            </div>

                                            @php
                                                $userRoles = DB::table('user_roles')
                                                    ->where([
                                                        'q_m_s_roles_id' => 18,
                                                        'q_m_s_divisions_id' => $data->division_id,
                                                    ])->get();
                                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get();
                                            @endphp

                                            <!-- Other's 1 Person -->
                                            <div class="col-lg-6 other1_reviews">
                                                <div class="group-input">
                                                    <label for="Customer notification">Other's 1 Person</label>
                                                    <select name="Other1_person" id="Other1_person" @if($data->stage == 4) readonly @endif>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($Allusers as $user)
                                                            <option value="{{ $user->id }}" @if($data1->Other1_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Other's 1 Department -->
                                            <div class="col-lg-12 other1_reviews">
                                                <div class="group-input">
                                                    <label for="Customer notification">Other's 1 Department</label>
                                                    <select name="Other1_Department_person" id="Other1_Department_person" @if($data->stage == 4) readonly @endif>
                                                        <option value="">-- Select --</option>
                                                        <option @if($data1->Other1_Department_person == 'Production') selected @endif value="Production">Production</option>
                                                        <option @if($data1->Other1_Department_person == 'Warehouse') selected @endif value="Warehouse">Warehouse</option>
                                                        <option @if($data1->Other1_Department_person == 'Quality_Control') selected @endif value="Quality_Control">Quality Control</option>
                                                        <option @if($data1->Other1_Department_person == 'Quality_Assurance_Review') selected @endif value="Quality_Assurance_Review">Quality Assurance</option>
                                                        <option @if($data1->Other1_Department_person == 'Engineering') selected @endif value="Engineering">Engineering</option>
                                                        <option @if($data1->Other1_Department_person == 'Analytical_Development_Laboratory') selected @endif value="Analytical_Development_Laboratory">Analytical Development Laboratory</option>
                                                        <option @if($data1->Other1_Department_person == 'Process_Development_Lab') selected @endif value="Process_Development_Lab">Process Development Lab</option>
                                                        <option @if($data1->Other1_Department_person == 'Technology transfer/Design') selected @endif value="Technology transfer/Design">Technology Transfer/Design</option>
                                                        <option @if($data1->Other1_Department_person == 'Environment, Health & Safety') selected @endif value="Environment, Health & Safety">Environment, Health & Safety</option>
                                                        <option @if($data1->Other1_Department_person == 'Human Resource & Administration') selected @endif value="Human Resource & Administration">Human Resource & Administration</option>
                                                        <option @if($data1->Other1_Department_person == 'Information Technology') selected @endif value="Information Technology">Information Technology</option>
                                                        <option @if($data1->Other1_Department_person == 'Project management') selected @endif value="Project management">Project management</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Other's 1 Comment -->
                                            <div class="col-md-12 mb-3 other1_reviews">
                                                <div class="group-input">
                                                    <label for="productionfeedback">Impact Assessment (By Other's 1)</label>
                                                    <textarea  name="Other1_assessment" id="summernote-17" @if ($data1->Other1_review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->Other1_person) && Auth::user()->id != $data1->Other1_person)) disabled @endif>{{ $data1->Other1_assessment }}</textarea>                                              

                                                    <!-- <textarea class="{{ $data->stage == 3 || (isset($data1->Other1_person) && Auth::user()->id != $data1->Other1_person) ? 'tiny-disable' : 'tiny' }}" name="Other1_assessment" id="summernote-41"
                                                        @if($data1->Other1_review == 'yes' && $data->stage == 4) required @endif
                                                        >{{ $data1->Other1_assessment }}</textarea> -->
                                                </div>
                                            </div>

                                            <!-- Other's 1 Attachments -->
                                            <div class="col-lg-12 other1_reviews">
                                                <div class="group-input">
                                                    <label for="Audit Attachments">Other's 1 Attachments</label>
                                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                    <div class="file-attachment-field">
                                                        <div class="file-attachment-list" id="Other1_attachment">
                                                            @if($data1->Other1_attachment)
                                                                @foreach(json_decode($data1->Other1_attachment) as $file)
                                                                    <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                        <b>{{ $file }}</b>
                                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                                            <i class="fa fa-eye text-primary" style="font-size: 20px; margin-right: -10px;"></i>
                                                                        </a>
                                                                        <a type="button" class="remove-file" data-file-name="{{ $file }}">
                                                                            <i class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i>
                                                                        </a>
                                                                    </h6>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="add-btn">
                                                            <div>Add</div>
                                                            <input type="file" id="myfile" name="Other1_attachment[]" multiple
                                                                @if($data->stage == 0 || $data->stage == 8) readonly @endif 
                                                                oninput="addMultipleFiles(this, 'Other1_attachment')">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Other's 1 Review Completed By -->
                                            <div class="col-md-6 mb-3 other1_reviews">
                                                <div class="group-input">
                                                    <label for="productionfeedback">Other's 1 Review Completed By</label>
                                                    <input readonly type="text" name="Other1_by" value="{{ $data1->Other1_by }}">
                                                </div>
                                            </div>

                                            <!-- Other's 1 Review Completed On -->
                                            <div class="col-lg-6 new-date-data-field other1_reviews">
                                                <div class="group-input input-date">
                                                    <label for="Review Completed On1">Other's 1 Review Completed On</label>
                                                    <div class="calenderauditee">
                                                        <input type="text" id="Other1_on" readonly placeholder="DD-MM-YYYY"
                                                            value="{{ Helpers::getdateFormat($data1->Other1_on) }}" />
                                                        <input readonly type="date" name="Other1_on" class="hide-input"
                                                            oninput="handleDateInput(this, 'Other1_on')" />
                                                    </div>
                                                </div>
                                            </div>

                                            @else

                                            <!-- Other's 1 Review (Disabled) -->
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="Customer notification">Other's 1 Review Required?</label>
                                                    <select name="Other1_review" id="Other1_review" disabled>
                                                        <option value="">-- Select --</option>
                                                        <option @if($data1->Other1_review == 'yes') selected @endif value="yes">Yes</option>
                                                        <option @if($data1->Other1_review == 'no') selected @endif value="no">No</option>
                                                        <option @if($data1->Other1_review == 'na') selected @endif value="na">NA</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Other's 1 Person (Disabled) -->
                                            <div class="col-lg-6 other1_reviews">
                                                <div class="group-input">
                                                    <label for="Customer notification">Other's 1 Person</label>
                                                    <select name="Other1_person" id="Other1_person" disabled>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($Allusers as $user)
                                                            <option value="{{ $user->id }}" @if($data1->Other1_person == $user->id) selected @endif>{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Other's 1 Department (Disabled) -->
                                            <div class="col-lg-12 other1_reviews">
                                                <div class="group-input">
                                                    <label for="Customer notification">Other's 1 Department</label>
                                                    <select name="Other1_Department_person" id="Other1_Department_person" readonly>
                                                        <option value="">-- Select --</option>
                                                        <option @if($data1->Other1_Department_person == 'Production') selected @endif value="Production">Production</option>
                                                        <option @if($data1->Other1_Department_person == 'Warehouse') selected @endif value="Warehouse">Warehouse</option>
                                                        <option @if($data1->Other1_Department_person == 'Quality_Control') selected @endif value="Quality_Control">Quality Control</option>
                                                        <option @if($data1->Other1_Department_person == 'Quality_Assurance_Review') selected @endif value="Quality_Assurance_Review">Quality Assurance</option>
                                                        <option @if($data1->Other1_Department_person == 'Engineering') selected @endif value="Engineering">Engineering</option>
                                                        <option @if($data1->Other1_Department_person == 'Analytical_Development_Laboratory') selected @endif value="Analytical_Development_Laboratory">Analytical Development Laboratory</option>
                                                        <option @if($data1->Other1_Department_person == 'Process_Development_Lab') selected @endif value="Process_Development_Lab">Process Development Lab</option>
                                                        <option @if($data1->Other1_Department_person == 'Technology transfer/Design') selected @endif value="Technology transfer/Design">Technology Transfer/Design</option>
                                                        <option @if($data1->Other1_Department_person == 'Environment, Health & Safety') selected @endif value="Environment, Health & Safety">Environment, Health & Safety</option>
                                                        <option @if($data1->Other1_Department_person == 'Human Resource & Administration') selected @endif value="Human Resource & Administration">Human Resource & Administration</option>
                                                        <option @if($data1->Other1_Department_person == 'Information Technology') selected @endif value="Information Technology">Information Technology</option>
                                                        <option @if($data1->Other1_Department_person == 'Project management') selected @endif value="Project management">Project management</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Other's 1 Comment (Disabled) -->
                                            <div class="col-md-12 mb-3 other1_reviews">
                                                <div class="group-input">
                                                    <label for="productionfeedback">Impact Assessment (By Other's 1)</label>
                                                    <textarea  name="Other1_assessment" id="summernote-17" @if ($data1->Other1_review == 'yes' && $data->stage == 4) required @endif @if ($data->stage == 3 || (isset($data1->Other1_person) && Auth::user()->id != $data1->Other1_person)) disabled @endif>{{ $data1->Other1_assessment }}</textarea>                                              
                                                </div>
                                            </div>

                                            <!-- Other's 1 Attachments (Disabled) -->
                                            <div class="col-lg-12 other1_reviews">
                                                <div class="group-input">
                                                    <label for="Audit Attachments">Other's 1 Attachments</label>
                                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                    <div class="file-attachment-list" id="Other1_attachment">
                                                        @if($data1->Other1_attachment)
                                                            @foreach(json_decode($data1->Other1_attachment) as $file)
                                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                    <b>{{ $file }}</b>
                                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                                        <i class="fa fa-eye text-primary" style="font-size: 20px; margin-right: -10px;"></i>
                                                                    </a>
                                                                    <a type="button" class="remove-file" data-file-name="{{ $file }}">
                                                                        <i class="fa-solid fa-circle-xmark" style="color: red; font-size: 20px;"></i>
                                                                    </a>
                                                                </h6>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Other's 1 Review Completed By (Disabled) -->
                                            <div class="col-md-6 mb-3 other1_reviews">
                                                <div class="group-input">
                                                    <label for="productionfeedback">Other's 1 Review Completed By</label>
                                                    <input readonly type="text" name="Other1_by" value="{{ $data1->Other1_by }}" readonly>
                                                </div>
                                            </div>

                                            <!-- Other's 1 Review Completed On (Disabled) -->
                                            <div class="col-lg-6 new-date-data-field other1_reviews">
                                                <div class="group-input input-date">
                                                    <label for="Review Completed On1">Other's 1 Review Completed On</label>
                                                    <div class="calenderauditee">
                                                        <input type="text" id="Other1_on" readonly placeholder="DD-MM-YYYY"
                                                            value="{{ Helpers::getdateFormat($data1->Other1_on) }}" />
                                                        <input readonly type="date" name="Other1_on" class="hide-input" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                            @endif


                                            
                                        </div>
                                        <div class="button-block">
                                            <button type="submit" class="saveButton">Save</button>
                                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                                    Exit
                                                </a> </button>
                                        </div>

                                    </div>
                     </div>
                                
<!--  QA Approval -->
<div id="CCForm17" class="inner-block cctabcontent">
    <div class="inner-block-content">
        <div class="row">
            <div class="col-12">
                <div class="group-input">
                    <label for="Comments"> QA/CQA  Approval Comment</label>
                    <textarea name="qa_approval_review" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>{{ $data->hod_final_review }}</textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="group-input">
                    <label for="Closure Attachments">QA/CQA  Approval Attachment</label>
                    <div><small class="text-primary">Please Attach all relevant or supporting
                            documents</small></div>
                    {{-- <input multiple type="file" id="myfile" name="qa_approval_attachment[]"> --}}
                    <div class="file-attachment-field">
                        <div class="file-attachment-list" id="qa_approval_attachment">

                            @if ($data->qa_approval_attachment)
                            @foreach (json_decode($data->qa_approval_attachment) as $file)
                                <h6 type="button" class="file-container text-dark"
                                    style="background-color: rgb(243, 242, 240);">
                                    <b>{{ $file }}</b>
                                    <a href="{{ asset('upload/' . $file) }}"
                                        target="_blank"><i class="fa fa-eye text-primary"
                                            style="font-size:20px; margin-right:-10px;"></i></a>
                                    <a type="button" class="remove-file"
                                        data-file-name="{{ $file }}"><i
                                            class="fa-solid fa-circle-xmark"
                                            style="color:red; font-size:20px;"></i></a>
                                </h6>
                            @endforeach
                        {{-- @endif --}}
                        @endif
                        </div>
                        <div class="add-btn">
                            <div>Add</div>
                            <input type="file" id="myfile" name="qa_approval_attachment[]"
                                oninput="addMultipleFiles(this, 'qa_approval_attachment')" multiple {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="col-12 sub-head">
                Effectiveness Check Details
            </div> -->
            <!-- <div class="col-12">
                <div class="group-input">
                    <label for="Effectiveness Check Required">Effectiveness Check
                        Required?</label>
                    <select name="effect_check" onChange="setCurrentDate(this.value)">
                        <option value="">Enter Your Selection Here</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
            </div> -->
            <!-- <div class="col-6 new-date-data-field">
                <div class="group-input input-date">
                    <label for="EffectCheck Creation Date">Effectiveness Check Creation Date</label>
                    {{-- <input type="date" name="effect_check_date"> --}}
                    <div class="calenderauditee">
                        <input type="text" name="effect_check_date" id="effect_check_date" readonly
                            placeholder="DD-MMM-YYYY" />
                        <input type="date" name="effect_check_date" class="hide-input"
                            oninput="handleDateInput(this, 'effect_check_date')" />
                    </div>
                </div>
            </div> -->
            <!-- <div class="col-6">
                <div class="group-input">
                    <label for="Effectiveness_checker">Effectiveness Checker</label>
                    <select id="select-state" placeholder="Select..." name="Effectiveness_checker">
                        <option value="">Select a person</option>
                        @foreach ($users as $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div> -->
            <!-- <div class="col-12">
                <div class="group-input">
                    <label for="effective_check_plan">Effectiveness Check Plan</label>
                    <textarea name="effective_check_plan"></textarea>
                </div>
            </div> -->
           
          
        </div>
        <div class="button-block">
            <button type="submit" class="saveButton" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>Save</button>
             <button type="button" class="backButton" onclick="previousStep()">Back</button>
            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
        </div>
    </div>
</div>


{{-- ==========================QA review tab ================ --}}

<div id="CCForm12" class="inner-block cctabcontent">
    <div class="inner-block-content">
        <div class="row">
            <div class="col-md-12">
                <div class="group-input">
                    <label for="Post Categorization">Post Categorization</label>
                    <select name="Post_Categorization" id="Post_Categorization" value="Post_Categorization">
                        <option value=""> -- Select --</option>
                        <option value="Major" {{ $data->Post_Categorization == 'Major' ? 'selected' : '' }}>Major</option>
                        <option value="Minor" {{ $data->Post_Categorization == 'Minor' ? 'selected' : '' }}>Minor</option>
                        <option value="Critical" {{ $data->Post_Categorization == 'Critical' ? 'selected' : '' }}>Critical</option>
                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="group-input">
                    <label for="Comments"> CAPA QA Review @if($data->stage == 3) <span class="text-danger">*</span>@endif </label>
                    <textarea name="capa_qa_comments" {{ $data->stage == 3  ? 'required' : '' }} {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>{{ $data->capa_qa_comments }}</textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="group-input">
                    <label for="Closure Attachments">QA Attachment</label>
                    <div><small class="text-primary">Please Attach all relevant or supporting
                            documents</small></div>
                    {{-- <input multiple type="file" id="myfile" name="closure_attachment[]"> --}}
                    <div class="file-attachment-field">
                        <div class="file-attachment-list" id="qa_attachment">

                            @if ($data->qa_attachment)
                            @foreach (json_decode($data->qa_attachment) as $file)
                                <h6 type="button" class="file-container text-dark"
                                    style="background-color: rgb(243, 242, 240);">
                                    <b>{{ $file }}</b>
                                    <a href="{{ asset('upload/' . $file) }}"
                                        target="_blank"><i class="fa fa-eye text-primary"
                                            style="font-size:20px; margin-right:-10px;"></i></a>
                                    <a type="button" class="remove-file"
                                        data-file-name="{{ $file }}"><i
                                            class="fa-solid fa-circle-xmark"
                                            style="color:red; font-size:20px;"></i></a>
                                </h6>
                            @endforeach
                        {{-- @endif --}}
                        @endif
                        </div>
                        <div class="add-btn">
                            <div>Add</div>
                            <input type="file" id="myfile" name="qa_attachment[]"
                                oninput="addMultipleFiles(this, 'qa_attachment')" multiple {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="col-12 sub-head">
                Effectiveness Check Details
            </div> -->
            <!-- <div class="col-12">
                <div class="group-input">
                    <label for="Effectiveness Check Required">Effectiveness Check
                        Required?</label>
                    <select name="effect_check" onChange="setCurrentDate(this.value)">
                        <option value="">Enter Your Selection Here</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
            </div> -->
            <!-- <div class="col-6 new-date-data-field">
                <div class="group-input input-date">
                    <label for="EffectCheck Creation Date">Effectiveness Check Creation Date</label>
                    {{-- <input type="date" name="effect_check_date"> --}}
                    <div class="calenderauditee">
                        <input type="text" name="effect_check_date" id="effect_check_date" readonly
                            placeholder="DD-MMM-YYYY" />
                        <input type="date" name="effect_check_date" class="hide-input"
                            oninput="handleDateInput(this, 'effect_check_date')" />
                    </div>
                </div>
            </div> -->
            <!-- <div class="col-6">
                <div class="group-input">
                    <label for="Effectiveness_checker">Effectiveness Checker</label>
                    <select id="select-state" placeholder="Select..." name="Effectiveness_checker">
                        <option value="">Select a person</option>
                        @foreach ($users as $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div> -->
            <!-- <div class="col-12">
                <div class="group-input">
                    <label for="effective_check_plan">Effectiveness Check Plan</label>
                    <textarea name="effective_check_plan"></textarea>
                </div>
            </div> -->
            <h3 style="font-size: 15px; color: #333; margin-bottom: 20px">
                                            <span style="font-weight: bold; color: red;">Note: </span>
                                            <span style="font-weight: bold; color: blue";>Please fill up both QA/CQA Review Tab and CFT Tab value to save the form.</span>
                                        </h3>
          
        </div>
        <div class="button-block">
            <button type="submit" class="saveButton" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>Save</button>
             <button type="button" class="backButton" onclick="previousStep()">Back</button>
            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
        </div>
    </div>
</div>

                            <!-- CAPA Closure content -->
                            <div id="CCForm5" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="QA Review & Closure">QA Head Review & Closure</label>
                                                <textarea name="qa_review" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>{{ $data->qa_review }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Closure Attachments">Closure Attachment</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                {{-- <input type="file" id="myfile" name="closure_attachment"
                                                    {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}> --}}
                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="closure_attachment">
                                                        @if ($data->closure_attachment)
                                                            @foreach (json_decode($data->closure_attachment) as $file)
                                                                <h6 type="button" class="file-container text-dark"
                                                                    style="background-color: rgb(243, 242, 240);">
                                                                    <b>{{ $file }}</b>
                                                                    <a href="{{ asset('upload/' . $file) }}"
                                                                        target="_blank"><i class="fa fa-eye text-primary"
                                                                            style="font-size:20px; margin-right:-10px;"></i></a>
                                                                    <a type="button" class="remove-file"
                                                                        data-file-name="{{ $file }}"><i
                                                                            class="fa-solid fa-circle-xmark"
                                                                            style="color:red; font-size:20px;"></i></a>
                                                                </h6>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                    <div class="add-btn">
                                                        <div>Add</div>
                                                        <input
                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}
                                                            type="file" id="myfile" name="closure_attachment[]"{{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}
                                                            oninput="addMultipleFiles(this, 'closure_attachment')"
                                                            multiple>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                         <!-- <div class="col-12 sub-head">
                                    Effectiveness Check Details -->
                                </div>
                                        <!-- <div class="col-12">
                                            <div class="group-input">
                                                <label for="Effectiveness Check required">Effectiveness Check
                                                    required</label>
                                                <select name="effect_check"{{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}
                                                    {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option {{ $data->effect_check == 'yes' ? 'selected' : '' }}
                                                        value="yes">Yes</option>
                                                    <option {{ $data->effect_check == 'no' ? 'selected' : '' }}
                                                        value="no">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        {{-- <div class="col-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Effect.Check Creation Date">Effect.Check Creation
                                                    Date</label>
                                                <input type="date" name="effect_check_date"
                                                    value="{{ $data->effect_check_date }}">
                                                    <div class="calenderauditee">
                                                        <input type="text"  value="{{ $data->effect_check_date }}" id="effect_check_date"  readonly placeholder="DD-MMM-YYYY" />
                                                        <input type="date" name="effect_check_date" value=""
                                                        class="hide-input"
                                                        oninput="handleDateInput(this, 'effect_check_date')"/>
                                                    </div>
                                            </div>
                                        </div> --}}

                                        <div class="col-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Effect Check Creation Date">Effectiveness Check Creation Date</label>
                                                {{-- <input type="date" name="effect_check_date"> --}}
                                                <div class="calenderauditee">
                                                    <input type="text"  id="effect_check_date" readonly
                                                        placeholder="DD-MMM-YYYY"value="{{ Helpers::getdateFormat($data->effect_check_date) }}"/>
                                                    <input type="date" name="effect_check_date" value=""class="hide-input"
                                                        oninput="handleDateInput(this,'effect_check_date')" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Effectiveness_checker">Effectiveness Checker</label>
                                                <select name="Effectiveness_checker">{{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}
                                                    <option value="">Enter Your Selection Here</option>
                                                    @foreach ($users as $value)
                                                        <option
                                                            {{ $data->Effectiveness_checker == $value->id ? 'selected' : '' }}
                                                            value="{{ $value->id }}">{{ $value->name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="effective_check_plan">Effectiveness Check Plan</label>
                                                <textarea name="effective_check_plan"{{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}> {{ $data->effective_check_plan }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 sub-head">
                                            Extension Justification
                                        </div> -->
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="due_date_extension">Due Date Extension Justification</label>
                                                <div><small class="text-primary">Please Mention justification if due date is crossed</small></div>
                                                <textarea name="due_date_extension"{{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>{{ $data->due_date_extension }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a class="text-white"
                                                href="{{ url('rcms/qms-dashboard') }}"> Exit </a> </button>
                                    </div>
                                </div>
                            </div>
                            {{-- ==========================HOD Final Review
 tab ================ --}}

<div id="CCForm13" class="inner-block cctabcontent">
    <div class="inner-block-content">
        <div class="row">
            <div class="col-12">
                <div class="group-input">
                    <label for="Comments"> HOD Final Review Comment</label>
                    <textarea name="hod_final_review" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>{{ $data->hod_final_review }}</textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="group-input">
                    <label for="Closure Attachments">HOD Final Review Attachment</label>
                    <div><small class="text-primary">Please Attach all relevant or supporting
                            documents</small></div>
                    {{-- <input multiple type="file" id="myfile" name="closure_attachment[]"> --}}
                    <div class="file-attachment-field">
                        <div class="file-attachment-list" id="hod_final_attachment">

                            @if ($data->hod_final_attachment)
                            @foreach (json_decode($data->hod_final_attachment) as $file)
                                <h6 type="button" class="file-container text-dark"
                                    style="background-color: rgb(243, 242, 240);">
                                    <b>{{ $file }}</b>
                                    <a href="{{ asset('upload/' . $file) }}"
                                        target="_blank"><i class="fa fa-eye text-primary"
                                            style="font-size:20px; margin-right:-10px;"></i></a>
                                    <a type="button" class="remove-file"
                                        data-file-name="{{ $file }}"><i
                                            class="fa-solid fa-circle-xmark"
                                            style="color:red; font-size:20px;"></i></a>
                                </h6>
                            @endforeach
                        {{-- @endif --}}
                        @endif
                        </div>
                        <div class="add-btn">
                            <div>Add</div>
                            <input type="file" id="myfile" name="hod_final_attachment[]"
                                oninput="addMultipleFiles(this, 'hod_final_attachment')" multiple {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="col-12 sub-head">
                Effectiveness Check Details
            </div> -->
            <!-- <div class="col-12">
                <div class="group-input">
                    <label for="Effectiveness Check Required">Effectiveness Check
                        Required?</label>
                    <select name="effect_check" onChange="setCurrentDate(this.value)">
                        <option value="">Enter Your Selection Here</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
            </div> -->
            <!-- <div class="col-6 new-date-data-field">
                <div class="group-input input-date">
                    <label for="EffectCheck Creation Date">Effectiveness Check Creation Date</label>
                    {{-- <input type="date" name="effect_check_date"> --}}
                    <div class="calenderauditee">
                        <input type="text" name="effect_check_date" id="effect_check_date" readonly
                            placeholder="DD-MMM-YYYY" />
                        <input type="date" name="effect_check_date" class="hide-input"
                            oninput="handleDateInput(this, 'effect_check_date')" />
                    </div>
                </div>
            </div> -->
            <!-- <div class="col-6">
                <div class="group-input">
                    <label for="Effectiveness_checker">Effectiveness Checker</label>
                    <select id="select-state" placeholder="Select..." name="Effectiveness_checker">
                        <option value="">Select a person</option>
                        @foreach ($users as $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div> -->
            <!-- <div class="col-12">
                <div class="group-input">
                    <label for="effective_check_plan">Effectiveness Check Plan</label>
                    <textarea name="effective_check_plan"></textarea>
                </div>
            </div> -->
           
          
        </div>
        <div class="button-block">
            <button type="submit" class="saveButton" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>Save</button>
             <button type="button" class="backButton" onclick="previousStep()">Back</button>
            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
        </div>
    </div>
</div>
{{-- ==========================QA QA/CQA Closure Review
 tab ================ --}}

<div id="CCForm14" class="inner-block cctabcontent">
    <div class="inner-block-content">
        <div class="row">
            <div class="col-12">
                <div class="group-input">
                    <label for="Comments"> QA/CQA Closure Review Comment</label>
                    <textarea name="qa_cqa_qa_comments" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>{{ $data->qa_cqa_qa_comments }}</textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="group-input">
                    <label for="Closure Attachments">QA/CQA Closure Review Attachment</label>
                    <div><small class="text-primary">Please Attach all relevant or supporting
                            documents</small></div>
                    {{-- <input multiple type="file" id="myfile" name="closure_attachment[]"> --}}
                    <div class="file-attachment-field">
                        <div class="file-attachment-list" id="qa_closure_attachment">

                            @if ($data->qa_closure_attachment)
                            @foreach (json_decode($data->qa_closure_attachment) as $file)
                                <h6 type="button" class="file-container text-dark"
                                    style="background-color: rgb(243, 242, 240);">
                                    <b>{{ $file }}</b>
                                    <a href="{{ asset('upload/' . $file) }}"
                                        target="_blank"><i class="fa fa-eye text-primary"
                                            style="font-size:20px; margin-right:-10px;"></i></a>
                                    <a type="button" class="remove-file"
                                        data-file-name="{{ $file }}"><i
                                            class="fa-solid fa-circle-xmark"
                                            style="color:red; font-size:20px;"></i></a>
                                </h6>
                            @endforeach
                        {{-- @endif --}}
                        @endif
                        </div>
                        <div class="add-btn">
                            <div>Add</div>
                            <input type="file" id="myfileb" name="qa_closure_attachment[]"
                                oninput="addMultipleFiles(this, 'qa_closure_attachment')" multiple {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="col-12 sub-head">
                Effectiveness Check Details
            </div> -->
            <!-- <div class="col-12">
                <div class="group-input">
                    <label for="Effectiveness Check Required">Effectiveness Check
                        Required?</label>
                    <select name="effect_check" onChange="setCurrentDate(this.value)">
                        <option value="">Enter Your Selection Here</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
            </div> -->
            <!-- <div class="col-6 new-date-data-field">
                <div class="group-input input-date">
                    <label for="EffectCheck Creation Date">Effectiveness Check Creation Date</label>
                    {{-- <input type="date" name="effect_check_date"> --}}
                    <div class="calenderauditee">
                        <input type="text" name="effect_check_date" id="effect_check_date" readonly
                            placeholder="DD-MMM-YYYY" />
                        <input type="date" name="effect_check_date" class="hide-input"
                            oninput="handleDateInput(this, 'effect_check_date')" />
                    </div>
                </div>
            </div> -->
            <!-- <div class="col-6">
                <div class="group-input">
                    <label for="Effectiveness_checker">Effectiveness Checker</label>
                    <select id="select-state" placeholder="Select..." name="Effectiveness_checker">
                        <option value="">Select a person</option>
                        @foreach ($users as $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div> -->
            <!-- <div class="col-12">
                <div class="group-input">
                    <label for="effective_check_plan">Effectiveness Check Plan</label>
                    <textarea name="effective_check_plan"></textarea>
                </div>
            </div> -->
           
          
        </div>
        <div class="button-block">
            <button type="submit" class="saveButton" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>Save</button>
             <button type="button" class="backButton" onclick="previousStep()">Back</button>
            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
        </div>
    </div>
</div>
{{-- ==========================QAH/CQAH Approval tab ================ --}}

<div id="CCForm15" class="inner-block cctabcontent">
    <div class="inner-block-content">
        <div class="row">
            <div class="col-12">
                <div class="group-input">
                    <label for="Comments"> QAH/CQAH Approval Comment </label>
                    <textarea name="qah_cq_comments" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>{{ $data->qah_cq_comments }}</textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="group-input">
                    <label for="Closure Attachments">QAH/CQAH Approval Attachment</label>
                    <div><small class="text-primary">Please Attach all relevant or supporting
                            documents</small></div>
                    {{-- <input multiple type="file" id="myfile" name="closure_attachment[]"> --}}
                    <div class="file-attachment-field">
                        <div class="file-attachment-list" id="qah_cq_attachment">

                            @if ($data->qah_cq_attachment)
                            @foreach (json_decode($data->qah_cq_attachment) as $file)
                                <h6 type="button" class="file-container text-dark"
                                    style="background-color: rgb(243, 242, 240);">
                                    <b>{{ $file }}</b>
                                    <a href="{{ asset('upload/' . $file) }}"
                                        target="_blank"><i class="fa fa-eye text-primary"
                                            style="font-size:20px; margin-right:-10px;"></i></a>
                                    <a type="button" class="remove-file"
                                        data-file-name="{{ $file }}"><i
                                            class="fa-solid fa-circle-xmark"
                                            style="color:red; font-size:20px;"></i></a>
                                </h6>
                            @endforeach
                        {{-- @endif --}}
                        @endif
                        </div>
                        <div class="add-btn">
                            <div>Add</div>
                            <input type="file" id="myfilec" name="qah_cq_attachment[]"
                                oninput="addMultipleFiles(this, 'qah_cq_attachment')" multiple {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="col-12 sub-head">
                Effectiveness Check Details
            </div> -->
            <!-- <div class="col-12">
                <div class="group-input">
                    <label for="Effectiveness Check Required">Effectiveness Check
                        Required?</label>
                    <select name="effect_check" onChange="setCurrentDate(this.value)">
                        <option value="">Enter Your Selection Here</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
            </div> -->
            <!-- <div class="col-6 new-date-data-field">
                <div class="group-input input-date">
                    <label for="EffectCheck Creation Date">Effectiveness Check Creation Date</label>
                    {{-- <input type="date" name="effect_check_date"> --}}
                    <div class="calenderauditee">
                        <input type="text" name="effect_check_date" id="effect_check_date" readonly
                            placeholder="DD-MMM-YYYY" />
                        <input type="date" name="effect_check_date" class="hide-input"
                            oninput="handleDateInput(this, 'effect_check_date')" />
                    </div>
                </div>
            </div> -->
            <!-- <div class="col-6">
                <div class="group-input">
                    <label for="Effectiveness_checker">Effectiveness Checker</label>
                    <select id="select-state" placeholder="Select..." name="Effectiveness_checker">
                        <option value="">Select a person</option>
                        @foreach ($users as $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div> -->
            <!-- <div class="col-12">
                <div class="group-input">
                    <label for="effective_check_plan">Effectiveness Check Plan</label>
                    <textarea name="effective_check_plan"></textarea>
                </div>
            </div> -->
           
          
        </div>
        <div class="button-block">
            <button type="submit" class="saveButton" {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>Save</button>
             <button type="button" class="backButton" onclick="previousStep()">Back</button>
            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
        </div>
    </div>
</div>



                          


                            <!-- Activity Log content -->
                            <div id="CCForm6" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="sub-head">Activity Log</div>

                                    <div class="d-flex align-item-end justify-content-end">
                                        <a href="route('rcms/capaActivityLog')">
                                            {{-- <button class="button_theme1" id="printButton" style="margin-bottom:20px;">Print </a></button> --}}
                                            {{-- <button id="printButton" class="btn btn-primary">Print PDF</button> --}}

                                            <button style="margin-bottom:20px;" class="button_theme1"> <a
                                                    class="text-white"
                                                    href="{{ url('capaActivityLog', $data->id) }}"> Print </a>
                                            </button>
                                    </div>

                            
                                    <div class="printable-content">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <strong>Propose Plan By:</strong><br>
                                                            {{ $data->plan_proposed_by }}
                                                        </td>
                                                        <td>
                                                            <strong>Proposed Plan On:</strong><br>
                                                            @php
                                                                $initiateTime = $data->plan_proposed_on;
                                                                $timeArray = explode(' | ', $initiateTime);
                                                                $timeInIST = isset($timeArray[0])
                                                                    ? $timeArray[0]
                                                                    : 'No IST Time Available';
                                                                $timeInGMT = isset($timeArray[1])
                                                                    ? $timeArray[1]
                                                                    : 'No GMT Time Available';
                                                                $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                                                echo $isIndia ? $timeInIST : $timeInGMT;
                                                            @endphp
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>Proposed Plan Comments:</strong><br>
                                                            {{ $data->comment ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>

                                                    
                                                    <tr>
                                                        <td>
                                                            <strong>Cancelled By:</strong><br>
                                                            {{ $data->cancelled_by }}
                                                        </td>
                                                        <td>
                                                            <strong>Cancelled On:</strong><br>
                                                            @php
                                                                $withinLimitsTime = $data->cancelled_on;
                                                                $timeArray = explode(' | ', $withinLimitsTime);
                                                                $timeInIST = isset($timeArray[0])
                                                                    ? $timeArray[0]
                                                                    : 'No IST Time Available';
                                                                $timeInGMT = isset($timeArray[1])
                                                                    ? $timeArray[1]
                                                                    : 'No GMT Time Available';
                                                                $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                                                echo $isIndia ? $timeInIST : $timeInGMT;
                                                            @endphp
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>Cancel Comment:</strong><br>
                                                            {{ $data->cancel_comment ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr> 
                                                   
                                                    <tr>
                                                        <td>
                                                            <strong>Hod Review Completed By:</strong><br>
                                                            {{ $data->hod_review_completed_by }}
                                                        </td>
                                                        <td>
                                                            <strong>Hod Review Completed On:</strong><br>
                                                            @php
                                                                $outOfLimitsTime = $data->hod_review_completed_on;
                                                                $timeArray = explode(' | ', $outOfLimitsTime);
                                                                $timeInIST = isset($timeArray[0])
                                                                    ? $timeArray[0]
                                                                    : 'No IST Time Available';
                                                                $timeInGMT = isset($timeArray[1])
                                                                    ? $timeArray[1]
                                                                    : 'No GMT Time Available';
                                                                $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                                                echo $isIndia ? $timeInIST : $timeInGMT;
                                                            @endphp
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>HOD Review Completed Comment:</strong><br>
                                                            {{ $data->hod_comment ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>

                                                  
                                                    <tr>
                                                        <td>
                                                            <strong>QA/CQA Review Completed By:</strong><br>
                                                            {{ $data->qa_review_completed_by }}
                                                        </td>
                                                        <td>
                                                            <strong>QA/CQA Review Completed On:</strong><br>
                                                            @php
                                                                $completeActionsTime = $data->qa_review_completed_on;
                                                                $timeArray = explode(' | ', $completeActionsTime);
                                                                $timeInIST = isset($timeArray[0])
                                                                    ? $timeArray[0]
                                                                    : 'No IST Time Available';
                                                                $timeInGMT = isset($timeArray[1])
                                                                    ? $timeArray[1]
                                                                    : 'No GMT Time Available';
                                                                $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                                                echo $isIndia ? $timeInIST : $timeInGMT;
                                                            @endphp
                                                        </td>
                                                    </tr>

                                                    
                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>QA/CQA Review Completed Comment:</strong><br>
                                                            {{ $data->qa_comment ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>

                                                    
                                                    <tr>
                                                        <td>
                                                            <strong>Approved By:</strong><br>
                                                            {{ $data->approved_by }}
                                                        </td>
                                                        <td>
                                                            <strong>Approved On:</strong><br>
                                                            @php
                                                                $additionalWorkTime = $data->approved_on;
                                                                $timeArray = explode(' | ', $additionalWorkTime);
                                                                $timeInIST = isset($timeArray[0])
                                                                    ? $timeArray[0]
                                                                    : 'No IST Time Available';
                                                                $timeInGMT = isset($timeArray[1])
                                                                    ? $timeArray[1]
                                                                    : 'No GMT Time Available';
                                                                $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                                                echo $isIndia ? $timeInIST : $timeInGMT;
                                                            @endphp
                                                        </td>
                                                    </tr>

                                                    
                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>Approved Comment:</strong><br>
                                                            {{ $calibration->approved_comment ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>

                                                    <!-- Complete By -->
                                                    <tr>
                                                        <td>
                                                            <strong>Completed By:</strong><br>
                                                            {{ $data->completed_by }}
                                                        </td>
                                                        <td>
                                                            <strong>Completed On:</strong><br>
                                                            @php
                                                                $qaApprovalTime = $data->completed_on;
                                                                $timeArray = explode(' | ', $qaApprovalTime);
                                                                $timeInIST = isset($timeArray[0])
                                                                    ? $timeArray[0]
                                                                    : 'No IST Time Available';
                                                                $timeInGMT = isset($timeArray[1])
                                                                    ? $timeArray[1]
                                                                    : 'No GMT Time Available';
                                                                $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                                                echo $isIndia ? $timeInIST : $timeInGMT;
                                                            @endphp
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>Completed Comment:</strong><br>
                                                            {{ $data->com_comment ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <strong>HOD Final Review Completed By:</strong><br>
                                                            {{ $data->hod_final_review_completed_by }}
                                                        </td>
                                                        <td>
                                                            <strong>HOD Final Review Completed On:</strong><br>
                                                            @php
                                                                $cancelTime = $data->hod_final_review_completed_on;
                                                                $timeArray = explode(' | ', $cancelTime);
                                                                $timeInIST = isset($timeArray[0])
                                                                    ? $timeArray[0]
                                                                    : 'No IST Time Available';
                                                                $timeInGMT = isset($timeArray[1])
                                                                    ? $timeArray[1]
                                                                    : 'No GMT Time Available';
                                                                $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                                                echo $isIndia ? $timeInIST : $timeInGMT;
                                                            @endphp
                                                        </td>
                                                    </tr>

                                                    
                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>HOD Final Review Completed Comment:</strong><br>
                                                            {{ $calibration->final_comment ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>

                                                    <!-- Row for QA/CQA Closure Review Completed By-->
                                                    <tr>
                                                        <td>
                                                            <strong>QA/CQA Closure Review Completed By:</strong><br>
                                                            {{ $data->qa_review_completed_by }}
                                                        </td>
                                                        <td>
                                                            <strong>QA/CQA Closure Review Completed On:</strong><br>
                                                            @php
                                                                $cancelTime = $data->qa_review_completed_on;
                                                                $timeArray = explode(' | ', $cancelTime);
                                                                $timeInIST = isset($timeArray[0])
                                                                    ? $timeArray[0]
                                                                    : 'No IST Time Available';
                                                                $timeInGMT = isset($timeArray[1])
                                                                    ? $timeArray[1]
                                                                    : 'No GMT Time Available';
                                                                $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                                                echo $isIndia ? $timeInIST : $timeInGMT;
                                                            @endphp
                                                        </td>
                                                    </tr>

                                                   
                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>QA/CQA Closure Review Completed Comment:</strong><br>
                                                            {{ $calibration->qa_comment ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>

                                                     
                                                     <tr>
                                                        <td>
                                                            <strong>QA/CQA Approval Completed By:</strong><br>
                                                            {{ $data->qah_approval_completed_by }}
                                                        </td>
                                                        <td>
                                                            <strong>QA/CQA Approval Completed On:</strong><br>
                                                            @php
                                                                $cancelTime = $data->qah_approval_completed_on;
                                                                $timeArray = explode(' | ', $cancelTime);
                                                                $timeInIST = isset($timeArray[0])
                                                                    ? $timeArray[0]
                                                                    : 'No IST Time Available';
                                                                $timeInGMT = isset($timeArray[1])
                                                                    ? $timeArray[1]
                                                                    : 'No GMT Time Available';
                                                                $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                                                echo $isIndia ? $timeInIST : $timeInGMT;
                                                            @endphp
                                                        </td>
                                                    </tr>

                                                    
                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>QA/CQA Approval Completed Comment:</strong><br>
                                                            {{ $data->qah_comment ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>
                                      
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="button-block">
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <button type="button"> <a class="text-white"href="{{ url('rcms/qms-dashboard') }}"> Exit </a> </button>
                                    </div>
                                </div>
                                
                     </div>
                        
                    </form>

                </div>

            </div>

            <div class="modal fade" id="child-modal1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Child</h4>
                        </div>
                        <form action="{{ route('capa_child_changecontrol', $data->id) }}" method="POST">
                            @csrf
                           
                            <div class="modal-body">
                                <div class="group-input">
                                    
                                    <label for="major">
                                       <input type="radio" name="child_type" value="extension">
                                          Extension
                                    </label>
                            

                                </div>

                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" data-bs-dismiss="modal">Close</button>
                                <button type="submit">Continue</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <div class="modal fade" id="child-modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Child</h4>
                        </div>
                        <form action="{{ route('capa_child_changecontrol', $data->id) }}" method="POST">
                            @csrf
                            <!-- Modal body -->
                            {{-- <div class="modal-body">
                                <div class="group-input">
                                    @if ($data->stage == 3)
                                        <label for="major">

                                        </label>
                                         {{-- <label for="major">
                                            <input type="radio" name="child_type" value="Change_control">
                                            Change Control
                                        </label> --}}
                                        {{-- <label for="major">
                                            <input type="radio" name="child_type" value="Action_Item">
                                            Action-Item
                                        </label>
                                        --}}
                                        {{-- <label for="major">
                                            <input type="radio" name="child_type" value="extension">
                                            Extension
                                        </label>
                                        <label for="major">
                                            <input type="radio" name="child_type" value="rca">
                                           RCA
                                        </label> 
                                    @endif
                                    @if ($data->stage == 4)
                                        <label for="major">
                                           <input type="radio" name="child_type" value="Action-item">
                                              Action-Item
                                        </label>
                                    @endif
                                    @if ($data->stage == 5)
                                    <label for="major">
                                       <input type="radio" name="child_type" value="Action-item">
                                          Action-Item
                                    </label>
                                @endif

                                    @if ($data->stage == 7)
                                        <label for="major">
                                            <input type="radio" name="child_type" value="effectiveness_check">
                                            Action-Item
                                        </label>
                                    @endif
                                </div>

                            </div>--}} 
                            <div class="modal-body">
                                <div class="group-input">
                                    <label for="major">
                                        <input type="radio" name="child_type" value="Action_Item">
                                        <input type="hidden" name="CAPA" value="{{Helpers::getDivisionName(session()->get('division'))}}/CAPA/{{ date('Y') }}/{{ $data->record}}">
                                        Action-Item
                                    </label>
                                </div>
                                <div class="group-input">
                                    <label for="major">
                                        <input type="radio" name="child_type" value="extension">
                                        Extension
                                      </label>
                                </div>

                            </div>



                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" data-bs-dismiss="modal">Close</button>
                                <button type="submit">Continue</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <div class="modal fade" id="child-modal1l">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Child</h4>
                        </div>
                        <form action="{{ route('capa_effectiveness_check', $data->id) }}" method="POST">
                            @csrf
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="group-input">
                                    <label for="major">
                                        <input type="radio" name="effectiveness_check" id="major"
                                            value="Effectiveness_check">
                                        Effectiveness Check
                                    </label>
                                </div>

                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" data-bs-dismiss="modal">Close</button>
                                <button type="submit">Continue</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <div class="modal fade" id="rejection-modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">E-Signature</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <form action="{{ route('capa_reject', $data->id) }}" method="POST">
                            @csrf
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="mb-3 text-justify">
                                    Please select a meaning and a outcome for this task and enter your username
                                    and password for this task. You are performing an electronic signature,
                                    which is legally binding equivalent of a hand written signature.
                                </div>
                                <div class="group-input">
                                    <label for="username">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" required>
                                </div>
                                <div class="group-input">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" required>
                                </div>
                                <div class="group-input">
                                    <label for="comment">Comment <span class="text-danger">*</span></label>
                                    <input type="comment" name="comment" required >
                                </div>
                            </div>

                            <!-- Modal footer -->
                            <!-- <div class="modal-footer">
                                <button type="submit" data-bs-dismiss="modal">Submit</button>
                                <button>Close</button>
                            </div> -->
                            <div class="modal-footer">
                              <button type="submit">Submit</button>
                                <button type="button" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="cancel-modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">E-Signature</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <form action="{{ route('capaCancel', $data->id) }}" method="POST">
                            @csrf
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="mb-3 text-justify">
                                    Please select a meaning and a outcome for this task and enter your username
                                    and password for this task. You are performing an electronic signature,
                                    which is legally binding equivalent of a hand written signature.
                                </div>
                                <div class="group-input">
                                    <label for="username">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" required>
                                </div>
                                <div class="group-input">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" required>
                                </div>
                                <div class="group-input">
                                    <label for="comment">Comment <span class="text-danger">*</span></label>
                                    <input type="comment" name="comment" required>
                                </div>
                            </div>

                            <!-- Modal footer -->
                            <!-- <div class="modal-footer">
                                <button type="submit" data-bs-dismiss="modal">Submit</button>
                                <button>Close</button>
                            </div> -->
                            <div class="modal-footer">
                              <button type="submit">Submit</button>
                                <button type="button" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="signature-modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">E-Signature</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('capa_send_stage', $data->id) }}" method="POST">
                            @csrf
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="mb-3 text-justify">
                                    Please select a meaning and a outcome for this task and enter your username
                                    and password for this task. You are performing an electronic signature,
                                    which is legally binding equivalent of a hand written signature.
                                </div>
                                <div class="group-input">
                                    <label for="username">Username<span class="text-danger">*</span></label>
                                    <input type="text" name="username" required>
                                </div>
                                <div class="group-input">
                                    <label for="password">Password<span class="text-danger">*</span></label>
                                    <input type="password" name="password" required>
                                </div>
                                <div class="group-input">
                                    <label for="comment">Comment</label>
                                    <input type="comment" name="comment">
                                </div>
                            </div>

                            <!-- Modal footer -->
                            <!-- <div class="modal-footer">
                                <button type="submit" data-bs-dismiss="modal">Submit</button>
                                <button>Close</button>
                            </div> -->
                            <div class="modal-footer">
                              <button type="submit">Submit</button>
                                <button type="button" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modal1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">E-Signature</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('capa_qa_more_info', $data->id) }}" method="POST">
                            @csrf
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="mb-3 text-justify">
                                    Please select a meaning and a outcome for this task and enter your username
                                    and password for this task. You are performing an electronic signature,
                                    which is legally binding equivalent of a hand written signature.
                                </div>
                                <div class="group-input">
                                    <label for="username">Username<span class="text-danger">*</span></label>
                                    <input type="text" name="username" required>
                                </div>
                                <div class="group-input">
                                    <label for="password">Password<span class="text-danger">*</span></label>
                                    <input type="password" name="password" required>
                                </div>
                                <div class="group-input">
                                    <label for="comment">Comment<span class="text-danger">*</span></label>
                                    <input type="comment" name="comment" required>
                                </div>
                            </div>

                            <!-- Modal footer -->
                            <!-- <div class="modal-footer">
                                <button type="submit" data-bs-dismiss="modal">Submit</button>
                                <button>Close</button>
                            </div> -->
                            <div class="modal-footer">
                              <button type="submit">Submit</button>
                                <button type="button" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
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
                    ele: '#Facility, #Group, #Audit, #Auditee ,#capa_related_record'
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
                <script>
                    document.getElementById('initiator_group').addEventListener('change', function() {
                        var selectedValue = this.value;
                        document.getElementById('initiator_group_code').value = selectedValue;
                    });
                </script>
                 <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const removeButtons = document.querySelectorAll('.remove-file');

                        removeButtons.forEach(button => {
                            button.addEventListener('click', function () {
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
                    var maxLength = 255;
                    $('#docname').keyup(function() {
                        var textlen = maxLength - $(this).val().length;
                        $('#rchars').text(textlen);});
                </script>
                 <script>
                    wow = new WOW(
                                    {
                                    boxClass:     'wow',      // default
                                    animateClass: 'animated', // default
                                    offset:       0,          // default
                                    mobile:       true,       // default
                                    live:         true        // default
                                    }
                                    )
                                    wow.init();
                </script>
                <!-- session -->
                <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @if (Session::has('swal'))
        <script>
            swal("{{ Session::get('swal')['title'] }}", "{{ Session::get('swal')['message'] }}",
                "{{ Session::get('swal')['type'] }}")
        </script>
    @endif
    <script>

        @endsection
