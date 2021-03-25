<?php

namespace App\Http\Controllers\TestEntry;

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
use App\GroupsModel;
use DB;


class TestEntryController extends Controller
{
    
	public function index($regkey){
		$PatientReg  = PatientRegModel::get();
		// $MegaTests   = MegaTestsModel::get();
		$TestData    = TestDataModel::get();
		$SubGroups   = SubGroupsModel::get();
		$Groups      = GroupsModel::get();
		// $users       = TestRegModel::with(['PatientReg'])->get();
		// $users       = TestEntryModel::with(['TestData'])->get();
	
		// //dd($users->toArray());

		$users = DB::table('Test_Entry')
		->join('Patient_Reg', 'Patient_Reg.regkey', '=', 'Test_Entry.regkey')
		->join('Test_Data', 'Test_Data.test_id', '=', 'Test_Entry.test_id')
		->join('Subgroups', 'Subgroups.subgroup_id', '=', 'Test_Data.subgroup')
		->join('Groups', 'Groups.group_id', '=', 'SubGroups.group_id')
		->select('Groups.group_name as group','Test_Entry.regkey','Subgroups.subgroup_name as subgroup','Patient_Reg.*','Test_Data.subgroup as subgroup_id')->where('Test_Entry.regkey',$regkey)->whereNull('TestEntry.deleted_at')
        ->groupBy('Groups.group_name','Subgroups.subgroup_name','Test_Entry.regkey','Patient_Reg.patient_name','Test_Data.subgroup')
		->get();
		// dd($users->all());
		return view('testentry\testentry',['users'=>$users],compact('TestData','PatientReg'));
		}  

		
}