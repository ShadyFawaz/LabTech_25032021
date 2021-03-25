<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\NewUserModel;


class NewUserController extends Controller
{
    
    public function insert(){
        
        return view('systemusers');
    }
    public function create(Request $request){
		//dd($request->all());
        $rules = [
			'PatientID' => 'required|string|min:3|max:255',
			'Title' => 'required|string|min:3|max:255',
			'Patientname' => 'required|string|min:5|max:255',
			'DOB' => 'required|string|min:3|max:255',
			'PhoneNumber' => 'required|string|min:3|max:255',
			'Ag' => 'required|string|min:5|max:255',
			'Age' => 'required|string|min:3|max:255',
			'Gender' => 'required|string|min:3|max:255',
			'Address' => 'required|string|min:5|max:255',
			'E-Mail' => 'required|string|min:3|max:255',
			'Website' => 'required|string|min:3|max:255',
			'Country' => 'required|string|min:5|max:255',
			'Ntionality' => 'required|string|min:5|max:255'
		];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('insert')->with('status',"Insert failed");
		}
		else{
            $data = $request->input();
			try{
				$user = new NewUserModel();
                $user->login_name = $data['login_name'];
                $user->user_name = $data['user_name'];
				$user->password = $data['Password'];
				$user->save();
				return redirect('insert')->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('insert')->with('failed',"operation failed");
			}
		}
    }
}