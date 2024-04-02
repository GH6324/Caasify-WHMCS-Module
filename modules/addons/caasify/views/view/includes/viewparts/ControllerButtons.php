<div class="m-0 p-0">
    <div v-if="ControllersAreLoading" class="d-flex flex-row mt-5 text-primary">
        <p class="h5 me-4 ">{{ lang('Controllers Are Loading') }}</p>
        <span>
            <?php include('./includes/baselayout/threespinner.php'); ?>
        </span>
    </div>
    <div class="row m-0 p-0">
        <div v-if="!ControllersAreLoading" class="m-0 p-0">
            <div v-if="NoValidControllerItems != true" class="d-flex flex-row flex-wrap gap-3 justify-content-start">
                <a 
                    data-bs-toggle="modal" data-bs-target="#actionsModal"
                    v-for="button in ValidControllerItems" class="btn btn-primary px-3 px-lg-5" 
                    style="width: 140px;" 
                    @click="PushButtonController(button.id, button.name)"
                >
                    {{ button.name }}
                </a>
            </div>
            <div v-if="NoValidControllerItems === true" class="alert alert-primary my-5">
                No valid Controller Founded
            </div>
        </div>
    </div>
</div>



<div class="col-12" v-if="ActionAlert">
    <div class="px-4">
        <p class="alert alert-danger">
            {{ ActionAlert }}
        </p>
    </div>
</div>


