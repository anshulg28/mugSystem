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
                <div class="form-group">
                    <label class="control-label col-sm-2">Mail Type:</label>
                    <div class="col-sm-10">
                        <label for="is_expired">
                            <input type="radio" id="is_expired" name="mailType" value="1">
                            Expired Mail
                        </label>
                        <br>
                        <label for="is_expiring">
                            <input type="radio" id="is_expiring" name="mailType" value="2">
                            Expiring Mail
                        </label>
                        <br>
                        <label for="is_birthday">
                            <input type="radio" id="is_birthday" name="mailType" value="3">
                            Birthday Mail
                        </label>
                        <br>
                        <label for="is_custom">
                            <input type="radio" id="is_custom" name="mailType" value="0">
                            Others
                        </label>
                    </div>
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