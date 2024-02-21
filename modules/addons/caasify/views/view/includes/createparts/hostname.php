new for caasify in hostnam.php
<div class="mt-5 pt-5">
    <h1>regions</h1>
    <div class="row">
        <div class="col-12 bg-dark text-light p-5 rounded-4">
            {{regions}}
        </div>
    </div>
</div>

<div class="mt-5 pt-5">
    <h1>products</h1>
    <div class="row">
        <div class="col-12 bg-dark text-light p-5 rounded-4">
            {{products}}
        </div>
    </div>
</div>


<!-- Host Name -->
<div class="row m-0 p-0 pt-0 pt-md-5 mt-0 mt-md-5"> 
    <div class="col-12 m-0 p-0" style="--bs-bg-opacity: 0.1;">
        <div class="m-0 p-0">

            <!-- name -->
            <div class="m-0 p-0 py-5">
                <div class="m-0 p-0">
                    <p class="text-dark h3">
                        {{ lang('nameofhost') }}
                    </p>
                    <p class="fs-6 pt-1 text-secondary">
                        {{ lang('enteraname') }}    
                    </p>
                </div>

                <div class="row m-0 p-0">
                    <input v-model="themachinename" @input="validateInput" type="text" class="form-control py-3 bg-body-secondary fs-6 ps-4 border-0" style="--bs-bg-opacity: 0.5;" placeholder="Machine-1">
                </div>
                <p v-if="MachineNameValidationError" class="mt-4 w-50 small text-danger">{{ lang('onlyenglishletters') }}</p>
            </div>
            
        </div>
    </div> 
</div> 
<!-- End Name -->


