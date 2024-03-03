
<!-- Operation System -->
<div v-if="planIsSelected && !EmptyPlanConfigs" class="row">
    <div v-for="(PlanConfig, index) in PlanConfigs" class="row m-0 p-0 px-2 px-md-4" style="--bs-bg-opacity: 0.1;">
        <div class="col-12 m-0 p-0 py-5 px-md-4">    
            <div class="d-flex flex-row justify-content-start alighn-items-center">    
                <div class="m-0 p-0 pe-4" style="min-width: 140px;">
                    <p class="text-dark h3">
                        {{ PlanConfig.name }}
                    </p>
                </div>
                <div v-if="PlanConfig.type == 'dropdown'" style="min-width:250px">
                    <select :name="PlanConfig.name" class="form-select" :aria-label="PlanConfig.name" v-model="PlanConfigValue[PlanConfig.name]" >
                        <option value="default" selected disabled>Please select</option>
                        <option v-for="option in PlanConfig.options" :value="option.value">
                            {{ option.name }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Operation System -->