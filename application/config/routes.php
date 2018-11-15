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
|	http://codeigniter.com/user_guide/general/routing.html
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

$route['default_controller'] = 'themes';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;




/**
 * Load Routes From Database
 * @uses global app routes
*/
require_once( BASEPATH .'database/DB'. EXT );
$db =& DB();
$query = $db->get('routes');
$result = $query->result();
foreach( $result as $row ){
    $route[ $row->uri ]                 = $row->controller;
    $route[ $row->uri.'/:any' ]         = $row->controller;
    $route[ $row->controller ]           = 'error404';
    $route[ $row->controller.'/:any' ]   = 'error404';
}





// // THEME ROUTES
// $route['admin/themes'] = 'themes/admin/themes';
// $route['admin/themes/options'] = 'themes/admin/themes/get_theme_options';
// $route['admin/themes/slider'] = 'themes/admin/themes/slider_settings';
// $route['page/(:num)/(:any)'] = 'themes/page/$1/$2';
// $route['post/(:num)/(:any)'] = 'themes/post/$1/$2';
// $route['tour/(:num)/(:any)'] = 'themes/tour/$1/$2';
// $route['category/(:any)/(:any)'] = 'themes/category/$1/$2';

// $route['tours/type/(:any)'] = 'tour/get_tours_by_type/$1';
// $route['tours'] = 'tour';




// // APP ROUTES
// $route['admin/login'] = 'user/admin/user/login';
// $route['admin/logout'] = 'user/admin/user/logout';


// // DASHBOARD
// $route['admin'] = 'dashboard/dashboard';
// $route['admin/dashboard'] = 'dashboard/dashboard';


// // BLOGS
// $route['admin/blogs'] = 'blog/admin/blog';
// $route['admin/blogs/add'] = 'blog/admin/blog/add_post';
// $route['admin/blogs/edit/(:num)'] = 'blog/admin/blog/edit_post/$1';
// $route['admin/blogs/categories'] = 'blog/admin/blog/categories';
// $route['admin/blogs/categories/edit/(:num)'] = 'blog/admin/blog/edit_category/$1';
// $route['admin/blogs/status/(:any)'] = 'blog/admin/blog/blog_by_status/$1';
// $route['admin/blogs/status/(:any)/(:num)'] = 'blog/admin/blog/blog_by_status/$1/$2'; 
// $route['admin/blogs/search'] = 'blog/admin/blog/search';


// // PAGES
// $route['admin/pages'] = 'page/admin/page';
// $route['admin/pages/add'] = 'page/admin/page/add_page';
// $route['admin/pages/edit/(:num)'] = 'page/admin/page/edit_page/$1';
// $route['admin/pages/status/(:any)'] = 'page/admin/page/page_by_status/$1';
// $route['admin/pages/status/(:any)/(:num)'] = 'page/admin/page/page_by_status/$1/$2';
// $route['admin/pages/search'] = 'page/admin/page/search'; 


// // MENUS
// $route['admin/menus'] = 'menus/admin/menus';
// $route['admin/menus/edit/(:num)'] = 'menus/admin/menus/edit_menu/$1';


// // USERS
// $route['admin/users'] = 'user/admin/user';
// $route['admin/users/add'] = 'user/admin/user/add_user';
// $route['admin/users/edit/(:num)'] = 'user/admin/user/edit/$1';
// $route['admin/users/role/(:any)'] = 'user/admin/user/user_by_role/$1';
// $route['admin/users/role/(:any)/(:num)'] = 'user/admin/user/user_by_role/$1/$2'; 
// $route['admin/users/profile'] = 'user/admin/user/profile';


// // INQUIRIES
// $route['admin/inquiries'] = 'inquiries/admin/inquiries';
// $route['admin/inquiries/view/(:num)'] = 'inquiries/admin/inquiries/view_inquiry/$1';
// $route['admin/inquiries/status/(:any)'] = 'inquiries/admin/inquiries/inquiries_by_status/$1';
// $route['admin/inquiries/status/(:any)/(:num)'] = 'inquiries/admin/inquiries/inquiries_by_status/$1/$2';



// // SETTINGS
// $route['admin/settings'] = 'settings/admin/settings';




// // TOUR
// $route['admin/tours'] = 'tour/admin/tour';
// $route['admin/tours/add'] = 'tour/admin/tour/add_tour';
// $route['admin/tours/edit/(:num)'] = 'tour/admin/tour/edit_tour/$1';
// $route['admin/tours/status/(:any)'] = 'tour/admin/tour/tour_by_status/$1';
// $route['admin/tours/status/(:any)/(:num)'] = 'tour/admin/tour/tour_by_status/$1/$2'; 
// $route['admin/tours/search'] = 'tour/admin/tour/search'; 




// // BOOKING
// $route['admin/bookings'] = 'booking/admin/booking';
// $route['admin/bookings/view/(:num)'] = 'booking/admin/booking/view_booking/$1';
// $route['admin/bookings/status/(:any)'] = 'booking/admin/booking/booking_by_status/$1';
// $route['admin/bookings/status/(:any)/(:num)'] = 'booking/admin/booking/booking_by_status/$1/$2'; 
// $route['admin/bookings/search'] = 'booking/admin/booking/search'; 