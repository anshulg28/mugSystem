<!DOCTYPE html>
<html lang="en">

<body>
<!-- Status bar overlay for full screen mode (PhoneGap) -->
<!-- Top Navbar-->
<div class="navbar mycustomNav">
    <div class="navbar-inner">
        <div class="left">
            <a href="#" class="back link" data-ignore-cache="true">
                <i class="ic_back_icon point-item"></i>
            </a>
        </div>
        <div class="center sliding">
            <!--My Events-->
            Request Song
        </div>
        <div class="right">
            <?php
                if(isset($status) && $status === true)
                {
                    ?>
                    <a href="#" id="music-logout-btn">
                        <i class="ic_logout_icon point-item"></i>
                    </a>
                    <?php
                }
            ?>
        </div>
        <?php
            if(isset($status) && $status === false)
            {
                ?>
                <div class="subnavbar myCustomSubNav">
                    <!-- Buttons row as tabs controller in Subnavbar-->
                    <div class="buttons-row">
                        <!-- Link to 1st tab, active -->
                        <a href="#login" class="button active tab-link">Login</a>
                        <!-- Link to 2nd tab -->
                        <a href="#signup" class="button tab-link">Sign Up</a>
                    </div>
                </div>
                <?php
            }
        ?>
    </div>
</div>

<div class="pages">
    <div data-page="songlist" class="page tapSong-page">
        <?php
        if(isset($status) && $status === true)
        {
            ?>
            <form class="searchbar searchbar-init" data-search-list=".list-block-search" data-search-in=".item-title" data-found=".searchbar-found" data-not-found=".searchbar-not-found">
                <div class="searchbar-input">
                    <input type="search" placeholder="Search Music">
                    <a href="#" class="searchbar-clear"></a>
                </div>
                <a href="#" class="searchbar-cancel">Cancel</a>
            </form>

            <!-- Search Bar overlay-->
            <div class="searchbar-overlay"></div>
            <?php
        }
        ?>

        <div class="page-content">
            <div class="content-block searchbar-not-found">
                Nothing found
            </div>
            <?php
            if(isset($status) && $status === true)
            {
                if(isset($tapSongs) && myIsMultiArray($tapSongs))
                {
                    $songs = json_decode($tapSongs[0]['tapSongs'],true);
                    ?>
                    <div class="list-block media-list list-block-search searchbar-found">
                        <ul>
                            <?php
                            foreach($songs[0] as $key => $row)
                            {

                                ?>
                                <li>
                                    <div class="item-content">
                                        <div class="item-media">
                                            <?php
                                                if($row['albumartThumbnail'] == '')
                                                {
                                                    ?>
                                                    <i class="fa fa-music music-placeholder"></i>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <img class="queue-img-icon" src="<?php echo $row['albumartThumbnail'];?>" width="44"/>
                                                    <?php
                                                }
                                            ?>
                                        </div>
                                        <div class="item-inner">
                                            <div class="item-title-row">
                                                <div class="item-title"><?php echo $row['name'];?></div>
                                            </div>
                                            <div class="item-subtitle">
                                                <?php echo $row['artist'];?>
                                                <div class="request_song_btn" data-songId="<?php echo $row['id'];?>"
                                                     data-tapId="<?php echo $tapId;?>">
                                                    <i class="fa fa-plus"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <?php
                }
            }
            else
            {
                ?>
                <!-- Tabs swipeable wrapper, required to switch tabs with swipes -->
                <div class="tabs-swipeable-wrap">
                    <!-- Tabs, tabs wrapper -->
                    <div class="tabs">
                        <!-- Tab 1, active by default -->
                        <div id="login" class="page-content tab active">
                            <div class="content-block">
                                <form action="<?php echo base_url().'main/checkUser';?>" id="jukebox-login" method="post" class="ajax-submit">
                                    <div class="list-block">
                                        <ul>
                                            <li class="item-content">
                                                <div class="item-inner">
                                                    <div class="item-title label">Email</div>
                                                    <div class="item-input">
                                                        <input type="email" name="username" placeholder="Email">
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="item-content">
                                                <div class="item-inner">
                                                    <div class="item-title label">Password</div>
                                                    <div class="item-input">
                                                        <input type="password" name="password" placeholder="Your password">
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="list-block">
                                        <ul>
                                            <li><input type="submit" class="button button-big button-fill" value="Log In"/></li>
                                        </ul>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Tab 2 -->
                        <div id="signup" class="page-content tab">
                            <div class="content-block">
                                <form action="<?php echo base_url().'main/saveUser';?>" id="jukebox-signup" method="post" class="ajax-submit">
                                    <div class="list-block">
                                        <ul>
                                            <li class="item-content">
                                                <div class="item-inner">
                                                    <div class="item-title label">Email</div>
                                                    <div class="item-input">
                                                        <input type="email" name="username" placeholder="Email">
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="item-content">
                                                <div class="item-inner">
                                                    <div class="item-title label">Mobile No.</div>
                                                    <div class="item-input">
                                                        <input type="number" name="mobNum" placeholder="Mobile Number">
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="item-inner">
                                                    <div class="item-title"></div>
                                                    <div class="item-input">
                                                        <label class="label-checkbox item-content">
                                                            <!-- Checked by default -->
                                                            <input type="checkbox" name="hasjukebox" value="Jukebox">
                                                            <div class="item-media">
                                                                <i class="icon icon-form-checkbox"></i>
                                                            </div>
                                                            <div class="item-inner">
                                                                <div class="item-title">Have Jukebox Login?</div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>

                                            </li>
                                        </ul>
                                    </div>
                                    <div class="list-block jukepass-wrapper hide">
                                        <ul>
                                            <li class="item-content">
                                                <div class="item-inner">
                                                    <div class="item-title label">Password</div>
                                                    <div class="item-input">
                                                        <input type="password" name="jukepass" placeholder="Jukebox Password">
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="list-block">
                                        <ul>
                                            <li><input type="submit" class="button button-big button-fill" value="Sign Up"/></li>
                                        </ul>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
</div>

</body>
</html>