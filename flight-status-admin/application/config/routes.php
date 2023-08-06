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
// $route['default_controller'] = 'Chn_airport';
// $route['404_override'] = '';
// $route['translate_uri_dashes'] = FALSE;
$route['default_controller'] = 'Airport_Controller';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//departure selenium json route
$route['getds'] = 'Airport_Controller/getdepartureseleniumData';
$route['departureselenium'] = 'Airport_Controller/departureSelenium';

//departure json route
$route['getd'] = 'Airport_Controller/getdepartureData';
$route['departure'] = 'Airport_Controller/departure';

//arrival selenium json route
$route['getas'] = 'Airport_Controller/getarrivalseleniumData';
$route['arrivalselenium'] = 'Airport_Controller/arrivalSelenium';

//arrival json route
$route['geta'] = 'Airport_Controller/getarrivalData';
$route['arrival'] = 'Airport_Controller/arrival';

$rout['getflight'] = 'Airport_Controller/getflightData';

$rout['getflightS'] = 'Airport_Controller/get_TrichyMasterFlight_table';


$route['test'] = 'Airport_Controller/get_TrichyMasterArrivalSelenium_table';

//wordpress
$route['wordpress/(:any)/(:any)'] = 'Airport_Controller/wordpress/$1/$2';



//api flight for wordpress
$route['airport/(:any)'] = 'Airport_Controller/get_Apiflights/$1';

//api arrival flight for wordpress
$route['airport/arrival/(:any)'] = 'Airport_Controller/get_ApiArrival/$1';

//api departure flight for wordpress
$route['airport/departure/(:any)'] = 'Airport_Controller/get_ApiDeparture/$1';

//api slug tables list wordpress
$route['slug'] = 'Airport_Controller/get_Apislug';

//api slug for flight list tables wordpress
$route['slug/flights'] = 'Airport_Controller/get_ApislugFlight';


//api slug tables wordpress for dubai Airport
$route['slug/(:any)-(:any)'] = 'Airport_Controller/get_slug_url/$1/$2';

//api slug tables sitemap seggrigate for arrival and departure al;so which project code the url
$route['slug_segrigate/(:any)?-(:any)'] = 'Airport_Controller/get_slug_url_sitemap/$1/$2';


//*************************************************************** */
//route for dubai flight data
$route['getDubai'] = 'Airport_Controller/get_DubaiData';

//route for Dubai Departure data
$route['get-departure-dubai'] = 'Airport_Controller/get_Dubai_Departure_Data';

//route for Dubai Arrival data
$route['get-arrival-dubai'] = 'Airport_Controller/get_Dubai_Arrival_Data';

//route for Dubai Departure  unique destination data
$route['get-departure-dubai/(:any)'] = 'Airport_Controller/get_Dubai_Departure_dest_Data/$1';

//route for Dubai Arrival unique origin data
$route['get-arrival-dubai/(:any)'] = 'Airport_Controller/get_Dubai_Arrival_dest_Data/$1';

//********************************************************************* */


//route for Chennai Departure unique destination data
$route['get-departure-chennai/(:any)'] = 'Airport_Controller/get_chennai_Departure_dest_Data/$1';

//route for Chennai Arrival unique origin data
$route['get-arrival-chennai/(:any)'] = 'Airport_Controller/get_chennai_Arrival_dest_Data/$1';



//route for Airline details table
$route['getairlinedetail'] = 'Airport_Controller/get_Airline_Detail';

// $route['airline-details'] = 'Airport_Controller/airline_detail';

//Unique slug for Arrival flight
$route['Dubai-Origin-slug'] = 'Airport_Controller/Dubai_Arrival';


//Unique slug for Destination flights
$route['(:any)-Destination-slug'] = 'Airport_Controller/Airport_Destination/$1';



//route for Airport Arrival unique origin data
$route['get-arrival-unique/(:any)/(:any)'] = 'Airport_Controller/get_Arrival_unique_Data/$1/$2';

//route for Airport Departure unique destination data
$route['get-departure-unique/(:any)/(:any)'] = 'Airport_Controller/get_Departure_unique_Data/$1/$2';


//route for indivitual airport of unique airlirne data
$route['get-unique-airlirne/(:any)/(:any)'] = 'Airport_Controller/get_unique_airlirne/$1/$2';

//route unique flight information
$route['flights/(:any)/(:any)'] = 'Airport_Controller/get_unique_flight/$1/$2';

//route get airline details as vitual page url
$route['get-airline-details/(:any)'] = 'Airport_Controller/get_airline_details/$1';


