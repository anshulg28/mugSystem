<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Mail Add :: Doolally</title>
	<?php echo $globalStyle; ?>
</head>
<body>
    <?php echo $headerView; ?>
    <main>
        <div class="container-fluid">
            <h1 class="text-center">Mail Template Add</h1>
            <hr>
            <form action="<?php echo base_url();?>mailers/saveMail" method="post" class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="mailsubject">Mail Subject:</label>
                    <div class="col-sm-10">
                        <input type="text" name="mailSubject" class="form-control" id="mailsubject" placeholder="Enter Mail Subject">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="mailbody">Mail Body:</label>
                    <div class="col-sm-10">
                        <textarea name="mailBody" class="form-control" id="mailbody" placeholder="Enter Mail Body"></textarea>
                    </div>
                </div>
                <input type="hidden" name="mailType" value="1"/>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </main>
</body>
<?php echo $globalJs; ?>
</html>