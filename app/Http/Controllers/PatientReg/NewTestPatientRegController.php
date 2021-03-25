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
use App\OutLabsModel;
use App\OutLabTestsModel;
use Carbon\Carbon;
use DB;

class NewTestPatientRegController extends Controller
{
	
    public function create(Request $request,$regkey){
		// dd($request->all());

		$rules = [
			
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
		$data = $request->except('megacheck','groupcheck','seperatecheck','megatest_name','grouptest_name','test_name');		
		// dd($data);
		// $data = $request->input();
		$RegTracking = new RegTrackingModel();
			$RegTracking->regkey              = $regkey;
			$RegTracking->user_id             = '1';
			$RegTracking->status              = 'Tests Added';

			$RegTracking->save();

				// dd($RegTracking);
    $PatientReg          = PatientRegModel::where('regkey',$regkey)->first();
	$RelativePriceLists  = RelativePriceListsModel::where('relative_pricelist_id',$PatientReg->relative_pricelist_id)->first();
				
		// dd($RelativePriceLists->relative_pricelist_id);
		$test_check      = $request->has('test_id');
		$megatest_check  = $request->has('megatest_id');
		$grouptest_check = $request->has('grouptest_id');

		// dd($test_check);
		
if ($megatest_check){
		foreach($request->megatest_id as $id){
		$MegaTest_ID       = MegaTestsModel::where('megatest_id',$id)->first();
		$LabToLabPrice     = OutLabTestsModel::where('megatest_id',$id)->where('outlab_id',$MegaTest_ID->outlab_id)->first();

		$PriceListsTests   = PriceListsTestsModel::where('megatest_id',$id)->where('pricelist_id',$RelativePriceLists->pricelist_id)->first();
		$PatientLoad       = $PriceListsTests->price * $RelativePriceLists->patient_load;
		$InsuranceLoad     = $PriceListsTests->price * $RelativePriceLists->insurance_load;
		// dd($PatientLoad);
		$TestReg  = new TestRegModel();
		$TestReg->regkey           = $regkey;
		$TestReg->megatest_id      = $id;
		$TestReg->patient_fees     = $PatientLoad ;
		$TestReg->insurance_fees   = $InsuranceLoad;
		$TestReg->outlab           = $MegaTest_ID->outlab;
		$TestReg->outlab_id        = $MegaTest_ID->outlab_id;
		$TestReg->outlab_fees      = isset($LabToLabPrice['price']) ? $LabToLabPrice->price : Null;


		$TestReg->user_id          ='1';
		// dd($TestReg->patient_fees);
		$TestReg->save();
	
		}
		$MegaTestsChild = MegaTestsChildModel::whereIn('megatest_id',$request->megatest_id)->where('active',true)->get();
		// dd($MegaTestsChild);
		foreach($MegaTestsChild as $testchild){
			$AntibioticEntry  = AntibioticEntryModel::get();
			$TestData         = TestDataModel::where('test_id',$testchild->test_id)->first();
			$CultureData      = TestDataModel::whereNotNull('culture_link')->where('test_id',$testchild->test_id)->first();
			$ResultsUnits     = ResultsUnitsModel::where('resultunit_id',$TestData->unit)->first();
			// $NormalRanges     = NormalRangesModel::Where('test_id',$testchild->test_id)->Where('age_from','<=',$PatientReg->ag)->Where('age_to','>=',$PatientReg->ag)->Where('age',$PatientReg->age)->Where('gender',$PatientReg->gender)->Where('active',True)->first();
			$age_total      = $PatientReg->age_y*365 + $PatientReg->age_m*30 + $PatientReg->age_d;
			$normal_age     = NormalRangesModel::Where('test_id',$testchild->test_id)->Where('age_from_total','<=',$age_total)->Where('age_to_total','>=',$age_total)->Where('gender',$PatientReg->gender)->Where('active',True)->first();
			
			if ($CultureData){
				$newAntibioticEntry  = new AntibioticEntryModel();
				$newAntibioticEntry->regkey         = $regkey;
				$newAntibioticEntry->culture_link   = $CultureData->culture_link;
				$newAntibioticEntry->antibiotic_id  = null;
				$newAntibioticEntry->sensitivity    = null;

				$newAntibioticEntry->save();
			}
			if (TestEntryModel::where('regkey',$regkey)->where('test_id',$testchild->test_id)->exists()){
			}else{
			$TestEntry     = new TestEntryModel();
			$SampleID      = $regkey.''.$TestData->test_group.''.'0';
			// dd($CultureData);
			$TestEntry->regkey            = $regkey;
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
		
if ($grouptest_check){
	foreach($request->grouptest_id as $groupid){
	$GroupTest_ID      = GroupTestsModel::where('grouptest_id',$groupid)->first();
	$LabToLabPrice     = OutLabTestsModel::where('grouptest_id',$groupid)->where('outlab_id',$GroupTest_ID->outlab_id)->first();

	$GroupTestCheck    = GroupTestsChildModel::where('grouptest_id',$groupid)->first();
	$PriceListsTests   = PriceListsTestsModel::where('grouptest_id',$groupid)->where('pricelist_id',$RelativePriceLists->pricelist_id)->first();
	$PatientLoad       = $PriceListsTests->price * $RelativePriceLists->patient_load;
	$InsuranceLoad     = $PriceListsTests->price * $RelativePriceLists->insurance_load;
	// dd($PatientLoad);
	if (TestEntryModel::where('regkey',$regkey)->where('test_id',$GroupTestCheck->test_id)->exists()){
	}else{
	$TestReg  = new TestRegModel();
	$TestReg->regkey           = $regkey;
	$TestReg->grouptest_id     = $groupid;
	$TestReg->patient_fees     = $PatientLoad ;
	$TestReg->insurance_fees   = $InsuranceLoad;
	$TestReg->outlab           = $GroupTest_ID->outlab;
	$TestReg->outlab_id        = $GroupTest_ID->outlab_id;
	$TestReg->outlab_fees      = isset($LabToLabPrice['price']) ? $LabToLabPrice->price : Null;

	$TestReg->user_id          ='1';
	// dd($TestReg->patient_fees);
	$TestReg->save();
	}
	}
	$GroupTestsChild = GroupTestsChildModel::whereIn('grouptest_id',$request->grouptest_id)->where('active',true)->get();
	// dd($MegaTestsChild);
	foreach($GroupTestsChild as $testchild){
		$AntibioticEntry  = AntibioticEntryModel::get();
		$TestData         = TestDataModel::where('test_id',$testchild->test_id)->first();
		$CultureData      = TestDataModel::whereNotNull('culture_link')->where('test_id',$testchild->test_id)->first();
		$ResultsUnits     = ResultsUnitsModel::where('resultunit_id',$TestData->unit)->first();
		// $NormalRanges     = NormalRangesModel::Where('test_id',$testchild->test_id)->Where('age_from','<=',$PatientReg->ag)->Where('age_to','>=',$PatientReg->ag)->Where('age',$PatientReg->age)->Where('gender',$PatientReg->gender)->Where('active',True)->first();
		$age_total      = $PatientReg->age_y*365 + $PatientReg->age_m*30 + $PatientReg->age_d;
		$normal_age     = NormalRangesModel::Where('test_id',$testchild->test_id)->Where('age_from_total','<=',$age_total)->Where('age_to_total','>=',$age_total)->Where('gender',$PatientReg->gender)->Where('active',True)->first();
		
		if ($CultureData){
			$newAntibioticEntry  = new AntibioticEntryModel();
			$newAntibioticEntry->regkey         = $regkey;
			$newAntibioticEntry->culture_link   = $CultureData->culture_link;
			$newAntibioticEntry->antibiotic_id  = null;
			$newAntibioticEntry->sensitivity    = null;

			$newAntibioticEntry->save();
		}
		if (TestEntryModel::where('regkey',$regkey)->where('test_id',$testchild->test_id)->exists()){
		}else{
		$TestEntry     = new TestEntryModel();
		$SampleID      = $regkey.''.$TestData->test_group.''.'0';
		// dd($CultureData);
		$TestEntry->regkey            = $regkey;
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
			$Test_ID           = TestDataModel::where('test_id',$testid)->first();
			$LabToLabPrice     = OutLabTestsModel::where('test_id',$testid)->where('outlab_id',$Test_ID->outlab_id)->first();

			$PriceListsTests   = PriceListsTestsModel::where('test_id',$testid)->where('pricelist_id',$RelativePriceLists->pricelist_id)->first();
			$PatientLoad       = $PriceListsTests->price * $RelativePriceLists->patient_load;
			$InsuranceLoad     = $PriceListsTests->price * $RelativePriceLists->insurance_load;
			if (TestEntryModel::where('regkey',$regkey)->where('test_id',$testid)->exists()){
			}else{
			$TestReg  = new TestRegModel();
			$TestReg->regkey           = $regkey;
			$TestReg->megatest_id      = null;
			$TestReg->test_id          = $testid;
			$TestReg->patient_fees     = $PatientLoad;
			$TestReg->insurance_fees   = $InsuranceLoad;
			$TestReg->outlab           = $Test_ID->out_lab;
			$TestReg->outlab_id        = $Test_ID->outlab_id;
			$TestReg->outlab_fees      = isset($LabToLabPrice['price']) ? $LabToLabPrice->price : Null;
			
			$TestReg->user_id          ='1';
			$TestReg->save();
			}}
			$TestIDs        = TestDataModel::whereIn('test_id',$request->test_id)->get();
				// dd($TestIDs);
			foreach($TestIDs as $test_id){

				$AntibioticEntry  = AntibioticEntryModel::get();
				$TestData         = TestDataModel::where('test_id',$test_id->test_id)->first();
				$CultureData      = TestDataModel::whereNotNull('culture_link')->where('test_id',$test_id->test_id)->first();
				$ResultsUnits     = ResultsUnitsModel::where('resultunit_id',$TestData->unit)->first();
				// $NormalRanges     = NormalRangesModel::Where('test_id',$test_id->test_id)->Where('age_from','<=',$PatientReg->ag)->Where('age_to','>=',$PatientReg->ag)->Where('age',$PatientReg->age)->Where('gender',$PatientReg->gender)->Where('active',True)->first();
				$age_total      = $PatientReg->age_y*365 + $PatientReg->age_m*30 + $PatientReg->age_d;
				$normal_age     = NormalRangesModel::Where('test_id',$test_id->test_id)->Where('age_from_total','<=',$age_total)->Where('age_to_total','>=',$age_total)->Where('gender',$PatientReg->gender)->Where('active',True)->first();
				
				if ($CultureData){
					$newAntibioticEntry  = new AntibioticEntryModel();
					$newAntibioticEntry->regkey         = $regkey;
					$newAntibioticEntry->culture_link   = $CultureData->culture_link;
					$newAntibioticEntry->antibiotic_id  = null;
					$newAntibioticEntry->sensitivity    = null;

					$newAntibioticEntry->save();
				}
				if (TestEntryModel::where('regkey',$regkey)->where('test_id',$test_id->test_id)->exists()){
				}else{
				$TestEntry     = new TestEntryModel();
				$SampleID      = $regkey.''.$TestData->test_group.''.'0';
				// dd($CultureData);
				$TestEntry->regkey            = $regkey;
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

			
			
	// 			DB::commit();
	// return redirect('patientreg')->back();
	$patientloadcheck = TestRegModel::query()->where('regkey',$regkey)->sum('patient_fees');
	// dd($patientloadcheck);
	if($patientloadcheck > 0){
		return redirect('transactions/'.$regkey)->with('status',"Tests Added");
	}else{
		return redirect('patientreg')->with('status',"Tests Added");
	}
				// return redirect('transactions/'.$regkey)->with('status',"Tests Added");
	// 		}
		}}}
    
