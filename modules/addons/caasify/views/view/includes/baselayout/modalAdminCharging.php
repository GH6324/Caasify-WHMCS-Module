<!-- modalDemo -->
<div class="modal fade" id="ModalChargingAdmin" tabindex="-1" aria-labelledby="ModalChargingAdminLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top" style="max-width: 550px; padding-top: 20px">  
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="h5 text-dark p-0 m-0">Charging User Balance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- ChargeAmount -->
            <div class="modal-body" v-if="ChargeAmount != null && ChargingIsInProcess != true">
                <div class="">
                    <div class="my-5 fw-medium text-dark">
                        <p class="fs-5">
                            <span>
                                Your are goting to charge this user for : 
                            </span>
                            <span class="text-primary">
                                {{ ChargeAmount }} €
                            </span>
                        </p>
                        <p class="h4">
                            Are you sure ?
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="modal-body" v-if="ChargingIsInProcess == true">
                <div class="">
                    <div class="my-5 fw-medium h5 text-dark">
                        <p class="text-primary">
                            <span class="">
                                Charging user for ( {{ ChargeAmount }} €)
                            </span>
                            <span class="m-0 p-0 ps-2">
                                <?php include('./includes/baselayout/threespinner.php'); ?>
                            </span> 
                        </p>
                    </div>
                </div>
            </div>

            <!-- Succeed -->
            <div class="modal-body" v-if="ChargingResponse?.data != null">
                <div class="">
                    <div class="my-5 fw-medium text-dark">
                        <p class="alert alert-success py-2">
                            Charge action has done Successfully
                        </p>
                        <p class="alert alert-primary py-2">
                            This might take some minutes to see result in user balance
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- failed -->
            <div class="modal-body" v-if="ChargingResponse?.message != null">
                <div class="">
                    <div class="my-5 fw-medium">
                        <p class="alert alert-danger py-2">
                            <span>
                                Error: 
                            </span>
                            <span>
                                {{ ChargingResponse?.message }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="d-flex flex-column justify-content-end align-items-center">
                    <div class="m-0 p-0 mx-2">
                        <button type="button" class="btn btn-secondary px-4 border-0" data-bs-dismiss="modal" :disabled="ChargingIsInProcess">
                            Close
                        </button>
                        <button v-if="ChargeAmount != null" class="btn btn-primary px-4 ms-2 border-0" @click="chargeCaasify" :disabled="ChargingIsInProcess">
                            Charge User for {{ ChargeAmount }} €
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- end modal -->

