<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Mug Club :: Doolally</title>
	<?php echo $globalStyle; ?>
</head>
<body>
    <?php echo $headerView; ?>
    <main class="mugClub">
        <div class="container">
            <div class="row">
                <div class="col-sm-9 col-xs-8">
                    <a class="btn btn-primary" href="<?php echo base_url().'mugclub/add';?>">
                    <i class="fa fa-plus"></i>
                    Add New Mug</a>
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
                    <th>Mug #</th>
                    <th>Mug Tag</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Homebase</th>
                    <th>Birthday</th>
                    <th>Start Date</th>
                    <th>End Date</th>
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
                                <td colspan="10">No Data Found!</td>
                            </tr>
                        </tbody>
                        <?php
                    }
                    else
                    {
                        ?>
                        <tbody>
                        <?php
                            foreach($mugData['mugList'] as $key => $row)
                            {
                                if(isset($row['mugId']))
                                {
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $row['mugId'];?></th>
                                        <td><?php echo $row['mugTag'];?></td>
                                        <td><?php echo ucfirst($row['firstName']) .' '.ucfirst($row['lastName']);?></td>
                                        <td><?php echo $row['emailId'];?></td>
                                        <td><?php echo $row['mobileNo'];?></td>
                                        <td><?php echo $row['locationName']['locName'];?></td>
                                        <td><?php echo $row['birthDate'];?></td>
                                        <td><?php echo $row['membershipStart'];?></td>
                                        <td><?php echo $row['membershipEnd'];?></td>
                                        <td><a data-toggle="tooltip" title="Edit" href="<?php echo base_url().'mugclub/edit/'.$row['mugId'];?>">
                                                <i class="glyphicon glyphicon-edit"></i></a>&nbsp;
                                            <a data-toggle="tooltip" class="mugDelete-icon" title="Delete" data-mugId = "<?php echo $row['mugId'];?>">
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
        var value = $(this).val();

        $("table tr").each(function(index) {
            if (index !== 0) {

                $row = $(this);

                var id = $row.find("td").each(function(){
                    if($(this).html().indexOf(value) >-1){
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
        bootbox.confirm("Are you sure you want to delete Mug #"+mugId+" ?", function(result) {
            if(result === true)
            {
                window.location.href='<?php echo base_url();?>mugclub/delete/'+mugId;
            }
        });
    });

    var numPerPage = 10;
    //Table Pagination
    function makeTablePagination(){
        $('table.paginated').each(function() {
            var currentPage = 0;
            var $table = $(this);
            $table.bind('repaginate', function () {
                $table.find('tbody tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
            });
            $table.trigger('repaginate');
            var numRows = $table.find('tbody tr').length;
            var numPages = Math.ceil(numRows / numPerPage);
            var $pager = $('<ul class="pagination pull-right"></ul>');
            for (var page = 0; page < numPages; page++) {
                $('<li class="page-number"></li>').html('<a href="#">'+(page + 1)+'</a>').bind('click', {
                    newPage: page
                }, function (event) {
                    currentPage = event.data['newPage'];
                    $table.trigger('repaginate');
                    $(this).addClass('active').siblings().removeClass('active');
                }).appendTo($pager);
            }
            $pager.insertAfter($table).find('li.page-number:first').addClass('active');
        });
    }
    makeTablePagination();
    function changePagination(ele)
    {
        numPerPage = $(ele).val();
        $('body').find('.pagination.pull-right').remove();
        makeTablePagination();
    }
</script>
</html>