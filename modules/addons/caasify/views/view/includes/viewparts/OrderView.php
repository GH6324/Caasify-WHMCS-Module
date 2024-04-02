<!-- OrderViewfromOrder -->
<div class="row">
    <div class="col-12 m-0 p-0">
        <div v-if="OrderHasFinded != true" class="d-flex flex-row justify-content-start align-items-center mt-5 text-primary">            
            <p class="h5 me-4 ">{{ lang('Order is Loading') }}</p>
            <span>
                <?php include('./includes/baselayout/threespinner.php'); ?>
            </span>
        </div>
        <div v-if="OrderHasFinded == true">
            <div class="mt-5">
                <h1 class="ps-2 pb-3 text-secondary">
                    User and Order
                </h1>
            </div>
            <?php include('./includes/viewparts/OrderDetails.php');         ?>
            
            <div class="mt-5 pt-5">
                <h1 class="mt-5 pt-5 ps-2 pb-3 text-secondary">
                    Machine Details
                </h1>
            </div>

            <?php include('./includes/viewparts/ViewFromAPI.php');         ?>

            <div class="mt-5 pt-5">
                <h1 class="mt-5 pt-5 ps-2 pb-3 text-secondary">
                    Controllers
                </h1>
            </div>
            <?php include('./includes/viewparts/ControllerButtons.php');   ?>
        </div>
    </div>
</div>