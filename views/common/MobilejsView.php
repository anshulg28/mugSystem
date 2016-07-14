<!--not tho change js-->
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery-2.2.4.min.js"></script>
<!-- Framework 7 script -->
<script type="text/javascript" src="<?php echo base_url(); ?>asset/mobile/js/framework7.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/mobile/js/welcomescreen.js"></script>

<script>
    var isAndroid = Framework7.prototype.device.android === true;
    var isIos = Framework7.prototype.device.ios === true;

    Template7.global = {
        android: isAndroid,
        ios: isIos
    };

    // Export selectors engine
    var $$ = Dom7;

    var welcomescreen_slides = [
        {
            id: 'slide0',
            picture: '<div class="tutorialicon">♥</div>',
            text: 'Welcome to this tutorial. In the next steps we will guide you through a manual that will teach you how to use this app.'
        },
        {
            id: 'slide1',
            picture: '<div class="tutorialicon">✲</div>',
            text: 'This is slide 2'
        },
        {
            id: 'slide2',
            picture: '<div class="tutorialicon">♫</div>',
            text: 'This is slide 3'
        },
        {
            id: 'slide3',
            picture: '<div class="tutorialicon">☆</div>',
            text: 'Thanks for reading! Enjoy this app.<br><br><a id="tutorial-close-btn" class="button" href="#">End Tutorial</a>'
        }
    ];
    var options = {
        'bgcolor': '#0da6ec',
        'fontcolor': '#fff'
    };
</script>