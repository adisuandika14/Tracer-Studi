<?php

use Illuminate\Support\Facades\Route;

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
    Route::get('/periodealumni','alumniController@periode');
    Route::post('/periodealumni/createperiode','alumniController@createperiode');
    Route::post('/periodealumni/updateperiode','alumniController@updateperiode');
    Route::get('/periodealumni/{id}/delete','alumniController@deleteperiode');

    Route::get('/alumni/{id}','alumniController@show')->name('alumni');
    Route::post('/alumni/create','alumniController@create');
    //Route::get('/alumni/{id}/edit','alumniController@edit');
    Route::post('/alumni/update','alumniController@update');
    Route::get('/alumni/{id}/delete','alumniController@delete');
    Route::post('/alumni/status', 'alumniController@status');
    Route::get('/baca-notif/{id}', 'alumniController@bacaNotif');
    Route::get('/tracer','alumniController@tracer');
    Route::get('/tracer/{id}','alumniController@detailtracer');
    Route::post('/tracer/filter','alumniController@filtertracer');
    
    Route::get('/periodealumni/{id}/{statusperiode}', 'alumniController@statusperiode');

    //Import Excel
    Route::post('/alumni/import_excel', 'alumniController@import_excel');



    //Pengumuman
    Route::get('/pengumuman','pengumumanController@show');
    Route::get('/pengumuman/create','pengumumanController@create');
    Route::post('/pengumuman/store', 'pengumumanController@store');
    Route::get('/pengumuman/{id}/delete', 'pengumumanController@delete');
    Route::get('/pengumuman/showpengumuman/{id}', 'pengumumanController@detail');
    Route::get('/pengumuman/{id}/edit', 'pengumumanController@edit');
    Route::post('/pengumuman/{id}', 'pengumumanController@update');

    // Route::post('/pengumuman/{id}', 'pengumumanController@send');
    Route::post('/pengumuman/showpengumuman/send-message/{id}', 'pengumumanController@storeMessage');
    Route::post('/pengumuman/showpengumuman/periode/send-message/{id}', 'pengumumanController@storeMessagePeriodeAlumni');

    //Lowongan
    Route::get('/lowongan','lowonganController@show');
    Route::get('/lowongan/create','lowonganController@create');
    Route::post('/lowongan/store', 'lowonganController@store');
    Route::get('/lowongan/{id}/delete', 'lowonganController@delete');
    Route::get('/lowongan/showlowongan/{id}', 'lowonganController@detail');
    Route::get('/lowongan/{id}/edit', 'lowonganController@edit');
    Route::post('/lowongan/{id}', 'lowonganController@update');

    Route::post('/lowongan/showlowongan/send-message/{id}', 'lowonganController@storeMessage');
    Route::post('/lowongan/showlowongan/periode/send-message/{id}', 'lowonganController@storeMessagePeriodeAlumni');


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

   //Master Periode
   Route::get('/periode','periodeController@show');
   Route::post('/masterperiode/create','periodeController@create');
   Route::post('/masterperiode/update','periodeController@update');
   Route::get('/masterperiode/{id}/delete','periodeController@delete');

   Route::get('/mastertahun','tahunperiodeController@show');
   Route::post('/mastertahun/create','tahunperiodeController@create');
   Route::post('/mastertahun/update','tahunperiodeController@update');
   Route::get('/mastertahun/{id}/delete','tahunperiodeController@delete');




   //Bank Soal Alumni
   Route::get('/banksoal/alumni','banksoalalumniController@show')->name('show-banksoal');
   Route::post('/banksoal/alumni/create','banksoalalumniController@create');
   Route::post('/banksoal/alumni/update','banksoalalumniController@update');
   Route::get('/banksoal/alumni/{id}/delete','banksoalalumniController@delete');

       //Bank Soal Alumni Detail
       Route::get('/banksoal/showkuesioner/{id}','banksoalalumnidetailController@detail')->name('show-banksoalalumni');
       Route::post('/banksoal/showkuesioner/filter','banksoalalumnidetailController@filter')->name('filter-banksoalalumni');
       Route::post('/banksoal/showkuesioner/create','banksoalalumnidetailController@create');
       Route::delete('/banksoal/showkuesioner/{id}/delete', 'banksoalalumnidetailController@delete');
       Route::get('/banksoal/showkuesioner/{id}/edit', 'banksoalalumnidetailController@edit');
       Route::post('/banksoal/showkuesioner/{id}/update','banksoalalumnidetailController@update');
       Route::get('/banksoal/showkuesioner/{id}/{status}', 'banksoalalumnidetailController@status');



   
    
    //Kuesioner Stakeholder
    Route::get('/kuesioner/stakeholder','stakeholderkuesionerController@index')->name('stakeholder-kuesioner-show');
    Route::post('/kuesioner/stakeholder/create','stakeholderkuesionerController@create');
    Route::delete('/kuesioner/stakeholder/{id}/delete','stakeholderkuesionerController@delete');
    Route::get('/kuesioner/stakeholder/showkuesioner/{id}/{status}', 'stakeholderkuesionerController@status');

    Route::get('/kuesioner/stakeholder/detail/{id_prodi}/{id_periode}', 'stakeholderkuesionerController@detail_kuesioner')->name('kuesioner-stakeholder-detail');
    Route::get('/kuesioner/stakeholder/{id}/edit', 'stakeholderkuesionerController@edit');
    Route::post('/kuesioner/stakeholder/{id}/update','stakeholderkuesionerController@update');


    Route::get('/kuesioner/stakeholder/get-bank-soal/{id_prodi}/{id_periode}', 'stakeholderkuesionerController@bank_soal_data');
    Route::post('/kuesioner/stakeholder/create/{id_prodi}/{id_periode}','stakeholderkuesionerController@create_from_bank_soal');
    Route::post('/kuesioner/stakeholder/filter','stakeholderkuesionerController@filter')->name('stakeholder-filter');


    //Periode Kuesioner   
    Route::get('/periodekuesioner','kuesionerperiodeController@show');
    Route::post('/periodekuesioner/create','kuesionerperiodeController@create');
    Route::post('/periodekuesioner/update','kuesionerperiodeController@update');
    Route::get('/periodekuesioner/{id}/delete','kuesionerperiodeController@delete');
    Route::get('/periodekuesioner/{id}/{status}', 'kuesionerperiodeController@status');
    
    //Kuesioner
    Route::get('/kuesioner/{id}','kuesionerController@show')->name('kuesioner-alumni');
    Route::post('/kuesioner/create','kuesionerController@create');
    Route::post('/kuesioner/update','kuesionerController@update');
    Route::get('/kuesioner/{id}/delete','kuesionerController@delete');
    Route::post('/kuesioner/filter','kuesionerController@filter')->name('filter-kuesioner');
    Route::get('/kuesioner/get-bank-soal/{id_periode}','kuesionerController@bank_soal_data')->name('get-bank-soal-kuesioner');
    Route::post('/kuesioner/create/{id_periode}','kuesionerController@create_from_bank_soal');



    //Detail Kuesioner
    Route::get('/kuesioner/showkuesioner/{id}','detailkuesionerController@detail')->name('show-kuesioner');
    Route::post('/kuesioner/showkuesioner/filter','detailkuesionerController@filter')->name('filter-kuesioner');
    Route::post('/kuesioner/soal/create','detailkuesionerController@create');
    Route::delete('/kuesioner/soal/{id}/delete', 'detailkuesionerController@delete');
    Route::get('/kuesioner/soal/{id}/edit', 'detailkuesionerController@edit');
    Route::post('/kuesioner/soal/{id}/update','detailkuesionerController@update');
    Route::get('/kuesioner/showkuesioner/{id}/{status}', 'detailkuesionerController@status');
    Route::get('/kuesioner/get-bank-soal/showkuesioner/{id}','detailkuesionerController@bank_soal_data')->name('get-bank-soal-kuesioner-detail');
    Route::post('/kuesioner/post-bank-soal/showkuesioner/{id}','detailkuesionerController@create_from_bank_soal');



    //Bank Soal stakeholder
    Route::get('/banksoal/stakeholder','banksoalstakeholderController@show')->name('show-banksoal-stakeholder');
    Route::post('/banksoal/stakeholder/create','banksoalstakeholderController@create');
    Route::get('/banksoal/stakeholder/{id}/edit', 'banksoalstakeholderController@edit');
    Route::post('/banksoal/stakeholder/{id}/update','banksoalstakeholderController@update');
    Route::delete('/banksoal/stakeholder/{id}/delete','banksoalstakeholderController@delete');
    Route::post('/banksoal/stakeholder/filter','banksoalstakeholderController@filter')->name('stakeholder-filter');


    //Report Alumni
    Route::get('/reportalumni', 'alumnireportController@tracer');
    Route::get('/reportalumni/{id}', 'alumnireportController@detailtracer');
    Route::post('/reportalumni/filter', 'alumnireportController@filtertracer');
    Route::post('/reportalumni/export/submit','export\ExportDosenController@excel')->name('admin-export-dosen');

    //Report
    Route::get('/reportstakeholder', 'stakeholderreportController@report');
    Route::get('/reportstakeholder/{id}', 'stakeholderreportController@detailreport');
    Route::post('/reportstakeholder/filter', 'stakeholderreportController@filterreport');

    //Master Pertanyaan
    Route::get('/pertanyaan','masterkuesionerController@show')->name('show-pertanyaan');
    Route::post('/pertanyaan/soal/create','masterkuesionerController@create');
    Route::delete('/pertanyaan/soal/{id}/delete', 'masterkuesionerController@delete');
    Route::get('/pertanyaan/soal/{id}/edit', 'masterkuesionerController@edit');
    Route::post('/pertanyaan/soal/{id}/update','masterkuesionerController@update');

    //Dashboard
    Route::get('/dashboard','dashboardController@dashboard')->middleware('AdminMiddleware');
    //Route::get('/dashboard', 'dashboardController@chartjs');


    // //Export Excel
    // Route::get('/export', 'alumniController@export');

    Route::get('/alumni/export/alumni','exportalumniController@exportalumni')->name('admin-export-alumni');
    Route::post('/alumni/export/alumni/submit','exportalumniController@excel')->name('admin-export-alumni');
});





Route::group(['prefix' => 'pimpinan',  'middleware' => 'PimpinanMiddleware'],function(){
    //Auth
    Route::get('/profile', 'AuthPimpinanController@profile')->name('admin-profile-edit');
    Route::post('/profile-update', 'AuthPimpinanController@updateProfile')->name('admin-profile-update');
    Route::get('/password', 'AuthPimpinanController@password')->name('admin-password-edit');
    Route::post('/editpassword', 'AuthPimpinanController@editpassword')->name('admin-password-update');


    //Alumni
    Route::get('/periodealumni','pimpinanalumniController@periode');

    Route::get('/alumni/{id}','pimpinanalumniController@show');
    Route::post('/alumni/create','pimpinanalumniController@create');
    Route::post('/alumni/update','pimpinanalumniController@update');
    Route::get('/alumni/{id}/delete','pimpinanalumniController@delete');



    //Kuesioner Stakeholder
    Route::get('/kuesioner/stakeholder','pimpinanstakeholderController@show')->name('stakeholder-kuesioner-show');
    Route::get('/kuesioner/stakeholder/showkuesioner/{id}/{status}', 'pimpinanstakeholderController@status');
    Route::get('/kuesioner/stakeholder/detail/{id_prodi}/{id_periode}', 'pimpinanstakeholderController@detail_kuesioner');
    Route::post('/kuesioner/stakeholder/filter','pimpinanstakeholderController@filter')->name('stakeholder-filter');



    //Kuesioner ALumni
    Route::get('/kuesioner','pimpinankuesionerController@show');
    Route::get('/kuesioner/{id}/delete','pimpinankuesionerController@delete');
    Route::get('/kuesioner/showkuesioner/{id}','pimpinankuesionerController@detail')->name('detail-kuesioner');
    Route::get('/tracer', 'pimpinankuesionerController@detailjawaban');
    Route::post('/kuesioner/filter','pimpinankuesionerController@filter')->name('filter-kuesioner');

    Route::get('/periodekuesioner','kuesionerperiodeController@show');

    //Detail Kuesioner ALumni
    Route::get('/kuesioner/{id}', 'pimpinankuesionerController@showdetail');
    Route::get('/kuesioner/showkuesioner/{id}','pimpinankuesionerController@detail')->name('detail-kuesioner');

    Route::get('/kuesioner/showkuesioner/{id}/{status}', 'pimpinankuesionerController@statusall');



    //Report alumni
    Route::get('/reportalumni','pimpinanreportalumniController@traceralumni')->name('pimpinan-alumni-report');
    Route::get('/reportalumni/{id}','pimpinanreportalumniController@detailtracer');
    // Route::post('/reportalumni/filteralumni','pimpinanreportalumniController@filteralumni');
    Route::post('/reportalumni/filter', 'pimpinanreportalumniController@filteralumni');

    //Report Stakeholder
    Route::get('/reportstakeholder','pimpinanreportstakeholderController@report')->name('pimpinan-alumni-report');
    Route::get('/reportstakeholder/{id}','pimpinanreportstakeholderController@detailreport');
    Route::post('/reportstakeholder/filterreport','pimpinanreportstakeholderController@filterreport');

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
    route::post('/login', [ 'as' => 'alumni-login', 'uses' => 'LoginController@login']);
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
    Route::get('/password', 'Alumni\PasswordController@password')->name('alumni-password-edit');
    Route::post('/updatepassword', 'Alumni\PasswordController@updatepassword')->name('alumni-password-update');
});

Route::group(['prefix' => 'alumni',  'middleware' => 'VerifiedAlumniMiddleware'],function(){

    Route::get('/profile', 'Alumni\AuthAlumniController@profile')->name('alumni-profile-edit');
    Route::post('/profile-update', 'Alumni\AuthAlumniController@updateProfile')->name('alumni-profile-update');
    Route::post('/kuesioner', 'Alumni\Kuesioner\AlumniDetailKuesionerController@show');
    Route::get('/prekuesioner', 'Alumni\Kuesioner\AlumniKuesionerController@show');
    Route::post('/kuesioner/simpan', 'Alumni\Kuesioner\AlumniDetailKuesionerController@jawabKuesioner')
        ->name('simpan-kuesioner');
    Route::get('/hasilKuesioner', 'Alumni\Kuesioner\AlumniDetailKuesionerController@hasilKuesioner');
    Route::post('/hasilKuesioner/update/{id}', 'Alumni\Kuesioner\AlumniDetailKuesionerController@updateHasilKuesioner');

});

Route::group(['prefix' => 'stakeholder'],function(){
    route::get('/','Stakeholder\Auth\StakeholderRegisterController@index');
    route::post('/', [ 'as' => 'login', 'Stakeholder\Auth\StakeholderRegisterController@index']);
    route::post('/kuesioner','Stakeholder\Auth\StakeholderRegisterController@regisStakeholder')->name('regisStakeholder');
    Route::post('/kuesioner/simpan', 'Stakeholder\Kuesioner\StakeholderDetailKuesionerController@jawabKuesioner')
        ->name('simpan-kuesioner-stakeholder');
    Route::get('/hasilKuesioner', 'Stakeholder\Kuesioner\StakeholderDetailKuesionerController@hasilKuesioner');
    Route::post('/hasilKuesioner/update/{id}', 'Stakeholder\Kuesioner\StakeholderDetailKuesionerController@updateHasilKuesioner');
    route::get('/logouts','Stakeholder\Auth\StakeholderRegisterController@logout');

});



