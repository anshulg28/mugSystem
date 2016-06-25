<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = 'Page404';
$route['translate_uri_dashes'] = FALSE;
$route['mugclub/add'] = 'mugclub/addNewMug';
$route['mugclub/edit/(:any)'] = 'mugclub/editExistingMug/$1';
$route['mugclub/save'] = 'mugclub/saveOrUpdateMug';
$route['mugclub/delete/(:any)'] = 'mugclub/deleteMugData/$1';
$route['check-ins'] = 'checkin';
$route['check-ins/add'] = 'checkin/addNewCheckIn';
$route['check-ins/edit/(:any)'] = 'checkin/editExistingCheckin/$1';
$route['check-ins/save/(:any)'] = 'checkin/saveOrUpdateCheckIn/$1';
$route['check-ins/delete/(:any)'] = 'checkin/deleteMugCheckIn/$1';
$route['check-ins/verify'] = 'checkin/verifyCheckIn';
$route['location-select'] = 'home/getLocation';
$route['login/settings'] = 'login/changeSetting';
$route['users/edit/(:any)'] = 'users/editExistingUser/$1';
$route['users/save'] = 'users/saveOrUpdateUser';
$route['users/add'] = 'users/addNewUser';
$route['users/delete/(:any)'] = 'users/deleteUserData/$1';
$route['users/setActive/(:any)'] = 'users/setUserActive/$1';
$route['users/setDeActive/(:any)'] = 'users/setUserDeActive/$1';
$route['locations/edit/(:any)'] = 'locations/editExistingUser/$1';
$route['locations/save'] = 'locations/saveOrUpdateLocation';
$route['locations/add'] = 'locations/addNewLocation';
$route['mugclub/ajaxSave'] = 'mugclub/ajaxMugUpdate';
$route['mailers/send/(:any)'] = 'mailers/sendMail/$1';
$route['mailers/add'] = 'mailers/showMailAdd';
$route['mugclub/renew/(:any)'] = 'mugclub/renewExistingMug/$1';