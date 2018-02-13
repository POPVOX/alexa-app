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

Route::get('/', function () {
    return view('whatup');
});

Route::get('/test', 'SentimentController@getBillSentiment');

AlexaRoute::launch('/request', function() {
    return Alexa::say('POPVOX is open for business');
});

AlexaRoute::intent('/request', 'GetLatestBill', function() {
    //return Alexa::say('The latest bill at POPVOX is house joint resolution 104 : Proposing an amendment to the Constitution of the United States to treat Puerto Rico as if it were a State for purposes of the election of the President and Vice President.  This bill is sponsored by Representative Steve Cohen of Tennessee\'s 9th district.');
    return Alexa::say('What is up with my home peeps tonight? Hopefully drinking some delicious wine and getting your bachelor on!');
});

AlexaRoute::intent('/request', 'GetBillSentiment', 'App\Http\Controllers\SentimentController@getBillSentiment');
