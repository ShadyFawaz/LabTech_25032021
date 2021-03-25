<?php

namespace App\Http\Controllers\Antibiotics;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\AntibioticsModel;


class AntibioticsController extends Controller
{
    
    public function insert(){
        
        return view('antibiotics\Newantibiotic');
    }
    public function create(Request $request){
		//dd($request->all());
        $rules = [
			'antibiotic_name' => 'required|string|min:2|max:255',
			'report_name' => 'required|string|min:2|max:255',
			
		];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('newantibiotic')->with('status',"Insert failed");
		}
		else{
            $data = $request->input();
			try{
				$user = new AntibioticsModel();
                $user->antibiotic_name = $data['antibiotic_name'];
                $user->report_name = $data['report_name'];
				$user->save();
				return redirect('antibiotics')->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('newantibiotic')->with('failed',"operation failed");
			}
		}
	}
	public function delete(Request $request,$antibiotic_id){
        
		AntibioticsModel::query()->where('antibiotic_id', $antibiotic_id)->delete();
		return redirect()->back();
	}

	public function restore(Request $request,$antibiotic_id){
        
		AntibioticsModel::query()->where('antibiotic_id', $antibiotic_id)->restore();
		return redirect()->back();
	}
	
}