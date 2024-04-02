<div class="row d-flex flex-row align-items-stretch text-start m-0 p-0">
    <!-- OrderDetails -->
    <div class="col-12 col-xl-6 p-0 m-0 mb-2 flex-grow-1 pe-xl-1">
        <div class="border border-2 rounded-4 bg-white m-0 p-0 py-4 px-4 mx-0 me-xl-1 pb-5 h-100">
            <div class="m-0 p-0">
                <!-- Title -->
                <div class="m-0 p-0 mb-5">
                    <span class="m-0 p-0">
                        <i class="bi bi-list-ul text-secondary fw-medium h3 me-2"></i>
                        <span class="text-secondary fw-medium my-auto h3">
                            Order Details
                        </span>
                    </span>
                </div>

                <!-- Hostname -->
                <div class="m-0 p-0">
                    <div class="d-flex flex-row justify-content-start align-items-center m-0 p-0 flex-wrap">
                        <div class="m-0 p-0 me-md-3">
                            <div class="m-0 p-0">
                                <span class="">
                                    <span class="m-0 p-0 h5">
                                        <span class="text-secondary">
                                            Hostname : 
                                        </span>
                                        <span v-if="thisOrder?.note" class="h4 text-primary">
                                            {{ thisOrder?.note }}
                                        </span>
                                        <span v-else class="h4 text-primary">
                                            --- 
                                        </span>
                                    </span>
                                </span>
                            </div>    
                        </div>
                        
                        <div class="m-0 p-0 d-none d-md-block ms-2">
                            <span class="btn bg-primary text-primary py-2 d-flex flex-row align-items-center px-4 btn-sm" style="--bs-bg-opacity: .2">
                                <span class="spinner-grow text-primary my-auto m-0 p-0 me-1 align-middle" style="--bs-spinner-width: 7px; --bs-spinner-height: 7px; --bs-spinner-animation-speed: 2s;"></span>
                                <span class="ms-1 pe-2" v-if="thisOrder?.status"> {{ thisOrder?.status.toUpperCase() }} </span>
                                <span class="ms-1" v-else> - </span>
                            </span>
                        </div>
                        
                        <div class="m-0 p-0 d-none d-md-block ms-2">
                            <span class="btn bg-primary text-primary py-2 d-flex flex-row align-items-center px-2 ms-2 btn-sm" style="--bs-bg-opacity: .2">
                                <span class="ms-1 pe-2" v-if="thisOrder?.created_at"> {{ MachineSpendTime(thisOrder?.created_at) }} </span>
                                <span class="ms-1" v-else> - </span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="m-0 p-0 py-4">
                    <hr class="text-secondary border-2 border-secondary m-0 p-0">
                </div>

                <!-- bottom slice -->
                <div class="m-0 p-0">
                    <div class="m-0 p-0 mt-0">
                    
                        <!-- Balance -->
                        <div class="row m-0 p-0">
                            <div class="col-auto m-0 p-0" style="min-width: 120px;">
                                <span class="text-secondary align-middle m-0 p-0">
                                    Product Price : 
                                </span>
                            </div>
                            <div class="col-auto m-0 p-0">
                                <span class="text-primary align-middle m-0 p-0 fw-medium" v-if="thisOrder?.records[thisOrder.records.length - 1].price">
                                    <span>
                                        {{ showBalanceWhmcsUnit(ConvertFromCaasifyToWhmcs(thisOrder.records[thisOrder.records.length - 1].price)) }}
                                    </span>
                                    <span v-if="userCurrencySymbolFromWhmcs" class="ms-1">
                                        {{ userCurrencySymbolFromWhmcs }}
                                    </span>
                                </span>
                                <span class="text-secondary align-middle m-0 p-0 fw-medium" v-else>
                                    <span>
                                        ...
                                    </span>
                                </span>
                            </div>
                        </div>

                        <!-- Billing Cycle -->
                        <div class="row m-0 p-0">
                            <div class="col-auto m-0 p-0" style="min-width: 120px;">
                                <span class="text-secondary align-middle m-0 p-0">
                                    Billing Cycle :
                                </span>
                            </div>
                            <div class="col-auto m-0 p-0">
                                <span class="text-secondary align-middle m-0 p-0 fw-medium">
                                    Pay as you go
                                </span>
                            </div>
                        </div>
                    </div>
                </div><!-- end bottom -->
            
            </div>
        </div>
    </div>
    <!-- UserDetails -->
    <div class="col-12 col-xl-6 p-0 m-0 mb-2 flex-grow-1">
        <div class="border border-2 rounded-4 bg-white m-0 p-0 py-4 px-4 mx-0 me-xl-1 pb-5 h-100">
            <div class="m-0 p-0">
                <!-- Title -->
                <div class="m-0 p-0 mb-5">
                    <span class="m-0 p-0">
                        <i class="bi bi-person-badge text-secondary fw-medium h3 me-2"></i>
                        <span class="text-secondary fw-medium my-auto h3">
                            User Information
                        </span>
                    </span>
                </div>

                <!-- Hostname -->
                <div class="m-0 p-0">
                    <div class="d-flex flex-row justify-content-start align-items-center m-0 p-0 flex-wrap">
                        <div class="m-0 p-0 me-md-3">
                            <div class="m-0 p-0">
                                <span class="">
                                    <span class="m-0 p-0 h5">
                                        <span class="text-secondary">
                                            Name : 
                                        </span>
                                        <span v-if="user?.name" class="h4 text-primary">
                                            {{ user?.name }}
                                        </span>
                                        <span v-else class="h4 text-primary">
                                            --- 
                                        </span>
                                    </span>
                                </span>
                            </div>    
                        </div>
                    </div>
                </div>

                <div class="m-0 p-0 py-4">
                    <hr class="text-secondary border-2 border-secondary m-0 p-0">
                </div>

                <!-- bottom slice -->
                <div class="m-0 p-0">
                    <div class="m-0 p-0 mt-0">
                    
                        <!-- Balance -->
                        <div class="row m-0 p-0">
                            <div class="col-auto m-0 p-0" style="min-width: 180px;">
                                <span class="text-secondary align-middle m-0 p-0">
                                    Cloud Balance : 
                                </span>
                            </div>
                            <div class="col-auto m-0 p-0">
                                <span class="text-primary align-middle m-0 p-0 fw-medium" v-if="balance">
                                    <span>
                                        {{ showBalanceWhmcsUnit(ConvertFromCaasifyToWhmcs(balance)) }}
                                    </span>
                                    <span v-if="userCurrencySymbolFromWhmcs" class="ms-1">
                                        {{ userCurrencySymbolFromWhmcs }}
                                    </span>
                                </span>
                                <span class="text-secondary align-middle m-0 p-0 fw-medium" v-else>
                                    <span>
                                        ...
                                    </span>
                                </span>
                            </div>
                        </div>

                        <!-- WHMCS User Credit -->
                        <div class="row m-0 p-0">
                            <div class="col-auto m-0 p-0" style="min-width: 180px;">
                                <span class="text-secondary align-middle m-0 p-0">
                                    WHMCS User Credit :
                                </span>
                            </div>
                            <div class="col-auto m-0 p-0">
                                <span class="text-secondary align-middle m-0 p-0 fw-medium" v-if="WhmcsUserInfo?.credit">
                                    {{ showCreditWhmcsUnit(WhmcsUserInfo?.credit) }}
                                </span>
                                <span v-if="userCurrencySymbolFromWhmcs" class="ms-1" v-if="WhmcsUserInfo?.credit">
                                        {{ userCurrencySymbolFromWhmcs }}
                                </span>
                                <span class="text-secondary align-middle m-0 p-0 fw-medium" v-else>
                                    ---
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            
            </div>
        </div>
    </div>
    
</div>


