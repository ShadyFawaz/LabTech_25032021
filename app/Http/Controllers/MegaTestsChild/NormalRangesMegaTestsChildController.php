<?php

namespace App\Http\Controllers\MegaTestsChild;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\NormalRangesModel;
use App\TestDataModel;
use App\PatientConditionModel;
use App\MegaTestsChildModel;
use DB;


class NormalRangesMegaTestsChildController extends Controller
{
    
	public function index($test_id){
		$TestData          = TestDataModel::get();
		$MegaTestsChild    = MegaTestsChildModel::get();
		$PatientCondition  = PatientConditionModel::get();
		$users             = NormalRangesModel::with(['TestData'])->where('test_id',$test_id)->get();
		//dd($users->toArray());
		return view('normalranges\normalranges',['users'=>$users],compact('TestData','PatientCondition','test_id','MegaTestsChild'));
		}  

		
}