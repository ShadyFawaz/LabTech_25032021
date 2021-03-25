<?php

namespace App\Http\Controllers\Diagnosis;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\DiagnosisModel;
use DB;

class EditDiagnosisController extends Controller
{
    
    public function index(){
		$users = DiagnosisModel::get();
		return view('diagnosis\diagnosis',['users'=>$users]);
		}

		public function show($diagnosis_id) {
		$users = DiagnosisModel::where('diagnosis_id',$diagnosis_id)->get();
		return view('diagnosis\editdiagnosis',['users'=>$users]);
		}

		public function edit(Request $request,$diagnosis_id) {
		$diagnosis   = $request->input('diagnosis');
		$description = $request->input('description');
		$users       = DiagnosisModel::where('diagnosis_id',$diagnosis_id)->update([

			'diagnosis'   => $diagnosis,
			'description' => $description

			]);
		return redirect('diagnosis')->with('status',"Updated Successfully");
		
		}
}