



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<?php  include('./config.php'); ?>
<?php  include('./includes/baselayout/header.php');   ?>
<body class="container-fluid p-1 p-md-3" style="background-color: #ff000000 !important;" > 
<div id="app" class="row px-1 px-md-2 py-5 mx-auto" style="max-width: 1500px;">
    <div class="" v-cloak>
        <?php  include('./includes/baselayout/backflash.php');     ?>
        <div class="col-12 bg-white rounded-4 border border-2 border-body-secondary m-0 p-0 mt-5" style="min-height: 1000px">
            <div class="row m-0 p-0">
                <div class="col-12">
                    <div class="py-5 px-4 px-md-2">                      
                        <?php include('./includes/viewparts/modalActions.php');       ?>
                        <?php include('./includes/viewparts/viewmachine.php');       ?>
                        <?php include('./includes/viewparts/ControllerButtons.php'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

<?php include('./includes/baselayout/footer.php'); ?>

