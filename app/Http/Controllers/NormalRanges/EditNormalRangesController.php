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
use Carbon\Carbon;
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
		// public function edit(Request $request,$normal_id) {
		// 	// dd($request->all(),$normal_id);
		// //$title = $request->input('title');
		// 		$low                 = $request->input('low');
		// 		$high                = $request->input('high');
		// 		$nn_normal           = $request->input('nn_normal');
		// 		$age_from            = $request->input('age_from');
		// 		$age_to              = $request->input('age_to');
		// 		$gender              = $request->input('gender');
		// 		$age                 = $request->input('age');
		// 		$patient_condition   = $request->input('patient_condition');
		// 		$active              = $request->input('active');
				
		// DB::update('update normal_ranges set low=?,high=?,nn_normal=?,age_from=?,age_to=?,gender=?,age=?,patient_condition=?,active=? where normal_id = ?',[$low,$high,$nn_normal,$age_from,$age_to,$gender,$age,$patient_condition,$active,$normal_id]);
		// return redirect()->back();
		public function edit(Request $request,$test_id) {
			// dd($request->all());
		$NormalRanges = NormalRangesModel::query()->with('TestData');
	
			$Normals       = $request->except('_token','_method');
			$NormalsCount  = count($request->only('low')); 
			
		DB::beginTransaction();
		// dd($Normals);

        foreach ($Normals['low'] as $i=> $normal) {
			$age_total_check = NormalRangesModel::query()->where('normal_id',$i)->first();
			// dd($age_total_check);
			// dd($i);
			$NormalRangesTotalCheck = NormalRangesModel::where('test_id',$test_id)->get();
			// dd($NormalRangesTotalCheck);


			$Low                = $Normals['low'][$i];
			$High               = $Normals['high'][$i];
			$NN_Normal          = $Normals['nn_normal'][$i];
			$Age_From_Y         = $Normals['age_from_y'][$i];
			$Age_From_M         = $Normals['age_from_m'][$i];
			$Age_From_D         = $Normals['age_from_d'][$i];
			$Age_To_Y           = $Normals['age_to_y'][$i];
			$Age_To_M           = $Normals['age_to_m'][$i];
			$Age_To_D           = $Normals['age_to_d'][$i];
			$Gender             = $Normals['gender'][$i];
			$Patient_Condition  = $Normals['patient_condition'][$i];
			$Active             = isset($Normals['active'][$i]) ? $Normals['active'][$i] : false;
			// isset($Normals['active']) ? $Normals['active'] : false;

			// dd($NormalRanges);
          
			$NormalRanges = NormalRangesModel::query()->where('normal_id',$i)->update(
				[
					'low'                  =>$Low,
					'high'                 =>$High,
					'nn_normal'            =>$NN_Normal,
					'age_from_y'           =>$Age_From_Y,
					'age_from_m'           =>$Age_From_M,
					'age_from_d'           =>$Age_From_D,
					'age_to_y'             =>$Age_To_Y,
					'age_to_m'             =>$Age_To_M,
					'age_to_d'             =>$Age_To_D,
					'gender'               =>$Gender,
					'patient_condition'    =>$Patient_Condition,
					'active'               =>$Active,
			]
				
			);
		
        }
    // when done commit
DB::commit();

		

			$NormalRangesTotal = NormalRangesModel::where('test_id',$test_id)->get();
		foreach ($NormalRangesTotal as $normal) {
			$age_from_total  = $normal->age_from_y*365 + $normal->age_from_m*30 + $normal->age_from_d;
			$age_to_total    = $normal->age_to_y*365 + $normal->age_to_m*30 + $normal->age_to_d;
			$NormalRangesUpdate = NormalRangesModel::where('normal_id',$normal->normal_id)->update([
						'age_from_total'=> $age_from_total,
						'age_to_total'  => $age_to_total
				]);

			}

			// dd($NormalRangesTotal);


		return redirect()->back();
		}
}