<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/* Custom constants defined */
defined('PAGE_404')  OR define('PAGE_404', 'page404');
defined('FROM_NAME_EMAIL')  OR define('FROM_NAME_EMAIL', 'Doolally');
defined('RESPONSE_JSON') OR define('RESPONSE_JSON','json');
defined('RESPONSE_RETURN') OR define('RESPONSE_RETURN','return');
defined('DATE_FORMAT_UI')   OR define('DATE_FORMAT_UI', 'jS M, Y');
defined('DATE_FORMAT_GRAPH_UI')   OR define('DATE_FORMAT_GRAPH_UI', 'j F');
defined('DATE_MAIL_FORMAT_UI')   OR define('DATE_MAIL_FORMAT_UI', 'jS M Y');
defined('DATE_TIME_FORMAT_UI')   OR define('DATE_TIME_FORMAT_UI', 'D, jS F, Y g:i a');

/* Mail Type */
defined('EXPIRED_MAIL') OR define('EXPIRED_MAIL',1);
defined('EXPIRING_MAIL') OR define('EXPIRING_MAIL',2);
defined('BIRTHDAY_MAIL') OR define('BIRTHDAY_MAIL',3);
defined('CUSTOM_MAIL') OR define('CUSTOM_MAIL',0);

/* User Type */
defined('ADMIN_USER') OR define('ADMIN_USER',1);
defined('EXECUTIVE_USER') OR define('EXECUTIVE_USER',2);
defined('SERVER_USER') OR define('SERVER_USER',3);
defined('GUEST_USER') OR define('GUEST_USER',4);

/*Active or not*/
defined('ACTIVE')   OR define('ACTIVE', 1);
defined('NOT_ACTIVE')   OR define('NOT_ACTIVE', 0);

/* API Feeds */
defined('TWITTER_API') OR define('TWITTER_API','https://api.twitter.com/1.1/');
defined('FACEBOOK_API') OR define('FACEBOOK_API','https://graph.facebook.com/');
defined('CONSUMER_KEY') OR define('CONSUMER_KEY','vsi8yrEMdAaFfjz1vTLMOHnNe');
defined('CONSUMER_SECRET') OR define('CONSUMER_SECRET','T5nSoTaf8rgpXYbWqiLMGSFsdajfHnZ8uXhqz5xyzXgnUaQqbi');
defined('ACCESS_TOKEN') OR define('ACCESS_TOKEN','15804491-nkhDglNJ5uNSBGixul3kwrnQJWCkZA9tYLuUM3yQk');
defined('ACCESS_SECRET') OR define('ACCESS_SECRET','eRdLrS6eAwj07Ul5264YUZLf0AXCP9rbicAlXsLFLDjMB');
defined('BEARER_TOKEN') OR define('BEARER_TOKEN','AAAAAAAAAAAAAAAAAAAAAFhQegAAAAAAePdzbMWF5F%2FfVU5Ph09OIb22dnE%3D7qKzt9ZZQ6IwfUErgznCPq6AcEmIZqYTnKAamzks6ojV72Nobn');
defined('FACEBOOK_TOKEN') OR define('FACEBOOK_TOKEN','EAAUZBjn6HCmQBAI3HKSk4NpOVRylQ885JM4bbYBZCydzBQFq7gnTLwG09MFVo8EnAxUaK82YnCXZA7CewbY7mkE7WhCm9Hn3jz34ZBeGFgtXZCqZA9MTRWPsrY3CpkSB0SpEOVQ8Eix8ZCZADcFD3UwtEuHgNK4S5zQZD');
