<!--not tho change js-->
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery-2.2.4.min.js"></script>
<!-- Framework 7 script -->
<script type="text/javascript" src="<?php echo base_url(); ?>asset/mobile/js/framework7.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/material.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/mobile/js/jquery.timeago.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/mobile/js/jssocials.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/mobile/js/jquery-clockpicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/mobile/js/jquery.swipebox.min.js"></script>
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
            picture: '<div class="tutorialicon"><img src="<?php echo base_url();?>asset/images/splashLogo.png"/>'+
            '<span class="load-txt">Loading</span><div class="progress-bar"><div class="progressbar-infinite"></div></div></div>'
        }
    ];
    var options = {
        'bgcolor': '#fff',
        'fontcolor': '#000',
        closeButton:false,
        pagination:false
    };
   /* <div class="windows8">'+
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
    '</div>*/
    var MS_IN_MINUTES = 60 * 1000;
    var formatTime = function(date) {
        return date.toISOString().replace(/-|:|\.\d+/g, '');
    };

    var calculateEndTime = function(event) {
        return event.end ?
            formatTime(event.end) :
            formatTime(new Date(event.start.getTime() + (event.duration * MS_IN_MINUTES)));
    };

    var calendarGenerators = {
        google: function(event) {
            var startTime = formatTime(event.start);
            var endTime = calculateEndTime(event);

            var href = encodeURI([
                'https://www.google.com/calendar/render',
                '?action=TEMPLATE',
                '&text=' + (event.title || ''),
                '&dates=' + (startTime || ''),
                '/' + (endTime || ''),
                '&details=' + (event.description || ''),
                '&location=' + (event.address || ''),
                '&sprop=&sprop=name:'
            ].join(''));
            return '<a class="icon-google external item-link list-button" target="_blank" href="' +
                href + '">Google Calendar</a>';
        },

        yahoo: function(event) {
            var eventDuration = event.end ?
                ((event.end.getTime() - event.start.getTime())/ MS_IN_MINUTES) :
                event.duration;

            // Yahoo dates are crazy, we need to convert the duration from minutes to hh:mm
            var yahooHourDuration = eventDuration < 600 ?
            '0' + Math.floor((eventDuration / 60)) :
            Math.floor((eventDuration / 60)) + '';

            var yahooMinuteDuration = eventDuration % 60 < 10 ?
            '0' + eventDuration % 60 :
            eventDuration % 60 + '';

            var yahooEventDuration = yahooHourDuration + yahooMinuteDuration;

            // Remove timezone from event time
            var st = formatTime(new Date(event.start - (event.start.getTimezoneOffset() *
                    MS_IN_MINUTES))) || '';

            var href = encodeURI([
                'http://calendar.yahoo.com/?v=60&view=d&type=20',
                '&title=' + (event.title || ''),
                '&st=' + st,
                '&dur=' + (yahooEventDuration || ''),
                '&desc=' + (event.description || ''),
                '&in_loc=' + (event.address || '')
            ].join(''));

            return '<a class="icon-yahoo external item-link list-button" target="_blank" href="' +
                href + '">Yahoo! Calendar</a>';
        },

        ics: function(event, eClass, calendarName) {
            var startTime = formatTime(event.start);
            var endTime = calculateEndTime(event);

            var href = encodeURI(
                'data:text/calendar;charset=utf8,' + [
                    'BEGIN:VCALENDAR',
                    'VERSION:2.0',
                    'BEGIN:VEVENT',
                    'URL:' + document.URL,
                    'DTSTART:' + (startTime || ''),
                    'DTEND:' + (endTime || ''),
                    'SUMMARY:' + (event.title || ''),
                    'DESCRIPTION:' + (event.description || ''),
                    'LOCATION:' + (event.address || ''),
                    'END:VEVENT',
                    'END:VCALENDAR'].join('\n'));

            return '<a class="' + eClass + ' external item-link list-button" target="_blank" href="' +
                href + '">' + calendarName + ' Calendar</a>';
        },

        ical: function(event) {
            return this.ics(event, 'icon-ical', 'iCal');
        },

        outlook: function(event) {
            return this.ics(event, 'icon-outlook', 'Outlook');
        }
    };

    var generateCalendars = function(event) {
        return {
            google: calendarGenerators.google(event),
            yahoo: calendarGenerators.yahoo(event),
            ical: calendarGenerators.ical(event),
            outlook: calendarGenerators.outlook(event)
        };
    };
</script>