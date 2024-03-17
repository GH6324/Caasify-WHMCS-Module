<!-- Cost Table -->
<div v-if="PlanSections != null && SelectedPlan != null" class="row m-0 p-0 py-5 px-4 mt-5">    
    <div class="col-12 " style="--bs-bg-opacity: 0.1;">
        <div class="row">
            <div class="m-0 p-0">
                <p class="text-dark h3">
                    {{ lang('billsummary') }}
                </p>
            </div>
        </div>
        <hr class="row pb-4">
        <div class="p-0 m-0">
            <div class="">
                <p class="h4 mb-3">
                    Plan
                </p>
                <p class="h6 ms-3">
                    PLACE: {{ SelectedRegion.name }}
                </p>
                <p class="h6 ms-3">
                    Data Center: {{ SelectedDataCenter.name }}
                </p>
                <p class="h6 ms-3">
                    NAME : {{ SelectedPlan.title }}
                </p>
                <p class="h6 ms-3">
                    PRICE: {{ showMachinePriceInWhmcsUnit(ConverFromCaasifyToWhmcs(SelectedPlan.price)) }} {{ userCurrencySymbolFromWhmcs }}
                </p>
            </div>
            <div v-if="PlanConfigSelectedOptions" class="mt-5">
                <p class="h4 mb-3">
                    Add-ons features
                </p>
                <div v-for="(value, key) in PlanConfigSelectedOptions" :key="key" class="d-flex flex-row justify-content-start align-items-center">
                    <div v-if="value?.price">
                        <span class="h6 ms-3">
                            {{ key }}
                        </span>
                    </div>    
                    <div v-if="value?.price" class="m-0 p-0 ps-4 text-primary">
                        <span v-if="value?.price == 0">
                            free
                        </span>
                        <span v-else>
                            {{ showMachinePriceInWhmcsUnit(ConverFromCaasifyToWhmcs(value?.price)) }} {{ userCurrencySymbolFromWhmcs }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Summery Table -->
        <div class="row">
            <div class="m-0 p-0">
                <p class="float-end text-dark h4">
                    <i class="bi bi-currency-exchange text-secondary p-0 m-0 me-3 h5"></i>
                    <span>
                        {{ lang('totalcost') }} = 
                    </span>
                    <span>
                        {{ showMachinePriceInWhmcsUnit(ConverFromCaasifyToWhmcs(NewMachinePrice)) }} {{ userCurrencySymbolFromWhmcs }}
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>




