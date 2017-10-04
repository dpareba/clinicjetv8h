<?php


Route::get('/', function () {
    return view('welcome');
});


//Route::get('/home', 'HomeController@index');

Auth::routes();

Route::get('register/confirm/{token}','Auth\RegisterController@confirmEmail');

Route::get('/newmember','MemberController@index')->name('newmember');
Route::post('/joincode','MemberController@joincode');
Route::get('/addnew','MemberController@createnew');
Route::post('/newdoctor','MemberController@newdoctor')->name('newdoctor');
Route::post('/newrecep','MemberController@newrecep')->name('newrecep');
Route::get('/managemember','MemberController@managemember')->name('managemember');
Route::post('delete','MemberController@delete')->name('delete');
Route::post('attachmember','MemberController@attachmember')->name('attachmember');
Route::get('/getCodeNumber','MemberController@getCodeNumber');
Route::get('/getMember','MemberController@getMember');

Route::get('check','ClinicController@check')->name('check');
Route::resource('clinics','ClinicController');

Route::post('dashboard','PatientController@dashboard')->name('dashboard');
Route::post('patients.consent','PatientController@consent')->name('consent');
Route::resource('patients','PatientController');

Route::get('patients.docspatients',function(){
		return view('patients.docspatients');
	});
// Route::get('patients.index',function(){
// 		return view('patients.index');
// });
Route::get('patients/createconsult/{id}/{repeatvisitid}/{editconsult}',[
	'as'=>'patients.createconsult',
	'uses'=>'PatientController@createconsult'
	]);

Route::get('/getMyPatient','PatientController@getMyPatient');
Route::get('/getAllPatient','PatientController@getAllPatient');
Route::get('/showPatient','PatientController@showPatient');
Route::get('/getOTP','PatientController@getOTP');


Route::get('slots.appointmentstoday','SlotController@appointmentstoday')->name('slots.appointmentstoday');
Route::get('/getArrivalTime','SlotController@getArrivalTime');

Route::post('showVisits','VisitController@showVisits')->name('showVisits');



/********************************************************/



Route::get('printvisit/{id}/{printall}',[
	'as'=>'print.visits',
	'uses'=>'PrintController@printVisit'
	]);




Route::get('printvisit/{id}/{printall}',[
	'as'=>'print.visits',
	'uses'=>'PrintController@printVisit'
	]);
Route::get('profile',[
	'as'=>'profile',
	'uses'=>'UserController@profile'
	]);

Route::post('profile','UserController@updateAvatar');

Route::resource('tokens','TokenController');

Route::resource('passkeys','PasskeyController');

Route::resource('clinictokens','ClinictokenController');



Route::resource('visits','VisitController',['except'=>['create','store','edit']]);

Route::post('visits/edit/{id}',[
	'as'=>'visits.edit',
	'uses'=>'VisitController@edit'
	]);

Route::get('visits/create/{id}',[
	'as'=>'visits.create',
	'uses'=>'VisitController@visitcreate'
	]);


Route::post('visits/store',[
	'as'=>'visits.store',
	'uses'=>'VisitController@visitstore'
	]);

Route::post('visits/storeloc',[
	'as'=>'visits.storelocal',
	'uses'=>'VisitController@visitsstorelocal'
	]);

Route::resource('reports','ReportController',['except'=>['create','show']]);

Route::get('reports/create/{id}',[
	'as'=>'reports.create',
	'uses'=>'ReportController@create'
	]);

Route::post('reports/show',[
	'as'=>'reports.show',
	'uses'=>'ReportController@show'
	]);

Route::post('image/do-upload',[
	'as'=>'images.upload',
	'uses'=>'ReportController@doImageUpload'
	]);




Route::get('videocall/initiate',[
	'as'=>'videocall.initiate',
	'uses'=>'VideoController@initiateVideoCall'
	]);



Route::resource('print','PrintController');

Route::resource('medicines','MedicineController',['except'=>'index']);

Route::get('medicines.index/{id}',[
	'as'=>'medicines.index',
	'uses'=>'MedicineController@index'
	]);

Route::resource('pathologies','PathologyController');

Route::resource('templates','TemplateController');

Route::get('showcc',[
	'as'=>'templates.showcc',
	'uses'=>'TemplateController@showcc'
	]);

Route::get('showef',[
	'as'=>'templates.showef',
	'uses'=>'TemplateController@showef'
	]);

Route::post('storecc',[
	'as'=>'templates.storecc',
	'uses'=>'TemplateController@storecc'
	]);

Route::post('storeef',[
	'as'=>'templates.storeef',
	'uses'=>'TemplateController@storeef'
	]);

//Route::resource('tests','TestController');


Route::resource('slots','SlotController');

Route::post('slots.assigntoken',[
	'as'=>'slots.assigntoken',
	'uses'=>'SlotController@assigntoken'
	]);

Route::get('slots.appointmentstoday',[
	'as'=>'slots.appointmentstoday',
	'uses'=>'SlotController@appointmentstoday'
	]);


Route::get('repeatvisit',[
	'as'=>'visits.repeatvisit',
	'uses'=>'VisitController@repeatvisit'
	]);


Route::get('useractivation/{token}',[
	'as'=>'useractivation',
	'uses'=>'ActivationController@activateuser'
]);

Route::get('useractivationstatus',function(){
	return view('errors.userverification');
});







