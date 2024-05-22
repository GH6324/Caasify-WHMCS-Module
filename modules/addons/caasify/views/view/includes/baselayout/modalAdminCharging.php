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
                    <div class="my-5 fw-medium text-dark" v-if="ChargeAmount != null && ChargeAmount != 0">
                        <p class="fs-5" v-if="CommissionIsValid">
                            <span v-if="ChargeAmount != null && CommissionIsValid && ChargeAmount > 0">
                                <span>
                                    Your are goting to <b>Increase</b> charge this user for : 
                                </span>
                                <span class="text-primary ms-3">
                                    {{ ChargeAmount * (1+(config.Commission/100)) }} €
                                </span>
                            </span>
                            <span v-if="ChargeAmount != null && CommissionIsValid && ChargeAmount < 0">
                                <span>
                                    Your are goting to <b>Decrease</b> charge this user for : 
                                </span>
                                <span class="text-danger ms-3">
                                    {{ ChargeAmount * (1+(config.Commission/100)) }} €
                                </span>
                            </span>
                        </p>
                        <p class="h4" v-if="CommissionIsValid">
                            Are you sure ?
                        </p>

                        <p class="fs-5" v-if="!CommissionIsValid">
                            Error: NaN
                        </p>
                    </div>
                    <div class="my-5 fw-medium text-dark" v-else>
                        <p class="fs-5">
                            It is not valid number
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="modal-body" v-if="ChargingIsInProcess == true">
                <div class="">
                    <div class="my-5 fw-medium h5 text-dark">
                        <p class="text-primary" v-if="CommissionIsValid">
                            <span class="">
                                Charging user for ( {{ ChargeAmount * (1+(config.Commission/100)) }} € Euro)
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
                        <button v-if="ChargeAmount != null && CommissionIsValid && ChargeAmount > 0" class="btn px-4 ms-2 border-0" @click="IncreaseChargeCaasify" :disabled="ChargingIsInProcess" :class="ChargeBtnClass" style="--bs-bg-opacity: 0.2;">
                            Increase for {{ ChargeAmount  * (1+(config.Commission/100)) }} € Caasify
                        </button>
                        <button v-if="ChargeAmount != null && CommissionIsValid && ChargeAmount < 0" class="btn px-4 ms-2 border-0" @click="DecreaseChargeCaasify" :disabled="ChargingIsInProcess" :class="ChargeBtnClass" style="--bs-bg-opacity: 0.2;">
                            Decrease for {{ ChargeAmount  * (1+(config.Commission/100)) }} € Caasify
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- end modal -->

