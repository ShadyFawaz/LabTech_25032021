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
use App\NewPatientDataModel;
use App\MegaTestsModel;
use App\MegaTestsChildModel;
use App\PriceListsModel;
use App\TestRegModel;
use App\TestEntryModel;
use App\TestDataModel;
use App\ResultsUnitsModel;
use App\NormalRangesModel;
use App\PricelistsTestsModel;
use App\RelativePricelistsModel;
use App\AntibioticEntryModel;
use App\TransactionsModel;
use App\ProfilesModel;
use App\ProfilesTestsModel;
use App\GroupTestsModel;
use App\GroupTestsChildModel;
use App\RegTrackingModel;
use App\OutLabsModel;
use App\OutLabTestsModel;
use App\RelativePriceListsUsersModel;
use Carbon\Carbon;
use Auth;
use DB;

class NewPatientRegProfileController extends Controller
{
    
    public function insert($patient_id = null){
		    $Titles              = TitlesModel::get();
			$Country             = CountryModel::get();
			$Doctor              = DoctorModel::get();
			$Diagnosis           = DiagnosisModel::get();
			$PatientCondition    = PatientConditionModel::get();
			$PriceLists          = PriceListsModel::get();
			$relatives           = RelativePriceListsUsersModel::where('user_id',Auth::user()->user_id)->where('active',true)->pluck('relative_pricelist_id');
			// dd($relatives);
			$rel   = RelativepriceListsModel::whereIn('relative_pricelist_id',$relatives)->pluck('relative_pricelist_id');
			// dd($rel);

			$RelativePriceLists  = RelativePriceListsModel::with('PriceLists','RankPriceLists')->whereIn('relative_pricelist_id',$rel)->groupBy('rank_pricelist_id')->get();
			// dd($RelativePriceLists);

			$patient       		 = NewPatientDataModel::where('patient_id',$patient_id)->first();
			$patients       	 = NewPatientDataModel::get();
			$tests  			 = ProfilesModel::where('active',true)->orderBy('profile_id')->get();

			if($patient){
				if($patient->DOB){
					$age   = Carbon::now()->diffInYears(Carbon::parse($patient->DOB));
					$age_y = Carbon::now()->diff(Carbon::parse($patient->DOB))->format('%y');
					$age_m = Carbon::now()->diff(Carbon::parse($patient->DOB))->format('%m');
					$age_d = Carbon::now()->diff(Carbon::parse($patient->DOB))->format('%d');
					
					// $test = $age_y*365.25 + $age_m*30 + $age_d;
					// dd($test);
					$patient->age   = $age;
					$patient->age_y = $age_y;	
					$patient->age_m = $age_m;	
					$patient->age_d = $age_d;
					// dd($patient);
					}else{
					$age = null;
					$patient->age = $age;
					$patient->age_y = '0';	
					$patient->age_m = '0';	
					$patient->age_d = '0';
				}}
        return view('patientreg\Newpatientregprofile',compact(['Titles','Country','Doctor','Diagnosis','PatientCondition','patient','PriceLists','tests','RelativePriceLists','patients']));
    }
    public function create(Request $request){
		// dd($request->all());
        $rules = [
			'patient_name'   => 'required|string|min:1|max:255',
			'gender'         => 'required|string|min:1|max:255',
			'age_y'          => 'required_without: age_m,age_d',
			'age_m'          => 'required_without: age_y,age_d',
			'age_d'          => 'required_without: age_y,age_m',
			
		];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('newpatientregprofile')->with('status',"Insert failed");
		}
		else{
			$VisitNo  = PatientRegModel::withTrashed()->orderBy('visit_no', 'desc')->first();
			$Date     = Carbon::now()->format('ymd');
			$pat_id   = $Date.''.($VisitNo->visit_no+'1');

			$data = $request->input();
			DB::beginTransaction();
			try{
				$user = new PatientRegModel();
				$user->patient_id              = isset($data['patient_id']) ? $data['patient_id'] : $pat_id;
				$user->visit_no                = $VisitNo->visit_no + '1';
                $user->title_id                = $data['title_id'];
				$user->patient_name            = $data['patient_name'];
				$user->gender                  = $data['gender'];
                $user->dob                     = $data['dob'];
				$user->phone_number            = $data['phone_number'];
				$user->age_y                   = $data['age_y'];
				$user->age_m                   = $data['age_m'];
				$user->age_d                   = $data['age_d'];
				$user->req_date                = $data['req_date'];
				$user->email                   = $data['email'];
				$user->patient_condition       = $data['patient_condition'];
				$user->website                 = $data['website'];
				$user->country_id              = $data['country_id'];
				$user->nationality             = $data['nationality'];
				$user->doctor_id               = $data['doctor_id'];
				$user->diagnosis_id            = $data['diagnosis_id'];
				$user->pricelist_id            = $data['rank_pricelist_id'];
				$user->relative_pricelist_id   = $data['relative_pricelist_id'];
				$user->comment                 = $data['comment'];
				$user->user_id                 = '1';
				$user->save();
				// dd($user->ag,$request->all());
				// if($data['parent_test'])
				//  {

					$Transactions = new TransactionsModel();
				 	$Transactions->regkey              = $user->id;
					$Transactions->payed               = null;
					$Transactions->visa                = '0';
					$Transactions->transaction_date    = null;
					$Transactions->user_id             = null;
					$Transactions->save();

// if ($user->patient_id){
	if(NewPatientDataModel::where('Patient_ID', $user->patient_id)->exists()){
	}else{
				$PatientData = new NewPatientDataModel();
				   $PatientData->Patient_ID        = $user->patient_id;
				   $PatientData->Title_id          = $user->title_id;
				   $PatientData->patient_name      = $user->patient_name;
				   $PatientData->DOB               = $user->dob;
				   $PatientData->Gender            = $user->gender;

				   $PatientData->save();
				}
				
				$RegTracking = new RegTrackingModel();
				 	$RegTracking->regkey              = $user->id;
					$RegTracking->user_id             = '1';
					$RegTracking->status              = 'Registered';

					$RegTracking->save();

					

		$MegaProfilesTests   = ProfilesTestsModel::whereIn('profile_id',$request->profile_id)->whereNull('test_id')->whereNull('grouptest_id')->get();
		$ProfilesTests       = ProfilesTestsModel::whereIn('profile_id',$request->profile_id)->whereNull('megatest_id')->whereNull('grouptest_id')->get();
		$GroupProfilesTests  = ProfilesTestsModel::whereIn('profile_id',$request->profile_id)->whereNull('megatest_id')->whereNull('test_id')->get();

		$RelativePriceLists  = RelativePriceListsModel::where('relative_pricelist_id',$user->relative_pricelist_id)->first();
				
		// dd($MegaProfilesTests);

		foreach($MegaProfilesTests as $megaprofiletest){
			$MegaTest_ID        = MegaTestsModel::where('megatest_id',$megaprofiletest->megatest_id)->first();
			$LabToLabPrice      = OutLabTestsModel::where('megatest_id',$megaprofiletest->megatest_id)->where('outlab_id',$MegaTest_ID->outlab_id)->first();

			// dd($MegaTest_ID);
			$PriceListsTests    = PriceListsTestsModel::where('megatest_id',$megaprofiletest->megatest_id)->where('pricelist_id',$RelativePriceLists->pricelist_id)->first();
			$PatientLoad        = $PriceListsTests->price * $RelativePriceLists->patient_load;
			$InsuranceLoad      = $PriceListsTests->price * $RelativePriceLists->insurance_load;
			// dd($PatientLoad);

			$TestReg    = new TestRegModel();
			$TestReg->regkey           = $user->id;
			$TestReg->megatest_id      = $megaprofiletest->megatest_id;
			$TestReg->patient_fees     = $PatientLoad ;
			$TestReg->insurance_fees   = $InsuranceLoad;
			$TestReg->outlab           = $MegaTest_ID->outlab;
			$TestReg->outlab_id        = $MegaTest_ID->outlab_id;
			$TestReg->outlab_fees      = isset($LabToLabPrice['price']) ? $LabToLabPrice->price : Null;

			$TestReg->user_id          ='1';
			// dd($ProfilesTests);
			$TestReg->save();
		}
		
		$MegaProfileTestsids = $MegaProfilesTests->pluck('megatest_id');
		$MegaTestsChild  = MegaTestsChildModel::whereIn('megatest_id',$MegaProfileTestsids)->where('active',true)->get();

		// dd($MegaProfileTestsids);


		foreach($MegaTestsChild as $testchild){
			$AntibioticEntry  = AntibioticEntryModel::get();
			$TestData         = TestDataModel::where('test_id',$testchild->test_id)->first();
			$CultureData      = TestDataModel::whereNotNull('culture_link')->where('test_id',$testchild->test_id)->first();
			$ResultsUnits     = ResultsUnitsModel::where('resultunit_id',$TestData->unit)->first();
			// $NormalRanges     = NormalRangesModel::Where('test_id',$testchild->test_id)->Where('age_from','<=',$user->ag)->Where('age_to','>=',$user->ag)->Where('age',$user->age)->Where('gender',$user->gender)->Where('active',True)->first();
			$age_total      = $user->age_y*365 + $user->age_m*30 + $user->age_d;
			$normal_age     = NormalRangesModel::Where('test_id',$testchild->test_id)->Where('age_from_total','<=',$age_total)->Where('age_to_total','>=',$age_total)->Where('gender',$user->gender)->Where('active',True)->first();
			
			if ($CultureData){
				$newAntibioticEntry  = new AntibioticEntryModel();
				$newAntibioticEntry->regkey         = $user->id;
				$newAntibioticEntry->culture_link   = $CultureData->culture_link;
				$newAntibioticEntry->antibiotic_id  = null;
				$newAntibioticEntry->sensitivity    = null;

				$newAntibioticEntry->save();
			}
			if (TestEntryModel::where('regkey',$user->id)->where('test_id',$testchild->test_id)->exists()){
				}else{
				$TestEntry     = new TestEntryModel();
				$SampleID      = $user->id.''.$TestData->test_group.''.'0';
				// dd($CultureData);
				$TestEntry->regkey            = $user->id;
				$TestEntry->test_id           = $testchild->test_id;
				$TestEntry->megatest_id       = $testchild->megatest_id;
				$TestEntry->sample_id         = $SampleID;
				$TestEntry->unit              = $TestData->unit? $ResultsUnits->result_unit : Null;
				$TestEntry->result            = $TestData->default_value? $TestData->default_value : Null;
				$TestEntry->low               = isset($normal_age['test_id']) ? $normal_age->low : Null;
				$TestEntry->high              = isset($normal_age['test_id']) ? $normal_age->high : Null;
				$TestEntry->nn_normal         = isset($normal_age['test_id']) ? $normal_age->nn_normal : Null;
				$TestEntry->save();

				}

			}


		foreach($GroupProfilesTests as $groupprofiletest){
			$GroupTest_ID        = GroupTestsModel::where('grouptest_id',$groupprofiletest->grouptest_id)->first();
			$GroupTestCheck      = GroupTestsChildModel::where('grouptest_id',$groupprofiletest->grouptest_id)->first();
			$LabToLabPrice     = OutLabTestsModel::where('grouptest_id',$groupprofiletest->grouptest_id)->where('outlab_id',$GroupTest_ID->outlab_id)->first();

			$PriceListsTests    = PriceListsTestsModel::where('grouptest_id',$groupprofiletest->grouptest_id)->where('pricelist_id',$RelativePriceLists->pricelist_id)->first();
			$PatientLoad        = $PriceListsTests->price * $RelativePriceLists->patient_load;
			$InsuranceLoad      = $PriceListsTests->price * $RelativePriceLists->insurance_load;
			// dd($PatientLoad);
			if (TestEntryModel::where('regkey',$user->id)->where('test_id',$GroupTestCheck->test_id)->exists()){
			}else{
			$TestReg    = new TestRegModel();
			$TestReg->regkey           = $user->id;
			$TestReg->grouptest_id     = $groupprofiletest->grouptest_id;
			$TestReg->patient_fees     = $PatientLoad ;
			$TestReg->insurance_fees   = $InsuranceLoad;
			$TestReg->outlab           = $GroupTest_ID->outlab;
			$TestReg->outlab_id        = $GroupTest_ID->outlab_id;
			$TestReg->outlab_fees      = isset($LabToLabPrice['price']) ? $LabToLabPrice->price : Null;

			$TestReg->user_id          ='1';
			// dd($ProfilesTests);
			$TestReg->save();
		}}
		
		$GroupProfileTestsids = $GroupProfilesTests->pluck('grouptest_id');
		$GroupTestsChild  = GroupTestsChildModel::whereIn('grouptest_id',$GroupProfileTestsids)->where('active',true)->get();

		// dd($MegaProfileTestsids);


		foreach($GroupTestsChild as $testchild){
			$AntibioticEntry  = AntibioticEntryModel::get();
			$TestData         = TestDataModel::where('test_id',$testchild->test_id)->first();
			$CultureData      = TestDataModel::whereNotNull('culture_link')->where('test_id',$testchild->test_id)->first();
			$ResultsUnits     = ResultsUnitsModel::where('resultunit_id',$TestData->unit)->first();
			// $NormalRanges     = NormalRangesModel::Where('test_id',$testchild->test_id)->Where('age_from','<=',$user->ag)->Where('age_to','>=',$user->ag)->Where('age',$user->age)->Where('gender',$user->gender)->Where('active',True)->first();
			$age_total      = $user->age_y*365 + $user->age_m*30 + $user->age_d;
			$normal_age     = NormalRangesModel::Where('test_id',$testchild->test_id)->Where('age_from_total','<=',$age_total)->Where('age_to_total','>=',$age_total)->Where('gender',$user->gender)->Where('active',True)->first();
			
			if ($CultureData){
				$newAntibioticEntry  = new AntibioticEntryModel();
				$newAntibioticEntry->regkey         = $user->id;
				$newAntibioticEntry->culture_link   = $CultureData->culture_link;
				$newAntibioticEntry->antibiotic_id  = null;
				$newAntibioticEntry->sensitivity    = null;

				$newAntibioticEntry->save();
			}
			if (TestEntryModel::where('regkey',$user->id)->where('test_id',$testchild->test_id)->exists()){
				}else{
				$TestEntry     = new TestEntryModel();
				$SampleID      = $user->id.''.$TestData->test_group.''.'0';
				// dd($CultureData);
				$TestEntry->regkey            = $user->id;
				$TestEntry->test_id           = $testchild->test_id;
				$TestEntry->grouptest_id      = $testchild->grouptest_id;
				$TestEntry->sample_id         = $SampleID;
				$TestEntry->unit              = $TestData->unit? $ResultsUnits->result_unit : Null;
				$TestEntry->result            = $TestData->default_value? $TestData->default_value : Null;
				$TestEntry->low               = isset($normal_age['test_id']) ? $normal_age->low : Null;
				$TestEntry->high              = isset($normal_age['test_id']) ? $normal_age->high : Null;
				$TestEntry->nn_normal         = isset($normal_age['test_id']) ? $normal_age->nn_normal : Null;
				$TestEntry->save();

				}

			}

			
	
			
	foreach($ProfilesTests as $profiletest){
		$Test_ID        = TestDataModel::where('test_id',$profiletest->test_id)->first();
		$LabToLabPrice  = OutLabTestsModel::where('test_id',$profiletest->test_id)->where('outlab_id',$Test_ID->outlab_id)->first();

		$PriceListsTests    = PriceListsTestsModel::where('test_id',$profiletest->test_id)->where('pricelist_id',$RelativePriceLists->pricelist_id)->first();
		$PatientLoad        = $PriceListsTests->price * $RelativePriceLists->patient_load;
		$InsuranceLoad      = $PriceListsTests->price * $RelativePriceLists->insurance_load;
		// dd($PatientLoad);
		if (TestEntryModel::where('regkey',$user->id)->where('test_id',$profiletest)->exists()){
		}else{
		$TestReg    = new TestRegModel();
		$TestReg->regkey           = $user->id;
		$TestReg->test_id          = $profiletest->test_id;
		$TestReg->patient_fees     = $PatientLoad ;
		$TestReg->insurance_fees   = $InsuranceLoad;
		$TestReg->outlab           = $Test_ID->out_lab;
		$TestReg->outlab_id        = $Test_ID->outlab_id;
		$TestReg->outlab_fees      = isset($LabToLabPrice['price']) ? $LabToLabPrice->price : Null;

		$TestReg->user_id          ='1';
		// dd($ProfilesTests);
		$TestReg->save();
	}}

	$ProfileTestsids  = $ProfilesTests->pluck('test_id');
	$TestData         = TestDataModel::whereIn('test_id',$ProfileTestsids)->where('active',true)->get();

// dd($TestData);
	foreach($TestData as $test){

		$AntibioticEntry  = AntibioticEntryModel::get();
		$TestData         = TestDataModel::where('test_id',$test->test_id)->first();
		$CultureData      = TestDataModel::whereNotNull('culture_link')->where('test_id',$test->test_id)->first();
		$ResultsUnits     = ResultsUnitsModel::where('resultunit_id',$TestData->unit)->first();
		// $NormalRanges     = NormalRangesModel::Where('test_id',$test->test_id)->Where('age_from','<=',$user->ag)->Where('age_to','>=',$user->ag)->Where('age',$user->age)->Where('gender',$user->gender)->Where('active',True)->first();
		$age_total      = $user->age_y*365 + $user->age_m*30 + $user->age_d;
		$normal_age     = NormalRangesModel::Where('test_id',$testchild->test_id)->Where('age_from_total','<=',$age_total)->Where('age_to_total','>=',$age_total)->Where('gender',$user->gender)->Where('active',True)->first();
		
		if ($CultureData){
			$newAntibioticEntry  = new AntibioticEntryModel();
			$newAntibioticEntry->regkey         = $user->id;
			$newAntibioticEntry->culture_link   = $CultureData->culture_link;
			$newAntibioticEntry->antibiotic_id  = null;
			$newAntibioticEntry->sensitivity    = null;

			$newAntibioticEntry->save();
		}
		if (TestEntryModel::where('regkey',$user->id)->where('test_id',$test->test_id)->exists()){
			}else{
			$TestEntry     = new TestEntryModel();
			$SampleID      = $user->id.''.$TestData->test_group.''.'0';
			// dd($CultureData);
			$TestEntry->regkey            = $user->id;
			$TestEntry->test_id           = $test->test_id;
			$TestEntry->megatest_id       = null;
			$TestEntry->sample_id         = $SampleID;
			$TestEntry->unit              = $TestData->unit? $ResultsUnits->result_unit : Null;
			$TestEntry->result            = $TestData->default_value? $TestData->default_value : Null;
			$TestEntry->low               = isset($normal_age['test_id']) ? $normal_age->low : Null;
			$TestEntry->high              = isset($normal_age['test_id']) ? $normal_age->high : Null;
			$TestEntry->nn_normal         = isset($normal_age['test_id']) ? $normal_age->nn_normal : Null;
			$TestEntry->save();

			}

		}
				DB::commit();
				 
				$patientloadcheck = TestRegModel::query()->where('regkey',$user->id)->sum('patient_fees');
				// dd($patientloadcheck);
				if($patientloadcheck > 0){
					return redirect('transactions/'.$user->id)->with('status',"Insert successfully");
				}else{
					return redirect('newpatientreg')->with('status',"Insert successfully");
				}
				}
			catch(Exception $e){
				DB::rollback();
				return redirect('newpatientregprofile')->with('failed',"operation failed");
			}
		}
    }
}