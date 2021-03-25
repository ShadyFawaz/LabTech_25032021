<?php

namespace App\Http\Controllers\PatientData;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use App\TitlesModel;
use App\NewPatientDataModel;

class EditPatientDataController extends Controller
{
    
    public function index(){
		$users = NewpatientDataModel::get();
		return view('patientdata\viewpatientdata',['users'=>$users]);
		}
		public function show($patient_code) {
			$titles = TitlesModel::get();
			$users  = NewPatientDataModel::with(['Title'])->where('patient_code',$patient_code)->get();
			return view('patientdata\editpatientdata',['users'=>$users],compact('titles'));
		}
		public function edit(Request $request,$patient_code) {
		//$title = $request->input('title');
		        $Patient_ID   = $request->input('Patient_ID');
                $Title_id     = $request->input('Title_id');
				$patient_name = $request->input('patient_name');
				$DOB          = $request->input('DOB');
                $phone_number = $request->input('phone_number');
                $Gender       = $request->input('Gender');
				$Address      = $request->input('Address');
				$Email        = $request->input('Email');
                $Website      = $request->input('Website');
				$Country      = $request->input('Country');
				$Nationality  = $request->input('Nationality');
		
				$users  = NewPatientDataModel::with(['Title'])->where('patient_code',$patient_code)->update([
					'Patient_ID'           => $Patient_ID,
					'Title_id'             => $Title_id,
					'patient_name'         => $patient_name,
					'Gender'               => $Gender,
					'DOB'                  => $DOB,
					'phone_number'         => $phone_number,
					'Address'              => $Address,
					'Email'                => $Email,
					'Country'              => $Country,
					'Nationality'          => $Nationality,
					'Website'              => $Website
				]);

		return redirect('viewpatientdata')->with('status',"Updated Successfully");
		
		}
}