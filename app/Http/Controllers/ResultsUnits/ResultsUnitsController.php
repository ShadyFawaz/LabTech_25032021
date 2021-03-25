<?php

namespace App\Http\Controllers\ResultsUnits;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\ResultsUnitsModel;


class ResultsUnitsController extends Controller
{
    
    public function insert(){
        
        return view('resultsunits\newresultsunits');
    }
    public function create(Request $request){
		//dd($request->all());
        $rules = [
			'result_unit' => 'required|string|min:1|max:255',
		];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('newresultsunits')->with('status',"Insert failed");
		}
		else{
            $data = $request->input();
			try{
				$user = new ResultsUnitsModel();
                $user->result_unit = $data['result_unit'];
				$user->save();
				return redirect('resultsunits')->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('newresultsunits')->with('failed',"Insert failed");
			}
		}
    }
}