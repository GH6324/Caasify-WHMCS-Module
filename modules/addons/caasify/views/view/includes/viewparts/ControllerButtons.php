<div class="py-5 px-4 px-lg-5">
    <h1>
        Controllers
    </h1>
    <div v-if="ControllersBtnAreLoading" class="d-flex flex-row mt-5 text-primary">
        <p class="h5 me-4 ">{{ lang('Controllers Are Loading') }}</p>
        <span>
            <?php include('./includes/baselayout/threespinner.php'); ?>
        </span>
    </div>
    <div class="">
        <div v-if="ControllersBtnAreLoaded">
            <div v-if="NoValidControllerItems != true" class="bg-body-secondary rounded-4 py-5 px-4 mt-5 border h5 lh-lg">
                <div v-for="(item, index) in ValidControllerItems">
                    <a v-if="index == 'button'" :href="item.id" class="btn btn-primary me-3 px-3 px-lg-5">
                        {{ item.name }}
                    </a>
                </div>
            </div>
            <div v-if="NoValidControllerItems === true" class="alert alert-primary my-5">
                No valid Controller Founded
            </div>
        </div>
    </div>
</div>