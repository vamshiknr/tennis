<?php
require_once 'manageCategories.php';
require_once 'header.php';
$cats = new categories();
$categories = $cats->getCategories(NULL, true);
$cat_display = '<option value="0">--Select a Category--</option>';
while ($category = mysql_fetch_object($categories)) {
    $cat_display .= '<option value="' . $category->category_id . '">' . $category->category_name . '</option>';
}
$statuses = $cats->fetchStatuses();
$disp_Status = '<option value="0">--Select a Status--</option>';
while ($status = mysql_fetch_object($statuses)) {
    $disp_Status .= '<option value="' . $status->status_id . '">' . $status->status_title . '</option>';
}
?>
<div class="header">
    <h1 class="page-title">Add Exam</h1>
    <ul class="breadcrumb">
        <li><a href="dashboard.php">Dashboard</a> </li>
        <li><a href="exams.php">Exams</a> </li>
        <li class="active">Add Exam</li>
    </ul>

</div>
<div class="main-content">

    <ul class="nav nav-tabs">
        <li class="active"><a href="#home" data-toggle="tab">Exam Details</a></li>

    </ul>

    <div class="row">
        <div class="col-md-4">
            <br>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane active in" id="home">
                    <form id="tab" name="addexam" class="form-horizontal form-group" method="post" action="<?php echo $admin_url . '/exam.php'; ?>">
                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                            <label>Exam Name</label>
                            <input type="text" name="examname" value="" class="form-control">
                        </div>
                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 padding-top">
                            <label>Exam Time</label>
                            <input type="text" name="minutes" placeholder="Min" class="form-control" style="width: 50px; display: inline-block;" value=""/>&nbsp;:&nbsp;
                            <input type="text" name="seconds" placeholder="Sec" class="form-control" style="width: 50px; display: inline-block;" value=""/>
                        </div>
                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12  padding-top">
                            <label>Exam Attempts</label>
                            <input type="text" name="examAttemts" class="form-control" value=""/>
                        </div>
                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 categoriesContainer">
                            <h3>Exam Categories</h3>
                            <div class="container exam_categories padding-bottom">
                                <div class="col-lg-12 padding-bottom">
                                    <label class=" col-md-6 col-sm-2 col-lg-1 control-label" for="examcategories">Category</label>
                                    <div class="col-md-6 col-lg-4 col-sm-10">
                                        <select name="examCategory[]" class="examCategories form-control">
                                            <?php
                                            echo $cat_display;
                                            ?>
                                        </select>
                                    </div>
                                    <label class="col-md-6 col-sm-2 col-lg-2 control-label" for="questionCount">Question Count</label>
                                    <div class="col-md-6 col-lg-4 col-sm-10">
                                        <input type="text" value="" name="examQuestionCount[]" class="questionCount form-control"/>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <label class=" col-md-6 col-sm-2 col-lg-1 control-label" for="examstatus">Status</label>
                                    <div class="col-md-6 col-lg-4 col-sm-7">
                                        <select name="examStatus[]" class="examstatus form-control">
                                            <?php
                                            echo $disp_Status;
                                            ?>
                                        </select>
                                    </div>
                                    <div>
                                        <button name="addMore" type="button" class="btn btn-primary addmore"><i class="fa fa-plus"></i>Add More Categories</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn-toolbar list-toolbar">
                            <button type="submit" name="addSubmit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                            <a href="<?php echo $admin_url . '/exams.php'; ?>" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>
</div>
<script type="text/javascript" src="../scripts/exams.js"></script>
<?php
require_once 'footer.php';
?>