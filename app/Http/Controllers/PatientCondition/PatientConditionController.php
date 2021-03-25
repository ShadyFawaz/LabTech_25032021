<?php

namespace App\Http\Controllers\PatientCondition;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\PatientConditionModel;
use DB;


class PatientConditionController extends Controller
{

	

	public function index(){
		$users = PatientConditionModel::get();
		return view('patientcondition\patientcondition',['users'=>$users]);
		}  

	public function trashedIndex(){
		$users = PatientConditionModel::onlyTrashed()->get();
		return view('patientcondition\patientcondition',['users'=>$users]);
		} 

	public function show($patientcondition_id) {
		$users = PatientConditionModel::where('patientcondition_id',$patientcondition_id)->get();
		return view('patientcondition\editpatientcondition',['users'=>$users]);
		}

	public function edit(Request $request,$patientcondition_id) {
	$patient_condition = $request->input('patient_condition');
	$users = PatientConditionModel::where('patientcondition_id',$patientcondition_id)->update([

		'patient_condition' => $patient_condition
		
		]);

			return redirect('patientcondition')->with('status',"Updated Successfully");
			
			}
			
    public function insert(){
        
        return view('patientcondition\newpatientcondition');
    }
    public function create(Request $request){
		//dd($request->all());
        $rules = [
			'patient_condition' => 'required|string|min:2|max:255',
		];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('newpatientcondition')->with('status',"Insert failed");
		}
		else{
            $data = $request->input();
			try{
				$user = new PatientConditionModel();
                $user->patient_condition = $data['patient_condition'];
				$user->save();
				return redirect('patientcondition')->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('newpatientcondition')->with('failed',"Insert failed");
			}	
		}	
	}
	public function delete(Request $request,$patientcondition_id){
        
		PatientConditionModel::query()->where('patientcondition_id', $patientcondition_id)->delete();
		return redirect()->back();
	}
	public function restore(Request $request,$patientcondition_id){
        
		PatientConditionModel::query()->where('patientcondition_id', $patientcondition_id)->restore();
		return redirect()->back();
	}
}

