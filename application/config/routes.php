<?php
defined('BASEPATH') or exit('No direct script access allowed');
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
$route['default_controller'] = 'Front/reactView';
$route['resetPassword/(:any)'] = 'Front/reactView';
$route['404_override'] = 'Front/error';
$route['translate_uri_dashes'] = FALSE;
 
$route['google']='Auth/index';
$route['facebook']='Auth/facebook';

$route['data-deletion'] = 'Front/dataDeletion';

/*API*/ 
$route['user-profile'] = 'api/User/userProfile';
$route['agent-properties'] = 'api/PropertyDetail/getAgentProperties';
$route['plans'] = 'api/Services/getPlans';
$route['budget'] = 'api/PropertyDetail/budget';
$route['get-any-message'] = 'api/PropertyDetail/getAnymessage';
$route['rent'] = 'api/Rentapi/rent';
$route['rent-details'] = 'api/Rentapi/rentDetails';
$route['rent-search'] = 'api/Rentapi/rent_search';
$route['add-rent-property'] = 'api/Rentapi/addRentProperties';
$route['all-property-types'] = 'api/Rentapi/allPropertyTypeApi';
$route['rent-hot-deals'] = 'api/Rentapi/rentHotDeals';
$route['property-hot-deals'] = 'api/PropertyDetail/propertyHotDeals';
$route['property-property-type'] = 'api/PropertyDetail/allPropertyPropertyTypeApi';
$route['forget-password'] = 'api/User/forgetPassword';
$route['add-loan-info'] = 'api/Loanapi/addLoanInfo';
$route['kiosik'] = 'api/Loanapi/kiosikInfo';
$route['project-detail'] = 'api/Projects/getSingleProject';
$route['insert-scraped-projects'] = 'api/Projects/add_scraped_data';
$route['all-projects'] = 'api/Projects/getSomeeField';
$route['residential-commercial'] = 'api/Projects/getSomeeFieldRC';
$route['agent-projects'] = 'api/Projects/getProjectField';
$route['our_services_img'] = 'api/Home_img/get_images';
$route['upcoming-projects'] = 'api/Projects/getUpcomingProjects';
$route['test-api'] = 'api/TestAPI/propertyTest';
$route['leads-user-data'] = 'api/TestAPI/leadUserData';
/*App API*/ 

//leads api
$route['get-user-leads'] = 'api/Leads/getLeadsData';
$route['status-leads-data'] = 'api/Leads/statusGetLeadsData';
$route['add-user-leads'] = 'api/Leads/addLeadsData';
$route['delete-user-leads/(:num)'] = 'api/Leads/deleteLeadsData/$1';
$route['update-user-leads/(:num)'] = 'api/Leads/updateLeadsData/$1';

//meeting new api 
$route['get-user-meetings'] = 'api/AppApiMeeting/getMeetingsData';
$route['add-user-meeting'] = 'api/AppApiMeeting/addMeeting';
$route['edit-user-meeting'] = 'api/AppApiMeeting/editMeeting';

//message api
$route['get-message-leads'] = 'api/AppApiMeeting/getMessageLData';
$route['add-message-leads'] = 'api/AppApiMeeting/addMessageLData';

//assign_leads
$route['assign-leads']='api/AppApiMeeting/assignLeads';



//meeting api 
$route['get-all-meeting'] = 'api/AppApiMeeting/getAllMeetings';
$route['post-meeting'] = 'api/AppApiMeeting/postAllMeetings';
$route['delete-meeting'] = 'api/AppApiMeeting/deleteAllMeetings';

//properties fillter api
$route['get_matching_properties'] = 'api/AppApiMeeting/getMatchingProperties';

//deal api
$route['add_lead_deals']= 'api/AppApiMeeting/addLeadDeals';
$route['get_lead_deals'] = 'api/AppApiMeeting/getLeadDeals';
$route['update_lead_deal_status'] = 'api/AppApiMeeting/updateLeadDealStatus';







//property api delete
$route["property-get"] = 'api/Properties/getProperty';
$route["property-user-get"] = 'api/Properties/getUserProperty';

$route["property-delete"] = 'api/Properties/deleteProperty';


//api contact us 
$route['api/contact']['GET'] = 'api/Contact/index';







$route['some-field'] = 'api/PropertyDetail/getSomeeFieldProperties';
$route['only-single-properties'] = 'api/PropertyDetail/getProperties';
$route['single-all-properties'] = 'api/PropertyDetail/getPropertiesSingleOne';
/*API add data */
$route['submit-agent-properties'] = 'api/PropertyDetail/submitAgentProperties';
$route['submit-properties'] = 'api/PropertyDetail/submitNewAgentPropertie';
$route['check-url'] = 'api/PropertyDetail/checkPropertyurl';
$route['add-property-buy-sale-or-rent'] = 'api/PropertyDetail/add_property_sale_buy_or_rent';


/*get data live table */
$route['submit-data-properties'] = 'api/Data_properties/moveFilteredProperties';

//$route['agent-properties'] = 'properties/getAgentField';
/* front view */
$route['property'] = 'Front/reactView';
$route['property/(:any)'] = 'Front/reactView';
$route['property-for-rent'] = 'Front/reactView';
$route['for-rent'] = 'Front/reactView';
$route['buyerData'] = 'Front/reactView';
$route['contact'] = 'Front/reactView';
$route['login'] = 'Front/reactView';
$route['propertyType/(:any)'] = 'Front/reactView';
$route['property-type/(:any)'] = 'Front/reactView';
$route['buyer-data'] = 'Front/reactView';
$route['success'] = 'Front/reactView';
$route['rentDetails/(:any)'] = 'Front/reactView';
$route['projects'] = 'Front/reactView';
$route['project-details/(:any)'] = 'Front/reactView';
$route['project-details/(:num)'] = 'Front/reactView';
$route['single-property/(:num)'] = 'Front/reactView';
$route['privacy-policy'] = 'Front/reactView';
$route['data-deletion'] = 'Front/reactView';
$route['term-and-condition'] = 'Front/reactView';
$route['about'] = 'Front/reactView';
$route['disclaimer'] = 'Front/reactView';
$route['requirment'] = 'Front/reactView';
$route['wishlist'] = 'Front/reactView';
$route['dashboards'] = 'Front/reactView';
$route['home-loan'] = 'Front/reactView';
$route['forget-password'] = 'Front/reactView';
$route['sell-with-us'] = 'Front/reactView';
$route['budget'] = 'Front/reactView';


/*
$route['properties/(:any)'] = 'Front/detailProperties';
$route['search'] = 'Front/searchProperties';
$route['properties'] = 'Front/properties';
$route['purchase-properties'] = 'Front/purchaseProperties';
$route['sale-properties'] = 'Front/saleProperties';
$route['rent-properties'] = 'Front/rentProperties';
$route['contact-us'] = 'Front/contact';
$route['city/(:any)'] = 'Front/cityProperties';
$route['category/(:any)'] = 'Front/categoryProperties';
$route['type/(:any)'] = 'Front/typeProperties';
*/

$route['site-admin'] = 'Siteadmin/Login/index';
$route['manager-login'] = 'Siteadmin/Login/index';
$route['agent-login'] = 'Siteadmin/Login/index';
$route['admin/dashboard'] = 'Siteadmin/Login/dashboard';
$route['admin/logout'] = 'Siteadmin/Login/logout';

$route['admin/properties'] = 'Siteadmin/Properties/index';
$route['admin/import_export'] = 'Siteadmin/Properties/import_export';
//$route['admin/properties/add'] = 'Siteadmin/Properties/addProperties';
$route['admin/properties/add'] = 'Siteadmin/Properties/addProperties1';
$route['admin/properties/updateStatus'] = 'Siteadmin/Properties/updateStatus';
$route['admin/properties/updateBulkStatus'] = 'Siteadmin/Properties/updateBulkStatus';
$route['admin/properties/edit/(:num)'] = 'Siteadmin/Properties/editProperties1/$1';
//$route['admin/properties/edit/(:num)'] = 'Siteadmin/Properties/editProperties/$1';
$route['admin/properties/delete/(:num)'] = 'Siteadmin/Properties/deleteProperties/$1';
$route['admin/properties/export_page'] = 'Siteadmin/Properties/export_page';
$route['admin/properties/export_data'] = 'Siteadmin/Properties/export_data';
$route['admin/properties/import_page'] = 'Siteadmin/properties/import_page';
$route['admin/properties/import_data'] = 'Siteadmin/properties/import_data';
$route['admin/properties/exportSelected'] = 'Siteadmin/Properties/exportSelected';



$route['admin/contact'] = 'Siteadmin/Properties/contact';
/*Leads*/
$route['admin/leads'] = 'Siteadmin/Leads/index';
$route['admin/leads/add'] = 'Siteadmin/Leads/Addleads';
$route['admin/leads/edit/(:num)'] = 'Siteadmin/Leads/editLeads/$1';
$route['admin/leads/delete/(:num)'] = 'Siteadmin/Leads/deleteLeads/$1';
$route['admin/leads/delete-comment/(:num)/(:num)'] = 'Siteadmin/Leads/deleteComment/$1';
$route['admin/leads/personal/(:num)'] = 'Siteadmin/PersonalInfo/index/$1';
$route['admin/leads/view/(:num)'] = 'Siteadmin/LeadsView/index/$1';
$route['admin/leads/deal/(:num)'] = 'Siteadmin/Leads/addDeal';
$route['admin/leads/export_page'] = 'Siteadmin/Leads/export_page';
$route['admin/leads/export_data'] = 'Siteadmin/Leads/export_data';
$route['admin/leads/export'] = 'Siteadmin/Leads/export_leads';
//$route['admin/leads/Comment/edit/(:num)'] = 'Siteadmin/Leads/AddleadsComment/$1';

/*Lead Task*/
$route['admin/task'] = 'Siteadmin/leadtask/index';
$route['admin/leadtask/(:num)'] = 'Siteadmin/LeadTask/index/$1';
$route['admin/leadtask/add/(:num)'] = 'Siteadmin/LeadTask/addTask/$1';
$route['admin/leadtask/edit/(:num)/(:num)'] = 'Siteadmin/LeadTask/editTask/$1';
$route['admin/leadtask/delete/(:num)/(:num)'] = 'Siteadmin/LeadTask/deleteTask/$1';
$route['admin/leadtask/delete-comment/(:num)/(:num)'] = 'Siteadmin/LeadTask/deleteComment/$1';

/*Project*/
$route['admin/projects'] = 'Siteadmin/Project/index';
$route['admin/project/add'] = 'Siteadmin/Project/addProject';
$route['admin/project/edit/(:num)'] = 'Siteadmin/Project/editProject/$1';
$route['admin/project/delete/(:num)'] = 'Siteadmin/Project/deleteProject/$1';

/*Meetings*/
$route['admin/leads/meetings/(:num)'] = 'Siteadmin/Meetings/index/$1';
$route['admin/meeting/add/(:num)'] = 'Siteadmin/Meetings/addMeeting/$1';
$route['admin/meeting/edit/(:num)'] = 'Siteadmin/Meetings/editMeeting/$1';
$route['admin/meeting/delete/(:num)'] = 'Siteadmin/Meetings/deleteMeeting/$1';

/*Task*/
$route['admin/task'] = 'Siteadmin/Task/index';
$route['admin/task/(:num)'] = 'Siteadmin/Task/index/$1';
$route['admin/task/add/(:num)'] = 'Siteadmin/Task/addTask/$1';
$route['admin/task/edit/(:num)/(:num)'] = 'Siteadmin/Task/editTask/$1/$2';
$route['admin/task/delete/(:num)'] = 'Siteadmin/Task/deleteTask/$1';
$route['admin/task/delete-comment/(:num)/(:num)'] = 'Siteadmin/Task/deleteComment/$1';

/*Deal*/
$route['admin/deal'] = 'Siteadmin/Deal/index';
$route['admin/deal/add'] = 'Siteadmin/Deal/dealAdd';
$route['admin/deal/edit/(:num)'] = 'Siteadmin/Deal/dealEdit/$1';
$route['admin/deal/delete/(:num)'] = 'Siteadmin/Deal/dealDelete/$1';

/*Sub Task*/
$route['admin/subtask/(:num)/(:num)'] = 'Siteadmin/SubTask/index/$1/$2';
$route['admin/subtask/add/(:num)/(:num)'] = 'Siteadmin/SubTask/addSubTask/$1/$2';
$route['admin/subtask/edit/(:num)/(:num)/(:num)'] = 'Siteadmin/SubTask/editsubTask/$1/$2/$3';
$route['admin/subtask/delete/(:num)/(:num)'] = 'Siteadmin/SubTask/deletesubTask/$1/$2';
$route['admin/subtask/delete-comment/(:num)/(:num)/(:num)'] = 'Siteadmin/SubTask/deleteComment/$1/$2/$3';

/*Category*/
$route['admin/category'] = 'Siteadmin/Category/index';
$route['admin/category/add'] = 'Siteadmin/Category/categoryAdd';
$route['admin/category/edit/(:num)'] = 'Siteadmin/Category/categoryEdit/$1';
$route['admin/category/delete/(:num)'] = 'Siteadmin/Category/categorydelete/$1';

/*Tag*/
$route['admin/tag'] = 'Siteadmin/Tag/index';
$route['admin/tag/add'] = 'Siteadmin/Tag/tagAdd';
$route['admin/tag/edit/(:num)'] = 'Siteadmin/Tag/tagEdit/$1';
$route['admin/tag/delete/(:num)'] = 'Siteadmin/Tag/tagdelete/$1';

/*User*/
$route['admin/user'] = 'Siteadmin/User/index';
$route['admin/user/add'] = 'Siteadmin/User/userAdd';
$route['admin/user/edit/(:num)'] = 'Siteadmin/User/userEdit/$1';
$route['admin/user/delete/(:num)'] = 'Siteadmin/User/userdelete/$1';

/*agent user register*/
$route['admin/user/edit-agent/(:num)'] = 'Siteadmin/AgentController/edit/$1';

/*rent*/
$route['admin/rent'] = 'Siteadmin/Rent/index';
$route['admin/rent/add'] = 'Siteadmin/Rent/addRent';
$route['admin/rent/edit/(:num)'] = 'Siteadmin/Rent/editRent/$1';
$route['admin/rent/delete/(:num)'] = 'Siteadmin/Rent/deleteRent/$1';

/*Customers*/
$route['admin/customers'] = 'Siteadmin/Customers/index';
$route['admin/customer/add'] = 'Siteadmin/Customers/addCustomer';
$route['admin/customer/edit/(:num)'] = 'Siteadmin/Customers/editCustomer/$1';
$route['admin/customer/delete/(:num)'] = 'Siteadmin/Customers/deleteCustomer/$1';

// Metings
$route['admin/meetings'] = 'Siteadmin/Leads/meeting';
$route['admin/follow-up'] = 'Siteadmin/Leads/follow';

//Properties projects
$route['admin/projects'] = 'Siteadmin/PropertiesProject/index';
$route['admin/projects/add'] = 'Siteadmin/PropertiesProject/addProjects';
$route['admin/projects/delete/(:num)'] = 'PropertiesProject/deleteProject/$1';

$route['admin/projects/edit/(:num)'] = 'Siteadmin/PropertiesProject/editProjects/$1';
$route['admin/projects/delete/(:num)'] = 'Siteadmin/PropertiesProject/deleteProject/$1';

//Properties Approvel
$route['admin/approvel'] = 'Siteadmin/Properties/approve';
//Project Approvel
$route['admin/project-approvel'] = 'Siteadmin/PropertiesProject/approve';

$route['admin/update-approval-status'] = 'Siteadmin/PropertiesProject/updateApprovalStatus';
// whatsapp
$route['admin/whatsapp'] = 'Siteadmin/Whatsapp/index';
$route['admin/whatsapp/(:num)'] = 'Siteadmin/Whatsapp/wtspmessage/$1';

$route['admin/whatsapp-new-user'] = 'Siteadmin/Whatsapp/firstMessage';
//$route['whatsapp/sendWelcome'] = 'Siteadmin/Whatsapp/sendWelcome';

// New Home
$route['new-home-page'] = 'Home/index';
$route['for-sale'] = 'For_Sale/index';
$route['buy'] = 'Buy/index';
$route['for-rent-new'] = 'For_Rent/index';
//$route['sell-with-us'] = 'Sell_With_US/index';

$route['log-in'] = 'Login/index';
$route['contact-us'] = 'Contact_us/index';

// Schedule Demo
$route['schedule-demo'] = 'Schedule_demo/submit_form';

//whatsapp api
$route['whatsapp-api.php'] = 'Whatsapp_api/index';

//Meeting api
$route['api/meetings'] = 'Siteadmin/Leads/meeting_api';


// Company Management Routes
$route['admin/company'] = 'Siteadmin/Company/index';
$route['admin/company/add'] = 'Siteadmin/Company/add';
$route['admin/company/edit/(:num)'] = 'Siteadmin/Company/edit/$1';
$route['admin/company/delete/(:num)'] = 'Siteadmin/Company/delete/$1';


// Chat Routes
$route['admin/chat'] = 'Siteadmin/Chat/index';
$route['admin/chat/add'] = 'Siteadmin/Chat/chatAdd';
$route['admin/chat/edit/(:num)'] = 'Siteadmin/Chat/chatEdit/$1';
$route['admin/chat/delete/(:num)'] = 'Siteadmin/Chat/chatDelete/$1';

// Chat Routes

// $route['admin/projects/chat'] = 'Siteadmin/PropertiesProject/chatProjects';
//$route['admin/projects/chat/(:num)/(:num)'] = 'Siteadmin/PropertiesProject/viewChat/$1/$2';
//$route['admin/projects/send-reply'] = 'Siteadmin/PropertiesProject/sendReply';
// main chat list + optional thread
$route['admin/projects/chat/(:num)/(:num)'] = 'Siteadmin/PropertiesProject/chatProjects/$1/$2';
$route['admin/projects/chat']               = 'Siteadmin/PropertiesProject/chatProjects';









