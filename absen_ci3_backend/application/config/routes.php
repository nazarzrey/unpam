<?php
defined('BASEPATH') or exit('No direct script access allowed');
#define('ENVIRONMENT', 'development');
#error_reporting(E_ALL);
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
$route['default_controller']     = 'welcome';
$route['api_link']         = 'xhr/get/link';
$route['push_absen']         = 'xhr/post/absen';
$route['read_absen']         = 'xhr/get/absen';
$route['receive_data']         = 'xhr/post/reciveabsen';
$route['cek_absen']         = 'xhr/get/cekabsen';
$route['nama']         = 'xhr/get/nama';
$route['nama/(:any)']         = 'xhr/get/nama/$1';
$route['url']         = 'xhr/get/url';
$route['url/(:any)']         = 'xhr/get/url/$1';
$route['absenlog']         = 'xhr/get/loging';
$route['absenlog/(:num)']         = 'xhr/get/loging/$1';
$route['absendosen']         = 'xhr/get/log_dtl';
$route['absensiswa']         = 'xhr/get/log_dtl_siswa';
$route['absensiswa/(:num)']         = 'xhr/get/log_dtl_siswa/$1';
$route['sync']         = 'xhr/get/sync';
$route['login']         = 'Login';
//buat bin makalah
$route['makalah']         = 'xhr/get/makalah';
// $route['logout']         = 'Login/logout';
$route['dashboard']        = 'xhr/get/log_dtl_siswa/$1';
$route['dashboard/(:num)']        = 'xhr/get/log_dtl_siswa/$1/$2';
$route['menu']        = 'xhr/get/menu';
$route['grup']        = 'xhr/get/grup';
$route['grup/(:num)']        = 'xhr/get/grup/$1';

$route['note']        = 'xhr/get/noted';
$route['note/(:num)']        = 'xhr/get/noted/$1';

$route['mangkir/(:num)']        = 'xhr/get/mangkir/$1';
$route['nilai']        = 'penilaian';
$route['save_nilai']        = 'penilaian/save_nilai';
$route['nilai/(:any)']        = 'penilaian/nilai/$1';

$route['absen/(:any)']         = 'xhr/absen/$1';

$route['create']         = 'backend/generate_dyn';
$route['dyrect']         = 'backend/directly';
$route['daftar']         = 'backend/daftar_dynurl';
$route['visit']          = 'backend/visit';
$route['log']            = 'backend/visit_log';
$route['(:any)']         = 'backend';
$route['ip/(:any)']      = 'backend/job/$1';

#$route['404_override'] = 'Errorpage404';
$route['translate_uri_dashes'] = FALSE;
