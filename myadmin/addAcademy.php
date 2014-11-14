<?php
require_once 'manageAcadamies.php';
require_once 'header.php';
$academies = new acadamies();
//$parentCategories = $academies->getAcadamies(NULL, true);
$states = $academies->fetchStates();
$cities = $academies->fetchCities();
?>
<div class="header">
    <h1 class="page-title">Add Academy</h1>
    <ul class="breadcrumb">
        <li><a href="dashboard.php">Dashboard</a> </li>
        <li><a href="acadamies.php">Academies</a> </li>
        <li class="active">Add Academy</li>
    </ul>

</div>
<div class="main-content">

    <ul class="nav nav-tabs">
        <li class="active"><a href="#home" data-toggle="tab">Academy Details</a></li>

    </ul>

    <div class="row">
        <div class="col-lg-8 col-md-6">
            <br>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane active in" id="home">
                    <form id="tab" name="addcategory" method="post" class="form-horizontal" action="<?php echo $admin_url . '/academy.php'; ?>" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Academy Name</label>
                            <div class="col-lg-6">
                                <input type="text" name="academy" value="" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">State</label>
                            <div class="col-lg-6">
                                <select name="state" id="selectState" class="form-control">
                                    <option value="0">Select Any State</option>
                                    <?php
                                    if (isset($states)) {
                                        while ($state = mysql_fetch_object($states)) {
                                            echo '<option value="' . $state->state . '">' . $state->name . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">City</label>
                            <div class="col-lg-6">
                                <select name="city" id="selectCity" class="form-control">
                                    <option value="0">Select Any City</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Colony</label>
                            <div class="col-lg-6">
                                <input type="text" name="colony" value="" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Address</label>
                            <div class="col-lg-6">
                                <input type="text" name="address" value="" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Landmark</label>
                            <div class="col-lg-6">
                                <input type="text" name="landmark" value="" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Contact Name</label>
                            <div class="col-lg-6">
                                <input type="text" name="contact_name" value="" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Mobile</label>
                            <div class="col-lg-6">
                                <input type="text" name="mobile" maxlength="10" value="" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Clay Courts</label>
                            <div class="col-lg-6">
                                <select name="clay_courts" id="clay_courts" class="form-control">
                                    <option value="0">Select Any Court</option>
                                    <?php
                                    for ($i = 1; $i <= CLAY_COURT_LIMIT; $i++) {
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Hard Courts</label>
                            <div class="col-lg-6">
                                <select name="hard_courts" id="hard_courts" class="form-control">
                                    <option value="0">Select Any Court</option>
                                    <?php
                                    for ($i = 1; $i <= HARD_COURT_LIMIT; $i++) {
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Academy URL</label>
                            <div class="col-lg-6">
                                <input type="text" name="academy_url" value="" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Facebook Page</label>
                            <div class="col-lg-6">
                                <input type="text" name="facebook_page" value="" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Follow on Twitter</label>
                            <div class="col-lg-6">
                                <input type="text" name="twitter_account" value="" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Academy Photo</label>
                            <div class="col-lg-6">
                                <input type="file" name="academy_photo"/>
                            </div>
                        </div>
                        <div class="form-group court_count hide">
                            <label class="col-lg-3 control-label">Upload Photo</label>
                            <div class="col-lg-6">
                                <div id="court_count">

                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-9 col-lg-offset-3">
                                <button type="submit" name="addSubmit" id="addSubmit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                                <a href="#myModal" data-toggle="modal" class="btn btn-danger">Delete</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>

    <div class="modal small fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Delete Confirmation</h3>
                </div>
                <div class="modal-body">

                    <p class="error-text"><i class="fa fa-warning modal-icon"></i>Are you sure you want to delete the user?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancel</button>
                    <button class="btn btn-danger" data-dismiss="modal">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="../scripts/academies.js"></script>
<?php
require_once 'footer.php';
?>