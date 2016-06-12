<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Location :: Doolally</title>
	<?php echo $globalStyle; ?>
</head>
<body>
    <?php echo $headerView; ?>
    <main class="locSelectPage">
        <div class="container-fluid">
            <div class="row">
                <h2 class="text-center">Select Your Location</h2>
                <br>

                <form id="locationForm" method="post" action="<?php echo base_url().'home/setLocation';?>">
                    <div class="col-sm-12 text-center">
                        <ul class="list-inline my-mainMenuList">
                            <li>
                                <input type="radio" name="currentLoc" onchange="submitLocation()" id="andheri" value="2" />
                                <label for="andheri">
                                    <i class="glyphicon glyphicon-map-marker fa-5x"></i>
                                    <br>
                                    <span>Andheri</span>
                                </label>
                            </li>
                            <li>
                                <input type="radio" name="currentLoc" onchange="submitLocation()" id="bandra" value="1" />
                                <label for="bandra">
                                    <i class="glyphicon glyphicon-map-marker fa-5x"></i>
                                    <br>
                                    <span>Bandra</span>
                                </label>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
<?php echo $globalJs; ?>
<script>
    function submitLocation()
    {
        $('#locationForm').submit();
    }
</script>
</html>