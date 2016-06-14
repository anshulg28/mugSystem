<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Location Add :: Doolally</title>
	<?php echo $globalStyle; ?>
</head>
<body>
    <?php echo $headerView; ?>
    <main class="locationsAdd">
        <div class="container">
            <div class="row">
                <h2><i class="fa fa-globe"></i> Add New Locations</h2>
                <hr>
                <br>
                <form id="locationsAdd-form" action="<?php echo base_url();?>locations/save" method="post" class="form-horizontal" role="form">
                    <div class="location-status"></div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="locName">Location Name :</label>
                        <div class="col-sm-10">
                            <input type="text" name="locName" class="form-control"
                                    id="locName" placeholder="Eg. Malad"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
<?php echo $globalJs; ?>

<script>
    $(document).on('submit','#locationsAdd-form', function(e){
       e.preventDefault();
        if($('#locName').val() != '')
        {
            showCustomLoader();
            $.ajax({
                type:'get',
                dataType:'json',
                url:'<?php echo base_url();?>locations/checkLocationByUniqueLink/'+$('#locName').val(),
                success: function(data){
                    if(data.status === true)
                    {
                        hideCustomLoader();
                        $(this).submit();
                    }
                    else
                    {
                        hideCustomLoader();
                        $('.location-status').css('color','red').html(data.errorMsg);
                    }
                },
                error: function(){
                    hideCustomLoader();
                    $('.location-status').css('color','red').html('Some Error Occurred');
                }
            });

        }
        else
        {
            bootbox.alert('Please Provide Location Name');
        }

    });
    
</script>
</html>