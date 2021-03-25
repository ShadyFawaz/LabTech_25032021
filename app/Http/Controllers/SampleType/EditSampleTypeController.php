<?php

namespace App\Http\Controllers\SampleType;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use App\SampleTypeModel;

class EditSampleTypeController extends Controller
{
    
    public function index(){
		$users = SampleTypeModel::get();
		return view('sampletype\sampletype',['users'=>$users]);
		}
		public function show($sampletype_id) {
			$users = SampleTypeModel::where('sampletype_id',$sampletype_id)->get();
			return view('sampletype\editsampletype',['users'=>$users]);
		}
		public function edit(Request $request,$sampletype_id) {
		$sample_type = $request->input('sample_type');
	
		$users = SampleTypeModel::where('sampletype_id',$sampletype_id)->update([
			'sample_type'   =>   $sample_type
		]);
		return redirect('sampletype')->with('status',"Updated Successfully");
		
		}
}