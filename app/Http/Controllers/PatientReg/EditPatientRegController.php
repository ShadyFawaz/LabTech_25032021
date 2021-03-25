<?php

namespace App\Http\Controllers\PatientReg;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\PatientRegModel;
use App\TitlesModel;
use App\CountryModel;
use App\DoctorModel;
use App\DiagnosisModel;
use App\PatientConditionModel;
use App\PriceListsModel;
use App\RegTrackingModel;
use App\TestEntryModel;
use App\NormalRangesModel;
use App\RankPriceListsModel;
use App\RelativePriceListsModel;
use DB;

class EditPatientRegController extends Controller
{
    
    public function index(){
		$users = PatientRegModel::get();
		return view('patientreg\patientreg',['users'=>$users]);
		}

		public function show($regkey) {
			$Titles              = TitlesModel::get();
			$Country             = CountryModel::get();
			$Doctor              = DoctorModel::get();
			$Diagnosis           = DiagnosisModel::get();
			$PatientCondition    = PatientConditionModel::get();
			$PriceLists          = PriceListsModel::get();
			$RelativePriceLists   = RelativePriceListsModel::get();

			$users = PatientRegModel::where('regkey',$regkey)->get();
			return view('patientreg\editpatientreg',['users'=>$users],compact(['Titles','Country','Doctor','Diagnosis','PatientCondition','PriceLists','RelativePriceLists']));
		}
		public function edit(Request $request,$regkey) {
		//$title = $request->input('title');
                $title_id             = $request->input('title_id');
				$patient_name         = $request->input('patient_name');
				$gender               = $request->input('gender');
                $dob                  = $request->input('dob');
				$phone_number         = $request->input('phone_number');
				$age_y                = $request->input('age_y');
                $age_m                = $request->input('age_m');
				$age_d                = $request->input('age_d');
				$req_date             = $request->input('req_date');
				$email                = $request->input('email');
				$patient_condition    = $request->input('patient_condition');
				$country_id           = $request->input('country_id');
				$nationality          = $request->input('nationality');
				$doctor_id            = $request->input('doctor_id');
				$diagnosis_id         = $request->input('diagnosis_id');
				$comment              = $request->input('comment');
				$website              = $request->input('website');
				
		
				$users = PatientRegModel::where('regkey',$regkey)->update([
					'title_id'             => $title_id,
					'patient_name'         => $patient_name,
					'gender'               => $gender,
					'dob'                  => $dob,
					'phone_number'         => $phone_number,
					'age_y'                => $age_y,
					'age_m'                => $age_m,
					'age_d'                => $age_d,
					'req_date'             => $req_date,
					'email'                => $email,
					'patient_condition'    => $patient_condition,
					'country_id'           => $country_id,
					'nationality'          => $nationality,
					'doctor_id'            => $doctor_id,
					'diagnosis_id'         => $diagnosis_id,
					'comment'              => $comment,
					'website'              => $website
				]);

				$Results = TestEntryModel::where('regkey',$regkey)->get();
				// dd($Results);

			foreach($Results as $result){
				$age_total      = $age_y*365 + $age_m*30 + $age_d;
			//   $Normals     = NormalRangesModel::where('test_id',$result->test_id)->Where('age_from','<=',$ag)->Where('age_to','>=',$ag)->Where('age',$age)->Where('gender',$gender)->Where('active',True)->first();
			$normal_age     = NormalRangesModel::Where('test_id',$result->test_id)->Where('age_from_total','<=',$age_total)->Where('age_to_total','>=',$age_total)->Where('gender',$gender)->Where('active',True)->first();
   
				$low       = isset($normal_age['test_id']) ? $normal_age->low : Null;
                $high      = isset($normal_age['test_id']) ? $normal_age->high : Null;
				$nn_normal = isset($normal_age['test_id']) ? $normal_age->nn_normal : Null;
            // dd($Normals);
				$TestEntry = TestEntryModel::where('regkey',$regkey)->where('test_id',$result->test_id)->update([
				'low'        => $low,
				'high'       => $high,
				'nn_normal'  => $nn_normal
				]);

			}

				$RegTracking = new RegTrackingModel();
				$RegTracking->regkey              = $regkey;
			    $RegTracking->user_id             = '1';
				$RegTracking->status              = 'Updated';

				$RegTracking->save();
				
				// dd($RegTracking);

		return redirect('patientreg')->with('status',"Updated Successfully");
		
		}
}