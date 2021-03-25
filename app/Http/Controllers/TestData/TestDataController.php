<?php

namespace App\Http\Controllers\TestData;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\TestDataModel;
use App\SubgroupsModel;
use App\LabUnitModel;
use App\SampleConditionModel;
use App\SampleTypeModel;
use App\CultureLinkModel;
use App\ResultsUnitsModel;
use App\GroupsModel;
use DB;


class TestDataController extends Controller
{
    
	public function index(){
		$Groups          = GroupsModel::get();
		$LabUnit         = LabUnitModel::get();
		$SampleCondition = SampleConditionModel::get();
		$SampleType      = SampleTypeModel::get();
		$Culturelink     = CultureLinkModel::get();
		$ResultsUnits    = ResultsUnitsModel::get();
		$users           = TestDataModel::orderBy('abbrev')->get();
		return view('testdata\testdata',['users'=>$users],compact(['Groups','LabUnit','SampleCondition','SampleType','Culturelink','ResultsUnits']));
		}  
		public function back(){
		return redirect()->back();
		}
}