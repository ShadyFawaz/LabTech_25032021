<?php

namespace App\Http\Controllers\OutLabTests;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\OutLabTestsModel;
use App\OutLabsModel;
use App\MegaTestsModel;
use App\TestDataModel;
use App\GroupTestsModel;
use DB;


class OutLabTestsController extends Controller
{
	
	public function index($outlab_id){
		$OutLabs     = OutLabsModel::get();
		$MegaTests   = MegaTestsModel::get();
		$GroupTests  = GroupTestsModel::get();
		$users       = OutLabTestsModel::with(['OutLabs','MegaTests','TestData','GroupTests'])->where('outlab_id',$outlab_id)->get();
		$out_lab = $users[0]->OutLabs->out_lab;

		//dd($users->toArray());
		return view('outlabtests\outlabtests',['users'=>$users],compact('OutLabs','outlab_id','out_lab'));
		}  

		public function show($outlab_id) {
			$OutLabs     = OutLabsModel::get();
			$MegaTests   = MegaTestsModel::where('active',true)->get();
			$TestData    = TestDataModel::where('active',true)->get();
			$GroupTests  = GroupTestsModel::where('active',true)->get();
			$users       = OutLabsModel::with(['OutLabs','MegaTests','TestData','GroupTests'])->where('outlab_id',$outlab_id)->get();
			$out_lab = $users[0]->OutLabs->out_lab;

			return view('outlabtests/editoutlabtests',['users'=>$users],compact('Outlabs','MegaTests','TestData','GroupTests','outlab_id','out_lab'));
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
   
	
	public function new(Request $request,$outlab_id){
		//dd($request->all());
		$megatest_id = $request->megatest_id;
		// dd($megatest_id);
			    $user = new ProfilesTestsModel();
				$user->profile_id         = $profile_id;
				$user->megatest_id        = $megatest_id; 
				$user->save();
				return redirect()->back();
			}

		public function insert($outlab_id){
			$OutLabs           = OutLabsModel::get();
			$MegaProfileTests  = OutLabTestsModel::where('outlab_id',$outlab_id)->whereNull('test_id')->whereNull('grouptest_id')->get()->pluck('megatest_id');
			$GroupProfileTests = OutLabTestsModel::where('outlab_id',$outlab_id)->whereNull('megatest_id')->whereNull('test_id')->get()->pluck('grouptest_id');
			$ProfileTests      = OutLabTestsModel::where('outlab_id',$outlab_id)->whereNull('megatest_id')->whereNull('grouptest_id')->get()->pluck('test_id');
			// $MegaProfileTests = $megatest->pluck('megatest_id');
			// $ProfileTests     = $megatest->pluck('test_id');

			// dd($ProfileTests);

			$MegaTests   = MegaTestsModel::whereNotIn('megatest_id',$MegaProfileTests)->where('active',true)->orderBy('test_name')->get();
			$GroupTests  = GroupTestsModel::whereNotIn('grouptest_id',$GroupProfileTests)->where('active',true)->orderBy('test_name')->get();
			$TestData    = TestDataModel::whereNotIn('test_id',$ProfileTests)->where('active',true)->orderBy('abbrev')->get();
// dd($MegaTests);
			$users       = OutLabTestsModel::with(['OutLabs','MegaTests','TestData','GroupTests'])->where('outlab_id',$outlab_id)->get();
			$out_lab     = OutLabsModel::where('outlab_id',$outlab_id)->first()->out_lab;

			// dd($profileid);
			return view('outlabtests/newoutlabtest',['users'=>$users],compact('OutLabs','MegaTests','TestData','GroupTests','outlab_id','out_lab'));
			}  
		
				public function create(Request $request , $outlab_id){
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
						$OutLabTests  = new OutLabTestsModel();
						$OutLabTests->outlab_id        = $outlab_id;
						$OutLabTests->megatest_id      = $megaid;
						$OutLabTests->save();
					}}
					if ($grouptest_check){
						foreach($request->grouptest_id as $groupid){
							$OutLabTests  = new OutLabTestsModel();
							$OutLabTests->outlab_id        = $outlab_id;
							$OutLabTests->grouptest_id     = $groupid;
							$OutLabTests->save();
						}}
					if ($test_check){
						foreach($request->test_id as $testid){
							$OutLabTests  = new OutLabTestsModel();
							$OutLabTests->outlab_id        = $outlab_id;
							$OutLabTests->test_id          = $testid;
							$OutLabTests->save();
						}}
						return redirect('outlabtests/'.$outlab_id)->with('status',"Insert successfully");
					}

					catch(Exception $e){
						return redirect()->back()->with('failed',"operation failed");
					}
				}
			}
			
			public function delete(Request $request,$testprice_id){
				
			OutLabTestsModel::where('testprice_id',$testprice_id)->delete();
				return redirect()->back();
			
		}

		public function UpdatePrices(Request $request,$outlab_id) {

			$price           = $request->input('price');
			// $priceupdate     = $request->input('update_percent');
			$OutLabTests     = OutlabTestsModel::query();
			$Prices          = $request->except('_token','_method');
			$PricesCount     = count($request->only('price')); 

DB::beginTransaction();
		// dd($Prices);
		foreach ($Prices['price'] as $i=> $pric) {
			// $TestEntry = TestEntryModel::query()->where('result_id',$i)->first();
// dd($i);
			$price     = $Prices['price'][$i];
			$duration  = $Prices['duration'][$i];

			$OutLabTests = OutLabTestsModel::query()->where('testprice_id',$i)->update(
				[
					'price'      =>$price,	
					'duration'   =>$duration	

			]	
			);					
		}

	DB::commit();
	return redirect()->back();

}

}