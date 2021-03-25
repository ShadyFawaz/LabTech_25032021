<?php

namespace App\Http\Controllers\SampleCondition;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\SampleConditionModel;
use DB;

class SampleConditionController extends Controller
{
    
    public function insert(){
        
        return view('samplecondition\newsamplecondition');
    }
    public function create(Request $request){
		//dd($request->all());
        $rules = [
			'sample_condition' => 'required|string|min:2|max:255',
		];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('newsamplecondition')->with('status',"Insert failed");
		}
		else{
            $data = $request->input();
			try{
				$user = new SampleConditionModel();
                $user->sample_condition = $data['sample_condition'];
				$user->save();
				return redirect('samplecondition')->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('newsamplecondition')->with('failed',"Insert failed");
			}
		}
	}
	public function delete(Request $request,$samplecondition_id){
        
		DB::table('sample_condition')->where('samplecondition_id', $samplecondition_id)->delete();
		return redirect()->back();
		}
}