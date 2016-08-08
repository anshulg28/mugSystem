<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Doolally</title>
	<?php echo $mobileStyle; ?>
    <?php echo $iosStyle; ?>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans|Averia+Serif+Libre' rel='stylesheet' type='text/css'>
</head>
<body class="iosHome">
<!-- Status bar overlay for full screen mode (PhoneGap) -->
<div class="statusbar-overlay"></div>
<!-- Panels overlay-->
<div class="panel-overlay"></div>
<!-- Left panel with reveal effect-->
<div class="panel panel-left panel-cover">
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
                    <a href="#" class="link icon-only open-panel main-menu-icon">
                        <i class="fa fa-bars color-black"></i>
                        <span class="d-logo"></span>
                        <!--<span class="bottom-bar-line"></span>-->
                        <!--<i class="fa fa-minus"></i>
                        <i class="fa fa-minus"></i>-->
                    </a>
                </div>
                <!--<div class="center sliding">Awesome App</div>-->
            </div>
        </div>

        <!-- Pages container, because we use fixed-through navbar and toolbar, it has additional appropriate classes-->
        <div class="pages navbar-through toolbar-through">
            <!-- Page, "data-page" contains page name -->
            <div class="page" data-page="comming-up">
                <!-- Scrollable page content -->
                <div class="page-content pull-to-refresh-content" data-ptr-distance="55" id="my-page1">
                    <div class="pull-to-refresh-layer">
                        <div class="preloader"></div>
                        <div class="pull-to-refresh-arrow"></div>
                    </div>
                    <p>Page content goes here</p>
                    <div id="instafeed"></div>
                    <!--<a href="#" class="floating-button color-white">
                        <i class="icon fa-4x">+</i>
                    </a>-->
                </div>
            </div>
        </div>
    </div>
    <div id="tab2" class="view view-main tab">
        <!-- Top Navbar-->
        <div class="navbar mycustomNav">
            <div class="navbar-inner">
                <div class="left">
                    <!--<a href="#" class="link icon-only open-panel"><i class="icon fa fa-bars color-black"></i></a>-->
                    <a href="#" class="link icon-only open-panel ripple main-menu-icon">
                        <i class="fa fa-bars color-black"></i>
                        <span class="d-logo"></span>
                        <!--<i class="fa fa-minus"></i>
                        <i class="fa fa-minus"></i>-->
                    </a>
                </div>
                <!--<div class="center sliding">Awesome App</div>-->
            </div>
        </div>
        <!-- Pages container, because we use fixed-through navbar and toolbar, it has additional appropriate classes-->
        <div class="pages navbar-through toolbar-through">
            <!-- Page, "data-page" contains page name -->
            <div data-page="main-feeds" class="page">
                <!-- Scrollable page content -->
                <div class="page-content infinite-scroll" id="my-page2">
                    <div class="content-block custom-accordion">
                        <?php
                            if(isset($myFeeds) && myIsArray($myFeeds))
                            {
                                $postlimit = 0;
                                foreach($myFeeds as $key => $row)
                                {
                                    if(isset($row['socialType']))
                                    {
                                        switch($row['socialType'])
                                        {
                                            case 't':
                                                $row['text'] = preg_replace('!(http|ftp|scp)(s)?:\/\/[a-zA-Z0-9.?%=&_/]+!', "", $row['text']);
                                                $row['text'] = highlight('/#\w+/',$row['text']);
                                                $row['text'] = highlight('/@\w+/',$row['text']);
                                                $truncated_RestaurantName = (strlen($row['text']) > 140) ? substr($row['text'], 0, 140) . '..' : $row['text'];
                                                ?>
                                                <!--twitter://status?status_id=756765768470130689-->
                                                <a href="https://twitter.com/<?php echo $row['user']['screen_name'];?>/status/<?php echo $row['id_str'];?>" target="_blank" class="external twitter-wrapper">
                                                    <div class="my-card-items <?php if($postlimit >= 10){echo 'hide';} $postlimit++; ?>">
                                                        <div class="card demo-card-header-pic">
                                                            <div class="card-content">
                                                                <div class="card-content-inner">
                                                                    <div class="list-block media-list">
                                                                        <ul>
                                                                            <li>
                                                                                <div class="item-content">
                                                                                    <div class="item-media"><img class="myAvtar-list lazy" data-src="<?php echo $row['user']['profile_image_url'];?>" width="44"/></div>
                                                                                    <div class="item-inner">
                                                                                        <div class="item-title-row">
                                                                                            <div class="item-title"><?php echo ucfirst($row['user']['name']);?></div>
                                                                                            <i class="fa fa-twitter social-icon-gap"></i>
                                                                                        </div>
                                                                                        <div class="item-subtitle">@<?php echo $row['user']['screen_name'];?></div>
                                                                                    </div>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                    <?php
                                                                    if(isset($row['extended_entities']))
                                                                    {
                                                                        ?>
                                                                        <div class="row no-gutter feed-image-container">
                                                                            <?php
                                                                            $imageLimit = 0;
                                                                            foreach($row['extended_entities']['media'] as $mediaKey => $mediaRow)
                                                                            {
                                                                                if($imageLimit >= 1)
                                                                                {
                                                                                    $isImageDone = true;
                                                                                    break;
                                                                                }
                                                                                $imageLimit++;
                                                                                if(isset($mediaRow['video_info']['variants']) && myIsArray($mediaRow['video_info']['variants']))
                                                                                {
                                                                                    $videoUrl= '';
                                                                                    $videoType = '';
                                                                                    foreach($mediaRow['video_info']['variants'] as $videoKey => $videoRow)
                                                                                    {
                                                                                        if(isset($videoRow['bitrate']))
                                                                                        {
                                                                                            $videoUrl = $videoRow['url'];
                                                                                            $videoType = $videoRow['content_type'];
                                                                                        }
                                                                                    }
                                                                                    if(strpos($videoUrl,"youtube") !== false || strpos($videoUrl,"youtu.be"))
                                                                                    {
                                                                                        ?>
                                                                                        <div class="col-100">
                                                                                            <iframe width="100%" src="<?php echo $videoUrl;?>" frameborder="0" allowfullscreen>
                                                                                            </iframe>
                                                                                        </div>
                                                                                        <?php
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        ?>
                                                                                        <div class="col-100">
                                                                                            <video width="100%" controls>
                                                                                                <source src="<?php echo $videoUrl;?>" type="<?php echo $videoType;?>">
                                                                                                No Video Found!
                                                                                            </video>
                                                                                        </div>
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                                else
                                                                                {
                                                                                    ?>
                                                                                    <div class="col-100">
                                                                                        <img data-src="<?php echo $mediaRow['media_url'];?>" class="mainFeed-img lazy lazy-fadein"/>
                                                                                    </div>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    elseif(isset($row['entities']['urls']) && myIsArray($row['entities']['urls']))
                                                                    {
                                                                        ?>
                                                                        <div class="link-card-wrapper">
                                                                            <input type="hidden" class="my-link-url" value="<?php echo $row['entities']['urls'][0]['expanded_url'];?>"/>
                                                                            <div class="liveurl feed-image-container hide">
                                                                                <img src="" class="link-image mainFeed-img lazy lazy-fadeIn" />
                                                                                <div class="details">
                                                                                    <div class="title"></div>
                                                                                    <div class="description"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    <p class="final-card-text"><?php echo $truncated_RestaurantName;?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <?php
                                                break;
                                            case 'f':
                                                preg_match_all('!(http|ftp|scp)(s)?:\/\/[a-zA-Z0-9.?%=&_/]+!', $row['message'], $backupLink);
                                                $row['message'] = preg_replace('!(http|ftp|scp)(s)?:\/\/[a-zA-Z0-9.?%=&_/]+!', "", $row['message']);
                                                $row['message'] = highlight('/#\w+/',$row['message']);
                                                $row['message'] = highlight('/@\w+/',$row['message']);
                                                $truncated_RestaurantName = (strlen($row['message']) > 140) ? substr($row['message'], 0, 140) . '..' : $row['message'];
                                                ?>
                                                <!--twitter://status?status_id=756765768470130689-->
                                                <a href="<?php echo $row['permalink_url'];?>" target="_blank" class="external facebook-wrapper">
                                                    <div class="my-card-items <?php if($postlimit >= 10){echo 'hide';} $postlimit++; ?>">
                                                        <div class="card demo-card-header-pic">
                                                            <div class="card-content">
                                                                <div class="card-content-inner">
                                                                    <div class="list-block media-list">
                                                                        <ul>
                                                                            <li>
                                                                                <div class="item-content">
                                                                                    <div class="item-media"><img class="myAvtar-list lazy" data-src="https://graph.facebook.com/v2.7/<?php echo $row['from']['id'];?>/picture" width="44"/></div>
                                                                                    <div class="item-inner">
                                                                                        <div class="item-title-row">
                                                                                            <div class="item-title"><?php echo ucfirst($row['from']['name']);?></div>
                                                                                            <i class="fa fa-facebook-official social-icon-gap"></i>
                                                                                        </div>
                                                                                        <!--<div class="item-subtitle">@<?php /*echo $row['user']['screen_name'];*/?></div>-->
                                                                                    </div>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                    <?php
                                                                    if(isset($row['source']))
                                                                    {
                                                                        if(strpos($row['source'],"youtube") !== false || strpos($row['source'],"youtu.be") !== false)
                                                                        {
                                                                            ?>
                                                                            <div class="row no-gutter feed-image-container">
                                                                                <div class="col-100">
                                                                                    <iframe width="100%" src="<?php echo $row['source'];?>" frameborder="0" allowfullscreen>
                                                                                    </iframe>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        else
                                                                        {
                                                                            ?>
                                                                            <div class="row no-gutter feed-image-container">
                                                                                <div class="col-100">
                                                                                    <video width="100%" controls>
                                                                                        <source src="<?php echo $row['source'];?>" >
                                                                                        No Video Found!
                                                                                    </video>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    elseif(isset($row['picture']))
                                                                    {
                                                                        ?>
                                                                        <div class="row no-gutter feed-image-container">
                                                                            <div class="col-100">
                                                                                <img data-src="<?php echo $row['picture'];?>" class="mainFeed-img lazy lazy-fadein"/>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    elseif(isset($backupLink) && myIsArray($backupLink))
                                                                    {
                                                                        ?>
                                                                        <div class="link-card-wrapper">
                                                                            <input type="hidden" class="my-link-url" value="<?php echo $backupLink[0][0];?>"/>
                                                                            <div class="liveurl feed-image-container hide">
                                                                                <img src="" class="link-image mainFeed-img lazy lazy-fadeIn" />
                                                                                <div class="details">
                                                                                    <div class="title"></div>
                                                                                    <div class="description"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    <p class="final-card-text"><?php echo $truncated_RestaurantName;?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <?php
                                                break;
                                            case 'i':
                                                preg_match_all('!(http|ftp|scp)(s)?:\/\/[a-zA-Z0-9.?%=&_/]+!', $row['unformatted_message'], $backupLink);
                                                $row['unformatted_message'] = preg_replace('!(http|ftp|scp)(s)?:\/\/[a-zA-Z0-9.?%=&_/]+!', "", $row['unformatted_message']);
                                                $row['unformatted_message'] = highlight('/#\w+/',$row['unformatted_message']);
                                                $row['unformatted_message'] = highlight('/@\w+/',$row['unformatted_message']);
                                                $truncated_RestaurantName = (strlen($row['unformatted_message']) > 140) ? substr($row['unformatted_message'], 0, 140) . '..' : $row['unformatted_message'];
                                                ?>
                                                <!--twitter://status?status_id=756765768470130689-->
                                                <a href="<?php echo $row['full_url'];?>" target="_blank" class="external instagram-wrapper">
                                                    <div class="my-card-items <?php if($postlimit >= 10){echo 'hide';} $postlimit++; ?>">
                                                        <div class="card demo-card-header-pic">
                                                            <div class="card-content">
                                                                <div class="card-content-inner">
                                                                    <div class="list-block media-list">
                                                                        <ul>
                                                                            <li>
                                                                                <div class="item-content">
                                                                                    <div class="item-media"><img class="myAvtar-list lazy" data-src="<?php echo $row['poster_image'];?>" width="44"/></div>
                                                                                    <div class="item-inner">
                                                                                        <div class="item-title-row">
                                                                                            <div class="item-title"><?php echo ucfirst($row['poster_name']);?></div>
                                                                                            <i class="fa fa-instagram social-icon-gap"></i>
                                                                                        </div>
                                                                                        <?php
                                                                                            if(isset($row['source']))
                                                                                            {
                                                                                                if($row['source']['term_type'] == 'hashtag')
                                                                                                {
                                                                                                    ?>
                                                                                                    <div class="item-subtitle">#<?php echo $row['source']['term'];?></div>
                                                                                                    <?php
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    ?>
                                                                                                    <div class="item-subtitle">@<?php echo $row['source']['term'];?></div>
                                                                                                    <?php
                                                                                                }
                                                                                            }
                                                                                        ?>
                                                                                    </div>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                    <?php
                                                                    if(isset($row['video']))
                                                                    {
                                                                        if(strpos($row['video'],"youtube") !== false || strpos($row['video'],"youtu.be") !== false)
                                                                        {
                                                                            ?>
                                                                            <div class="row no-gutter feed-image-container">
                                                                                <div class="col-100">
                                                                                    <iframe width="100%" src="<?php echo $row['video'];?>" frameborder="0" allowfullscreen>
                                                                                    </iframe>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        else
                                                                        {
                                                                            ?>
                                                                            <div class="row no-gutter feed-image-container">
                                                                                <div class="col-100">
                                                                                    <video width="100%" controls>
                                                                                        <source src="<?php echo $row['video'];?>" >
                                                                                        No Video Found!
                                                                                    </video>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    elseif(isset($row['image']))
                                                                    {
                                                                        ?>
                                                                        <div class="row no-gutter feed-image-container">
                                                                            <div class="col-100">
                                                                                <img data-src="<?php echo $row['image'];?>" class="mainFeed-img lazy lazy-fadein"/>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    elseif(isset($backupLink) && myIsArray($backupLink))
                                                                    {
                                                                        ?>
                                                                        <div class="link-card-wrapper">
                                                                            <input type="hidden" class="my-link-url" value="<?php echo $backupLink[0][0];?>"/>
                                                                            <div class="liveurl feed-image-container hide">
                                                                                <img src="" class="link-image mainFeed-img lazy lazy-fadeIn" />
                                                                                <div class="details">
                                                                                    <div class="title"></div>
                                                                                    <div class="description"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    <p class="final-card-text"><?php echo $truncated_RestaurantName;?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <?php
                                                break;
                                        }
                                    }
                                }
                            }
                            else
                            {
                                echo 'No Feeds Found!';
                            }
                        ?>
                    </div>
                    <?php
                        if(isset($myFeeds) && myIsArray($myFeeds))
                        {
                            ?>
                            <div class="infinite-scroll-preloader">
                                <div class="preloader"></div>
                            </div>
                            <?php
                        }
                    ?>
                </div>
            </div>

        </div>
    </div>
    <div id="tab3" class="view view-menus tab">
        <!-- Top Navbar-->
        <div class="navbar mycustomNav">
            <div class="navbar-inner">
                <div class="left">
                    <!--<a href="#" class="link icon-only open-panel"><i class="icon fa fa-bars color-black"></i></a>-->
                    <a href="#" class="link icon-only open-panel main-menu-icon">
                        <i class="fa fa-bars color-black"></i>
                        <span class="d-logo"></span>
                        <!--<i class="fa fa-minus"></i>
                        <i class="fa fa-minus"></i>-->
                    </a>
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
                <span class="tabbar-label">Events</span>
            </a>
            <a href="#tab2" class="tab-link active">
                <i class="fa fa-hashtag"></i>
                <span class="tabbar-label">#Doolally</span>
            </a>
            <a href="#tab3" class="tab-link">
                <i class="fa fa-cutlery"></i>
                <span class="tabbar-label">F&B</span>
            </a>
        </div>
    </div>
</div>
<!-- Colored FAB button with ripple -->
<button data-popover=".popover-links"
        class="open-popover mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored my-fab-btn hide">
    <i class="popover-toggle-on fa fa-filter"></i>
    <i class="popover-toggle-off fa fa-times"></i>
</button>
<div class="popover popover-links">
    <div class="popover-angle"></div>
    <div class="popover-inner">
        <p>Filter Posts</p>
        <div class="list-block inset">
            <ul>
                <li>
                    <div class="item-inner">
                        <div class="item-title">Facebook</div>
                        <div class="item-after">
                            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect my-fb-label" for="fb-checked">
                                <input type="checkbox" name="social-filter" value="1" id="fb-checked" class="mdl-checkbox__input">
                                <span class="mdl-checkbox__label"></span>
                            </label>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item-inner">
                        <div class="item-title">Twitter</div>
                        <div class="item-after">
                            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect my-tw-label" for="tw-checked">
                                <input type="checkbox" name="social-filter" value="2" id="tw-checked" class="mdl-checkbox__input">
                                <span class="mdl-checkbox__label"></span>
                            </label>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item-inner">
                        <div class="item-title">Instagram</div>
                        <div class="item-after">
                            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect my-insta-label" for="insta-checked">
                                <input type="checkbox" name="social-filter" value="3" id="insta-checked" class="mdl-checkbox__input">
                                <span class="mdl-checkbox__label"></span>
                            </label>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
</body>
<?php echo $mobileJs; ?>
<?php echo $iosJs; ?>

</html>