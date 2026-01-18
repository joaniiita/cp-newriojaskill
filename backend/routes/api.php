<?php

use App\Http\Controllers\admin\DigimonController;
use App\Http\Controllers\admin\DigimonEvolutionController;
use App\Http\Controllers\admin\EvolutionTypeController;
use App\Http\Controllers\admin\SkillController;
use App\Http\Controllers\auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth', 'middleware' => 'api'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    Route::get('me', [AuthController::class, 'userProfile'])->middleware('auth:api');
});

Route::group(['middleware' => 'api'], function () {
    Route::get('digimons', [DigimonController::class, 'index']);
    Route::get('digimon/{digimon}', [DigimonController::class, 'show']);
    Route::get('/digimon/{digimon}/prev', [DigimonController::class, 'previous_digimon']);
    Route::get('/digimon/{digimon}/next', [DigimonController::class, 'next_digimon']);
//    Route::get('skills/{digimon}', [DigimonController::class, 'skills']);
    Route::post('digimon', [DigimonController::class, 'create'])->middleware('auth:api');
    Route::put('digimon/{digimon}', [DigimonController::class, 'update'])->middleware('auth:api');;
    Route::delete('digimon/{digimon}', [DigimonController::class, 'destroy'])->middleware('auth:api');;
});


Route::group(['middleware' => 'api'], function () {
    Route::get('skills', [SkillController::class, 'index']);
    Route::get('skill/{skill}', [SkillController::class, 'show']);
    Route::post('skill', [SkillController::class, 'create'])->middleware('auth:api');
    Route::delete('skill/{skill}', [SkillController::class, 'destroy'])->middleware('auth:api');
    Route::put('skill/{skill}', [SkillController::class, 'update'])->middleware('auth:api');
});

Route::group(['middleware' => 'api'], function () {
    Route::get('types', [EvolutionTypeController::class, 'index']);
    Route::get('type/{evolution_type}', [EvolutionTypeController::class, 'show']);
    Route::post('type', [EvolutionTypeController::class, 'create'])->middleware('auth:api');
    Route::put('type/{evolution_type}', [EvolutionTypeController::class, 'update'])->middleware('auth:api');
    Route::delete('type/{evolution_type}', [EvolutionTypeController::class, 'destroy'])->middleware('auth:api');
});


Route::group(['middleware' => 'api'], function () {
   Route::get('digievolutions', [DigimonEvolutionController::class, 'index']);
   Route::get('digievolution/{prev}/{next}', [DigimonEvolutionController::class, 'show']);
   Route::post('digievolution', [DigimonEvolutionController::class, 'create'])->middleware('auth:api');
   Route::put('digievolution/{prev}/{next}', [DigimonEvolutionController::class, 'update'])->middleware('auth:api');
   Route::delete('digievolution/{prev}/{next}', [DigimonEvolutionController::class, 'destroy'])->middleware('auth:api');
});
