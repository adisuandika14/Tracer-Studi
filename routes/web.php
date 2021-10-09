<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

use App\tb_jawaban;
use App\tb_alumni;
use App\tb_prodi;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/admin/kuesioner', function () {
//     return view('admin/kuesioner');
// });


route::get('/','loginController@index');
route::post('/logins','loginController@login');
route::get('/logouts','loginController@logout');




Route::group(['prefix' => 'admin',  'middleware' => 'AdminMiddleware'],function(){

       //Auth
       Route::get('/profile', 'AuthAdminController@profile')->name('pegawai-profile-edit');
       Route::post('/profile-update', 'AuthAdminController@updateProfile')->name('pegawai-profile-update');
       Route::get('/password', 'AuthAdminController@password')->name('pegawai-password-edit');
       Route::post('/editpassword', 'AuthAdminController@editpassword')->name('pegawai-password-update');




    // Route::get('/auth/profile', 'ProfileController@profile');
    // Route::post('/auth/profile/update','ProfileController@update');
    //Route::post('/auth/profile/upload','ProfileController@upload')->name("crop-image-upload");


    //Alumni
    Route::get('/alumni','alumniController@show');
    Route::post('/alumni/create','alumniController@create');
    //Route::get('/alumni/{id}/edit','alumniController@edit');
    Route::post('/alumni/update','alumniController@update');
    Route::get('/alumni/{id}/delete','alumniController@delete');
    Route::post('/alumni/status', 'alumniController@status');
    Route::get('/baca-notif/{id}', 'alumniController@bacaNotif');

    //Pengumuman
    Route::get('/pengumuman','pengumumanController@show');
    Route::get('/pengumuman/create','pengumumanController@create');
    Route::post('/pengumuman/store', 'pengumumanController@store');
    Route::get('/pengumuman/{id}/delete', 'pengumumanController@delete');
    Route::get('/pengumuman/showpengumuman/{id}', 'pengumumanController@detail');
    Route::get('/pengumuman/{id}/edit', 'pengumumanController@edit');
    Route::post('/pengumuman/{id}', 'pengumumanController@update');

    // Route::post('/pengumuman/{id}', 'pengumumanController@send');
    Route::post('/pengumuman/showpengumuman/send-message/{id}', 'TelegramBotController@storeMessage');

    //Lowongan
    Route::get('/lowongan','lowonganController@show');
    Route::get('/lowongan/create','lowonganController@create');
    Route::post('/lowongan/store', 'lowonganController@store');
    Route::get('/lowongan/{id}/delete', 'lowonganController@delete');
    Route::get('/lowongan/showlowongan/{id}', 'lowonganController@detail');
    Route::get('/lowongan/{id}/edit', 'lowonganController@edit');
    Route::post('/lowongan/{id}', 'lowonganController@update');
    Route::post('/lowongan/showlowongan/send-message/{id}', 'TelegramBotController@storelowongan');

    //Master Angkatan
    Route::get('/angkatan','angkatanController@show');
    Route::post('/masterangkatan/create','angkatanController@create');
    //Route::get('/masterangkatan/{id}/edit','angkatanController@edit');
    Route::post('/masterangkatan/update','angkatanController@update');
    Route::get('/masterangkatan/{id}/delete','angkatanController@delete');


    //Master Prodi
    Route::get('/prodi','prodiController@show');
    Route::post('/masterprodi/create','prodiController@create');
    //Route::get('/masterprodi/{id}/edit','prodiController@edit');
    Route::post('/masterprodi/update','prodiController@update');
    Route::get('/masterprodi/{id}/delete','prodiController@delete');

    //Master Periode
    Route::get('/periode','periodeController@show');
    Route::post('/masterperiode/create','periodeController@create');
    Route::post('/masterperiode/update','periodeController@update');
    Route::get('/masterperiode/{id}/delete','periodeController@delete');
    
   



    //Kuesioner
    Route::get('/kuesioner','kuesionerController@show');
    Route::post('/kuesioner/create','kuesionerController@create');
    Route::post('/kuesioner/update','kuesionerController@update');
    Route::get('/kuesioner/{id}/delete','kuesionerController@delete');
    //Route::get('/kuesioner/showkuesioner/{id}','kuesionerController@detail')->name('show-kuesioner');

    //Route::get('/tracer','kuesionerController@showtracer');

    //Detail Kuesioner
    Route::get('/kuesioner/showkuesioner/{id}','detailkuesionerController@detail')->name('show-kuesioner');
    Route::post('/kuesioner/showkuesioner/filter','detailkuesionerController@filter')->name('filter-kuesioner');
    Route::post('/kuesioner/soal/create','detailkuesionerController@create');
    Route::delete('/kuesioner/soal/{id}/delete', 'detailkuesionerController@delete');
    Route::get('/kuesioner/soal/{id}/edit', 'detailkuesionerController@edit');
    Route::post('/kuesioner/soal/{id}/update','detailkuesionerController@update');
    Route::get('/kuesioner/showkuesioner/{id}/{status}', 'detailkuesionerController@status');
 

    //Kuesioner Stackholder
    Route::get('/kuesioner/stackholder/{id}/edit', 'stackholderkuesionerController@edit');
    Route::get('/kuesioner/stackholder','stackholderkuesionerController@detail')->name('stackholder-kuesioner-show');
    Route::post('/kuesioner/stackholder/create','stackholderkuesionerController@create');
    Route::post('/kuesioner/stackholder/update','stackholderkuesionerController@update');
    Route::get('/kuesioner/stackholder/{id}/delete','stackholderkuesionerController@delete');
    //Route::get('/kuesioner/stackholder/showkuesioner/{id}','stackholderkuesionerController@detail')->name('stackholder-kuesioner');
    //Route::get('/tracer', 'stackholderkuesionerController@detailjawaban');
    Route::get('/kuesioner/stackholder/showkuesioner/{id}/{status}', 'stackholderkuesionerController@status');
    Route::post('/kuesioner/stackholder/showkuesioner/filter','stackholderkuesionerController@filter')->name('stackholder-filter');




    //tracer
    Route::get('/tracer', 'detailkuesionerController@tracer');
    Route::get('/tracer/{id}', 'detailkuesionerController@detailtracer');
    Route::post('/tracer/filter', 'detailkuesionerController@filtertracer');

    //Master Pertanyaan
    Route::get('/pertanyaan','masterkuesionerController@show')->name('show-pertanyaan');
    Route::post('/pertanyaan/soal/create','masterkuesionerController@create');
    Route::delete('/pertanyaan/soal/{id}/delete', 'masterkuesionerController@delete');
    Route::get('/pertanyaan/soal/{id}/edit', 'masterkuesionerController@edit');
    Route::post('/pertanyaan/soal/{id}/update','masterkuesionerController@update');

    //Dashboard
    Route::get('/dashboard','dashboardController@dashboard')->middleware('AdminMiddleware');
    //Route::get('/dashboard', 'dashboardController@chartjs');


    //Export Excel
    Route::get('/export', 'dashboardController@export');

    //Import Excel
    Route::post('/alumni/import_excel', 'alumniController@import_excel');




});





//<input type="text" class="form-control" id="edit_id_kuesioner" name="id_kuesioner" value="{{$id_kuesioner}}" hidden>


Route::prefix('pimpinan')->group(function(){
    // route::get('/','loginController@index');
    // route::post('/logins','loginController@login');
    // route::get('/logouts','loginController@logout');



    //Auth
    Route::get('/profile', 'AuthPimpinanController@profile')->name('admin-profile-edit');
    Route::post('/profile-update', 'AuthPimpinanController@updateProfile')->name('admin-profile-update');
    Route::get('/password', 'AuthPimpinanController@password')->name('admin-password-edit');
    Route::post('/editpassword', 'AuthPimpinanController@editpassword')->name('admin-password-update');




    //Alumni
    Route::get('/alumni','pimpinanalumniController@show');
    Route::post('/alumni/create','pimpinanalumniController@create');
    //Route::get('/alumni/{id}/edit','pimpinanalumniController@edit');
    Route::post('/alumni/update','pimpinanalumniController@update');
    Route::get('/alumni/{id}/delete','pimpinanalumniController@delete');



    //Kuesioner
    Route::get('/kuesioner','pimpinankuesionerController@show');
    Route::post('/kuesioner/create','pimpinankuesionerController@create');
    Route::post('/kuesioner/update','pimpinankuesionerController@update');
    Route::get('/kuesioner/{id}/delete','pimpinankuesionerController@delete');
    Route::get('/kuesioner/showkuesioner/{id}','pimpinankuesionerController@detail')->name('detail-kuesioner');
    Route::get('/tracer', 'pimpinankuesionerController@detailjawaban');
    Route::get('/kuesioner/showkuesioner/{id}/{status}', 'pimpinankuesionerController@status');
    Route::post('/kuesioner/showkuesioner/filter','pimpinankuesionerController@filter')->name('filter-kuesioner');


    //Pengumuman
    Route::get('/pengumuman','pimpinanpengumumanController@show');
    Route::get('/pengumuman/showpengumuman/{id}', 'pimpinanpengumumanController@detail');


    //lowongan
    Route::get('/lowongan','pimpinanlowonganController@show');
    Route::get('/lowongan/showlowongan/{id}', 'pimpinanlowonganController@detail');

    Route::get('/dashboard','dashboardpimpinanController@dashboard')->name('pimpinan-home');


});

Route::group(['prefix' => 'alumni'],function(){
    route::get('/login','Alumni\Auth\AlumniLoginController@index')->name('login-alumni');
    route::post('/login', [ 'as' => 'login', 'uses' => 'LoginController@login']);
    route::post('/logins','Alumni\Auth\AlumniLoginController@login');
    route::get('/logouts','Alumni\Auth\AlumniLoginController@logout');
    route::get('/register','Alumni\Auth\AlumniRegisterController@index')->name('register');
    route::post('/registers','Alumni\Auth\AlumniRegisterController@regisAlumni')->name('regisAlumni');
    Route::get('/dashboard','Alumni\DashboardAlumniController@dashboard')
        ->middleware('AlumniMiddleware')
        ->name('dashboard');
    Route::get('/read-notif/{notifikasi_unique}', 'Alumni\DashboardAlumniController@bacaNotif')
        ->middleware('AlumniMiddleware');
    Route::get('/perbaikan', 'Alumni\AuthAlumniController@perbaikan')->name('alumni-perbaikan')
        ->middleware('UnverifiedAlumniMiddleware');
    Route::post('/perbaikan-update', 'Alumni\AuthAlumniController@perbaikanAlumni')->name('alumni-perbaikan-update')
        ->middleware('UnverifiedAlumniMiddleware');
});

Route::group(['prefix' => 'alumni',  'middleware' => 'VerifiedAlumniMiddleware'],function(){

    Route::get('/profile', 'Alumni\AuthAlumniController@profile')->name('alumni-profile-edit');
    Route::post('/profile-update', 'Alumni\AuthAlumniController@updateProfile')->name('alumni-profile-update');
    Route::post('/kuesioner', 'Alumni\Kuesioner\AlumniDetailKuesionerController@show');
    Route::get('/prekuesioner', 'Alumni\Kuesioner\AlumniKuesionerController@show');
    Route::post('/kuesioner/simpan', 'Alumni\Kuesioner\AlumniDetailKuesionerController@jawabKuesioner');
    Route::get('/hasilKuesioner', 'Alumni\Kuesioner\AlumniDetailKuesionerController@hasilKuesioner');
    Route::post('/hasilKuesioner/update/{id}', 'Alumni\Kuesioner\AlumniDetailKuesionerController@updateHasilKuesioner');

});



