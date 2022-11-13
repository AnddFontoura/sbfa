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
        Route::get('form/{teamId}', 'MatchesController@create')->name('matches.create');
        Route::get('form/{teamId}/{matchId}', 'MatchesController@create')->name('matches.edit');
        Route::post('store/{teamId}', 'MatchesController@store')->name('matches.save');
        Route::post('store/{teamId}/{matchId}', 'MatchesController@update')->name('matches.update');
        Route::get('show/{matchId}', 'MatchesController@show')->name('matches.view');
        Route::get('statistics/{teamId}/{matchId}', 'PlayerStatisticInMatchController@create')->name('matches.statistics.create');
        Route::post('statistics/{teamId}/{matchId}', 'PlayerStatisticInMatchController@store')->name('matches.statistics.save');
        Route::get('players-at-match/{teamId}/{matchId}', 'MatchHasPlayerController@create')->name('matches.player-at.create');
        Route::post('players-at-match/save/{teamId}/{matchId}', 'MatchHasPlayerController@store')->name('matches.player-at.save');
        Route::get('cost/form/{teamId}/{matchId}', 'MatchCostController@create')->name('matches.cost.create');
        Route::post('cost/store/{teamId}/{matchId}', 'MatchCostController@store')->name('matches.cost.save');
    });
    
    Route::prefix('statistics')->group(function() {
        //Route::match(['get', 'post'], '/', 'MatchesController@index')->name('teams');
        //Route::match(['get', 'post'], 'my-teams', 'MatchesController@myTeams');
        Route::get('form/{teamId}', 'MatchesController@create')->name('statistics.create');
        Route::get('form/{teamId}/{matchId}', 'MatchesController@create')->name('statistics.edit');
        Route::post('store/{teamId}/{matchId}', 'StatisticController@store')->name('statistics.save');
        Route::post('store/{teamId}/{matchId}', 'StatisticController@update')->name('statistics.update');
        Route::get('show/{matchId}', 'MatchesController@show')->name('statistics.view');
        Route::get('statistics/{teamId}/{matchId}', 'MatchesController@statistics')->name('statistics.statistics');
    });
});
