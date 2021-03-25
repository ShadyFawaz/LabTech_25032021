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
use DB;


class ReportController extends Controller
{
    
	public function indexGroup($regkey,$group,$seperate_test){

		$verifycount = TestEntryModel::where('verified','=','1')->where('regkey',$regkey)->whereNull('megatest_id')->whereHas('TestData', function($q) use($group) {
			$q->where('test_group',$group);
	})->count();

		// dd($count);
		if($verifycount == 0) {

			return 'Results Not Verified';
			// return redirect()->back()->with(['message'=>'User not found']);

		}else {
		

		$Results = TestEntryModel::query()->with('PatientReg','TestData','TestData.Groups','MegaTests',
		'PatientReg.Doctor','PatientReg.Titles')->whereHas('TestData', function($q) use($group) {
				$q->where('test_group',$group);
		})->where('regkey',$regkey)->whereNull('megatest_id')->where('seperate_test',$seperate_test)->whereNotNull('result')->where('result','<>','.')->where('verified','=','1')->where('report_printed','=','1')
		->get()->sortBy('TestData.test_order',SORT_REGULAR,false);
		$CommentCheck  = $Results->whereNotNull('result_comment')->count();
		$ResultComment = TestEntryModel::query()->with('PatientReg','TestData','TestData.Groups','MegaTests',
		'PatientReg.Doctor','PatientReg.Titles')->whereHas('TestData', function($q) use($group) {
				$q->where('test_group',$group);
		})->where('regkey',$regkey)->whereNull('megatest_id')->where('seperate_test',$seperate_test)->whereNotNull('result')->where('result','<>','.')->where('verified','=','1')->where('report_printed','=','1')
		->get()->sortBy('TestData.test_order',SORT_REGULAR,false);

	// dd($ResultComment);
		$resultMap = [];
		$cultureEntriesMap = [];
		$cultureLinkId = null;
		foreach ($Results as $key => $result) {
			if($result->TestData->profile && $result->TestData->test_header){
				$resultMap[$result->TestData->profile][$result->TestData->test_header][] = $result;
			}
			if($result->TestData->profile && !$result->TestData->test_header){
				$resultMap[$result->TestData->profile][] = $result;
			}
			if($result->TestData->test_header && !$result->TestData->profile){
				$resultMap[$result->TestData->test_header][] = $result;
			}
			if(!$result->TestData->test_header && !$result->TestData->profile){
				$resultMap[] = $result;
			}
			if($result->TestData->culture_link){
				$cultureLinkId = $result->TestData->culture_link;
			}
			
		}

		if($cultureLinkId){
			$antibioticEntries = AntibioticEntryModel::query()
			->with(['Organism','Antibiotics','CultureLink'])
			->where('culture_link',$cultureLinkId)
			->whereHas('Organism')
			->where('regkey',$regkey)->get();
			foreach($antibioticEntries as $entry){
				    $cultureEntriesMap[$entry->organism_id]['organism_name'] = $entry->Organism->organism;
				if($entry->sensitivity){
					$cultureEntriesMap[$entry->organism_id]['sensitivities'][$entry->sensitivity]['antibiotics'][] = $entry->Antibiotics ? $entry->Antibiotics->report_name : null; 
				}else{
					$cultureEntriesMap[$entry->organism_id]['sensitivities'] = [];
				}

			}
		}
		// dd($cultureEntriesMap);
		$patient        = $Results[0]->PatientReg;
		$groupName      = $Results[0]->TestData->Groups->report_name;
		$meganame       = $Results[0]->megatest_id;
// dd($meganame);
		TestEntryModel::query()->where('regkey',$regkey)->whereNull('megatest_id')->where('seperate_test',$seperate_test)->where('verified',true)->whereHas('TestData', function($q) use($group) {
			$q->where('test_group',$group);
		})->update(['printed' => '1']);
// dd($ResultComment);
		return view('report',['Results'=>$resultMap,'cultureMap' => $cultureEntriesMap,'ResultComment'=>$ResultComment],compact('patient','groupName','meganame','CommentCheck'));
		}  
	}

	public function indexGroupPDF($regkey,$group,$seperate_test){

		$verifycount = TestEntryModel::where('verified','=','1')->where('regkey',$regkey)->whereNull('megatest_id')->whereHas('TestData', function($q) use($group) {
			$q->where('test_group',$group);
	})->count();

		// dd($count);
		if($verifycount == 0) {

			return 'Results Not Verified';
			// return redirect()->back()->with(['message'=>'User not found']);

		}else {
		

		$Results = TestEntryModel::query()->with('PatientReg','TestData','TestData.Groups','MegaTests',
		'PatientReg.Doctor','PatientReg.Titles')->whereHas('TestData', function($q) use($group) {
				$q->where('test_group',$group);
		})->where('regkey',$regkey)->whereNull('megatest_id')->where('seperate_test',$seperate_test)->whereNotNull('result')->where('result','<>','.')->where('verified','=','1')->where('report_printed','=','1')
		->get()->sortBy('TestData.test_order',SORT_REGULAR,false);
		$CommentCheck  = $Results->whereNotNull('result_comment')->count();
		$ResultComment = TestEntryModel::query()->with('PatientReg','TestData','TestData.Groups','MegaTests',
		'PatientReg.Doctor','PatientReg.Titles')->whereHas('TestData', function($q) use($group) {
				$q->where('test_group',$group);
		})->where('regkey',$regkey)->whereNull('megatest_id')->where('seperate_test',$seperate_test)->whereNotNull('result')->where('result','<>','.')->where('verified','=','1')->where('report_printed','=','1')
		->get()->sortBy('TestData.test_order',SORT_REGULAR,false);

	// dd($ResultComment);
		$resultMap = [];
		$cultureEntriesMap = [];
		$cultureLinkId = null;
		foreach ($Results as $key => $result) {
			if($result->TestData->profile && $result->TestData->test_header){
				$resultMap[$result->TestData->profile][$result->TestData->test_header][] = $result;
			}
			if($result->TestData->profile && !$result->TestData->test_header){
				$resultMap[$result->TestData->profile][] = $result;
			}
			if($result->TestData->test_header && !$result->TestData->profile){
				$resultMap[$result->TestData->test_header][] = $result;
			}
			if(!$result->TestData->test_header && !$result->TestData->profile){
				$resultMap[] = $result;
			}
			if($result->TestData->culture_link){
				$cultureLinkId = $result->TestData->culture_link;
			}
			
		}

		if($cultureLinkId){
			$antibioticEntries = AntibioticEntryModel::query()
			->with(['Organism','Antibiotics','CultureLink'])
			->where('culture_link',$cultureLinkId)
			->whereHas('Organism')
			->where('regkey',$regkey)->get();
			foreach($antibioticEntries as $entry){
				    $cultureEntriesMap[$entry->organism_id]['organism_name'] = $entry->Organism->organism;
				if($entry->sensitivity){
					$cultureEntriesMap[$entry->organism_id]['sensitivities'][$entry->sensitivity]['antibiotics'][] = $entry->Antibiotics ? $entry->Antibiotics->report_name : null; 
				}else{
					$cultureEntriesMap[$entry->organism_id]['sensitivities'] = [];
				}

			}
		}
		// dd($cultureEntriesMap);
		$patient        = $Results[0]->PatientReg;
		$groupName      = $Results[0]->TestData->Groups->report_name;
		$meganame       = $Results[0]->megatest_id;
// dd($meganame);
		TestEntryModel::query()->where('regkey',$regkey)->whereNull('megatest_id')->where('seperate_test',$seperate_test)->where('verified',true)->whereHas('TestData', function($q) use($group) {
			$q->where('test_group',$group);
		})->update(['printed' => '1']);
// dd($ResultComment);
		return view('reportPDF',['Results'=>$resultMap,'cultureMap' => $cultureEntriesMap,'ResultComment'=>$ResultComment],compact('patient','groupName','meganame','CommentCheck'));
		}  
	}




	public function indexMega($regkey,$group,$megatest_id,$seperate_test){
		$MegaTestID = MegaTestsModel::query()->where('megatest_id',$megatest_id)->first();
// dd($MegaTestID);
		$verifycount = TestEntryModel::where('verified',true)->where('regkey',$regkey)->whereHas('TestData', function($q) use($group) {
			$q->where('test_group',$group);
	})->whereHas('MegaTests', function($q) use($megatest_id) {
		$q->where('megatest_id',$megatest_id);
})->count();

		// dd($count);
		if($verifycount == 0) {

			return 'Results Not Verified';
			// return redirect()->back()->with(['message'=>'User not found']);

		}else {
		

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
	})->where('regkey',$regkey)->where('seperate_test',$seperate_test)->whereNotNull('result')->whereNotNull('result_comment')->where('result','<>','.')->where('verified',true)->where('report_printed','=','1')
		->get()->sortBy('TestData.test_order',SORT_REGULAR,false);

		$CBC = TestEntryModel::query()->with('PatientReg','TestData','TestData.Groups','MegaTests',
		'PatientReg.Doctor','PatientReg.Titles')->whereHas('MegaTests', function($q) use($megatest_id){
			$q->where('megatest_id',$megatest_id);
			})->whereHas('TestData', function($q) {
				$q->whereNull('profile')->whereNull('test_header');
			})->where('regkey',$regkey)->where('seperate_test',$seperate_test)->whereNotNull('result')->where('result','<>','.')->where('verified',true)->where('report_printed','=','1')
			->get()->sortBy('TestData.test_order',SORT_REGULAR,false);


			$Relative = TestEntryModel::whereHas('TestData', function($q) {
				$q->where('test_header','=','Relative Count');
			})->whereHas('MegaTests', function($q) use($megatest_id) {
				$q->where('megatest_id',$megatest_id);
			})->where('regkey',$regkey)->where('seperate_test',$seperate_test)->whereNotNull('result')->where('result','<>','.')->where('verified',true)->where('report_printed','=','1')
			->get()->sortBy('TestData.test_order',SORT_REGULAR,false);
	
			$Absolute = TestEntryModel::whereHas('TestData', function($q) {
				$q->where('test_header','=','Absolute Count');
			})
			->whereHas('MegaTests', function($q) use($megatest_id){
				$q->where('megatest_id',$megatest_id);
			})->where('regkey',$regkey)->where('seperate_test',$seperate_test)->whereNotNull('result')->where('result','<>','.')->where('verified',true)->where('report_printed','=','1')
			->get()->sortBy('TestData.test_order',SORT_REGULAR,false);


	// dd($Absolute);
		$resultMap = [];
		$cultureEntriesMap = [];
		$cultureLinkId = null;
		foreach ($Results as $key => $result) {
			if($result->TestData->profile && $result->TestData->test_header){
				$resultMap[$result->TestData->profile][$result->TestData->test_header][] = $result;
			}
			if($result->TestData->profile && !$result->TestData->test_header){
				$resultMap[$result->TestData->profile][] = $result;
			}
			if($result->TestData->test_header && !$result->TestData->profile){
				$resultMap[$result->TestData->test_header][] = $result;
			}
			if(!$result->TestData->test_header && !$result->TestData->profile){
				$resultMap[] = $result;
			}
			if($result->TestData->culture_link){
				$cultureLinkId = $result->TestData->culture_link;
			}
			
		}

		if($cultureLinkId){
			$antibioticEntries = AntibioticEntryModel::query()
			->with(['Organism','Antibiotics','CultureLink'])
			->where('culture_link',$cultureLinkId)
			->whereHas('Organism')
			->where('regkey',$regkey)->get();
			foreach($antibioticEntries as $entry){
				    $cultureEntriesMap[$entry->organism_id]['organism_name'] = $entry->Organism->organism;
				if($entry->sensitivity){
					$cultureEntriesMap[$entry->organism_id]['sensitivities'][$entry->sensitivity]['antibiotics'][] = $entry->Antibiotics ? $entry->Antibiotics->report_name : null; 
				}else{
					$cultureEntriesMap[$entry->organism_id]['sensitivities'] = [];
				}

			}
		}
		// dd($cultureEntriesMap);
		$patient        = $Results[0]->PatientReg;
		$groupName      = $Results[0]->TestData->Groups->report_name;
		$meganame       = $Results[0]->MegaTests->report_name;
// dd($meganame);
		TestEntryModel::query()->where('regkey',$regkey)->where('seperate_test',$seperate_test)->where('verified',true)->whereHas('TestData', function($q) use($group) {
			$q->where('test_group',$group);
		})->whereHas('MegaTests', function($q) use($megatest_id) {
			$q->where('megatest_id',$megatest_id);
		})->update(['printed' => '1']);
// dd($ResultComment);
if($MegaTestID->report_type){
	return view($MegaTestID->report_type,['Results'=>$resultMap,'cultureMap' => $cultureEntriesMap,'ResultComment'=>$ResultComment , 'MegaTestID'=>$MegaTestID],compact('patient','groupName','meganame','CommentCheck','CBC','Relative','Absolute'));
}else{
	return view('report',['Results'=>$resultMap,'cultureMap' => $cultureEntriesMap,'ResultComment'=>$ResultComment],compact('patient','groupName','meganame','CommentCheck'));

}
		}  
	}
	public function indexMegaPDF($regkey,$group,$megatest_id,$seperate_test){
		$MegaTestID = MegaTestsModel::query()->where('megatest_id',$megatest_id)->first();
// dd($MegaTestID);
		$verifycount = TestEntryModel::where('verified',true)->where('regkey',$regkey)->whereHas('TestData', function($q) use($group) {
			$q->where('test_group',$group);
	})->whereHas('MegaTests', function($q) use($megatest_id) {
		$q->where('megatest_id',$megatest_id);
})->count();

		// dd($count);
		if($verifycount == 0) {

			return 'Results Not Verified';
			// return redirect()->back()->with(['message'=>'User not found']);

		}else {
		

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
	})->where('regkey',$regkey)->where('seperate_test',$seperate_test)->whereNotNull('result')->whereNotNull('result_comment')->where('result','<>','.')->where('verified',true)->where('report_printed','=','1')
		->get()->sortBy('TestData.test_order',SORT_REGULAR,false);

		$CBC = TestEntryModel::query()->with('PatientReg','TestData','TestData.Groups','MegaTests',
		'PatientReg.Doctor','PatientReg.Titles')->whereHas('MegaTests', function($q) use($megatest_id){
			$q->where('megatest_id',$megatest_id);
			})->whereHas('TestData', function($q) {
				$q->whereNull('profile')->whereNull('test_header');
			})->where('regkey',$regkey)->where('seperate_test',$seperate_test)->whereNotNull('result')->where('result','<>','.')->where('verified',true)->where('report_printed','=','1')
			->get()->sortBy('TestData.test_order',SORT_REGULAR,false);


			$Relative = TestEntryModel::whereHas('TestData', function($q) {
				$q->where('test_header','=','Relative Count');
			})->whereHas('MegaTests', function($q) use($megatest_id) {
				$q->where('megatest_id',$megatest_id);
			})->where('regkey',$regkey)->where('seperate_test',$seperate_test)->whereNotNull('result')->where('result','<>','.')->where('verified',true)->where('report_printed','=','1')
			->get()->sortBy('TestData.test_order',SORT_REGULAR,false);
	
			$Absolute = TestEntryModel::whereHas('TestData', function($q) {
				$q->where('test_header','=','Absolute Count');
			})
			->whereHas('MegaTests', function($q) use($megatest_id){
				$q->where('megatest_id',$megatest_id);
			})->where('regkey',$regkey)->where('seperate_test',$seperate_test)->whereNotNull('result')->where('result','<>','.')->where('verified',true)->where('report_printed','=','1')
			->get()->sortBy('TestData.test_order',SORT_REGULAR,false);


	// dd($Absolute);
		$resultMap = [];
		$cultureEntriesMap = [];
		$cultureLinkId = null;
		foreach ($Results as $key => $result) {
			if($result->TestData->profile && $result->TestData->test_header){
				$resultMap[$result->TestData->profile][$result->TestData->test_header][] = $result;
			}
			if($result->TestData->profile && !$result->TestData->test_header){
				$resultMap[$result->TestData->profile][] = $result;
			}
			if($result->TestData->test_header && !$result->TestData->profile){
				$resultMap[$result->TestData->test_header][] = $result;
			}
			if(!$result->TestData->test_header && !$result->TestData->profile){
				$resultMap[] = $result;
			}
			if($result->TestData->culture_link){
				$cultureLinkId = $result->TestData->culture_link;
			}
			
		}

		if($cultureLinkId){
			$antibioticEntries = AntibioticEntryModel::query()
			->with(['Organism','Antibiotics','CultureLink'])
			->where('culture_link',$cultureLinkId)
			->whereHas('Organism')
			->where('regkey',$regkey)->get();
			foreach($antibioticEntries as $entry){
				    $cultureEntriesMap[$entry->organism_id]['organism_name'] = $entry->Organism->organism;
				if($entry->sensitivity){
					$cultureEntriesMap[$entry->organism_id]['sensitivities'][$entry->sensitivity]['antibiotics'][] = $entry->Antibiotics ? $entry->Antibiotics->report_name : null; 
				}else{
					$cultureEntriesMap[$entry->organism_id]['sensitivities'] = [];
				}

			}
		}
		// dd($cultureEntriesMap);
		$patient        = $Results[0]->PatientReg;
		$groupName      = $Results[0]->TestData->Groups->report_name;
		$meganame       = $Results[0]->MegaTests->report_name;
// dd($meganame);
		TestEntryModel::query()->where('regkey',$regkey)->where('seperate_test',$seperate_test)->where('verified',true)->whereHas('TestData', function($q) use($group) {
			$q->where('test_group',$group);
		})->whereHas('MegaTests', function($q) use($megatest_id) {
			$q->where('megatest_id',$megatest_id);
		})->update(['printed' => '1']);
// dd($ResultComment);
if($MegaTestID->report_type){
	return view($MegaTestID->report_type.'PDF',['Results'=>$resultMap,'cultureMap' => $cultureEntriesMap,'ResultComment'=>$ResultComment , 'MegaTestID'=>$MegaTestID],compact('patient','groupName','meganame','CommentCheck','CBC','Relative','Absolute'));
}else{
	return view('reportPDF',['Results'=>$resultMap,'cultureMap' => $cultureEntriesMap,'ResultComment'=>$ResultComment],compact('patient','groupName','meganame','CommentCheck'));

}
		}  
	}

}