<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0056)file:///C:/Users/user1/Desktop/Emails/welcome-email.html -->
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Event Approve</title>
</head>

<body>
    <p>Dear <?php echo $mailData[0]['creatorName'] ?>,</p>
    <p>
        1. Your event has been approved! Here's a link to your event - <?php echo $mailData[0]['eventShareLink'] ?><br><br>
        2. Additionally, as an organiser, you are expected:<br>
        &nbsp;&nbsp;To set up and manage the ticket counter for any ticketed events.<br>
        &nbsp;&nbsp;To chip in with the arrangements of the event.<br>
        &nbsp;&nbsp;To have visited the venue prior to the event.<br>
        &nbsp;&nbsp;To arrive at the venue at least 45 minutes before the scheduled time of the event.<br><br>

        3. For paid events, we will collect money from the customer on your behalf. This is to ensure complete refund in case of cancelled events.
        Instamojo is our payment partner. Please check out their credentials here - www.instamojo.com<br><br>

        4. You can access your events from your <a href="<?php echo base_url().'mobile?page/event_dash';?>" target="_blank">Event Dashboard</a>. Your dashboard is a place where information on the number of sign ups, fees collected, payout details will be available to you. You can also edit your event or cancel your event from this dashboard.<br><br>

        5. For events below 5000, organisers will be reimbursed by cash on the day of the event. For events greater than 5000, we will hand over a cheque in the name of organiser.<br><br>
        All the best for your event, in case you have any questions/queries please don't hesitate to write to me at this mail address or you can reach me at 9820570311 (tresha) 7045170006 (shweta) 9920087855(priyanka) 9892110655 (daksha).<br><br>

        In case you have any questions/queries please don't hesitate to write to me at this mail address or you can reach me at
        <?php echo $mailData['senderPhone'] .' ('.$mailData['senderName'].')';?><br><br>

        Cheers!
        <?php echo $mailData['senderName']; ?>
    </p>

</body>
</html>