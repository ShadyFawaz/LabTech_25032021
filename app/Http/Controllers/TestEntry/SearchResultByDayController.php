<?php

namespace App\Http\Controllers\TestEntry;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\TestEntryModel;
use App\PatientRegModel;
use App\MegaTestsModel;
use App\TestDataModel;
use App\GroupsModel;
use App\SubGroupsModel;
use App\TestRegModel;
use App\PriceListsModel;
use App\RelativePriceListsModel;
use App\GroupTestsModel;
use Carbon\Carbon;
use DB;


class SearchResultByDayController extends Controller
{
	
	public function index(){
		$SubGroups   = SubGroupsModel::orderBy('subgroup_name')->get();
		$Groups      = GroupsModel::orderBy('group_name')->get();
		$MegaTests   = MegaTestsModel::where('active',true)->orderBy('test_name')->get();
		$GroupTests  = GroupTestsModel::where('active',true)->orderBy('test_name')->get();
		$TestData    = TestDataModel::where('active',true)->orderBy('abbrev')->get();
		$PriceLists  = PriceListsModel::get();
		$RelativePriceLists  = RelativePriceListsModel::with('PriceLists','RankPriceLists')->groupBy('rank_pricelist_id')->get();


		
		return view('testentry\searchresultsbyday',compact('SubGroups','Groups','MegaTests','PriceLists','RelativePriceLists','TestData','GroupTests'));
		}  

    
	public function SearchResultsByDay(){
		$PatientReg  = PatientRegModel::get();
		$MegaTests   = MegaTestsModel::get();
		$TestEntry   = TestEntryModel::get();
		$TestReg     = TestRegModel::get();
		$TestData    = TestDataModel::get();
		$SubGroups   = SubGroupsModel::get();
		$Groups      = GroupsModel::get();
		
		$TestEntryQuery = TestEntryModel::query()->with('PatientReg','PatientReg.TestReg','TestData','TestData.SubGroups','TestData.SubGroups.Groups');
// 		$array = array(
// 			'regkey'  => $TestEntryQuery->pluck('regkey'),
// 			'test_id' => $TestEntryQuery->pluck('test_id'),
// 		);
// dd($array);
		// $users = DB::table('Test_Entry')
		// 	->join('Patient_Reg', 'Patient_Reg.regkey', '=', 'Test_Entry.regkey')
		// 	->join('Test_Reg', 'Test_Reg.regkey', '=', 'Patient_Reg.regkey')
		// 	->join('Test_Data', 'Test_Data.test_id', '=', 'Test_Entry.test_id')
		// 	->join('Subgroups', 'Subgroups.subgroup_id', '=', 'Test_Data.subgroup')
		// 	->join('Groups', 'Groups.group_id', '=', 'SubGroups.group_id')
		// 	->select('Groups.group_name as group','Subgroups.subgroup_name as subgroup','Patient_Reg.*','Test_Data.subgroup as subgroup_id','Test_Entry.seperate_test as seperate_test')
		// 	->groupBy('Groups.group_name','Subgroups.subgroup_name','Test_Entry.regkey','Patient_Reg.patient_name','Patient_Reg.visit_no','Test_Entry.seperate_test','Test_Data.subgroup')
		// 	->orderBy('Test_Entry.regkey')
		// 	;

	$users = DB::table('Test_Entry')
		->join('Patient_Reg', 'Patient_Reg.regkey', '=', 'Test_Entry.regkey')
		->leftjoin('Test_Data', 'Test_Data.test_id', '=', 'Test_Entry.test_id')
		->join('Groups', 'Groups.group_id', '=', 'Test_Data.test_group')
		->leftjoin('Mega_Tests', 'Mega_Tests.megatest_id', '=', 'Test_Entry.megatest_id')
		->select('Groups.group_name as group','Mega_Tests.test_name as meganame','Patient_Reg.*',
		'Test_Data.test_group as group_id',
		'Test_Entry.seperate_test as seperate_test',
		'Test_Entry.regkey as sample_grouping',
		'Mega_Tests.megatest_id as megatest_id',
		DB::raw('count(Test_Entry.regkey) as regcheck'),

		DB::raw('sum(completed = "1")  as comp'),
		DB::raw('sum(completed = "0")  as notcomp'),

		DB::raw('sum(verified = "1")  as ver'),
		DB::raw('sum(verified = "0")  as notver'),
		
		DB::raw('sum(printed = "1")  as pr'),
		DB::raw('sum(printed = "0")  as notpr'))

		->whereNull('Test_Entry.deleted_at')
		->groupBy('Test_Entry.megatest_id','Test_Data.test_group','Test_Entry.seperate_test','Test_Entry.regkey')
		->orderBy('Test_Entry.regkey')
		->orderBy('Test_Data.test_group');

		$datefrom               = request()->post('datefrom') ? Carbon::parse(request()->post('datefrom')) : null;
		$dateto                 = request()->post('dateto')   ? Carbon::parse(request()->post('dateto')) : null;
		$completed              = request()->post('completed');
		$notcompleted           = request()->post('notcompleted');
		$verified               = request()->post('verified');
		$notverified            = request()->post('notverified');
		$printed                = request()->post('printed');
		$notprinted             = request()->post('notprinted');
		$visit_no               = request()->post('visit_no');
		$rank_pricelist_id      = request()->post('rank_pricelist_id');
		$relative_pricelist_id  = request()->post('relative_pricelist_id');
		$patient_id             = request()->post('patient_id');
		$group                  = request()->post('group');
		$select_test            = request()->post('selecttest_id');

		// dd($megatest_id);
		if($datefrom && $dateto){
			
			$TestEntryQuery->whereHas('PatientReg',function($qurey) use($datefrom,$dateto){
			$qurey->whereBetween('req_date',[$datefrom,$dateto]);
			});

			$users->whereBetween('Patient_Reg.req_date',[$datefrom,$dateto]);
			
			$datefrom = $datefrom->format('Y-m-d g:i A');
			$dateto   = $dateto->format('Y-m-d g:i A');
		}
		if($patient_id){
			$TestEntryQuery->whereHas('PatientReg',function($qurey) use($patient_id){
				$qurey->where('patient_id',$patient_id);
				});
			$users->where('Patient_Reg.patient_id',$patient_id);
 		}
		if($visit_no){
			$TestEntryQuery->whereHas('PatientReg',function($qurey) use($visit_no){
				$qurey->where('visit_no',$visit_no);
				});
			$users->where('Patient_Reg.visit_no',$visit_no);

		 }
		 if($rank_pricelist_id){
			$TestEntryQuery->whereHas('PatientReg',function($qurey) use($rank_pricelist_id){
				$qurey->where('pricelist_id',$rank_pricelist_id);
				});
			$users->where('Patient_Reg.pricelist_id',$rank_pricelist_id);

		 }
		 if($relative_pricelist_id){
			$TestEntryQuery->whereHas('PatientReg',function($qurey) use($relative_pricelist_id){
				$qurey->where('relative_pricelist_id',$relative_pricelist_id);
				});
			$users->where('Patient_Reg.relative_pricelist_id',$relative_pricelist_id);

		 }
		
		 if($group){
			$TestEntryQuery->whereHas('TestData.Groups',function($qurey) use($group){
				$qurey->where('test_group',$group);
				});
			$users->where('Test_Data.test_group',$group);

		 }
		 if($select_test){
			// $TestEntryQuery->whereHas('PatientReg',function($qurey) use($megatest_id){
			// 	$qurey->where('megatest_id',$megatest_id);
			// 	});
		$MegaTest  = TestEntryModel::where('megatest_id',$select_test)->first();
		$GroupTest = TestEntryModel::where('grouptest_id',$select_test)->first();
		$Test      = TestEntryModel::where('test_id',$select_test)->first();
		
		// dd($MegaTest);
		if($MegaTest){
			$users->where('Test_Entry.megatest_id',$select_test);
		}elseif($GroupTest){
			$users->where('Test_Entry.grouptest_id',$select_test);
		}elseif($Test){
			$users->where('Test_Entry.test_id',$select_test);
		}
			// dd($megatest_id);

		 }
		if($completed){
			$TestEntryQuery->where('completed','=','1');
			$users->where('completed',true);

		}
		if($notcompleted){
			$TestEntryQuery->where('completed','=','0');
			$users->where('completed',false);

		}
		if($verified){
			$TestEntryQuery->where('verified','=','1');
			$users->where('verified',true);

		}
		if($notverified){
			$TestEntryQuery->where('verified','=','0');
			$users->where('verified',false);

		}
		if($printed){
			$TestEntryQuery->where('printed','=','1');
			$users->where('printed',true);

		}
		if($notprinted){
			$TestEntryQuery->where('printed','=','0');
			$users->where('printed',false);

		}
		$ResultEntries = $users->get();
        
		// $verified = $users->count();
		// dd($ResultEntries);
		
		return view('testentry\testentry',['ResultEntries'=>$ResultEntries],compact('datefrom','dateto'));
		}  

		public function PatientResults($regkey){
			$PatientReg  = PatientRegModel::get();
			$MegaTests   = MegaTestsModel::get();
			$TestEntry   = TestEntryModel::get();
			$TestReg     = TestRegModel::get();
			$TestData    = TestDataModel::get();
			$SubGroups   = SubGroupsModel::get();
			$Groups      = GroupsModel::get();
			
			
			$TestEntryQuery = TestEntryModel::query()->with('PatientReg','PatientReg.TestReg','TestData','TestData.Groups','MegaTests')->where('regkey',$regkey)->groupBy('sample_id');
			$ResultEntries  = $TestEntryQuery->orderBy('regkey')->get();
			// dd($ResultEntries->toArray());

			$users = DB::table('Test_Entry')
			->join('Patient_Reg', 'Patient_Reg.regkey', '=', 'Test_Entry.regkey')
			->leftjoin('Test_Data', 'Test_Data.test_id', '=', 'Test_Entry.test_id')
			->join('Groups', 'Groups.group_id', '=', 'Test_Data.test_group')
			->leftjoin('Mega_Tests', 'Mega_Tests.megatest_id', '=', 'Test_Entry.megatest_id')
			->select('Groups.group_name as group','Mega_Tests.test_name as meganame','Patient_Reg.*'
			,'Test_Data.test_group as group_id'
			,'Test_Entry.seperate_test as seperate_test'
			,'Test_Entry.regkey as sample_grouping'
			,'Mega_Tests.megatest_id as megatest_id',

			DB::raw('count(Test_Entry.regkey) as regcheck'),

			DB::raw('sum(completed = "1")  as comp'),
			DB::raw('sum(completed = "0")  as notcomp'),
	
			DB::raw('sum(verified = "1")  as ver'),
			DB::raw('sum(verified = "0")  as notver'),
			
			DB::raw('sum(printed = "1")  as pr'),
			DB::raw('sum(printed = "0")  as notpr'))

			->where('Test_Entry.regkey',$regkey)
			->whereNull('Test_Entry.deleted_at')
			->groupBy('Test_Entry.megatest_id','Test_Data.test_group','Test_Entry.seperate_test')
			->get();

			
			$patient_id   = $ResultEntries->first()->PatientReg->patient_id;
			$visit_no     = $ResultEntries->first()->PatientReg->visit_no;
			$patientName  = $ResultEntries->first()->PatientReg->patient_name;
			$gender       = $ResultEntries->first()->PatientReg->gender;
			$age_d        = $ResultEntries->first()->PatientReg->age_d;
			$age_m        = $ResultEntries->first()->PatientReg->age_m;
			$age_y        = $ResultEntries->first()->PatientReg->age_y;

			$reqdate      = $ResultEntries->first()->PatientReg->req_date;

			// dd($users->first());

			return view('testentry\patienttestentry',['users'=>$users],
			compact('PatientReg','TestData','Groups','patientName','patient_id','visit_no','gender','reqdate','age_d','age_m','age_y'));
			} 
		
}