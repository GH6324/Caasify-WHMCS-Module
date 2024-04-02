<!-- plan-->
<div v-if="SelectedRegion != null" class="row m-0 p-0 py-5 px-4 mt-5" id="plans">    
    <div class="col-12" style="--bs-bg-opacity: 0.1;">
        <div class="row mb-5">
            <div class="m-0 p-0">
                <span class="text-dark h3">
                    {{ lang('products') }}
                </span>
                <span class="text-dark h3">
                    in
                </span>
                <span class="text-dark h3">
                    {{ SelectedRegion.name }} *
                </span>
            </div>
        </div>
        <!-- Selected but loading -->
        <div v-if="plansAreLoading" class="row mt-5">
            <div class="col-12 mb-5" >        
                <div class="d-flex flex-row justify-content-start align-items-center mt-4 text-primary">
                    <p class="h5 me-4">{{ lang('loadingmsg') }}</p>
                    <span>
                        <?php include('./includes/baselayout/threespinner.php'); ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- order details -->
        <div v-if="plansAreLoaded" class="row mt-5">
            <!-- Selected but empty -->
            <div v-if="plans.length < 1" class="alert bg-danger text-danger" style="--bs-bg-opacity: 0.1" role="alert">
                {{ lang('thereisnodatacenter') }}
            </div>
            <div v-if="plans.length > 0" v-for="plan in plans" class="col-12 col-md-6 col-lg-4 m-0 p-0 mb-5 px-1" >
                <div class="border rounded-4 bg-white shadow-sm" :class="{ 'shadow-lg border-secondary border-2 ': isPlan(plan) }" @click="selectPlan(plan)">
                    <div class="bg-body-secondary rounded-top-4 py-4 px-5 px-md-3 px-xl-4" style="--bs-bg-opacity: 0.5;">
                        <div class="p-0 m-0">
                            <div class="d-flex flex-row justify-content-center">
                                <div class="">
                                    <span class="h5 m-0 p-0">
                                        {{ plan.title }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-bottom-4 py-4 px-4">
                        <div class="m-0 p-0 px-3 px-md-0">
                            <!-- Description -->
                            <div class="d-flex flex-row justify-content-start py-2">
                                <div class="d-flex flex-row justify-content-start">
                                    <span v-if="plan?.description != null" class="fs-6 text-dark fw-medium text-start" style="height: 90px;">
                                        {{ plan.description }}
                                    </span>                                            
                                    <span v-else class="fs-6 text-dark fw-medium">
                                        ---
                                    </span>
                                </div>
                            </div>
                            <!-- End MemDescriptionory -->
                            <hr>
                            
                            <!-- Plan start from  -->
                            <div v-if="plan?.price != null && userCurrencySymbolFromWhmcs != null" class="d-flex flex-row justify-content-center py-2 btn bg-secondary" style="--bs-bg-opacity: 0.1;">
                                <div class="d-flex flex-row justify-content-center">
                                    <span class="fs-6 fw-medium me-2">
                                    {{ lang('price') }}
                                    </span>
                                    <span class="fs-6 fw-medium">
                                        {{ formatCostMonthly(ConvertFromCaasifyToWhmcs(plan.price)) }} {{ userCurrencySymbolFromWhmcs }}
                                    </span>
                                </div>
                            </div><!-- End MemDescriptionory -->
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end order  -->
    </div>
</div>
<!-- end plan -->
<div id="configsPoint"></div>