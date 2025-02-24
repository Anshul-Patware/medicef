<div class="form-step">
    <h2>QA Initial Review</h2>
    <label for="init_dev_cate">Initial Deviation Category</label>
    <input type="text" id="init_dev_cate" name="init_dev_cate" required>

    <div class="row mt-3">
        <div class="col-lg-6">
            <label for="inves_req">Investigation Required ?</label>
            <input type="text" id="inves_req" name="inves_req" required>
        </div>
        <div class="col-lg-6">
            <label for="capa_req">CAPA Required ?</label>
            <input type="text" id="capa_req" name="capa_req" required>
        </div>
    </div>

    <!-- Additional fields -->
    <div class="row">
        <div class="col-lg-6">
            <label for="qrm_req">QRM Required ?</label>
            {{-- <textarea id="qrm_req" name="qrm_req" rows="3"></textarea> --}}
            {{-- <input type="text" id="qrm_req" name="qrm_req" required /> --}}
            <select name="qrm_req" id="qrm_req">
                <option></option>
            </select>
        </div>
    </div>


    <!-- Attachment -->

    <label for="resume">
        Justification for Categorization</label><br>
    <small style="color: blue">Please insert "NA" in the data field if it does not require completion</small>
    <input type="file" id="resume" name="resume" required>

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
