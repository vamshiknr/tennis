<?php
require_once 'manageAcadamies.php';
require_once 'header.php';
$academies = new acadamies();
//$totalAcademies = $academies->getAcadamies();
$perPage = $academies->perPage;
$page = 1;
if (isset($_GET['page'])) {
    $page = trim($_GET['page']);
}
$academies->first = ($page - 1) * $perPage;

$categories = $academies->getAcadamies();
$total = $academies->getToalRecords();

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

    <h1 class="page-title">Academies</h1>
    <ul class="breadcrumb">
        <li><a href="dashboard.php">Dashboard</a> </li>
        <li class="active">Academies</li>
    </ul>

</div>
<div class="main-content">

    <div class="btn-toolbar list-toolbar">
        <button class="btn btn-primary" onclick="location.href = 'addAcademy.php';"><i class="fa fa-plus"></i> New Academy</button>
        <div class="btn-group">
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Academy Name</th>
                <th>Location</th>
                <th>Mobile</th>
                <th>No Of Clay Courts</th>
                <th>No Of Hard Courts</th>
                <th style="width: 3.5em;"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $starting = 0;
            while ($category = mysql_fetch_object($categories)) {
                echo '<tr>';
                echo '<td>' . $category->NAME . '</td><td>' . $category->COLONY . ', ' . $category->ADDRESS . ', ' . $category->LANDMARK . ', ' . $category->CITY . ', ' . $category->STATE . '</td>
              <td>' . $category->MOBILE . '</td>
              <td>' . $category->CLAY_COURTS . '</td>
              <td>' . $category->HARD_COURTS . '</td>
              <td>
              <a href="editacademy.php?id=' . $category->ACADEMY_ID . '"><i class="fa fa-pencil"></i></a>
              <a href="#myModal" role="button" data-toggle="modal" catval="' . $category->ACADEMY_ID . '"  class="deleteCat"><i class="fa fa-trash-o"></i></a>
              </td>
              </tr>';
                $starting++;
            }
            ?>
        </tbody>
    </table>

    <ul class="pagination">
        <li><a href="acadamies.php?page=<?php echo $previous; ?>">&laquo;</a></li>
        <?php
        for ($t = 1; $t <= ceil($total / $perPage); $t++) {
            echo '<li><a href="acadamies.php?page=' . $t . '">' . $t . '</a></li>';
        }
        ?>
        <li><a href="acadamies.php?page=<?php echo $next; ?>">&raquo;</a></li>
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
                    <form action="<?php echo $admin_url . '/category.php'; ?>" method="POST" enctype="multipart/form-data" name="deleteForm" id="deleteForm">
                        <input type="hidden" name="categoryDelete" value="" id="deleteCaregory"/>
                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancel</button>
                        <button class="btn btn-danger" data-dismiss="modal" name="delete" id="deleteSubmit" type="submit">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.fa-trash-o').click(function () {
            $('#deleteCaregory').val($(this).parent().attr('catval'));
        });
        $('#deleteSubmit').click(function () {
            $('#deleteForm').submit();
        });
    });
</script>
<?php
require_once 'footer.php';
?>