<!DOCTYPE html>
<html lang="en">

<body class="event-view">
<!-- Status bar overlay for full screen mode (PhoneGap) -->
<!-- Top Navbar-->
<?php
    if(isset($eventDetails) && myIsMultiArray($eventDetails))
    {
        foreach($eventDetails as $key => $row)
        {
            ?>
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="left">
                        <a href="#" class="back link" data-ignore-cache="true">
                            <i class="ic_back_icon point-item"></i>
                        </a>
                    </div>
                    <div class="center sliding"><?php echo $row['eventData']['eventName'];?></div>
                    <!--<div class="right">

                    </div>-->
                </div>
            </div>
            <div class="pages">
                <div data-page="event" class="page">
                    <div class="page-content">
                        <div class="content-block event-wrapper">
                            <?php
                                if(isset($row['eventAtt']) && myIsMultiArray($row['eventAtt']))
                                {
                                    ?>
                                    <div class="col-100 more-photos-wrapper">
                                        <img src="<?php echo base_url().EVENT_PATH_THUMB.$row['eventAtt'][0]['filename'];?>" class="mainFeed-img"/>
                                    </div>
                                    <?php
                                }
                            ?>
                            <div class="event-header-name"><?php echo $row['eventData']['eventName'];?></div>
                            <p class="content-block event-about"><?php echo strip_tags($row['eventData']['eventDescription'],'<br>');?></p>
                            <hr class="card-ptag">
                            <!-- Where section -->
                            <div class="event-descrip-wrapper">
                                <i class="ic_me_location_icon point-item my-right-event-icon"></i>
                                <div class="event-header-name">Where</div>
                                <div class="clear"></div>
                                <p class="event-sub-text">
                                    Doolally Taproom, <?php echo $row['eventData']['locData'][0]['locName'];?>
                                </p>
                            </div>

                            <!-- When Section -->
                            <div class="event-descrip-wrapper">
                                <span class="fa-15x ic_events_icon my-right-event-icon"></span>
                                <div class="event-header-name">When</div>
                                <div class="clear"></div>
                                <p class="event-sub-text">
                                    <?php $d = date_create($row['eventData']['eventDate']);
                                    echo date('h:i a',strtotime($row['eventData']['startTime'])).'-'.date('h:i a',strtotime($row['eventData']['endTime'])).' ,'. date_format($d,EVENT_INSIDE_DATE_FORMAT);?>
                                </p>
                            </div>

                            <!-- Host Section -->
                            <div class="event-descrip-wrapper">
                                <a href="tel:<?php echo $row['eventData']['creatorPhone']; ?>">
                                    <span class="ic_event_contact_icon my-right-event-icon"></span>
                                </a>
                                <div class="event-header-name">Host</div>
                                <div class="clear"></div>
                                <p class="event-sub-text">
                                    <?php echo $row['eventData']['creatorName']; ?>
                                </p>
                            </div>

                            <!-- Entry Section -->
                            <div class="event-descrip-wrapper">
                                <div class="event-header-name">Entry</div>
                                <p class="event-sub-text">
                                    <?php
                                    switch($row['eventData']['costType'])
                                    {
                                        case "1":
                                            echo "Free";
                                            break;
                                        case "2":
                                            echo 'Rs. '.$row['eventData']['eventPrice'];
                                            if(isset($row['eventData']['priceFreeStuff']) && isStringSet($row['eventData']['priceFreeStuff']))
                                            {
                                                echo ' + '.$row['eventData']['priceFreeStuff'];
                                            }
                                            break;
                                    }
                                    ?>
                                </p>
                            </div>

                            <!--<div class="list-block cards-list">
                                <ul>
                                    <li class="card">
                                        <div class="card-header">Where</div>
                                        <p class="color-gray">
                                           Doolally Taproom, <?php /*echo $row['eventData']['locData'][0]['locName'];*/?>
                                        </p>
                                        <i class="fa fa-map-marker pull-right"></i>
                                    </li>
                                    <li class="card">
                                        <div class="card-header">When</div>
                                        <p class="color-gray">
                                            <?php /*$d = date_create($row['eventData']['eventDate']);
                                            echo date('h:i a',strtotime($row['eventData']['startTime'])).'-'.date('h:i a',strtotime($row['eventData']['endTime'])).' ,'. date_format($d,EVENT_INSIDE_DATE_FORMAT);*/?>
                                        </p>
                                        <span class="ic_events_icon pull-right"></span>
                                    </li>
                                    <li class="card">
                                        <div class="card-header">Entry</div>
                                        <p class="color-gray">
                                            <?php
/*                                            switch($row['eventData']['costType'])
                                            {
                                                case "1":
                                                    echo "Free";
                                                    break;
                                                case "2":
                                                    echo 'Rs. '.$row['eventData']['eventPrice'];
                                                    if(isset($row['eventDate']['priceFreeStuff']) && isStringSet($row['eventDate']['priceFreeStuff']))
                                                    {
                                                        echo ' + '.$row['eventDate']['priceFreeStuff'];
                                                    }
                                                    break;
                                            }
                                            */?>
                                        </p>
                                    </li>
                                </ul>
                            </div>-->
                            <div class="row">
                                <div class="col-5"></div>
                                <div class="col-90">
                                    <?php
                                        if(isset($row['eventData']['eventPaymentLink']) && isStringSet($row['eventData']['eventPaymentLink']))
                                        {
                                            ?>
                                            <a href="<?php echo $row['eventData']['eventPaymentLink'];?>" class="button button-big button-fill book-event-btn external">Book Now </a>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <a href="#" class="button button-big button-fill book-event-btn" disabled>Book Now </a>
                                            <?php
                                        }
                                    ?>
                                </div>
                                <div class="col-5"></div>
                            </div>
                            <br>
                            <div class="bottom-share-panel">
                                <p class="event-share-text">
                                    Share "<?php echo $row['eventData']['eventName']; ?>"
                                </p>
                                <input type="hidden" id="shareLink" value="<?php echo $row['eventData']['eventShareLink'];?>"/>
                                <div id="share" class="my-social-share"></div>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    else
    {
        ?>
        <div class="navbar">
            <div class="navbar-inner">
                <div class="left">
                    <a href="#" class="back link">
                        <i class="icon icon-back"></i>
                        <span>Back</span>
                    </a>
                </div>
                <div class="center sliding">Nothing Found</div>
                <!--<div class="right">

                </div>-->
            </div>
        </div>
        <div class="pages">
            <div data-page="event" class="page">
                <div class="page-content">
                    <div class="content-block">
                        <p>No result Found!</p>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
?>
</body>
</html>