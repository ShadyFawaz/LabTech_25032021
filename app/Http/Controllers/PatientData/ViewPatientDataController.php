<?php

namespace App\Http\Controllers\PatientData;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\NewPatientDataModel;
use App\TitlesModel;
use DB;


class ViewPatientDataController extends Controller
{
    
	public function index(){
		$titles = TitlesModel::get();
		$users  = NewPatientDataModel::get();
		return view('patientdata\viewpatientdata',['users'=>$users],compact('titles'));
		}  
		
}