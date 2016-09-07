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
                <form action="<?php echo base_url().'saveEvent';?>" method="post">
                    <div class="event-img-space">
                        <div class="event-img-before">
                            <input type="file" id="event-img-upload" onchange="uploadChange(this)" class="my-vanish"/>
                            <!--<a href="#" class="button event-img-add-btn">
                                <i class="ic_add"></i>
                            </a>-->
                            <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored event-img-add-btn">
                                <i class="ic_add"></i>
                            </button>
                            <p class="add-img-caption">Add a cover photo</p>
                        </div>
                        <div class="event-img-after hide">
                            <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored event-img-remove hide">
                                <i class="ic_add"></i>
                            </button>
                            <div class="progress-bar">
                                <div class="progressbar"></div>
                            </div>
                        </div>
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
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label my-fullWidth">
                            <input class="mdl-textfield__input" type="text" id="eventName" name="eventName" required>
                            <label class="mdl-textfield__label" for="eventName">Name of event</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label my-fullWidth">
                            <textarea class="mdl-textfield__input" type="text" rows= "3" id="eventDesc" name="eventDesc"></textarea>
                            <label class="mdl-textfield__label" for="eventDesc">Describe your event</label>
                        </div>
                        <select name="eventType" id="eventType" class="mdl-textfield__input">
                            <option value="" selected>Type of event</option>
                            <?php
                            foreach($this->config->item('eventTypes') as $key => $row)
                            {
                                ?>
                                <option value="<?php echo $row;?>"><?php echo $row;?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <br>
                        <select id="eventPlace" name="eventPlace" class="mdl-textfield__input" required>
                            <option value="">Location of event (max. 20 people)</option>
                            <?php
                            if(isset($locData))
                            {
                                foreach($locData as $key => $row)
                                {
                                    if(isset($row['id']))
                                    {
                                        ?>
                                        <option value="<?php echo $row['id'];?>"><?php echo $row['locName'];?></option>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                        <br>
                        <div class="row">
                            <div class="col-50">
                                <div class="input-group clockpicker" id="startTime">
                                    <input type="text" class="mdl-textfield__input" name="startTime" value="" placeholder="Start Time" readonly>
                                </div>
                            </div>
                            <div class="col-50">
                                <div class="input-group clockpicker" id="endTime">
                                    <input type="text" class="mdl-textfield__input" name="endTime" value="" placeholder="End Time" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="event-header-name">Is the event Free or Paid?</div>
                        <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="paidType">
                            <input type="radio" id="paidType" class="mdl-radio__button" name="costType" value="2" checked>
                            <span class="mdl-radio__label">Paid</span>
                        </label>
                        <p class="event-sub-text">For paid events, we charge Rs 250 per attendee which includes a pint or horse fries.</p>
                        <div class="row">
                            <div class="col-50">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label event-price">
                                    <input class="mdl-textfield__input" type="text" pattern="-?[0-9]*(\.[0-9]+)?" id="eventPrice">
                                    <label class="mdl-textfield__label" for="eventPrice">Event Fee</label>
                                    <span class="mdl-textfield__error">Input is not a number!</span>
                                </div>
                            </div>
                            <div class="col-50">
                                <p class="event-sub-text">+ Rs. 250 Doolally Fee</p>
                            </div>
                        </div>
                        <div class="event-header-name">Total Price: Rs. <span class="total-event-price">250</span></div>
                        <input type="hidden" name="eventPrice" value="250"/>
                        <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="freeType">
                            <input type="radio" id="freeType" class="mdl-radio__button" name="costType" value="1">
                            <span class="mdl-radio__label">Free</span>
                        </label>
                        <p class="event-sub-text">If you don't charge, we don't charge</p>
                        <div class="event-header-name">Your details</div>
                        <p class="event-sub-text">We'll contact you while we curate your event.</p>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label my-fullWidth">
                            <input class="mdl-textfield__input" type="text" name="creatorName" id="creatorName" required>
                            <label class="mdl-textfield__label" for="creatorName">Name</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label my-fullWidth">
                            <input class="mdl-textfield__input" type="number" name="creatorPhone" id="creatorPhone" required>
                            <label class="mdl-textfield__label" for="creatorPhone">Phone Number</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label my-fullWidth">
                            <input class="mdl-textfield__input" type="email" name="creatorEmail" id="creatorEmail" required>
                            <label class="mdl-textfield__label" for="creatorEmail">Email ID</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label my-fullWidth">
                            <textarea class="mdl-textfield__input" type="text" rows= "3" id="aboutCreator" name="aboutCreator"></textarea>
                            <label class="mdl-textfield__label" for="aboutCreator">Something about yourself (Optional)</label>
                        </div>
                        <div class="event-header-name">
                            All events are curated and approved by Doolally. Once approved, we will create an Instamojo payment link and
                            accept payments on your behalf.
                        </div>
                        <hr>
                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="tnc">
                            <input type="checkbox" id="tnc" value="1" class="mdl-checkbox__input">
                            <span class="mdl-checkbox__label">I have read and agree to the
                                <a href="#">Terms and Conditions.</a>
                            </span>
                        </label>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-5"></div>
                        <div class="col-90">
                            <a href="#" type="submit" class="button button-big button-fill submit-event-btn">Create Event </a>
                        </div>
                        <div class="col-5"></div>
                    </div>
                    <br>
                </form>
            </div>
        </div>
    </div>
</div>

</body>

</html>