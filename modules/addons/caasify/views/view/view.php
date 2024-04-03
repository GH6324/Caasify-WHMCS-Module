<?php  include('./config.php'); ?>
<?php  include('./includes/baselayout/header.php');   ?>

<body class="container-fluid p-1 p-md-3" style="background-color: #ff000000 !important;">
    <div id="app" class="row py-5 mx-auto px-0 px-md-2 px-lg-4" style="max-width: 1200px;">
        <div class="" v-cloak>
            <?php  include('./includes/baselayout/backflash.php');     ?>
            <div class="col-12 m-0 p-0 mt-5" style="min-height: 1000px">
                <div class="row m-0 p-0">
                    <div class="col-12 m-0 p-0">
                        <div class="py-5 px-1">
                            <?php include('./includes/viewparts/modalActions.php');  ?>
                            <?php include('./includes/viewparts/allViews.php');     ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('./includes/baselayout/footer.php'); ?>