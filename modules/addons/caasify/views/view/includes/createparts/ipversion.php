<!-- Host Name -->
<div v-if="planId != null" class="row m-0 p-0 border rounded-4 bg-body-secondary py-5 px-4 mt-5"> 
    <div class="col-12 m-0 p-0" style="--bs-bg-opacity: 0.1;">
        <div class="m-0 p-0">
            <!-- name -->
            <div class="m-0 p-0">
                <div class="m-0 p-0">
                    <p class="text-dark h3">
                        {{ lang('ipv') }}
                    </p>
                    <p class="fs-6 pt-1 text-secondary">
                        {{ lang('please Select Your IPV') }}    
                    </p>
                </div>
                <hr class="pb-4">
                <div class="row m-0 p-0">
                    <!-- Table of IPV -->
                    <div class="mt-5 px-4 px-lg-5 py-4 rounded-4 bg-primary" style="--bs-bg-opacity: 0.05;">
                        <div class="row m-0 p-0">
                            <div class="col-12 col-md-6 m-0 p-0 d-flex flex-row align-items-center">
                                <input class="form-check-input p-0 m-0 border-2 h4" type="checkbox" v-model="ipv4Checkbox" :value="ipv4Checkbox" id="ipv4checkbox">
                                <label class="form-check-label ms-2 h5" for="ipv4checkbox">
                                    <span>
                                        {{ lang('ipvversion4') }}
                                    </span>
                                    <span class="ps-2 fw-medium">
                                        Ipv4
                                    </span>
                                </label>
                            </div>
                            <div class="col-12 col-md-6 m-0 p-0 d-flex flex-row align-items-center">
                                <input class="form-check-input p-0 m-0 border-2 h4" type="checkbox" v-model="ipv6Checkbox" :value="ipv6Checkbox" id="ipv6checkbox">
                                <label class="form-check-label ms-2 h5" for="ipv6checkbox">
                                    <span>
                                        {{ lang('ipvversion6') }}
                                    </span>
                                    <span class="ps-2 fw-medium">
                                        Ipv6
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div> 
<!-- End Name -->


