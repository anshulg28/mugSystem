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
        <?php
            if($this->userType == SERVER_USER)
            {
                ?>
                    <div class="container">
                        <div class="row">
                            <h2 class="text-center">Mug # Check</h2>
                            <br>
                            <div class="col-sm-2 col-xs-1"></div>
                            <div class="col-sm-8 col-xs-10">
                                <div class="form-group my-marginLR-zero">
                                    <div class="col-sm-1 col-xs-0"></div>
                                    <div class="col-sm-10 col-xs-12">
                                        <input type="number" name="mobNum" id="mobNumCheck"
                                               class="form-control" placeholder="Mug # (Max 9999)">
                                    </div>
                                    <div class="col-sm-1 col-xs-0"></div>
                                </div>
                                <br><br>
                                <div class="form-group my-marginLR-zero">
                                    <div class="col-sm-12 col-xs-12 text-center">
                                        <button type="button" class="btn btn-primary mugCheck-btn">Check</button>
                                    </div>
                                </div>
                                <br><br>
                                <div class="col-sm-1 col-xs-0"></div>
                                <div class="col-sm-10 col-xs-12">
                                    <div class="panel panel-default avail-header hide">
                                        <div class="panel-heading">Available Mug Number(s)</div>
                                        <div class="panel-body">
                                            <ul class="list-inline available-mugs-list">

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-1 col-xs-0"></div>
                            </div>
                            <div class="col-sm-2 col-xs-1"></div>
                        </div>
                    </div>
                <?php
            }
            else
            {
                ?>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-9 col-xs-8">
                            <a class="btn btn-primary" href="<?php echo base_url().'mugclub/add';?>">
                                <i class="fa fa-plus"></i>
                                Add New Mug</a>
                            <!--<ul class="list-inline pagination-List">
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
                        </div>-->
                        </div>
                    </div>
                </div>
                <br>
                <div class="container table-responsive">
                    <table id="main-mugclub-table" class="table table-hover table-bordered table-striped">
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
                                            <td><?php echo $row['locName'];?></td>
                                            <td><?php echo $row['birthDate'];?></td>
                                            <td><?php echo $row['membershipStart'];?></td>
                                            <td><?php echo $row['membershipEnd'];?></td>
                                            <td><a data-toggle="tooltip" title="Edit" href="<?php echo base_url().'mugclub/edit/'.$row['mugId'];?>">
                                                    <i class="glyphicon glyphicon-edit"></i></a>&nbsp;
                                                <?php
                                                if($this->userType != SERVER_USER)
                                                {
                                                    ?>
                                                    <a data-toggle="tooltip" class="mugDelete-icon" title="Delete" data-mugId = "<?php echo $row['mugId'];?>">
                                                        <i class="fa fa-trash-o"></i></a>
                                                    <?php
                                                }
                                                ?>
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
                <div class="container">
                    <div class="row">
                        <div class="col-sm-9 col-xs-8">
                            <a class="btn btn-primary" href="<?php echo base_url().'mugclub/add';?>">
                                <i class="fa fa-plus"></i>
                                Add New Mug</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        ?>

    </main>
</body>
<?php echo $globalJs; ?>

<script>

    <?php
        if($this->userType == SERVER_USER)
        {
            ?>
                $(document).on('click','.mugCheck-btn',function(){

                    var mugNum = $('#mobNumCheck').val();
                    if(mugNum != '')
                    {
                        showCustomLoader();
                        //send ajax request to check mobile number
                        $.ajax({
                            type:"GET",
                            dataType:"json",
                            url:base_url+'mugclub/MugAvailability/json/'+mugNum,
                            success: function(data)
                            {
                                hideCustomLoader();
                                if(data.status === true)
                                {
                                    if(!$('.avail-header').hasClass('hide'))
                                    {
                                        $('.avail-header').addClass('hide');
                                    }
                                    bootbox.alert('Mug Number is <label class="my-success-text">Available</label>');
                                }
                                else
                                {
                                    bootbox.alert('Mug Number is <label class="my-danger-text">Not Available</label>');
                                    if(typeof data.availMugs != 'undefined')
                                    {
                                        var mugHtml = '';
                                        for(var index in data.availMugs)
                                        {
                                            if(index == 5)
                                            {
                                                $('.avail-header').removeClass('hide');
                                                $('.available-mugs-list').html(mugHtml);
                                                return false;
                                            }
                                            mugHtml += '<li><span class="label label-primary avail-mugs">'+data.availMugs[index]+'</span></li>';
                                        }
                                        $('.avail-header').removeClass('hide');
                                        $('.available-mugs-list').html(mugHtml);
                                    }
                                }
                            },
                            error: function()
                            {
                                hideCustomLoader();
                                bootbox.alert('Unable To Connect To Server!');
                            }
                        });
                    }
                    else
                    {
                        bootbox.alert('Please Provide Mug Number!');
                    }
                });

                $(document).on('keypress','#mobNumCheck', function(event){

                    var keycode = (event.keyCode ? event.keyCode : event.which);

                    if(keycode == 45)
                    {
                       return false;
                    }
                });

                $(document).on('keyup','#mobNumCheck', function(event){

                    var keycode = (event.keyCode ? event.keyCode : event.which);

                    var finalVal;
                    if($(this).val() > 9998)
                    {
                        finalVal = 9999 /*- (Number($(this).val()) - 9999)*/;
                        $(this).val(finalVal);
                    }
                    else if(keycode == '13'){
                        $('.mugCheck-btn').trigger('click');
                    }
                });
                $(document).on('click','.avail-mugs', function(){
                    $('#mobNumCheck').val($(this).html());
                });
            <?php
        }
        else
        {
            ?>
           /* $(".my-searchField").on("keyup", function() {
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
            });*/
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

            /*var numPerPage = 10;

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

            }*/
    //$(document).ready(function(){
        $('#main-mugclub-table').DataTable();
    //});
            //newPaginationFunc();
            <?php
        }
    ?>

</script>
</html>