<?php

namespace App\Http\Controllers;

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
use App\AntibioticEntryModel;
use Carbon\Carbon;
use DB;


class CBCReportController extends Controller
{
	public function indexMega(){

		$Results = TestEntryModel::whereHas('PatientReg', function($q) {
			$q->whereDate('req_date',Carbon::today());
	})->get();
	$CBC = TestEntryModel::whereHas('MegaTests', function($q) {
		$q->where('megatest_id','=','405');
		})->whereHas('TestData', function($q) {
			$q->whereNull('profile')->whereNull('test_header');
		})->get();

		$Relative = TestEntryModel::whereHas('TestData', function($q) {
			$q->where('test_header','=','Relative Count');
		})->whereHas('MegaTests', function($q) {
			$q->where('megatest_id','=','405');
		})->get();

		$Absolute = TestEntryModel::whereHas('TestData', function($q) {
			$q->where('test_header','=','Absolute Count');
		})
		->whereHas('MegaTests', function($q) {
			$q->where('megatest_id','=','405');
		})->get();

		dd($Absolute);
	
		

		$Results = TestEntryModel::query()->with('PatientReg','TestData','TestData.Groups','MegaTests',
		'PatientReg.Doctor','PatientReg.Titles')->whereHas('TestData', function($q) use($group) {
				$q->where('test_group',$group);
		})->whereHas('MegaTests', function($q) use($megatest_id) {
			$q->where('megatest_id',$megatest_id);
	})->where('regkey',$regkey)->where('seperate_test',$seperate_test)->whereNotNull('result')->where('result','<>','.')->where('verified',true)->where('report_printed','=','1')
		->get()->sortBy('TestData.test_order',SORT_REGULAR,false);

		$CommentCheck  = $Results->whereNotNull('result_comment')->count();

		$ResultComment = TestEntryModel::query()->with('PatientReg','TestData','TestData.Groups','MegaTests',
		'PatientReg.Doctor','PatientReg.Titles')->whereHas('TestData', function($q) use($group) {
				$q->where('test_group',$group);
		})->whereHas('MegaTests', function($q) use($megatest_id) {
			$q->where('megatest_id',$megatest_id);
	})->where('regkey',$regkey)->where('seperate_test',$seperate_test)->whereNotNull('result')->where('result','<>','.')->where('verified',true)->where('report_printed','=','1')
		->get()->sortBy('TestData.test_order',SORT_REGULAR,false);

	
		dd($Results);
		$patient        = $Results[0]->PatientReg;
		$groupName      = $Results[0]->TestData->Groups->report_name;
		$meganame       = $Results[0]->MegaTests->report_name;
// dd($meganame);
		TestEntryModel::query()->where('regkey',$regkey)->whereNull('megatest_id')->where('seperate_test',$seperate_test)->where('verified',true)->whereHas('TestData', function($q) use($group) {
			$q->where('test_group',$group);
		})->whereHas('MegaTests', function($q) use($megatest_id) {
			$q->where('megatest_id',$megatest_id);
		})->update(['printed' => '1']);
// dd($ResultComment);
		return view('reportcbc',['Results'=>$resultMap,'ResultComment'=>$ResultComment],compact('patient','groupName','meganame','CommentCheck'));
		}  
	}
