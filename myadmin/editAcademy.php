<?php
require_once 'manageAcadamies.php';
require_once 'header.php';
$academies = new acadamies();
$academiesFetch = $academies->getAcadamies(trim($_GET['id']));
while ($cat = mysql_fetch_object($academiesFetch)) {
    $academy = $cat;
}

$states = $academies->fetchStates();
$cities = $academies->fetchCities($academy->STATE);
?>
<div class="header">
    <h1 class="page-title">Edit Academy</h1>
    <ul class="breadcrumb">
        <li><a href="dashboard.php">Dashboard</a> </li>
        <li><a href="acadamies.php">Academies</a> </li>
        <li class="active">Edit Academy</li>
    </ul>

</div>
<div class="main-content">

    <ul class="nav nav-tabs">
        <li class="active"><a href="#home" data-toggle="tab">Academy Details</a></li>

    </ul>

    <div class="row">
        <div class="col-md-4">
            <br>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane active in" id="home">
                    <form id="tab" name="editcategory" method="post" action="<?php echo $admin_url . '/academy.php'; ?>" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Academy Name</label>
                            <input type="text" name="academy" value="<?php echo $academy->NAME; ?>" class="form-control"/>
                            <input type="hidden" name="academyId" value="<?php echo $academy->ACADEMY_ID; ?>"/>
                        </div>
                        <div class="form-group">
                            <label>State</label>
                            <select name="state" id="selectState" class="form-control">
                                <option value="0">Select Any State</option>
                                <?php
                                if (isset($states)) {
                                    while ($state = mysql_fetch_object($states)) {
                                        if ($state->state == $academy->STATE) {
                                            $selected = ' selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        echo '<option value="' . $state->state . '"' . $selected . '>' . $state->name . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <select name="city" id="selectCity" class="form-control">
                                <?php
                                if (isset($cities)) {
                                    while ($city = mysql_fetch_object($cities)) {
                                        if ($city->city == $academy->CITY) {
                                            $selected = ' selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        echo '<option value="' . $city->city . '">' . $city->city . '-' . $city->state . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Colony</label>
                            <input type="text" name="colony" value="<?php echo $academy->COLONY; ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="address" value="<?php echo $academy->ADDRESS; ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Landmark</label>
                            <input type="text" name="landmark" value="<?php echo $academy->LANDMARK; ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Contact Name</label>
                            <input type="text" name="contact_name" value="<?php echo $academy->CONTACT_NAME; ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Mobile</label>
                            <input type="text" name="mobile" maxlength="10" value="<?php echo $academy->MOBILE; ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Clay Courts</label>
                            <select name="clay_courts" id="clay_courts" class="form-control">
                                <option value="0">Select Any Court</option>
                                <?php
                                for ($i = 1; $i <= CLAY_COURT_LIMIT; $i++) {
                                    if ($academy->CLAY_COURTS == $i) {
                                        $selected = ' selected="selected"';
                                    } else {
                                        $selected = '';
                                    }
                                    echo '<option value="' . $i . '"' . $selected . '>' . $i . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Hard Courts</label>
                            <select name="hard_courts" id="hard_courts" class="form-control">
                                <option value="0">Select Any Court</option>
                                <?php
                                for ($i = 1; $i <= HARD_COURT_LIMIT; $i++) {
                                    if ($academy->HARD_COURTS == $i) {
                                        $selected = ' selected="selected"';
                                    } else {
                                        $selected = '';
                                    }
                                    echo '<option value="' . $i . '"' . $selected . '>' . $i . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Academy URL</label>
                            <input type="text" name="academy_url" value="<?php echo $academy->URL; ?>" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>Facebook Page</label>
                            <input type="text" name="facebook_page" value="<?php echo $academy->FACEBOOK; ?>" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>Follow on Twitter</label>
                            <input type="text" name="twitter_account" value="<?php echo $academy->TWITTER; ?>" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>Academy Photo</label>
                            <img src="../<?php echo $academy->PHOTO; ?>" title="Academy Photo" alt="Academy Photo" height="130" width="180"/>
                            <?php
                            if (!empty($academy->PHOTO)) {
                                echo '<a href="javascript: void(0);" class="change">Change</a>';
                            }
                            ?>
                            <div class="academy_photo hide">
                                <input type="file" name="academy_photo"/>
                            </div>
                        </div>
                        <div class="form-group court_count hide">
                            <label>Upload Photo</label>
                            <div id="court_count">

                            </div>
                        </div>
                        <div class="btn-toolbar list-toolbar">
                            <button type="submit" name="editSubmit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                            <a href="#myModal" data-toggle="modal" class="btn btn-danger">Delete</a>
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