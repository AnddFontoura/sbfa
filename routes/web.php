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
        Route::get('team/{teamId}', 'TeamHasPlayersController@create')->name('team_has_player.create');
        Route::get('team/{teamId}/{playerId}', 'TeamHasPlayersController@create')->name('team_has_player.edit');
        Route::post('store/{teamId}', 'TeamHasPlayersController@store')->name('team_has_player.save');
        Route::post('store/{teamId}/{playerId}', 'TeamHasPlayersController@update')->name('team_has_player.update');
        Route::get('show/{teamId}/{playerId}', 'TeamHasPlayersController@view')->name('team_has_player.view');
        Route::delete('delete', 'TeamHasPlayersController@delete')->name('team_has_player.delete');
    });

    Route::prefix('players-invited')->group(function() {
        Route::post('invite', 'PlayerInvitedController@invite')->name('players_invited.invite');
        Route::post('yes', 'PlayerInvitedController@yes')->name('players_invited.yes');
        Route::post('no', 'PlayerInvitedController@no')->name('players_invited.no');
    });

    Route::prefix('configuration')->group(function() {
        Route::get('team/{teamId}', 'ConfigurationController@team')->name('configuration.team');
    });
    
    Route::prefix('matches')->group(function() {
        //Route::match(['get', 'post'], '/', 'MatchesController@index')->name('teams');
        //Route::match(['get', 'post'], 'my-teams', 'MatchesController@myTeams');
        Route::get('form/{teamId}', 'MatchesController@create')->name('matches.create');
        Route::get('form/{teamId}/{matchId}', 'MatchesController@create')->name('matches.edit');
        Route::post('store/{teamId}', 'MatchesController@store')->name('matches.save');
        Route::post('store/{teamId}/{matchId}', 'MatchesController@store')->name('matches.update');
        Route::get('show/{matchId}', 'MatchesController@show')->name('matches.view');
    });
});