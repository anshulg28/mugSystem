<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Mug Club :: Doolally</title>
	<?php echo $globalStyle; ?>
</head>
<body>
    <?php echo $headerView; ?>
    <main class="mugClub">
        <div class="container">
            <div class="row">
                <h2><i class="fa fa-beer fa-1x"></i> Add New Mug</h2>
                <hr>
                <br>
                <form action="<?php echo base_url();?>mugclub/save" id="mugNumSave-form" method="post" class="form-horizontal" role="form">
                    <div class="mugNumber-status text-center"></div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="mugNum">Mug No. :</label>
                        <div class="col-sm-10">
                            <input type="number" name="mugNum" class="form-control" id="mugNum" placeholder="Eg. 100" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="mugTag">Mug Tag:</label>
                        <div class="col-sm-10">
                            <input type="text" name="mugTag" class="form-control" id="mugTag" placeholder="Eg. ABC">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="homeBase">HomeBase:</label>
                        <div class="col-sm-10">
                            <?php
                                if(isset($baseLocations))
                                {
                                    ?>
                                    <select class="form-control" name="baseLocation">
                                        <?php
                                        foreach($baseLocations as $key => $row)
                                        {
                                            ?>
                                            <option value="<?php echo $row['id'];?>"><?php echo $row['locName'];?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                        <?php
                                }
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="firstName">First Name:</label>
                        <div class="col-sm-10">
                            <input type="text" name="firstName" class="form-control" id="firstName" placeholder="Eg. John" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="lastName">Last Name:</label>
                        <div class="col-sm-10">
                            <input type="text" name="lastName" class="form-control" id="lastName" placeholder="Eg. Doe">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="mobNum">Mobile No. :</label>
                        <div class="col-sm-10">
                            <input type="number" name="mobNum" maxlength="10" oninput="maxLengthCheck(this)" class="form-control" id="mobNum" placeholder="Eg. 9876543210" required>
                            <div class="mobile-verification-holder"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="email">Email:</label>
                        <div class="col-sm-10">
                            <input type="email" name="emailId" class="form-control" id="email" placeholder="Eg. abc@gmail.com" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="bdate">BirthDate:</label>
                        <div class="col-sm-10">
                            <input type="date" name="birthdate" class="form-control" id="bdate" placeholder="Eg. 12 June 1990">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="invoiceDate">Invoice Date:</label>
                        <div class="col-sm-10">
                            <input type="date" name="invoiceDate" class="form-control" id="invoiceDate" placeholder="Eg. 12 June 2016">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="invoiceNo">Invoice No. :</label>
                        <div class="col-sm-10">
                            <input type="text" name="invoiceNo"
                                   class="form-control" id="invoiceNo" placeholder="Eg. L-50" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="invoiceAmt">Invoice Amount:</label>
                        <div class="col-sm-10">
                            <input type="number" name="invoiceAmt"
                                   class="form-control" id="invoiceAmt" placeholder="Eg. 3000">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="memberS">Membership Start Date:</label>
                        <div class="col-sm-10">
                            <input type="date" name="memberS"
                                   class="form-control" id="memberS" placeholder="Eg. 12 June 2016">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="memberE">Membership End Date:</label>
                        <div class="col-sm-10">
                            <input type="date" name="memberE"
                                   class="form-control" id="memberE" placeholder="Eg. 12 June 2016">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="mugNotes">Notes:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="mugNotes" id="mugNotes" rows="5" placeholder="Eg. Anshul's Friend"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <label class="control-label" for="mugMail">
                                <input type="checkbox" name="ifMail" id="mugMail" value="1" />
                                Send Confirmation E-Mail?
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-success">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
<?php echo $globalJs; ?>

<script>
    var mugVerified = 0;
    var mobileVerified = 0;
    $(document).on('focusout','#mugNum', function(){
        if($(this).val() != '')
        {
            var mugNo = $(this).val();
            $('.mugNumber-status').empty();

            $.ajax({
                type:'get',
                dataType:'json',
                url:'<?php echo base_url();?>mugclub/MugAvailability/json/'+mugNo,
                success: function(data){
                    if(data.status === true)
                    {
                        $('.mugNumber-status').css('color','green').html('Mug Number is Available');
                        mugVerified = 1;
                        if(mobileVerified == 1)
                        {
                            $('form button[type="submit"]').removeAttr('disabled');
                        }
                    }
                    else
                    {
                        $('.mugNumber-status').css('color','red').html(data.errorMsg);
                        mugVerified = 0;
                        $('form button[type="submit"]').attr('disabled','true');
                    }
                },
                error: function(){
                    $('.mugNumber-status').css('color','red').html('Some Error Occurred');
                }
            });
        }
        else
        {
            $('.mugNumber-status').empty();
        }
    });

    $(document).on('focusout','#mobNum', function(){
        if($(this).val() != '')
        {
            var mobNo = $(this).val();
            $('.mobile-verification-holder').empty();

            $.ajax({
                type:'get',
                dataType:'json',
                url:'<?php echo base_url();?>mugclub/CheckMobileNumber/json/'+mobNo,
                success: function(data){
                    if(data.status === true)
                    {
                        $('.mobile-verification-holder').css('color','green').html('Mobile Number is Available');
                        mobileVerified = 1;
                        if(mugVerified == 1)
                        {
                            $('form button[type="submit"]').removeAttr('disabled');
                        }
                    }
                    else
                    {
                        $('.mobile-verification-holder').css('color','red').html(data.errorMsg);
                        mobileVerified = 0;
                        $('form button[type="submit"]').attr('disabled','true');
                    }
                },
                error: function(){
                    $('.mobile-verification-holder  ').css('color','red').html('Some Error Occurred');
                }
            });
        }
        else
        {
            $('.mobile-verification-holder').empty();
        }
    });
    function maxLengthCheck(object)
    {
        if (object.value.length > object.maxLength)
            object.value = object.value.slice(0, object.maxLength)
    }

    $(document).ready(function(){
        $('form button[type="submit"]').attr('disabled','true');
    });
    
</script>
</html>