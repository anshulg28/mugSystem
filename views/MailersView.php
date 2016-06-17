<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Mailers :: Doolally</title>
	<?php echo $globalStyle; ?>
</head>
<body>
    <?php echo $headerView; ?>
    <main class="mailPage">
        <div class="container-fluid">
            <div class="row">
                <h2 class="text-center">Mail View</h2>
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
                        <?php
                            if($this->userType != SERVER_USER)
                            {
                                ?>
                                <li>
                                    <a href="<?php echo base_url().'users';?>">
                                        <div class="menuWrap">
                                            <i class="fa fa-user fa-5x"></i>
                                            <br>
                                            <span>Users List</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url().'locations'; ?>">
                                        <div class="menuWrap">
                                            <i class="fa fa-globe fa-5x"></i>
                                            <br>
                                            <span>Locations</span>
                                        </div>
                                    </a>
                                </li>
                                <?php
                            }
                            if($this->userType != EXECUTIVE_USER)
                            {
                                ?>
                                <li>
                                    <a href="<?php echo base_url() . 'check-ins/add'; ?>">
                                        <div class="menuWrap">
                                            <i class="fa fa-calendar-check-o fa-5x"></i>
                                            <br>
                                            <span>Check-Ins</span>
                                        </div>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                    </ul>
                </div>
            </div>
        </div>

    </main>
</body>
<?php echo $globalJs; ?>

<script>
    checkExpiredMugs();
</script>
</html>