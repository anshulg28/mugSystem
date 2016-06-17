<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Mug Check-In :: Doolally</title>
	<?php echo $globalStyle; ?>
</head>
<body>
    <?php echo $headerView; ?>
    <main class="mugClub">
        <div class="container">
            <div class="row">
                <div class="col-sm-9 col-xs-8">
                    <a class="btn btn-primary" href="<?php echo base_url().'check-ins/add';?>">
                    <i class="fa fa-plus"></i>
                    New Check-In</a>
                    <ul class="list-inline pagination-List">
                        <li>
                            <label class="control-label" for="pageEntry">Show</label>
                        </li>
                        <li>
                            <select id="pageEntry" onchange="changePagination(this)" class="form-control">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </li>
                        <li>
                            <label class="control-label" for="pageEntry">entries</label>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-3 col-xs-4">
                    <input type="text" placeholder="Search" class="form-control my-searchField"/>
                </div>
            </div>
        </div>
        <br>
        <div class="container">
            <table class="table table-hover table-bordered table-striped paginated">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Mug #</th>
                    <th>Location</th>
                    <th>Date & Time</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <?php
                if(isset($mugData) && myIsArray($mugData))
                {
                    if($mugData['status'] === false)
                    {
                        ?>
                        <tbody>
                            <tr class="my-danger-text text-center">
                                <td colspan="5">No Today Check-Ins!</td>
                            </tr>
                        </tbody>
                        <?php
                    }
                    else
                    {
                        ?>
                        <tbody>
                        <?php
                            foreach($mugData['checkInList'] as $key => $row)
                            {
                                if(isset($row['id']))
                                {
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $row['id'];?></th>
                                        <td><?php echo $row['mugId'];?></td>
                                        <td><?php echo $row['locName'];?></td>
                                        <td><?php $d = date_create($row['checkinDateTime']); echo date_format($d,DATE_TIME_FORMAT_UI);?></td>
                                        <td><a data-toggle="tooltip" title="Edit" href="<?php echo base_url().'check-ins/edit/'.$row['id'];?>">
                                                <i class="glyphicon glyphicon-edit"></i></a>&nbsp;
                                            <a data-toggle="tooltip" class="mugDelete-icon" title="Delete" data-mugId = "<?php echo $row['id'];?>">
                                                <i class="fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
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
    $(".my-searchField").on("keyup", function() {
        var value = $(this).val().toLowerCase();

        $("table tr").each(function(index) {
            if (index !== 0) {

                $row = $(this);

                var id = $row.find("td").each(function(){
                    if($(this).html().toLowerCase().indexOf(value) >-1){
                        $row.show();
                        return false;
                    }
                    else
                    {
                        $row.hide();
                    }
                });
            }
        });
    });
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
    $(document).on('click','.mugDelete-icon',function(){
        var mugId = $(this).attr('data-mugId');
        bootbox.confirm("Are you sure you want to delete Check-In Entry #"+mugId+" ?", function(result) {
            if(result === true)
            {
                window.location.href='<?php echo base_url();?>check-ins/delete/'+mugId;
            }
        });
    });

    var numPerPage = 10;

    function changePagination(ele)
    {
        numPerPage = Number($(ele).val());
        //$('body').find('.pagination.pull-right').remove();
        newPaginationFunc();
    }

    function newPaginationFunc()
    {
        $('.pagination-container').remove();
        $("table.paginated").simplePagination({
            // the number of rows to show per page
            perPage: numPerPage,

            // CSS classes to custom the pagination
            containerClass: 'pagination-container',
            previousButtonClass: 'btn btn-primary',
            nextButtonClass: 'btn btn-success',

            // text for next and prev buttons
            previousButtonText: 'Previous',
            nextButtonText: 'Next',

            // initial page
            currentPage: 1
        });

    }
    newPaginationFunc();
</script>
</html>