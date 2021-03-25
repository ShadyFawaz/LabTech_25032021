<?php

namespace App\Http\Controllers\NormalRanges;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\NormalRangesModel;
use App\TestDataModel;
use App\PatientConditionModel;


class NormalRangesController extends Controller
{
    
    public function insert(){
		$TestData          = TestDataModel::get();
		$PatientCondition  = PatientConditionModel::get();
        return view('normalranges\Newnormalranges',compact('TestData','PatientCondition'));
    }
    public function create(Request $request){
		//dd($request->all());
        $rules = [
			'test_id'   => 'integer|min:1',
			'gender'    => 'required|string|min:1|max:255',
			'age_from'  => 'required|integer|min:0|max:255',
			'age_to'    => 'required|integer|min:1|max:255',
			'age'       => 'required|string|min:1|max:255',
		];
		
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('newnormalranges')->with('status',"Insert failed");
		}
		else{
            $data = $request->input();
			try{
				$user = new NormalRangesModel();
				$user->test_id             = $data['test_id'];
				$user->low                 = $data['low'];
				$user->high                = $data['high'];
				$user->nn_normal           = $data['nn_normal'];
				$user->age_from            = $data['age_from'];
				$user->age_to              = $data['age_to'];
				$user->age                 = $data['age'];
				$user->gender              = $data['gender'];
				$user->patient_condition   = $data['patient_condition'];
				$user->active              = $data['active'];
               
				$user->save();
				return redirect('newnormalranges')->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('newnormalranges')->with('failed',"operation failed");
			}
		}
    }

	public function delete($normal_id){
	NormalRangesModel::where('normal_id',$normal_id)->delete();
        return redirect()->back();
    }
}