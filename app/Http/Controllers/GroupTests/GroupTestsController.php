<?php

namespace App\Http\Controllers\GroupTests;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\GroupTestsModel;
use App\PriceListsModel;
use App\PriceListsTestsModel;
use App\TestDataModel;
use App\GroupTestsChildModel;
use App\OutLabsModel;
use DB;

class GroupTestsController extends Controller
{
	public function index(){
		
		$users =  GroupTestsModel::orderBy('test_name')->get();
		$TestData = TestDataModel::orderBy('abbrev')->get();
		// dd($users);
		return view('grouptests\grouptests',['users'=>$users]);
		}  

    
    public function insert(){
		$TestData = TestDataModel::orderBy('abbrev')->get();
		$OutLabs  = OutLabsModel::get();

        return view('grouptests\Newgrouptests',compact(['TestData','OutLabs']));
    }
    public function create(Request $request){
		//dd($request->all());
        $rules = [
			'test_name' => 'required|string|min:3|max:255',
			'test_id'   => 'required',

		];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('newgrouptests')->with('status',"Insert failed");
		}
		else{
            $data = $request->input();
			try{
				$user = new GroupTestsModel();
				$user->test_name   = $data['test_name'];
				$user->active      = isset($data['active']) ? $data['active'] : false;
				$user->outlab      = isset($data['outlab']) ? $data['outlab'] : false;
				$user->outlab_id   = $data['outlab_id'];

				$user->save();
				
				$PriceLists       = PriceListsModel::get();
				$GroupTests       = GroupTestsModel::get();
				$GroupTestsChild  = GroupTestsChildModel::get();

				foreach($PriceLists as $pricelist){
					// dd($MegaTests);
					$PriceListsTests = new PriceListsTestsModel();
				 	$PriceListsTests->pricelist_id    = $pricelist->pricelist_id;
					$PriceListsTests->grouptest_id    = $user->id;
					$PriceListsTests->price           = NULL;
					$PriceListsTests->save();
					 
				 }

				 foreach($request->test_id as $id){
					// dd($MegaTests);
					$GroupTestsChild = new GroupTestsChildModel();
				 	$GroupTestsChild->grouptest_id    = $user->id;
					$GroupTestsChild->test_id         = $id;
					$GroupTestsChild->active          = '1';
					$GroupTestsChild->save();
					 
				 }
			
				
				return redirect('grouptests')->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('newgrouptests')->with('failed',"operation failed");
			}
		}
	
    }
	
		public function show($grouptest_id) {
			$OutLabs  = OutLabsModel::get();
			$users = GroupTestsModel::where('grouptest_id',$grouptest_id)->get();
			return view('grouptests\editgrouptests',['users'=>$users , 'OutLabs' => $OutLabs]);
		}
		public function edit(Request $request,$grouptest_id) {
		//$title = $request->input('title');
		        $test_name    = $request->input('test_name');
				$active       = isset($request['active']) ? $request['active'] : false;
				$outlab       = isset($request['outlab']) ? $request['outlab'] : false;
				// dd($request->active);
				$outlab_id    = $request->input('outlab_id');

				$users = GroupTestsModel::where('grouptest_id',$grouptest_id)->update([
						'test_name'  =>   $test_name,
						'active'     =>   $active,
						'outlab'     =>   $outlab,
						'outlab_id'  =>   $outlab_id,

				]);

		return redirect('grouptests')->with('status',"Updated Successfully");
		
		}
}