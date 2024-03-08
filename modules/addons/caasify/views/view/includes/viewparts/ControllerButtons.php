<div class="py-5 px-4 px-lg-5">
    <div v-if="ControllersAreLoading" class="d-flex flex-row mt-5 text-primary">
        <p class="h5 me-4 ">{{ lang('Controllers Are Loading') }}</p>
        <span>
            <?php include('./includes/baselayout/threespinner.php'); ?>
        </span>
    </div>
    <div class="">
        <div v-if="!ControllersAreLoading">
            <div v-if="NoValidControllerItems != true" class="d-flex flex-row">
                <a v-for="button in ValidControllerItems" :href="button.id" class="btn btn-primary me-3 px-3 px-lg-5">
                    {{ button.name }}
                </a>
            </div>
            <div v-if="NoValidControllerItems === true" class="alert alert-primary my-5">
                No valid Controller Founded
            </div>
        </div>
    </div>
</div>