<!-- for Three action (start, stop, reboot) -->
<div class="modal fade" id="actionsModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">  
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="actionModalLabel">Confirmation</h1>
            </div>

            <div class="modal-body py-5">
                <p class="mb-5 py-5 fs-5 fw-light">
                    You are going to {{ actionWouldBeHappened }} your machine, are you sure ?
                </p>
            </div>
            
            <div class="m-0 p-0">
                <div class="d-flex flex-row modal-footer justify-content-end">
                    <div class="m-0 p-0 mx-2">
                        <button @click="closeConfirmDialog" type="button" class="btn btn-secondary px-4 mx-2 border-0" data-bs-dismiss="modal">
                            {{ lang('close') }}
                        </button>
                    </div>
                    <div v-if="actionWouldBeHappened" class="m-0 p-0">
                        <button @click="acceptConfirmDialog" type="button" class="btn btn-primary px-4 mx-2 border-0" data-bs-dismiss="modal">
                            {{ actionWouldBeHappened.toUpperCase() }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- end modal -->






