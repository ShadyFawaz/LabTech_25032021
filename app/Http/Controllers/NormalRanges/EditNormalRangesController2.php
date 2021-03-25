<?php

namespace App\Http\Controllers\NormalRanges;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\NormalRangesModel;
use App\PatientConditionModel;
use DB;

class EditNormalRangesController extends Controller
{
    
    // public function index(){
	// 	$users = DB::select('select * from mega_tests_child');
	// 	return view('megatestschild\viewmegatestschild',['users'=>$users]);
	// 	}
		public function show($normal_id) {
		 $normals             = NormalRangesModel::where('normal_id',$normal_id)->get();
		 $PatientCondition    = PatientConditionModel::get();
		 //$users   = NormalRangesModel::with(['TestData'])->where('test_id',$test_id)->get();
		//dd($users);
		return view('normalranges/editnormalranges',['normals'=>$normals],compact(['PatientCondition']));
		
		}
		public function edit(Request $request,$normal_id) {
			// dd($request->all(),$normal_id);
		//$title = $request->input('title');
				$low                 = $request->input('low');
				$high                = $request->input('high');
				$nn_normal           = $request->input('nn_normal');
				$age_from            = $request->input('age_from');
				$age_to              = $request->input('age_to');
				$gender              = $request->input('gender');
				$age                 = $request->input('age');
				$patient_condition   = $request->input('patient_condition');
				$active              = $request->input('active');
				
		DB::update('update normal_ranges set low=?,high=?,nn_normal=?,age_from=?,age_to=?,gender=?,age=?,patient_condition=?,active=? where normal_id = ?',[$low,$high,$nn_normal,$age_from,$age_to,$gender,$age,$patient_condition,$active,$normal_id]);
		return redirect()->back();
		
		}
}