<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\DoctorsController;
use App\Http\Controllers\Admin\MeetingsController;
use App\Http\Controllers\Admin\MessagesController;
use App\Http\Controllers\UserController;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Blade : view engine
 */
Route::group([], function () {
    Route::get('/', [WebsiteController::class, 'home']);
    Route::get('/about', [WebsiteController::class, 'about']);
    Route::get('/contactus', [WebsiteController::class, 'contactus']);
    Route::post('/messages', [WebsiteController::class, 'messages'])->name('messages');
    
    Route::get('/doctors', [WebsiteController::class, 'doctors']);
    Route::get('/doctors/{id}', [WebsiteController::class, 'show'])->name('web.doctors.show');
    Route::post('/doctors-comment/{id}', [WebsiteController::class, 'doctor_comment'])->name('web.doctors.comment.store');
    Route::delete('/del-doctors-comment/{id}', [WebsiteController::class, 'destroy_comment'])->name('web.doctors.comment.destroy');
    
    Route::post('/request_date/{id}', [WebsiteController::class, 'request_date'])->name('request_date');

    Route::get('/profile/{id}', [UserController::class, 'show'])->name('profile.show');
    Route::put('/profile/{id}', [UserController::class, 'update'])->name('profile.update');
});

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('users', UsersController::class);
    Route::resource('doctors', DoctorsController::class);
    Route::resource('meetings', MeetingsController::class);
    Route::get('messages', [MessagesController::class, 'index'])->name('messages.index');
    Route::delete('messages/{id}', [MessagesController::class, 'destroy'])->name('messages.destroy');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/test', function () {
    $token = 'eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6Imw4a0NGWGowUVhTZXFvQkFYTFlhbFEiLCJleHAiOjE2NTA4NDUyMDksImlhdCI6MTY1MDc1ODgxMH0.sas631o8FDoCdm7hSqdSbx4N2sa7LubJs-mclv-SUWI';
    // $headers    =   [
    //     'headers' => [
    //     'Content-Type' => 'application/json',
    //       'Authorization' => "Bearer $token",
    //     ],
    //     'http_errors' => false,
    // ];

    $url = 'https://api.zoom.us/v2/users/me/meetings';
    // $client = new \GuzzleHttp\Client($headers);
    // $response = $client->request('POST', $url, [
    //     'body' => json_encode([
    //         "schedule_for" => "mostafa.husany@gmail.com",
    //         "start_time" => "2022-04-25T07:32:55Z",
    //     ])
    // ]);

    $response = Http::withToken($token)->post($url, [
        // "_token" => $token,
        // "schedule_for" => "mostafa.husany@gmail.com",
        "start_time" => "2022-05-25T07:32:55Z",
    ]);


    // $response = Http::post('https://api.zoom.us/v2/users/me/meetings', [
    //     "_token" => $token,
    //     "agenda" => "My Meeting",
    //     "default_password" => false,
    //     "start_time" => "2022-04-25T07:32:55Z",
    //     'auth' => [
    //     //Provide your token here
    //         'bearer' => $token
    //     ],
    // ]);


    dd($response->body(), $response->ok());
    // $response = $request->getBody()->getContents();
    // dd($response->getBody()->getContents(), $response->getStatusCode());
});