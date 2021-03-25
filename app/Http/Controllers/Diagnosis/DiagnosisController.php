<?php

namespace App\Http\Controllers\Diagnosis;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\DiagnosisModel;


class DiagnosisController extends Controller
{
    
    public function insert(){
        return view('Diagnosis\newdiagnosis');
    }
    public function create(Request $request){
		//dd($request->all());
        $rules = [
			'diagnosis' => 'required|string|min:2|max:255',
			'description' => 'required|string|min:2|max:255',
		];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('newdiagnosis')->with('status',"Insert failed");
		}
		else{
            $data = $request->input();
			try{
				$user = new DiagnosisModel();
                $user->diagnosis = $data['diagnosis'];
                $user->description = $data['description'];
				$user->save();
				return redirect('diagnosis')->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('newdiagnosis')->with('failed',"Insert failed");
			}
		}
	}
	public function delete(Request $request,$diagnosis_id){
        
		DiagnosisModel::query()->where('diagnosis_id', $diagnosis_id)->delete();
		return redirect()->back();
	}
	public function restore(Request $request,$diagnosis_id){
        
		DiagnosisModel::query()->where('diagnosis_id', $diagnosis_id)->restore();
		return redirect()->back();
	}
}