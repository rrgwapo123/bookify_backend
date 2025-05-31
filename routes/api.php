<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\EmailController;

// All routes here are automatically prefixed with 'api/'

// Ticketmaster Events (user query)
Route::get('events/{query?}', [EventController::class, 'getEvents']);

// Geocode (user address query)
Route::get('geocode/{address?}', [LocationController::class, 'geocode']);
Route::post('geocode', [LocationController::class, 'geocode']);

// Weather 
Route::get('weather', [WeatherController::class, 'index']);
Route::post('weather', [WeatherController::class, 'index']);

// Images (user query)
Route::get('images/{query?}', [ImageController::class, 'searchImages']);

// Email validation (user email)
Route::post('email/send-confirmation', [EmailController::class, 'sendConfirmation']); 