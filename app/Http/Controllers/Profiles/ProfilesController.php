<?php

namespace App\Http\Controllers\Profiles;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\ProfilesModel;
use App\ProfilesTestsModel;
use App\MegaTestsModel;
use App\TestDataModel;
use App\GroupTestsModel;
use DB;


class ProfilesController extends Controller
{
    public function index(){
		$users      = ProfilesModel::get();
		$MegaTests  = MegaTestsModel::where('active',true)->get();
		$GroupTests = MegaTestsModel::where('active',true)->get();
		$TestData   = TestDataModel::where('active',true)->get();

		return view('profiles\profiles',['Megatests'=>$MegaTests , 'TestData'=>$TestData , 'GroupTests' => $GroupTests],['users'=>$users]);
		}  


    public function insert(){
    
		$users      = ProfilesModel::get();
		$MegaTests  = MegaTestsModel::orderBy('test_name')->where('active',true)->get();
		$GroupTests = GroupTestsModel::orderBy('test_name')->where('active',true)->get();
		$TestData   = TestDataModel::orderBy('abbrev')->where('active',true)->get();

		return view('profiles\newprofile',['MegaTests'=>$MegaTests , 'TestData'=>$TestData , 'GroupTests' => $GroupTests],['users'=>$users]);
		}  
    
    public function create(Request $request){
		//dd($request->all());
        $rules = [
			'profile_name'   => 'required|string|min:2|max:255',
			'megatest_id'    => 'required_without:test_id,grouptest_id',
			'test_id'        => 'required_without:megatest_id,grouptest_id',
			'grouptest_id'   => 'required_without:megatest_id,test_id',

		];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('newprofile')->with('status',"Insert failed");
		}
		else{
            $data = $request->input();
			try{
				$user = new ProfilesModel();
                $user->profile_name = $data['profile_name'];
				$user->active       = isset($data['active']) ? $data['active'] : false;
				$user->save();

				
				$test_check      = $request->has('test_id');
				$megatest_check  = $request->has('megatest_id');
				$grouptest_check = $request->has('grouptest_id');

				// dd($megatest_check);
				$test_check     = $request->has('test_id');
				$megatest_check = $request->has('megatest_id');

			if ($megatest_check){
			foreach($request->megatest_id as $megaid){
				$ProfilesTests  = new ProfilesTestsModel();
				$ProfilesTests->profile_id       = $user->id;
				$ProfilesTests->megatest_id      = $megaid;
				$ProfilesTests->test_id          = null;
				$ProfilesTests->save();
			}}
			if ($grouptest_check){
				foreach($request->grouptest_id as $groupid){
					$ProfilesTests  = new ProfilesTestsModel();
					$ProfilesTests->profile_id       = $user->id;
					$ProfilesTests->grouptest_id     = $groupid;
					$ProfilesTests->test_id          = null;
					$ProfilesTests->save();
				}}
			if ($test_check){
				foreach($request->test_id as $testid){
				$ProfilesTests  = new ProfilesTestsModel();
				$ProfilesTests->profile_id       = $user->id;
				$ProfilesTests->megatest_id      = null;
				$ProfilesTests->test_id          = $testid;
				$ProfilesTests->save();
				}}
				return redirect('profiles')->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('newprofile')->with('failed',"Insert failed");
			}
		}
	}
	
	public function new(){
		//dd($request->all());
		// dd($test_id);
			    $user = new ProfilesModel();
				$user->profile_name     = null; 
				$user->active           = null;
               
				$user->save();
				return redirect()->back();
			}

				public function show($profile_id) {
					$users = ProfilesModel::where('profile_id',$profile_id)->get();
					return view('profiles\editprofile',['users'=>$users]);
				}
				public function edit(Request $request,$profile_id) {
				$profile_name  = $request->input('group_name');
				$active        = isset($request['active']) ? $request['active'] : false;
				
				$users = ProfilesModel::where('profile_id',$profile_id)->update([
					'profile_name'  =>  $profile_name,
					'active'        =>  $active
				]);
		
				return redirect('profiles')->with('status',"Updated Successfully");
				
				}
}