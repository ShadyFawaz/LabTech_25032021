<?php

namespace App\Http\Controllers\TestEntry;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\TestRegModel;
use App\PatientRegModel;
use App\MegaTestsModel;
use App\TestDataModel;
use App\SubGroupsModel;
use App\TestEntryModel;
use App\ResultTrackingModel;
use App\NewUserModel;
use App\GroupsModel;
use Spatie\Permission\Models\Permission;
use DB;


class ResultEntryController extends Controller
{
    
	public function indexMega($regkey, $group , $megatest_id , $seperate_test){
	
		$ResultEntryQuery  = TestEntryModel::query()->with('PatientReg','PatientReg.TestReg','TestData','TestData.Groups','MegaTests');
		$PatientHistoryQuery = TestEntryModel::query()->with('PatientReg','PatientReg.TestReg','TestData','TestData.Groups','MegaTests');
		$PatientIDGet = TestEntryModel::query()->with('PatientReg','PatientReg.TestReg','TestData','TestData.Groups','MegaTests')->where('regkey',$regkey)->first();
		$PatientID    = $PatientIDGet->PatientReg->patient_id;

		// dd($PatientID);

		$users  = $ResultEntryQuery->whereHas('TestData',function($qurey) use($group){
			$qurey->where('test_group',$group);
			})->where('regkey',$regkey)->where('megatest_id',$megatest_id)->where('seperate_test',$seperate_test)->get()->sortBy('TestData.test_order',SORT_REGULAR,false);
			
		$PatientHistory = $PatientHistoryQuery->whereHas('PatientReg',function($qurey) use($PatientID){
			$qurey->where('patient_id',$PatientID);
			})->where('megatest_id',$megatest_id)->where('seperate_test',$seperate_test)->get()->sortBy('TestData.test_order',SORT_REGULAR,false);

	// dd($PatientHistory);

			$CommentCheck = $users->whereNotNull('result_comment')->count();
			$ResultComment  = $ResultEntryQuery->whereHas('TestData',function($qurey) use($group){
				$qurey->where('test_group',$group);
				})->whereNotNull('result_comment')->where('regkey',$regkey)->where('megatest_id',$megatest_id)->where('seperate_test',$seperate_test)->get()->sortBy('TestData.test_order',SORT_REGULAR,false);
				
		return view('testentry/resultentry',['users'=>$users],compact('CommentCheck','ResultComment'));
		}  
	public function indexGroup($regkey, $group , $seperate_test){

		$ResultEntryQuery  = TestEntryModel::query()->with('PatientReg','PatientReg.TestReg','TestData','TestData.Groups','MegaTests');
	
		$users  = $ResultEntryQuery->whereHas('TestData',function($qurey) use($group){
			$qurey->where('test_group',$group);
			})->where('regkey',$regkey)->whereNull('megatest_id')->where('seperate_test',$seperate_test)->get()->sortBy('TestData.test_order',SORT_REGULAR,false);
			$CommentCheck = $users->whereNotNull('result_comment')->count();
			$ResultComment  = $ResultEntryQuery->whereHas('TestData',function($qurey) use($group){
				$qurey->where('test_group',$group);
				})->whereNotNull('result_comment')->where('regkey',$regkey)->where('seperate_test',$seperate_test)->get()->sortBy('TestData.test_order',SORT_REGULAR,false);
				// dd($ResultComment);
		return view('testentry/resultentry',['users'=>$users],compact('CommentCheck','ResultComment'));
		}  
	
		
		public function editGroup(Request $request,$regkey,$group,$seperate_test) {

	$resulttracking = TestEntryModel::query()
	->where('regkey',$regkey)
	->where('seperate_test',$seperate_test)
	->whereHas('TestData',function($qurey) use($group){
		$qurey->where('test_group',$group);
		})->get();

		// dd($resulttracking);

			$Results       = $request->except('_token','_method');
			$ResultsCount  = count($request->only('result')); 
		DB::beginTransaction();
		// dd($Results);
        foreach ($Results['result'] as $i=> $result) {
			// $ResultTracking = new ResultTrackingModel();
			// 	 	$ResultTracking->result_id   = $Results->result_id;
			// 		$ResultTracking->regkey      = '1';
			// 		$ResultTracking->user_id     = '1';
			// 		$ResultTracking->test_id     = '1';
			// 		$ResultTracking->result      = null;
			// 		$ResultTracking->save();
			// dd($i);
			$ResultInput      = $Results['result'][$i];
			$Low              = $Results['low'][$i];
			$High             = $Results['high'][$i];
			$NN_Normal        = $Results['nn_normal'][$i];
			$Flag             = $Results['flag'][$i];
			$Unit             = $Results['unit'][$i];
			$ResultComment    = $Results['result_comment'][$i];
			$ReportPrinted    = isset($Results['report_printed'][$i]) ? $Results['report_printed'][$i] : false;
			$SeperateTest     = isset($Results['seperate_test'][$i]) && ($Results['active'][$i] == '1') ? $Results['test_id'][$i] : '0';
		
			$SampleID         = $regkey.''.$group.''.$SeperateTest; 
// dd($SampleID);
			$TestEntry = TestEntryModel::query()->where('result_id',$i)->update(
				[
					'result'         =>$ResultInput,
					'low'            =>$Low,
					'high'           =>$High,
					'nn_normal'      =>$NN_Normal,
					'flag'           =>$Flag,
					'unit'           =>$Unit,
					'result_comment' =>$ResultComment,
					'report_printed' =>$ReportPrinted,
					'seperate_test'  =>$SeperateTest,
					'sample_id'      =>$SampleID,
					// 'completed'      =>isset($ResultInput) ? "1":"0" ,
			]
				
			);
			
        }
    // when done commit
DB::commit();
	
foreach($resulttracking as $result){
	$resultcheck = TestEntryModel::query()->where('result_id',$result->result_id)->where('result',$result->result)->exists();
	$newresult = TestEntryModel::query()->where('result_id',$result->result_id)->first();
	// dd($result);
	// dd($newresult);
// dd($resultcheck);
if($resultcheck){
}else{
	$tracking  = new ResultTrackingModel();
		$tracking->result_id    = $result->result_id;
		$tracking->regkey       = $result->regkey;
		$tracking->test_id      = $result->test_id;
		$tracking->result       = $newresult->result;
		$tracking->user_id      = '1';
		$tracking->modify_time  = now();
		$tracking->save();
}}


// BUN Calculations
$Urea  = TestEntryModel::where('regkey',$regkey)->where('test_id','=','428')->first();
$BUN   = TestEntryModel::where('regkey',$regkey)->where('test_id','=','721')->first();

if ($BUN){
if ($BUN->result == '.'){	
}else{
if (isset($Urea->result) && $Urea->result <>'.'){
$bun = $Urea->result / 2.14;
if($BUN->low && $BUN->high){
if ($bun < $BUN->low){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','721')->where('verified','=','0')->update([
		'result' => round($bun,1),
		'flag' => 'L'
		]);
	}elseif($bun > $BUN->high){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','721')->where('verified','=','0')->update([
		'result' => round($bun,1),
	  'flag' => 'H'
  ]);
}elseif($bun >= $BUN->low && $bun <= $BUN->high){
TestEntryModel::where('regkey',$regkey)->where('test_id','=','721')->where('verified','=','0')->update([
'result' => round($bun,1),
  'flag' => null
]);
}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','721')->where('verified','=','0')->update([
		'result' => round($bun,1)
	  ]);
}}}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','721')->where('verified','=','0')->update([
		'result' => null
	  ]);	
}

// Bilirubin Calculations
$TBIL  = TestEntryModel::where('regkey',$regkey)->where('test_id','=','97')->first();
$DBIL  = TestEntryModel::where('regkey',$regkey)->where('test_id','=','98')->first();
$INBIL = TestEntryModel::where('regkey',$regkey)->where('test_id','=','444')->first();

if ($INBIL){
if ($INBIL->result == '.'){	
}else{
if (isset($TBIL->result ,$DBIL->result)
&& $TBIL->result <>'.' && $DBIL->result <>'.'){
$inbil = $TBIL->result - $DBIL->result;
if($INBIL->low && $INBIL->high){
if ($inbil < $INBIL->low){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','444')->where('verified','=','0')->update([
		'result' => round($inbil,2),
		'flag' => 'L'
		]);
	}elseif($inbil > $INBIL->high){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','444')->where('verified','=','0')->update([
		'result' => round($inbil,2),
	  'flag' => 'H'
  ]);
}elseif($inbil >= $INBIL->low && $inbil <= $INBIL->high){
TestEntryModel::where('regkey',$regkey)->where('test_id','=','444')->where('verified','=','0')->update([
'result' => round($inbil,2),
  'flag' => null
]);
}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','444')->where('verified','=','0')->update([
		'result' => round($inbil,2)
	  ]);
}}}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','444')->where('verified','=','0')->update([
		'result' => null
	  ]);	
}

// PSA Calculations
$TPSA  = TestEntryModel::where('regkey',$regkey)->where('test_id','=','318')->first();
$FPSA  = TestEntryModel::where('regkey',$regkey)->where('test_id','=','319')->first();
$PSA_R = TestEntryModel::where('regkey',$regkey)->where('test_id','=','320')->first();

if ($PSA_R){
if ($PSA_R->result == '.'){	
}else{
if (isset($TPSA->result ,$FPSA->result)
&& $TPSA->result <>'.' && $TPSA->result <>'.'){
$psa_r = $FPSA->result / $TPSA->result;
TestEntryModel::where('regkey',$regkey)->where('test_id','=','320')->where('verified','=','0')->update([
	'result' => round($psa_r,2)
]);
}else{
TestEntryModel::where('regkey',$regkey)->where('test_id','=','320')->where('verified','=','0')->update([
		'result' => null
	]);
}}}

// Ratio Calculations
$Alb_Ratio    = TestEntryModel::where('regkey',$regkey)->where('test_id','=','13')->first();
$Creat_Ratio  = TestEntryModel::where('regkey',$regkey)->where('test_id','=','14')->first();
$Alb_Creat    = TestEntryModel::where('regkey',$regkey)->where('test_id','=','15')->first();

$Alb_Micro    = TestEntryModel::where('regkey',$regkey)->where('test_id','=','16')->first();
$Creat_Micro  = TestEntryModel::where('regkey',$regkey)->where('test_id','=','17')->first();
$MicroAlb     = TestEntryModel::where('regkey',$regkey)->where('test_id','=','18')->first();
// dd($Alb_Creat);
if ($Alb_Creat){
if ($Alb_Creat->result == '.'){	
}else{
if (isset($Alb_Ratio->result ,$Creat_Ratio->result) 
&& $Alb_Ratio->result <>'.' && $Creat_Ratio->result <>'.'){
$alb_creat = ($Alb_Ratio->result / $Creat_Ratio->result) * 100;
TestEntryModel::where('regkey',$regkey)->where('test_id','=','15')->where('verified','=','0')->update([
	'result' => round($alb_creat,2)
]);
}else{
TestEntryModel::where('regkey',$regkey)->where('test_id','=','15')->where('verified','=','0')->update([
		'result' => null
	]);
}}}



if ($MicroAlb){
if ($MicroAlb->result == '.'){	
}else{
if (isset($Alb_Micro->result ,$Creat_Micro->result)
&& $Alb_Micro->result <>'.' && $Creat_Micro->result <>'.'){
$microalb = ($Alb_Micro->result / $Creat_Micro->result) * 100;
TestEntryModel::where('regkey',$regkey)->where('test_id','=','18')->where('verified','=','0')->update([
	'result' => round($microalb,2)
]);
}else{
TestEntryModel::where('regkey',$regkey)->where('test_id','=','18')->where('verified','=','0')->update([
		'result' => null
	]);
}}}



// Lipids Calculation
$TG     = TestEntryModel::where('regkey',$regkey)->where('test_id','=','423')->first();
$CHOL   = TestEntryModel::where('regkey',$regkey)->where('test_id','=','420')->first();
$HDL    = TestEntryModel::where('regkey',$regkey)->where('test_id','=','268')->first();
$LDL    = TestEntryModel::where('regkey',$regkey)->where('test_id','=','290')->first();
$VLDL   = TestEntryModel::where('regkey',$regkey)->where('test_id','=','434')->first();
$Risk1  = TestEntryModel::where('regkey',$regkey)->where('test_id','=','445')->first();
$Risk2  = TestEntryModel::where('regkey',$regkey)->where('test_id','=','446')->first();
// dd($HDL);
if ($LDL){
if ($LDL->result == '.'){	
}else{
if (isset($TG->result ,$CHOL->result ,$HDL->result)
&& $TG->result <>'.' && $CHOL->result <>'.' && $HDL->result<>'.'){
$ldl = $CHOL->result - ($HDL->result +($TG->result / 5))  ;
if($LDL->low && $LDL->high){
if ($ldl < $LDL->low){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','290')->where('verified','=','0')->update([
		'result' => round($ldl,0),
		'flag' => 'L'
		]);
	}elseif($ldl > $LDL->high){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','290')->where('verified','=','0')->update([
		'result' => round($ldl,0),
	  'flag' => 'H'
  ]);
}elseif($ldl >= $LDL->low && $inbil <= $LDL->high){
TestEntryModel::where('regkey',$regkey)->where('test_id','=','290')->where('verified','=','0')->update([
'result' => round($ldl,0),
  'flag' => null
]);
}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','290')->where('verified','=','0')->update([
		'result' => round($ldl,0)
	  ]);
}}}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','290')->where('verified','=','0')->update([
		'result' => null
	  ]);	
}



if ($VLDL){
	if ($VLDL->result == '.'){	
	}else{	
if (isset($TG->result) && $TG->result <>'.'){
	$vldl = ($TG->result / 5);
	if($VLDL->low && $VLDL->high){
	if ($vldl < $VLDL->low){
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','434')->where('verified','=','0')->update([
			'result' => round($vldl,0),
			'flag' => 'L'
			]);
		}elseif($vldl > $VLDL->high){
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','434')->where('verified','=','0')->update([
			'result' => round($vldl,0),
		  'flag' => 'H'
	  ]);
  }elseif($vldl >= $VLDL->low && $vldl <= $VLDL->high){
  TestEntryModel::where('regkey',$regkey)->where('test_id','=','434')->where('verified','=','0')->update([
	'result' => round($vldl,0),
	  'flag' => null
  ]);
}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','434')->where('verified','=','0')->update([
		'result' => round($vldl,0)
	  ]);
}}}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','434')->where('verified','=','0')->update([
		'result' => null
	  ]);	
}

if ($Risk1){
	if ($Risk1->result == '.'){	
	}else{
	if (isset($CHOL->result ,$HDL->result)
&& $HDL->result <>'.' && $CHOL->result <>'.'){
		$risk1 = ($CHOL->result / $HDL->result);
		if ($Risk1->low && $Risk1->high ){
		if ($risk1 < $Risk1->low){
			TestEntryModel::where('regkey',$regkey)->where('test_id','=','445')->where('verified','=','0')->update([
				'result' => round($risk1,2),
				'flag' => 'L'
				]);
			}elseif($risk1 > $Risk1->high){
			TestEntryModel::where('regkey',$regkey)->where('test_id','=','445')->where('verified','=','0')->update([
				'result' => round($risk1,2),
			  'flag' => 'H'
		  ]);
	  }elseif($risk1 >= $Risk1->low && $risk1 <= $Risk1->high){
	  TestEntryModel::where('regkey',$regkey)->where('test_id','=','445')->where('verified','=','0')->update([
		'result' => round($risk1,2),
		  'flag' => null
	  ]);
	}}else{
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','445')->where('verified','=','0')->update([
			'result' => round($risk1,2)
		  ]);
	}}}}else{
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','445')->where('verified','=','0')->update([
			'result' => null
		  ]);	
	}


$LDL2    = TestEntryModel::where('regkey',$regkey)->where('test_id','=','290')->first();
// dd($LDL2);
if ($Risk2){
	if ($Risk2->result == '.'){	
	}else{
	if (isset($LDL2->result ,$HDL->result)
	&& $LDL2->result <>'.' && $HDL->result <>'.'){
		$risk2 = ($LDL2->result / $HDL->result);
		if ($Risk2->low && $Risk2->high){
		if ($risk2 < $Risk2->low){
			TestEntryModel::where('regkey',$regkey)->where('test_id','=','446')->where('verified','=','0')->update([
				'result' => round($risk2,2),
				'flag' => 'L'
				]);
			}elseif($risk2 > $Risk2->high){
			TestEntryModel::where('regkey',$regkey)->where('test_id','=','446')->where('verified','=','0')->update([
				'result' => round($risk2,2),
			  'flag' => 'H'
		  ]);
	  }elseif($risk2 >= $Risk2->low && $risk2 <= $Risk2->high){
	  TestEntryModel::where('regkey',$regkey)->where('test_id','=','446')->where('verified','=','0')->update([
		'result' => round($risk2,2),
		  'flag' => null
	  ]);
	}}else{
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','446')->where('verified','=','0')->update([
			'result' => round($risk2,2)
		  ]);
	}}}}else{
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','446')->where('verified','=','0')->update([
			'result' => null
		  ]);	
	}

	// PT Calculation
$PT       = TestEntryModel::where('regkey',$regkey)->where('test_id','=','360')->first();
$Control  = TestEntryModel::where('regkey',$regkey)->where('test_id','=','361')->first();
$Conc     = TestEntryModel::where('regkey',$regkey)->where('test_id','=','362')->first();
$INR      = TestEntryModel::where('regkey',$regkey)->where('test_id','=','363')->first();

if ($Conc){
	if ($Conc->result == '.'){	
	}else{
if (isset($PT->result ,$Control->result)){
$conc = ($Control->result / $PT->result) * 100 ;
if($Conc->low && $Conc->high){
if ($conc < $Conc->low){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','362')->where('verified','=','0')->update([
		'result' => round($conc,2),
		'flag' => 'L'
		]);
	}elseif($conc > $Conc->high){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','362')->where('verified','=','0')->update([
		'result' => round($conc,2),
	  'flag' => 'H'
  ]);
}elseif($conc >= $Conc->low && $conc <= $Conc->high){
TestEntryModel::where('regkey',$regkey)->where('test_id','=','362')->where('verified','=','0')->update([
'result' => round($conc,2),
  'flag' => null
]);
}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','362')->where('verified','=','0')->update([
		'result' => round($conc,2)
	  ]);
}}}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','362')->where('verified','=','0')->update([
		'result' => null
	  ]);	
}
if ($INR){
	if ($INR->result == '.'){	
	}else{
if (isset($PT->result ,$Control->result)){
$inr = (($PT->result / $Control->result));
if($INR->low && $INR->high){
if ($inr < $INR->low){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','363')->where('verified','=','0')->update([
		'result' => round($inr,2),
		'flag' => 'L'
		]);
	}elseif($inr > $INR->high){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','363')->where('verified','=','0')->update([
		'result' => round($inr,2),
	  'flag' => 'H'
  ]);
}elseif($inr >= $INR->low && $inr <= $INR->high){
TestEntryModel::where('regkey',$regkey)->where('test_id','=','363')->where('verified','=','0')->update([
'result' => round($inr,2),
  'flag' => null
]);
}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','363')->where('verified','=','0')->update([
		'result' => round($inr,2)
	  ]);
}}}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','363')->where('verified','=','0')->update([
		'result' => null
	  ]);	
}

//  CBC Calculations
$HB           = TestEntryModel::where('regkey',$regkey)->where('test_id','=','564')->first();
$RBC          = TestEntryModel::where('regkey',$regkey)->where('test_id','=','565')->first();
$HCT          = TestEntryModel::where('regkey',$regkey)->where('test_id','=','566')->first();
$MCV          = TestEntryModel::where('regkey',$regkey)->where('test_id','=','567')->first();
$MCH          = TestEntryModel::where('regkey',$regkey)->where('test_id','=','568')->first();
$MCHC         = TestEntryModel::where('regkey',$regkey)->where('test_id','=','569')->first();
$RDW          = TestEntryModel::where('regkey',$regkey)->where('test_id','=','570')->first();
$PLT          = TestEntryModel::where('regkey',$regkey)->where('test_id','=','571')->first();
$WBC          = TestEntryModel::where('regkey',$regkey)->where('test_id','=','572')->first();
$NEUT         = TestEntryModel::where('regkey',$regkey)->where('test_id','=','573')->first();
$SEGMENT      = TestEntryModel::where('regkey',$regkey)->where('test_id','=','574')->first();
$BANDS        = TestEntryModel::where('regkey',$regkey)->where('test_id','=','575')->first();
$LYMPH        = TestEntryModel::where('regkey',$regkey)->where('test_id','=','576')->first();
$MONO         = TestEntryModel::where('regkey',$regkey)->where('test_id','=','577')->first();
$EOSINO       = TestEntryModel::where('regkey',$regkey)->where('test_id','=','578')->first();
$BASO         = TestEntryModel::where('regkey',$regkey)->where('test_id','=','579')->first();
$META         = TestEntryModel::where('regkey',$regkey)->where('test_id','=','580')->first();
$MEYLO        = TestEntryModel::where('regkey',$regkey)->where('test_id','=','581')->first();
$PROMYLO      = TestEntryModel::where('regkey',$regkey)->where('test_id','=','582')->first();
$BLAST        = TestEntryModel::where('regkey',$regkey)->where('test_id','=','583')->first();
$NORMOBLAST   = TestEntryModel::where('regkey',$regkey)->where('test_id','=','584')->first();
$NEUT_        = TestEntryModel::where('regkey',$regkey)->where('test_id','=','585')->first();
$SEG_         = TestEntryModel::where('regkey',$regkey)->where('test_id','=','723')->first();
$BAND_        = TestEntryModel::where('regkey',$regkey)->where('test_id','=','724')->first();

$LYMPH_       = TestEntryModel::where('regkey',$regkey)->where('test_id','=','586')->first();
$MONO_        = TestEntryModel::where('regkey',$regkey)->where('test_id','=','587')->first();
$EOSINO_      = TestEntryModel::where('regkey',$regkey)->where('test_id','=','588')->first();
$BASO_        = TestEntryModel::where('regkey',$regkey)->where('test_id','=','589')->first();
// dd($EOSINO);


if ($MCV){
	if ($MCV->result == '.'){	
	}else{
	if (isset($HCT->result ,$RBC->result)){
	  $mcv = ($HCT->result / $RBC->result)*10 ;
	//   dd($mcv);
	if($MCV->low && $MCV->high){
	  if ($mcv < $MCV->low){
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','567')->where('verified',false)->update([
			'result' => round($mcv,1),
			'flag'   => 'L'
			]);
		}elseif($mcv > $MCV->high){
	  TestEntryModel::where('regkey',$regkey)->where('test_id','=','567')->where('verified','=','0')->update([
		  'result' => round($mcv,1),
		  'flag'   => 'H'
	  ]);
  }elseif($mcv >= $MCV->low && $mcv <= $MCV->high){
  TestEntryModel::where('regkey',$regkey)->where('test_id','=','567')->where('verified','=','0')->update([
	  'result' => round($mcv,1),
	  'flag' => null
  ]);
}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','567')->where('verified','=','0')->update([
		'result' => round($mcv,1)
	  ]);
}}}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','567')->where('verified','=','0')->update([
		'result' => null
	  ]);	
}

  if ($MCH){
	if ($MCH->result == '.'){	
	}else{
	if (isset($HB->result ,$RBC->result)){
	  $mch = ($HB->result * 10) / $RBC->result ;
	  if($MCH->low && $MCH->high){
	  if ($mch < $MCH->low){
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','568')->where('verified','=','0')->update([
			'result' => round($mch,1),
			'flag' => 'L'
			]);
		}elseif($mch > $MCH->high){
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','568')->where('verified','=','0')->update([
			'result' => round($mch,1),
		  'flag' => 'H'
	  ]);
  }elseif($mch >= $MCH->low && $mch <= $MCH->high){
  TestEntryModel::where('regkey',$regkey)->where('test_id','=','568')->where('verified','=','0')->update([
	'result' => round($mch,1),
	  'flag' => null
  ]);
  }}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','568')->where('verified','=','0')->update([
		'result' => round($mch,1)
	  ]);
}}}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','568')->where('verified','=','0')->update([
		'result' => null
	  ]);	
}

  if ($MCHC){
	if ($MCHC->result == '.'){	
	}else{
	if (isset($HB->result ,$HCT->result)){
	  $mchc = ($HB->result * 100) / $HCT->result ;
	  if($MCHC->low && $MCHC->high){

	  if ($mchc < $MCHC->low){
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','569')->where('verified','=','0')->update([
			'result' => round($mchc,1),
			'flag' => 'L'
			]);
		}elseif($mchc > $MCHC->high){
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','569')->where('verified','=','0')->update([
			'result' => round($mchc,1),
		  'flag' => 'H'
	  ]);
  }elseif($mchc >= $MCHC->low && $mchc <= $MCHC->high){
  TestEntryModel::where('regkey',$regkey)->where('test_id','=','569')->where('verified','=','0')->update([
	'result' => round($mchc,1),
	  'flag' => null
  ]);
}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','569')->where('verified','=','0')->update([
		'result' => round($mchc,1)
	  ]);
}}}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','569')->where('verified','=','0')->update([
		'result' => null
	  ]);	
}

  if ($SEGMENT){
	if ($SEGMENT->result == '.'){	
	}else{
	if (isset($BANDS->result ,$LYMPH->result ,$MONO->result ,$EOSINO->result ,$BASO->result)){
	  $seg = 100 - ($BANDS->result + $LYMPH->result + $MONO->result + $EOSINO->result + $BASO->result);
	  if($SEGMENT->low && $SEGMENT->high){
	  if ($seg < $SEGMENT->low){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','574')->where('verified','=','0')->update([
		'result' => round($seg,0),
	'flag' => 'L'
	]);
}elseif($seg > $SEGMENT->high){
TestEntryModel::where('regkey',$regkey)->where('test_id','=','574')->where('verified','=','0')->update([
	'result' => round($seg,0),
	'flag' => 'H'
]);
}elseif($seg >= $SEGMENT->low && $seg <= $SEGMENT->high){
TestEntryModel::where('regkey',$regkey)->where('test_id','=','574')->where('verified','=','0')->update([
'result' => round($seg,0),
'flag' => null
]);
}}else{
TestEntryModel::where('regkey',$regkey)->where('test_id','=','574')->where('verified','=','0')->update([
	'result' => round($seg,0)
  ]);
}}}}else{
TestEntryModel::where('regkey',$regkey)->where('test_id','=','574')->where('verified','=','0')->update([
	'result' => null
  ]);	
}
$SEGMENT2    = TestEntryModel::where('regkey',$regkey)->where('test_id','=','574')->first();
$BANDS2      = TestEntryModel::where('regkey',$regkey)->where('test_id','=','575')->first();

if ($NEUT){
	if ($NEUT->result == '.'){	
	}else{
	if (isset($SEGMENT2->result ,$BANDS->result)){
	  $neut = $SEGMENT2->result + $BANDS->result ;
	  if($NEUT->low && $NEUT->high){

	  if($NEUT->low && $NEUT->high){
	  if ($neut < $NEUT->low){
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','573')->where('verified','=','0')->update([
			'result' => round($neut,0),
			'flag' => 'L'
		]);
	}elseif($neut > $NEUT->high){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','573')->where('verified','=','0')->update([
		'result' => round($neut,0),
		'flag' => 'H'
	]);
}elseif($neut >= $NEUT->low && $neut <= $NEUT->high){
TestEntryModel::where('regkey',$regkey)->where('test_id','=','573')->where('verified','=','0')->update([
	'result' => round($neut,0),
	'flag' => null
]);
}}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','573')->where('verified','=','0')->update([
		'result' => round($neut,0)
	  ]);
}}}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','573')->where('verified','=','0')->update([
		'result' => null
	  ]);	
}

if ($SEG_){
	if ($SEG_->result == '.'){	
	}else{
	if (isset($SEGMENT2->result ,$WBC->result)){
	  $seg_ = ($SEGMENT2->result * $WBC->result) / 100 ;
	  if($SEG_->low && $SEG_->high){

	  if ($seg_ < $SEG_->low){
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','723')->where('verified','=','0')->update([
			'result' => round($seg_,0),
			'flag' => 'L'
		]);
	}elseif($seg_ > $SEG_->high){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','723')->where('verified','=','0')->update([
		'result' => round($seg_,0),
		'flag' => 'H'
	]);
}elseif($seg_ >= $SEG_->low && $seg_ <= $SEG_->high){
TestEntryModel::where('regkey',$regkey)->where('test_id','=','723')->where('verified','=','0')->update([
	'result' => round($seg_,0),
	'flag' => null
]);
}}else{
TestEntryModel::where('regkey',$regkey)->where('test_id','=','723')->where('verified','=','0')->update([
	'result' => round($seg_,0)
  ]);
}}}}else{
TestEntryModel::where('regkey',$regkey)->where('test_id','=','723')->where('verified','=','0')->update([
	'result' => null
  ]);	
}
if ($BAND_){
	if ($BAND_->result == '.'){	
	}else{
	if (isset($BANDS->result ,$WBC->result)){
	  $band_ = ($BANDS->result * $WBC->result) / 100 ;
	  if($BAND_->low && $BAND_->high){

	  if ($band_ < $BAND_->low){
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','724')->where('verified','=','0')->update([
			'result' => round($band_,0),
		'flag' => 'L'
		]);
	}elseif($band_ > $BAND_->high){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','724')->where('verified','=','0')->update([
		'result' => round($band_,0),
		'flag' => 'H'
	]);
}elseif($band_ >= $BAND_->low && $band_ <= $BAND_->high){
TestEntryModel::where('regkey',$regkey)->where('test_id','=','724')->where('verified','=','0')->update([
	'result' => round($band_,0),
	'flag' => null
]);
}}else{
TestEntryModel::where('regkey',$regkey)->where('test_id','=','724')->where('verified','=','0')->update([
	'result' => round($band_,0)
  ]);
}}}}else{
TestEntryModel::where('regkey',$regkey)->where('test_id','=','724')->where('verified','=','0')->update([
	'result' => null
  ]);	
}


$NEUT2    = TestEntryModel::where('regkey',$regkey)->where('test_id','=','573')->first();
if ($NEUT_){
	if ($NEUT_->result == '.'){	
	}else{
	if (isset($NEUT2->result ,$WBC->result)){
	  $neut_ = ($NEUT2->result * $WBC->result) / 100 ;
	  if($NEUT2->low && $NEUT2->high){

	  if ($neut_ < $NEUT2->low){
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','585')->where('verified','=','0')->update([
			'result' => round($neut_,2),
			'flag' => 'L'
		]);
	}elseif($neut_ > $NEUT2->high){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','585')->where('verified','=','0')->update([
		'result' => round($neut_,2),
		'flag' => 'H'
	]);
}elseif($neut_ >= $NEUT2->low && $neut_ <= $NEUT2->high){
TestEntryModel::where('regkey',$regkey)->where('test_id','=','585')->where('verified','=','0')->update([
	'result' => round($neut_,2),
	'flag' => null
]);
}}else{
TestEntryModel::where('regkey',$regkey)->where('test_id','=','585')->where('verified','=','0')->update([
	'result' => round($neut_,2)
  ]);
}}}}else{
TestEntryModel::where('regkey',$regkey)->where('test_id','=','585')->where('verified','=','0')->update([
	'result' => null
  ]);	
}

$LYMPH2    = TestEntryModel::where('regkey',$regkey)->where('test_id','=','576')->first();
if ($LYMPH_){
	if ($LYMPH_->result == '.'){	
	}else{
	if (isset($LYMPH2->result ,$WBC->result)){
	  $lymph_ = ($LYMPH2->result * $WBC->result) / 100 ;
	  if($LYMPH2->low && $LYMPH2->high){

	  if ($lymph_ < $LYMPH2->low){
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','586')->where('verified','=','0')->update([
			'result' => round($lymph_,2),
		'flag' => 'L'
		]);
	}elseif($lymph_ > $LYMPH2->high){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','586')->where('verified','=','0')->update([
		'result' => round($lymph_,2),
		'flag' => 'H'
	]);
}elseif($lymph_ >= $LYMPH2->low && $lymph_ <= $LYMPH2->high){
TestEntryModel::where('regkey',$regkey)->where('test_id','=','586')->where('verified','=','0')->update([
	'result' => round($lymph_,2),
	'flag' => null
]);
}}else{
TestEntryModel::where('regkey',$regkey)->where('test_id','=','586')->where('verified','=','0')->update([
	'result' => round($lymph_,2)
  ]);
}}}}else{
TestEntryModel::where('regkey',$regkey)->where('test_id','=','586')->where('verified','=','0')->update([
	'result' => null
  ]);	
}

$MONO2    = TestEntryModel::where('regkey',$regkey)->where('test_id','=','577')->first();
if ($MONO_){
	if ($MONO_->result == '.'){	
	}else{
	if (isset($MONO2->result ,$WBC->result)){
	  $mono_ = ($MONO2->result * $WBC->result) / 100 ;
	  if($MONO2->low && $MONO2->high){

	  if ($mono_ < $MONO2->low){
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','587')->where('verified','=','0')->update([
			'result' => round($mono_,2),
		'flag' => 'L'
		]);
	}elseif($mono_ > $MONO2->high){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','587')->where('verified','=','0')->update([
		'result' => round($mono_,2),
		'flag' => 'H'
	]);
}elseif($mono_ >= $MONO2->low && $mono_ <= $MONO2->high){
TestEntryModel::where('regkey',$regkey)->where('test_id','=','587')->where('verified','=','0')->update([
	'result' => round($mono_,2),
	'flag' => null
]);
}}else{
TestEntryModel::where('regkey',$regkey)->where('test_id','=','587')->where('verified','=','0')->update([
	'result' => round($mono_,2)
  ]);
}}}}else{
TestEntryModel::where('regkey',$regkey)->where('test_id','=','587')->where('verified','=','0')->update([
	'result' => null
  ]);	
}

$EOSINO2    = TestEntryModel::where('regkey',$regkey)->where('test_id','=','578')->first();
if ($EOSINO_){
	if ($EOSINO_->result == '.'){	
	}else{
	if (isset($EOSINO2->result ,$WBC->result)){
	  $eosino_ = ($EOSINO2->result * $WBC->result) / 100 ;
	  if($EOSINO2->low && $EOSINO2->high){

	  if ($eosino_ < $EOSINO2->low){
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','588')->where('verified','=','0')->update([
			'result' => round($eosino_,2),
		'flag' => 'L'
		]);
	}elseif($eosino_ > $EOSINO2->high){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','588')->where('verified','=','0')->update([
		'result' => round($eosino_,2),
		'flag' => 'H'
	]);
}elseif($eosino_ >= $EOSINO2->low && $eosino_ <= $EOSINO2->high){
TestEntryModel::where('regkey',$regkey)->where('test_id','=','588')->where('verified','=','0')->update([
	'result' => round($eosino_,2),
	'flag' => null
]);
	
}}else{
TestEntryModel::where('regkey',$regkey)->where('test_id','=','588')->where('verified','=','0')->update([
	'result' => round($eosino_,2)
  ]);
}}}}else{
TestEntryModel::where('regkey',$regkey)->where('test_id','=','588')->where('verified','=','0')->update([
	'result' => null
  ]);	
}

$BASO2    = TestEntryModel::where('regkey',$regkey)->where('test_id','=','579')->first();
if ($BASO_){
	if ($BASO_->result == '.'){	
	}else{
	if (isset($BASO2->result ,$WBC->result)){
	  $baso_ = ($BASO2->result * $WBC->result) / 100 ;
	  if($BASO2->low && $BASO2->high){

	  if ($baso_ < $BASO2->low){
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','589')->where('verified','=','0')->update([
			'result' => round($baso_,2),
		'flag' => 'L'
		]);
	}elseif($baso_ > $BASO2->high){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','589')->where('verified','=','0')->update([
		'result' => round($baso_,2),
		'flag' => 'H'
	]);
}elseif($baso_ >= $BASO2->low && $baso_ <= $BASO2->high){
TestEntryModel::where('regkey',$regkey)->where('test_id','=','589')->where('verified','=','0')->update([
	'result' => round($baso_,2),
	'flag' => null
]);
	
}}else{
TestEntryModel::where('regkey',$regkey)->where('test_id','=','589')->where('verified','=','0')->update([
	'result' => round($baso_,2)
  ]);
}}}}else{
TestEntryModel::where('regkey',$regkey)->where('test_id','=','589')->where('verified','=','0')->update([
	'result' => null
  ]);	
}


// if ($megatest_id == 405){

// // CBC Comments 
// // dd($HB);
// $MCV2    = TestEntryModel::where('regkey',$regkey)->where('test_id','=','567')->first();
// $MCH2    = TestEntryModel::where('regkey',$regkey)->where('test_id','=','568')->first();

// if ((!$HB->result) 
// &&(!$RBC->result) 
// &&(!$HCT->result) 
// && (!$MCV2->result)
// && (!$MCH2->result) 
// && (!$RDW->result)){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
// 		'result_comment' => null
// 	]);
// }

// if (($HB->result >= $HB->low && $HB->result <= $HB->high) 
// && ($MCV2->result >= $MCV2->low  && $MCV2->result <= $MCV2->high)
// && ($MCH2->result >= $MCH2->low  && $MCH2->result <= $MCH2->high) 
// && ($RDW->result >= $RDW->low && $RDW->result <= $RDW->high)){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'RBCs : Normocytic Normochromic cells'
// 	]);
// }

// if (($HB->result >= $HB->low && $HB->result <= $HB->high) 
// && ($MCV2->result < $MCV2->low  && $MCV2->result > 0)
// && ($MCH2->result >= $MCH2->low  && $MCH2->result <= $MCH2->high)
// && ($RDW->result >= $RDW->low && $RDW->result <= $RDW->high)){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'RBCs : Microcytic normochromic cells'
// 	]);
// }

// if (($HB->result >= $HB->low && $HB->result <= $HB->high) 
// && ($MCV2->result >= $MCV2->low  && $MCV2->result <= $MCV2->high)
// && ($MCH2->result < $MCH2->low  && $MCH2->result > 0)
// && ($RDW->result >= $RDW->low && $RDW->result <= $RDW->high)){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'RBCs : Normocytic hypochromic cells'
// 	]);
// }

// if (($HB->result >= $HB->low && $HB->result <= $HB->high) 
// && ($MCV2->result < $MCV2->low  && $MCV2->result > 0)
// && ($MCH2->result < $MCH2->low  && $MCH2->result > 0)
// && ($RDW->result >= $RDW->low && $RDW->result <= $RDW->high)){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'RBCs : Microcytic hypochromic cells'
// 	]);
// }

// if (($HB->result >= $HB->low && $HB->result <= $HB->high) 
// && ($MCV2->result >= $MCV2->low  && $MCV2->result <= $MCV2->high)
// && ($MCH2->result >= $MCH2->low  && $MCH2->result <= $MCH2->high) 
// && ($RDW->result > $RDW->high)){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'RBCs : Normocytic Normochromic cells with anisocytosis'
// 	]);
// }

// if (($HB->result >= $HB->low && $HB->result <= $HB->high) 
// && ($MCV2->result >= $MCV2->low  && $MCV2->result <= $MCV2->high)
// && ($MCH2->result < $MCH2->low  && $MCH2->result > 0)
// && ($RDW->result > $RDW->high)){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'RBCs : Normocytic hypochromic cells with anisocytosis'
// 	]);
// }


// if (($HB->result >= $HB->low && $HB->result <= $HB->high) 
// && ($MCV2->result < $MCV2->low  && $MCV2->result > 0)
// && ($MCH2->result >= $MCH2->low  && $MCH2->result <= $MCH2->high) 
// && ($RDW->result > $RDW->high)){
// TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'RBCs : Microcytic normochromic cells with anisocytosis'
// 	]);
// }
// if (($HB->result >= $HB->low && $HB->result <= $HB->high) 
// && ($MCV2->result < $MCV2->low  && $MCV2->result > 0)
// && ($MCH2->result < $MCH2->low  && $MCH2->result > 0)
// && ($RDW->result > $RDW->high)){
// TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'RBCs : Microcytic hypochromic cells with anisocytosis'
// 	]);
// }


// if (($HB->result < $HB->low && $HB->result >= $HB->low  - 3) 
// && ($MCV2->result < $MCV2->low && $MCV2->result > 0) 
// && ($MCH2->result < $MCH2->low && $MCV2->result > 0 ) 
// && ($RDW->result >= $RDW->low && $RDW->result <= $RDW->high)){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'RBCs : Mild microcytic hypochromic anemia'
// 	]);
// }

// if (($HB->result < $HB->low && $HB->result >= $HB->low  - 3) 
// && ($MCV2->result <= $MCV2->high && $MCV2->result >= $MCV2->low) 
// && ($MCH2->result < $MCH2->low) && ($RDW->result >= $RDW->low && $RDW->result < $RDW->low)){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'RBCs : Mild normocytic hypochromic anemia'
// 	]);
// }

// if (($HB->result < $HB->low && $HB->result >= $HB->low  - 3) 
// && ($MCV2->result < $MCV2->low && $MCV2->result > 0) 
// && ($MCH2->result >= $MCH2->low && $MCH2->result <= $MCH2->high) 
// && ($RDW->result >= $RDW->low && $RDW->result <= $RDW->high)){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'RBCs : Mild microcytic normochromic anemia'
// 	]);
// }


// if (($HB->result < $HB->low - 3 && $HB->result >= $HB->low  - 6) 
// && ($MCV2->result < $MCV2->low && $MCV2->result > 0) 
// && ($MCH2->result < $MCH2->low && $MCH2->result > 0) 
// && ($RDW->result >= $RDW->low && $RDW->result <= $RDW->high)){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'RBCs : Moderate microcytic hypochromic anemia'
// 	]);
// }

// if (($HB->result < $HB->low - 3 && $HB->result >= $HB->low  - 6) 
// && ($MCV2->result <= $MCV2->high && $MCV2->result >= $MCV2->low) 
// && ($MCH2->result < $MCH2->low && $MCH2->result > 0) 
// && ($RDW->result >= $RDW->low && $RDW->result <= $RDW->high)){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'RBCs : Moderate normocytic hypochromic anemia'
// 	]);
// }

// if (($HB->result < $HB->low - 3 && $HB->result >= $HB->low  - 6) 
// && ($MCV2->result < $MCV2->low && $MCH2->result > 0) 
// && ($MCH2->result >= $MCH2->low && $MCH2->result <= $MCH2->high) 
// && ($RDW->result >= $RDW->low && $RDW->result <= $RDW->high)){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'RBCs : Moderate microcytic normochromic anemia'
// 	]);
// }


// if (($HB->result < $HB->low - 6)  
// && ($MCV2->result < $MCV2->low && $MCV2->result > 0) 
// && ($MCH2->result < $MCH2->low && $MCH2->result > 0) 
// && ($RDW->result >= $RDW->low && $RDW->result <= $RDW->high)){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'RBCs : Marked microcytic hypochromic anemia'
// 	]);
// }

// if (($HB->result < $HB->low - 6)  
// && ($MCV2->result <= $MCV2->high && $MCV2->result >= $MCV2->low) 
// && ($MCH2->result < $MCH2->low && $MCH2->result > 0)
// && ($RDW->result >= $RDW->low && $RDW->result <= $RDW->high)){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'RBCs : Marked normocytic hypochromic anemia'
// 	]);
// }

// if (($HB->result < $HB->low - 6)  
// && ($MCV2->result < $MCV2->low && $MCV2->result > 0) 
// && ($MCH2->result >= $MCH2->low && $MCH2->result <= $MCH2->high)
// && ($RDW->result >= $RDW->low && $RDW->result <= $RDW->high)){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'RBCs : Marked microcytic normochromic anemia'
// 	]);
// }



// if (($HB->result < $HB->low && $HB->result >= $HB->low  - 3) 
// && ($MCV2->result < $MCV2->low && $MCV2->result > 0) 
// && ($MCH2->result < $MCH2->low && $MCH2->result > 0) 
// && ($RDW->result > $RDW->high)){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'RBCs : Mild microcytic hypochromic anemia with anisocytosis'
// 	]);
// }

// if (($HB->result < $HB->low && $HB->result >= $HB->low  - 3) 
// && ($MCV2->result <= $MCV2->high && $MCV2->result >= $MCV2->low) 
// && ($MCH2->result < $MCH2->low && $MCH2->result > 0) 
// && ($RDW->result > $RDW->high)){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'RBCs : Mild normocytic hypochromic anemia with anisocytosis'
// 	]);
// }

// if (($HB->result < $HB->low && $HB->result >= $HB->low  - 3) 
// && ($MCV2->result < $MCV2->low && $MCV2->result > 0) 
// && ($MCH2->result >= $MCH2->low && $MCH2->result <= $MCH2->high) 
// && ($RDW->result > $RDW->high)){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'RBCs : Mild microcytic normochromic anemia with anisocytosis'
// 	]);
// }


// if (($HB->result < $HB->low - 3 && $HB->result >= $HB->low  - 6) 
// && ($MCV2->result < $MCV2->low && $MCV2->result > 0) 
// && ($MCH2->result < $MCH2->low && $MCH2->result > 0) 
// && ($RDW->result > $RDW->high)){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'RBCs : Moderate microcytic hypochromic anemia with anisocytosis'
// 	]);
// }

// if (($HB->result < $HB->low - 3 && $HB->result >= $HB->low  - 6) 
// && ($MCV2->result <= $MCV2->high && $MCV2->result >= $MCV2->low) 
// && ($MCH2->result < $MCH2->low && $MCH2->result > 0) 
// && ($RDW->result > $RDW->high)){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'RBCs : Moderate normocytic hypochromic anemia with anisocytosis'
// 	]);
// }

// if (($HB->result < $HB->low - 3 && $HB->result >= $HB->low  - 6) 
// && ($MCV2->result < $MCV2->low && $MCV2->result > 0) 
// && ($MCH2->result >= $MCH2->low && $MCH2->result <= $MCH2->high) 
// && ($RDW->result > $RDW->high)){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'RBCs : Moderate microcytic normochromic anemia with anisocytosis'
// 	]);
// }


// if (($HB->result < $HB->low - 6)  
// && ($MCV2->result < $MCV2->low && $MCV2->result > 0) 
// && ($MCH2->result < $MCH2->low && $MCH2->result > 0) 
// && ($RDW->result > $RDW->high)){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'RBCs : Marked microcytic hypochromic anemia with anisocytosis'
// 	]);
// }

// if (($HB->result < $HB->low - 6)  
// && ($MCV2->result <= $MCV2->high && $MCV2->result >= $MCV2->low) 
// && ($MCH2->result < $MCH2->low)&& ($RDW->result > $RDW->high)){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'RBCs : Marked normocytic hypochromic anemia with anisocytosis'
// 	]);
// }

// if (($HB->result < $HB->low - 6)  
// && ($MCV2->result < $MCV2->low && $MCV2->result > 0) 
// && ($MCH2->result >= $MCH2->low && $MCH2->result <= $MCH2->high)
// && ($RDW->result > $RDW->high)){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'RBCs : Marked microcytic normochromic anemia with anisocytosis'
// 	]);
// }

// if (!$PLT->result ){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$PLT->test_id)->where('verified','=','0')->update([
// 		'result_comment' => null
// 	]);
// }

// if (($PLT->result <= $PLT->high && $PLT->result >= $PLT->low) ){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$PLT->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'PLTs : Adequate'
// 	]);
// }

// if (($PLT->result < $PLT->low && $PLT->result >= $PLT->low - 50) ){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$PLT->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'PLTs : Mild thrombocytopenia'
// 	]);
// }
// if (($PLT->result < $PLT->low - 50 && $PLT->result >= $PLT->low - 100) ){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$PLT->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'PLTs : Moderate thrombocytopenia'
// 	]);
// }
// if (($PLT->result < $PLT->low - 100 && $PLT->result > 0)){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$PLT->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'PLTs : Marked thrombocytopenia'
// 	]);
// }

// if (($PLT->result > $PLT->high && $PLT->result <= $PLT->high * 2) ){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$PLT->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'PLTs : Mild thrombocytosis'
// 	]);
// }
// if (($PLT->result > $PLT->high *2 && $PLT->result <= $PLT->high *3) ){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$PLT->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'PLTs : Moderate thrombocytosis'
// 	]);
// }
// if (($PLT->result > $PLT->high *3)){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$PLT->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'PLTs : Marked thrombocytosis'
// 	]);
// }

// $NEUT_comm  = TestEntryModel::where('regkey',$regkey)->where('test_id','=','585')->first();
// $SEG_comm   = TestEntryModel::where('regkey',$regkey)->where('test_id','=','723')->first();
// $BAND_comm  = TestEntryModel::where('regkey',$regkey)->where('test_id','=','724')->first();

// $LYMPH_comm  = TestEntryModel::where('regkey',$regkey)->where('test_id','=','586')->first();
// $MONO_comm   = TestEntryModel::where('regkey',$regkey)->where('test_id','=','587')->first();
// $EOSINO_comm = TestEntryModel::where('regkey',$regkey)->where('test_id','=','588')->first();
// $BASO_comm   = TestEntryModel::where('regkey',$regkey)->where('test_id','=','589')->first();	
// // dd($LYMPH_comm);
// if (($WBC->result >= $WBC->low  && $WBC->result <= $WBC->high) 
// && ($NEUT_comm->result >= $NEUT_comm->low  && $NEUT_comm->result <= $NEUT_comm->high)
// && ($LYMPH_comm->result >= $LYMPH_comm->low  && $LYMPH_comm->result <= $LYMPH_comm->high)
// && ($MONO_comm->result >= $MONO_comm->low  && $MONO_comm->result <= $MONO_comm->high)
// && ($EOSINO_comm->result >= $EOSINO_comm->low  && $EOSINO_comm->result <= $EOSINO_comm->high)
// && ($BASO_comm->result >= $BASO_comm->low  && $BASO_comm->result <= $BASO_comm->high)
// ){
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$WBC->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'WBCs : Normal count and morphology'
// 	]);
// }else{
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$WBC->test_id)->where('verified','=','0')->update([
// 		'result_comment' => null
// 	]);
// }

// if ($WBC->result > $WBC->high  && $WBC->result <= $WBC->high * 2) {
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$WBC->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'WBCs : Mild Leucocytosis'
// 	]);
// }
// if ($WBC->result > $WBC->high * 2  && $WBC->result <= $WBC->high * 3) {
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$WBC->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'WBCs : Moderate Leucocytosis'
// 	]);
// }
// if ($WBC->result > $WBC->high*3 ) {
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$WBC->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'WBCs : Marked Leucocytosis'
// 	]);
// }

// if ($WBC->result < $WBC->low  && $WBC->result >= $WBC->low - 2) {
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$WBC->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'WBCs : Mild Leucopenia'
// 	]);
// }
// if ($WBC->result < $WBC->low -2  && $WBC->result >= $WBC->low - 3) {
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$WBC->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'WBCs : Moderate Leucopenia'
// 	]);}
// if ($WBC->result < $WBC->low - 3 &&  $WBC->result > 0) {
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$WBC->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'WBCs : Marked Leucopenia'
// 	]);}


// $WBCcomment = TestEntryModel::where('regkey',$regkey)->where('test_id','=','572')->first();

// if ($NEUT_comm->result < $NEUT_comm->low && $NEUT_comm->result > 0) {
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$NEUT->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'Absolute neutropenia'
// 	]);}
// if ($NEUT_comm->result > $NEUT_comm->high) {
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$NEUT->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'Absolute neutrophilia'
// 	]);}
// if ($NEUT_comm->result >= $NEUT_comm->low  && $NEUT_comm->result <= $NEUT_comm->high) {
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$NEUT->test_id)->where('verified','=','0')->update([
// 		'result_comment' => null
// 	]);}

// 	if (!$NEUT_comm->result) {
// 		TestEntryModel::where('regkey',$regkey)->where('test_id',$NEUT->test_id)->where('verified','=','0')->update([
// 			'result_comment' => null
// 		]);}

// if ($LYMPH_comm->result < $LYMPH_comm->low && $LYMPH_comm->result > 0) {
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$LYMPH->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'Absolute lymphopenia'
// 	]);}

// if ($LYMPH_comm->result > $LYMPH_comm->high) {
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$LYMPH->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'Absolute lymphocytosis'
// 	]);}
// if ($LYMPH_comm->result >= $LYMPH_comm->low  && $LYMPH_comm->result <= $LYMPH_comm->high) {
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$LYMPH->test_id)->where('verified','=','0')->update([
// 		'result_comment' => null
// 	]);}

// if (!$LYMPH_comm->result ) {
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$LYMPH->test_id)->where('verified','=','0')->update([
// 		'result_comment' => null
// 	]);}

// if ($MONO_comm->result > $MONO_comm->high) {
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$MONO->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'Absolute Mococytosis'
// 	]);}
// if ($MONO_comm->result >= $MONO_comm->low  && $MONO_comm->result <= $MONO_comm->high) {
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$MONO->test_id)->where('verified','=','0')->update([
// 		'result_comment' => null
// 	]);}

// 	if (!$MONO_comm->result) {
// 		TestEntryModel::where('regkey',$regkey)->where('test_id',$MONO->test_id)->where('verified','=','0')->update([
// 			'result_comment' => null
// 		]);}


// if ($EOSINO_comm->result > $EOSINO_comm->high) {
// TestEntryModel::where('regkey',$regkey)->where('test_id',$EOSINO->test_id)->where('verified','=','0')->update([
// 	'result_comment' => 'Absolute eosinophilia'
// ]);}
// if ($EOSINO_comm->result >= $EOSINO_comm->low  && $EOSINO_comm->result <= $EOSINO_comm->high) {
// TestEntryModel::where('regkey',$regkey)->where('test_id',$EOSINO->test_id)->where('verified','=','0')->update([
// 	'result_comment' => null
// ]);}

// if (!$EOSINO_comm->result ) {
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$EOSINO->test_id)->where('verified','=','0')->update([
// 		'result_comment' => null
// 	]);}

// if ($BASO_comm->result > $BASO_comm->high) {
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$BASO->test_id)->where('verified','=','0')->update([
// 		'result_comment' => 'Absolute basophilia'
// 	]);}
// if ($BASO_comm->result >= $BASO_comm->low  && $BASO_comm->result <= $BASO_comm->high) {
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$BASO->test_id)->where('verified','=','0')->update([
// 		'result_comment' => null
// 	]);}

// if (!$BASO_comm->result ) {
// 	TestEntryModel::where('regkey',$regkey)->where('test_id',$BASO->test_id)->where('verified','=','0')->update([
// 		'result_comment' => null
// 	]);}
// 	}


	$grouptestscount = TestEntryModel::where('regkey',$regkey)->whereNull('megatest_id')->where('seperate_test',$seperate_test)->whereHas('TestData', function($q) use($group) {
		$q->where('test_group',$group)->where('active',false);
	})->groupBy('grouptest_id')->get();
//  dd($grouptestscount);

 foreach($grouptestscount as $grouptest){
$incompcount = 	TestEntryModel::where('regkey',$regkey)->where('grouptest_id',$grouptest->grouptest_id)->whereNull('megatest_id')->where('seperate_test',$seperate_test)->whereNull('result')->whereHas('TestData', function($q) use($group) {
		$q->where('test_group',$group)->where('active',false);
	})->groupBy('grouptest_id')->count();

	if($incompcount > 0){
		TestEntryModel::where('regkey',$regkey)->where('grouptest_id',$grouptest->grouptest_id)->whereNull('megatest_id')->where('seperate_test',$seperate_test)->whereHas('TestData', function($q) use($group) {
			$q->where('test_group',$group)->where('active',false);
		})->update(['completed'=>false]);	
	}else{
		TestEntryModel::where('regkey',$regkey)->where('grouptest_id',$grouptest->grouptest_id)->whereNull('megatest_id')->where('seperate_test',$seperate_test)->whereHas('TestData', function($q) use($group) {
			$q->where('test_group',$group)->where('active',false);
		})->update(['completed'=>true]);

	}
 }

 $grouptestscountcomp = TestEntryModel::where('regkey',$regkey)->whereNull('megatest_id')->where('seperate_test',$seperate_test)->where('completed',true)->whereHas('TestData', function($q) use($group) {
	$q->where('test_group',$group)->where('active',false);
})->groupBy('grouptest_id')->get();
// dd($grouptestscountcomp);

TestEntryModel::where('regkey',$regkey)->whereNull('megatest_id')->whereNotNull('result')->where('seperate_test',$seperate_test)->whereHas('TestData', function($q) use($group) {
	$q->where('test_group',$group)->where('active',true);
})->update(['completed'=>true]);

TestEntryModel::where('regkey',$regkey)->whereNull('megatest_id')->whereNull('result')->where('seperate_test',$seperate_test)->whereHas('TestData', function($q) use($group) {
	$q->where('test_group',$group)->where('active',true);
})->update(['completed'=>false]);	

		return redirect()->route('resultentry',array('regkey' => $regkey,'group' => $group , 'seperate_test'=> $SeperateTest));
		}
	

		public function editMega(Request $request,$regkey,$group,$megatest_id,$seperate_test) {
		
			$resulttracking = TestEntryModel::query()
			->where('regkey',$regkey)
			->where('seperate_test',$seperate_test)
			->whereHas('TestData',function($qurey) use($group){
				$qurey->where('test_group',$group);
				})->get();
				
			$Results       = $request->except('_token','_method');
			$ResultsCount  = count($request->only('result')); 
		DB::beginTransaction();
		// dd($Results);
        foreach ($Results['result'] as $i=> $result) {

			$ResultInput      = $Results['result'][$i];
			$Low              = $Results['low'][$i];
			$High             = $Results['high'][$i];
			$NN_Normal        = $Results['nn_normal'][$i];
			$Flag             = $Results['flag'][$i];
			$Unit             = $Results['unit'][$i];
			$ResultComment    = $Results['result_comment'][$i];
			$ReportPrinted    = isset($Results['report_printed'][$i]) ? $Results['report_printed'][$i] : false;
			$SeperateTest     = isset($Results['seperate_test'][$i]) && ($Results['active'][$i] == '1') ? $Results['test_id'][$i] : '0';
		
			$SampleID         = $regkey.''.$group.''.$SeperateTest; 
// dd($SampleID);
			$TestEntry = TestEntryModel::query()->where('result_id',$i)->update(
				[
					'result'         =>$ResultInput,
					'low'            =>$Low,
					'high'           =>$High,
					'nn_normal'      =>$NN_Normal,
					'flag'           =>$Flag,
					'unit'           =>$Unit,
					'result_comment' =>$ResultComment,
					'report_printed' =>$ReportPrinted,
					'seperate_test'  =>$SeperateTest,
					'sample_id'      =>$SampleID,
					// 'completed'      =>isset($ResultInput) ? "1":"0" ,
			]
				
			);
			
        }
    // when done commit
DB::commit();
	

foreach($resulttracking as $result){
	$resultcheck = TestEntryModel::query()->where('result_id',$result->result_id)->where('result',$result->result)->exists();
	$newresult = TestEntryModel::query()->where('result_id',$result->result_id)->first();
	// dd($result);
	// dd($newresult);
// dd($resultcheck);
if($resultcheck){
}else{
	$tracking  = new ResultTrackingModel();
		$tracking->result_id    = $result->result_id;
		$tracking->regkey       = $result->regkey;
		$tracking->test_id      = $result->test_id;
		$tracking->result       = $newresult->result;
		$tracking->user_id      = '1';
		$tracking->modify_time  = now();
		$tracking->save();
}}


// BUN Calculations
$Urea  = TestEntryModel::where('regkey',$regkey)->where('test_id','=','428')->first();
$BUN   = TestEntryModel::where('regkey',$regkey)->where('test_id','=','721')->first();

if ($BUN){
if ($BUN->result == '.'){	
}else{
if (isset($Urea->result) && $Urea->result <>'.'){
$bun = $Urea->result / 2.14;
if($BUN->low && $BUN->high){
if ($bun < $BUN->low){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','721')->where('verified','=','0')->update([
		'result' => round($bun,1),
		'flag' => 'L'
		]);
	}elseif($bun > $BUN->high){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','721')->where('verified','=','0')->update([
		'result' => round($bun,1),
	  'flag' => 'H'
  ]);
}elseif($bun >= $BUN->low && $bun <= $BUN->high){
TestEntryModel::where('regkey',$regkey)->where('test_id','=','721')->where('verified','=','0')->update([
'result' => round($bun,1),
  'flag' => null
]);
}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','721')->where('verified','=','0')->update([
		'result' => round($bun,1)
	  ]);
}}}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','721')->where('verified','=','0')->update([
		'result' => null
	  ]);	
}

// Bilirubin Calculations
$TBIL  = TestEntryModel::where('regkey',$regkey)->where('test_id','=','97')->first();
$DBIL  = TestEntryModel::where('regkey',$regkey)->where('test_id','=','98')->first();
$INBIL = TestEntryModel::where('regkey',$regkey)->where('test_id','=','444')->first();

if ($INBIL){
if ($INBIL->result == '.'){	
}else{
if (isset($TBIL->result ,$DBIL->result)
&& $TBIL->result <>'.' && $DBIL->result <>'.'){
$inbil = $TBIL->result - $DBIL->result;
if($INBIL->low && $INBIL->high){
if ($inbil < $INBIL->low){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','444')->where('verified','=','0')->update([
		'result' => round($inbil,2),
		'flag' => 'L'
		]);
	}elseif($inbil > $INBIL->high){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','444')->where('verified','=','0')->update([
		'result' => round($inbil,2),
	  'flag' => 'H'
  ]);
}elseif($inbil >= $INBIL->low && $inbil <= $INBIL->high){
TestEntryModel::where('regkey',$regkey)->where('test_id','=','444')->where('verified','=','0')->update([
'result' => round($inbil,2),
  'flag' => null
]);
}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','444')->where('verified','=','0')->update([
		'result' => round($inbil,2)
	  ]);
}}}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','444')->where('verified','=','0')->update([
		'result' => null
	  ]);	
}

// PSA Calculations
$TPSA  = TestEntryModel::where('regkey',$regkey)->where('test_id','=','318')->first();
$FPSA  = TestEntryModel::where('regkey',$regkey)->where('test_id','=','319')->first();
$PSA_R = TestEntryModel::where('regkey',$regkey)->where('test_id','=','320')->first();

if ($PSA_R){
if ($PSA_R->result == '.'){	
}else{
if (isset($TPSA->result ,$FPSA->result)
&& $TPSA->result <>'.' && $TPSA->result <>'.'){
$psa_r = $FPSA->result / $TPSA->result;
TestEntryModel::where('regkey',$regkey)->where('test_id','=','320')->where('verified','=','0')->update([
	'result' => round($psa_r,2)
]);
}else{
TestEntryModel::where('regkey',$regkey)->where('test_id','=','320')->where('verified','=','0')->update([
		'result' => null
	]);
}}}

// Ratio Calculations
$Alb_Ratio    = TestEntryModel::where('regkey',$regkey)->where('test_id','=','13')->first();
$Creat_Ratio  = TestEntryModel::where('regkey',$regkey)->where('test_id','=','14')->first();
$Alb_Creat    = TestEntryModel::where('regkey',$regkey)->where('test_id','=','15')->first();

$Alb_Micro    = TestEntryModel::where('regkey',$regkey)->where('test_id','=','16')->first();
$Creat_Micro  = TestEntryModel::where('regkey',$regkey)->where('test_id','=','17')->first();
$MicroAlb     = TestEntryModel::where('regkey',$regkey)->where('test_id','=','18')->first();
// dd($Alb_Creat);
if ($Alb_Creat){
if ($Alb_Creat->result == '.'){	
}else{
if (isset($Alb_Ratio->result ,$Creat_Ratio->result) 
&& $Alb_Ratio->result <>'.' && $Creat_Ratio->result <>'.'){
$alb_creat = ($Alb_Ratio->result / $Creat_Ratio->result) * 100;
TestEntryModel::where('regkey',$regkey)->where('test_id','=','15')->where('verified','=','0')->update([
	'result' => round($alb_creat,2)
]);
}else{
TestEntryModel::where('regkey',$regkey)->where('test_id','=','15')->where('verified','=','0')->update([
		'result' => null
	]);
}}}



if ($MicroAlb){
if ($MicroAlb->result == '.'){	
}else{
if (isset($Alb_Micro->result ,$Creat_Micro->result)
&& $Alb_Micro->result <>'.' && $Creat_Micro->result <>'.'){
$microalb = ($Alb_Micro->result / $Creat_Micro->result) * 100;
TestEntryModel::where('regkey',$regkey)->where('test_id','=','18')->where('verified','=','0')->update([
	'result' => round($microalb,2)
]);
}else{
TestEntryModel::where('regkey',$regkey)->where('test_id','=','18')->where('verified','=','0')->update([
		'result' => null
	]);
}}}



// Lipids Calculation
$TG     = TestEntryModel::where('regkey',$regkey)->where('test_id','=','423')->first();
$CHOL   = TestEntryModel::where('regkey',$regkey)->where('test_id','=','420')->first();
$HDL    = TestEntryModel::where('regkey',$regkey)->where('test_id','=','268')->first();
$LDL    = TestEntryModel::where('regkey',$regkey)->where('test_id','=','290')->first();
$VLDL   = TestEntryModel::where('regkey',$regkey)->where('test_id','=','434')->first();
$Risk1  = TestEntryModel::where('regkey',$regkey)->where('test_id','=','445')->first();
$Risk2  = TestEntryModel::where('regkey',$regkey)->where('test_id','=','446')->first();
// dd($HDL);
if ($LDL){
if ($LDL->result == '.'){	
}else{
if (isset($TG->result ,$CHOL->result ,$HDL->result)
&& $TG->result <>'.' && $CHOL->result <>'.' && $HDL->result<>'.'){
$ldl = $CHOL->result - ($HDL->result +($TG->result / 5))  ;
if($LDL->low && $LDL->high){
if ($ldl < $LDL->low){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','290')->where('verified','=','0')->update([
		'result' => round($ldl,0),
		'flag' => 'L'
		]);
	}elseif($ldl > $LDL->high){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','290')->where('verified','=','0')->update([
		'result' => round($ldl,0),
	  'flag' => 'H'
  ]);
}elseif($ldl >= $LDL->low && $inbil <= $LDL->high){
TestEntryModel::where('regkey',$regkey)->where('test_id','=','290')->where('verified','=','0')->update([
'result' => round($ldl,0),
  'flag' => null
]);
}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','290')->where('verified','=','0')->update([
		'result' => round($ldl,0)
	  ]);
}}}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','290')->where('verified','=','0')->update([
		'result' => null
	  ]);	
}



if ($VLDL){
	if ($VLDL->result == '.'){	
	}else{	
if (isset($TG->result) && $TG->result <>'.'){
	$vldl = ($TG->result / 5);
	if($VLDL->low && $VLDL->high){
	if ($vldl < $VLDL->low){
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','434')->where('verified','=','0')->update([
			'result' => round($vldl,0),
			'flag' => 'L'
			]);
		}elseif($vldl > $VLDL->high){
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','434')->where('verified','=','0')->update([
			'result' => round($vldl,0),
		  'flag' => 'H'
	  ]);
  }elseif($vldl >= $VLDL->low && $vldl <= $VLDL->high){
  TestEntryModel::where('regkey',$regkey)->where('test_id','=','434')->where('verified','=','0')->update([
	'result' => round($vldl,0),
	  'flag' => null
  ]);
}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','434')->where('verified','=','0')->update([
		'result' => round($vldl,0)
	  ]);
}}}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','434')->where('verified','=','0')->update([
		'result' => null
	  ]);	
}

if ($Risk1){
	if ($Risk1->result == '.'){	
	}else{
	if (isset($CHOL->result ,$HDL->result)
&& $HDL->result <>'.' && $CHOL->result <>'.'){
		$risk1 = ($CHOL->result / $HDL->result);
		if ($Risk1->low && $Risk1->high ){
		if ($risk1 < $Risk1->low){
			TestEntryModel::where('regkey',$regkey)->where('test_id','=','445')->where('verified','=','0')->update([
				'result' => round($risk1,2),
				'flag' => 'L'
				]);
			}elseif($risk1 > $Risk1->high){
			TestEntryModel::where('regkey',$regkey)->where('test_id','=','445')->where('verified','=','0')->update([
				'result' => round($risk1,2),
			  'flag' => 'H'
		  ]);
	  }elseif($risk1 >= $Risk1->low && $risk1 <= $Risk1->high){
	  TestEntryModel::where('regkey',$regkey)->where('test_id','=','445')->where('verified','=','0')->update([
		'result' => round($risk1,2),
		  'flag' => null
	  ]);
	}}else{
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','445')->where('verified','=','0')->update([
			'result' => round($risk1,2)
		  ]);
	}}}}else{
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','445')->where('verified','=','0')->update([
			'result' => null
		  ]);	
	}


$LDL2    = TestEntryModel::where('regkey',$regkey)->where('test_id','=','290')->first();
// dd($LDL2);
if ($Risk2){
	if ($Risk2->result == '.'){	
	}else{
	if (isset($LDL2->result ,$HDL->result)
	&& $LDL2->result <>'.' && $HDL->result <>'.'){
		$risk2 = ($LDL2->result / $HDL->result);
		if ($Risk2->low && $Risk2->high){
		if ($risk2 < $Risk2->low){
			TestEntryModel::where('regkey',$regkey)->where('test_id','=','446')->where('verified','=','0')->update([
				'result' => round($risk2,2),
				'flag' => 'L'
				]);
			}elseif($risk2 > $Risk2->high){
			TestEntryModel::where('regkey',$regkey)->where('test_id','=','446')->where('verified','=','0')->update([
				'result' => round($risk2,2),
			  'flag' => 'H'
		  ]);
	  }elseif($risk2 >= $Risk2->low && $risk2 <= $Risk2->high){
	  TestEntryModel::where('regkey',$regkey)->where('test_id','=','446')->where('verified','=','0')->update([
		'result' => round($risk2,2),
		  'flag' => null
	  ]);
	}}else{
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','446')->where('verified','=','0')->update([
			'result' => round($risk2,2)
		  ]);
	}}}}else{
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','446')->where('verified','=','0')->update([
			'result' => null
		  ]);	
	}

	// PT Calculation
$PT       = TestEntryModel::where('regkey',$regkey)->where('test_id','=','360')->first();
$Control  = TestEntryModel::where('regkey',$regkey)->where('test_id','=','361')->first();
$Conc     = TestEntryModel::where('regkey',$regkey)->where('test_id','=','362')->first();
$INR      = TestEntryModel::where('regkey',$regkey)->where('test_id','=','363')->first();

if ($Conc){
	if ($Conc->result == '.'){	
	}else{
if (isset($PT->result ,$Control->result)){
$conc = ($Control->result / $PT->result) * 100 ;
if($Conc->low && $Conc->high){
if ($conc < $Conc->low){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','362')->where('verified','=','0')->update([
		'result' => round($conc,2),
		'flag' => 'L'
		]);
	}elseif($conc > $Conc->high){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','362')->where('verified','=','0')->update([
		'result' => round($conc,2),
	  'flag' => 'H'
  ]);
}elseif($conc >= $Conc->low && $conc <= $Conc->high){
TestEntryModel::where('regkey',$regkey)->where('test_id','=','362')->where('verified','=','0')->update([
'result' => round($conc,2),
  'flag' => null
]);
}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','362')->where('verified','=','0')->update([
		'result' => round($conc,2)
	  ]);
}}}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','362')->where('verified','=','0')->update([
		'result' => null
	  ]);	
}
if ($INR){
	if ($INR->result == '.'){	
	}else{
if (isset($PT->result ,$Control->result)){
$inr = (($PT->result / $Control->result));
if($INR->low && $INR->high){
if ($inr < $INR->low){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','363')->where('verified','=','0')->update([
		'result' => round($inr,2),
		'flag' => 'L'
		]);
	}elseif($inr > $INR->high){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','363')->where('verified','=','0')->update([
		'result' => round($inr,2),
	  'flag' => 'H'
  ]);
}elseif($inr >= $INR->low && $inr <= $INR->high){
TestEntryModel::where('regkey',$regkey)->where('test_id','=','363')->where('verified','=','0')->update([
'result' => round($inr,2),
  'flag' => null
]);
}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','363')->where('verified','=','0')->update([
		'result' => round($inr,2)
	  ]);
}}}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','363')->where('verified','=','0')->update([
		'result' => null
	  ]);	
}

//  CBC Calculations
	$HB           = TestEntryModel::where('regkey',$regkey)->where('test_id','=','564')->first();
	$RBC          = TestEntryModel::where('regkey',$regkey)->where('test_id','=','565')->first();
	$HCT          = TestEntryModel::where('regkey',$regkey)->where('test_id','=','566')->first();
	$MCV          = TestEntryModel::where('regkey',$regkey)->where('test_id','=','567')->first();
	$MCH          = TestEntryModel::where('regkey',$regkey)->where('test_id','=','568')->first();
	$MCHC         = TestEntryModel::where('regkey',$regkey)->where('test_id','=','569')->first();
	$RDW          = TestEntryModel::where('regkey',$regkey)->where('test_id','=','570')->first();
	$PLT          = TestEntryModel::where('regkey',$regkey)->where('test_id','=','571')->first();
	$WBC          = TestEntryModel::where('regkey',$regkey)->where('test_id','=','572')->first();
	$NEUT         = TestEntryModel::where('regkey',$regkey)->where('test_id','=','573')->first();
	$SEGMENT      = TestEntryModel::where('regkey',$regkey)->where('test_id','=','574')->first();
	$BANDS        = TestEntryModel::where('regkey',$regkey)->where('test_id','=','575')->first();
	$LYMPH        = TestEntryModel::where('regkey',$regkey)->where('test_id','=','576')->first();
	$MONO         = TestEntryModel::where('regkey',$regkey)->where('test_id','=','577')->first();
	$EOSINO       = TestEntryModel::where('regkey',$regkey)->where('test_id','=','578')->first();
	$BASO         = TestEntryModel::where('regkey',$regkey)->where('test_id','=','579')->first();
	$META         = TestEntryModel::where('regkey',$regkey)->where('test_id','=','580')->first();
	$MEYLO        = TestEntryModel::where('regkey',$regkey)->where('test_id','=','581')->first();
	$PROMYLO      = TestEntryModel::where('regkey',$regkey)->where('test_id','=','582')->first();
	$BLAST        = TestEntryModel::where('regkey',$regkey)->where('test_id','=','583')->first();
	$NORMOBLAST   = TestEntryModel::where('regkey',$regkey)->where('test_id','=','584')->first();
	$NEUT_        = TestEntryModel::where('regkey',$regkey)->where('test_id','=','585')->first();
	$SEG_         = TestEntryModel::where('regkey',$regkey)->where('test_id','=','723')->first();
	$BAND_        = TestEntryModel::where('regkey',$regkey)->where('test_id','=','724')->first();
	
	$LYMPH_       = TestEntryModel::where('regkey',$regkey)->where('test_id','=','586')->first();
	$MONO_        = TestEntryModel::where('regkey',$regkey)->where('test_id','=','587')->first();
	$EOSINO_      = TestEntryModel::where('regkey',$regkey)->where('test_id','=','588')->first();
	$BASO_        = TestEntryModel::where('regkey',$regkey)->where('test_id','=','589')->first();
	// dd($EOSINO);


	if ($MCV){
		if ($MCV->result == '.'){	
		}else{
		if (isset($HCT->result ,$RBC->result)){
		  $mcv = ($HCT->result / $RBC->result)*10 ;
		//   dd($mcv);
		if($MCV->low && $MCV->high){
		  if ($mcv < $MCV->low){
			TestEntryModel::where('regkey',$regkey)->where('test_id','=','567')->where('verified',false)->update([
				'result' => round($mcv,1),
				'flag'   => 'L'
				]);
			}elseif($mcv > $MCV->high){
		  TestEntryModel::where('regkey',$regkey)->where('test_id','=','567')->where('verified','=','0')->update([
			  'result' => round($mcv,1),
			  'flag'   => 'H'
		  ]);
	  }elseif($mcv >= $MCV->low && $mcv <= $MCV->high){
	  TestEntryModel::where('regkey',$regkey)->where('test_id','=','567')->where('verified','=','0')->update([
		  'result' => round($mcv,1),
		  'flag' => null
	  ]);
	}}else{
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','567')->where('verified','=','0')->update([
			'result' => round($mcv,1)
		  ]);
	}}}}else{
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','567')->where('verified','=','0')->update([
			'result' => null
		  ]);	
	}

	  if ($MCH){
		if ($MCH->result == '.'){	
		}else{
		if (isset($HB->result ,$RBC->result)){
		  $mch = ($HB->result * 10) / $RBC->result ;
		  if($MCH->low && $MCH->high){
		  if ($mch < $MCH->low){
			TestEntryModel::where('regkey',$regkey)->where('test_id','=','568')->where('verified','=','0')->update([
				'result' => round($mch,1),
				'flag' => 'L'
				]);
			}elseif($mch > $MCH->high){
			TestEntryModel::where('regkey',$regkey)->where('test_id','=','568')->where('verified','=','0')->update([
				'result' => round($mch,1),
			  'flag' => 'H'
		  ]);
	  }elseif($mch >= $MCH->low && $mch <= $MCH->high){
	  TestEntryModel::where('regkey',$regkey)->where('test_id','=','568')->where('verified','=','0')->update([
		'result' => round($mch,1),
		  'flag' => null
	  ]);
	  }}else{
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','568')->where('verified','=','0')->update([
			'result' => round($mch,1)
		  ]);
	}}}}else{
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','568')->where('verified','=','0')->update([
			'result' => null
		  ]);	
	}

	  if ($MCHC){
		if ($MCHC->result == '.'){	
		}else{
		if (isset($HB->result ,$HCT->result)){
		  $mchc = ($HB->result * 100) / $HCT->result ;
		  if($MCHC->low && $MCHC->high){

		  if ($mchc < $MCHC->low){
			TestEntryModel::where('regkey',$regkey)->where('test_id','=','569')->where('verified','=','0')->update([
				'result' => round($mchc,1),
				'flag' => 'L'
				]);
			}elseif($mchc > $MCHC->high){
			TestEntryModel::where('regkey',$regkey)->where('test_id','=','569')->where('verified','=','0')->update([
				'result' => round($mchc,1),
			  'flag' => 'H'
		  ]);
	  }elseif($mchc >= $MCHC->low && $mchc <= $MCHC->high){
	  TestEntryModel::where('regkey',$regkey)->where('test_id','=','569')->where('verified','=','0')->update([
		'result' => round($mchc,1),
		  'flag' => null
	  ]);
	}}else{
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','569')->where('verified','=','0')->update([
			'result' => round($mchc,1)
		  ]);
	}}}}else{
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','569')->where('verified','=','0')->update([
			'result' => null
		  ]);	
	}

	  if ($SEGMENT){
		if ($SEGMENT->result == '.'){	
		}else{
		if (isset($BANDS->result ,$LYMPH->result ,$MONO->result ,$EOSINO->result ,$BASO->result)){
		  $seg = 100 - ($BANDS->result + $LYMPH->result + $MONO->result + $EOSINO->result + $BASO->result);
		  if($SEGMENT->low && $SEGMENT->high){
		  if ($seg < $SEGMENT->low){
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','574')->where('verified','=','0')->update([
			'result' => round($seg,0),
		'flag' => 'L'
		]);
	}elseif($seg > $SEGMENT->high){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','574')->where('verified','=','0')->update([
		'result' => round($seg,0),
		'flag' => 'H'
	]);
}elseif($seg >= $SEGMENT->low && $seg <= $SEGMENT->high){
TestEntryModel::where('regkey',$regkey)->where('test_id','=','574')->where('verified','=','0')->update([
	'result' => round($seg,0),
	'flag' => null
]);
}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','574')->where('verified','=','0')->update([
		'result' => round($seg,0)
	  ]);
}}}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','574')->where('verified','=','0')->update([
		'result' => null
	  ]);	
}
	$SEGMENT2    = TestEntryModel::where('regkey',$regkey)->where('test_id','=','574')->first();
	$BANDS2      = TestEntryModel::where('regkey',$regkey)->where('test_id','=','575')->first();

	if ($NEUT){
		if ($NEUT->result == '.'){	
		}else{
		if (isset($SEGMENT2->result ,$BANDS->result)){
		  $neut = $SEGMENT2->result + $BANDS->result ;
		  if($NEUT->low && $NEUT->high){

		  if($NEUT->low && $NEUT->high){
		  if ($neut < $NEUT->low){
			TestEntryModel::where('regkey',$regkey)->where('test_id','=','573')->where('verified','=','0')->update([
				'result' => round($neut,0),
				'flag' => 'L'
			]);
		}elseif($neut > $NEUT->high){
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','573')->where('verified','=','0')->update([
			'result' => round($neut,0),
			'flag' => 'H'
		]);
	}elseif($neut >= $NEUT->low && $neut <= $NEUT->high){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','573')->where('verified','=','0')->update([
		'result' => round($neut,0),
		'flag' => null
	]);
	}}}else{
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','573')->where('verified','=','0')->update([
			'result' => round($neut,0)
		  ]);
	}}}}else{
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','573')->where('verified','=','0')->update([
			'result' => null
		  ]);	
	}

	if ($SEG_){
		if ($SEG_->result == '.'){	
		}else{
		if (isset($SEGMENT2->result ,$WBC->result)){
		  $seg_ = ($SEGMENT2->result * $WBC->result) / 100 ;
		  if($SEG_->low && $SEG_->high){

		  if ($seg_ < $SEG_->low){
			TestEntryModel::where('regkey',$regkey)->where('test_id','=','723')->where('verified','=','0')->update([
				'result' => round($seg_,0),
				'flag' => 'L'
			]);
		}elseif($seg_ > $SEG_->high){
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','723')->where('verified','=','0')->update([
			'result' => round($seg_,0),
			'flag' => 'H'
		]);
	}elseif($seg_ >= $SEG_->low && $seg_ <= $SEG_->high){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','723')->where('verified','=','0')->update([
		'result' => round($seg_,0),
		'flag' => null
	]);
}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','723')->where('verified','=','0')->update([
		'result' => round($seg_,0)
	  ]);
}}}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','723')->where('verified','=','0')->update([
		'result' => null
	  ]);	
}
	if ($BAND_){
		if ($BAND_->result == '.'){	
		}else{
		if (isset($BANDS->result ,$WBC->result)){
		  $band_ = ($BANDS->result * $WBC->result) / 100 ;
		  if($BAND_->low && $BAND_->high){

		  if ($band_ < $BAND_->low){
			TestEntryModel::where('regkey',$regkey)->where('test_id','=','724')->where('verified','=','0')->update([
				'result' => round($band_,0),
			'flag' => 'L'
			]);
		}elseif($band_ > $BAND_->high){
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','724')->where('verified','=','0')->update([
			'result' => round($band_,0),
			'flag' => 'H'
		]);
	}elseif($band_ >= $BAND_->low && $band_ <= $BAND_->high){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','724')->where('verified','=','0')->update([
		'result' => round($band_,0),
		'flag' => null
	]);
}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','724')->where('verified','=','0')->update([
		'result' => round($band_,0)
	  ]);
}}}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','724')->where('verified','=','0')->update([
		'result' => null
	  ]);	
}


	$NEUT2    = TestEntryModel::where('regkey',$regkey)->where('test_id','=','573')->first();
	if ($NEUT_){
		if ($NEUT_->result == '.'){	
		}else{
		if (isset($NEUT2->result ,$WBC->result)){
		  $neut_ = ($NEUT2->result * $WBC->result) / 100 ;
		  if($NEUT2->low && $NEUT2->high){

		  if ($neut_ < $NEUT2->low){
			TestEntryModel::where('regkey',$regkey)->where('test_id','=','585')->where('verified','=','0')->update([
				'result' => round($neut_,2),
			    'flag' => 'L'
			]);
		}elseif($neut_ > $NEUT2->high){
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','585')->where('verified','=','0')->update([
			'result' => round($neut_,2),
			'flag' => 'H'
		]);
	}elseif($neut_ >= $NEUT2->low && $neut_ <= $NEUT2->high){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','585')->where('verified','=','0')->update([
		'result' => round($neut_,2),
		'flag' => null
	]);
}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','585')->where('verified','=','0')->update([
		'result' => round($neut_,2)
	  ]);
}}}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','585')->where('verified','=','0')->update([
		'result' => null
	  ]);	
}

	$LYMPH2    = TestEntryModel::where('regkey',$regkey)->where('test_id','=','576')->first();
	if ($LYMPH_){
		if ($LYMPH_->result == '.'){	
		}else{
		if (isset($LYMPH2->result ,$WBC->result)){
		  $lymph_ = ($LYMPH2->result * $WBC->result) / 100 ;
		  if($LYMPH2->low && $LYMPH2->high){

		  if ($lymph_ < $LYMPH2->low){
			TestEntryModel::where('regkey',$regkey)->where('test_id','=','586')->where('verified','=','0')->update([
				'result' => round($lymph_,2),
			'flag' => 'L'
			]);
		}elseif($lymph_ > $LYMPH2->high){
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','586')->where('verified','=','0')->update([
			'result' => round($lymph_,2),
			'flag' => 'H'
		]);
	}elseif($lymph_ >= $LYMPH2->low && $lymph_ <= $LYMPH2->high){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','586')->where('verified','=','0')->update([
		'result' => round($lymph_,2),
		'flag' => null
	]);
}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','586')->where('verified','=','0')->update([
		'result' => round($lymph_,2)
	  ]);
}}}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','586')->where('verified','=','0')->update([
		'result' => null
	  ]);	
}

	$MONO2    = TestEntryModel::where('regkey',$regkey)->where('test_id','=','577')->first();
	if ($MONO_){
		if ($MONO_->result == '.'){	
		}else{
		if (isset($MONO2->result ,$WBC->result)){
		  $mono_ = ($MONO2->result * $WBC->result) / 100 ;
		  if($MONO2->low && $MONO2->high){

		  if ($mono_ < $MONO2->low){
			TestEntryModel::where('regkey',$regkey)->where('test_id','=','587')->where('verified','=','0')->update([
				'result' => round($mono_,2),
			'flag' => 'L'
			]);
		}elseif($mono_ > $MONO2->high){
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','587')->where('verified','=','0')->update([
			'result' => round($mono_,2),
			'flag' => 'H'
		]);
	}elseif($mono_ >= $MONO2->low && $mono_ <= $MONO2->high){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','587')->where('verified','=','0')->update([
		'result' => round($mono_,2),
		'flag' => null
	]);
}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','587')->where('verified','=','0')->update([
		'result' => round($mono_,2)
	  ]);
}}}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','587')->where('verified','=','0')->update([
		'result' => null
	  ]);	
}

	$EOSINO2    = TestEntryModel::where('regkey',$regkey)->where('test_id','=','578')->first();
	if ($EOSINO_){
		if ($EOSINO_->result == '.'){	
		}else{
		if (isset($EOSINO2->result ,$WBC->result)){
		  $eosino_ = ($EOSINO2->result * $WBC->result) / 100 ;
		  if($EOSINO2->low && $EOSINO2->high){

		  if ($eosino_ < $EOSINO2->low){
			TestEntryModel::where('regkey',$regkey)->where('test_id','=','588')->where('verified','=','0')->update([
				'result' => round($eosino_,2),
			'flag' => 'L'
			]);
		}elseif($eosino_ > $EOSINO2->high){
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','588')->where('verified','=','0')->update([
			'result' => round($eosino_,2),
			'flag' => 'H'
		]);
	}elseif($eosino_ >= $EOSINO2->low && $eosino_ <= $EOSINO2->high){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','588')->where('verified','=','0')->update([
		'result' => round($eosino_,2),
		'flag' => null
	]);
		
}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','588')->where('verified','=','0')->update([
		'result' => round($eosino_,2)
	  ]);
}}}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','588')->where('verified','=','0')->update([
		'result' => null
	  ]);	
}

	$BASO2    = TestEntryModel::where('regkey',$regkey)->where('test_id','=','579')->first();
	if ($BASO_){
		if ($BASO_->result == '.'){	
		}else{
		if (isset($BASO2->result ,$WBC->result)){
		  $baso_ = ($BASO2->result * $WBC->result) / 100 ;
		  if($BASO2->low && $BASO2->high){

		  if ($baso_ < $BASO2->low){
			TestEntryModel::where('regkey',$regkey)->where('test_id','=','589')->where('verified','=','0')->update([
				'result' => round($baso_,2),
			'flag' => 'L'
			]);
		}elseif($baso_ > $BASO2->high){
		TestEntryModel::where('regkey',$regkey)->where('test_id','=','589')->where('verified','=','0')->update([
			'result' => round($baso_,2),
			'flag' => 'H'
		]);
	}elseif($baso_ >= $BASO2->low && $baso_ <= $BASO2->high){
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','589')->where('verified','=','0')->update([
		'result' => round($baso_,2),
		'flag' => null
	]);
		
}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','589')->where('verified','=','0')->update([
		'result' => round($baso_,2)
	  ]);
}}}}else{
	TestEntryModel::where('regkey',$regkey)->where('test_id','=','589')->where('verified','=','0')->update([
		'result' => null
	  ]);	
}

	
if ($megatest_id == 405){

	// CBC Comments 
// dd($HB);
$MCV2    = TestEntryModel::where('regkey',$regkey)->where('test_id','=','567')->first();
$MCH2    = TestEntryModel::where('regkey',$regkey)->where('test_id','=','568')->first();

if ((!$HB->result) 
	&&(!$RBC->result) 
	&&(!$HCT->result) 
	&& (!$MCV2->result)
	&& (!$MCH2->result) 
	&& (!$RDW->result)){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
			'result_comment' => null
		]);
	}

if (($HB->result >= $HB->low && $HB->result <= $HB->high) 
&& ($MCV2->result >= $MCV2->low  && $MCV2->result <= $MCV2->high)
&& ($MCH2->result >= $MCH2->low  && $MCH2->result <= $MCH2->high) 
&& ($RDW->result >= $RDW->low && $RDW->result <= $RDW->high)){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
			'result_comment' => 'RBCs : Normocytic Normochromic cells'
		]);
	}

if (($HB->result >= $HB->low && $HB->result <= $HB->high) 
&& ($MCV2->result < $MCV2->low  && $MCV2->result > 0)
&& ($MCH2->result >= $MCH2->low  && $MCH2->result <= $MCH2->high)
&& ($RDW->result >= $RDW->low && $RDW->result <= $RDW->high)){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
			'result_comment' => 'RBCs : Microcytic normochromic cells'
		]);
	}

if (($HB->result >= $HB->low && $HB->result <= $HB->high) 
&& ($MCV2->result >= $MCV2->low  && $MCV2->result <= $MCV2->high)
&& ($MCH2->result < $MCH2->low  && $MCH2->result > 0)
&& ($RDW->result >= $RDW->low && $RDW->result <= $RDW->high)){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
			'result_comment' => 'RBCs : Normocytic hypochromic cells'
		]);
	}

if (($HB->result >= $HB->low && $HB->result <= $HB->high) 
&& ($MCV2->result < $MCV2->low  && $MCV2->result > 0)
&& ($MCH2->result < $MCH2->low  && $MCH2->result > 0)
&& ($RDW->result >= $RDW->low && $RDW->result <= $RDW->high)){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
			'result_comment' => 'RBCs : Microcytic hypochromic cells'
		]);
	}

	if (($HB->result >= $HB->low && $HB->result <= $HB->high) 
&& ($MCV2->result >= $MCV2->low  && $MCV2->result <= $MCV2->high)
&& ($MCH2->result >= $MCH2->low  && $MCH2->result <= $MCH2->high) 
&& ($RDW->result > $RDW->high)){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
			'result_comment' => 'RBCs : Normocytic Normochromic cells with anisocytosis'
		]);
	}

if (($HB->result >= $HB->low && $HB->result <= $HB->high) 
&& ($MCV2->result >= $MCV2->low  && $MCV2->result <= $MCV2->high)
&& ($MCH2->result < $MCH2->low  && $MCH2->result > 0)
&& ($RDW->result > $RDW->high)){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
			'result_comment' => 'RBCs : Normocytic hypochromic cells with anisocytosis'
		]);
	}


if (($HB->result >= $HB->low && $HB->result <= $HB->high) 
&& ($MCV2->result < $MCV2->low  && $MCV2->result > 0)
&& ($MCH2->result >= $MCH2->low  && $MCH2->result <= $MCH2->high) 
&& ($RDW->result > $RDW->high)){
	TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
			'result_comment' => 'RBCs : Microcytic normochromic cells with anisocytosis'
		]);
	}
if (($HB->result >= $HB->low && $HB->result <= $HB->high) 
&& ($MCV2->result < $MCV2->low  && $MCV2->result > 0)
&& ($MCH2->result < $MCH2->low  && $MCH2->result > 0)
&& ($RDW->result > $RDW->high)){
	TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
			'result_comment' => 'RBCs : Microcytic hypochromic cells with anisocytosis'
		]);
	}


if (($HB->result < $HB->low && $HB->result >= $HB->low  - 3) 
&& ($MCV2->result < $MCV2->low && $MCV2->result > 0) 
&& ($MCH2->result < $MCH2->low && $MCV2->result > 0 ) 
&& ($RDW->result >= $RDW->low && $RDW->result <= $RDW->high)){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
			'result_comment' => 'RBCs : Mild microcytic hypochromic anemia'
		]);
	}

	if (($HB->result < $HB->low && $HB->result >= $HB->low  - 3) 
	&& ($MCV2->result <= $MCV2->high && $MCV2->result >= $MCV2->low) 
	&& ($MCH2->result < $MCH2->low) && ($RDW->result >= $RDW->low && $RDW->result < $RDW->low)){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
			'result_comment' => 'RBCs : Mild normocytic hypochromic anemia'
		]);
	}

	if (($HB->result < $HB->low && $HB->result >= $HB->low  - 3) 
	&& ($MCV2->result < $MCV2->low && $MCV2->result > 0) 
	&& ($MCH2->result >= $MCH2->low && $MCH2->result <= $MCH2->high) 
	&& ($RDW->result >= $RDW->low && $RDW->result <= $RDW->high)){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
			'result_comment' => 'RBCs : Mild microcytic normochromic anemia'
		]);
	}


	if (($HB->result < $HB->low - 3 && $HB->result >= $HB->low  - 6) 
	&& ($MCV2->result < $MCV2->low && $MCV2->result > 0) 
	&& ($MCH2->result < $MCH2->low && $MCH2->result > 0) 
	&& ($RDW->result >= $RDW->low && $RDW->result <= $RDW->high)){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
			'result_comment' => 'RBCs : Moderate microcytic hypochromic anemia'
		]);
	}

	if (($HB->result < $HB->low - 3 && $HB->result >= $HB->low  - 6) 
	&& ($MCV2->result <= $MCV2->high && $MCV2->result >= $MCV2->low) 
	&& ($MCH2->result < $MCH2->low && $MCH2->result > 0) 
	&& ($RDW->result >= $RDW->low && $RDW->result <= $RDW->high)){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
			'result_comment' => 'RBCs : Moderate normocytic hypochromic anemia'
		]);
	}

	if (($HB->result < $HB->low - 3 && $HB->result >= $HB->low  - 6) 
	&& ($MCV2->result < $MCV2->low && $MCH2->result > 0) 
	&& ($MCH2->result >= $MCH2->low && $MCH2->result <= $MCH2->high) 
	&& ($RDW->result >= $RDW->low && $RDW->result <= $RDW->high)){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
			'result_comment' => 'RBCs : Moderate microcytic normochromic anemia'
		]);
	}


	if (($HB->result < $HB->low - 6)  
	&& ($MCV2->result < $MCV2->low && $MCV2->result > 0) 
	&& ($MCH2->result < $MCH2->low && $MCH2->result > 0) 
	&& ($RDW->result >= $RDW->low && $RDW->result <= $RDW->high)){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
			'result_comment' => 'RBCs : Marked microcytic hypochromic anemia'
		]);
	}

	if (($HB->result < $HB->low - 6)  
	&& ($MCV2->result <= $MCV2->high && $MCV2->result >= $MCV2->low) 
	&& ($MCH2->result < $MCH2->low && $MCH2->result > 0)
	&& ($RDW->result >= $RDW->low && $RDW->result <= $RDW->high)){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
			'result_comment' => 'RBCs : Marked normocytic hypochromic anemia'
		]);
	}

	if (($HB->result < $HB->low - 6)  
	&& ($MCV2->result < $MCV2->low && $MCV2->result > 0) 
	&& ($MCH2->result >= $MCH2->low && $MCH2->result <= $MCH2->high)
	&& ($RDW->result >= $RDW->low && $RDW->result <= $RDW->high)){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
			'result_comment' => 'RBCs : Marked microcytic normochromic anemia'
		]);
	}



	if (($HB->result < $HB->low && $HB->result >= $HB->low  - 3) 
	&& ($MCV2->result < $MCV2->low && $MCV2->result > 0) 
	&& ($MCH2->result < $MCH2->low && $MCH2->result > 0) 
	&& ($RDW->result > $RDW->high)){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
			'result_comment' => 'RBCs : Mild microcytic hypochromic anemia with anisocytosis'
		]);
	}

	if (($HB->result < $HB->low && $HB->result >= $HB->low  - 3) 
	&& ($MCV2->result <= $MCV2->high && $MCV2->result >= $MCV2->low) 
	&& ($MCH2->result < $MCH2->low && $MCH2->result > 0) 
	&& ($RDW->result > $RDW->high)){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
			'result_comment' => 'RBCs : Mild normocytic hypochromic anemia with anisocytosis'
		]);
	}

	if (($HB->result < $HB->low && $HB->result >= $HB->low  - 3) 
	&& ($MCV2->result < $MCV2->low && $MCV2->result > 0) 
	&& ($MCH2->result >= $MCH2->low && $MCH2->result <= $MCH2->high) 
	&& ($RDW->result > $RDW->high)){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
			'result_comment' => 'RBCs : Mild microcytic normochromic anemia with anisocytosis'
		]);
	}


	if (($HB->result < $HB->low - 3 && $HB->result >= $HB->low  - 6) 
	&& ($MCV2->result < $MCV2->low && $MCV2->result > 0) 
	&& ($MCH2->result < $MCH2->low && $MCH2->result > 0) 
	&& ($RDW->result > $RDW->high)){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
			'result_comment' => 'RBCs : Moderate microcytic hypochromic anemia with anisocytosis'
		]);
	}

	if (($HB->result < $HB->low - 3 && $HB->result >= $HB->low  - 6) 
	&& ($MCV2->result <= $MCV2->high && $MCV2->result >= $MCV2->low) 
	&& ($MCH2->result < $MCH2->low && $MCH2->result > 0) 
	&& ($RDW->result > $RDW->high)){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
			'result_comment' => 'RBCs : Moderate normocytic hypochromic anemia with anisocytosis'
		]);
	}

	if (($HB->result < $HB->low - 3 && $HB->result >= $HB->low  - 6) 
	&& ($MCV2->result < $MCV2->low && $MCV2->result > 0) 
	&& ($MCH2->result >= $MCH2->low && $MCH2->result <= $MCH2->high) 
	&& ($RDW->result > $RDW->high)){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
			'result_comment' => 'RBCs : Moderate microcytic normochromic anemia with anisocytosis'
		]);
	}


	if (($HB->result < $HB->low - 6)  
	&& ($MCV2->result < $MCV2->low && $MCV2->result > 0) 
	&& ($MCH2->result < $MCH2->low && $MCH2->result > 0) 
	&& ($RDW->result > $RDW->high)){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
			'result_comment' => 'RBCs : Marked microcytic hypochromic anemia with anisocytosis'
		]);
	}

	if (($HB->result < $HB->low - 6)  
	&& ($MCV2->result <= $MCV2->high && $MCV2->result >= $MCV2->low) 
	&& ($MCH2->result < $MCH2->low)&& ($RDW->result > $RDW->high)){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
			'result_comment' => 'RBCs : Marked normocytic hypochromic anemia with anisocytosis'
		]);
	}

	if (($HB->result < $HB->low - 6)  
	&& ($MCV2->result < $MCV2->low && $MCV2->result > 0) 
	&& ($MCH2->result >= $MCH2->low && $MCH2->result <= $MCH2->high)
	&& ($RDW->result > $RDW->high)){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$HB->test_id)->where('verified','=','0')->update([
			'result_comment' => 'RBCs : Marked microcytic normochromic anemia with anisocytosis'
		]);
	}

	if (!$PLT->result ){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$PLT->test_id)->where('verified','=','0')->update([
			'result_comment' => null
		]);
	}

	if (($PLT->result <= $PLT->high && $PLT->result >= $PLT->low) ){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$PLT->test_id)->where('verified','=','0')->update([
			'result_comment' => 'PLTs : Adequate'
		]);
	}

	if (($PLT->result < $PLT->low && $PLT->result >= $PLT->low - 50) ){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$PLT->test_id)->where('verified','=','0')->update([
			'result_comment' => 'PLTs : Mild thrombocytopenia'
		]);
	}
	if (($PLT->result < $PLT->low - 50 && $PLT->result >= $PLT->low - 100) ){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$PLT->test_id)->where('verified','=','0')->update([
			'result_comment' => 'PLTs : Moderate thrombocytopenia'
		]);
	}
	if (($PLT->result < $PLT->low - 100 && $PLT->result > 0)){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$PLT->test_id)->where('verified','=','0')->update([
			'result_comment' => 'PLTs : Marked thrombocytopenia'
		]);
	}

	if (($PLT->result > $PLT->high && $PLT->result <= $PLT->high * 2) ){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$PLT->test_id)->where('verified','=','0')->update([
			'result_comment' => 'PLTs : Mild thrombocytosis'
		]);
	}
	if (($PLT->result > $PLT->high *2 && $PLT->result <= $PLT->high *3) ){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$PLT->test_id)->where('verified','=','0')->update([
			'result_comment' => 'PLTs : Moderate thrombocytosis'
		]);
	}
	if (($PLT->result > $PLT->high *3)){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$PLT->test_id)->where('verified','=','0')->update([
			'result_comment' => 'PLTs : Marked thrombocytosis'
		]);
	}

	$NEUT_comm  = TestEntryModel::where('regkey',$regkey)->where('test_id','=','585')->first();
	$SEG_comm   = TestEntryModel::where('regkey',$regkey)->where('test_id','=','723')->first();
	$BAND_comm  = TestEntryModel::where('regkey',$regkey)->where('test_id','=','724')->first();
	
	$LYMPH_comm  = TestEntryModel::where('regkey',$regkey)->where('test_id','=','586')->first();
	$MONO_comm   = TestEntryModel::where('regkey',$regkey)->where('test_id','=','587')->first();
	$EOSINO_comm = TestEntryModel::where('regkey',$regkey)->where('test_id','=','588')->first();
	$BASO_comm   = TestEntryModel::where('regkey',$regkey)->where('test_id','=','589')->first();	
// dd($LYMPH_comm);
	if (($WBC->result >= $WBC->low  && $WBC->result <= $WBC->high) 
	&& ($NEUT_comm->result >= $NEUT_comm->low  && $NEUT_comm->result <= $NEUT_comm->high)
	&& ($LYMPH_comm->result >= $LYMPH_comm->low  && $LYMPH_comm->result <= $LYMPH_comm->high)
	&& ($MONO_comm->result >= $MONO_comm->low  && $MONO_comm->result <= $MONO_comm->high)
	&& ($EOSINO_comm->result >= $EOSINO_comm->low  && $EOSINO_comm->result <= $EOSINO_comm->high)
	&& ($BASO_comm->result >= $BASO_comm->low  && $BASO_comm->result <= $BASO_comm->high)
	){
		TestEntryModel::where('regkey',$regkey)->where('test_id',$WBC->test_id)->where('verified','=','0')->update([
			'result_comment' => 'WBCs : Normal count and morphology'
		]);
	}else{
		TestEntryModel::where('regkey',$regkey)->where('test_id',$WBC->test_id)->where('verified','=','0')->update([
			'result_comment' => null
		]);
	}

	if ($WBC->result > $WBC->high  && $WBC->result <= $WBC->high * 2) {
		TestEntryModel::where('regkey',$regkey)->where('test_id',$WBC->test_id)->where('verified','=','0')->update([
			'result_comment' => 'WBCs : Mild Leucocytosis'
		]);
	}
	if ($WBC->result > $WBC->high * 2  && $WBC->result <= $WBC->high * 3) {
		TestEntryModel::where('regkey',$regkey)->where('test_id',$WBC->test_id)->where('verified','=','0')->update([
			'result_comment' => 'WBCs : Moderate Leucocytosis'
		]);
	}
	if ($WBC->result > $WBC->high*3 ) {
		TestEntryModel::where('regkey',$regkey)->where('test_id',$WBC->test_id)->where('verified','=','0')->update([
			'result_comment' => 'WBCs : Marked Leucocytosis'
		]);
	}

	if ($WBC->result < $WBC->low  && $WBC->result >= $WBC->low - 2) {
		TestEntryModel::where('regkey',$regkey)->where('test_id',$WBC->test_id)->where('verified','=','0')->update([
			'result_comment' => 'WBCs : Mild Leucopenia'
		]);
	}
	if ($WBC->result < $WBC->low -2  && $WBC->result >= $WBC->low - 3) {
		TestEntryModel::where('regkey',$regkey)->where('test_id',$WBC->test_id)->where('verified','=','0')->update([
			'result_comment' => 'WBCs : Moderate Leucopenia'
		]);}
	if ($WBC->result < $WBC->low - 3 &&  $WBC->result > 0) {
		TestEntryModel::where('regkey',$regkey)->where('test_id',$WBC->test_id)->where('verified','=','0')->update([
			'result_comment' => 'WBCs : Marked Leucopenia'
		]);}


	$WBCcomment = TestEntryModel::where('regkey',$regkey)->where('test_id','=','572')->first();
	
	if ($NEUT_comm->result < $NEUT_comm->low && $NEUT_comm->result > 0) {
		TestEntryModel::where('regkey',$regkey)->where('test_id',$NEUT->test_id)->where('verified','=','0')->update([
			'result_comment' => 'Absolute neutropenia'
		]);}
	if ($NEUT_comm->result > $NEUT_comm->high) {
		TestEntryModel::where('regkey',$regkey)->where('test_id',$NEUT->test_id)->where('verified','=','0')->update([
			'result_comment' => 'Absolute neutrophilia'
		]);}
	if ($NEUT_comm->result >= $NEUT_comm->low  && $NEUT_comm->result <= $NEUT_comm->high) {
		TestEntryModel::where('regkey',$regkey)->where('test_id',$NEUT->test_id)->where('verified','=','0')->update([
			'result_comment' => null
		]);}

		if (!$NEUT_comm->result) {
			TestEntryModel::where('regkey',$regkey)->where('test_id',$NEUT->test_id)->where('verified','=','0')->update([
				'result_comment' => null
			]);}

	if ($LYMPH_comm->result < $LYMPH_comm->low && $LYMPH_comm->result > 0) {
		TestEntryModel::where('regkey',$regkey)->where('test_id',$LYMPH->test_id)->where('verified','=','0')->update([
			'result_comment' => 'Absolute lymphopenia'
		]);}

	if ($LYMPH_comm->result > $LYMPH_comm->high) {
		TestEntryModel::where('regkey',$regkey)->where('test_id',$LYMPH->test_id)->where('verified','=','0')->update([
			'result_comment' => 'Absolute lymphocytosis'
		]);}
	if ($LYMPH_comm->result >= $LYMPH_comm->low  && $LYMPH_comm->result <= $LYMPH_comm->high) {
		TestEntryModel::where('regkey',$regkey)->where('test_id',$LYMPH->test_id)->where('verified','=','0')->update([
			'result_comment' => null
		]);}

	if (!$LYMPH_comm->result ) {
		TestEntryModel::where('regkey',$regkey)->where('test_id',$LYMPH->test_id)->where('verified','=','0')->update([
			'result_comment' => null
		]);}
	
	if ($MONO_comm->result > $MONO_comm->high) {
		TestEntryModel::where('regkey',$regkey)->where('test_id',$MONO->test_id)->where('verified','=','0')->update([
			'result_comment' => 'Absolute Mococytosis'
		]);}
	if ($MONO_comm->result >= $MONO_comm->low  && $MONO_comm->result <= $MONO_comm->high) {
		TestEntryModel::where('regkey',$regkey)->where('test_id',$MONO->test_id)->where('verified','=','0')->update([
			'result_comment' => null
		]);}

		if (!$MONO_comm->result) {
			TestEntryModel::where('regkey',$regkey)->where('test_id',$MONO->test_id)->where('verified','=','0')->update([
				'result_comment' => null
			]);}


if ($EOSINO_comm->result > $EOSINO_comm->high) {
	TestEntryModel::where('regkey',$regkey)->where('test_id',$EOSINO->test_id)->where('verified','=','0')->update([
		'result_comment' => 'Absolute eosinophilia'
	]);}
if ($EOSINO_comm->result >= $EOSINO_comm->low  && $EOSINO_comm->result <= $EOSINO_comm->high) {
	TestEntryModel::where('regkey',$regkey)->where('test_id',$EOSINO->test_id)->where('verified','=','0')->update([
		'result_comment' => null
	]);}

	if (!$EOSINO_comm->result ) {
		TestEntryModel::where('regkey',$regkey)->where('test_id',$EOSINO->test_id)->where('verified','=','0')->update([
			'result_comment' => null
		]);}

	if ($BASO_comm->result > $BASO_comm->high) {
		TestEntryModel::where('regkey',$regkey)->where('test_id',$BASO->test_id)->where('verified','=','0')->update([
			'result_comment' => 'Absolute basophilia'
		]);}
	if ($BASO_comm->result >= $BASO_comm->low  && $BASO_comm->result <= $BASO_comm->high) {
		TestEntryModel::where('regkey',$regkey)->where('test_id',$BASO->test_id)->where('verified','=','0')->update([
			'result_comment' => null
		]);}

	if (!$BASO_comm->result ) {
		TestEntryModel::where('regkey',$regkey)->where('test_id',$BASO->test_id)->where('verified','=','0')->update([
			'result_comment' => null
		]);}
		}

		
	$childcount = TestEntryModel::where('regkey',$regkey)->where('megatest_id',$megatest_id)->where('seperate_test',$seperate_test)->whereNull('result')->whereHas('TestData', function($q) use($group) {
		$q->where('test_group',$group)->where('active',false);
	})->count();
// dd($childcount);

	if($childcount > 0){
		TestEntryModel::where('regkey',$regkey)->where('megatest_id',$megatest_id)->where('seperate_test',$seperate_test)->whereHas('TestData', function($q) use($group) {
			$q->where('test_group',$group)->where('active',false);
		})->update(['completed'=>false]);
	}else{
		TestEntryModel::where('regkey',$regkey)->where('megatest_id',$megatest_id)->where('seperate_test',$seperate_test)->whereNotNull('result')->whereHas('TestData', function($q) use($group) {
			$q->where('test_group',$group)->where('active',false);
		})->update(['completed'=>true]);

	}

      TestEntryModel::where('regkey',$regkey)->where('megatest_id',$megatest_id)->where('seperate_test',$seperate_test)->whereNotNull('result')->whereHas('TestData', function($q) use($group) {
		$q->where('test_group',$group)->where('active',true);
	})->update(['completed'=>true]);

	TestEntryModel::where('regkey',$regkey)->where('megatest_id',$megatest_id)->where('seperate_test',$seperate_test)->whereNull('result')->whereHas('TestData', function($q) use($group) {
		$q->where('test_group',$group)->where('active',true);
	})->update(['completed'=>false]);

		return redirect()->back();
		// return redirect()->route('resultentry',array('regkey' => $regkey,'group' => $group  ,'megatest_id' => $megatest_id , 'seperate_test' => $SeperateTest));
		}
		public function VerifyGroup(Request $request,$regkey,$group,$seperate_test) {
			$completecount = TestEntryModel::where('completed',true)->whereNull('megatest_id')->where('regkey',$regkey)->whereNull('megatest_id')->where('seperate_test',$seperate_test)->whereHas('TestData', function($q) use($group) {
				$q->where('test_group',$group);
		})->count();
	
			// dd($count);
		if($completecount == 0) {
			return redirect()->back()->with('status','Results not completed');

		}else {

			$TestEntry = TestEntryModel::query()->where('seperate_test',$seperate_test)->whereNull('megatest_id')->where('completed',true)->whereHas('TestData', function($q) use($group) {
				$q->where('test_group',$group);
				})->update(['verified'=>'1']);
			return redirect()->back();
}
		}

		public function VerifyMega(Request $request,$regkey,$group,$megatest_id ,$seperate_test) {
			$completecount = TestEntryModel::where('completed',true)->whereNotNull('megatest_id')->where('regkey',$regkey)->where('seperate_test',$seperate_test)->whereHas('TestData', function($q) use($group) {
				$q->where('test_group',$group);
		})->whereHas('MegaTests', function($q) use($megatest_id) {
			$q->where('megatest_id',$megatest_id);
		})->count();
	
			// dd($completecount);
		if($completecount == 0) {
			return redirect()->back()->with('status','Results not completed');

		}else {

		$TestEntry = TestEntryModel::query()->where('seperate_test',$seperate_test)->whereNotNull('megatest_id')->where('completed',true)->whereHas('TestData', function($q) use($group) {
			$q->where('test_group',$group);
			})->whereHas('MegaTests', function($q) use($megatest_id) {
			$q->where('megatest_id',$megatest_id);
			})->update(['verified'=>'1']);
		return redirect()->back();
}
		}
}