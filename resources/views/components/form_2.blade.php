<div class="form-step">
    <h2>Work Information</h2>
    @csrf
    <label for="company">Company Name</label>
    <input type="text" id="company" name="company" required>

    <label for="company">Join Date</label>
    <input type="date" id="join_date" name="join_date" required>


    <label for="jobTitle">Job Title</label>
    <input type="text" id="jobTitle" name="jobTitle" required>

    <label for="experience">Years of Experience</label>
    <input type="number" id="experience" name="experience" required>

    <!-- Additional fields -->
    <label for="skills">Skills</label>
    <textarea id="skills" name="skills" rows="3"></textarea>

    <!-- Attachment -->
    <label for="resume">Upload Resume</label>
    <input type="file" id="resume" name="resume" required multiple>

    <div id="btns">
        <button type="button" class="prev-step">Previous</button>
        <button type="button" onclick="submitform(2)" class="save_btn_all">Save step 2</button>
        <button type="button" class="next-step">Next</button>
    </div>

    <div class="col-lg-6" style="display: none">
        <input type="email" id="email" value="{{ $email ?? ''}}" name="email" required readonly>

    </div>
</div>

<style>
    #btns {
        display: flex;
        justify-content: space-around;
    }
</style>

{{-- <script>
    function submitform(step) {
        // Get form fields
        let company = document.getElementById('company').value;
        let job  = document.getElementById('jobTitle').value;
        let join_date  = document.getElementById('join_date').value;
        let expe = document.getElementById('experience').value;
        let skill = document.getElementById('skills').value;
        let resume = document.getElementById('resume').value;
        

        // Check if all required fields are filled
        if (!company || !job || !expe || !skill || !resume || !join_date) {
            alert('Please fill all the fields');
            return; // Stop the function if any field is empty
        }
        let formData = new FormData();

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

              
        fetch(`/save-step-${step}`, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Step saved successfully!');
                    // Optionally reset fields
                    div.querySelectorAll('input').forEach(input => {
                        input.value = ''; // Reset input field value
                    });
                } else {
                    alert(data.message || 'Error occurred!');
                }
            })
            .catch(() => alert('Something went wrong!'));
    }
</script> --}}
