<?php

namespace App\Http\Controllers\TestParameters;

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
use App\TestParametersModel;
use App\TestEntryModel;
use DB;


class TestParametersController extends Controller
{
    
	public function index($test_id , $result_id){
		$TestData    = TestDataModel::get();
		$users       = TestParametersModel::with(['TestData'])->where('test_id',$test_id)->get();
			//dd($users->toArray());

		// dd($users->all());
		return view('testparameters/testparameters',['users'=>$users],compact('TestData','test_id','result_id'));
		}  

	
		public function testparameters($test_id){
			$TestData          = TestDataModel::get();
			$users             = TestParametersModel::with(['TestData'])->where('test_id',$test_id)->get();
			//dd($users->toArray());
			return view('testparameters/testparameters_testdata',['users'=>$users],compact('TestData','test_id'));
			}  

		public function newTestParameter(Request $request,$test_id){
			//dd($request->all());
			$data = $request->test_id;
			// dd($test_id);
					$user = new TestParametersModel();
					$user->test_id           = $test_id;
					$user->test_parameter    = null; 
					
					$user->save();
					return redirect()->back();
				}
				public function delete(Request $request,$parameter_id){
        
					DB::table('test_parameters')->where('parameter_id', $parameter_id)->delete();
					return redirect()->back();
					}

		public function show($parameter_id) {
			$users = TestparametersModel::where('parameter_id',$parameter_id)->get();
			return view('testparameters\edittestparameter',['users'=>$users]);
			}
		public function edit(Request $request,$parameter_id) {
			$test_parameter = $request->input('test_parameter');
			$users = TestparametersModel::where('parameter_id',$parameter_id)->update([
				'test_parameter'    =>   $test_parameter
			]);

			return redirect()->back();
			
			}

			public function updateResult(Request $request ,$result_id){
				$data = $request->input();
				$ParameterID = TestParametersModel::query()->where('parameter_id',$data['parameter_select'])->first();
				// dd($ParameterID);
				TestEntryModel::query()->where('result_id',$result_id)->update([
					'result' => $ParameterID->test_parameter,
				]);
				return redirect()->back();

				}  

				
}