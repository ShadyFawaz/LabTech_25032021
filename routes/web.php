<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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
Route::get('test', function () {
    return view('test');
});
Route::get('navbar', function () {
    return view('test');
});
Route::get('/barcode', 'TestController@generateBarcode');

Route::get('/uploadfile', 'UploadfileController@index');
Route::post('/uploadfile', 'UploadfileController@upload');
Route::get('/main', 'MainController@index');
Route::post('/main/checklogin', 'MainController@checklogin');
Route::get('main/successlogin', 'MainController@successlogin');
Route::get('main/logout', 'MainController@logout');

Route::get('/dynamic_dependent', 'DynamicDependent@index');
Route::post('dynamic_dependent/fetch', 'DynamicDependent@fetch')->name('dynamicdependent.fetch');

Route::get('permissions','permissionsController@insert');
Route::post('newpermissioncreate','permissionsController@create');
Route::get('cbc','cbcreportcontroller@indexmega');


Route::get('testentry/{regkey}','testentry\TestEntryController@index');
Route::get('resultsbyday','testentry\resultbydayController@index');
Route::get('searchresultsbyday','testentry\searchresultbydayController@index');
Route::post('resultsmenu','testentry\searchresultbydayController@SearchResultsByDay');
Route::get('patientresults/{regkey}','testentry\searchresultbydayController@patientresults');
Route::get('patienthistory/{regkey}/{group}/{megatest_id}/{seperate_test}','testentry\PatientHistoryController@PatientHistoryMega');
Route::get('patienthistory/{regkey}/{group}/{seperate_test}','testentry\PatientHistoryController@PatientHistoryGroup');

Route::get('resultentry/{regkey}/{group}/{megatest_id}/{seperate_test}','testentry\ResultEntryController@indexMega')->name('resultentry');
Route::get('resultentry/{regkey}/{group}/{seperate_test}','testentry\ResultEntryController@indexGroup')->name('resultentry');

Route::post('editresultentry/{regkey}/{group}/{seperate_test}','testentry\ResultEntryController@editGroup');
Route::post('editresultentry/{regkey}/{group}/{megatest_id}/{seperate_test}','testentry\ResultEntryController@editMega');

Route::get('verifyresultentry/{regkey}/{subgroup}/{seperate_test}','testentry\ResultEntryController@verifyGroup');
Route::get('verifyresultentry/{regkey}/{subgroup}/{megatest_id}/{seperate_test}','testentry\ResultEntryController@verifyMega');

Route::get('newtestentry','testentry\newtestentryController@insert');
Route::post('newtestentrycreate','testentry\newtestentryController@create');
Route::get('report/{regkey}/{subgroup}/{seperate_test}','reportController@indexGroup');
Route::get('reportPDF/{regkey}/{subgroup}/{seperate_test}','reportController@indexGroupPDF');

Route::get('report/{regkey}/{subgroup}/{megatest_id}/{seperate_test}','reportController@indexMega');
Route::get('reportPDF/{regkey}/{subgroup}/{megatest_id}/{seperate_test}','reportController@indexMegaPDF');

Route::get('cbcreport/{regkey}/{subgroup}/{megatest_id}/{seperate_test}','reportController@indexMega');



// Route::get('testentry', function () {
//     return view('testentry');
// });
Route::get('mainmenutrial', function () {
    return view('MainMenuTrial');
});
Route::get('mainmenu', function () {
    return view('MainMenu');
});
Route::get('home', function () {
    // dd(Auth::check());
    return view('HomeScreen');
});

Route::get('technicalsupport', function () {
    return view('TechnicalSupport');
});

Route::get('/', function () {
    return view('welcome');
});


Route::get('login','Users\LoginController@showlogin');
Route::post('login','Users\LoginController@login');
Route::get('logout','Users\LoginController@logout');



// Route::get('patientreg', function () {
//     return view('PatientReg');
// });

// Route::get('users', function () {
//     return view('users\viewsystemusers');
// });

Route::get('insert','Users\UsersController@insert');
Route::post('create','Users\UsersController@create');

// Users Routes
Route::get('users', function () {
    return view('users\users');
});

Route::get('users','users\usersController@index');
Route::get('newuser','users\usersController@insert');
Route::post('newusercreate','users\usersController@create');

Route::get('edituser/{user_id}','users\usersController@show');
Route::post('edituser/{user_id}','users\usersController@edit');

// Roles Routes
Route::get('users', function () {
    return view('users\users');
});

Route::get('roles','roles\rolesController@index');
Route::get('newrole','roles\rolesController@insert');
Route::post('newrolecreate','roles\rolesController@create');

Route::get('editrole/{id}','roles\rolesController@show');
Route::post('editrole/{id}','roles\rolesController@edit');

// Permissions Routes
Route::get('users', function () {
    return view('users\users');
});

Route::get('users','users\usersController@index');
Route::get('newuser','users\usersController@insert');
Route::post('newusercreate','users\usersController@create');

Route::get('edituser/{user_id}','users\usersController@show');
Route::post('edituser/{user_id}','users\usersController@edit');

// Titles Routes
Route::get('viewtitles', function () {
    return view('titles\titles');
});

Route::get('titles','Titles\viewtitlesController@index');
Route::get('trashedtitles','Titles\viewtitlesController@trashedindex');

Route::get('newtitle','Titles\TitlesController@insert');
Route::post('newtitlecreate','Titles\TitlesController@create');

Route::get('edittitle','Titles\edittitleController@index');
Route::get('edittitle/{title_id}','Titles\edittitleController@show');
Route::post('edittitle/{title_id}','Titles\edittitleController@edit');
Route::get('deletetitle/{title_id}','Titles\titlesController@delete');
Route::get('restoretitle/{title_id}','Titles\titlesController@restore');

// Country Routes
Route::get('viewcountry', function () {
    return view('country\country');
});

Route::get('country','Country\viewcountryController@index');
Route::get('trashedcountry','Country\viewCountryController@trashedindex');
Route::get('newcountry','Country\CountryController@insert');
Route::post('newcountrycreate','Country\CountryController@create');

Route::get('editcountry','Country\editcountryController@index');
Route::get('editcountry/{country_id}','Country\editcountryController@show');
Route::post('editcountry/{country_id}','Country\editcountryController@edit');
Route::get('deletecountry/{country_id}','Country\countryController@delete');
Route::get('restorecountry/{country_id}','Country\countryController@restore');

// Sample Types Routes
Route::get('viewsampletype', function () {
    return view('sampletype\sampletype');
});

Route::get('sampletype','sampletype\viewsampletypeController@index');
Route::get('newsampletype','sampletype\sampletypeController@insert');
Route::post('newsampletypecreate','SampleType\sampletypeController@create');

Route::get('editsampletype','sampletype\editsampletypeController@index');
Route::get('editsampletype/{sampletype_id}','sampletype\editsampletypeController@show');
Route::post('editsampletype/{sampletype_id}','sampletype\editsampletypeController@edit');
Route::get('deletesampletype/{sampletype_id}','sampletype\sampletypeController@delete');


// Sample Condition Routes
Route::get('viewsamplecondition', function () {
    return view('samplecondition\samplecondition');
});

Route::get('samplecondition','samplecondition\viewsampleconditionController@index');
Route::get('newsamplecondition','samplecondition\sampleconditionController@insert');
Route::post('newsampleconditioncreate','samplecondition\sampleconditionController@create');

Route::get('editsamplecondition','samplecondition\editsampleconditionController@index');
Route::get('editsamplecondition/{samplecondition_id}','samplecondition\editsampleconditionController@show');
Route::post('editsamplecondition/{samplecondition_id}','samplecondition\editsampleconditionController@edit');
Route::get('deletesamplecondition/{samplecondition_id}','samplecondition\sampleconditionController@delete');


// Lab Unit Routes
Route::get('viewlabunit', function () {
    return view('labunit\labunit');
});

Route::get('labunit','labunit\viewlabunitController@index');
Route::get('newlabunit','labunit\labunitController@insert');
Route::post('newlabunitcreate','labunit\labunitController@create');

Route::get('editlabunit','labunit\editlabunitController@index');
Route::get('editlabunit/{labunit_id}','labunit\editlabunitController@show');
Route::post('editlabunit/{labunit_id}','labunit\editlabunitController@edit');
Route::get('deletelabunit/{labunit_id}','labunit\labunitController@delete');


// Patient Conditions Routes
Route::get('viewpatientcondition', function () {
    return view('patientcondition\patientcondition');
});

Route::get('patientcondition','patientcondition\patientconditionController@index');
Route::get('trashedpatientcondition','patientcondition\patientconditionController@trashedindex');

Route::get('newpatientcondition','patientcondition\patientconditionController@insert');
Route::post('newpatientconditioncreate','patientcondition\patientconditionController@create');

Route::get('editpatientcondition','labunit\patientconditionController@index');
Route::get('editpatientcondition/{patientcondition_id}','patientcondition\patientconditionController@show');
Route::post('editpatientcondition/{patientcondition_id}','patientcondition\patientconditionController@edit');
Route::get('deletepatientcondition/{patientcondition_id}','patientcondition\patientconditionController@delete');
Route::get('restorepatientcondition/{patientcondition_id}','patientcondition\patientconditionController@restore');


// Diagnosis Routes
Route::get('viewdiagnosis', function () {
    return view('diagnosis\diagnosis');
});

Route::get('diagnosis','diagnosis\viewdiagnosisController@index');
Route::get('trasheddiagnosis','diagnosis\viewdiagnosisController@trashedindex');

Route::get('newdiagnosis','diagnosis\diagnosisController@insert');
Route::post('newdiagnosiscreate','diagnosis\diagnosisController@create');

Route::get('editdiagnosis','diagnosis\editdiagnosisController@index');
Route::get('editdiagnosis/{diagnosis_id}','diagnosis\editdiagnosisController@show');
Route::post('editdiagnosis/{diagnosis_id}','diagnosis\editdiagnosisController@edit');
Route::get('deletediagnosis/{diagnosis_id}','diagnosis\diagnosisController@delete');
Route::get('restorediagnosis/{diagnosis_id}','diagnosis\diagnosisController@restore');


// Antibiotics Routes
Route::get('viewantibiotics', function () {
    return view('antibiotics\antibiotics');
});

Route::get('antibiotics','antibiotics\viewantibioticsController@index');
Route::get('trashedantibiotics','antibiotics\viewantibioticsController@trashedindex');
Route::get('newantibiotic','antibiotics\antibioticsController@insert');
Route::post('newantibioticcreate','antibiotics\antibioticsController@create');

Route::get('editantibiotic','antibiotics\editantibioticController@index');
Route::get('editantibiotic/{antibiotic_id}','antibiotics\editantibioticController@show');
Route::post('editantibiotic/{antibiotic_id}','antibiotics\editantibioticController@edit');
Route::get('deleteantibiotic/{antibiotic_id}','antibiotics\antibioticsController@delete');
Route::get('restoreantibiotic/{antibiotic_id}','antibiotics\antibioticsController@restore');

// Organism Routes
Route::get('vieworganism', function () {
    return view('organism\organism');
});

Route::get('organism','organism\vieworganismController@index');
Route::get('trashedorganism','organism\vieworganismController@trashedindex');
Route::get('neworganism','organism\organismController@insert');
Route::post('neworganismcreate','organism\organismController@create');

Route::get('editorganism','organism\editorganismController@index');
Route::get('editorganism/{organism_id}','organism\editorganismController@show');
Route::post('editorganism/{organism_id}','organism\editorganismController@edit');
Route::get('deleteorganism/{organism_id}','organism\organismController@delete');
Route::get('restoreorganism/{organism_id}','organism\organismController@restore');


// Doctor Routes
Route::get('viewdoctor', function () {
    return view('doctor\doctor');
});

Route::get('doctor','doctor\viewdoctorController@index');
Route::get('trasheddoctor','doctor\viewdoctorController@trashedindex');
Route::get('newdoctor','doctor\doctorController@insert');
Route::post('newdoctorcreate','doctor\doctorController@create');

Route::get('editdoctor','doctor\editdoctorController@index');
Route::get('editdoctor/{doctor_id}','doctor\editdoctorController@show');
Route::post('editdoctor/{doctor_id}','doctor\editdoctorController@edit');
Route::get('deletedoctor/{doctor_id}','doctor\doctorController@delete');
Route::get('restoredoctor/{doctor_id}','doctor\doctorController@restore');


   // Out Labs Routes
   Route::get('outlabs','outlabs\outlabsController@index');
   Route::get('newoutlab','outlabs\outlabsController@insert');
   Route::post('newoutlabcreate','outlabs\outlabsController@create');
   
   Route::get('editoutlab','outlabs\outlabsController@index');
   Route::get('editoutlab/{outlab_id}','outlabs\outlabsController@show');
   Route::post('editoutlab/{outlab_id}','outlabs\outlabsController@edit');
   
   // Out Lab Tests Routes
   Route::get('outlabtests/{outlab_id}','outlabtests\outlabtestsController@index');
   Route::get('newoutlabtests/{outlab_id}','outlabtests\outlabtestsController@insert');
   Route::post('newoutlabtestscreate/{outlab_id}','outlabtests\outlabtestsController@create');
   
   Route::get('editoutlabtests','outlabtests\outlabtestsController@index');
   Route::get('editoutlabtests/{testprice_id}','outlabtests\outlabtestsController@show');
   Route::post('editoutlabtests/{testprice_id}','outlabtests\outlabtestsController@edit');
   Route::get('newoutlabtestscreate','outlabtests\outlabtestsController@create');
   Route::get('newoutlaboutlabtests/{outlab_id}','outlabtests\outlabtestsController@new');
   Route::get('deleteoutlabtest/{testprice_id}','outlabtests\outlabtestsController@delete');
   Route::post('updateoutlab/{outlab_id}','outlabtests\outlabtestsController@UpdatePrices');


// Culture Link Routes
Route::get('viewculturelink', function () {
    return view('culturelink\culturelink');
});

Route::get('culturelink','culturelink\viewculturelinkController@index');
Route::get('newculturelink','culturelink\culturelinkController@insert');
Route::post('newculturelinkcreate','culturelink\culturelinkController@create');

Route::get('editculturelink','culturelink\editculturelinkController@index');
Route::get('editculturelink/{culturelink_id}','culturelink\editculturelinkController@show');
Route::post('editculturelink/{culturelink_id}','culturelink\editculturelinkController@edit');

// Results Units Routes
Route::get('viewresultsunits', function () {
    return view('resultsunits\resultsunits');
});

Route::get('resultsunits','resultsunits\viewresultsunitsController@index');
Route::get('newresultsunits','resultsunits\resultsunitsController@insert');
Route::post('newresultsunitscreate','resultsunits\resultsunitsController@create');

Route::get('editresultsunits','resultsunits\editresultsunitsController@index');
Route::get('editresultsunits/{resultunit_id}','resultsunits\editresultsunitsController@show');
Route::post('editresultsunits/{resultunit_id}','resultsunits\editresultsunitsController@edit');

// Groups Routes
Route::get('viewcgroups', function () {
    return view('groups\groups');
});

Route::get('groups','groups\viewgroupsController@index');
// Route::get('newgroups','groups\groupsController@insert');
Route::get('newgroups','groups\groupsController@insert');
Route::post('newgroupscreate','groups\groupsController@create');

Route::get('editgroups','groups\editgroupsController@index');
Route::get('editgroups/{group_id}','groups\editgroupsController@show');
Route::post('editgroups/{group_id}','groups\editgroupsController@edit');
Route::get('grouptests/{group_id}','groups\groupsController@groupTests');


// Sub Groups Routes
Route::get('subgroups', function () {
    return view('subgroups\subgroups');
});

Route::get('subgroups/{group_id}','subgroups\subgroupsController@index');
//Route::get('normalranges/{normal_id}','normalranges\viewnormalrangesController@index');
Route::get('newsubgroups','subgroups\subgroupsController@insert');
Route::post('newsubgroupscreate','subgroups\subgroupsController@create');

Route::get('editsubgroups','subgroups\subgroupsController@index');
Route::get('editsubgroups/{subgroup_id}','subgroups\subgroupsController@show');
Route::post('editsubgroups/{subgroup_id}','subgroups\subgroupsController@edit');
Route::get('newsubgroupscreate','subgroups\subgroupsController@create');
Route::get('newgroupsubgroup/{group_id}','subgroups\subgroupsController@new');


// Patient Data Routes
Route::get('patientdata', function () {
    return view('patientdata\PatientData');
});
Route::get('batchpatientdata', function () {
    return view('patientdata\batchPatientData');
});
Route::get('viewpatientdata','patientdata\viewpatientdataController@index');
Route::get('newpatientdata','PatientData\NewPatientDataController@insert');
Route::post('newpatientdatacreate','PatientData\NewPatientDataController@create');

Route::get('editpatientdata','PatientData\editpatientdataController@index');
Route::get('editpatientdata/{patient_code}','PatientData\editpatientdataController@show');
Route::post('editpatientdata/{patient_code}','PatientData\editpatientdataController@edit');


// Patient Reg Routes
Route::get('patientreg', function () {
    return view('patientreg\patientreg');
});

Route::get('patientreg','patientreg\patientregController@index');
Route::post('patientregsearch','patientreg\patientregController@search');
Route::get('patientregdeleted','patientreg\patientregController@indexTrashed');
Route::post('patientregdeletedsearch','patientreg\patientregController@searchTrashed');
Route::get('patientregsearch/{datefrom}/{dateto}','patientreg\patientregController@search');

Route::get('newpatientreg/{patient_id?}','patientreg\newpatientregController@insert');
Route::get('newpatientregprofile/{patient_id?}','patientreg\newpatientregprofileController@insert');
Route::post('newpatientregcreate','patientreg\newpatientregController@create');
Route::post('newpatientregprofilecreate','patientreg\newpatientregprofileController@create');

Route::get('editpatientreg','patientreg\editpatientregController@index');
Route::get('editpatientreg/{regkey}','patientreg\editpatientregController@show');
Route::get('transactionpatientreg/{regkey}','transactions\transactionsController@index');
Route::get('deletetransaction/{transaction_id}','transactions\transactionsController@deleteTransaction');

Route::get('patientreset/{regkey}','transactions\transactionsController@reset');
Route::post('editpatientreg/{regkey}','patientreg\editpatientregController@edit');
Route::get('patientid/{patient_id}','patientreg\patientidregController@index');
Route::get('deletepatient/{regkey}','patientreg\patientregController@deletePatient');
Route::get('restorepatient/{regkey}','patientreg\patientregController@restorePatient');


// Test Data Routes
Route::get('testdata', function () {
    return view('testdata\testdata');
});
Route::get('batchtestdata', function () {
    return view('testdata\batchtestdata');
});
Route::get('testdataback','testdata\testdataController@index');
Route::get('testdata','testdata\testdataController@index');
Route::get('newtestdata','testdata\NewtestdataController@insert');
Route::post('newtestdatacreate','testdata\NewtestdataController@create');

Route::get('edittestdata','testdata\edittestdataController@index');
Route::get('edittestdata/{test_id}','testdata\edittestdataController@show');
Route::post('edittestdata/{test_id}','testdata\edittestdataController@edit');


// Mega Tests Routes
Route::get('megatests', function () {
    return view('megatests\megatests');
});

Route::get('megatests','megatests\viewmegatestsController@index');
Route::get('newmegatests','megatests\megatestsController@insert');
Route::post('newmegatestscreate','megatests\megatestsController@create');

Route::get('editmegatests','megatests\editmegatestsController@index');
Route::get('editmegatests/{megatest_id}','megatests\editmegatestsController@show');
Route::post('editmegatests/{megatest_id}','megatests\editmegatestsController@edit');

// Mega Tests Child Routes
Route::get('megatestschild', function () {
    return view('megatestschild\megatestschild');
});

Route::get('megatestschild/{megatest_id}','megatestschild\viewmegatestschildController@index');
Route::get('newmegatestschild/{megatest_id}','megatestschild\megatestschildController@insert');
Route::post('newmegatestschildcreate/{megatest_id}','megatestschild\megatestschildController@create');
Route::post('editmegatestschilds/{megatest_id}','megatestschild\viewmegatestschildController@edit');

Route::get('editmegatestschild','megatestschild\editmegatestschildController@index');
Route::get('editmegatestschild/{test_code}','megatestschild\editmegatestschildController@show');
Route::post('editmegatestschild/{test_code}','megatestschild\editmegatestschildController@edit');
Route::get('deletemegatestchild/{test_code}','megatestschild\megatestschildController@delete');
Route::get('normalsmegatestchild/{test_id}','megatestschild\NormalRangesMegaTestsChildController@index');
Route::get('megatestchilddata/{test_id}','megatestschild\MegaTestsChildController@TestData');


// Price Lists Routes
Route::get('pricelists', function () {
    return view('pricelists\pricelists');
});

Route::get('pricelists','pricelists\pricelistsController@index');
Route::get('trashedpricelists','pricelists\pricelistsController@trashedindex');

Route::get('newpricelists','pricelists\pricelistsController@insert');
Route::post('newpricelistscreate','pricelists\pricelistsController@create');

Route::get('editpricelists','pricelists\pricelistsController@index');
Route::get('editpricelists/{pricelist_id}','pricelists\pricelistsController@show');
Route::post('editpricelists/{pricelist_id}','pricelists\pricelistsController@edit');
Route::get('deletepricelists/{pricelist_id}','pricelists\pricelistsController@delete');
Route::get('restorepricelists/{pricelist_id}','pricelists\pricelistsController@restore');


// Price Lists Tests Routes
Route::get('priceliststests', function () {
    return view('priceliststests\priceliststests');
});

Route::get('priceliststests/{pricelist_id}','priceliststests\priceliststestsController@index');
Route::get('newpriceliststests','priceliststests\priceliststestsController@insert');
Route::post('newpriceliststestscreate','priceliststests\priceliststestsController@create');

Route::get('editpriceliststests','priceliststets\priceliststestsController@index');
Route::get('editpriceliststests/{testprice_id}','priceliststests\priceliststestsController@show');
Route::post('editpriceliststests/{testprice_id}','priceliststests\priceliststestsController@edit');
Route::post('editpricelisttests/{pricelist_id}','priceliststests\priceliststestsController@update');
Route::get('newpricelisttests/{pricelist_id}','priceliststests\priceliststestsController@newPriceListTests');
Route::get('printpricelist/{pricelist_id}','priceliststests\priceliststestsController@showPrint');
Route::post('updatepricelist/{pricelist_id}','priceliststests\priceliststestsController@UpdatePrices');



// Normal Ranges Routes
Route::get('normalranges', function () {
    return view('normalranges\normalranges');
});

Route::get('normalranges/{test_id}','normalranges\viewnormalrangesController@index');
//Route::get('normalranges/{normal_id}','normalranges\viewnormalrangesController@index');
Route::get('newnormalranges','normalranges\normalrangesController@insert');
Route::post('newnormalrangescreate','normalranges\normalrangesController@create');

Route::get('editnormalranges','normalranges\editnormalrangesController@index');
Route::get('editnormalranges/{normal_id}','normalranges\editnormalrangesController@show');
Route::get('deletenormal/{normal_id}','normalranges\normalrangesController@delete');
// Route::post('editnormalranges/{normal_id}','normalranges\editnormalrangesController@edit');
Route::post('editnormalranges/{test_id}','normalranges\editnormalrangesController@edit');
Route::get('newtestnormalranges/{test_id}','normalranges\newnormalrangesController@create');


// Invoice Routes
Route::get('invoice','invoice\invoiceController@invoice');
Route::post('invoicedata','invoice\invoiceController@data');
Route::get('teststatistics','invoice\teststatisticsController@test');



// Result Tracking Routes
Route::get('resulttracking/{result_id}','resulttracking\resulttrackingController@index');

// Reg Tracking Routes
Route::get('regtracking','regtracking\regtrackingController@index');
Route::post('regtracking','regtracking\regtrackingController@PatientRegTrack');


// Test Parameters Routes
Route::get('testparameters/{test_id}/{result_id}','testparameters\testparametersController@index');
Route::get('testparameters_testdata/{test_id}','testparameters\testparametersController@testparameters');
Route::get('newtestparameter/{test_id}','testparameters\testparametersController@newtestparameter');
Route::get('deletetestparameter/{parameter_id}','testparameters\testparametersController@delete');
Route::get('edittestparameter/{parameter_id}','testparameters\testparametersController@show');
Route::post('edittestparameter/{parameter_id}','testparameters\testparametersController@edit');
Route::post('updateresulttestparameter/{result_id}','testparameters\testparametersController@updateResult');

// Transactions and payment Routes
Route::get('transactions/{regkey}','transactions\transactionsController@index');
Route::get('newtransaction/{regkey}','transactions\transactionsController@create');
Route::post('edittransactions/{regkey}','transactions\transactionsController@edit');


// Antibiotic Entry Routes
Route::get('antibioticentry/{regkey}/{culture_link}','antibioticentry\antibioticentryController@index');
Route::post('newantibioticentry/{regkey}/{culture_link}','antibioticentry\antibioticentryController@create');
Route::post('editantibioticentry/{regkey}/{culturelink}','antibioticentry\antibioticentryController@edit');
Route::post('submitantibioticentry/{regkey}/{culturelink}','antibioticentry\antibioticentryController@newAntibiotic');
Route::get('deleteantibioticentry/{antibioticentry_id}','antibioticentry\antibioticentryController@delete');

// Delete Patient Routes
Route::get('deletepatientsearch','deletepatient\deletepatientController@index');
Route::post('resultsmenu','testentry\searchresultbydayController@SearchResultsByDay');

Route::get('change-language/{language}',function($language){
    Session::put('locale',$language);
    return redirect()->back()->withInput();
});
    // Profiles Routes
Route::get('profiles','profiles\profilesController@index');
Route::get('newprofile','profiles\profilesController@insert');
Route::post('newprofilecreate','profiles\profilesController@create');

Route::get('editprofile','profiles\profilesController@index');
Route::get('editprofile/{profile_id}','profiles\profilesController@show');
Route::post('editprofile/{profile_id}','profiles\profilesController@edit');

// Profiles Tests Routes
Route::get('profiletests/{profile_id}','profilestests\profilestestsController@index');
Route::get('newprofiletest/{profile_id}','profilestests\profilestestsController@insert');
Route::post('newprofiletestcreate/{profile_id}','profilestests\profilestestsController@create');

Route::get('editprofiletest','profilestests\profilestestsController@index');
Route::get('editprofiletest/{profiletest_id}','profilestests\profilestestsController@show');
Route::post('editprofiletest/{profiletest_id}','profilestests\profilestestsController@edit');
Route::get('newprofiletestcreate','profilestests\profilestestsController@create');
Route::get('newprofileprofiletest/{profile_id}','profilestests\profilestestsController@new');
Route::get('deleteprofiletest/{profiletest_id}','profilestests\profilestestsController@delete');


// Rank Price Lists Routes
Route::get('rankpricelists','rankpricelists\rankpricelistsController@index');
Route::get('newrankpricelist','rankpricelists\rankpricelistsController@insert');
Route::post('newrankpricelistcreate','rankpricelists\rankpricelistsController@create');
Route::get('trashedrankpricelists','rankpricelists\rankpricelistsController@trashedindex');


Route::get('editrankpricelist','rankpricelists\rankpricelistsController@index');
Route::get('editrankpricelist/{rank_pricelist_id}','rankpricelists\rankpricelistsController@show');
Route::post('editrankpricelist/{rank_pricelist_id}','rankpricelists\rankpricelistsController@edit');
Route::get('deleterankpricelist/{rank_pricelist_id}','rankpricelists\rankpricelistsController@delete');
Route::get('restorerankpricelist/{rank_pricelist_id}','rankpricelists\rankpricelistsController@restore');


// Relative Price Lists Routes
Route::get('relativepricelists/{relativepricelist_id}','relativepricelists\relativepricelistsController@index');
Route::get('newrelativepricelist/{rank_pricelist_id}','relativepricelists\relativepricelistsController@insert');
Route::post('newrelativepricelistcreate/{rank_pricelist_id}','relativepricelists\relativepricelistsController@create');

Route::get('editrelativepricelist','relativepricelists\relativepricelistsController@index');
Route::get('editrelativepricelist/{relativepricelist_id}','relativepricelists\relativepricelistsController@show');
Route::post('editrelativepricelist/{relativepricelist_id}','relativepricelists\relativepricelistsController@edit');
Route::get('newrelativepricelist','relativepricelists\relativepricelistsController@insertnew');
Route::get('newrelativepricelistcreate','relativepricelists\relativepricelistsController@createnew');
Route::get('deleterelativepricelist/{relativepricelist_id}','relativepricelists\relativepricelistsController@delete');


// Test Reg Routes
Route::get('testreg/{regkey}','testreg\testregController@index');
Route::get('testnotreg/{regkey}','testreg\testregController@show');
Route::post('newtestpatientreg/{regkey}','patientreg\NewTestPatientRegController@create');
Route::post('updatetestreg/{regkey}','testreg\testregController@updateReg');

Route::get('trashedregtests/{regkey}','testreg\testregController@trashedindex');
Route::get('deletepatienttest/{testreg_id}','testreg\testregController@delete');
Route::get('restorepatienttest/{testreg_id}','testreg\testregController@restore');


// Group Tests Routes
Route::get('grouptests', function () {
    return view('grouptests\grouptests');
});

Route::get('grouptests','grouptests\grouptestsController@index');
Route::get('newgrouptests','grouptests\grouptestsController@insert');
Route::post('newgrouptestscreate','grouptests\grouptestsController@create');

Route::get('editgrouptests','grouptests\grouptestsController@index');
Route::get('editgrouptests/{grouptest_id}','grouptests\grouptestsController@show');
Route::post('editgrouptests/{grouptest_id}','grouptests\grouptestsController@edit');

// Group Tests Child Routes
Route::get('grouptestschild', function () {
    return view('grouptestschild\grouptestschild');
});

Route::get('grouptestschild/{grouptest_id}','grouptestschild\grouptestschildController@index');
Route::get('newgrouptestschild/{grouptest_id}','grouptestschild\grouptestschildController@insert');
Route::post('newgrouptestschildcreate/{grouptest_id}','grouptestschild\grouptestschildController@create');
Route::post('editgrouptestchilds/{grouptest_id}','grouptestschild\grouptestschildController@edit');

Route::get('editgrouptestschild','grouptestschild\grouptestschildController@indexEdit');
Route::get('editgrouptestchild/{grouptest_code}','grouptestschild\grouptestschildController@show');
Route::post('editgrouptestchild/{grouptest_code}','grouptestschild\grouptestschildController@edit');
Route::get('deletegrouptestchild/{grouptest_code}','grouptestschild\grouptestschildController@delete');
Route::get('normalsgrouptestchild/{test_id}','grouptestschild\grouptestschildController@indexNormal');
Route::get('grouptestchilddata/{test_id}','grouptestschild\grouptestschildController@TestData');




