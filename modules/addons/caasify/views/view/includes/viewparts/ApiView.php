<!-- OrderViewFromAPI -->
<div class="row m-0 p-0 px-2">
    <div v-if="viewsAreLoaded" class="m-0 p-0">
        <div v-if="NoValidViewItems != true" class="col-12 m-0 p-0">
            <div v-for="(item, index) in ValidViewItems"
                class="row d-flex flex-row align-items-center justify-content-center" v-html="item.content"
                :key="index">
            </div>
        </div>
        <div v-if="NoValidViewItems === true" class="alert alert-primary my-5">
            No valid View Founded
        </div>
    </div>
</div>