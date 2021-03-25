<?php

namespace App\Http\Controllers\LabUnit;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\LabUnitModel;
use DB;

class EditLabUnitController extends Controller
{
    
    public function index(){
		$users = LabUnitModel::get();
		return view('labunit\labunit',['users'=>$users]);
		}
		public function show($labunit_id) {
			$users = LabUnitModel::where('labunit_id',$labunit_id)->get();
			return view('labunit\editlabunit',['users'=>$users]);
		}
		public function edit(Request $request,$labunit_id) {
		$lab_unit = $request->input('lab_unit');
		
		$users = LabUnitModel::where('labunit_id',$labunit_id)->update([
			'lab_unit'  =>  $lab_unit
		]);

		return redirect('labunit')->with('status',"Updated Successfully");
		
		}
}