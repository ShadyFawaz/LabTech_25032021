<?php

namespace App\Http\Controllers\TestEntry;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\TestRegModel;
use App\PatientRegModel;
use App\MegaTestsModel;
use App\TestDataModel;
use App\SubGroupsModel;
use App\TestEntryModel;
use App\ResultTrackingModel;
use App\NewUserModel;
use App\GroupsModel;
use Spatie\Permission\Models\Permission;
use DB;


class PatientHistoryController extends Controller
{
    
	public function PatientHistoryMega($regkey, $group , $megatest_id , $seperate_test){
	
		$ResultEntryQuery        = TestEntryModel::query()->with('PatientReg','PatientReg.TestReg','TestData','TestData.Groups','MegaTests');
		$PatientHistoryQuery     = TestEntryModel::query()->with('PatientReg','PatientReg.TestReg','TestData','TestData.Groups','MegaTests');
		$PatientHistoryDateQuery = TestEntryModel::query()->with('PatientReg','PatientReg.TestReg','TestData','TestData.Groups','MegaTests');

		$PatientIDGet = TestEntryModel::query()->with('PatientReg','PatientReg.TestReg','TestData','TestData.Groups','MegaTests')->where('regkey',$regkey)->first();
		$PatientID    = $PatientIDGet->PatientReg->patient_id;

		// dd($PatientID);
		$PatientHistory = $PatientHistoryQuery->whereHas('PatientReg',function($qurey) use($PatientID){
		$qurey->where('patient_id',$PatientID);
		})->where('megatest_id',$megatest_id)->where('seperate_test',$seperate_test)->get()->sortBy('TestData.test_order',SORT_REGULAR,false)->groupBy('test_id');
	// dd($PatientHistory);
		
		$PatientHistoryDate = $PatientHistoryDateQuery->whereHas('PatientReg',function($qurey) use($PatientID){
		$qurey->where('patient_id',$PatientID);
		})->where('megatest_id',$megatest_id)->where('seperate_test',$seperate_test)->get()->sortBy('PatientReg.req_date',SORT_REGULAR,true)->groupBy('PatientReg.req_date');

	// dd($PatientHistoryDate);
	
		return view('testentry/patienthistory',[ 'PatientIDGet' => $PatientIDGet  , 'PatientHistory' => $PatientHistory , 'PatientHistoryDate' => $PatientHistoryDate]);
		}

	public function PatientHistoryGroup($regkey, $group , $seperate_test){

		$ResultEntryQuery        = TestEntryModel::query()->with('PatientReg','PatientReg.TestReg','TestData','TestData.Groups','MegaTests');
		$PatientHistoryQuery     = TestEntryModel::query()->with('PatientReg','PatientReg.TestReg','TestData','TestData.Groups','MegaTests');
		$PatientHistoryDateQuery = TestEntryModel::query()->with('PatientReg','PatientReg.TestReg','TestData','TestData.Groups','MegaTests');

		$PatientIDGet = TestEntryModel::query()->with('PatientReg','PatientReg.TestReg','TestData','TestData.Groups','MegaTests')->where('regkey',$regkey)->first();
		$PatientID    = $PatientIDGet->PatientReg->patient_id;

		// dd($PatientID);

		$PatientHistory = $PatientHistoryQuery->whereHas('TestData',function($qurey) use($group){
			$qurey->where('test_group',$group);
			})->whereHas('PatientReg',function($qurey) use($PatientID){
		$qurey->where('patient_id',$PatientID);
		})->groupBy('test_id')->where('seperate_test',$seperate_test)->get()->sortBy('PatientReg.req_date',SORT_REGULAR,true)->sortBy('TestData.test_order',SORT_REGULAR,false);
	// dd($PatientHistory);


		$PatientHistoryDate = $PatientHistoryDateQuery->whereHas('TestData',function($qurey) use($group){
			$qurey->where('test_group',$group);
			})->whereHas('PatientReg',function($qurey) use($PatientID){
		$qurey->where('patient_id',$PatientID);
		})->where('seperate_test',$seperate_test)->get()->sortBy('PatientReg.req_date',SORT_REGULAR,true)->groupBy('PatientReg.req_date');

	// dd($PatientHistoryDate);

	
		return view('testentry/patienthistory',['users'=>$users , 'PatientHistory' => $PatientHistory , 'PatientHistoryDate' => $PatientHistoryDate]);
		}
}