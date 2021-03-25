<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\PermissionsModel;


class PermissionsController extends Controller
{
    
    public function insert(){
        
        return view('newpermissions');
    }
    public function create(Request $request){
		//dd($request->all());
        $rules = [
			'permission'  => 'required|string|min:2|max:255',
			'description' => 'required|string|min:2|max:255',
			'type'        => 'required|string|max:255',

		];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('permissions')->with('status',"Insert failed");
		}
		else{
            $data = $request->input();
			try{
				$user = new PermissionsModel();
				$user->name          = $data['permission'];
				$user->type          = $data['type'];
				$user->description   = $data['description'];
                $user->guard_name    = 'web';
				$user->save();
				return redirect('permissions')->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('permissions')->with('failed',"Insert failed");
			}
		}
	}
	public function delete(Request $request,$diagnosis_id){
        
		DiagnosisModel::query()->where('diagnosis_id', $diagnosis_id)->delete();
		return redirect()->back();
	}
}