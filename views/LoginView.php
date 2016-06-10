<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Login :: Doolally</title>
	<?php echo $globalStyle; ?>
</head>
<body>
    <?php echo $headerView; ?>
    <main>
        <div class="container-fluid">
            <h1 class="text-center">Login</h1>
            <hr>
            <form action="<?php echo base_url();?>login/checkUser" method="post" class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="userName">Username:</label>
                    <div class="col-sm-10">
                        <input type="text" name="userName" class="form-control" id="userName" placeholder="Enter Username">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="pwd">Password:</label>
                    <div class="col-sm-10">
                        <input type="password" name="password" class="form-control" id="pwd" placeholder="Enter password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </main>
</body>
<?php echo $globalJs; ?>
</html>