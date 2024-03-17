<div class="py-5 px-4 px-lg-5">

    <h1>
        <span class="me-3">
            Order Details
        </span>
        <button @click="LoadRequestNewView" class="btn btn-primary px-3">New view</button>
    </h1>

    <div v-if="thisProduct" class="h4 pt-5">
        Product Name: {{ thisProduct?.title }}
    </div>
    
    <div v-if="thisOrder" class="h4 pt-5">
        Price: {{ thisOrder.records[0].price }}
    </div>
    
    <div v-if="thisOrder" class="h4 pt-5">
            {{ thisOrder?.note }} 
        <span class="text-primary">
            ({{ thisOrder?.status }})
        </span>
    </div>
    <div v-if="viewsAreLoading" class="d-flex flex-row mt-5 text-primary">
        <p class="h5 me-4 ">{{ lang('Views Are Loading') }}</p>
        <span>
            <?php include('./includes/baselayout/threespinner.php'); ?>
        </span>
    </div>
    
    <div v-if="viewsAreLoaded" class="row">
        <div v-if="NoValidViewItems != true" class="col-12 m-0 p-0">
            <div v-for="(item, index) in ValidViewItems" class="">
                <div class="" v-html="item.content"></div>
            </div>
        </div>
        <div v-if="NoValidViewItems === true" class="alert alert-primary my-5">
            No valid View Founded
        </div>
    </div>
    
</div>