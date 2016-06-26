<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Offer Validation :: Doolally</title>
	<?php echo $globalStyle; ?>
</head>
<body>
    <?php echo $headerView; ?>
    <main class="offerPage">
        <div class="container">
            <div class="row my-marginLR-zero">
                <h2 class="text-center">Offer Validator</h2>
                <br>
                <div class="col-sm-2 col-xs-1"></div>
                <div class="col-sm-8 col-xs-10">
                    <div class="form-group my-marginLR-zero">
                        <div class="col-sm-1 col-xs-0"></div>
                        <div class="col-sm-10 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon">DO-</span>
                                <input type="number" name="offerCode" id="offerCode"
                                       class="form-control" placeholder="11111">
                            </div>
                        </div>
                        <div class="col-sm-1 col-xs-0"></div>
                    </div>
                    <br><br>
                    <div class="form-group my-marginLR-zero">
                        <div class="col-sm-12 col-xs-12 text-center">
                            <button type="button" class="btn btn-primary offerCheck-btn">Verify</button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2 col-xs-1"></div>
            </div>
        </div>
    </main>
</body>
<?php echo $globalJs; ?>

<script>


    $(document).on('click','.offerCheck-btn',function(){

        var mugNum = $('#offerCode').val();
        if(mugNum != '')
        {
            showCustomLoader();
            //send ajax request to check mobile number
            $.ajax({
                type:"GET",
                dataType:"json",
                url:base_url+'offers/offerCheck/'+mugNum,
                success: function(data)
                {
                    hideCustomLoader();
                    if(data.status === true)
                    {
                        bootbox.alert('Code is valid for <label class="my-success-text">'+data.offerType+'</label>');
                    }
                    else
                    {
                        bootbox.alert('<label class="my-danger-text">'+data.errorMsg+'</label>');
                    }
                },
                error: function()
                {
                    hideCustomLoader();
                    bootbox.alert('Unable To Connect To Server!');
                }
            });
        }
        else
        {
            bootbox.alert('Please Provide Offer Code!');
        }
    });

    $(document).on('keypress','#offerCode', function(event){

        var keycode = (event.keyCode ? event.keyCode : event.which);

        if(keycode == 45)
        {
           return false;
        }
        if(keycode == 13)
        {
            $('.offerCheck-btn').trigger('click');
        }
    });

</script>
</html>