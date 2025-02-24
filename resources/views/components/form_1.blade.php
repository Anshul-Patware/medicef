@props(['email' => '']) <!-- Define the email prop with a default value -->

<style>
    #head {
        color: red;
    }
</style>


{{-- first form personal information start --}}
<div class="form-step active">
    <h2 id='head'>Personal Information</h2>
    @csrf
    @foreach ($data as $record)
        <div class="row">
            <div class="col-lg-6">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstName" value="{{ $record->first_name }}" required>
            </div>

            <div class="col-lg-6">
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName" value="{{ $record->last_name }}" required>
            </div>

            <div class="col-lg-6">
                <label for="email">Email</label>
                <input type="email" id="email" value="{{ $email ?? '' }}" name="email" required readonly>

            </div>
            <div class="col-lg-6">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" required>
            </div>

            <div class="col-lg-6">
                <label for="depart">Department</label>
                <input type="text" id="depart" name="depart" required>
            </div>
            <div class="col-lg-6">
                <label for="course">Course</label>
                <input type="text" id="course" name="course" required>
            </div>


            <div class="col-lg-6">
                <label for="roll">Roll No</label>
                <input type="text" id="roll" name="rollno" required>
            </div>
            <div class="col-lg-6">
                <label for="contact">Contact</label>
                <input type="text" id="contact" name="contact" required>
            </div>

            <div class="col-lg-6">
                <label for="branch">Branch</label>
                <input type="text" id="branch" name="branch" required>
            </div>

            <div class="col-lg-6">
                <label for="category">Category</label>
                <input type="text" id="category" name="category" required>
            </div>


            <div class="col-lg-6">
                <label for="address">Address</label>
                <textarea id="address" name="address" rows="3"></textarea>
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

<style>
    .save_btn {
        width: 49%;
    }

    #next_btn {
        width: 49%;
    }
</style>

{{-- <script>
    function submitform(step) {
        // Get form fields
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
        if (!firstName || !lastName || !email || !phone || !depart || !course || !rollno || !contact || !branch || !
            category || !files) {
            alert('Please fill all the fields');
            return; // Stop the function if any field is empty
        }

        let formData = new FormData();
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        formData.append('firstName', document.getElementById('firstName').value);
        formData.append('lastName', document.getElementById('lastName').value);
        formData.append('email', document.getElementById('email').value);
        formData.append('phone', document.getElementById('phone').value);
        formData.append('address', document.getElementById('address').value);
        formData.append('depart', document.getElementById('depart').value);
        formData.append('course', document.getElementById('course').value);
        formData.append('rollno', document.getElementById('roll').value);
        formData.append('contact', document.getElementById('contact').value);
        formData.append('branch', document.getElementById('branch').value);
        formData.append('category', document.getElementById('category').value);

        let profilePic = document.getElementById('profilePics').files;

        if (profilePic.length > 0) {
            for (let i = 0; i < profilePic.length; i++) {
                formData.append('profilePic[]', profilePic[i]);
            }
        }

        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        
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
