<div class="m-0 p-0">
    <div v-if="ControllersAreLoading" class="d-flex flex-row mt-5 text-primary">
        <p class="h5 me-4 ">{{ lang('Controllers Are Loading') }}</p>
        <span>
            <?php include('./includes/baselayout/threespinner.php'); ?>
        </span>
    </div>
    <div class="row m-0 p-0">
        <div v-if="!ControllersAreLoading" class="m-0 p-0">
            <div v-if="NoValidControllerItems != true"
                class="d-flex flex-row flex-wrap gap-1 justify-content-start ms-1">
                <a data-bs-toggle="modal" data-bs-target="#actionsModal" v-for="(button, index) in ValidControllerItems"
                    class="btn btn-light px-4 py-4 fw-medium border-2 border-secondary"
                    style="width: 140px; --bs-border-opacity: 0.3;"
                    @click="PushButtonController(button.id, button.name)" :key="index">
                    {{ button.name }}
                </a>
            </div>
            <div v-if="NoValidControllerItems === true" class="alert alert-primary my-5">
                No valid Controller Founded
            </div>
        </div>
    </div>
</div>


