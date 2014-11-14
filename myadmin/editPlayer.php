<?php
require_once './manageAcadamies.php';
require_once './managePlayers.php';
require_once './header.php';
$academies = new acadamies();
$players = new players();
$parentAcademies = $academies->getAcadamies(NULL, true);
$states = $academies->fetchStates();

$playerFetch = $players->getPlayers(trim($_GET['aid']), trim($_GET['pid']), true);
while ($cat = mysql_fetch_object($playerFetch)) {
    $player = $cat;
}
$statuses = $academies->fetchStatuses();
?>
<div class="header">
    <h1 class="page-title">Edit Player</h1>
    <ul class="breadcrumb">
        <li><a href="dashboard.php">Dashboard</a> </li>
        <li><a href="players.php">Players</a> </li>
        <li class="active">Edit Player</li>
    </ul>

</div>
<div class="main-content">

    <ul class="nav nav-tabs">
        <li class="active"><a href="#home" data-toggle="tab">Player Details</a></li>

    </ul>

    <div class="row">
        <?php
        if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
            echo '<h4 class="alert alert-error"><a href="#" class="close" data-dismiss="alert">&times;</a>' . $_SESSION['error'] . '</h4>';
            unset($_SESSION['error']);
        }
        ?>
        <div class="col-lg-8 col-md-6">
            <br>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane active in" id="home">
                    <form id="tab" name="editcategory" method="post" class="form-horizontal" action="<?php echo $admin_url . '/player.php'; ?>" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">AITA Number</label>
                            <div class="col-lg-6">
                                <input type="text" name="aita" maxlength="10" value="<?php echo $player->AITA; ?>" class="form-control">
                                <input type="hidden" name="refno" value="<?php echo $player->refno; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">First Name</label>
                            <div class="col-lg-6">
                                <input type="text" name="firstName" value="<?php echo $player->FIRST_NAME; ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Last Name</label>
                            <div class="col-lg-6">
                                <input type="text" name="lastName" value="<?php echo $player->LAST_NAME; ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Date Of Birth</label>
                            <div class="col-lg-6">
                                <div class="input-group date datetimePicker">
                                    <input type="text" class="form-control datetimePicker" readonly="readonly" value="<?php echo date('Y/m/d', strtotime($player->DOB)); ?>" name="birthday"  data-date-format="YYYY/MM/DD"/>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Gender</label>
                            <div class="col-lg-5">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="gender" <?php
                                        if (strtoupper($player->GENDER) == 'M') {
                                            echo 'checked="checked"';
                                        }
                                        ?> value="M" /> Male
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="gender" <?php
                                        if (strtoupper($player->GENDER) == 'F') {
                                            echo 'checked="checked"';
                                        }
                                        ?> value="F" /> Female
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">State</label>
                            <div class="col-lg-6">
                                <select name="state" id="selectState" class="form-control">
                                    <?php
                                    if (isset($states)) {
                                        while ($state = mysql_fetch_object($states)) {
                                            $select = '';
                                            if ($player->STATE == $state->state) {
                                                $select = ' selected="selected"';
                                            }
                                            echo '<option value="' . $state->state . '"' . $select . '>' . $state->name . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Mobile</label>
                            <div class="col-lg-6">
                                <input type="text" name="mobile" maxlength="10" value="<?php echo $player->MOBILE; ?>" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Email</label>
                            <div class="col-lg-6">
                                <input type="text" name="email" value="<?php echo $player->EMAIL; ?>" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Academy</label>
                            <div class="col-lg-6">
                                <select name="academyId" class="form-control">
                                    <?php
                                    if (isset($parentAcademies)) {
                                        while ($academy = mysql_fetch_object($parentAcademies)) {
                                            $select = '';
                                            if ($player->ACADEMY_ID == $academy->ACADEMY_ID) {
                                                $select = ' selected="selected"';
                                            }
                                            echo '<option value="' . $academy->ACADEMY_ID . '"' . $select . '>' . $academy->NAME . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Facebook</label>
                            <div class="col-lg-6">
                                <input type="text" name="facebook_page" value="<?php echo $player->FACEBOOK; ?>" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Twitter</label>
                            <div class="col-lg-6">
                                <input type="text" name="twitter_account" value="<?php echo $player->TWITTER; ?>" class="form-control"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Status</label>
                            <div class="col-lg-6">
                                <select name="statuses" id="DropDownTimezone" class="form-control">
                                    <?php
                                    while ($status = mysql_fetch_object($statuses)) {
                                        $select = '';
                                        if ($player->status == $status->statusid) {
                                            $select = ' selected="selected"';
                                        }
                                        echo '<option value="' . $status->statusid . '"' . $select . '>' . $status->statusname . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Photo</label>
                            <div class="col-lg-6">

                                <?php
                                $class = '';
                                if (!$academies->isValidImageExt($player->PHOTO)) {
                                    //echo '<input type="hidden" name="insertedImage" value="' . $academy->PHOTO . '"/><a href="javascript: void(0);" class="change">Add New Image</a>';
                                } else if (!empty($player->PHOTO)) {
                                    $class = ' hide';
                                    echo '<input type="hidden" name="insertedImage" value="' . $player->PHOTO . '"/>';
                                    ?>
                                    <img src="../<?php echo $player->PHOTO; ?>" title="Player Photo" alt="" height="130" width="180"/>
                                    <?php
                                    echo '<a href="javascript: void(0);" class="change">Change</a>';
                                }
                                ?>
                                <div class="academy_photo <?php echo $class; ?>">
                                    <input type="file" name="player_photo"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-9 col-lg-offset-3">
                                <button type="submit" name="editSubmit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
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