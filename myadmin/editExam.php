<?php
require_once 'manageExams.php';
require_once 'header.php';
$exams = new exams();
$exam = $exams->getExams(trim($_GET['id']));
$statuses = $exams->fetchStatuses();
while ($examValue = mysql_fetch_object($exam)) {
    $presentExam = $examValue;
}
?>
<div class="header">
    <h1 class="page-title">Edit Exam</h1>
    <ul class="breadcrumb">
        <li><a href="dashboard.php">Dashboard</a> </li>
        <li><a href="categories.php">Exams</a> </li>
        <li class="active">Edit Exam</li>
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
                    <form id="tab" name="editexam" method="post" action="<?php echo $admin_url . '/exam.php'; ?>">
                        <div class="form-group">
                            <label>Exam Name</label>
                            <input type="text" name="examname" value="<?php echo trim($presentExam->exam_title); ?>" class="form-control">
                            <input type="hidden" name="examid" value="<?php echo trim($presentExam->exam_id); ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Exam Time</label>
                            <input type="text" name="minutes" placeholder="Min" value="<?php echo floor(trim($presentExam->exam_time) / 60); ?>" class="form-control" style="width: 50px; display: inline-block;" value=""/>&nbsp;:&nbsp;
                            <input type="text" name="seconds" placeholder="Sec" value="<?php echo trim($presentExam->exam_time) % 60; ?>" class="form-control" style="width: 50px; display: inline-block;" value=""/>
                        </div>
                        <div class="form-group">
                            <label>Exam Attempts</label>
                            <input type="text" name="examAttemts" class="form-control" value="<?php echo trim($presentExam->exam_attempts_count); ?>"/>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="statuses" id="DropDownTimezone" class="form-control">
                                <?php
                                while ($status = mysql_fetch_object($statuses)) {
                                    $select = '';
                                    if ($presentExam->exam_status_id == $status->status_id) {
                                        $select = ' selected="selected"';
                                    }
                                    echo '<option value="' . $status->status_id . '"' . $select . '>' . $status->status_title . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="btn-toolbar list-toolbar">
                            <button type="submit" name="editexamSubmit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
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
<?php
require_once 'footer.php';
?>