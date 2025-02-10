<?php

namespace Config;

use App\Controllers\Admin\Settings;
use CodeIgniter\Router\RouteCollection;

$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
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
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved$ to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->get('pharmacy/(:num)', 'Pharmacy::profile/$1');
$routes->post('pharmacy/add-to-cart', 'Pharmacy::addToCart');
$routes->post('order/create', 'Order::create');
$routes->get('order/confirmation/(:num)', 'Order::confirmation/$1');



// Super Admin routes
$routes->group('', ['hostname' => 'admin.chrisbertconsult.org'], function ($routes) {

    $routes->get('/', 'Admin\Dashboard::index');
    $routes->get('pharmacies', 'Admin\PharmacyManagement::index');
    $routes->get('pharmacies/pending', 'Admin\PharmacyManagement::pendingApprovals');
    $routes->post('pharmacies/approve/(:num)', 'Admin\PharmacyManagement::approve/$1');
    $routes->post('pharmacies/reject/(:num)', 'Admin\PharmacyManagement::reject/$1');
    $routes->post('pharmacies/toggle-active/(:num)', 'Admin\PharmacyManagement::toggleActive/$1');
    $routes->get('drugs', 'Admin\DrugManagement::index');
    $routes->get('drugs/categories', 'Admin\DrugManagement::categories');
    $routes->get('drugs/add-category', 'Admin\DrugManagement::addCategory');
    $routes->post('drugs/add-category', 'Admin\DrugManagement::addCategory');
    $routes->get('drugs/pending', 'Admin\DrugManagement::pendingApprovals');
    $routes->get('drugs/approve/(:num)', 'Admin\DrugManagement::approve/$1');
    $routes->get('drugs/reject/(:num)', 'Admin\DrugManagement::reject/$1');
    $routes->get('users', 'Admin\UserManagement::index');
    $routes->get('users/edit/(:num)', 'Admin\UserManagement::edit/$1');
    $routes->post('users/edit/(:num)', 'Admin\UserManagement::edit/$1');
    $routes->get('users/delete/(:num)', 'Admin\UserManagement::delete/$1');
    $routes->get('settings', 'Admin::settings');
    $routes->post('settings', 'Admin::settings');
    // Added
    $routes->get('drugs/add', 'Admin\DrugManagement::add');
    $routes->post('drugs/add', 'Admin\DrugManagement::add');
    $routes->get('orders', 'Admin\OrderManagement::index');
    $routes->get('orders/view/(:num)', 'Admin\OrderManagement::view/$1');
    $routes->get('drugs/delete-category/(:num)', 'Admin\DrugManagement::deleteCategory/$1');
    $routes->get('drugs/edit-category/(:num)', 'Admin\DrugManagement::editCategory/$1');
    $routes->post('drugs/edit-category/(:num)', 'Admin\DrugManagement::editCategory/$1');
    $routes->get('drugs/delete/(:num)', 'Admin\DrugManagement::delete/$1');
    $routes->get('drugs/edit/(:num)', 'Admin\DrugManagement::edit/$1');
    $routes->post('drugs/edit/(:num)', 'Admin\DrugManagement::edit/$1');
    $routes->get('drugs/bulk-upload', 'Admin\DrugManagement::bulkUpload');
    $routes->post('drugs/bulk-upload', 'Admin\DrugManagement::bulkUpload');
    $routes->get('drugs/download-template', 'Admin\DrugManagement::downloadTemplate');
    $routes->post('drugs/upload-image', 'Admin\DrugImageController::uploadImage');
    $routes->get('drugs/upload-image', 'Admin\DrugImageController::index');
    
    // Pharmacy routes
    $routes->get('pharmacies/edit/(:num)', 'Admin\PharmacyManagement::edit/$1');
    $routes->post('pharmacies/edit/(:num)', 'Admin\PharmacyManagement::edit/$1');
    $routes->get('pharmacies/view/(:num)', 'Admin\PharmacyManagement::view/$1');
    $routes->get('pharmacies/delete/(:num)', 'Admin\PharmacyManagement::delete/$1');
    $routes->get('pharmacies/add', 'Admin\PharmacyManagement::add');
    $routes->post('pharmacies/add', 'Admin\PharmacyManagement::add');
    
    $routes->get('testimonials', 'Admin\TestimonialManagement::index');
    $routes->get('testimonials/add', 'Admin\TestimonialManagement::add');
    $routes->post('testimonials/add', 'Admin\TestimonialManagement::add');
    $routes->get('testimonials/edit/(:num)', 'Admin\TestimonialManagement::edit/$1');
    $routes->post('testimonials/edit/(:num)', 'Admin\TestimonialManagement::edit/$1');
    $routes->get('testimonials/delete/(:num)', 'Admin\TestimonialManagement::delete/$1');

    $routes->get('delivery-partners', 'Admin\DeliveryPartnerController::index');
    $routes->get('delivery-partners/create', 'Admin\DeliveryPartnerController::create');
    $routes->post('delivery-partners/create', 'Admin\DeliveryPartnerController::create');
    $routes->get('delivery-partners/edit/(:num)', 'Admin\DeliveryPartnerController::edit/$1');
    $routes->post('delivery-partners/edit/(:num)', 'Admin\DeliveryPartnerController::edit/$1');
    $routes->get('delivery-partners/delete/(:num)', 'Admin\DeliveryPartnerController::delete/$1');

    $routes->get('blog', 'Admin\Blog::index');
    $routes->match(['get', 'post'], 'blog/create', 'Admin\Blog::create');
    $routes->match(['get', 'post'], 'blog/edit/(:num)', 'Admin\Blog::edit/$1');
    $routes->get('blog/delete/(:num)', 'Admin\Blog::delete/$1');
    
    $routes->post('stocks/upload', 'Admin\StockController::uploadCSV');
    $routes->post('stocks/map', 'Admin\StockController::mapColumns');
    $routes->get('stocks/upload', 'Admin\StockController::index');
    // Report routes
    $routes->get('report', 'Admin\ReportController::index');
    $routes->get('reports/generate-pdf-report', 'Admin\ReportController::generatePDFReport');
    $routes->get('reports/export-csv', 'Admin\ReportController::exportCSV');
    $routes->get('reports/sales-by-pharmacy', 'Admin\ReportController::generateSalesByPharmacyPDF');

    // Subscription Plan routes
    $routes->get('subscription-plans', 'Admin\SubscriptionPlanController::index');
    $routes->get('subscription-plans/create', 'Admin\SubscriptionPlanController::create');
    $routes->post('subscription-plans/store', 'Admin\SubscriptionPlanController::store');
    $routes->get('subscription-plans/edit/(:num)', 'Admin\SubscriptionPlanController::edit/$1');
    $routes->post('subscription-plans/update/(:num)', 'Admin\SubscriptionPlanController::update/$1');
    $routes->get('subscription-plans/delete/(:num)', 'Admin\SubscriptionPlanController::delete/$1');
    
    // Add these lines inside the admin group
    $routes->get('inventory/low-stock', 'Admin::lowStock');
    $routes->get('activities', 'Admin::recentActivities');
    
});

// User subdomain routes
$routes->group('', ['hostname' => 'user.chrisbertconsult.org'], function ($routes) {
    $routes->get('/', 'UserDashboard::index');
    // ...existing user routes...
    $routes->get('profile', 'UserProfile::index');
    $routes->get('dashboard', 'UserDashboard::index');
    $routes->get('profile/edit', 'UserProfile::edit');
    $routes->post('profile/update', 'UserProfile::update');
    $routes->get('change-password', 'UserDashboard::changePassword');
    $routes->post('change-password', 'UserDashboard::changePassword');
    
    $routes->get('orders', 'Order::userOrders');
    $routes->get('order-history', 'UserDashboard::orderHistory');
    $routes->get('order/order_view/(:num)', 'Order::view/$1');


    $routes->get('settings', 'UserSettings::index');
    $routes->post('settings/update', 'UserSettings::update');
    $routes->get('drugs', 'UserDrugs::index');
    $routes->match(['GET', 'POST'], 'drugs/edit/(:num)', 'UserDrugs::edit/$1');
    $routes->match(['GET', 'POST'], 'drugs/add', 'UserDrugs::add');
    $routes->get('drugs/delete/(:num)', 'UserDrugs::delete/$1');
});

// Pharmacy subdomain routes
$routes->group('', ['hostname' => 'pharmacy.chrisbertconsult.org'], function ($routes) {
    $routes->get('/', 'Pharmacy\Dashboard::index');
    // ...existing pharmacy routes...
    $routes->get('profile', 'Pharmacy\Profile::index');
    $routes->post('profile', 'Pharmacy\Profile::update');
    $routes->get('inventory', 'Pharmacy\Inventory::index');
    $routes->get('inventory/add', 'Pharmacy\Inventory::add');
    $routes->post('inventory/add', 'Pharmacy\Inventory::add');
    $routes->get('inventory/edit/(:num)', 'Pharmacy\Inventory::edit/$1');
    $routes->post('inventory/edit/(:num)', 'Pharmacy\Inventory::edit/$1');
    $routes->post('inventory/update-availability', 'Pharmacy\Inventory::updateAvailability');
    $routes->post('inventory/threshold-update', 'Pharmacy\Inventory::thresholdUpdate');
    $routes->get('inventory/delete/(:num)', 'Pharmacy\Inventory::delete/$1');
    $routes->get('inventory/bulk-upload', 'Pharmacy\Inventory::bulkUpload');
    $routes->post('inventory/bulk-upload', 'Pharmacy\Inventory::bulkUpload');
    $routes->get('inventory/download-template', 'Pharmacy\Inventory::downloadTemplate');
    $routes->get('orders', 'Pharmacy\Orders::index');
    $routes->get('orders/view/(:num)', 'Pharmacy\Orders::view/$1');
    $routes->post('orders/update-status/(:num)', 'Pharmacy\Orders::updateStatus/$1');
    $routes->get('orders/assign-delivery/(:num)', 'Pharmacy\Orders::assignDelivery/$1');
    $routes->post('orders/assign-delivery/(:num)', 'Pharmacy\Orders::assignDelivery/$1');

    // Add these new routes
    // $routes->get('subscription', 'Pharmacy\Subscription::index');
    // $routes->post('subscription/upgrade', 'Pharmacy\Subscription::upgrade');
    $routes->post('subscription/toggle-premium', 'Pharmacy\Subscription::togglePremium');
    // Subscription management routes
    $routes->get('subscription', 'Pharmacy\SubscriptionController::index');
    $routes->post('subscription/upgrade', 'Pharmacy\SubscriptionController::upgrade');
    $routes->post('subscription/cancel', 'Pharmacy\SubscriptionController::cancel');

     $routes->get('drugs', 'Pharmacy\Drugs::index');
     $routes->get('drugs/add', 'Pharmacy\Drugs::add');
     $routes->post('drugs/add', 'Pharmacy\Drugs::add');
     $routes->get('drugs/edit/(:num)', 'Pharmacy\Drugs::edit/$1');
     $routes->post('drugs/edit/(:num)', 'Pharmacy\Drugs::edit/$1');
     $routes->get('drugs/delete/(:num)', 'Pharmacy\Drugs::delete/$1');
     
     //delivery partners
     $routes->get('delivery-partners', 'Pharmacy\DeliveryPartnerController::index');
     $routes->get('delivery-partners/create', 'Pharmacy\DeliveryPartnerController::create');
     $routes->post('delivery-partners/create', 'Pharmacy\DeliveryPartnerController::create');
     $routes->get('delivery-partners/edit/(:num)', 'Pharmacy\DeliveryPartnerController::edit/$1');
     $routes->post('delivery-partners/edit/(:num)', 'Pharmacy\DeliveryPartnerController::edit/$1');
     $routes->get('delivery-partners/delete/(:num)', 'Pharmacy\DeliveryPartnerController::delete/$1');
 
     //Settings
     $routes->get('analytics', 'Pharmacy\Analytics::index');
     $routes->get('reports', 'Pharmacy\Reports::index');
     $routes->get('settings', 'Pharmacy\Settings::index');
     $routes->post('settings', 'Pharmacy\Settings::index');
});

// Driver subdomain routes
$routes->group('', ['hostname' => 'driver.chrisbertconsult.org'], function ($routes) {
    $routes->get('/', 'Driver\Dashboard::index');
    // ...existing driver routes...
    $routes->post('update-delivery-status', 'Driver\Dashboard::updateDeliveryStatus');
    $routes->post('update-location', 'Driver\Dashboard::updateLocation');
    $routes->get('track-delivery/(:num)', 'Driver\Dashboard::trackDelivery/$1');
});

// Auth routes
$routes->get('login', 'Auth::login');
$routes->post('authenticate', 'Auth::authenticate');  // Add this line for POST login
$routes->get('logout', 'Auth::logout');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::register');
$routes->get('verify2fa/(:num)', 'Auth::verify2fa/$1');
$routes->post('verify2fa/(:num)', 'Auth::verify2fa/$1');
$routes->get('enable2fa', 'Auth::enable2fa');
$routes->get('disable2fa', 'Auth::disable2fa');

// Add routes for Google login and callback
$routes->get('login/google', 'GoogleLoginController::login');
$routes->get('login/google/callback', 'GoogleLoginController::callback');
$routes->get('logout', 'GoogleLoginController::logout');

// Pharmacy Admin routes
$routes->group('pharmacy', ['filter' => 'auth:pharmacy_admin'], function (RouteCollection $routes) {
    $routes->get('/', 'Pharmacy\Dashboard::index');
    $routes->get('profile', 'Pharmacy\Profile::index');
    $routes->post('profile', 'Pharmacy\Profile::update');
    $routes->get('inventory', 'Pharmacy\Inventory::index');
    $routes->get('inventory/add', 'Pharmacy\Inventory::add');
    $routes->post('inventory/add', 'Pharmacy\Inventory::add');
    $routes->get('inventory/edit/(:num)', 'Pharmacy\Inventory::edit/$1');
    $routes->post('inventory/edit/(:num)', 'Pharmacy\Inventory::edit/$1');
    $routes->post('inventory/update-availability', 'Pharmacy\Inventory::updateAvailability');
    $routes->post('inventory/threshold-update', 'Pharmacy\Inventory::thresholdUpdate');
    $routes->get('inventory/delete/(:num)', 'Pharmacy\Inventory::delete/$1');
    $routes->get('inventory/bulk-upload', 'Pharmacy\Inventory::bulkUpload');
    $routes->post('inventory/bulk-upload', 'Pharmacy\Inventory::bulkUpload');
    $routes->get('inventory/download-template', 'Pharmacy\Inventory::downloadTemplate');
    $routes->get('orders', 'Pharmacy\Orders::index');
    $routes->get('orders/view/(:num)', 'Pharmacy\Orders::view/$1');
    $routes->post('orders/update-status/(:num)', 'Pharmacy\Orders::updateStatus/$1');
    $routes->get('orders/assign-delivery/(:num)', 'Pharmacy\Orders::assignDelivery/$1');
    $routes->post('orders/assign-delivery/(:num)', 'Pharmacy\Orders::assignDelivery/$1');

    // Add these new routes
    // $routes->get('subscription', 'Pharmacy\Subscription::index');
    // $routes->post('subscription/upgrade', 'Pharmacy\Subscription::upgrade');
    $routes->post('subscription/toggle-premium', 'Pharmacy\Subscription::togglePremium');
    // Subscription management routes
    $routes->get('subscription', 'Pharmacy\SubscriptionController::index');
    $routes->post('subscription/upgrade', 'Pharmacy\SubscriptionController::upgrade');
    $routes->post('subscription/cancel', 'Pharmacy\SubscriptionController::cancel');

     $routes->get('drugs', 'Pharmacy\Drugs::index');
     $routes->get('drugs/add', 'Pharmacy\Drugs::add');
     $routes->post('drugs/add', 'Pharmacy\Drugs::add');
     $routes->get('drugs/edit/(:num)', 'Pharmacy\Drugs::edit/$1');
     $routes->post('drugs/edit/(:num)', 'Pharmacy\Drugs::edit/$1');
     $routes->get('drugs/delete/(:num)', 'Pharmacy\Drugs::delete/$1');
     
     //delivery partners
     $routes->get('delivery-partners', 'Pharmacy\DeliveryPartnerController::index');
     $routes->get('delivery-partners/create', 'Pharmacy\DeliveryPartnerController::create');
     $routes->post('delivery-partners/create', 'Pharmacy\DeliveryPartnerController::create');
     $routes->get('delivery-partners/edit/(:num)', 'Pharmacy\DeliveryPartnerController::edit/$1');
     $routes->post('delivery-partners/edit/(:num)', 'Pharmacy\DeliveryPartnerController::edit/$1');
     $routes->get('delivery-partners/delete/(:num)', 'Pharmacy\DeliveryPartnerController::delete/$1');
 
     //Settings
     $routes->get('analytics', 'Pharmacy\Analytics::index');
     $routes->get('reports', 'Pharmacy\Reports::index');
     $routes->get('settings', 'Pharmacy\Settings::index');
     $routes->post('settings', 'Pharmacy\Settings::index');
});

$routes->group('driver', ['filter' => 'auth:driver'], function ($routes) {
    $routes->get('dashboard', 'Driver\Dashboard::index');
    $routes->post('update-delivery-status', 'Driver\Dashboard::updateDeliveryStatus');
    $routes->post('update-location', 'Driver\Dashboard::updateLocation');
    $routes->get('track-delivery/(:num)', 'Driver\Dashboard::trackDelivery/$1');
});

// Api
// $routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {
//     $routes->post('inventory/batch-upload', 'InventoryController::batchUpload');
//     $routes->put('inventory/stock/(:num)', 'InventoryController::updateStock/$1');
//     $routes->post('inventory/sync-fhir', 'InventoryController::syncFHIR');
// });
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {
    $routes->get('drugs/search', 'DrugController::search');
    $routes->get('search', 'SearchController::search');
    $routes->get('stock-updates', 'StockUpdatesController::stream');
    $routes->get('update-drugs', 'DrugUpdateController::updateDrugs');
    $routes->get('update-drug-images', 'DrugImageUpdateController::updateImages');
    $routes->get('fill-missing-fields', 'DrugUpdateController::fillMissingFields');
});

// User profile routes
$routes->group('user', ['filter' => 'auth'], function ($routes) {
    $routes->get('profile', 'UserProfile::index');
    $routes->get('dashboard', 'UserDashboard::index');
    $routes->get('profile/edit', 'UserProfile::edit');
    $routes->post('profile/update', 'UserProfile::update');
    $routes->get('change-password', 'UserDashboard::changePassword');
    $routes->post('change-password', 'UserDashboard::changePassword');
    
    $routes->get('orders', 'Order::userOrders');
    $routes->get('order-history', 'UserDashboard::orderHistory');
    $routes->get('order/order_view/(:num)', 'Order::view/$1');


    $routes->get('settings', 'UserSettings::index');
    $routes->post('settings/update', 'UserSettings::update');
    $routes->get('drugs', 'UserDrugs::index');
    $routes->match(['GET', 'POST'], 'drugs/edit/(:num)', 'UserDrugs::edit/$1');
    $routes->match(['GET', 'POST'], 'drugs/add', 'UserDrugs::add');
    $routes->get('drugs/delete/(:num)', 'UserDrugs::delete/$1');
});

// Order routes
$routes->group('order', ['filter' => 'auth'], function ($routes) {
    $routes->get('add/(:num)', 'Order::add/$1');
    $routes->post('create', 'Order::create');
    $routes->get('confirmation/(:num)', 'Order::confirmation/$1');
    $routes->get('track/(:num)', 'Order::track/$1');
    $routes->get('history', 'Order::history');
    $routes->get('reorder/(:num)', 'Order::reorder/$1');
    $routes->get('checkout', 'Order::checkout');
});

// Search routes
$routes->get('search', 'Search::index');
$routes->get('search/results', 'Search::results');
$routes->get('search/autocomplete', 'Search::autocomplete');

// Cart routes
$routes->get('cart', 'Cart::index');
$routes->post('cart/update', 'Cart::update');
$routes->post('cart/add', 'Cart::add');
$routes->get('cart/remove', 'Cart::remove');

// Payment routes
$routes->post('payment/process/(:num)', 'Payment::process/$1');

// Favorites routes
$routes->post('favorites/toggle', 'Favorites::toggle');

// Compare routes
$routes->post('compare/add', 'Compare::add');

// User registration routes
$routes->get('register/user', 'Auth\UserRegistration::index');
$routes->post('register/user', 'Auth\UserRegistration::register');
$routes->post('register/process', 'Auth\UserRegistration::process');

// Pharmacy registration routes
$routes->get('register/pharmacy', 'Auth\PharmacyRegistration::index');
$routes->post('register/pharmacy', 'Auth\PharmacyRegistration::register');

// Driver registration routes
$routes->get('register/driver', 'Auth\DriverRegistration::index');
$routes->post('register/driver', 'Auth\DriverRegistration::register');

// Add these new routes for pharmacy registration
$routes->get('pharmacy-registration', 'PharmacyRegistration::index');
$routes->post('pharmacy-registration/register', 'PharmacyRegistration::register');

// Add new routes here
$routes->get('drug/(:num)', 'Drug::view/$1');
$routes->get('order/add/(:num)', 'Order::add/$1');
$routes->post('order/create', 'Order::create');
$routes->get('about', 'Pages::about');
$routes->get('faqs', 'Pages::faqs');
$routes->get('contact', 'Pages::contact');
$routes->get('pharmacies', 'Pharmacies::index');

// Support routes
$routes->get('privacy', 'Pages::privacyPolicy');
$routes->get('support', 'Support::index');
$routes->post('support/submit-ticket', 'Support::submitTicket');
$routes->post('support/submit-feedback', 'Support::submitFeedback');

$routes->get('notifications', 'NotificationController::index');
$routes->get('notifications/unread', 'NotificationController::getUnreadNotifications');
$routes->post('notifications/markAsRead/(:num)', 'NotificationController::markAsRead/$1');

$routes->post('feedback/submit', 'Feedback::submit');
$routes->get('blog', 'Blog::index');
$routes->get('reviews/create/(:num)', 'Reviews::create/$1');
$routes->post('reviews/create/(:num)', 'Reviews::create/$1');
$routes->get('blog/(:any)', 'Blog::view/$1');

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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

