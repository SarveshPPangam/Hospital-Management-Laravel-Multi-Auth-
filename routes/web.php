<?php

use App\Models\Specialization;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware'=>'web'], function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/bookAppointment', [App\Http\Controllers\HomeController::class, 'bookAppointmentForm'])->name('bookAppointment');
    Route::get('/doctorsRequest/{id}',[App\Http\Controllers\HomeController::class, 'getDoctors'])->name('doctorsRequest');
    Route::get('/feesRequest/{id}',[App\Http\Controllers\HomeController::class, 'getFees'])->name('feesRequest');
    Route::post('/bookAppointment', [App\Http\Controllers\HomeController::class, 'bookAppointment'])->name('bookAppointment');
    Route::get('/appointmentHistory', [App\Http\Controllers\HomeController::class, 'appointmentHistory'])->name('appointmentHistory');
    Route::put('/cancelAppointment', [App\Http\Controllers\HomeController::class, 'cancelAppointment'])->name('cancelAppointment');

    Route::get('/medicalHistory', [App\Http\Controllers\HomeController::class, 'medicalHistory'])->name('medicalHistory');

    Route::view('updateUser','userEditForm')->name('home.updateUser');
    Route::post('updateUser',  [App\Http\Controllers\HomeController::class,'updateUser'])->name('updateUser');

    Route::view('updatePassword','updatePassForm')->name('home.updatePasswordForm');
    Route::post('updatePassword',  [App\Http\Controllers\HomeController::class,'updatePassword'])->name('updatePassword');

});

Route::group(['prefix'=>'admin'], function () {
    Route::group(['middleware'=>'admin.guest'], function () {
        Route::view('login', 'admin.login')->name('admin.login');
        Route::post('login', [App\Http\Controllers\AdminController::class,'login'])->name('admin.auth');
    });
    Route::group(['middleware'=>'admin.auth'], function () {
        Route::view('dashboard', 'admin.home')->name('admin.home');

        Route::get('manageDoctors', [App\Http\Controllers\AdminController::class,'manageDoctors'])->name('manageDoctors');
        Route::get('editDoctor/{id}', [App\Http\Controllers\AdminController::class,'editDoctor'])->name('editDoctor');
        Route::get('deleteDoctor/{id}', [App\Http\Controllers\AdminController::class,'deleteDoctor'])->name('deleteDoctor');
        Route::post('update',  [App\Http\Controllers\AdminController::class,'updateDoctor'])->name('updateDoctor');
        Route::post('add',  [App\Http\Controllers\AdminController::class,'addDoctor'])->name('addDoctorSubmit');
        Route::view('addDoctor', 'admin.addDoctorForm')->name('addDoctor');

        Route::get('manageSpecializations', [App\Http\Controllers\AdminController::class,'manageSpecializations'])->name('manageSpecializations');
        Route::get('getSpecialization/{id}',[App\Http\Controllers\AdminController::class,'getSpecialization']);
        Route::post('addSpecialization', [App\Http\Controllers\AdminController::class,'addSpecializationAJAX'])->name('addSpecialization');
        Route::put('updateSpecialization', [App\Http\Controllers\AdminController::class,'updateSpecializationAJAX'])->name('updateSpecialization');
        Route::delete('deleteSpecialization/{id}', [App\Http\Controllers\AdminController::class,'deleteSpecializationAJAX'])->name('deleteSpecialization');

        Route::get('manageUsers', [App\Http\Controllers\AdminController::class,'manageUsers'])->name('manageUsers');
        Route::delete('deleteUser/{id}', [App\Http\Controllers\AdminController::class,'deleteUserAJAX']);

        Route::get('managePatients', [App\Http\Controllers\AdminController::class,'managePatients'])->name('managePatients');
        Route::get('viewPatient/{id}', [App\Http\Controllers\AdminController::class,'viewPatient'])->name('admin.viewPatient');

        Route::get('search', [App\Http\Controllers\AdminController::class,'searchPage'])->name('admin.searchPage');
        Route::get('searchResults', [App\Http\Controllers\AdminController::class,'search'])->name('admin.search');

        Route::view('updateAdmin','admin.updateAdminForm')->name('updateAdminForm');
        Route::post('updateAdmin',  [App\Http\Controllers\AdminController::class,'updateAdmin'])->name('updateAdmin');

        Route::view('updatePassword','admin.updatePassForm')->name('updatePassForm');
        Route::post('updatePassword',  [App\Http\Controllers\AdminController::class,'updatePassword'])->name('admin.updatePassword');

        Route::post('logout', [App\Http\Controllers\AdminController::class,'logout'])->name('admin.logout');
    });
});


Route::group(['prefix'=>'doctor'], function () {
    Route::group(['middleware'=>'doctor.guest'], function () {
        Route::view('login', 'doctor.login')->name('doctor.login');
        Route::post('login', [App\Http\Controllers\DoctorController::class,'login'])->name('doctor.auth');
    });
    Route::group(['middleware'=>'doctor.auth'], function () {
        Route::view('dashboard', 'doctor.home')->name('doctor.home');

        Route::view('addPatient', 'doctor.addPatientForm')->name('doctor.addPatient');
        Route::post('add',  [App\Http\Controllers\DoctorController::class,'addPatient'])->name('addPatientSubmit');
        Route::get('showPatients', [App\Http\Controllers\DoctorController::class,'showPatients'])->name('doctor.showPatients');
        Route::get('updatePatient/{id}', [App\Http\Controllers\DoctorController::class,'updatePatientForm'])->name('updatePatientForm');
        Route::post('updatePatient',  [App\Http\Controllers\DoctorController::class,'updatePatient'])->name('updatePatient');
        Route::delete('deletePatient/{id}', [App\Http\Controllers\DoctorController::class,'deletePatient'])->name('deletePatient');
        Route::get('viewPatient/{id}', [App\Http\Controllers\DoctorController::class,'viewPatient'])->name('doctor.viewPatient');
        Route::post('addMedicalHistory', [App\Http\Controllers\DoctorController::class,'addMedicalHistoryAJAX'])->name('doctor.addMedicalHistory');

        Route::get('appointmentHistory', [App\Http\Controllers\DoctorController::class, 'appointmentHistory'])->name('doctor.appointmentHistory');
        Route::put('cancelAppointment', [App\Http\Controllers\DoctorController::class, 'cancelAppointment'])->name('doctor.cancelAppointment');

        Route::get('search', [App\Http\Controllers\DoctorController::class,'searchPage'])->name('doctor.searchPage');
        Route::get('searchResults', [App\Http\Controllers\DoctorController::class,'search'])->name('doctor.search');

        Route::view('updatePassword','doctor.updatePassForm')->name('doctor.updatePasswordForm');
        Route::post('updatePassword',  [App\Http\Controllers\DoctorController::class,'updatePassword'])->name('doctor.updatePassword');

        Route::post('logout', [App\Http\Controllers\DoctorController::class,'logout'])->name('doctor.logout');
    });
});

