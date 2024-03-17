
<!-- Operation System -->
<div v-if="PlanSections != null" class="row m-0 p-0 py-5 px-4 mt-5">
    <div class="col-12">
        <div class="row mb-5">
            <h3>Configuration</h3>
        </div>
    </div>
    <div v-for="PlanSection in PlanSections" class="col-12" style="--bs-bg-opacity: 0.1;">
        <div v-if="PlanSection?.fields != null" v-for="(field, index) in PlanSection?.fields" class="row m-0 p-0 my-1">
            <div class="col-12 m-0 p-0 ">    
                <div class="d-flex flex-row justify-content-start align-items-center">    
                    <div class="m-0 p-0 pe-4" style="min-width: 140px;">
                        <p class="text-dark h5">
                            {{ field.label }}
                        </p>
                    </div>
                    
                    <!-- Type: DropDown -->
                    <div v-if="field.type == 'dropdown'" class="d-flex flex-row justify-content-start align-items-center">
                        <div style="min-width:250px">
                            <select :name="field.name" class="form-select" :aria-label="field.name" :key="index" v-model="PlanConfigSelectedOptions[field.name]">
                                <option value ="field.options[0]" selected disabled>Please select</option>
                                <option v-for="option in field.options" :value="option">
                                    {{ option.name }}
                                </option>
                            </select>
                        </div>
                        <div v-if="PlanConfigSelectedOptions[field.name]?.price" class="m-0 p-0 ps-4" style="min-width: 140px;">
                            <p class="text-secondary h5" v-if="PlanConfigSelectedOptions[field.name].price == 0">
                                free
                            </p>
                            <p v-else class="text-primary h5">
                                {{ showMachinePriceInWhmcsUnit(ConverFromCaasifyToWhmcs(PlanConfigSelectedOptions[field.name].price)) }} {{ userCurrencySymbolFromWhmcs }}
                            </p>
                        </div>
                    </div>


                    <!-- Type: Text -->
                    <div v-if="field.type == 'text'" class="row m-0 p-0">
                        <div class="col-12 m-0 p-0" style="--bs-bg-opacity: 0.1;">
                            <div class="m-0 p-0">
                                <div class="m-0 p-0">
                                    <div class="m-0 p-0" style="min-width: 250px;">
                                        <p class="text-dark h3 m-0 p-0">
                                            {{ PlanConfigSelectedOptions[field.label] }}
                                        </p>
                                        <input v-model="PlanConfigSelectedOptions[field.name].options" @input="validateInput" type="text" class="form-control bg-white fs-6" style="--bs-bg-opacity: 0.5;" placeholder="Public key">
                                    </div>
                                    <p v-if="SshNameValidationError" class="mt-4 w-50 small text-danger">not valid</p>
                                </div> 
                            </div>
                        </div> 
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Operation System -->



