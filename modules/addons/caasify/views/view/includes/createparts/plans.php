<!-- plan-->
<div v-if="SelectedRegion != null" class="row m-0 p-0 py-5 px-4 mt-5" id="plans">
    <div class="col-12" style="--bs-bg-opacity: 0.1;">
        <div class="row mb-4">
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
        <div v-if="plansAreLoading" class="row">
            <div class="col-12 mb-5">
                <div class="d-flex flex-row justify-content-start align-items-center mt-4 text-primary">
                    <p class="h5 me-4">{{ lang('loadingmsg') }}</p>
                    <span>
                        <?php include('./includes/baselayout/threespinner.php'); ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- order details -->
        <div v-if="plansAreLoaded" class="row">
            <!-- Selected but empty -->
            <div v-if="plans.length < 1" class="alert bg-danger text-danger" style="--bs-bg-opacity: 0.1" role="alert">
                {{ lang('thereisnodatacenter') }}
            </div>
            <div v-if="plans.length > 0" v-for="plan in plans" class="col-12 m-0 p-0 py-2">
                <div class="d-flex flex-row justify-content-between align-items-center">
                    <div class="flex-grow-1">
                        <div v-html="plan.description" :class="{ 'border-secondary border-2 text-dark': isPlan(plan) }" @click="selectPlan(plan)" class="d-flex flex-row justify-content-between align-items-center border rounded-3 bg-white text-dark shadow-sm py-3 px-4 flex-grow-1 bg-body-secondary" style="--bs-bg-opacity: 0.1;"></div>
                    </div>
                    <div v-if="plan.price" class="fw-medium px-4 btn bg-body-secondary ms-3 py-3" style="width: 130px;" :class="{ 
                            'text-dark border-2 border-secondary': isPlan(plan), 
                            'text-secondary': !isPlan(plan) }">
                        {{ formatCostMonthly(ConvertFromCaasifyToWhmcs(plan.price)) }} {{userCurrencySymbolFromWhmcs}}
                    </div>
                </div>
            </div>
        </div> <!-- end order  -->
    </div>
</div>
<!-- end plan -->
<div id="configsPoint"></div>