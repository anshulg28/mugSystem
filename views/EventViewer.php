<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $eventDetails[0]['eventData']['eventName'];?></title>
	<?php echo $globalStyle; ?>
</head>
<body>
    <?php echo $headerView; ?>
    <main class="eventViewer">
        <div class="container">
            <div class="row">
                <div class="col-sm-2 col-xs-0"></div>
                <div class="col-sm-8 col-xs-12">
                <?php
                    if(isset($eventDetails) && myIsArray($eventDetails))
                    {
                        foreach($eventDetails as $key => $row)
                        {
                            if(isset($row['eventData']['eventId']))
                            {
                                ?>
                                <h2><i class="fa fa-calendar fa-1x"></i> <?php echo $row['eventData']['eventName'];?></h2>
                                <hr>
                                <div class="content-block event-wrapper">
                                    <?php
                                    if(isset($row['eventAtt']) && myIsMultiArray($row['eventAtt']))
                                    {
                                        ?>
                                        <img src="<?php echo base_url().EVENT_PATH_THUMB.$row['eventAtt'][0]['filename'];?>" class="img-responsive event-img"/>
                                        <?php
                                    }
                                    ?>
                                    <br>
                                    <!--<div class="event-header-name"><?php /*echo $row['eventData']['eventName'];*/?></div>-->
                                    <blockquote><?php echo strip_tags($row['eventData']['eventDescription'],'<br>');?></blockquote>
                                    <!--<hr class="card-ptag">-->
                                    <!-- Where section -->
                                    <div class="event-descrip-wrapper">
                                        <i class="fa fa-map-marker my-right-event-icon fa-15x"></i>
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
                                <?php
                            }
                        }
                    }
                    else
                    {
                        echo '<h2 class="my-danger-text text-center>Event Not Found!</h2>"';
                    }
                ?>
                </div>
                <div class="col-sm-2 col-xs-0"></div>
            </div>
        </div>
    </main>
</body>
<?php echo $globalJs; ?>

</html>