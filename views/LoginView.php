<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Login :: Doolally</title>
	<?php echo $globalStyle; ?>
</head>
<body>
    <?php echo $headerView; ?>
    <main>
        <div class="container-fluid">
            <form action="<?php echo base_url();?>login/checkUser" method="post">
                    
            </form>
        </div>
    </main>
</body>
<?php echo $globalJs; ?>
</html>