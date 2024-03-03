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
                <p class="h6">
                    PLACE: {{ regionName }}
                </p>
                <p class="h6">
                    Data Center: {{ DataCenterName }}
                </p>
                <p class="h6">
                    NAME : {{ planName }}
            
                </p>
                <p class="h6">
                    PRICE: {{ planPrice }}
                </p>
            </div>
        </div>
        
        <!-- Summery Table -->
        <div class="row mt-5">
            <div class="m-0 p-0">
                <p class="text-dark h4">
                    <i class="bi bi-currency-exchange text-secondary p-0 m-0 me-3 h5"></i>
                    <span>
                        {{ lang('totalcost') }} = 
                    </span>
                    <span>
                        {{ planPrice }}
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>




