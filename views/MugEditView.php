<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Mug Club Edit :: Doolally</title>
	<?php echo $globalStyle; ?>
</head>
<body>
    <?php echo $headerView; ?>
    <main class="mugClub">
        <div class="container">
            <div class="row">
                <?php
                    if(isset($mugInfo) && myIsArray($mugInfo))
                    {
                        if($mugInfo['status'] === true)
                        {
                            foreach($mugInfo['mugList'] as $key => $row)
                            {
                                if(isset($row['mugId']))
                                {
                                    ?>
                                    <h2><i class="fa fa-beer fa-1x"></i> Edit Mug #<?php echo $row['mugId'];?></h2>
                                    <hr>
                                    <br>
                                    <form action="<?php echo base_url();?>mugclub/save" method="post" class="form-horizontal" role="form">
                                        <div class="mugNumber-status text-center"></div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="mugNum">Mug No. :</label>
                                            <div class="col-sm-10">
                                                <input type="number" name="mugNum" class="form-control"
                                                       value="<?php echo $row['mugId'];?>" id="mugNum" placeholder="Eg. 100" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="mugTag">Mug Tag:</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="mugTag" value="<?php echo $row['mugTag'];?>"
                                                       class="form-control" id="mugTag" placeholder="Eg. ABC">
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
                                                        foreach($baseLocations as $lockey => $locrow)
                                                        {
                                                            ?>
                                                            <option value="<?php echo $locrow['id'];?>" <?php if($row['homeBase'] == $locrow['id'] ){echo 'selected';}?>>
                                                                <?php echo $locrow['locName'];?>
                                                            </option>
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
                                                <input type="text" name="firstName" value="<?php echo $row['firstName'];?>"
                                                       class="form-control" id="firstName" placeholder="Eg. John">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="lastName">Last Name:</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="lastName" value="<?php echo $row['lastName'];?>"
                                                       class="form-control" id="lastName" placeholder="Eg. Doe">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="mobNum">Mobile No. :</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="mobNum" value="<?php echo $row['mobileNo'];?>"
                                                       class="form-control" id="mobNum" placeholder="Eg. 9876543210">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="email">Email:</label>
                                            <div class="col-sm-10">
                                                <input type="email" name="emailId" value="<?php echo $row['emailId'];?>"
                                                       class="form-control" id="email" placeholder="Eg. abc@gmail.com">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="bdate">BirthDate:</label>
                                            <div class="col-sm-10">
                                                <input type="date" name="birthdate" value="<?php echo $row['birthDate'];?>"
                                                       class="form-control" id="bdate" placeholder="Eg. 12 June 1990">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="invoiceDate">Invoice Date:</label>
                                            <div class="col-sm-10">
                                                <input type="date" name="invoiceDate" value="<?php echo $row['invoiceDate'];?>"
                                                       class="form-control" id="invoiceDate" placeholder="Eg. 12 June 2016">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="invoiceNo">Invoice No. :</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="invoiceNo" value="<?php echo $row['invoiceNo'];?>"
                                                       class="form-control" id="invoiceNo" placeholder="Eg. L-50">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="invoiceAmt">Invoice Amount:</label>
                                            <div class="col-sm-10">
                                                <input type="number" name="invoiceAmt" value="<?php echo $row['invoiceAmt'];?>"
                                                       class="form-control" id="invoiceAmt" placeholder="Eg. 3000">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="memberS">Membership Start Date:</label>
                                            <div class="col-sm-10">
                                                <input type="date" name="memberS" value="<?php echo $row['membershipStart'];?>"
                                                       class="form-control" id="memberS" placeholder="Eg. 12 June 2016">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="memberE">Membership End Date:</label>
                                            <div class="col-sm-10">
                                                <input type="date" name="memberE" value="<?php echo $row['membershipEnd'];?>"
                                                       class="form-control" id="memberE" placeholder="Eg. 12 June 2016">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="mugNotes">Notes:</label>
                                            <div class="col-sm-10">
                                                <textarea name="mugNotes" id="mugNotes" rows="5" placeholder="Eg. Anshul's Friend"><?php echo trim($row['notes']);?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-2"></div>
                                            <div class="col-sm-10">
                                                <label class="control-label" for="mugMail">
                                                    <input type="checkbox" name="ifMail" id="mugMail" value="1" />
                                                    Resend Confirmation E-Mail?
                                                </label>
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
                            echo '<h2 class="my-danger-text text-center>Mug Number Not Found!</h2>"';
                        }
                    }
                ?>
            </div>
        </div>
    </main>
</body>
<?php echo $globalJs; ?>

</html>