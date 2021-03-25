<?php

namespace App\Http\Controllers\ProfilesTests;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\ProfilesTestsModel;
use App\profilesModel;
use App\MegaTestsModel;
use App\TestDataModel;
use App\GroupTestsModel;
use DB;


class ProfilesTestsController extends Controller
{
	
	public function index($profile_id){
		$Profiles    = ProfilesModel::get();
		$MegaTests   = MegaTestsModel::get();
		$GroupTests  = GroupTestsModel::get();
		$users       = ProfilesTestsModel::with(['Profiles','MegaTests','TestData','GroupTests'])->where('profile_id',$profile_id)->get();
		//dd($users->toArray());
		return view('profilestests\profiletests',['users'=>$users],compact('Profiles','MegaTests','profile_id'));
		}  

		public function show($profiletest_id) {
			$Profiles    = ProfilesModel::get();
			$MegaTests   = MegaTestsModel::where('active',true)->get();
			$TestData    = TestDataModel::where('active',true)->get();
			$GroupTests  = GroupTestsModel::where('active',true)->get();

			$users       = ProfilesTestsModel::with(['Profiles','MegaTests','TestData','GroupTests'])->where('profiletest_id',$profiletest_id)->get();
		   return view('profilestests/editprofiletests',['users'=>$users],compact('Profiles','MegaTests','TestData','GroupTests'));
		   }

		   public function edit(Request $request,$profiletest_id) {				   
				   $megatest_id    = $request->input('megatest_id');
				   $test_id        = $request->input('test_id');

				   $users = ProfilesTestsModel::where('profiletest_id',$profiletest_id)->update([
					   'megatest_id'  =>  $megatest_id,
					   'test_id'      =>  $test_id

				   ]);

		   return redirect('profiles')->with('status',"Updated Successfully");
		   
		   }
   
	
	public function new(Request $request,$profile_id){
		//dd($request->all());
		$megatest_id = $request->megatest_id;
		// dd($megatest_id);
			    $user = new ProfilesTestsModel();
				$user->profile_id         = $profile_id;
				$user->megatest_id        = $megatest_id; 
				$user->save();
				return redirect()->back();
			}

			
		public function insert($profile_id){
			$Profiles          = ProfilesModel::get();
			$MegaProfileTests  = ProfilesTestsModel::where('profile_id',$profile_id)->whereNull('test_id')->whereNull('grouptest_id')->get()->pluck('megatest_id');
			$GroupProfileTests = ProfilesTestsModel::where('profile_id',$profile_id)->whereNull('megatest_id')->whereNull('test_id')->get()->pluck('grouptest_id');
			$ProfileTests      = ProfilesTestsModel::where('profile_id',$profile_id)->whereNull('megatest_id')->whereNull('grouptest_id')->get()->pluck('test_id');
			// $MegaProfileTests = $megatest->pluck('megatest_id');
			// $ProfileTests     = $megatest->pluck('test_id');

			// dd($ProfileTests);

			$MegaTests   = MegaTestsModel::whereNotIn('megatest_id',$MegaProfileTests)->where('active',true)->orderBy('test_name')->get();
			$GroupTests  = GroupTestsModel::whereNotIn('grouptest_id',$GroupProfileTests)->where('active',true)->orderBy('test_name')->get();
			$TestData    = TestDataModel::whereNotIn('test_id',$ProfileTests)->where('active',true)->orderBy('abbrev')->get();
// dd($MegaTests);
			$users        = ProfilesTestsModel::with(['Profiles','MegaTests','TestData','GroupTests'])->where('profile_id',$profile_id)->get();
			$profile_name = ProfilesModel::where('profile_id',$profile_id)->first()->profile_name;
			// dd($profileid);
			return view('profilestests/newprofiletest',['users'=>$users],compact('Profiles','MegaTests','TestData','GroupTests','profile_id','profile_name'));
			}  
		
				public function create(Request $request , $profile_id){
					// dd($request->all());
					$rules = [
				];
					
					$validator = Validator::make($request->all(),$rules);
					if ($validator->fails()) {
						
				return redirect()->back()->with('status',"Insert failed");
					}
					else{
					$data = $request->input();
					try{
				$test_check      = $request->has('test_id');
				$megatest_check  = $request->has('megatest_id');
				$grouptest_check = $request->has('grouptest_id');

	
				if ($megatest_check){
					foreach($request->megatest_id as $megaid){
						$ProfilesTests  = new ProfilesTestsModel();
						$ProfilesTests->profile_id       = $profile_id;
						$ProfilesTests->megatest_id      = $megaid;
						$ProfilesTests->test_id          = null;
						$ProfilesTests->save();
					}}
					if ($grouptest_check){
						foreach($request->grouptest_id as $groupid){
							$ProfilesTests  = new ProfilesTestsModel();
							$ProfilesTests->profile_id       = $profile_id;
							$ProfilesTests->grouptest_id     = $groupid;
							$ProfilesTests->test_id          = null;
							$ProfilesTests->save();
						}}
					if ($test_check){
						foreach($request->test_id as $testid){
						$ProfilesTests  = new ProfilesTestsModel();
						$ProfilesTests->profile_id       = $profile_id;
						$ProfilesTests->megatest_id      = null;
						$ProfilesTests->test_id          = $testid;
						$ProfilesTests->save();
						}}
						return redirect('profiletests/'.$profile_id)->with('status',"Insert successfully");
					}

					catch(Exception $e){
						return redirect()->back()->with('failed',"operation failed");
					}
				}
			}
			
			public function delete(Request $request,$profiletest_id){
				
				$ProfielsTests = ProfilesTestsModel::where('profiletest_id',$profiletest_id)->delete();
				return redirect()->back();
				}
}