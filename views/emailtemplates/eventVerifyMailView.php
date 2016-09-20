<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0056)file:///C:/Users/user1/Desktop/Emails/welcome-email.html -->
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Event Creation</title>
</head>

<body>
    <p>Event Detail:</p>
    <p>
        Event Name: <?php echo $mailData['eventName'];?><br>
        Event description: <?php echo $mailData['eventDescription'];?><br>
        Event Date: <?php echo $mailData['eventDate'];?><br>
        Event Time: <?php echo $mailData['startTime'] .' - '.$mailData['endTime'];?><br>
        Event Price:
        <?php
            if($mailData['costType'] == '1')
            {
                echo 'Free';
            }
            else
            {
                echo $mailData['eventPrice'];
            }
        ?><br>
        Event Place: <?php echo $mailData['locData'][0]['locName'];?><br>
        Organiser Name: <?php echo $mailData['creatorName'];?><br>
        Organiser Phone: <?php echo $mailData['creatorPhone'];?><br>
        Organiser Email: <?php echo $mailData['creatorEmail'];?><br><br>

        <a href="<?php echo base_url().'dashboard/eventEmailApprove/'.$mailData['eventId'];?>"
        style="text-decoration: none;border: 2px solid #000;padding: 5px;border-radius: 5px;color:green;">Approve Event</a>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="<?php echo base_url().'dashboard/eventEmailDecline/'.$mailData['eventId'];?>"
           style="text-decoration: none;border: 2px solid #000;padding: 5px;border-radius: 5px;color:red;">Decline Event</a>
    </p>

</body>
</html>