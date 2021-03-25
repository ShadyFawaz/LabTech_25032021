<?php

namespace App\Http\Controllers\GroupTestsChild;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\GroupTestsChildModel;
use App\GroupTestsModel;
use App\TestDataModel;
use App\PatientConditionModel;
use App\NormalRangesModel;
use DB;

class GroupTestsChildController extends Controller
{
    
    public function insert($grouptest_id){
		$GroupTests  = GroupTestsModel::get();
		$TestData    = TestDataModel::get();
		$childs      = GroupTestsChildModel::with(['GroupTests','TestData'])->where('grouptest_id',$grouptest_id)->pluck('test_id');
		$TestData    = TestDataModel::whereNotIn('test_id',$childs)->get();
		// dd($TestData);
		$test_name   = GroupTestsModel::where('grouptest_id',$grouptest_id)->first()->test_name;
        return view('grouptestschild\Newgrouptestschild',['TestData' => $TestData],compact('GroupTests','TestData','grouptest_id','test_name'));
		}  
        //return view('megatestschild\Newmegatestschild');
    
		public function create(Request $request,$grouptest_id){
			// dd($request->all());
			$rules = [
				'grouptest_id' => 'integer|min:1',
			];
			
			$validator = Validator::make($request->all(),$rules);
			if ($validator->fails()) {
				//return redirect('insert')
				//->withInput()
				//->withErrors($validator);
				return redirect('newgrouptestschild/'.$grouptest_id)->with('status',"Insert failed");
			}
			else{
				$data = $request->except('seperatecheck');		
	// dd($data);
				try{
					foreach($request->test_id as $id){
						$GroupTestChilds  = new GroupTestsChildModel();
						$GroupTestChilds->grouptest_id     = $grouptest_id;
						$GroupTestChilds->test_id          = $id;
						$GroupTestChilds->active           = true;
						$GroupTestChilds->save();
					}
				return redirect('newgrouptestschild/'.$grouptest_id)->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('newgrouptestschild/'.$grouptest_id)->with('failed',"operation failed");
			}
		}
	}
	public function indexNormal($test_id){
		$TestData          = TestDataModel::get();
		$GroupTestsChild   = GroupTestsChildModel::get();
		$PatientCondition  = PatientConditionModel::get();
		$users             = NormalRangesModel::with(['TestData'])->where('test_id',$test_id)->get();
		//dd($users->toArray());
		return view('normalranges\normalranges',['users'=>$users],compact('TestData','PatientCondition','test_id','GroupTestsChild'));
		}  

	public function index($grouptest_id){
		
		$users = GroupTestsChildModel::with(['GroupTests','TestData'])->where('grouptest_id',$grouptest_id)->get();
		$test_name   = GroupTestsModel::where('grouptest_id',$grouptest_id)->first()->test_name;

		//dd($users->toArray());
		return view('grouptestschild\grouptestschild',['users'=>$users],compact('grouptest_id','test_name'));
		}  

		public function edit(Request $request,$grouptest_id) {
			// dd($request->all());
		$GroupTestsChild = GroupTestsChildModel::query()->with('GroupTests','TestData');
	
			$TestChilds    = $request->except('_token','_method');
			$ChildsCount   = count($request->only('test_id')); 
			
		DB::beginTransaction();
		// dd($TestChilds);

        foreach ($TestChilds['test_id'] as $i=> $testchild) {
			// dd($i);
			$Active         = isset($TestChilds['active'][$i]) ? $TestChilds['active'][$i] : false;
			$GroupTestsChild = GroupTestsChildModel::query()->where('grouptest_code',$i)->update(
				[
					'active'    =>$Active,
			]
				
			);
        }
    // when done commit
DB::commit();
		return redirect()->back();
		}
	public function delete(Request $request,$grouptest_code){
        
		GroupTestsChildModel::where('grouptest_code', $grouptest_code)->delete();
		return redirect()->back();
		}

		public function TestData($test_id){
			$GroupTestsChild    = GroupTestsChildModel::get();
			$users              = TestDataModel::where('test_id',$test_id)->get();
			// dd($users->toArray());
			return view('testdata\testdata',['users'=>$users],compact('GroupTestsChild'));
			} 
}