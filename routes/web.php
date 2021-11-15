<?php

use App\Http\Controllers\CrawlController;
use App\Http\Controllers\DetailController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('crawl');
});

Route::post('/crawl/', [CrawlController::class, 'crawl'])
    ->name('crawled');

Route::get('/crawled-page/', [CrawlController::class, 'index'])
    ->name('crawled.index');

Route::get('/crawled-page/{id}', [CrawlController::class, 'show'])
    ->name('crawled.show');
