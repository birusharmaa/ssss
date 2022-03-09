<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

// $routes->get('/dashboard', 'Dashboard::index');

// $routes->resource('photos');

// $routes->post('settings', 'users::settingPage');

// Equivalent to the following:
// $routes->get('user/new',             'users::new');
// $routes->post('user',                'users::create');
// $routes->get('user',                 'users::index');
// $routes->get('user/(:segment)',      'users::show/$1');
// $routes->get('user/(:segment)/edit', 'users::edit/$1');
// $routes->put('user/(:segment)',      'users::update/$1');
// $routes->patch('user/(:segment)',    'users::update/$1');
// $routes->delete('user/(:segment)',   'users::delete/$1');



$routes->post('login', 'Login::login');

// $routes->get('auth', 'Users::index');/leads/search/

$routes->get('logout', 'Dashboard::logout');

$routes->post('change-password', 'Login::savePassword');
$routes->post('reset-password', 'Login::resetPassword');
$routes->post('register', 'Login::create');

$routes->get('forgot-password', 'Users::forgotPassword');

$routes->group('auth',function ($routes) {
    $routes->get('change-password', 'Login::passwordChange');
});

/**
 * Routes for pages 
 */
$routes->group('admin', ["filter" => "mysess"], function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('websettings', 'Dashboard::settingPage');
    $routes->get('category', 'Dashboard::category');
    $routes->get('roles', 'Dashboard::role');
    $routes->get('new-leads', 'Dashboard::new_leads');
    $routes->get('lead/(:any)', 'Dashboard::leadDetails/$1');
    $routes->get('subcategory/(:any)', 'Admin::getSubCategory/$1');
    $routes->get('profile-setting', 'Settings::index/');
    $routes->get('final-leads', 'Dashboard::FinalLeads');
    $routes->get('follow-up', 'Dashboard::followupView');
    $routes->get('admission', 'Dashboard::admission');
    $routes->get('add_lead/(:any)', 'Dashboard::add_lead/$1');
    $routes->get('fee-collection', 'Dashboard::fee_collection');
    $routes->get('status', 'Dashboard::status');
    $routes->get('enquiry', 'Enquiry::index');
});

$routes->group('settings', ["filter" => "mysess"], function ($routes) {
    $routes->get('accounts', 'Dashboard::accounts');
    $routes->get('location', 'Dashboard::location');
    $routes->get('subject', 'Dashboard::subject');
    $routes->get('sysdetails', 'Dashboard::systemDetails');
    $routes->get('team', 'Dashboard::team');
    $routes->get('enqstatus', 'Dashboard::enqStatus');
});
$routes->group('user', ["filter" => "mysess"], function ($routes) {    
    $routes->get('profile-setting', 'Settings::index/');
});

$routes->group('fee', ['filter' => 'myauth'], function ($routes) {   
    $routes->post('collect','FeeCollect::create'); 
    $routes->get('comments/(:any)','FeeCollect::comments/$1');     
});

/**
 * Routes for admin apis
 */
$routes->group('api', ["filter" => "myauth"], function ($routes) {
    $routes->post('dashboad', 'Admin::dashBoardData');
    $routes->put('setting', 'Admin::updateSetting');
    $routes->get('users', 'Admin::allusers');
    $routes->post('upload_logo', 'Admin::updateSubSiteLogo');
    $routes->post('lead-data', 'Lead::getLeadBySearch');
    $routes->post('assignlead', 'Lead::assignLead');
    $routes->post('updatecomments', 'Lead::updateLeadComments');
    $routes->post('unsubscribe-leads', 'Lead::unsubscribeLeads');
    $routes->get('followuplist', 'Lead::getFolloupList');
    $routes->get('unsubscribelist', 'Lead::getUnsubscribedList');
});

$routes->post('authpass', 'AuthController::checkUser');

$routes->group('profile', ["filter" => "myauth"], function ($routes) {

    $routes->post('image_update/(:any)','ProfileController::updateImage/$1');
    $routes->delete('image_delete/(:any)','ProfileController::deleteImage/$1');
    $routes->put('update_password/(:any)','ProfileController::update_password/$1');
    $routes->put('update_general/(:any)','ProfileController::update_general/$1');
    $routes->get('search','ProfileController::search');
});

$routes->group('settings', ["filter" => "mysess"], function ($routes) {
    $routes->get('accounts', 'Dashboard::accounts'); 
    $routes->get('location', 'Dashboard::location');
    $routes->get('subject', 'Dashboard::subject');
    $routes->get('sysdetails', 'Dashboard::systemDetails');
    $routes->get('team', 'Dashboard::team');
    $routes->get('enqstatus', 'Dashboard::enqStatus');
    $routes->get('teamview/(:any)', 'Dashboard::teamview/$1');
});

$routes->group('leads',['filter' => 'myauth'], function ($routes) {
    $routes->post('search','Lead::search');
});

$routes->group('leadsapi', ['filter' => 'myauth'], function ($routes) {
    $routes->get('leads','Lead::index');
    $routes->get('lead/(:segment)','Lead::show/$1');
    $routes->post('insert','Lead::create');
    $routes->post('updateImage/(:any)','Lead::updateImage/$1');
    $routes->put('update/(:segment)','Lead::update/$1');
    $routes->delete('delete/(:any)','Lead::delete/$1');
    $routes->delete('deleteImage/(:any)','Lead::deleteImage/$1');
    $routes->post('import','Lead::import');
    $routes->put('update_add/(:any)','Lead::update_add/$1'); 
    $routes->get('lead_fee/(:any)','Lead::lead_fee/$1');
});

$routes->group('catapi', ['filter' => 'myauth'], function ($routes) {
    $routes->get('categories','Category::index');
    $routes->get('show/(:any)','Category::show/$1');
    $routes->post('insert','Category::create');
    $routes->delete('delete/(:any)','Category::delete/$1');    
    $routes->put('update/(:any)','Category::update/$1');  
});

$routes->group('subapi', ['filter' => 'myauth'], function ($routes) {
    $routes->get('subcategories/(:any)','SubCategory::index/$1');
    $routes->get('show/(:any)','SubCategory::show/$1');
    $routes->post('insert','SubCategory::create');
    $routes->delete('delete/(:any)','SubCategory::delete/$1');    
    $routes->put('update/(:any)','SubCategory::update/$1');  
});

$routes->group('status', ['filter' => 'myauth'], function ($routes) {
    $routes->get('all','Status::index');
    $routes->get('show/(:any)','Status::show/$1');
    $routes->post('insert','Status::create');
    $routes->delete('delete/(:any)','Status::delete/$1');    
    $routes->put('update/(:any)','Status::update/$1');  
});

$routes->group('account', ['filter' => 'myauth'], function ($routes) {
    $routes->get('all','Account::index');
    $routes->get('show/(:any)','Account::show/$1');
    $routes->post('insert','Account::create');
    $routes->delete('delete/(:any)','Account::delete/$1');    
    $routes->put('update/(:any)','Account::update/$1');  
});

$routes->group('enquiry', ['filter' => 'myauth'], function ($routes) {
    $routes->get('all','EnqStatus::index');
    $routes->get('show/(:any)','EnqStatus::show/$1');
    $routes->post('insert','EnqStatus::create');
    $routes->delete('delete/(:any)','EnqStatus::delete/$1');    
    $routes->put('update/(:any)','EnqStatus::update/$1');  
});

$routes->group('location', ['filter' => 'myauth'], function ($routes) {
    $routes->get('all','Location::index');
    $routes->get('show/(:any)','Location::show/$1');
    $routes->post('insert','Location::create');
    $routes->delete('delete/(:any)','Location::delete/$1');    
    $routes->put('update/(:any)','Location::update/$1');  
});

$routes->group('system', ['filter' => 'myauth'], function ($routes) {
    $routes->get('all','SystemDetials::index');
    $routes->get('show/(:any)','SystemDetials::show/$1');
    $routes->post('insert','SystemDetials::create');
    $routes->delete('delete/(:any)','SystemDetials::delete/$1');    
    $routes->put('update/(:any)','SystemDetials::update/$1');  
});

$routes->group('subject', ['filter' => 'myauth'], function ($routes) {
    $routes->get('all','Subject::index');
    $routes->get('show/(:any)','Subject::show/$1');
    $routes->post('insert','Subject::create');
    $routes->delete('delete/(:any)','Subject::delete/$1');    
    $routes->put('update/(:any)','Subject::update/$1');  
});

$routes->group('team', ['filter' => 'myauth'], function ($routes) {
    $routes->get('all','Team::index');
    $routes->get('show/(:any)','Team::show/$1');
    $routes->post('insert','Team::create');
    $routes->delete('delete/(:any)','Team::delete/$1');    
    $routes->put('update/(:any)','Team::update/$1');
    $routes->post('insertImage/(:any)','Team::insertImage/$1'); 
    $routes->put('deleteImage/(:any)','Team::deleteImage/$1');    
});

$routes->group('leadsApi', ['filter' => 'myauth'], function ($routes) {

    $routes->get('all','Enquiry::getAllLeads');
    $routes->get('show/(:num)','Enquiry::show/$1');
    $routes->post('fetchData','Enquiry::fetchData');
    $routes->post('saveComment','Enquiry::saveComment');
    $routes->post('updateUserDetails','Enquiry::updateUserDetails');
    $routes->post('insertLead','Enquiry::insertLead');
    $routes->post('import','Enquiry::import');
    $routes->post('sendMessage','Enquiry::sendMessage'); 
    $routes->post('searchValue','Enquiry::searchValue');   

    
    // $routes->put('update/(:any)','Category::update/$1');  
});





/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
