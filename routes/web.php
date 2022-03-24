<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return view('home');
})->middleware(['CheckUser', 'verified']);

Auth::routes(['verify' => true]);
Route::get('/', 'HomeController@index')->name('home');


// pets
Route::get('/pets', 'PetController@index')->name('pets');
Route::get('/pet/{pet}', 'PetController@show')->name('petDetails');
// get pet by type
Route::get('/type/{type}/pets', 'PetController@getByType')->name('petType');
// get pet by breed
Route::get('/breed/{breed}/pets', 'PetController@getByBreed')->name('petBreed');
// service
Route::get('/services/{service}', 'HomeController@serviceDetails')->name('serviceDetails');
// product
Route::get('/products', 'ProductController@getProducts')->name('products');
Route::get('/products/{product}', 'ProductController@getProduct')->name('product');
Route::get('/products/category/{id}', 'ProductController@getProductByCategory')->name('productByCategory');

Route::get('/about', 'HomeController@about')->name('about');

//admin routes
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/', 'AdminController@index')->name('admin.home');
    // type
    Route::get('/type', 'TypeController@index')->name('type.index');
    Route::post('/type/store', 'TypeController@store')->name('type.store');
    Route::put('/type/{type}', 'TypeController@update')->name('type.update');
    Route::delete('/type/{type}', 'TypeController@destroy')->name('type.destroy');
    // breed
    Route::get('/breed', 'BreedController@index')->name('breed.index');
    Route::post('/breed/store', 'BreedController@store')->name('breed.store');
    Route::put('/breed/{breed}', 'BreedController@update')->name('breed.update');
    Route::delete('/breed/{breed}', 'BreedController@destroy')->name('breed.destroy');
    // pet
    Route::resource('/pets', 'PetController');
    Route::get('/pets/status/{status}', 'PetController@getPetsByStatus')->name('getPetsByStatus');
    Route::get('/pets/breed/{breed}', 'PetController@getPetsByBreed')->name('getPetsByBreed');
    Route::get('/pets/type/{type}', 'PetController@getPetsByType')->name('getPetsByType');
    // reservations
    Route::get('/reservations', 'ReservationController@index')->name('reservations');
    Route::get('/reservations/{reservation}', 'ReservationController@show')->name('reservation');
    // update reservation status
    Route::put('/reservation/{reservation}', 'ReservationController@update')->name('reservation.status');
    // delete reservation
    Route::delete('/reservation/{reservation}', 'ReservationController@destroy')->name('reservation.destroy');
    //get reservation by status
    Route::get('/reservations/status/{status}', 'ReservationController@reservationByStatus')->name('reservationByStatus');

    //  appointment
    Route::get('/appointments', 'AppointmentController@index')->name('appointments');
    Route::get('/appointment/{appointment}', 'AppointmentController@show')->name('appointment');
    // update appointment status
    Route::put('/appointment/{appointment}/status', 'AppointmentController@status')->name('appointment.status');
    // get appointment by status
    Route::get('/appointment/status/{status}', 'AppointmentController@appointmentByStatus')->name('appointmentByStatus');

    // services
    Route::resource('/services', 'ServiceController');

    // users
    Route::get('/users', 'UserController@index')->name('users.index');
    Route::get('/user/{user}', 'UserController@show')->name('user');
    Route::put('/user/ban/{user}', 'UserController@ban')->name('banUser');

    // category
    Route::get('/category', 'CategoryController@index')->name('category.index');
    Route::post('/category/store', 'CategoryController@store')->name('category.store');
    Route::put('/category/{category}', 'CategoryController@update')->name('category.update');
    Route::delete('/category/{category}', 'CategoryController@destroy')->name('category.destroy');


    Route::resource('/products', 'ProductController');
    Route::get('/orders', 'OrderController@index')->name('orders');
    Route::get('/order/{order}', 'OrderController@show')->name('order');
    Route::put('/orders/{order}', 'OrderController@updateStatus')->name('orders.updateStatus');
});

//user routes
Route::group(['namespace' => 'User', 'middleware' => [ 'auth', 'verified', 'CheckUser']], function () {
    // reservation
    Route::get('/reservations', 'ReservationController@index')->name('user.reservations');
    Route::get('/pet/{pet}/reservation', 'ReservationController@create')->name('reservation.create');
    Route::post('/reservation', 'ReservationController@store')->name('reservation.store');
    Route::put('/reservation/{reservation}/cancel', 'ReservationController@cancel')->name('reservation.cancel');

    // appointment
    Route::get('/appointments', 'AppointmentController@index')->name('user.appointments');
    Route::get('/appointment/create', 'AppointmentController@create')->name('appointment.create');
    Route::post('/appointment', 'AppointmentController@store')->name('appointment.store');
    Route::put('/appointment/{appointment}/cancel', 'AppointmentController@cancel')->name('appointment.cancel');
    // Route::delete('/appointment/{appointment}', 'AppointmentController@destroy')->name('appointment.destroy');


    Route::get('/profile', 'UserController@profile')->name('profile');
    Route::put('/profile/{user}', 'UserController@update')->name('profile.update');

    // Cart
    Route::get('/carts', 'CartController@index')->name('carts.index');
    Route::get('/add-to-cart/{product:id}', 'CartController@add')->name('carts.add');
    Route::get('/remove/{product:id}', 'CartController@remove')->name('carts.remove');
    Route::get('/remove-to-cart/{product:id}', 'CartController@destroy')->name('carts.destroy');
    Route::put('/carts/update/{product:id}', 'CartController@update')->name('carts.update');

    //order
    // Route::resource('/orders', 'OrderController');
    Route::get('/orders', 'OrderController@index')->name('orders.index');
    Route::get('/order/{order}', 'OrderController@show')->name('orders.show');
    Route::put('/cancel/{order}', 'OrderController@cancelOrder')->name('orders.cancel');
    Route::get('/print/{order}', 'OrderController@printOrder')->name('orders.print');

    Route::get('/checkout', 'CheckoutController@checkout')->name('checkout');
    Route::post('/place-order', 'CheckoutController@store')->name('place-order');

    Route::post('/shippingAddresses', 'ShippingAddressController@store')->name('shippingAddresses.store');
    Route::put('/shippingAddresses/{shippingAddress}', 'ShippingAddressController@update')->name('shippingAddresses.update');
    Route::delete('/shippingAddresses/{shippingAddress}', 'ShippingAddressController@destroy')->name('shippingAddresses.destroy');
});


Route::get('/storage-link', function () {
    $targetFolder =  '/home/u993972610/domains/premiumkennel.online/pet_reservation/storage/app/public';
    $linkFolder = $_SERVER['DOCUMENT_ROOT'].'/storage';
    symlink($targetFolder,$linkFolder);
    echo 'success';
});

// // migrate
// Route::get('/migrate', function () {
//     Artisan::call('migrate:fresh');
//     return 'migrate success';
// });
// // db seed
// Route::get('/seed', function () {
//     Artisan::call('db:seed');
//     return 'seed success';
// });