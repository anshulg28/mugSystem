<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Mug New Check-In :: Doolally</title>
	<?php echo $globalStyle; ?>
</head>
<body>
    <?php echo $headerView; ?>
    <main class="mugCheckIn">
        <div class="container">
            <div class="row">
                <div class="col-sm-2 col-xs-1"></div>
                <div class="col-sm-8 col-xs-10 main-box">
                    <h2 class="text-center"><i class="fa fa-calendar-check-o fa-1x"></i> Add New Check-In</h2>
                    <hr>
                    <br>
                    <!--<div class="pull-right">
                        <a href="#" data-toggle="tooltip" title="Search"><i class="fa fa-search"></i></a> &nbsp;
                        <a href="#" class="my-info-filler"><i class="fa fa-file-text-o"></i></a>
                    </div>-->
                    <div class="col-sm-12 col-xs-12">
                        <ul class="list-inline my-mainMenuList text-center">
                            <li>
                                <input type="radio" name="checkInInput" onchange="showForm(this)" id="mugInput" value="1" />
                                <label for="mugInput">
                                    <i class="fa fa-beer fa-3x"></i>
                                    <br>
                                    <span>Mug #</span>
                                </label>
                            </li>
                            <!--<li>
                                <input type="radio" name="checkInInput" onchange="showForm(this)" id="mobInput" value="2" />
                                <label for="mobInput">
                                    <i class="fa fa-mobile fa-3x"></i>
                                    <br>
                                    <span>Mobile #</span>
                                </label>
                            </li>-->
                            <li>
                                <a href="#" data-toggle="modal" data-target="#searchModal">
                                    <div class="menuWrap text-center">
                                        <i class="fa fa-search fa-3x"></i>
                                        <br>
                                        <span>Search List</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <br>
                        <div class="form-group mugInput hide">
                            <div class="col-sm-1 col-xs-1 form-adjust-insmall"></div>
                            <div class="col-sm-8 col-xs-8">
                                <input type="number" name="mugNum" class="form-control" id="mugNum" placeholder="Mug #">
                            </div>
                            <div class="col-sm-2 col-xs-2">
                                <button type="button" class="btn btn-primary verify-checkin-btn">Verify</button>
                            </div>
                            <div class="col-sm-1 col-xs-1"></div>
                        </div>
                        <div class="form-group mobileInput hide">
                            <div class="col-sm-1 col-xs-1"></div>
                            <div class="col-sm-8 col-xs-8">
                                <input type="number" name="mobNum" oninput="maxLengthCheck(this)" class="form-control" id="mobNum" maxlength="10" placeholder="Mobile #">
                            </div>
                            <div class="col-sm-2 col-xs-2">
                                <button type="button" class="btn btn-primary verify-checkin-btn">Verify</button>
                            </div>
                            <div class="col-sm-1 col-xs-1 form-adjust-insmall"></div>
                        </div>
                        <br><br>
                        <div class="row">
                            <div class="col-sm-8 col-xs-8 checkin-info-panel">
                                <div class="mugNumber-status"></div>
                            </div>
                            <div class="col-sm-4 col-xs-4 visual-status-icons hide">
                                <i class="fa fa-home fa-4x" data-toggle="tooltip" title="Home"></i>
                                <i class="fa fa-plane fa-4x" data-toggle="tooltip" title="Roaming"></i>
                            </div>
                        </div>

                        <div class="row final-checkIn-row hide">
                            <div class="col-sm-2 col-xs-2"></div>
                            <div class="col-sm-8 col-xs-8 text-center">
                                <button type="button" class="btn btn-success final-checkin-btn">Check-In</button>
                            </div>
                            <div class="col-sm-2 col-xs-2"></div>
                        </div>
                        <br>
                    </div>
                    <!--<div class="col-sm-2">
                        <i class="fa fa-home fa-5x"></i>
                        <i class="fa fa-plane fa-5x"></i>
                        <button onclick="getLocation()">bvbbv</button>
                        <p id="demo"></p>
                    </div>-->
                </div>
                <div class="col-sm-2 col-xs-1"></div>
            </div>
        </div>
    </main>

    <!-- Modal -->
    <div id="searchModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Search List</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-5 col-xs-5">
                            <input type="text" placeholder="Search" class="form-control my-searchField"/>
                        </div>
                        <br><br><br>
                        <div class="col-sm-12 col-xs-12 modal-table">
                            <table class="table table-hover table-bordered table-striped my-checkIn-search-table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Birth Date</th>
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
                                                    <td class="hide location-info"><?php echo $row['homeBase'];?></td>
                                                    <td class="hide membershipEnd-info"><?php echo $row['membershipEnd'];?></td>
                                                    <td class="hide mugNumber-info"><?php echo $row['mugId'];?></td>
                                                    <td class="hide">
                                                        <span class="infoLabel">Mug #</span>
                                                        <span class="infoData"><?php echo $row['mugId'];?></span>
                                                    </td>
                                                    <td>
                                                        <span class="infoLabel hide">Name</span>
                                                        <span class="infoData"><?php echo ucfirst($row['firstName']) .' '.ucfirst($row['lastName']);?></span>
                                                    </td>
                                                    <td class="hide">
                                                        <span class="infoLabel hide">Mug Tag</span>
                                                        <span class="infoData"><?php echo $row['mugTag'];?></span>
                                                    </td>
                                                    <td>
                                                        <span class="infoLabel hide">Mobile #</span>
                                                        <span class="infoData"><?php echo $row['mobileNo'];?></span>
                                                    </td>
                                                    <td class="hide">
                                                        <span class="infoLabel">Email</span>
                                                        <span class="infoData"><?php echo $row['emailId'];?></span>
                                                    </td>
                                                    <td>
                                                        <span class="infoLabel hide">Birth Date</span>
                                                        <span class="infoData"><?php $d = date_create($row['birthDate']); echo date_format($d,DATE_FORMAT_UI);?></span>
                                                    </td>
                                                    <td class="hide">
                                                        <span class="infoLabel hide">Home Base</span>
                                                        <span class="infoData"><?php echo $row['locationName']['locName'];?></span>
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
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
<?php echo $footerView; ?>
</body>
<?php echo $globalJs; ?>

<script>
    var myMugDataInfo,checkedInMugNum;
    function showForm(ele)
    {
        if($(ele).val() == '1')
        {
            $('.mugInput').removeClass('hide');
            if(!$('.mobileInput').hasClass('hide'))
            {
                $('.mobileInput').addClass('hide');
            }
        }
        else
        {
            $('.mobileInput').removeClass('hide');
            if(!$('.mugInput').hasClass('hide'))
            {
                $('.mugInput').addClass('hide');
            }
        }
    }
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

    $(document).on('click','.verify-checkin-btn',function(){
        showCustomLoader();
        var selectedInputVal = $('input[name="checkInInput"]:checked').val();
        if(selectedInputVal == '1')
        {
            if($('#mugNum').val() == '')
            {
                hideCustomLoader();
                bootbox.alert("Please Enter Mug Number!");
            }
            else
            {
                if(myMugDataInfo == 'error')
                {
                    ajaxCheckIn({mugNum:$('#mugNum').val()});
                }
                else
                {
                    localCheckIn({mugNum:$('#mugNum').val()});
                }
            }
        }
        else if(selectedInputVal == '2')
        {
            if($('#mobNum').val() == '')
            {
                hideCustomLoader();
                bootbox.alert("Please Enter Mobile Number!");
            }
            else
            {
                if(myMugDataInfo == 'error')
                {
                    ajaxCheckIn({mobNum:$('#mobNum').val()});
                }
                else
                {
                    localCheckIn({mobNum:$('#mobNum').val()});
                }
            }
        }
    });

    function ajaxCheckIn(inputData)
    {
        $.ajax({
            type:"POST",
            dataType:"json",
            url: base_url+'check-ins/verify',
            data: inputData,
            success: function(data)
            {
                hideCustomLoader();
                if(data.status === true)
                {
                    var myBigStatusHtml = '<ul>';
                    var mugList = data.mugList;

                    var myFormatedData = {
                        'Mug #' : mugList[0].mugId,
                        'Name': mugList[0].firstName +' '+mugList[0].lastName,
                        'Mug Tag': mugList[0].mugTag,
                        'Mobile #': mugList[0].mobileNo,
                        'Email': mugList[0].emailId,
                        'Birth Date': formatJsDate(mugList[0].birthDate),
                        'Home Base': mugList[0].locationName.locName
                    };


                    for(var mugIndex in myFormatedData)
                    {
                        myBigStatusHtml += '<li>'+mugIndex+': '+myFormatedData[mugIndex]+'</li>';
                    }
                    myBigStatusHtml += '</ul>';
                    $('.mugNumber-status').html(myBigStatusHtml);
                    checkedInMugNum = mugList[0].mugId;
                    $('.mugCheckIn .final-checkIn-row').removeClass('hide');

                    //validity and location check
                    if(checkMemberLocation(mugList[0].homeBase) === true)
                    {
                        if(checkMembershipValidity(mugList[0].membershipEnd) === true)
                        {
                            $('.visual-status-icons').removeClass('hide');
                            $('.visual-status-icons').find('i').addClass('hide');
                            $('.visual-status-icons').find('i:first-child').removeClass('hide').addClass('my-danger-text');
                        }
                        else
                        {
                            $('.visual-status-icons').removeClass('hide');
                            $('.visual-status-icons').find('i').addClass('hide');
                            $('.visual-status-icons').find('i:first-child').removeClass('hide').addClass('my-success-text');
                        }
                    }
                    else
                    {
                        if (checkMembershipValidity(mugList[0].membershipEnd) === true)
                        {
                            $('.visual-status-icons').removeClass('hide');
                            $('.visual-status-icons').find('i').addClass('hide');
                            $('.visual-status-icons').find('i:last-child').removeClass('hide').addClass('my-danger-text');
                        }
                        else
                        {
                            $('.visual-status-icons').removeClass('hide');
                            $('.visual-status-icons').find('i').addClass('hide');
                            $('.visual-status-icons').find('i:last-child').removeClass('hide').addClass('my-success-text');
                        }
                    }
                        
                }
                else
                {
                    checkedInMugNum = '';
                    $('.mugCheckIn .final-checkIn-row').addClass('hide');
                    $('.visual-status-icons').addClass('hide');
                    $('.mugNumber-status').html('Record Not Found!');
                    hideCustomLoader();
                }

            },
            error: function(){
                $('.mugCheckIn .final-checkIn-row').addClass('hide');
                $('.visual-status-icons').addClass('hide');
                hideCustomLoader();
                bootbox.alert('Some Error Occurred!');
            }
        });
    }

    function localCheckIn(inputData)
    {
        var mugList = myMugDataInfo.mugList;
        var foundAnyData = 0;

        for(var mugI in mugList)
        {
            if(typeof inputData['mugNum'] != 'undefined')
            {
                if(mugList[mugI].mugId == inputData['mugNum'])
                {
                    foundAnyData = 1;
                    fillMugData(mugList[mugI]);
                    return false;
                }
            }
            else if(typeof inputData['mobNum'] != 'undefined')
            {

                if(mugList[mugI].mobileNo == inputData['mobNum'])
                {
                    foundAnyData = 1;
                    fillMugData(mugList[mugI]);
                    return false;
                }
            }

        }

        if(foundAnyData == 0)
        {
            checkedInMugNum = '';
            $('.mugCheckIn .final-checkIn-row').addClass('hide');
            $('.visual-status-icons').addClass('hide');
            hideCustomLoader();
            $('.mugNumber-status').html('Record Not Found!');
        }
    }

    function fillMugData(mugList)
    {
       var myBigStatusHtml = '<ul>';
       var myFormatedData = {
            'Mug #' : mugList.mugId,
            'Name': mugList.firstName +' '+mugList.lastName,
            'Mug Tag': mugList.mugTag,
            'Mobile #': mugList.mobileNo,
            'Email': mugList.emailId,
            'Birth Date': formatJsDate(mugList.birthDate),
            'Home Base': mugList.locationName.locName
        };
        for(var mugIndex in myFormatedData)
        {
            myBigStatusHtml += '<li>'+mugIndex+': '+myFormatedData[mugIndex]+'</li>';
        }
        myBigStatusHtml += '</ul>';
        $('.mugNumber-status').html(myBigStatusHtml);
        hideCustomLoader();
        checkedInMugNum = mugList.mugId;
        $('.mugCheckIn .final-checkIn-row').removeClass('hide');

        //validity and location check
        if(checkMemberLocation(mugList.homeBase) === true)
        {
            if(checkMembershipValidity(mugList.membershipEnd) === true)
            {
                $('.visual-status-icons').removeClass('hide');
                $('.visual-status-icons').find('i').addClass('hide');
                $('.visual-status-icons').find('i:first-child').removeClass('hide').addClass('my-danger-text');
            }
            else
            {
                $('.visual-status-icons').removeClass('hide');
                $('.visual-status-icons').find('i').addClass('hide');
                $('.visual-status-icons').find('i:first-child').removeClass('hide').addClass('my-success-text');
            }
        }
        else
        {
            if (checkMembershipValidity(mugList.membershipEnd) === true)
            {
                $('.visual-status-icons').removeClass('hide');
                $('.visual-status-icons').find('i').addClass('hide');
                $('.visual-status-icons').find('i:last-child').removeClass('hide').addClass('my-danger-text');
            }
            else
            {
                $('.visual-status-icons').removeClass('hide');
                $('.visual-status-icons').find('i').addClass('hide');
                $('.visual-status-icons').find('i:last-child').removeClass('hide').addClass('my-success-text');
            }
        }
    }

    $(document).ready(function(){
       myMugDataInfo = <?php if(isset($mugData) && myIsArray($mugData)) {if($mugData['status'] === false){ echo 'error';} else{echo json_encode($mugData);}}else {echo 'error';}?>;
        $('[data-toggle="tooltip"]').tooltip();
    });
    function maxLengthCheck(object)
    {
        if (object.value.length > object.maxLength)
            object.value = object.value.slice(0, object.maxLength)
    }

    $(document).on('click','.my-checkIn-search-table td', function(){
        var row_index = $(this).parent().index();
        var selectedRow = $(this).parent()[0];
        var currentRowLocation,membershipEnd;
        var myBigStatusHtml = '<ul>';
        $(selectedRow).find('td').each(function(i,val){
            if($(val).hasClass('location-info'))
            {
                currentRowLocation = $(val)[0].innerText;
            }
            else if($(val).hasClass('membershipEnd-info'))
            {
                membershipEnd = $(val)[0].innerText;
            }
            else if($(val).hasClass('mugNumber-info'))
            {
                checkedInMugNum = $(val)[0].innerText;
            }
            else
            {
                myBigStatusHtml += '<li>'+$(val).find('.infoLabel')[0].innerText+': '+$(val).find('.infoData')[0].innerText+'</li>';
            }

        });
        myBigStatusHtml += '</ul>';
        $('.mugNumber-status').html(myBigStatusHtml);
        $('.mugCheckIn .final-checkIn-row').removeClass('hide');
        //validity and location check
        if(checkMemberLocation(currentRowLocation) === true)
        {
            if(checkMembershipValidity(membershipEnd) === true)
            {
                $('.visual-status-icons').removeClass('hide');
                $('.visual-status-icons').find('i').addClass('hide');
                $('.visual-status-icons').find('i:first-child').removeClass('hide').addClass('my-danger-text');
            }
            else
            {
                $('.visual-status-icons').removeClass('hide');
                $('.visual-status-icons').find('i').addClass('hide');
                $('.visual-status-icons').find('i:first-child').removeClass('hide').addClass('my-success-text');
            }
        }
        else
        {
            if (checkMembershipValidity(membershipEnd) === true)
            {
                $('.visual-status-icons').removeClass('hide');
                $('.visual-status-icons').find('i').addClass('hide');
                $('.visual-status-icons').find('i:last-child').removeClass('hide').addClass('my-danger-text');
            }
            else
            {
                $('.visual-status-icons').removeClass('hide');
                $('.visual-status-icons').find('i').addClass('hide');
                $('.visual-status-icons').find('i:last-child').removeClass('hide').addClass('my-success-text');
            }
        }
        $('#searchModal').modal('hide');
    });

    $(document).on('click','.final-checkin-btn', function(){
        if(checkedInMugNum != '')
        {
            showCustomLoader();
            $.ajax({
                type:"post",
                dataType:"json",
                url:base_url+'check-ins/save/json',
                data:{mugNum:checkedInMugNum},
                success: function(data)
                {
                    hideCustomLoader();
                    if(data.status === true)
                    {
                        bootbox.alert('Successfully Checked In!');
                        window.location.reload();
                    }
                },
                error: function()
                {
                    hideCustomLoader();
                    bootbox.alert('Some Error Occurred!');
                }
            });
        }
    });

    setInterval(fetchAllMugList,(60*60*1000));

    function fetchAllMugList()
    {
        $.ajax({
            type:"GET",
            dataType:"json",
            url:base_url+'mugclub/getAllMugListMembers',
            success: function(data)
            {
                if(data.mugData.status === true)
                {
                    myMugDataInfo = data.mugData;
                }
                else
                {
                    myMugDataInfo = 'error';
                }

            },
            error: function()
            {
                myMugDataInfo = 'error';
            }
        });
    }

    var numPerPage = 10;
    $("table.my-checkIn-search-table").simplePagination({
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
</script>
</html>