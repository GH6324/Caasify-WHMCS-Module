<?php $parentFileName = basename(__FILE__, '.php'); ?>
<?php  include('config.php');   ?>
<?php  include_once('./includes/baselayout/header.php');   ?>
<body class="container-fluid m-0 p-0" style="background-color: #ff000000 !important;">
    <div class="bg-light rounded-4 border border-2 border-body-secondary px-3 px-md-4 py-4" style="min-height: 300px;">
        <div class="adminapp col-12" v-cloak>
            <?php  include_once('./includes/baselayout/modalAdminCharging.php');   ?>
            <p class="alert alert-danger" v-if="config?.errorMessage"> {{ config?.errorMessage }}</p>
            <div class="m-0 p-0" v-cloak>
                <div class="row">
                    <!-- User info -->
                    <div class="col-12 mb-3 mb-xxl-0">
                        <div class="">
                            <div class="row" v-if="CommissionIsValid">
                                <!-- UserInfo -->
                                <div class="col-12 col-lg-6 mt-lg-0" v-if="CommissionIsValid">
                                    <div class="row">
                                        <!-- Admin Finance -->
                                        <div class="row pb-3">
                                            <div class="col-12">
                                                <p class="h5 text-secondary">
                                                    <span class="m-0 p-0 ps-2">
                                                        Admin Finance
                                                        <span class="spinner-border spinner-border-sm text-secondary ms-2" role="status" v-if="UserInfoIsLoading == true"></span>
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="" v-if="UserInfoIsLoaded && ResellerInfoIsLoaded">
                                            <div class="lh-sm">
                                                <div class="input-group my-2" style="width: 260px;">
                                                    <span class="input-group-text text-start bg-body-secondary text-dark p-0 m-0 px-3" style="--bs-bg-opacity: 0.1; width: 140px;">
                                                        Commission
                                                    </span>
                                                    <input class="form-control bg-light text-start" :value="config?.Commission + '%'" style="width: 100px;" disabled>
                                                </div>
                                            </div>

                                            <!-- Admin Balance -->
                                            <div class="lh-sm">
                                                <div class="input-group my-2" style="width: 480px;">
                                                    <span class="input-group-text text-start bg-body-secondary text-dark p-0 m-0 px-3" style="--bs-bg-opacity: 0.1; width: 140px;">
                                                        Admin Balance
                                                    </span>
                                                    <input class="form-control bg-light text-start" :value="Number(CaasifyResellerInfo?.balance).toFixed(2)" style="width: 100px;" disabled>
                                                    <span class="input-group-text text-start bg-body-secondary text-dark p-0 m-0 px-3" style="--bs-bg-opacity: 0.1; width: 90px; width: 220px;">
                                                        € Caasify (without Commission)
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="lh-sm">
                                                <div class="input-group my-2" style="width: 480px;">
                                                    <span class="input-group-text text-start bg-body-secondary text-dark p-0 m-0 px-3" style="--bs-bg-opacity: 0.1; width: 140px;">
                                                        Admin Balance
                                                    </span>
                                                    <input class="form-control bg-light text-start" :value="Number((CaasifyResellerInfo?.balance)*(1+(config?.Commission/100))).toFixed(2)" style="width: 100px;" disabled>
                                                    <span class="input-group-text text-start bg-body-secondary text-dark p-0 m-0 px-3" style="--bs-bg-opacity: 0.1; width: 90px; width: 220px;">
                                                        € Euro (with Commission)
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <hr class="border-2 my-4" v-if="UserInfoIsLoaded && ResellerInfoIsLoaded && config?.Commission != null">

                                        <!-- User Finance -->
                                        <div class="row pb-3 mt-3" v-if="UserInfoIsLoaded && ResellerInfoIsLoaded && config?.Commission != null">
                                            <div class="col-12">
                                                <p class="h5 text-secondary">
                                                    <span class="m-0 p-0 ps-2">
                                                        User Finance
                                                    </span>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- User Balance -->
                                        <div class="" v-if="UserInfoIsLoaded && ResellerInfoIsLoaded && config?.Commission != null">
                                            <div class="lh-sm">
                                                <div class="input-group my-2" style="width: 480px;">
                                                    <span class="input-group-text text-start bg-body-secondary text-dark p-0 m-0 px-3" style="--bs-bg-opacity: 0.3; width: 140px;">
                                                        User Balance
                                                    </span>
                                                    <input class="form-control bg-light text-start" :value="Number(CaasifyUserInfo?.balance).toFixed(2)" style="width: 100px;" disabled>
                                                    <span class="input-group-text text-start bg-body-secondary text-dark p-0 m-0 px-3" style="--bs-bg-opacity: 0.3; width: 220px;">
                                                        € Caasify (without Commission)
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="lh-sm">
                                                <div class="input-group my-2" style="width: 480px;">
                                                    <span class="input-group-text text-start bg-body-secondary text-dark p-0 m-0 px-3" style="--bs-bg-opacity: 0.3; width: 140px;">
                                                        User Balance
                                                    </span>
                                                    <input class="form-control bg-light text-start" :value="Number((CaasifyUserInfo?.balance)*(1+(config?.Commission/100))).toFixed(2)" style="width: 100px;" disabled>
                                                    <span class="input-group-text text-start bg-body-secondary text-dark p-0 m-0 px-3" style="--bs-bg-opacity: 0.3; width: 220px;">
                                                        € Euro (with Commission)
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="border-2 my-4" v-if="UserInfoIsLoaded && ResellerInfoIsLoaded && config?.Commission != null">
                                        
                                        <!-- charge -->
                                        <div class="row pb-3 mt-3" v-if="UserInfoIsLoaded && ResellerInfoIsLoaded && config?.Commission != null">
                                            <div class="col-12">
                                                <p class="h5 text-secondary">
                                                    <span class="m-0 p-0 ps-2">
                                                        ± Charge Balance
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="" v-if="UserInfoIsLoaded && ResellerInfoIsLoaded && config?.Commission != null">
                                            <div class="lh-sm d-flex flex-column justify-content-center align-items-start">
                                                <div class="">
                                                    <div class="input-group my-2" style="width: 480px;">
                                                        <span class="input-group-text text-start p-0 m-0 px-3 fw-medium" style="--bs-bg-opacity: 0.1; width: 140px;" :class="ChargeBtnClass">
                                                            Amount to charge
                                                        </span>
                                                        <input class="form-control bg-light text-start text-dark fw-medium" v-model="ChargeAmount" style="width: 100px;">
                                                        <span class="input-group-text text-start p-0 m-0 px-3" style="--bs-bg-opacity: 0.1; width: 220px;" :class="ChargeBtnClass">
                                                            € Caasify (without Commission)
                                                        </span>
                                                    </div>
                                                    <div class="input-group my-2" style="width: 480px;">
                                                        <span class="input-group-text text-start p-0 m-0 px-3 fw-medium" style="--bs-bg-opacity: 0.1; width: 140px;" :class="ChargeBtnClass">
                                                            Amount to charge
                                                        </span>
                                                        <input class="form-control text-start text-dark fw-medium" :value="Number(ChargeAmount * (1+(config?.Commission/100))).toFixed(2)" style="--bs-bg-opacity: 0.3; width: 100px;" disabled :class="ChargeBtnClass">
                                                        <span class="input-group-text text-start p-0 m-0 px-3" style="--bs-bg-opacity: 0.1; width: 220px;" :class="ChargeBtnClass">
                                                            € Euro (with Commission)
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-row justify-content-cenetr">
                                                    <div v-if="ChargeAmount != null">

                                                        <button class="btn bg-primary text-dark px-4 fw-medium mt-3" style="--bs-bg-opacity: 0.4; width:480px" @click="openChargingDialogue" v-if="ChargeAmount > 0">
                                                            <span>
                                                                Increase User Balance
                                                            </span>
                                                        </button>
                                                        
                                                        <button class="btn bg-danger text-dark px-4 fw-medium mt-3" style="--bs-bg-opacity: 0.4; width:480px" @click="openChargingDialogue" v-if="ChargeAmount < 0">
                                                            <span>
                                                                Decrease User Balance
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-if="!UserInfoIsLoaded || !ResellerInfoIsLoaded" class="lh-sm ms-2 text-primary fw-medium fs-5">
                                            <span class="">
                                                Loading
                                            </span>
                                            <span class="m-0 p-0 ps-2">
                                                <?php include('./includes/baselayout/threespinner.php'); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 mt-lg-0" v-else>
                                    Commission is Wrong
                                </div>
                                <!-- Orders -->
                                <div class="col-12 col-lg-6 mt-5 mt-lg-0">
                                    <div class="row pb-3">
                                        <div class="col-12">
                                            <p class="h5 text-secondary">
                                                <span>
                                                    User Orders
                                                </span>
                                                <span class="spinner-border spinner-border-sm text-secondary ms-2" role="status" v-if="UserOrdersIsLoading == true"></span>
                                            </p>
                                        </div>
                                    </div>
                                    <div v-if="UserOrdersIsLoaded && UserOrders != null" class="lh-sm">
                                        <table class="table table-borderless pb-5 mb-5" style="--bs-table-bg: #ff000000;">
                                            <thead>
                                                <tr class="border-bottom text-center"
                                                    style="--bs-border-width: 2px !important; --bs-border-color: #e1e1e1 !important;">
                                                    <th scope="col" class="fw-light fs-6 text-secondary pb-3">ID</th>
                                                    <th scope="col" class="fw-light fs-6 text-secondary pb-3">name</th>
                                                    <th scope="col" class="fw-light fs-6 text-secondary pb-3">Alive</th>
                                                    <th scope="col" class="fw-light fs-6 text-secondary pb-3 d-none d-md-block">Price</th>
                                                </tr>
                                            </thead>
                                            <tbody v-for="(order, index) in UserOrders" :key="index">
                                                
                                                <tr class="border-bottom align-middle text-center" style="--bs-border-width: 1px !important; --bs-border-color: #e1e1e1 !important;">
                                                    <!-- ID -->
                                                    <td class="fw-medium">
                                                        <span v-if="order.id" class="text-dark fs-6 fw-medium">{{ order.id }}</span>
                                                        <span v-else class="text-dark fs-6 fw-medium"> --- </span>
                                                    </td>

                                                    <!-- Name -->
                                                    <td class="fw-medium">
                                                        <span v-if="order.note" class="text-dark fs-6 fw-medium">{{ order.note }}</span>
                                                        <span v-else class="text-dark fs-6 fw-medium"> --- </span>
                                                    </td>

                                                    <!-- Uptime -->
                                                    <td class="fw-medium">
                                                        <span v-if="order?.created_at" class="ms-2">
                                                            {{ order?.created_at }} 
                                                        </span>
                                                        <span v-else class="fw-medium"> --- </span>
                                                    </td>

                                                    <!-- record -->
                                                    <td class="fw-medium d-none d-md-block py-3">
                                                        <span v-for="record in order.records" class="m-0 p-0">
                                                            <span v-if="record.price" class="ms-2 text-primary">
                                                                <span>
                                                                    <span>
                                                                        {{ Number(addCommision(record.price)).toFixed(2) }}
                                                                    </span>
                                                                    <span>
                                                                        € Euro  
                                                                    </span>
                                                                </span>
                                                                <span>
                                                                    Nan
                                                                </span>
                                                            </span>
                                                            <span v-else class="fw-medium"> --- </span>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div v-if="UserOrdersIsLoaded && UserOrders == null" class="alert alert-primary small py-2">
                                        User has no active order
                                    </div>
                                    <div v-if="!UserOrdersIsLoaded" class="lh-sm ms-2 text-primary fw-medium fs-5">
                                        <span class="">
                                            Loading
                                        </span>
                                        <span class="m-0 p-0 ps-2">
                                            <?php include('./includes/baselayout/threespinner.php'); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row" v-else>
                                <p class="h5 p-4 alert alert-danger">
                                    Error 670: call your admin
                                </p>
                            </div>
                        </div>
                    </div><!-- User Details -->
                </div>
            </div>
        </div>
    </div>

<?php include_once('./includes/baselayout/footer.php'); ?>