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
                            <h4 class="text-center">OR</h4>
                            <div class="input-group">
                                <span class="input-group-addon">BR-</span>
                                <input type="number" name="breakOfferCode" id="breakOfferCode"
                                       class="form-control" placeholder="11111">
                            </div>
                            <h4 class="text-center">OR</h4>
                            <div class="input-group">
                                <span class="input-group-addon">TW-</span>
                                <input type="number" name="oldOfferCode" id="oldOfferCode"
                                       class="form-control" placeholder="11111">
                            </div>
                        </div>
                        <div class="col-sm-1 col-xs-0"></div>
                    </div>
                    <br><br>
                    <div class="form-group my-marginLR-zero">
                        <div class="col-sm-12 col-xs-12 text-center my-marginUp">
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

        var newOffer = $('#offerCode').val();
        var oldOffer = $('#oldOfferCode').val();
        var breakOffer = $('#breakOfferCode').val();
        var offerUrl,offerPrifix,finalCode;
        if(newOffer != '' && oldOffer != '' && breakOffer != '')
        {
            bootbox.alert('Enter Only 1 Code!');
            return false;
        }
        if(newOffer == '' && oldOffer == '' && breakOffer == '')
        {
            bootbox.alert('Please Provide Offer Code!');
            return false;
        }
        if(newOffer != '')
        {
            finalCode = newOffer;
            offerUrl = base_url+'offers/offerCheck/'+newOffer;
            offerPrifix = 'DO';
        }
        else if(breakOffer != '')
        {
            finalCode = breakOffer;
            offerUrl = base_url+'offers/offerCheck/'+breakOffer;
            offerPrifix = 'BR';
        }
        else if(oldOffer != '')
        {
            finalCode = oldOffer;
            offerUrl = base_url+'offers/oldOfferCheck/'+oldOffer;
            offerPrifix = 'TW';
        }
        bootbox.confirm("Sure you want to Redeem "+offerPrifix+"-"+finalCode+" ?", function(result) {
            if(result === true)
            {
                showCustomLoader();
                //send ajax request to check mobile number
                $.ajax({
                    type:"GET",
                    dataType:"json",
                    url:offerUrl,
                    success: function(data)
                    {
                        hideCustomLoader();
                        if(data.status === true)
                        {
                            if(data.offerType == 'Beer')
                            {
                                bootbox.alert('<label class="my-success-text">Congrats, you get a 330ml Beer! Mug Club members get 500ml</label>');
                            }
                            else if(data.offerType == 'Breakfast2')
                            {
                                bootbox.alert('<label class="my-success-text">Congrats, you get Two Breakfasts. This includes Two pint. </label>');
                            }
                            else if(data.offerType == 'Breakfast')
                            {
                                bootbox.alert('<label class="my-success-text">Congrats, you get a Breakfast. This includes one pint. </label>');
                            }
                            else
                            {
                                bootbox.alert('<label class="my-success-text">Success, '+data.offerType+' </label>');
                            }

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
        });

    });

    $(document).on('keypress','#offerCode,#oldOfferCode', function(event){

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