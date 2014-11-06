<?php
require_once 'manageExams.php';
require_once 'header.php';
$exams = new exams();
$perPage = $exams->perPage;
$page = 1;
if (isset($_GET['page'])) {
    $page = trim($_GET['page']);
}
$exams->first = ($page - 1) * $perPage;

$examValues = $exams->getExams();
$total = $exams->getToalRecords();

if ($total > (($page * $perPage) + 1)) {
    $next = $page + 1;
    $previous = $page - 1;
} else {
    $next = $page;
    if ($page > 1) {
        $previous = $page - 1;
    } else {
        $previous = $page;
    }
}
?>
<div class="header">

    <h1 class="page-title">Exams</h1>
    <ul class="breadcrumb">
        <li><a href="dashboard.php">Dashboard</a> </li>
        <li class="active">Exams</li>
    </ul>

</div>
<div class="main-content">

    <div class="btn-toolbar list-toolbar">
        <button class="btn btn-primary" onclick="location.href = 'addExam.php';"><i class="fa fa-plus"></i> New Exam</button>
        <div class="btn-group">
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Exam Name</th>
                <th>Exam Time</th>
                <th>Exam Attempts</th>
                <th>Created By</th>
                <th>Created Date</th>
                <th>Updated Date</th>
                <th style="width: 3.5em;"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $starting = 0;
            //if (isset($categories) && count($categories) > 1) {
            while ($exam = mysql_fetch_object($examValues)) {
                echo '<tr>';
                echo '<td>' . $exam->exam_title . '</td><td>' . $exam->exam_time . '</td><td>' . $exam->exam_attempts_count . '</td><td>' . $exam->createdby . '</td>
                <td>' . date('Y-m-d', strtotime($exam->createddatetime)) . '</td>
                <td>' . date('Y-m-d', strtotime($exam->updatedatetime)) . '</td>
                <td>
                    <a href="editexam.php?id=' . $exam->exam_id . '"><i class="fa fa-pencil"></i></a>
                    <a href="#myModal" role="button" data-toggle="modal" catval="' . $exam->exam_id . '"  class="deleteCat"><i class="fa fa-trash-o"></i></a>
                </td>
            </tr>';
                $starting++;
            }
            /* } else {
              echo '<tr><td colspan="5"> No Categories found</td></tr>';
              } */
            ?>
        </tbody>
    </table>

    <ul class="pagination">
        <li><a href="categories.php?page=<?php echo $previous; ?>">&laquo;</a></li>
        <?php
        for ($t = 1; $t <= ceil($total / $perPage); $t++) {
            echo '<li><a href="categories.php?page=' . $t . '">' . $t . '</a></li>';
        }
        ?>
        <li><a href="categories.php?page=<?php echo $next; ?>">&raquo;</a></li>
    </ul>

    <div class="modal small fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Delete Confirmation</h3>
                </div>
                <div class="modal-body">
                    <p class="error-text"><i class="fa fa-warning modal-icon"></i>Are you sure you want to delete the Category?<br>This cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <form action="<?php echo $admin_url . '/exam.php'; ?>" method="POST" enctype="multipart/form-data" name="deleteForm" id="deleteForm">
                        <input type="hidden" name="examDelete" value="" id="deleteExam"/>
                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancel</button>
                        <button class="btn btn-danger" data-dismiss="modal" name="delete" id="deleteSubmit" type="submit">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.fa-trash-o').click(function() {
            $('#deleteExam').val($(this).parent().attr('catval'));
        });
        $('#deleteSubmit').click(function() {
            $('#deleteForm').submit();
        });
    });
</script>
<?php
require_once 'footer.php';
?>