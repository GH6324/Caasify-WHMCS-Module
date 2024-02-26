<!-- Host Name -->
<div v-if="planId != null" class="row m-0 p-0 border rounded-4 bg-body-secondary py-5 px-4 mt-5"> 
    <div class="col-12 m-0 p-0" style="--bs-bg-opacity: 0.1;">
        <div class="m-0 p-0">

            <!-- name -->
            <div class="m-0 p-0">
                <div class="m-0 p-0">
                    <p class="text-dark h3">
                        {{ lang('nameofhost') }}
                    </p>
                    <p class="fs-6 pt-1 text-secondary">
                        {{ lang('enteraname') }}    
                    </p>
                </div>
                <hr class="pb-4">
                <div class="row m-0 p-0">
                    <input v-model="themachinename" @input="validateInput" type="text" class="form-control py-3 bg-white fs-6 ps-4 border-0" style="--bs-bg-opacity: 0.5;" placeholder="Machine-1">
                </div>
                <p v-if="MachineNameValidationError" class="mt-4 w-50 small text-danger">{{ lang('onlyenglishletters') }}</p>
            </div>
            
        </div>
    </div> 
</div> 
<!-- End Name -->


