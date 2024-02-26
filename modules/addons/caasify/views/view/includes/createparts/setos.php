<!-- Operation System -->
<div v-if="planIsSelected" class="row m-0 p-0 border rounded-4 bg-body-secondary py-5 px-4 mt-5">
    <div class="col-12" style="--bs-bg-opacity: 0.1;">
        <div class="m-0 p-0">
            <p class="text-dark h3">
            {{ lang('operationsystem') }}
            </p>
            <p class="fs-6 pt-1 text-secondary">{{ lang('selectatemplate') }}</p>
        </div>
        <hr class="pb-4">
        <!-- tems -->
        <form>
            <!-- body -->    
            <div class="row justify-content-start">
                <div class="col-12 col-md-6 col-xl-4 mb-3" v-for="category in categories">
                    <div class="row border rounded-3 px-3 py-3 mx-0 w-100 bg-light">
                        <div class="d-flex flex-row align-items-center m-0 p-0">
                            
                            <div class="py-1 pe-3" style="width: 50px;">
                                <img :src="category.icon.address" width="35">
                            </div>

                            <div class="py-1 pe-3" style="width: 80px;">
                                <span v-if="category.name == 'Windows Server'" class="h6 text-secondary">
                                    Windows
                                </span>

                                <span v-else class="h6 text-secondary">
                                    {{ category.name }}
                                </span>
                            </div>

                            <div class="py-1 pe-3 flex-grow-1" style="min-width:190px;">
                                <select v-model="templateId" class="form-select">
                                    <option v-for="template in category.templates" :value="template.id">
                                        {{ template.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-4 mb-3" v-if="categories != null">
                    <div class="d-flex flex-row justify-content-start align-items-center mt-4 text-primary ">
                        <span class="h5 text-primary"> loading </span>
                        <span>
                            <?php include('./includes/baselayout/threespinner.php'); ?>                        
                        </span>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- End Operation System -->