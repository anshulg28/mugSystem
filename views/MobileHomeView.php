<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Mobile :: Doolally</title>
	<?php echo $mobileStyle; ?>
</head>
<body>
<!-- Status bar overlay for full screen mode (PhoneGap) -->
<div class="statusbar-overlay"></div>
<!-- Panels overlay-->
<div class="panel-overlay"></div>
<!-- Left panel with reveal effect-->
<div class="panel panel-left panel-reveal">
    <div class="content-block">
        <p>Left panel content goes here</p>
    </div>
</div>
<!-- Views -->
<div class="views">
    <!-- Your main view, should have "view-main" class -->
    <div class="view view-main">
        <!-- Top Navbar-->
        <div class="navbar">
            <div class="navbar-inner">
                <!-- We need cool sliding animation on title element, so we have additional "sliding" class -->
                <div class="center sliding">Awesome App</div>
                <div class="right">
                    <!--
                      Right link contains only icon - additional "icon-only" class
                      Additional "open-panel" class tells app to open panel when we click on this link
                    -->
                    <a href="#" class="link icon-only open-panel"><i class="icon icon-bars"></i></a>
                </div>
            </div>
        </div>
        <!-- Pages container, because we use fixed-through navbar and toolbar, it has additional appropriate classes-->
        <div class="pages navbar-through toolbar-through">
            <!-- Page, "data-page" contains page name -->
            <div data-page="index" class="page">
                <!-- Scrollable page content -->
                <div class="page-content">
                    <p>Page content goes here</p>
                    <!-- Link to another page -->
                    <a href="<?php echo base_url();?>mobile/about">About app</a>
                </div>
            </div>
        </div>
        <!-- Bottom Toolbar-->
        <div class="toolbar tabbar tabbar-labels">
            <div class="toolbar-inner">
                <a href="#tab1" class="tab-link active">
                    <i class="fa fa-calendar fa-2x"></i>
                    <span class="tabbar-label">Comming Up</span>
                </a>
                <a href="#tab2" class="tab-link">
                    <i class="icon fa fa-beer fa-2x">
                        <span class="badge bg-red">5</span>
                    </i>
                    <span class="tabbar-label">#Doolally</span>
                </a>
                <a href="#tab3" class="tab-link">
                    <i class="fa fa-spoon fa-2x"></i>
                    <span class="tabbar-label">Menus</span>
                </a>
            </div>
        </div>
    </div>
</div>
</body>
<?php echo $mobileJs; ?>
<script>
    (function () {
        if (Framework7.prototype.device.android) {
            Dom7('head').append(
                '<link rel="stylesheet" href="<?php echo base_url();?>asset/mobile/css/framework7.material.min.css">' +
                '<link rel="stylesheet" href="<?php echo base_url();?>asset/mobile/css/framework7.material.colors.min.css">'
            );
        }
        else {
            Dom7('head').append(
                '<link rel="stylesheet" href="<?php echo base_url();?>asset/mobile/css/framework7.ios.min.css">' +
                '<link rel="stylesheet" href="<?php echo base_url();?>asset/mobile/css/framework7.ios.colors.min.css">'
            );
        }
    })();
</script>
</html>