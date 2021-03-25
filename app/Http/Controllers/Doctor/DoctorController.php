<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\DoctorModel;


class DoctorController extends Controller
{
    
    public function insert(){
        
        return view('doctor\newdoctor');
    }
    public function create(Request $request){
		//dd($request->all());
        $rules = [
			'doctor' => 'required|string|min:2|max:255',
		];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('newdoctor')->with('status',"Insert failed");
		}
		else{
            $data = $request->input();
			try{
				$user = new DoctorModel();
                $user->doctor = $data['doctor'];
				$user->save();
				return redirect('doctor')->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('newdoctor')->with('failed',"Insert failed");
			}
		}
	}
	public function delete(Request $request,$doctor_id){
        
		DoctorModel::query()->where('doctor_id', $doctor_id)->delete();
		return redirect()->back();
	}

	public function restore(Request $request,$doctor_id){
        
		DoctorModel::query()->where('doctor_id', $doctor_id)->restore();
		return redirect()->back();
	}
}