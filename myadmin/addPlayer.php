<?php
require_once './manageAcadamies.php';
require_once './header.php';
$academies = new acadamies();
$parentAcademies = $academies->getAcadamies(NULL, true);
$states = $academies->fetchStates();
$cities = $academies->fetchCities();
?>
<div class="header">
    <h1 class="page-title">Add Player</h1>
    <ul class="breadcrumb">
        <li><a href="dashboard.php">Dashboard</a> </li>
        <li><a href="players.php">Players</a> </li>
        <li class="active">Add Player</li>
    </ul>

</div>
<div class="main-content">

    <ul class="nav nav-tabs">
        <li class="active"><a href="#home" data-toggle="tab">Player Details</a></li>

    </ul>

    <div class="row">
        <div class="col-lg-8 col-md-6">
            <br>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane active in" id="home">
                    <form id="tab" name="addplayer" method="post" class="form-horizontal" action="<?php echo $admin_url . '/player.php'; ?>" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">AITA Number</label>
                            <div class="col-lg-6">
                                <input type="text" name="aita" maxlength="10" value="" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">First Name</label>
                            <div class="col-lg-6">
                                <input type="text" name="firstName" value="" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Last Name</label>
                            <div class="col-lg-6">
                                <input type="text" name="lastName" value="" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Date Of Birth</label>
                            <div class="col-lg-6">
                                <div class="input-group date datetimePicker">
                                    <input type="text" class="form-control datetimePicker" readonly="readonly" value="<?php echo date('Y/m/d'); ?>" name="birthday"  data-date-format="YYYY/MM/DD"/>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Gender</label>
                            <div class="col-lg-5">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="gender" value="M" /> Male
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="gender" value="F" /> Female
                                    </label>
                                </div>
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
                            <label class="col-lg-3 control-label">Mobile</label>
                            <div class="col-lg-6">
                                <input type="text" name="mobile" maxlength="10" value="" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Email</label>
                            <div class="col-lg-6">
                                <input type="text" name="email" value="" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Academy</label>
                            <div class="col-lg-6">
                                <select name="academyId" class="form-control">
                                    <option value="0">Select Any Academy</option>
                                    <?php
                                    if (isset($parentAcademies)) {
                                        while ($academy = mysql_fetch_object($parentAcademies)) {
                                            echo '<option value="' . $academy->ACADEMY_ID . '">' . $academy->NAME . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Facebook</label>
                            <div class="col-lg-6">
                                <input type="text" name="facebook_page" value="" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Twitter</label>
                            <div class="col-lg-6">
                                <input type="text" name="twitter_account" value="" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Photo</label>
                            <div class="col-lg-6">
                                <input type="file" name="player_photo"/>
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

<script type="text/javascript" src="../scripts/players.js"></script>
<?php
require_once 'footer.php';
?>