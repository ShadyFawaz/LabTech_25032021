<?php

namespace App\Http\Controllers\SampleCondition;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use App\SampleConditionModel;

class EditSampleConditionController extends Controller
{
    
    public function index(){
		$users = SampleConditionModel::get();
		return view('samplecondition\samplecondition',['users'=>$users]);
		}
		public function show($samplecondition_id) {
			$users = SampleConditionModel::where('samplecondition_id',$samplecondition_id)->get();
			return view('samplecondition\editsamplecondition',['users'=>$users]);
		}
		public function edit(Request $request,$samplecondition_id) {
		$sample_condition = $request->input('sample_condition');
		
		$users = SampleConditionModel::where('samplecondition_id',$samplecondition_id)->update([
			'sample_condition'  =>  $sample_condition
		]);
		return redirect('samplecondition')->with('status',"Updated Successfully");
		
		}
}