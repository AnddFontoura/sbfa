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

Auth::routes(['verify' => true]);

Route::get('/','HomeController@index');
Route::get('home','HomeController@index');

Route::middleware(['auth'])->group(function() {
    Route::prefix('teams')->group(function() {
        Route::match(['get', 'post'], '/', 'TeamController@index')->name('teams');
        Route::get('form', 'TeamController@create')->name('teams.create')->middleware('verified');
        Route::get('form/{id}', 'TeamController@create')->name('teams.edit')->middleware('verified');
        Route::post('store', 'TeamController@store')->name('teams.save')->middleware('verified');
        Route::post('store/{id}', 'TeamController@store')->name('teams.update')->middleware('verified');
        Route::get('show/{id}', 'TeamController@show')->name('teams.view');
    });

    Route::prefix('teams-has-players')->group(function() {
        Route::get('team/{teamId}', 'TeamHasPlayersController@create')->name('team_has_player.create')->middleware('verified');
        Route::get('team/{teamId}/{playerId}', 'TeamHasPlayersController@create')->name('team_has_player.edit')->middleware('verified');
        Route::post('store/{teamId}', 'TeamHasPlayersController@store')->name('team_has_player.save')->middleware('verified');
        Route::post('store/{teamId}/{playerId}', 'TeamHasPlayersController@update')->name('team_has_player.update')->middleware('verified');
        Route::get('show/{teamId}/{playerId}', 'TeamHasPlayersController@view')->name('team_has_player.view');
        Route::delete('delete', 'TeamHasPlayersController@delete')->name('team_has_player.delete')->middleware('verified');
    });

    Route::prefix('players-invited')->middleware('verified')->group(function() {
        Route::post('invite', 'PlayerInvitedController@invite')->name('players_invited.invite');
        Route::post('yes', 'PlayerInvitedController@yes')->name('players_invited.yes');
        Route::post('no', 'PlayerInvitedController@no')->name('players_invited.no');
    });

    Route::prefix('configuration')->middleware('verified')->group(function() {
        Route::get('team/{teamId}', 'ConfigurationController@team')->name('configuration.team');
    });

    Route::prefix('matches')->group(function() {
        Route::match(['get', 'post'], '/', 'MatchesController@index')->name('matches');
        Route::get('form/{teamId}', 'MatchesController@create')->name('matches.create')->middleware('verified');
        Route::get('form/{teamId}/{matchId}', 'MatchesController@create')->name('matches.edit')->middleware('verified');
        Route::post('store/{teamId}', 'MatchesController@store')->name('matches.save')->middleware('verified');
        Route::post('store/{teamId}/{matchId}', 'MatchesController@update')->name('matches.update')->middleware('verified');
        Route::get('show/{matchId}', 'MatchesController@show')->name('matches.view');
        Route::get('statistics/{teamId}/{matchId}', 'PlayerStatisticInMatchController@create')->name('matches.statistics.create')->middleware('verified');
        Route::post('statistics/{teamId}/{matchId}', 'PlayerStatisticInMatchController@store')->name('matches.statistics.save')->middleware('verified');
        Route::get('players-at-match/{teamId}/{matchId}', 'MatchHasPlayerController@create')->name('matches.player-at.create')->middleware('verified');
        Route::post('players-at-match/save/{teamId}/{matchId}', 'MatchHasPlayerController@store')->name('matches.player-at.save')->middleware('verified');
        Route::get('cost/form/{teamId}/{matchId}', 'MatchCostController@create')->name('matches.cost.create')->middleware('verified');
        Route::post('cost/store/{teamId}/{matchId}', 'MatchCostController@store')->name('matches.cost.save')->middleware('verified');
    });

    Route::prefix('statistics')->middleware('verified')->group(function() {
        Route::get('form/{teamId}', 'MatchesController@create')->name('statistics.create');
        Route::get('form/{teamId}/{matchId}', 'MatchesController@create')->name('statistics.edit');
        Route::post('store/{teamId}/{matchId}', 'StatisticController@store')->name('statistics.save');
        Route::post('store/{teamId}/{matchId}', 'StatisticController@update')->name('statistics.update');
        Route::get('show/{matchId}', 'MatchesController@show')->name('statistics.view');
        Route::get('statistics/{teamId}/{matchId}', 'MatchesController@statistics')->name('statistics.statistics');
    });

    Route::prefix('profile')->group(function() {
        Route::get('/', 'ProfileController@create')->name('profile');
        Route::post('store', 'ProfileController@store')->name('profile.save');
    });

    Route::prefix('players')->group(function() {
        Route::match(['get', 'post'], '/', 'UserProfileController@index')->name('players');
        Route::get('{profileId}', 'UserProfileController@show')->name('players.view');
    });
});
