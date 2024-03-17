<!-- create machine modal -->
<div class="modal fade modal-lg" id="createModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="false">
    <div class="modal-dialog" style="max-width: 800px !important;">
        <div class="modal-content border-0">
            <!-- Modal Body -->
            <div class="m-0 p-0">
                <div class="modal-body" style="min-height: 350px !important;">
                    <div class="row m-0 p-0 pt-5">
                        <div class="col-12 text-start lh-lg pb-3">
                        
                            <!-- Just Open window, Ready to order -->
                            <div v-if="!userClickedCreationBtn">   

                                <!-- enough data to push btn -->
                                <div v-if="themachinename && SelectedRegion && SelectedPlan && PlanConfigSelectedOptions">
                                    <p class="h5 fw-Medium">{{ lang('youarecreating') }}</p>
                                    <p class="fs-6 fw-light mt-3">{{ lang('makesure') }}</p>
                                </div>

                                <!-- Table of parameters -->
                                <div class="px-4 px-lg-5 py-5 rounded-4 bg-primary" style="--bs-bg-opacity: 0.15;">
                                    <table class="table table-borderless m-0 p-0 my-5" style="--bs-table-bg: #fff0;">
                                        <tbody>
                                            
                                            <!-- HostName -->
                                            <tr>
                                                <td class="m-0 p-0">
                                                    <i v-if="themachinename" class="bi bi-check-circle-fill me-1"></i>
                                                    <i v-if="!themachinename" class="bi bi-circle me-1"></i>                                                    
                                                    <span>{{ lang('name') }}</span>
                                                </td>
                                                <td class="text-primary fw-medium m-0 p-0">
                                                    <span v-if="themachinename" class="m-0 p-0">{{ themachinename }}</span>
                                                    <span v-else-if="!themachinename">    
                                                        <?php  include('./includes/baselayout/threespinner.php');      ?>
                                                    </span>
                                                </td>
                                            </tr>

                                            <!-- Datacenter -->
                                            <tr v-if="SelectedRegion && SelectedDataCenter">
                                                <td class="m-0 p-0">
                                                    <i v-if="SelectedRegion?.name && SelectedDataCenter?.name" class="bi bi-check-circle-fill me-1"></i>
                                                    <i v-if="!SelectedRegion?.name || !SelectedDataCenter?.name" class="bi bi-circle me-1"></i>
                                                    <span>{{ lang('datacenter') }}</span>
                                                </td>
                                                <td class="text-primary fw-medium m-0 p-0">
                                                    <span v-if="SelectedDataCenter?.name" class="m-0 p-0 pe-2">{{ SelectedDataCenter?.name }}</span>
                                                    <span v-else-if="!SelectedDataCenter?.name">    
                                                        <?php  include('./includes/baselayout/threespinner.php');      ?>
                                                    </span>

                                                    <span v-if="SelectedRegion?.name" class="m-0 p-0">({{ SelectedRegion?.name }})</span>
                                                    <span v-else-if="!SelectedRegion?.name">    
                                                        <?php  include('./includes/baselayout/threespinner.php');      ?>
                                                    </span>
                                                </td>
                                            </tr>

                                            <!-- plan -->
                                            <tr v-if="SelectedPlan">
                                                <td class="m-0 p-0">
                                                    <i v-if="SelectedPlan.title" class="bi bi-check-circle-fill me-1"></i>
                                                    <i v-if="!SelectedPlan.title" class="bi bi-circle me-1"></i>
                                                    {{ lang('product') }}
                                                </td>
                                                <td class="text-primary fw-medium m-0 p-0">
                                                    <span v-if="SelectedPlan.title" class="m-0 p-0">{{ SelectedPlan.title }}</span>
                                                    <span v-else-if="!SelectedPlan.title">
                                                        <?php  include('./includes/baselayout/threespinner.php');      ?>
                                                    </span>
                                                </td>
                                            </tr>

                                            <!-- Section Configs -->
                                            <tr v-if="PlanConfigSelectedOptions" v-for="(value, key) in PlanConfigSelectedOptions">
                                                <td class="m-0 p-0">
                                                    <i v-if="key" class="bi bi-check-circle-fill me-1"></i>
                                                    <i v-else class="bi bi-circle me-1"></i>
                                                    <span>
                                                        {{ key }}:
                                                    </span>
                                                </td>
                                                <td class="text-primary fw-medium m-0 p-0">
                                                    <div v-if="value?.value">
                                                        <span class="m-0 p-0">
                                                            {{ value.name }}
                                                        </span>
                                                    </div> 
                                                    <div v-else-if="value?.options">
                                                        <span v-if="value.options != ''" class="m-0 p-0">
                                                            {{ value.options }}
                                                        </span>
                                                        <span v-else class="m-0 p-0">
                                                            <?php  include('./includes/baselayout/threespinner.php');      ?>
                                                        </span>
                                                    </div>    
                                                    <span v-else>
                                                        <?php  include('./includes/baselayout/threespinner.php');      ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <hr>

                                    <!-- Total Price -->
                                    <div v-if="NewMachinePrice" class="float-end text-primary fw-medium">
                                        <p>
                                            Total Price : {{ showMachinePriceInWhmcsUnit(ConverFromCaasifyToWhmcs(NewMachinePrice)) }} {{ userCurrencySymbolFromWhmcs }}
                                        </p>
                                    </div>
                                </div>

                                <!-- not enough data -->
                                <div v-if="!themachinename || !SelectedRegion || !SelectedPlan" class="row m-0 p-0 mt-5">
                                    <p class="alert alert-danger">
                                        {{ lang('notprovideallinformation') }}
                                    </p>        
                                </div>    

                                <!-- Low Balance -->
                                <div v-if="user.balance < 2">
                                    <p class="alert alert-danger text-center py-2 mt-5">
                                        {{ lang('balanceisnotenough') }}
                                    </p>
                                    <a class="btn btn-danger float-end" href="<?php echo($PersonalRootDirectoryURL); ?>/index.php?m=caasify&action=pageIndex" target='_top'>{{ lang('movebalance') }}</a>
                                </div>
                            </div>

                            <!-- Btn Pressed [two case: 1-succed or failed] -->
                            <div v-if="userClickedCreationBtn" class="col-12 text-start lh-lg pb-3">
                                <!-- 1 (succed, reload, open list) -->
                                <div v-if="createActionSucced" class="m-0 p-0">
                                    <div class="row m-0 p-0 px-3">
                                        <p class="fs-5 fw-Medium text-primary p-0 m-0">
                                            {{ lang('machinecreatesuccessfully') }}  
                                        </p>
                                        <p class="fs-6 fw-Medium text-dark p-0 m-0 pb-5">
                                            {{ lang('createsuccessmsg') }}  
                                        </p>
                                    </div> 
                                    <div class="row d-flex flex-row justify-content-end p-0 m-0">
                                        <a class="col-auto btn btn-primary px-4 py-2" href="<?php echo($PersonalRootDirectoryURL); ?>/index.php?m=caasify&action=pageIndex" target='_top'>{{ lang('machinelink') }}</a>        
                                    </div> 
                                </div>

                                <!-- 2 (failed, reload, do again) -->
                                <div v-if="createActionFailed" class="m-0 p-0">
                                    <div class="row m-0 p-0 px-3">
                                        <p class="fs-5 fw-Medium text-dark p-0 m-0">
                                            {{ lang('createmachinefailed') }}  
                                        </p>
                                        <p v-if="CreateMSG != null" class="text-danger p-0 m-0 mt-5 h5">
                                            {{ CreateMSG }}
                                        </p>
                                    </div> 
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div v-if="!userClickedCreationBtn" class="row m-0 p-0 pt-5 mb-2">
                        <div class="form-check form-switch d-flex flex-row justify-content-start align-items-center px-3">
                            <input v-model="checkboxconfirmation" class="form-check-input ms-0" type="checkbox" role="switch" id="checkboxconfirmation">
                            <label class="form-check-label ms-3" :class="checkboxconfirmation ? '' : 'text-secondary'" for="checkboxconfirmation">
                                {{ lang('confirmationtext') }}
                            </label>                            
                        </div>
                    </div>
                </div>       
            </div>

           

            <!-- Modal Footer -->
            <div class="d-flex flex-row modal-footer justify-content-between">
                
                <!-- Balance -->
                <div class="m-0 p-0 mx-3">
                    <span class="text-dark fw-medium me-2">{{ lang('balance') }} : </span>
                    <span v-if="user.balance" class="text-primary fw-medium">
                        <span v-if="CurrenciesRatioCloudToWhmcs != null">
                            {{ showBalanceWhmcsUnit(ConverFromCaasifyToWhmcs(user.balance)) }} {{ userCurrencySymbolFromWhmcs }}
                        </span>
                        <span v-else>
                            <?php include('./includes/baselayout/threespinner.php'); ?>
                        </span>                                        
                    </span>
                    <span v-else class="text-primary fw-medium"> --- </span>
                </div>
                
                <!-- BTN's -->
                <div class="d-flex flex-row">
                    <!-- Close BTN ( two typ: 1-[normal close] , 2-[close+relaod] )-->
                    
                    <!-- 1- Normal close, before click -->
                    <div v-if="!userClickedCreationBtn || createActionFailed" class="m-0 p-0">
                        <a @click="closeConfirmDialog" type="button"
                            class="btn btn-secondary px-4 mx-2 border-0" style="background-color: #515151"
                            data-bs-dismiss="modal">
                            <div>
                                {{ lang('close') }}
                            </div>
                        </a>
                    </div>

                    <!-- 2- CloseReload, after click [Close + Reload = make another machine] -->
                    <div v-if="userClickedCreationBtn && createActionSucced" class="m-0 p-0">
                        <a @click="reloadPage" type="button"
                            class="btn btn-secondary px-4 mx-2 border-0" style="background-color: #515151"
                            data-bs-dismiss="modal">
                            <div>
                                {{ lang('createanothermachine') }}
                            </div>
                        </a>
                    </div>
                    

                    <!-- Create BTN -->
                    <div v-if="!userClickedCreationBtn">
                        <div class="m-0 p-0" v-if="themachinename && SelectedRegion && SelectedPlan && NewMachinePrice">
                            <a v-if="checkboxconfirmation" @click="acceptConfirmDialog" type="button" class="btn btn-primary px-5 mx-2">
                                <span>{{ lang('createthismachine') }}</span>
                            </a>
                        </div>
                    </div>


                    <!-- try again, (force reload) -->
                    <div v-if="userClickedCreationBtn && createActionFailed" class="m-0 p-0">
                        <div class="m-0 p-0">
                            <a @click="closeConfirmDialog" type="button" class="btn btn-primary px-5 mx-2" data-bs-dismiss="modal">
                                <span>{{ lang('tryagain') }}</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div><!-- end modal -->