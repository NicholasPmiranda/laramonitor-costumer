<?php

use App\Http\Controllers\UserController;
use App\Jobs\TesteJob;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use LaraMonitor\Src\Jobs\Server\SendMetricsServerJob;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('teste', function () {

    $data = [
        'teste' => '123',
        'novo_teste'=> 'agora vai'
    ];
    Http::get('http://174.138.125.73/api/auth/healthz1', $data)->json();

//        $teste = 1 /0 ;
//    TesteJob::dispatch($data);
//    SendMetricsServerJob::dispatch();
});


Route::get('login', [UserController::class, 'login']);


Route::get('privado', function (){
    $data = [
        'teste' => '123',
        'novo_teste'=> 'agora vai'
    ];
//    Http::get('http://174.138.125.731/api/auth/healthz', $data)->json();

//    $teste = 1 /0 ;
TesteJob::dispatch($data);
})->middleware('auth:sanctum');
