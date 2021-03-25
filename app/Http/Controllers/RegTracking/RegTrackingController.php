<?php

namespace App\Http\Controllers\RegTracking;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\TestRegModel;
use App\PatientRegModel;
use App\RegTrackingModel;
use DB;


class RegTrackingController extends Controller
{
   
	public function index(){
	
		return view('regtracking/regtrackingsearch');
		}  


	public function PatientRegTrack(Request $request){
	 	$data = $request->input();
		$patient_regkey = PatientRegModel::query()->withTrashed()->where('visit_no',$data['visit_no'])->first();
		// dd($patient_regkey);
		$users = RegTrackingModel::query()
		->with('PatientReg','Users')
		->where('regkey',$patient_regkey->regkey)
		->get()->sortBy('mod_date',SORT_REGULAR,true);
		// dd($users);

		$testsreg = TestRegModel::query()->withTrashed()->with('TestData','MegaTests','GroupTests','Users')->where('regkey',$patient_regkey->regkey)->get()->sortBy('registered',SORT_REGULAR,true);
	
		return view('regtracking/regtracking',['users'=>$users],['testsreg' =>$testsreg]);
		}  

		
}