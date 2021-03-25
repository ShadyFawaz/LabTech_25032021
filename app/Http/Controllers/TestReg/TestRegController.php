<?php

namespace App\Http\Controllers\TestReg;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\TestRegModel;
use App\PatientRegModel;
use App\MegaTestsModel;
use App\TestEntryModel;
use App\TestDataModel;
use App\GroupTestsModel;
use App\OutLabsModel;
use DB;


class TestRegController extends Controller
{
    
	public function index($regkey){
		$OutLabs      = OutLabsModel::query()->get();
		$users        = TestRegModel::with(['PatientReg','TestData','MegaTests','GroupTests','OutLabs'])->where('regkey',$regkey)->get();
		$PatientID    = $users[0]->PatientReg->patient_id;
		$VisitNo      = $users[0]->PatientReg->visit_no;
		$PatientName  = $users[0]->PatientReg->patient_name;
		$ReqDate      = $users[0]->PatientReg->req_date;
		$Gender       = $users[0]->PatientReg->gender;
		$Age_Y        = $users[0]->PatientReg->age_y;
		$Age_M        = $users[0]->PatientReg->age_m;
		$Age_D        = $users[0]->PatientReg->age_d;
		// dd($users->toArray());
		return view('testreg',['users'=>$users],compact('PatientID','VisitNo','PatientName','ReqDate','Gender','Age_Y','Age_M','Age_D','regkey','OutLabs'));
		}  


		public function show($regkey){
			$PatientReg      = PatientRegModel::get();
			$users           = TestRegModel::with(['PatientReg'])->where('regkey',$regkey)->get();
			$TestIDs         = $users->whereNotNull('test_id')->pluck('test_id');
			$MegaTestIDs     = $users->whereNotNull('megatest_id')->pluck('megatest_id');
			$GroupTestIDs    = $users->whereNotNull('grouptest_id')->pluck('grouptest_id');

			$TestNotReg       = TestDataModel::whereNotIn('test_id',$TestIDs)->where('active',true)->orderBy('abbrev')->get();
			$MegaTestNotReg   = MegaTestsModel::whereNotIn('megatest_id',$MegaTestIDs)->where('active',true)->orderBy('test_name')->get();
			$GroupTestNotReg  = GroupTestsModel::whereNotIn('grouptest_id',$GroupTestIDs)->where('active',true)->orderBy('test_name')->get();

			// dd($TestIDs);
			return view('testnotreg',['TestNotReg'=>$TestNotReg,'MegaTestNotReg'=>$MegaTestNotReg , 'GroupTestNotReg'=>$GroupTestNotReg],['users'=>$users]);
			}  

			public function trashedIndex($regkey){
				$OutLabs      = OutLabsModel::query()->get();
				$users           = TestRegModel::with('PatientReg')->where('regkey',$regkey)->withTrashed()->get();
				$TrashTestCount  = TestRegModel::with('PatientReg')->where('regkey',$regkey)->onlyTrashed()->count();
				$PatientID    = $users[0]->first()->PatientReg->patient_id;
				$VisitNo      = $users[0]->first()->PatientReg->visit_no;
				$PatientName  = $users[0]->first()->PatientReg->patient_name;
				$ReqDate      = $users[0]->first()->PatientReg->req_date;
				$Gender       = $users[0]->first()->PatientReg->gender;
				$Age_Y        = $users[0]->first()->PatientReg->age_y;
				$Age_M        = $users[0]->first()->PatientReg->age_m;
				$Age_D        = $users[0]->first()->PatientReg->age_d;

				// dd($PatientID);
				if($TrashTestCount == 0) {
					return redirect()->back()->with('status','No Deleted Tests');
		
				}else {
				return view('testreg',['users'=>$users],compact('PatientID','VisitNo','PatientName','ReqDate','Gender','Age_Y','Age_M','Age_D','regkey','OutLabs'));
				} 
			}
			public function delete($testreg_id){
				$TestRegID      = TestRegModel::query()->where('testreg_id', $testreg_id)->first();
				$TestCount      = TestRegModel::query()->where('regkey',$TestRegID->regkey)->count('regkey');
				$PatientRegKey  = PatientRegModel::query()->where('regkey',$TestRegID->regkey)->first();
		
				TestRegModel::query()->where('testreg_id', $testreg_id)->delete();
				if ($TestCount == 1){
					PatientRegModel::query()->where('regkey',$TestRegID->regkey)->delete();
				return redirect('patientreg');
				}
				return redirect()->back();
			}
		
		public function restore($testreg_id){
			$TestRegID   = TestRegModel::query()->where('testreg_id', $testreg_id)->onlyTrashed()->first();
			TestRegModel::query()->where('testreg_id', $testreg_id)->onlyTrashed()->restore();
			$RestoredTestReg   = TestRegModel::query()->where('testreg_id', $testreg_id)->first();
			// dd($RestoredTestReg);
			$TestCount = TestRegModel::query()->where('regkey', $RestoredTestReg->regkey)->count('regkey');
		// dd($TestCount);

			if ($TestCount > 0){
				PatientRegModel::query()->where('regkey',$RestoredTestReg->regkey)->withTrashed()->restore();
			return redirect('patientreg');

			}
			return redirect('patientreg');
			}

	
			public function updateReg(Request $request,$regkey) {
				// dd($request->all());
			$TestReg = TestRegModel::query()->with('PatientReg');
		
				$Tests         = $request->except('_token','_method');
				$TestsCount    = count($request->only('testreg_id')); 
				
			DB::beginTransaction();
			// dd($Tests);
	
			foreach ($Tests['testreg_id'] as $i=> $test) {
				// dd($i);
				$OutLab      = isset($Tests['outlab'][$i]) ? $Tests['outlab'][$i] : false;
				$OutLab_ID   = $Tests['outlab_id'][$i];
				$OutLab_Fees = $Tests['outlab_fees'][$i];

				$TestReg = TestRegModel::query()->where('testreg_id',$i)->update(
					[
						'outlab'       =>$OutLab,
						'outlab_id'    =>$OutLab_ID,
						'outlab_fees'  =>$OutLab_Fees

				]
					
				);
			}
		// when done commit
	DB::commit();
			return redirect()->back();
			}
}