<?php
require_once 'header.php';
?>
<div class="dialog">
    <div class="panel panel-default">
        <p class="panel-heading no-collapse">Sign In</p>
        <div class="panel-body">
            <form action='<?php echo $admin_url; ?>/adminLogin.php' method='post' enctype="multipart/form-data">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control span12">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-controlspan12 form-control">
                </div>
                <button type="submit" name="submit" class="btn btn-primary pull-right">Sign In</button>
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
    <p><a href="<?php echo $admin_url; ?>/reset-password.php">Forgot your password?</a></p>
</div>
<?php
require_once 'footer.php';
?>