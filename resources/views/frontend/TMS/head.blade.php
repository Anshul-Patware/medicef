    {{-- ======================================
                    TMS HEAD
    ======================================= --}}
    <div id="tms-head">
        <div class="head">Training Management System</div>
        <div class="link-list">
         
            <a href="{{ route('TMS.index') }}" class="tms-link">Dashboard</a>
            <a href="{{ route('employee_new') }}" class="tms-link">Employee</a>
            <a href="{{ route('trainer_qualification') }}" class="tms-link">Trainer Qualification</a>
            <div class="tms-drop-block">
                <div class="drop-btn">Quizzes&nbsp;<i class="fa-solid fa-angle-down"></i></div>
                <div class="drop-list">
                   <li><a href="/question">Question</a></li>
                    <li><a href="/question-bank">Question Banks</a></li>
                   <li><a href="{{ route('quize.index') }}">Manage Quizzes</a></li>
                </div>
            </div>
            <div class="tms-drop-block">
                <div class="drop-btn">Activities&nbsp;<i class="fa-solid fa-angle-down"></i></div>
                <div class="drop-list">
                    <ul>
                        <li><a href="{{ route('TMS.create') }}">Create Training Plan</a></li>
                        <li><a href="{{ url('TMS/show') }}">Manage Training Plan</a></li>
                        <li><a href="{{ url('induction_training') }}">Induction Training</a></li>
                        <li><a href="{{ url('job_training') }}">On The Job Training</a></li>
                    </ul>
                </div>
                
            </div>
        </div>
    </div>
<style>
.drop-list a {
    text-decoration: none;
    color: #333;
    font-size: 14px;
    transition: color 0.3s ease;
}

.drop-list a:hover {
    color: #eba746; 
}
#tms-head .head {
    font-weight: bold;
}
</style>