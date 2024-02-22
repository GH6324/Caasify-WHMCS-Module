new for caasify in hostnam.php
<h1 class="mt-5 pt-5">regions</h1>
<div v-for="region in regions" class="p-5">
    <div class="row">
        <div class="col-12 bg-primary text-primary p-5 rounded-4 h5" style="--bs-bg-opacity: 0.3;">
            <p>
                id: {{region?. id}}
            </p>
            <p>
                name: {{region?. name}}
            </p>
            <p>
                type: {{region?. type}}
            </p>
            <p>
                slug: {{region?. slug}}
            </p>
        </div>    
        
        <h5 class="mt-5">Categories</h5>
        <div class="col-12 bg-primary text-primary p-5 rounded-4 h5" style="--bs-bg-opacity: 0.3;">
            <div v-for="category in region.categories">
                <p class="pt-5">
                    ID: {{category.id}}
                </p>
                <hr>
                <p>
                    Name: {{category.name}}
                </p>
                <p>
                    type: {{category.type}}
                </p>
                <p>
                    slug: {{category.slug}}
                </p>
                <p>
                    image: {{category.image}}
                </p>
            </div>
        </div>
    </div>
</div>

<h1 class="mt-5 pt-5">plans</h1>
<div v-for="plan in plans" class="p-4 my-3">
    <div class="row">
        <div class="col-12 bg-primary text-primary p-5 rounded-4 h5" style="--bs-bg-opacity: 0.3;">
            <p class="pt-5">
                id = {{plan?.id}}
            </p>
            <hr>
            <p>
                title = {{plan?.title}}
            </p>
            <p>
                description = {{plan?.description}}
            </p>
            <p>
                price = {{plan?.price}}
            </p>
        </div>
    </div>
</div>


<!-- Host Name -->
<div class="row m-0 p-0 pt-0 pt-md-5 mt-0 mt-md-5"> 
    <div class="col-12 m-0 p-0" style="--bs-bg-opacity: 0.1;">
        <div class="m-0 p-0">

            <!-- name -->
            <div class="m-0 p-0 py-5">
                <div class="m-0 p-0">
                    <p class="text-dark h3">
                        {{ lang('nameofhost') }}
                    </p>
                    <p class="fs-6 pt-1 text-secondary">
                        {{ lang('enteraname') }}    
                    </p>
                </div>

                <div class="row m-0 p-0">
                    <input v-model="themachinename" @input="validateInput" type="text" class="form-control py-3 bg-body-secondary fs-6 ps-4 border-0" style="--bs-bg-opacity: 0.5;" placeholder="Machine-1">
                </div>
                <p v-if="MachineNameValidationError" class="mt-4 w-50 small text-danger">{{ lang('onlyenglishletters') }}</p>
            </div>
            
        </div>
    </div> 
</div> 
<!-- End Name -->


