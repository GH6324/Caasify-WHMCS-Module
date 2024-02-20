
<!-- orders List -->
<div class="row px-1 px-md-3 px-lg-4 pb-5 mt-5 pt-5">
    <div class="py-5">
    
        <!-- Fetching  -->
        <div v-if="!machinsLoaded">
            <span>
                <div class="spinner-border spinner-border-sm text-primary small" role="status"></div>
                <span class="h4 text-primary py-3 ps-3">{{ lang('listofactiveorders') }}</span>
            </span>    
            <p class="fs-5 pt-3 ps-3">
                {{ lang('waittofetch') }}
            </p>
        </div>

        <!-- Has no orders -->
        <div v-if="machinsLoaded && userHasNoorder">
            <p class="fs-5 ps-3 text-danger">
                {{ lang('noactiveorder') }} 
            </p>
        </div>
        
        <!-- show activ orders -->
        <div v-if="machinsLoaded && !userHasNoorder" >
            <table v-if="!isEmpty(activeorders)" class="table table-borderless pb-5 mb-5" style="--bs-table-bg: #ff000000;">
                <thead>
                    <tr class="border-bottom" style="--bs-border-width: 2px !important; --bs-border-color: #e1e1e1 !important;">
                        <th scope="col" class="fw-light fs-5 text-secondary pb-3">{{ lang('address') }}</th>
                        <th scope="col" class="fw-light fs-5 text-secondary pb-3">{{ lang('hostnameontable') }}</th>
                        <th scope="col" class="fw-light fs-5 text-secondary pb-3 d-none d-md-block">{{ lang('templateontable') }}</th>
                        <th scope="col" class="fw-light fs-5 text-secondary pb-3">{{ lang('viewontable') }}</th>
                        <th scope="col" class="fw-light fs-5 text-secondary pb-3 d-none d-md-block">{{ lang('statusontable') }}</th>
                    </tr>
                </thead>
                <tbody v-for="order in activeorders">
                
                    <tr class="border-bottom align-middle" style="--bs-border-width: 1px !important; --bs-border-color: #e1e1e1 !important;">
                    
                    
                        <!-- Address -->
                        <td class="py-4 fw-medium" v-if="address(order)">{{ address(order) }}</td>
                        <td class="py-4 fw-medium" v-else> --- </td>
                        <!-- end Address -->
                        

                        <!-- Hostname -->
                        <td class="py-4 fw-medium" v-if="order.name" >

                            <btn v-if="online(order)" class="d-flex flex-row align-items-center" style="max-width: 120px;">
                                <span class="spinner-grow text-success me-2 d-block d-md-none" style="--bs-spinner-width: 10px; --bs-spinner-height: 10px; --bs-spinner-animation-speed: 1s;"></span>
                                <span class="text-dark fs-6 fw-medium">{{ order.name }}</span>
                            </btn>

                            <btn v-if="offline(order)" class="d-flex flex-row align-items-center" style="max-width: 120px;">
                                <span class="spinner-grow text-danger me-2 d-block d-md-none" style="--bs-spinner-width: 10px; --bs-spinner-height: 10px; --bs-spinner-animation-speed: 1s;"></span>
                                <span class="text-dark fs-6 fw-medium">{{ order.name }}</span>
                            </btn>
                            
                            <btn v-if="!online(order) && !offline(order)" class="d-flex flex-row align-items-center" style="max-width: 120px;">
                                <span class="spinner-grow text-dark me-2 d-block d-md-none" style="--bs-spinner-width: 10px; --bs-spinner-height: 10px; --bs-spinner-animation-speed: 1s;"></span>
                                <span class="text-dark fs-6 fw-medium">{{ order.name }}</span>
                            </btn>
                            
                        </td>
                        <td class="py-4 fw-medium" v-else> --- </td>
                        <!-- end Hostname -->

                        
                        
                        <!-- Template -->
                        <td v-if="order.template" class="py-4 fw-medium d-none d-md-block">
                            <div class="d-flex flex-row align-items-center">
                                <img :src="order.template.icon.address" style="width: 25px;">
                                <span class="ms-2">{{ order.template.name }}</span>
                            </div>
                        </td>
                        <td class="py-4 fw-medium" v-else> --- </td>
                        
                        
                        
                        <!-- View -->
                        <td v-if="address(order)" class="py-4 fw-medium">
                            <a @click="open(order)" class="btn btn-primary btn-sm px-3 py-2 border-0 fw-medium" style="--bs-btn-bg: #0d6efd61; --bs-btn-color: #363636;">{{ lang('viewontable') }}</a>
                        </td>
                        <td class="py-4 fw-medium" v-else> --- </td>
                        


                        <!-- Status -->
                        <td class="py-4 fw-medium d-none d-md-block" v-if="online(order)">
                            <btn class="d-flex flex-row align-items-center" style="max-width: 85px;">
                                <span class="spinner-grow text-success me-2" style="--bs-spinner-width: 10px; --bs-spinner-height: 10px; --bs-spinner-animation-speed: 1s;"></span>
                                <span class="text-success fs-6 fw-medium d-none d-md-block">{{ lang('online') }}</span>
                            </btn>
                        </td>    
                        
                        <td class="py-4 fw-medium d-none d-md-block" v-if="offline(order)">
                            <btn class="d-flex flex-row align-items-center" style="max-width: 85px;">
                                <span class="spinner-grow text-danger me-2" style="--bs-spinner-width: 10px; --bs-spinner-height: 10px; --bs-spinner-animation-speed: 1s;"></span>
                                <span class="text-danger fs-6 fw-medium d-none d-md-block">{{ lang('offline') }}</span>
                            </btn>
                        </td>    

                        <td class="py-4 fw-medium d-none d-md-block ps-4" v-if="!online(order) && !offline(order)"> 
                            <div class="d-flex flex-row align-items-center m-0 p-0 py-3">
                            <?php include('./includes/commodules/threespinner.php'); ?>
                            </div>
                        </td>
                        <!-- end Status -->
                        
                        
                    </tr>
                </tbody>
            </table>
            <div class="" v-else>
                <p class="fs-6 ps-3 text-danger">
                    {{ lang('noactiveorder') }} 
                </p>
            </div>
        </div>

        
    </div>
</div>
<!-- End List -->