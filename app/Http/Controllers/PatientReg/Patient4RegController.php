<?php

namespace App\Http\Controllers\PatientReg;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\TitlesModel;
use App\CountryModel;
use App\DoctorModel;
use App\DiagnosisModel;
use App\PatientConditionModel;
use App\PatientRegModel;
use DB;


class PatientRegController extends Controller
{
    
	public function index(){
		    $Titles              = TitlesModel::get();
			$Country             = CountryModel::get();
			$Doctor              = DoctorModel::get();
			$Diagnosis           = DiagnosisModel::get();
			$PatientCondition    = PatientConditionModel::get();
			// $users     = PatientRegModel::->where(('req_date'), Carbon::today())->get();
		    $users        = PatientRegModel::get();
		return view('patientreg\patientreg',['users'=>$users],compact(['Titles','Country','Doctor','Diagnosis','PatientCondition']));
		}  
}