<?php
require_once 'managePlayers.php';
require_once 'header.php';

$players = new players();
//$totalAcademies = $academies->getAcadamies();
$perPage = $players->perPage;
$page = 1;
if (isset($_GET['page'])) {
    $page = trim($_GET['page']);
}
$players->first = ($page - 1) * $perPage;

$categories = $players->getPlayers();
$total = $players->getToalRecords();

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

    <h1 class="page-title">Players</h1>
    <ul class="breadcrumb">
        <li><a href="dashboard.php">Dashboard</a> </li>
        <li class="active">Players</li>
    </ul>

</div>
<div class="main-content">
    <?php
    if (isset($_SESSION['success']) && !empty($_SESSION['success'])) {
        echo '<h4 class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a>' . $_SESSION['success'] . '</h4>';
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
        echo '<h4 class="alert alert-error"><a href="#" class="close" data-dismiss="alert">&times;</a>' . $_SESSION['error'] . '</h4>';
        unset($_SESSION['error']);
    }
    ?>
    <div class="btn-toolbar list-toolbar">
        <button class="btn btn-primary" onclick="location.href = 'addPlayer.php';"><i class="fa fa-plus"></i> New Player</button>
        <a href="#importPlayers" role="button" class="btn" data-toggle="modal"><button class="btn btn-default">Import</button></a>
        <div class="btn-group">
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Player Name</th>
                <th>AITA Number</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>State</th>
                <th>Academy Name</th>
                <th style="width: 3.5em;"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $starting = 0;
            while ($category = mysql_fetch_object($categories)) {
                echo '<tr>';
                echo '<td>' . $category->NAME . '</td><td>' . $category->AITA . '</td>
              <td>' . $category->EMAIL . '</td>
              <td>' . $category->MOBILE . '</td>
              <td>' . $category->STATE . '</td>
              <td>' . $category->academyName . '</td>
              <td>
              <a href="editPlayer.php?aid=' . $category->ACADEMY_ID . '&pid=' . $category->AITA . '"><i class="fa fa-pencil"></i></a>
              <a href="#myModal" role="button" data-toggle="modal" catval="' . $category->AITA . '"  class="deleteCat"><i class="fa fa-trash-o"></i></a>
              </td>
              </tr>';
                $starting++;
            }
            ?>
        </tbody>
    </table>

    <ul class="pagination">
        <li><a href="players.php?page=<?php echo $previous; ?>">&laquo;</a></li>
        <?php
        for ($t = 1; $t <= ceil($total / $perPage); $t++) {
            echo '<li><a href="players.php?page=' . $t . '">' . $t . '</a></li>';
        }
        ?>
        <li><a href="players.php?page=<?php echo $next; ?>">&raquo;</a></li>
    </ul>

    <div class="modal small fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Delete Confirmation</h3>
                </div>
                <div class="modal-body">
                    <p class="error-text"><i class="fa fa-warning modal-icon"></i>Are you sure you want to delete the Player?<br>This cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <form action="<?php echo $admin_url . '/player.php'; ?>" method="POST" enctype="multipart/form-data" name="deleteForm" id="deleteForm">
                        <input type="hidden" name="deletePlayer" value="" id="deletePlayer"/>
                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancel</button>
                        <button class="btn btn-danger" data-dismiss="modal" name="delete" id="deleteSubmit" type="submit">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal small fade" id="importPlayers" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h2>Import Players</h2>
                </div>
                <div class="modal-body">
                    <p class="error-text">Select a file to import.</p>
                </div>
                <div class="modal-footer">
                    <form action="<?php echo $admin_url . '/player.php'; ?>" method="POST" enctype="multipart/form-data" name="uploadForm" id="importPlayersForm">
                        <input type="file" name="importPlayers" id="importPlayersFile"/>
                        <input type="hidden" name="testPlayers" value="Test"/>
                        <button class="btn btn-danger" data-dismiss="modal" name="playersImport" id="playersImport" type="submit">Import Players</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.fa-trash-o').click(function () {
            $('#deletePlayer').val($(this).parent().attr('catval'));
        });
        $('#deleteSubmit').click(function () {
            $('#deleteForm').submit();
        });
        $('#playersImport').click(function () {
            $('#importPlayersForm').submit();
        });
    });
</script>
<?php
require_once 'footer.php';
?>