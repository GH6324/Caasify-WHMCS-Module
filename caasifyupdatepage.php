<?php   include_once('caasifyupdatefunc.php');    ?>
<?php   include('caasifyupdater/header.php');     ?>


<div id="app" class="bg-dark text-light p-5 rounded-5 mt-4">
    <?php   include('caasifyupdater/actionsmodal.php');     ?>
    <div class="row" v-cloak>
        <div class="col-12 col-md-6">
            <div class="d-felx flex-row justify-content-center align-items-center">
                <span class="h3">
                    Caasify Module Updater
                </span>
            </div>
            <div class="d-felx flex-row justify-content-center align-items-center mt-4">
                <p class="mt-3">
                    Caasify Latest Version:
                    <?php if($RemoteVersion == 0): ?>
                        <span class="text-info small">
                            NAN
                        </span>
                    <?php else: ?>
                        <span class="btn btn-info btn-sm ms-2 px-4 rounded-pill py-0">
                            <?php echo($RemoteVersion); ?>
                        </span>
                    <?php endif ?>
                </p>
                <p>
                    Your Current Version: 
                    <?php if($LocalVersion == 0): ?>
                        <span class="text-info small">
                            NAN
                        </span>
                    <?php else: ?>
                        <span class="btn btn-info btn-sm ms-2 px-4 rounded-pill py-0">
                            <?php echo($LocalVersion); ?>
                        </span>
                    <?php endif ?>                    
                </p>
            </div>
            <div class="d-felx flex-row justify-content-center align-items-center mt-5 pt-5">
                <p>
                    <?php if($LocalVersion == 0 && $RemoteVersion != 0): ?>
                        <span class="text-warning fw-light">
                            Can not find your version, please Reinstall
                        <span>
                    <?php elseif($LocalVersion != 0 && $RemoteVersion == 0): ?>
                        <span class="text-warning fw-light">
                            Can not find the latest Versions, please refresh the page again
                        </span>
                    <?php elseif($LocalVersion != 0 && $RemoteVersion != 0): ?>
                        <span class="text-info fw-light">
                            Your Module Version is 
                        </span>
                        <span>
                            <?php echo($LocalVersion); ?>
                        </span>
                        <?php if($LocalVersion == $RemoteVersion): ?>
                            <span>
                                and you Module is Update 
                            </span>
                        <?php else: ?>
                            <span>
                                and you should update it 
                            </span>
                        <?php endif ?>
                    <?php endif ?>
                </p>
            </div>

            <hr>
            <div class="d-flex flex-row justify-content-start align-items-center pb-3">
                <a class="btn btn-info px-3 mx-2" style="width: 415px;" data-bs-toggle="modal" data-bs-target="#actionsmodal" @click="funcUpdate">Auto Update Module</a>
            </div>
            <div class="d-flex flex-row justify-content-start align-items-center">
                <a class="btn btn-outline-info px-3 mx-2" style="width: 200px;" data-bs-toggle="modal" data-bs-target="#actionsmodal" @click="funcDownload">Download Module</a>
                <a class="btn btn-outline-info px-3 mx-2" style="width: 200px;" data-bs-toggle="modal" data-bs-target="#actionsmodal" @click="funcFix">Fix Permision</a>
            </div>
        </div>
        
        <div class="col-12 col-md-6" v-if="ActonResponse">
            <div v-html="ActonResponse" class="bg-body-secondary p-4 rounded-5 border-2 shadow-lg text-secondary small">
            </div>
        </div>
        <div style="height:300px"></div>
    </div>
</div>


<?php   include('caasifyupdater/footer.php');    ?>