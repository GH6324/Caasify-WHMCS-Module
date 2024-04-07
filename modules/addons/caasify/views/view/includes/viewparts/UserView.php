<div class="row d-flex flex-row align-items-stretch text-start m-0 p-0">
    <!-- OrderDetails -->
    <div class="col-12 col-xl-6 p-0 m-0 mb-2 flex-grow-1 pe-xl-1">
        <div class="border border-2 rounded-4 bg-white m-0 p-0 py-4 px-4 mx-0 me-xl-1 pb-5 h-100">
            <div class="m-0 p-0">

                <p class="text-secondary fs-5">
                    <i class="bi bi-person-circle pe-1"></i>
                    Login
                </p>
                <div class="input-group mt-5 mb-2">
                    <span class="input-group-text" id="basic-addon1">Username</span>
                    <input type="text" class="form-control" value="root / administrator" disabled>
                </div>
                <div class="input-group mb-4">
                    <span class="input-group-text" id="basic-addon1">Password</span>
                    <input v-if="!PassVisible" type="text" class="form-control" value="*********" disabled>
                    <input v-if="PassVisible" type="text" class="form-control" :value="thisOrder?.secret" disabled>
                    <a class="input-group-text" id="basic-addon1" @click="ShowHidePassword">
                        <i v-if="PassVisible" class="bi bi-eye-fill"></i>
                        <i v-if="!PassVisible" class="bi bi-eye-slash-fill"></i>
                    </a>
                </div>

                <div class="m-0 p-0 pb-4 my-3">
                    <hr class="text-secondary border-2 border-secondary m-0 p-0">
                </div>

                <!-- bottom slice -->
                <div class="m-0 p-0 px-1">
                    <div class="m-0 p-0 mt-0">

                        <p class="text-secondary mb-4 fs-5">
                            <i class="bi bi-currency-exchange pe-1"></i>
                            Finance
                        </p>
                        <!-- Price -->
                        <div class="row m-0 p-0">
                            <div class="col-auto m-0 p-0" style="min-width: 120px;">
                                <span class="text-secondary align-middle m-0 p-0">
                                    Product Price :
                                </span>
                            </div>
                            <div class="col-auto m-0 p-0">
                                <span class="text-primary align-middle m-0 p-0 fw-medium"
                                    v-if="thisOrder?.records[thisOrder.records.length - 1].price">
                                    <span>
                                        {{ showBalanceWhmcsUnit(ConvertFromCaasifyToWhmcs(thisOrder.records[thisOrder.records.length - 1].price)) }}
                                    </span>
                                    <span v-if="userCurrencySymbolFromWhmcs" class="ms-1">
                                        {{ userCurrencySymbolFromWhmcs }}
                                    </span>
                                </span>
                                <span v-if="userCurrencySymbolFromWhmcs"
                                    class="text-secondary align-middle m-0 p-0 fw-light ps-3">
                                    Pay as you go
                                </span>
                                <span class="text-secondary align-middle m-0 p-0 fw-medium" v-else>
                                    <span>
                                        ...
                                    </span>
                                </span>
                            </div>
                        </div>

                        <!-- Balance -->
                        <div class="row m-0 p-0">
                            <div class="col-auto m-0 p-0" style="min-width: 120px;">
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
                            <div class="col-auto m-0 p-0" style="min-width: 120px;">
                                <span class="text-secondary align-middle m-0 p-0">
                                    User Credit :
                                </span>
                            </div>
                            <div class="col-auto m-0 p-0">
                                <span class="text-secondary align-middle m-0 p-0 fw-medium"
                                    v-if="WhmcsUserInfo?.credit">
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
                </div><!-- end bottom -->

            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="d-flex flex-column col-12 col-xl-6 p-0 m-0 mb-2 flex-grow-1">
        <div class="mx-0 h-100 mb-2">
            <?php include('./includes/viewparts/buttons.php');   ?>
        </div>
        <div class="border border-2 rounded-4 bg-white m-0 p-0 py-4 px-4 mx-0 ms-xl-1 pb-5 h-100"
            style="min-height: 320px;">
            <div class="m-0 p-0">
                <div class="d-flex flex-row justify-content-start align-items-center m-0 p-0 flex-wrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" class="text-secondary fw-light">Action</th>
                                <th scope="col" class="text-secondary fw-light">Status</th>
                                <th scope="col" class="text-secondary fw-light">Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="ActionHistory"
                                v-for="(action, index) in ActionHistory.slice(0, 5)" :key="index">
                                <td>{{ action.button.name.toUpperCase() }}</td>
                                <td>
                                    <span style="--bs-bg-opacity: 0.2; width:120px;"
                                        :class="{ 
                                            'btn btn-sm bg-danger py-1 text-danger small': action.status == 'failed',
                                            'btn btn-sm bg-primary py-1 text-primary small': action.status == 'pending',
                                            'btn btn-sm bg-success py-1 text-success small': action.status == 'delivered'
                                        }">
                                        {{ action.status.toUpperCase() }}
                                        <span v-if="action.status == 'pending'" class="spinner-grow my-auto mb-0 ms-1 align-middle" style="--bs-spinner-width: 5px; --bs-spinner-height: 5px; --bs-spinner-animation-speed: 1s;"></span>
                                    </span>
                                </td>
                                <td> {{ convertTime(action.created_at) }} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>