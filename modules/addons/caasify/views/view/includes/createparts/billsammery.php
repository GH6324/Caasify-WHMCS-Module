<!-- Cost Table -->
<div v-if="planId != null" class="row m-0 p-0 py-5 px-4 mt-5">    
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
                    PLACE: {{ regionName }}
                </p>
                <p class="h6 ms-3">
                    Data Center: {{ DataCenterName }}
                </p>
                <p class="h6 ms-3">
                    NAME : {{ planName }}
            
                </p>
                <p class="h6 ms-3">
                    PRICE: {{ showMachinePriceInWhmcsUnit(ConverFromCaasifyToWhmcs(planPrice)) }} {{ userCurrencySymbolFromWhmcs }}
                </p>
            </div>
            <div v-if="!EmptyPlanConfigs" class="mt-5">
                <p class="h4 mb-3">
                    Add-ons features
                </p>
                <div v-for="(PlanConfig, index) in PlanConfigs" class="d-flex flex-row justify-content-start align-items-center">
                    <div>
                        <span class="h6 ms-3" v-if="PlanConfig?.name">
                            {{ PlanConfig.name }}
                        </span>
                    </div>    
                    <div v-if="PlanConfigSelectedOptions[PlanConfig.name]['price']" class="m-0 p-0 ps-4 text-primary">
                        <span v-if="PlanConfigSelectedOptions[PlanConfig.name]['price'] == 0">
                            free
                        </span>
                        <span v-else>
                            {{ showMachinePriceInWhmcsUnit(ConverFromCaasifyToWhmcs(PlanConfigSelectedOptions[PlanConfig.name]['price'])) }} {{ userCurrencySymbolFromWhmcs }}
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




