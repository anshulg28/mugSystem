<!DOCTYPE html>
<html lang="en">

<body>
<!-- Status bar overlay for full screen mode (PhoneGap) -->
<!-- Top Navbar-->
<div class="navbar">
    <div class="navbar-inner">
        <div class="left">
            <a href="#" class="back link" data-ignore-cache="true">
                <i class="fa fa-arrow-left color-black"></i>
            </a>
        </div>
        <!--<div class="center sliding"><?php /*echo $row['eventData']['eventName'];*/?></div>-->
        <!--<div class="right">

        </div>-->
    </div>
</div>
<div class="pages">
    <div data-page="eventAdd" class="page event-add">
        <div class="page-content">
            <div class="content-block event-wrapper">
                <div class="event-img-space">
                    <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored event-img-add-btn">
                        <i class="ic_add"></i>
                    </button>
                    <p class="add-img-caption">Add a cover photo</p>
                </div>
                <br>
                <div class="event-descrip-wrapper">
                    <div class="event-header-name">Create an event</div>
                    <p class="event-sub-text">To organise an event, please read the event guidelines and then fill up the form.</p>
                    <div class="row">
                        <div class="col-5"></div>
                        <div class="col-90">
                            <div class="hide" id="event-guide"><?php echo $eventTc;?></div>
                            <a href="#" class="button button-big button-fill book-event-btn">
                                <i class="material-icons info-icon">info_outline</i> Read Event Guidelines
                            </a>
                        </div>
                        <div class="col-5"></div>
                    </div>
                </div>
                <div class="event-header-name">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input" type="text" id="eventName" name="eventName" required>
                        <label class="mdl-textfield__label" for="eventName">Name of event</label>
                    </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <textarea class="mdl-textfield__input" type="text" rows= "3" id="eventDesc"></textarea>
                        <label class="mdl-textfield__label" for="eventDesc">Describe your event</label>
                    </div>
                    <select name="eventType" id="eventType" class="mdl-textfield__input">
                        <option value="" selected>Event Type</option>
                        <?php
                        foreach($this->config->item('eventTypes') as $key => $row)
                        {
                            ?>
                            <option value="<?php echo $row;?>"><?php echo $row;?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="row">
                    <div class="col-5"></div>
                    <div class="col-90">
                        <a href="#" class="button button-big button-fill book-event-btn">Create Event </a>
                    </div>
                    <div class="col-5"></div>
                </div>
                <br>
            </div>
        </div>
    </div>
</div>

</body>

</html>