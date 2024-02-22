<!-- Data Centers -->
<div class="row m-0 p-0 mt-5">
    <div class="col-12 m-0 p-0" style="--bs-bg-opacity: 0.1;">
        <div class="row">
            <div class="row">
                <span class="h3">
                {{ lang('datacenters') }}
                </span>
            </div>

            <div class="row">
                <span class="fs-6 pt-1 pb-4 text-secondary">
                {{ lang('chooseregion') }}
                </span>
            </div>
        </div> 
        
        <div class="row">
            <div v-if="DataCentersAreLoaded && DataCentersLength > 0" v-for="DataCenter in DataCenters" class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                <div class="d-flex flex-column align-items-center border rounded-5 bg-light shadow-sm py-4 mx-1 px-2" 
                style="max-width: 165px !important; --bs-bg-opacity: 0.5 !important;"
                :class="{ 'shadow-lg border border-2 border-secondary': isDataCenter(DataCenter) }" 
                @click="selectDataCenter(DataCenter)">
                    <div class="d-flex flex-row justify-content-center" style="width: 50px !important; height: 50px !important">
                        <img :src="DataCenter?.image" class="m-0 p-0" style="width: 50px !important; height: 50px !important">
                    </div>
                    
                    <div class="row text-center mt-3">
                        <span class="text-secondary m-0 p-0 mt-3">
                            {{ DataCenter.name }}
                        </span>
                    </div>
                </div>
            </div>
            <div v-if="!DataCentersAreLoaded" class="d-flex flex-row justify-content-start align-items-center mt-4 text-primary">
                <p class="h5 me-4">{{ lang('loadingmsg') }}</p>
                <span>
                    <?php include('./includes/commodules/threespinner.php'); ?>
                </span>
            </div>
            <div v-if="DataCentersAreLoaded && DataCentersLength == 0" class="d-flex flex-row justify-content-start align-items-center mt-4 text-primary">
                <p class="h5 me-4">
                    Err. There is no DataCenter to show
                </p>
            </div>
        </div>
    </div>
</div>
