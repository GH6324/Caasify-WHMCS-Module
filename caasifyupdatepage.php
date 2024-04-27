<?php   include_once('caasifyupdatefunc.php');    ?>
<?php   include('caasifyupdater/header.php');     ?>


<div id="app" class="bg-dark text-light p-5 rounded-5 mt-4">
    <?php   include('caasifyupdater/actionsmodal.php');     ?>
    <div class="row" v-cloak>
        <div class="col-12 col-md-6">
            <div class="d-flex flex-row justify-content-start align-items-center">
                <span class="h3">
                    Caasify Module Updater
                </span>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex flex-row justify-content-start align-items-center mt-3">
                        <div style="width: 170px;">
                            Caasify Latest Version:
                        </div>
                        <?php if($RemoteVersion == 0): ?>
                        <div class="text-info small">
                            NAN
                        </div>
                        <?php else: ?>
                        <div class="btn btn-info btn-sm ms-2 px-3 py-0 rounded-3" style="width: 90px;">
                            <?php echo($RemoteVersion); ?>
                        </div>
                        <?php endif ?>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-row justify-content-start align-items-center mt-3">
                        <div style="width: 170px;">
                            Your Current Version: 
                        </div>
                        <?php if($LocalVersion == 0): ?>
                            <div class="text-info small">
                                NAN
                            </div>
                        <?php else: ?>
                            <div class="btn btn-info btn-sm ms-2 px-3 py-0 rounded-3" style="width: 90px;">
                                <?php echo($LocalVersion); ?>
                            </div>
                        <?php endif ?>                    
                    </div>
                </div>
            </div>
            <div class="row mt-5 pt-5">
                <p class="text-info fw-light">
                    <?php if($LocalVersion == 0 && $RemoteVersion != 0): ?>
                        <span>
                            Can not find your version, please Reinstall
                        <span>
                    <?php elseif($LocalVersion != 0 && $RemoteVersion == 0): ?>
                        <span>
                            Can not find the latest Versions, please refresh the page again
                        </span>
                    <?php elseif($LocalVersion != 0 && $RemoteVersion != 0): ?>
                        <?php if($LocalVersion == $RemoteVersion): ?>
                            <span>
                                Your module is updated to lates version
                            </span>
                        <?php else: ?>
                            <span>
                                You should update the module
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