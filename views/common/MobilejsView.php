<!--not tho change js-->
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery-2.2.4.min.js"></script>
<!-- Framework 7 script -->
<script type="text/javascript" src="<?php echo base_url(); ?>asset/mobile/js/framework7.min.js"></script>

<script>
    var isAndroid = Framework7.prototype.device.android === true;
    var isIos = Framework7.prototype.device.ios === true;

    Template7.global = {
        android: isAndroid,
        ios: isIos
    };

    // Export selectors engine
    var $$ = Dom7;

    if (isAndroid) {
        // Change class
        $$('.view.navbar-through').removeClass('navbar-through').addClass('navbar-fixed');
        // And move Navbar into Page
        $$('.view .navbar').prependTo('.view .page');
    }

    // Init App
    var myApp = new Framework7({
        // Enable Material theme for Android device only
        material: isAndroid ? true : false,
        // Enable Template7 pages
        template7Pages: true
    });

    // Init View
    var mainView = myApp.addView('.view-main', {
        // Material doesn't support it but don't worry about it
        // F7 will ignore it for Material theme
        dynamicNavbar: true
    });
    
    myApp.onPageInit('about', function (page) {
        // Do something here for "about" page

    })
</script>