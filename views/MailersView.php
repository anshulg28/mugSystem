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
                <div class="col-sm-2 col-xs-0"></div>
                <div class="col-sm-8 col-xs-12 text-center">
                    <ul class="list-inline my-mainMenuList">
                        <li>
                            <?php
                                if(count($expiredMugs['expiredMugList']) > 0)
                                {
                                    ?>
                                        <span class="badge"><?php echo count($expiredMugs['expiredMugList']); ?></span>
                                        <a href="<?php echo base_url().'mailers/send/1';?>" onclick="removeNotifications()">
                                    <?php
                                }
                                else
                                {
                                    ?>
                                            <a href="#">
                                    <?php
                                }
                            ?>
                                <div class="menuWrap">
                                    <i class="fa fa-battery-empty fa-2x my-danger-text"></i>
                                    <br>
                                    <span>Mugs Expired</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <?php
                            if(count($expiringMugs['expiringMugList']) > 0)
                            {
                                ?>
                                    <span class="badge"><?php echo count($expiringMugs['expiringMugList']); ?></span>
                                    <a href="<?php echo base_url().'mailers/send/2';?>" onclick="removeNotifications()">
                                <?php
                            }
                            else
                            {
                                ?>
                                    <a href="#">
                                <?php
                            }
                            ?>
                                <div class="menuWrap">
                                    <i class="fa fa-battery-quarter fa-2x my-orange-text"></i>
                                    <br>
                                    <span>Mugs Expiring</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url().'mailers/send/3'; ?>">
                                <div class="menuWrap">
                                    <i class="fa fa-plus fa-2x"></i>
                                    <br>
                                    <span>Custom Mail</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-2 col-xs-0"></div>
            </div>
        </div>

    </main>
</body>
<?php echo $globalJs; ?>

</html>