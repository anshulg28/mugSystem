<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Press Mail :: Doolally</title>
	<?php echo $globalStyle; ?>
</head>
<body>
    <?php echo $headerView; ?>
    <main class="mailPage">
        <div class="container-fluid">
            <div class="row">
                <h2 class="text-center">Send Mail</h2>
                <br>
                <div class="col-sm-1 col-xs-0"></div>
                <div class="col-sm-10 col-xs-12 mail-content text-center">
                    <div class="row">
                        <?php
                        $mailTypes = array();
                            if(!isset($pressMails))
                            {
                                echo 'No Press Mails Found!';
                            }
                            else
                            {
                                ?>
                                <nav class="col-sm-4">
                                    <ul class="nav nav-pills nav-stacked text-left custom-mugs-list">
                                        <?php
                                            foreach($pressMails as $key => $row)
                                            {
                                                switch ($row['pressMailType'])
                                                {
                                                    case 0:
                                                        ?>
                                                        <li>
                                                            <label class="my-pointer-item" for="<?php echo $row['id'];?>_press">
                                                                <input type="checkbox" id="<?php echo $row['id'];?>_press" class="mugCheckList"
                                                                       data-pressEmail="<?php echo $row['pressEmail'];?>" />
                                                                <?php
                                                                if(isset($row['publication']) && $row['publication'] != '')
                                                                {
                                                                    echo $row['publication'].'-'.$row['pressEmail'];
                                                                }
                                                                elseif(isset($row['pressName']) && $row['pressName'] != '')
                                                                {
                                                                    echo $row['pressName'].'-'.$row['pressEmail'];
                                                                }
                                                                else
                                                                {
                                                                    echo $row['pressEmail'];
                                                                }
                                                                ?>
                                                            </label>
                                                        </li>
                                                        <?php
                                                        break;
                                                    case 1:
                                                        $mailTypes['food'][] = $row['pressEmail'];
                                                        break;
                                                    case 2:
                                                        $mailTypes['games'][] = $row['pressEmail'];
                                                        break;
                                                    case 3:
                                                        $mailTypes['craft'][] = $row['pressEmail'];
                                                        break;
                                                    case 4:
                                                        $mailTypes['events'][] = $row['pressEmail'];
                                                        break;
                                                    case 5:
                                                        $mailTypes['reviews'][] = $row['pressEmail'];
                                                        break;
                                                    case 6:
                                                        $mailTypes['tech'][] = $row['pressEmail'];
                                                        break;
                                                    case 7:
                                                        $mailTypes['workshops'][] = $row['pressEmail'];
                                                        break;
                                                }
                                            }
                                        ?>
                                    </ul>
                                    <br>
                                    <ul class="nav nav-pills nav-stacked text-left custom-mugs-list">
                                        <?php
                                        foreach($mailTypes as $key => $row)
                                        {
                                            if(myIsArray($row))
                                            {
                                                $combinedEmails = implode(',',$row);
                                                ?>
                                                <li>
                                                    <label class="my-pointer-item" for="<?php echo $key;?>_press">
                                                        <input type="checkbox" id="<?php echo $key;?>_press" class="mugCheckList"
                                                               data-pressEmail="<?php echo $combinedEmails;?>" />
                                                        <?php
                                                            echo ucfirst($key);
                                                        ?>
                                                    </label>
                                                </li>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </nav>
                                <div class="col-sm-8">
                                    <form action="<?php echo base_url();?>mailers/sendPressMails/json" id="mainMailerForm" method="post" class="form-horizontal" role="form">
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="toList">To:</label>
                                            <div class="col-sm-10">
                                                <div class="row">
                                                    <div class="col-xs-11">
                                                        <textarea class="form-control" name="pressEmails" id="toList" placeholder="Email Id(s) (comma separated)"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <!--<button type="button" class="btn btn-danger col-sm-2 my-marginDown" data-toggle="modal" data-target="#subjectModal" >Select Subject</button>-->
                                            <div class="col-sm-2"></div>
                                            <div class="col-sm-10">
                                                <input type="text" name="mailSubject" class="form-control" onfocus="whichHasFocus= 1" id="mailSubject" placeholder="Subject">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <!--<button type="button" class="btn btn-danger col-sm-2 my-marginDown" data-toggle="modal" data-target="#bodyModal" >Select Body</button>-->
                                            <div class="col-sm-2"></div>
                                            <div class="col-sm-10">
                                                <textarea name="mailBody" rows="10" class="form-control" onfocus="whichHasFocus= 2" id="mailBody" placeholder="Body"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>

                                    <div>
                                        <p>Available Tags:</p>
                                        <div class="col-sm-2"></div>
                                        <ul class="col-sm-10 list-inline mugtags-list">
                                            <li class="my-pointer-item"><span class="label label-success">[name]</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <?php
                            }
                        ?>
                    </div>
                </div>
                <div class="col-sm-1 col-xs-0"></div>
            </div>
        </div>

    </main>
    <?php echo $footerView; ?>
</body>
<?php echo $globalJs; ?>

<script>
    var whichHasFocus = 0;
    $(document).on('submit','#mainMailerForm',function(e){
        e.preventDefault();
        if($('textarea[name="pressEmails"]').val() == '')
        {
            bootbox.alert('Email(s) Are Required!',function(){
                $('textarea[name="pressEmails"]').focus();
            });
            return false;
        }

        if($('input[name="mailSubject"]').val() == '')
        {
            bootbox.alert('Subject is Required!',function(){
                $('input[name="mailSubject"]').focus();
            });
            return false;
        }
        if($('textarea[name="mailBody"]').val() == '')
        {
            bootbox.alert('Body is Required!',function(){
                $('textarea[name="mailBody"]').focus();
            });
            return false;
        }

        showCustomLoader();
        $.ajax({
            type:"POST",
            url:$(this).attr('action'),
            dataType:"json",
            data:$(this).serialize(),
            success: function(data){
                hideCustomLoader();
                if(data.status === true)
                {
                    bootbox.alert('Mail Send Successfully', function(){
                        window.location.href=base_url+'mailers';
                    });
                }
            },
            error: function(){
                hideCustomLoader();
                bootbox.alert('Some Error occurred');
            }
        });

    });
    

    $(document).on('change', '.mugCheckList', function(){
        var emails= '';
        $('.mugCheckList:checked').each(function(i,val){
            emails += $(val).attr('data-pressEmail').trim();
            if(i != $('.mugCheckList:checked').length-1)
            {
                emails += ',';
            }
        });
        $('.mailPage #toList').empty().append(emails);
    });

    $(document).on('click','.mugtags-list li', function(){
        var mugTag = $(this).find('span').html();

        if(whichHasFocus == 1)
        {
            $('input[name="mailSubject"]').val($('input[name="mailSubject"]').val()+mugTag);
        }
        else if(whichHasFocus == 2)
        {
            $('textarea[name="mailBody"]').append(mugTag);
        }

    });
</script>

</html>