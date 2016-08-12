<!--not tho change js-->
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery-2.2.4.min.js"></script>
<!-- Framework 7 script -->
<script type="text/javascript" src="<?php echo base_url(); ?>asset/mobile/js/framework7.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/material.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/mobile/js/jquery.timeago.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/mobile/js/framework7.upscroller.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/mobile/js/welcomescreen.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/mobile/js/hammer.min.js"></script>

<script>
    window.base_url = '<?php echo base_url(); ?>';
    var isAndroid = Framework7.prototype.device.android === true;
    var isIos = Framework7.prototype.device.ios === true;

    /*Template7.global = {
        android: isAndroid,
        ios: isIos
    };*/

    // Export selectors engine
    var $$ = Dom7;

    var welcomescreen_slides = [
        {
            id: 'slide0',
            picture: '<div class="tutorialicon"><img src="<?php echo base_url();?>asset/images/mainImg.jpg"/><div class="windows8">'+
                        '<div class="wBall" id="wBall_1">'+
                                '<div class="wInnerBall"></div>'+
                             '</div>'+
                        '<div class="wBall" id="wBall_2">'+
                            '<div class="wInnerBall"></div>'+
                        '</div>'+
                        '<div class="wBall" id="wBall_3">'+
                            '<div class="wInnerBall"></div>'+
                        '</div>'+
                        '<div class="wBall" id="wBall_4">'+
                            '<div class="wInnerBall"></div>'+
                        '</div>'+
                        '<div class="wBall" id="wBall_5">'+
                            '<div class="wInnerBall"></div>'+
                        '</div>'+
                        '</div></div>'
        }
    ];
    var options = {
        'bgcolor': '#fff',
        'fontcolor': '#000',
        closeButton:false,
        pagination:false
    };
</script>