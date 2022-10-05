<?php

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

Auth::routes();

Route::get('/','HomeController@index');
Route::get('home','HomeController@index');

Route::middleware(['auth'])->group(function() {
    Route::prefix('teams')->group(function() {
        Route::match(['get', 'post'], '/', 'TeamController@index')->name('teams');
        Route::match(['get', 'post'], 'my-teams', 'TeamController@myTeams');
        Route::get('form', 'TeamController@create')->name('teams.create');
        Route::get('form/{id}', 'TeamController@create')->name('teams.edit');
        Route::post('store', 'TeamController@store')->name('teams.save');
        Route::post('store/{id}', 'TeamController@store')->name('teams.update');
        Route::get('show/{id}', 'TeamController@show')->name('teams.view');
    });

    Route::prefix('teams-has-players')->group(function() {
        Route::get('team/{teamId}', 'TeamHasPlayersController@index')->name('team_has_player');
        Route::get('team/{teamId}/{playerId}', 'TeamHasPlayersController@index')->name('team_has_player.edit');
        Route::post('store/{teamId}', 'TeamHasPlayersController@store')->name('team_has_player.save');
        Route::post('store/{teamId}/{playerId}', 'TeamHasPlayersController@store')->name('team_has_player.update');
    });
});