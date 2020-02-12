<?php
use App\User;

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
Route::get('/logout', 'Auth\LoginController@logout')->name('logout' );
Auth::routes();

Route::get('/', function () {
        return redirect('/home');
});

Route::get('landing', 'HomeController@landing')->name('landing');

Route::get('/login', 'CustomRegisterController@login')->name('login' );
Route::post('/register/submit', 'CustomRegisterController@submit');


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/students', 'HomeController@studentslist')->name('studentslist');

Route::get('/csv', 'HomeController@uploadReferences')->name('csv');
Route::get('/csv/students', 'HomeController@uploadStudent')->name('uploadStudent');

Route::get('/students/upload/1', 'ImportController@uploadStudent1')->name('uploadStudent1');

Route::post('/students/upload/2', 'ImportController@uploadStudent2')->name('uploadStudent2');

Route::post('/students/upload/3', 'ImportController@uploadStudent3')->name('uploadStudent3');
// Route::post('/csv/students/3/submit', 'ImportController@uploadStudent3Submit')->name('uploadStudent3Submit');


Route::get('/csv/references', 'HomeController@uploadReferences')->name('uploadReferences');

Route::get('/csv/references/scaledscores/1', 'ImportController@uploadScaledScore1')->name('uploadScaledScore1');

Route::post('/csv/references/scaledscores/2', 'ImportController@uploadScaledScore2')->name('uploadScaledScore2');

Route::post('/csv/references/scaledscores/3', 'ImportController@uploadScaledScore3')->name('uploadScaledScore3');
// Route::post('/csv/references/scaledscores/3/submit', 'ImportController@uploadScaledScore3Submit')->name('uploadScaledScore3Submit');

Route::get('/csv/references/sai/1', 'ImportController@uploadSAI1')->name('uploadSAI1');

Route::post('/csv/references/sai/2', 'ImportController@uploadSAI2')->name('uploadSAI2');

Route::post('/csv/references/sai/3', 'ImportController@uploadSAI3')->name('uploadSAI3');
// Route::post('/csv/references/sai/3/submit', 'ImportController@uploadSAI3Submit')->name('uploadSAI3Submit');

Route::get('/csv/references/percentile_stanine/1', 'ImportController@uploadStanine1')->name('uploadStanine1');
// Route::post('/csv/references/percentile_stanine/1', 'ImportController@skipSAI')->name('skipSAI');

Route::post('/csv/references/percentile_stanine/2', 'ImportController@uploadStanine2')->name('uploadStanine2');

Route::post('/csv/references/percentile_stanine/3', 'ImportController@uploadStanine3')->name('uploadStanine3');
// Route::post('/csv/references/percentile_stanine/3/submit', 'ImportController@uploadStanine3Submit')->name('uploadStanine3Submit');
Route::post('/csv', 'ImportController@finalizeUpload')->name('finalizeUpload');

Route::post('/csv/import_parse', 'ImportController@parseImport')->name('import_parse');
Route::post('/csv/import_process', 'ImportController@processImport')->name('import_process');

//Route::get('/students', 'HomeController@students')->name('students');
Route::get('/students/view', 'LiveSearchController@students')->name('students');
// Route::get('/students/fetch_data', 'LiveSearchController@fetch_data');
// Route::get('/students/info', 'LiveSearchController@studentInfo')->name('studentInfo');
Route::resource('/students/view/studentinfo', 'LiveSearchController');

// Route::patch('/view/studentinfo/{$student_details->id}', 'LiveSearchController@update');

// Route::get('/monitoring/total', 'HomeController@monitoring')->name('monitoringTotal');
Route::get('/students/monitoring', 'BatchController@index')->name('batch_list');
Route::get('/students/monitoring/{batch}', 'BatchController@monitor')->name('monitoring');
// Route::get('monitoring/fetch_data', 'MonitoringTotalController@fetch_data');
Route::get('/students/monitoring/info', 'MonitoringTotalController@totalInfo')->name('totalInfo');

Route::patch('/students/monitoring/info/{total_score_details->id}', 'MonitoringTotalController@udpate');

Route::resource('/students/monitoring/totalinfo', 'MonitoringTotalController');

Route::get('/students/monitoring/verbal', 'MonitoringVerbalController@monitoring_verbal')->name('monitoring_verbal');
// Route::get('monitoring/verbal/fetch_data', 'MonitoringVerbalController@fetch_data');
Route::get('/students/monitoring/verbalinfo', 'MonitoringVerbalController@verbalInfo')->name('verbalInfo');

Route::resource('/students/monitoring/verbalinfo', 'MonitoringVerbalController');

Route::get('/students/monitoring/nonverbal', 'MonitoringNonVerbalController@monitoring_nonverbal')->name('monitoring_nonverbal');
// Route::get('monitoring/nonverbal/fetch_data', 'MonitoringNonVerbalController@fetch_data');
Route::get('/students/monitoring/nonverbalinfo', 'MonitoringNonVerbalController@nonverbalInfo')->name('nonverbalInfo');

Route::resource('/students/monitoring/nonverbalinfo', 'MonitoringNonVerbalController');

Route::post('/export-pdf', 'PDFController@viewPDF')->name('viewPDF');
Route::post('/save-pdf', 'PDFController@savePDF')->name('savePDF');

Route::get('/students/monitoring/delete/{id}', 'BatchController@deleteBatch')->name('deleteBatch');
Route::get('/students/monitoring/export-batch/{id}', 'PDFController@pdf')->name('exportBatch');


Route::get('/csv/selective-scaled/reset', 'ImportController@selective_scaled_restart')->name('selective_scaled_restart');
Route::get('/csv/selective-sai/reset', 'ImportController@selective_sai_restart')->name('selective_sai_restart');
Route::get('/csv/selective-stanine/reset', 'ImportController@selective_stanine_restart')->name('selective_stanine_restart');

Route::get('/csv/selective-scaled/add', 'ImportController@selective_scaled_add')->name('selective_scaled_add');
Route::get('/csv/selective-sai/add', 'ImportController@selective_sai_add')->name('selective_scaled_add');
Route::get('/csv/selective-stanine/add', 'ImportController@selective_stanine_add')->name('selective_scaled_add');
