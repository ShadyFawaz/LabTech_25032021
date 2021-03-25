<?php

namespace App\Http\Controllers\MegaTestsChild;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\MegaTestsChildModel;
use App\MegaTestsModel;
use App\TestDataModel;
use DB;

class MegaTestsChildController extends Controller
{
    
    public function insert($megatest_id){
		$megaTests  = MegaTestsModel::get();
		$TestData   = TestDataModel::get();
		$childs     = MegaTestsChildModel::with(['megaTests','TestData'])->where('megatest_id',$megatest_id)->pluck('test_id');
		$TestData   = TestDataModel::whereNotIn('test_id',$childs)->get();
		// dd($TestData);
		$test_name  = MegaTestsModel::where('megatest_id',$megatest_id)->first()->test_name;
        return view('megatestschild\Newmegatestschild',['TestData'=>$TestData],compact('megaTests','TestData','megatest_id','test_name'));
		}  
        //return view('megatestschild\Newmegatestschild');
    
		public function create(Request $request ,$megatest_id){
			// dd($request->all());
			$rules = [
				'megatest_id' => 'integer|min:1',
			];
			
			$validator = Validator::make($request->all(),$rules);
			if ($validator->fails()) {
				//return redirect('insert')
				//->withInput()
				//->withErrors($validator);
				return redirect('newmegatestschild/'.$megatest_id)->with('status',"Insert failed");
			}
			else{
			$data = $request->except('seperatecheck');		
// dd($data);
			try{
				foreach($request->test_id as $id){
					$MegaTestsChilds  = new MegaTestsChildModel();
					$MegaTestsChilds->megatest_id      = $megatest_id;
					$MegaTestsChilds->test_id          = $id;
					$MegaTestsChilds->active           = true;
					$MegaTestsChilds->save();
				}

				return redirect('megatestschild/'.$megatest_id)->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('newmegatestschild/'.$megatest_id)->with('status',"Insert failed");
			}
		}
	}
	
	public function delete(Request $request,$test_code){
        
		DB::table('mega_tests_child')->where('test_code', $test_code)->delete();
		return redirect()->back();
		}

		public function TestData($test_id){
			$MegaTestsChild    = MegaTestsChildModel::get();
			$users             = TestDataModel::where('test_id',$test_id)->get();
			// dd($users->toArray());
			return view('testdata\testdata',['users'=>$users],compact('MegaTestsChild'));
			} 
}