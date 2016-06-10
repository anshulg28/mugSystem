<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<?php echo $globalStyle; ?>
</head>
<body>
    <?php echo $headerView; ?>
    <main class="homePage">
        <?php
            if(isSessionVariableSet($this->isUserSession) === true)
            {
                ?>
                <div class="container-fluid">
                    <div class="row">
                        <h2 class="text-center">Welcome <?php echo ucfirst($this->userName); ?></h2>
                        <br>
                        <div class="col-sm-12 text-center">
                            <ul class="list-inline my-mainMenuList">
                                <li>
                                    <a href="<?php echo base_url().'mugclub';?>">
                                        <div class="menuWrap">
                                            <i class="fa fa-beer fa-5x"></i>
                                            <br>
                                            <span>Mug Club</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="menuWrap">
                                            <i class="fa fa-print fa-5x"></i>
                                            <br>
                                            <span>Print List</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="menuWrap">
                                            <i class="fa fa-calendar-check-o fa-5x"></i>
                                            <br>
                                            <span>Check-Ins</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="menuWrap">
                                            <i class="fa fa-globe fa-5x"></i>
                                            <br>
                                            <span>Locations</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php
            }
            else
            {
                ?>
                <div class="container-fluid">
                    <h2 class="text-center">Login</h2>
                    <hr>
                    <form action="<?php echo base_url();?>login/checkUser/json" id="mainLoginForm" method="post" class="form-horizontal" role="form">
                        <div class="login-error-block text-center"></div>
                        <br>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="email">Username:</label>
                            <div class="col-sm-10">
                                <input type="text" name="userName" class="form-control" id="email" placeholder="Enter Username">
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
                <?php
            }
        ?>

    </main>
</body>
<?php echo $globalJs; ?>
</html>