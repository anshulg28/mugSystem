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

</script>