<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>IOS :: Doolally</title>
	<?php echo $mobileStyle; ?>
    <?php echo $iosStyle; ?>
</head>
<body class="iosHome">
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
<div class="views tabs toolbar-through">
    <!--<div class="tabs">-->
    <!-- Your main view, should have "view-main" class -->
    <div id="tab1" class="view view-commingUp tab">
        <!-- Top Navbar-->
        <div class="navbar mycustomNav">
            <div class="navbar-inner">
                <div class="left">
                    <a href="#" class="link icon-only open-panel"><i class="icon fa fa-bars color-black"></i></a>
                </div>
                <!--<div class="center sliding">Awesome App</div>-->
            </div>
        </div>

        <!-- Pages container, because we use fixed-through navbar and toolbar, it has additional appropriate classes-->
        <div class="pages navbar-through toolbar-through">
            <!-- Page, "data-page" contains page name -->
            <div class="page" data-page="comming-up">
                <!-- Scrollable page content -->
                <div class="page-content" id="my-page1">
                    <p>Page content goes here</p>
                    <a href="#" class="floating-button color-white">
                        <i class="icon fa-4x">+</i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div id="tab2" class="view view-main tab">
        <!-- Top Navbar-->
        <div class="navbar mycustomNav">
            <div class="navbar-inner">
                <div class="left">
                    <a href="#" class="link icon-only open-panel"><i class="icon fa fa-bars color-black"></i></a>
                </div>
                <!--<div class="center sliding">Awesome App</div>-->
            </div>
        </div>
        <!-- Pages container, because we use fixed-through navbar and toolbar, it has additional appropriate classes-->
        <div class="pages navbar-through toolbar-through">
            <!-- Page, "data-page" contains page name -->
            <div data-page="main-feeds" class="page">
                <!-- Scrollable page content -->
                <div class="page-content" id="my-page2">
                    <div class="content-block accordion-list custom-accordion">
                        <div class="accordion-item" id="mainItem">
                            <div class="card demo-card-header-pic">
                                <div class="accordion-item-content">
                                    <img class="mainFeed-img" src="<?php echo base_url();?>asset/images/mainImg.jpg"/>
                                </div>
                                <div class="accordion-item-toggle">
                                    <div class="card-content">
                                        <div class="card-content-inner">
                                            <div class="list-block media-list">
                                                <ul>
                                                    <li>
                                                        <div class="item-content">
                                                            <div class="item-media"><img class="myAvtar-list" src="<?php echo base_url();?>asset/images/Avatar_Cat.jpg" width="44"></div>
                                                            <div class="item-inner">
                                                                <div class="item-title-row">
                                                                    <div class="item-title">Doolally</div>
                                                                    <i class="fa fa-instagram"></i>
                                                                </div>
                                                                <div class="item-subtitle">@godoolally</div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <p>Giant Jenga, is clearly Jenga on Steroids. Audience game at #doolally #beerolympics2016</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <div class="card demo-card-header-pic">
                                <div class="accordion-item-content">
                                    <img class="mainFeed-img" src="<?php echo base_url();?>asset/images/mainImg.jpg"/>
                                </div>
                                <div class="accordion-item-toggle">
                                    <div class="card-content">
                                        <div class="card-content-inner">
                                            <div class="list-block media-list">
                                                <ul>
                                                    <li>
                                                        <div class="item-content">
                                                            <div class="item-media"><img class="myAvtar-list" src="<?php echo base_url();?>asset/images/Avatar_Dog.png" width="44"></div>
                                                            <div class="item-inner">
                                                                <div class="item-title-row">
                                                                    <div class="item-title">Gob Bluth</div>
                                                                    <i class="fa fa-twitter"></i>
                                                                </div>
                                                                <div class="item-subtitle">@IllusionistNotAMagician</div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <p>Giant Jenga, is clearly Jenga on Steroids. Audience game at #doolally #beerolympics2016</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="tab3" class="view view-menus tab">
        <!-- Top Navbar-->
        <div class="navbar mycustomNav">
            <div class="navbar-inner">
                <div class="left">
                    <a href="#" class="link icon-only open-panel"><i class="icon fa fa-bars color-black"></i></a>
                </div>
                <!--<div class="center sliding">Awesome App</div>-->
            </div>
        </div>
        <!-- Pages container, because we use fixed-through navbar and toolbar, it has additional appropriate classes-->
        <div class="pages navbar-through toolbar-through">
            <!-- Page, "data-page" contains page name -->
            <div class="page" data-page="menusPage">
                <!-- Scrollable page content -->
                <div class="page-content" id="my-page3">
                    <p>Tab 3</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Bottom Toolbar-->
    <!--</div>-->
    <div class="toolbar tabbar tabbar-labels myMainBottomBar">
        <div class="toolbar-inner">
            <a href="#tab1" class="tab-link">
                <i class="fa fa-calendar"></i>
                <span class="tabbar-label">Coming Up</span>
            </a>
            <a href="#tab2" class="tab-link active">
                <i class="icon fa fa-beer">
                </i>
                <span class="tabbar-label">#Doolally</span>
            </a>
            <a href="#tab3" class="tab-link">
                <i class="fa fa-spoon"></i>
                <span class="tabbar-label">Menus</span>
            </a>
        </div>
    </div>
</div>
</body>
<?php echo $mobileJs; ?>
<?php echo $iosJs; ?>
</html>