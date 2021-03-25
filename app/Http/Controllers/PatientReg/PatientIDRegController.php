<?php

namespace App\Http\Controllers\PatientReg;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\NewPatientDataModel;
use App\PatientRegModel;
use App\TitlesModel;
use DB;


class PatientIDRegController extends Controller
{
    
	public function index($patient_id){
		$Titles      = TitlesModel::get();
		$PatientData = NewPatientDataModel::get();
		$users       =  NewPatientDataModel::where('patient_id',$patient_id)->get();
		if (count($users)==0){
			return redirect()->back();
		}
		return view('patientreg\patientid',['users'=>$users],compact(['Titles']));
		}  
}