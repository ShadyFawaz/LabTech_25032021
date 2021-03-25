<?php

namespace App\Http\Controllers\ResultTracking;

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
use App\ResultTrackingModel;
use DB;


class ResultTrackingController extends Controller
{
    
	public function index($result_id){
		$PatientReg  = PatientRegModel::get();
		$TestData    = TestDataModel::get();
	 
		$users = ResultTrackingModel::query()->with('PatientReg','Users','TestData','ResultEntry')->where('result_id',$result_id)->get()->sortBy('modify_time',SORT_REGULAR,true);
		// $users = DB::table('Result_tracking')
		// ->join('Patient_Reg', 'Patient_Reg.regkey', '=', 'Result_Tracking.regkey')
		// ->join('Test_Data', 'Test_Data.test_id', '=', 'Result_Tracking.test_id')
		// ->join('Users', 'Users.user_id', '=', 'Result_Tracking.user_id')
		// ->select('Result_Tracking.*','Test_Data.*','Users.user_name')->where('Test_Data.test_id',$test_id)
		// ->get();

		// dd($users->all());
		return view('resulttracking/resulttracking',['users'=>$users]);
		}  

		
}