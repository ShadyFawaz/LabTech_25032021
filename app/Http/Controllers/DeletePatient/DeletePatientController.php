<?php

namespace App\Http\Controllers\DeletePatient;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\PatientRegModel;
use Carbon\Carbon;
use DB;


class DeletePatientController extends Controller
{
	
	public function index(){
		return view('deletepatient\deletepatientsearch');
		}  

    
	public function SearchResultsByDay(){
		$PatientReg  = PatientRegModel::get();
		
		$PatientRegQuery = PatientRegModel::query();
		$datefrom      = request()->post('datefrom') ? Carbon::parse(request()->post('datefrom')) : null;
		$dateto        = request()->post('dateto') ? Carbon::parse(request()->post('dateto')) : null;
		$visit_no      = request()->post('visit_no');
		$patient_id    = request()->post('patient_id');
	
		if($datefrom && $dateto){
			$PatientRegQuery->whereBetween('Patient_Reg.req_date',[$datefrom,$dateto]);
			$datefrom = $datefrom->format('Y-m-d g:i A');
			$dateto   = $dateto->format('Y-m-d g:i A');
		}
		
		if($patient_id){
			$PatientRegQuery->where('patient_id',$patient_id);
			
 		}
		if($visit_no){
			$PatientRegQuery->where('visit_no',$visit_no);	
		 }


		
		$users = $PatientRegQuery->get();

// dd($users->toArray());
		return view('deletepatient\deletepatient',['users'=>$users],compact('datefrom','dateto'));
		}  

		public function PatientResults($regkey){
			$PatientReg  = PatientRegModel::get();
			$MegaTests   = MegaTestsModel::get();
			$TestEntry   = TestEntryModel::get();
			$TestReg     = TestRegModel::get();
			$TestData    = TestDataModel::get();
			$SubGroups   = SubGroupsModel::get();
			$Groups      = GroupsModel::get();
			
			

			$TestEntryQuery = TestEntryModel::query()->with('PatientReg','PatientReg.TestReg','TestData','TestData.SubGroups','TestData.SubGroups.Groups')->where('regkey',$regkey);

			$users = $TestEntryQuery->whereHas('TestData',function($qurey) {
				$qurey->groupBy('subgroup');
				})->get();	

			$patient_id   = $users[0]->PatientReg->patient_id;
			$visit_no     = $users[0]->PatientReg->visit_no;
			$patientName  = $users[0]->PatientReg->patient_name;
			$gender       = $users[0]->PatientReg->gender;
			$ag           = $users[0]->PatientReg->ag;
			$age          = $users[0]->PatientReg->age;
			$reqdate      = $users[0]->PatientReg->req_date;
	// dd($users->toArray());
			return view('testentry\patienttestentry',['users'=>$users],
			compact('PatientReg','TestData','Groups','SubGroups','patientName','patient_id','visit_no','gender','reqdate','ag','age'));
			} 
		
}