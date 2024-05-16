<?php $parentFileName = basename(__FILE__, '.php'); ?>
<?php  include('./config.php');   ?>
<?php  include('./includes/baselayout/header.php');   ?>

<body class="container-fluid p-1 p-md-3" style="background-color: #ff000000 !important;">
    <div id="app" class="row px-1 px-md-2 py-5 mx-auto" style="max-width: 1200px;">
        <div class="p-0 m-0" :class="{ loading: CreateIsLoading }" v-cloak >
            <?php  include('./includes/baselayout/backflash.php');     ?>
            <?php  include('./includes/createparts/modalcreate.php');     ?>
            <?php if(isset($DemoMode) && $DemoMode == 'on' ): ?>
                <?php  include('./includes/baselayout/modalDemo.php');     ?>
            <?php endif ?>
            <div class="col-12 bg-white rounded-4 border border-2 border-body-secondary m-0 p-0 mt-5"
                style="min-height: 1800px">
                <?php if(isset($DemoMode) && $DemoMode == 'on' ): ?>
                    <?php  include('./includes/baselayout/DemoHeader.php');   ?>
                <?php endif ?>
                <!-- lang BTN     -->
                <div class="row">
                    <div class="col-12">
                        <div class="py-5 px-4">
                            <div class="float-end d-none d-md-block">
                                <div class="col-auto btn bg-primary text-dark m-0 p-0" style="--bs-bg-opacity: 0.2">
                                    <?php include('./includes/baselayout/langbtn.php'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content -->
                <div class="row m-0 p-0">
                    <div class="col-12">
                        <div class="py-5 px-0 px-md-2">
                            <?php  include('./includes/createparts/datacenters.php');   ?>
                            <?php  include('./includes/createparts/regions.php');       ?>
                            <?php  include('./includes/createparts/plans.php');         ?>
                            <?php  include('./includes/createparts/configs.php');      ?>
                            <?php  include('./includes/createparts/hostname.php');      ?>
                        </div>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-12 py-5 px-4 px-md-2">
                        <?php  include('./includes/createparts/createbtn.php');    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('./includes/baselayout/footer.php'); ?>