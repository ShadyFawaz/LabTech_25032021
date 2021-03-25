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
use App\RelativePriceListsModel;
use App\RankPriceListsModel;
use App\AntibioticEntryModel;
use App\TransactionsModel;
use App\RegTrackingModel;
use App\GroupTestsModel;
use App\GroupTestsChildModel;
use Carbon\Carbon;
use Auth;
use DB;

class NewPatientRegController extends Controller
{
    
    public function insert($patient_id = null){
		    $Titles              = TitlesModel::get();
			$Country             = CountryModel::get();
			$Doctor              = DoctorModel::get();
			$Diagnosis           = DiagnosisModel::get();
			$PatientCondition    = PatientConditionModel::get();
			$PriceLists          = PriceListsModel::get();
			$RelativePriceLists  = RelativePriceListsModel::with('PriceLists','RankPriceLists')->groupBy('rank_pricelist_id')->get();
			$patient       		 = NewPatientDataModel::where('patient_id',$patient_id)->first();
			$tests  			 = MegaTestsModel::where('active',true)->orderBy('test_name')->get();
			$tests2              = TestDataModel::where('active',true)->orderBy('abbrev')->get();
			$groups              = GroupTestsModel::where('active',true)->orderBy('test_name')->get();
			$patients       	 = NewPatientDataModel::get();

			// dd($patients);
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
        return view('patientreg/newpatientreg',compact(['Titles','Country','Doctor','Diagnosis','PatientCondition','patient','PriceLists','tests','tests2','groups','RelativePriceLists','patients']));
	}
	
    public function create(Request $request){
		dd($request->all());
        $rules = [
			'patient_name'   => 'required|string|min:1|max:255',
			'gender'         => 'required|string|min:1|max:255',
			'age_y'          => 'required_without: age_m,age_d',
			'age_m'          => 'required_without: age_y,age_d',
			'age_d'          => 'required_without: age_y,age_m',
			'patient_name'   => 'required|string|min:1|max:255',
			// 'megatest_id'    => 'sometimes|required',
			// 'test_id'        => 'sometimes|required',
			// 'grouptest_id'   => 'sometimes|required',

			// 'megatest_id'    => 'required_without: test_id,grouptest_id',
			// 'test_id'        => 'required_without: megatest_id,grouptest_id',
			// 'grouptest_id'   => 'required_without: megatest_id,test_id',

			
		];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('newpatientreg')->with('status',"Insert failed");
		}
		else{
			$VisitNo    = PatientRegModel::orderBy('visit_no', 'desc')->first();
			$Date       = Carbon::now()->format('ymd');
			$pat_id     = $Date.''.($VisitNo->visit_no+'1');
			dd($VisitNo);
			$VisitNo    = PatientRegModel::orderBy('visit_no', 'desc')->first();

			$data = $request->input();
			DB::beginTransaction();
			try{
				$user = new PatientRegModel();
				$user->patient_id             = isset($data['patient_id']) ? $data['patient_id'] : $pat_id;
				$user->visit_no               = $VisitNo->visit_no + '1';
                $user->title_id               = $data['title_id'];
				$user->patient_name           = $data['patient_name'];
				$user->gender                 = $data['gender'];
                $user->dob                    = $data['dob'];
				$user->phone_number           = $data['phone_number'];
				$user->age_y                  = $data['age_y'];
				$user->age_m                  = $data['age_m'];
				$user->age_d                  = $data['age_d'];
				$user->req_date               = $data['req_date'];
				$user->email                  = $data['email'];
				$user->patient_condition      = $data['patient_condition'];
				$user->website                = $data['website'];
				$user->country_id             = $data['country_id'];
				$user->nationality            = $data['nationality'];
				$user->doctor_id              = $data['doctor_id'];
				$user->diagnosis_id           = $data['diagnosis_id'];
				$user->pricelist_id           = $data['rank_pricelist_id'];
				$user->relative_pricelist_id  = $data['relative_pricelist_id'];
				$user->comment                = $data['comment'];
				$user->user_id                = Auth::user()->user_id;
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

				// dd($RegTracking);

				$RelativePriceLists  = RelativePriceListsModel::where('relative_pricelist_id',$user->relative_pricelist_id)->first();
				
				// dd($RelativePriceLists);
				$test_check     = $request->has('test_id');
				$megatest_check = $request->has('megatest_id');
				$group_check    = $request->has('grouptest_id');
// dd($request->megatest_id);
				// dd($megatest_check);
				
			if ($megatest_check){
			foreach($request->megatest_id as $id){
			$PriceListsTests   = PriceListsTestsModel::where('megatest_id',$id)->where('pricelist_id',$RelativePriceLists->pricelist_id)->first();
			$PatientLoad       = $PriceListsTests->price * $RelativePriceLists->patient_load;
			$InsuranceLoad     = $PriceListsTests->price * $RelativePriceLists->insurance_load;
			
			$TestReg  = new TestRegModel();
			$TestReg->regkey           = $user->id;
			$TestReg->megatest_id      = $id;
			$TestReg->patient_fees     = $PatientLoad;
			$TestReg->insurance_fees   = $InsuranceLoad;
			$TestReg->user_id          ='1';
			$TestReg->save();
			}
			$MegaTestsChild = MegaTestsChildModel::whereIn('megatest_id',$request->megatest_id)->where('active',true)->get();

			// dd($TestIDs);

			// dd($MegaTestsChild);

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

			}}

			if ($group_check){
				foreach($request->grouptest_id as $id){
				$GroupTestCheck    = GroupTestsChildModel::where('grouptest_id',$id)->first();
				// dd($GroupTestCheck);
				$PriceListsTests   = PriceListsTestsModel::where('grouptest_id',$id)->where('pricelist_id',$RelativePriceLists->pricelist_id)->first();
				$PatientLoad       = $PriceListsTests->price * $RelativePriceLists->patient_load;
				$InsuranceLoad     = $PriceListsTests->price * $RelativePriceLists->insurance_load;
				if (TestEntryModel::where('regkey',$user->id)->where('test_id',$GroupTestCheck->test_id)->exists()){
				}else{
				$TestReg  = new TestRegModel();
				$TestReg->regkey           = $user->id;
				$TestReg->grouptest_id     = $id;
				$TestReg->patient_fees     = $PatientLoad;
				$TestReg->insurance_fees   = $InsuranceLoad;
				$TestReg->user_id          ='1';
				$TestReg->save();
				}}
				$GroupTestsChild = GroupTestsChildModel::whereIn('grouptest_id',$request->grouptest_id)->where('active',true)->get();
	
				// dd($TestIDs);
	
				// dd($MegaTestsChild);
	
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
	
				}}


			if ($test_check){
				foreach($request->test_id as $testid){
					$PriceListsTests   = PriceListsTestsModel::where('test_id',$testid)->where('pricelist_id',$RelativePriceLists->pricelist_id)->first();
					$PatientLoad       = $PriceListsTests->price * $RelativePriceLists->patient_load;
					$InsuranceLoad     = $PriceListsTests->price * $RelativePriceLists->insurance_load;
			if (TestEntryModel::where('regkey',$user->id)->where('test_id',$testid)->exists()){
			}else{
					$TestReg  = new TestRegModel();
					$TestReg->regkey           = $user->id;
					$TestReg->megatest_id      = null;
					$TestReg->test_id          = $testid;
					$TestReg->patient_fees     = $PatientLoad;
					$TestReg->insurance_fees   = $InsuranceLoad;
					$TestReg->user_id          ='1';
					$TestReg->save();
					}}
					$TestIDs        = TestDataModel::whereIn('test_id',$request->test_id)->get();

					foreach($TestIDs as $test_id){
	
						$AntibioticEntry  = AntibioticEntryModel::get();
						$TestData         = TestDataModel::where('test_id',$test_id->test_id)->first();
						$CultureData      = TestDataModel::whereNotNull('culture_link')->where('test_id',$test_id->test_id)->first();
						$ResultsUnits     = ResultsUnitsModel::where('resultunit_id',$TestData->unit)->first();
						// $NormalRanges     = NormalRangesModel::Where('test_id',$test_id->test_id)->Where('age_from','<=',$user->ag)->Where('age_to','>=',$user->ag)->Where('age',$user->age)->Where('gender',$user->gender)->Where('active',True)->first();
			

					// dd($month);
						$age_total      = $user->age_y*365 + $user->age_m*30 + $user->age_d;
						$normal_age     = NormalRangesModel::Where('test_id',$test_id->test_id)->Where('age_from_total','<=',$age_total)->Where('age_to_total','>=',$age_total)->Where('gender',$user->gender)->Where('active',True)->first();
						
						// dd($normal_age);

						if ($CultureData){
							$newAntibioticEntry  = new AntibioticEntryModel();
							$newAntibioticEntry->regkey         = $user->id;
							$newAntibioticEntry->culture_link   = $CultureData->culture_link;
							$newAntibioticEntry->antibiotic_id  = null;
							$newAntibioticEntry->sensitivity    = null;
		
							$newAntibioticEntry->save();
						}
						if (TestEntryModel::where('regkey',$user->id)->where('test_id',$test_id->test_id)->exists()){
						}else{
						$TestEntry     = new TestEntryModel();
						$SampleID      = $user->id.''.$TestData->test_group.''.'0';
						// dd($CultureData);
						$TestEntry->regkey            = $user->id;
						$TestEntry->test_id           = $test_id->test_id;
						$TestEntry->megatest_id       = null;
						$TestEntry->sample_id         = $SampleID;
						$TestEntry->unit              = $TestData->unit? $ResultsUnits->result_unit : Null;
						$TestEntry->result            = $TestData->default_value? $TestData->default_value : Null;
						$TestEntry->low               = isset($normal_age['test_id']) ? $normal_age->low : Null;
						$TestEntry->high              = isset($normal_age['test_id']) ? $normal_age->high : Null;
						$TestEntry->nn_normal         = isset($normal_age['test_id']) ? $normal_age->nn_normal : Null;
						$TestEntry->save();
		
						}
		
					}}
			
	

			// $PSA_T    = TestEntryModel::where('test_id','=','318')->first();
			// $PSA_F    = TestEntryModel::where('test_id','=','319')->first();
			// $NRPSA    = NormalRangesModel::Where('test_id','=','320')->Where('age_from','<=',$user->ag)->Where('age_to','>=',$user->ag)->Where('age',$user->age)->Where('gender',$user->gender)->Where('active',True)->first();
			// $TestDataPSA     = TestDataModel::where('test_id','=','320')->first();
			// $ResultsUnitsPSA = ResultsUnitsModel::where('resultunit_id',$TestDataPSA->unit)->first();
			
			
// 			if ($PSA_T && $PSA_F){

// 				$TestReg  = new TestRegModel();
// 				$TestReg->regkey           = $user->id;
// 				$TestReg->megatest_id      = null;
// 				$TestReg->patient_fees     = null;
// 				$TestReg->insurance_fees   = null;
// 				$TestReg->user_id          ='1';
// 				$TestReg->save();

// 				$TestEntry     = new TestEntryModel();
// 				$SampleID      = $user->id.''.$TestData->subgroup.''.'0';
// 				// dd($CultureData);
// 				$TestEntry->regkey            = $user->id;
// 				$TestEntry->test_id           = '320';
// 				$TestEntry->megatest_id       = null;
// 				$TestEntry->sample_id         = $SampleID;
// 				$TestEntry->unit              = $TestDataPSA->unit? $ResultsUnitsPSA->result_unit : Null;
// 				$TestEntry->result            = $TestDataPSA->default_value? $TestDataPSA->default_value : Null;
// 				$TestEntry->low               = isset($NRPSA['test_id']) ? $NRPSA->low : Null;
// 				$TestEntry->high              = isset($NRPSA['test_id']) ? $NRPSA->high : Null;
// 				$TestEntry->nn_normal         = isset($NRPSA['test_id']) ? $NRPSA->nn_normal : Null;
// 				$TestEntry->save();

// }else{

// }
			
				DB::commit();
				return redirect('transactions/'.$user->id)->with('status',"Insert successfully");
			}
			catch(Exception $e){
				DB::rollback();
				return redirect('newpatientreg')->with('failed',"operation failed");
			}
		}
    }
}