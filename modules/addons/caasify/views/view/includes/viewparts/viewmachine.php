<div class="py-5 px-4 px-lg-5">

    <h1>
        Order Details
    </h1>

    <div v-if="viewsAreLoading" class="d-flex flex-row mt-5 text-primary">
        <p class="h5 me-4 ">{{ lang('Views Are Loading') }}</p>
        <span>
            <?php include('./includes/baselayout/threespinner.php'); ?>
        </span>
    </div>
    
    <div v-if="viewsAreLoaded" class="">
        <div v-if="NoValidViewItems != true" class="">
            <div class="bg-body-secondary rounded-4 py-5 px-4 mt-5 border h5 lh-lg">
                <div v-for="(item, index) in ValidViewItems" class="">
                    <div class="" v-html="item.content"></div>
                </div>
                <hr>
            </div>
        </div>
        <div v-if="NoValidViewItems === true" class="alert alert-primary my-5">
            No valid View Founded
        </div>
    </div>
    
</div>