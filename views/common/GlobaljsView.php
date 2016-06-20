<!--not tho change js-->
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery-2.2.4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/bootbox.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/doolally-local-session.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/dataTables.bootstrap.min.js"></script>

<!-- constants -->
<script>
    window.currentLocation = <?php echo $this->currentLocation; ?>;
    window.base_url = '<?php echo base_url(); ?>';
</script>

<script>
    $(document).on('submit','#mainLoginForm', function(e){

        $(this).find('.login-error-block').empty();
        $(this).find('button[type="submit"]').attr('disabled','disabled');
        $.ajax({
            type:"POST",
            dataType:"json",
            url:$(this).attr('action'),
            data:$(this).serialize(),
            success: function(data)
            {
                $('#mainLoginForm button[type="submit"]').removeAttr("disabled");
                if(data.status == true)
                {
                    window.location.href = data.pageUrl;
                }
                else
                {
                    $('#mainLoginForm .login-error-block').html(data.errorMsg);
                }
            },
            error:function()
            {
                $('#mainLoginForm button[type="submit"]').removeAttr("disabled");
                $('#mainLoginForm .login-error-block').html('Some Error Occurred, Try Again!');
            }
        });
        e.preventDefault();
    });
</script>
<!-- Loader Show and hide script -->
<script>
    function showCustomLoader()
    {
        $('body').addClass('custom-loader-body');
        $('.custom-loader-overlay').css('top',$(window).scrollTop()).addClass('show');
    }

    function hideCustomLoader()
    {
        $('body').removeClass('custom-loader-body');
        $('.custom-loader-overlay').removeClass('show');
    }

    function checkMembershipValidity(membershipEndDate)
    {
        var endDate = new Date(membershipEndDate);
        var today = new Date();
        return today > endDate;
    }
    function checkMemberLocation(location)
    {
        return location == currentLocation;
    }

    function formatJsDate(gotDate)
    {
        var monthNames = [
            "Jan", "Feb", "Mar",
            "Apr", "May", "June", "July",
            "Aug", "Sep", "Oct",
            "Nov", "Dec"
        ];

        var date = new Date(gotDate);
        var day = date.getDate();
        var monthIndex = date.getMonth();
        var year = date.getFullYear();

        return day + ' ' + monthNames[monthIndex] + ' ' + year;
    }

    function checkExpiredMugs()
    {
        $.ajax({
            type:"GET",
            dataType:"json",
            async: true,
            url:base_url+'mugclub/getAllExpiredMugs/json',
            success: function(data){
                if(data.status === true)
                {
                    localStorageUtil.setLocal('foundMails','1',(23 * 60 * 60 * 1000));
                    $('.notification-indicator').addClass('notification-animate-cls');
                    $('.notification-indicator-mobile').addClass('notification-animate-cls');
                    $('.notification-indicator-big').addClass('notification-animate-cls');
                }
            },
            error: function(){

            }
        });
    }

    function checkExpiringMugs()
    {
        $.ajax({
            type:"GET",
            dataType:"json",
            async: true,
            url:base_url+'mugclub/getAllExpiringMugs/json/1/week',
            success: function(data){
                if(data.status === true)
                {
                    localStorageUtil.setLocal('foundMails','1',(23 * 60 * 60 * 1000));
                    if(!$('.notification-indicator').hasClass('notification-animate-cls'))
                    {
                        $('.notification-indicator').addClass('notification-animate-cls');
                        $('.notification-indicator-mobile').addClass('notification-animate-cls');
                        $('.notification-indicator-big').addClass('notification-animate-cls');
                    }
                }
            },
            error: function(){

            }
        });
    }

    if(localStorageUtil.getLocal('mailCheckDone') == null)
    {
        localStorageUtil.setLocal('mailCheckDone','1',(23 * 60 * 60 * 1000));
        checkExpiredMugs();
        checkExpiringMugs();
        //write for recurring expired mugs
    }
    else if(localStorageUtil.getLocal('mailCheckDone') == '0') {
        localStorageUtil.setLocal('mailCheckDone','1',(23 * 60 * 60 * 1000));
        checkExpiredMugs();
        checkExpiringMugs();
    }
    else if(localStorageUtil.getLocal('foundMails') == '1')
    {
        $('.notification-indicator').addClass('notification-animate-cls');
        $('.notification-indicator-mobile').addClass('notification-animate-cls');
        $('.notification-indicator-big').addClass('notification-animate-cls');
    }
</script>