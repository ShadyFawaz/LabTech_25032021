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
use App\CountryModel;
use Carbon\Carbon;
use DB;

class NewPatientDataController extends Controller
{
    
    public function insert(){
		$titles  = TitlesModel::get();
		$Country = CountryModel::get();
        return view('patientdata\NewPatientData',compact('titles','Country'));
    }
    public function create(Request $request){
		//dd($request->all());
        $rules = [
			'patient_name' => 'required|string|min:5|max:255',
			'Gender'       => 'required|string|min:3|max:255',
		];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('newpatientdata')->with('status',"Insert failed");
		}
		else{
			$data          = $request->input();
			$Date          = Carbon::now()->format('ymdhis');
			$pat_id        = $Date;
			// dd($pat_id);
			$Pat_ID_Check  = NewPatientDataModel::where('Patient_ID',$data['Patient_ID'])->exists();
			try{
				if ($Pat_ID_Check){
				return redirect('newpatientdata')->with('failed',"Cannot Duplicate Patient");
				}else{
				$user = new NewPatientDataModel();
                $user->Patient_ID     = isset($data['Patient_ID']) ? $data['Patient_ID'] : $pat_id;
                $user->Title_id       = $data['Title_id'];
				$user->patient_name   = $data['patient_name'];
				$user->DOB            = $data['DOB'];
                $user->phone_number   = $data['phone_number'];
                $user->Gender         = $data['Gender'];
				$user->Address        = $data['Address'];
				$user->EMail          = $data['Email'];
                $user->Website        = $data['Website'];
				$user->Country        = $data['Country'];
				$user->Nationality    = $data['Nationality'];
				$user->save();
				return redirect('viewpatientdata')->with('status',"Insert successfully");
			}}
			catch(Exception $e){
				return redirect('newpatientdata')->with('failed',"operation failed");
			}
		}
    }
}