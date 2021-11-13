<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('accounts/authenticate', 'MobileAppController@loginAccount');
Route::post('accounts/push_token', 'MobileAppController@SaveDeviceToken');
Route::post('appointments/GetAppoinmentsByCoach', 'MobileAppController@getAppointmenDetailsByPatientId');
Route::post('appointments/GetAppoinmentsByPrincipal', 'MobileAppController@getAppointmenDetailsByPrincipal');
Route::post('agora/AgoraTokenGeneration', 'MobileAppController@AgoraTokenGeneration');
Route::post('library/GetCategories', 'MobileAppController@getCategories');
Route::post('library/GetLibraryPost', 'MobileAppController@getLibraryPost');




Route::post('getCategories', 'MobileAppController@getCategories');
Route::post('getDoctors', 'MobileAppController@getDoctors');
Route::post('getPrescriptionByPatient', 'MobileAppController@getPrescriptionByPatient');
Route::post('getPrescriptionImageById', 'MobileAppController@getPrescriptionImageById');
Route::post('getDoctorsByCat', 'MobileAppController@getDoctorsByCat');
Route::post('getAppointmentTimeSlots', 'MobileAppController@getAppointmentTimeSlots');
Route::post('appointmentStore', 'MobileAppController@appointmentStore');
Route::post('GetAppointmenDetailsByPatientId', 'MobileAppController@getAppointmenDetailsByPatientId');
Route::post('getArticlesByDocId', 'MobileAppController@getArticlesByDocId');
Route::post('GetYotubeByDocId', 'MobileAppController@getYotubeByDocId');
Route::post('GetAllBooks', 'MobileAppController@getAllBooks');
Route::post('PrescriptionStore', 'MobileAppController@prescriptionStore');
Route::post('PrescriptionUpload', 'MobileAppController@UploadPrescriptionImage');
Route::post('getAppointmenDetailsByDoctorId', 'MobileAppController@getAppointmenDetailsByDoctorId');
Route::post('ScheduleManage', 'MobileAppController@scheduleManage');
Route::post('patientRegister', 'MobileAppController@storePatient');
Route::post('UploadPatientImage', 'MobileAppController@UploadPatientImage');
Route::post('doctorRegister', 'MobileAppController@storeDoctor');
Route::post('UploadDoctorImage', 'MobileAppController@UploadDoctorImage');
Route::post('getpatientDetails', 'MobileAppController@getPatientDetails');
Route::post('getDoctorDetails', 'MobileAppController@getDoctorDetails');
Route::post('UpdateDoctorDetails', 'MobileAppController@updateDoctorDetails');
Route::post('updatePtientDetails', 'MobileAppController@updatePtientDetails');
Route::post('paymentresponse', 'MobileAppController@visa_master_payment_done')->name('payment.done');
Route::post('StoreBookPurchase', 'MobileAppController@storeBookPurchase');
Route::post('PurchaseHistory', 'MobileAppController@purchaseHistory');
Route::post('DoctorPasswordResetOTP', 'MobileAppController@drsendPasswordResetOTP');
Route::post('PatientPasswordResetOTP', 'MobileAppController@patientsendPasswordResetOTP');
Route::post('UpdatePatientPassword', 'MobileAppController@updatePatientPassword');
Route::post('UpdateDoctorPassword', 'MobileAppController@updateDoctorPassword');
Route::post('DeleteAppointment', 'MobileAppController@DeleteAppointment');
