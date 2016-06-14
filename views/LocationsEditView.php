<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Location Edit :: Doolally</title>
	<?php echo $globalStyle; ?>
</head>
<body>
    <?php echo $headerView; ?>
    <main class="locationsAdd">
        <div class="container">
            <div class="row">
                <?php
                    if(isset($locInfo) && myIsArray($locInfo))
                    {
                        if($locInfo['status'] === true)
                        {
                            foreach($locInfo['locData'] as $key => $row)
                            {
                                if(isset($row['id']))
                                {
                                    ?>
                                    <h2><i class="fa fa-globe"></i> Edit Location <?php echo $row['locName'];?></h2>
                                    <hr>
                                    <br>
                                    <form id="locationsEdit-form" action="<?php echo base_url();?>locations/save" method="post" class="form-horizontal" role="form">
                                        <div class="location-status"></div>
                                        <input type="hidden" name="locUniqueLink" value="<?php echo $row['locUniqueLink'];?>"/>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="locName">Location Name :</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="locName" class="form-control"
                                                       value="<?php echo $row['locName'];?>" id="locName" placeholder="Eg. Malad"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                    <?php
                                }
                            }
                        }
                        else
                        {
                            echo '<h2 class="my-danger-text text-center>Location Not Found!</h2>"';
                        }
                    }
                ?>
            </div>
        </div>
    </main>
</body>
<?php echo $globalJs; ?>

</html>