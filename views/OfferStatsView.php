<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Offers Stats :: Doolally</title>
	<?php echo $globalStyle; ?>
</head>
<body>
    <?php echo $headerView; ?>
    <main class="offerPage">
        <div class="container">
            <div class="row my-marginLR-zero">
                <div class="col-sm-9 col-xs-8">
                    <a href="<?php echo base_url().'offers';?>" class="btn btn-warning"><i class="fa fa-arrow-circle-o-left"></i> Go Back</a>
                </div>
            </div>
        </div>
        <br>
        <div class="container">
            <table id="main-mugclub-table" class="table table-hover table-bordered table-striped paginated">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Offer Code</th>
                    <th>Offer Type</th>
                    <th>Location</th>
                    <th>Created Date</th>
                    <th>Used Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <?php
                if(isset($offerCodes) && myIsArray($offerCodes))
                {
                    if($offerCodes['status'] === false)
                    {
                        ?>
                        <tbody>
                            <tr class="my-danger-text text-center">
                                <td colspan="6">No Data Found!</td>
                            </tr>
                        </tbody>
                        <?php
                    }
                    else
                    {
                        ?>
                        <tbody>
                        <?php
                            foreach($offerCodes['codes'] as $key => $row)
                            {
                                ?>
                                <tr class="<?php if($row['isRedeemed'] == 1) {echo 'danger';};?>">
                                    <th scope="row"><?php echo $row['id'];?></th>
                                    <td><?php echo 'DO-'.$row['offerCode'];?></td>
                                    <td><?php echo $row['offerType'];?></td>
                                    <td><?php echo $row['locName'];?></td>
                                    <td><?php echo $row['createDateTime'];?></td>
                                    <td><?php echo $row['useDateTime'];?></td>
                                    <td>
                                        <a data-toggle="tooltip" class="mugDelete-icon" title="Delete" data-offerId="<?php echo $row['id'];?>"
                                           data-offerCode= "<?php echo $row['offerCode'];?>">
                                            <i class="fa fa-trash-o"></i></a>&nbsp;
                                    </td>
                                </tr>
                                <?php
                            }
                        ?>
                        </tbody>
                        <?php
                    }
                }
                ?>
            </table>
        </div>
    </main>
</body>
<?php echo $globalJs; ?>

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
    $(document).on('click','.mugDelete-icon',function(){
        var locName = $(this).attr('data-offerCode');
        var locId = $(this).attr('data-offerId');
        bootbox.confirm("Are you sure you want to delete Offer Code "+locName+" ?", function(result) {
            if(result === true)
            {
                window.location.href='<?php echo base_url();?>offers/delete/'+locId;
            }
        });
    });

    $('#main-mugclub-table').DataTable();
</script>
</html>