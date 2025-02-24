<div class="form-step">
    <h2>Work Information 4</h2>
    <label for="company">Company Name</label>
    <input type="text" id="company" name="company" required>

    <label for="jobTitle">Job Title</label>
    <input type="text" id="jobTitle" name="jobTitle" required>

    <label for="experience">Years of Experience</label>
    <input type="number" id="experience" name="experience" required>

    <!-- Additional fields -->
    <label for="skills">Skills</label>
    <textarea id="skills" name="skills" rows="3"></textarea>

    <!-- Attachment -->
    <label for="resume">Upload Resume</label>
    <input type="file" id="resume" name="resume" required>

    <div id="btns">
        <button type="button" class="prev-step">Previous</button>
        <button type="button" class="save_btn_all">Save</button>
        <button type="button" class="next-step">Next</button>
    </div>
</div>

<style>
 #btns{
    display: flex;
    justify-content: space-around;
 }
</style>  