<?php

namespace App\Http\Controllers\Users;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\NewUserModel;


class LoginController extends Controller
{
    
    public function showlogin(){
        
        return view('Users\Login');
    }
    public function login(Request $request){
		//dd($request->all());
        $rules = [
			'login_name' => 'required|string|min:2|max:255',
			'password'   => 'required|string|min:2|max:255'
		];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('login')->with('status',"Invalid Login");
		}
		else{
            $data = $request->input();
			try{
				$user =  NewUserModel::query()->where('login_name',$data['login_name'])->where('password',$data['password'])->first();
				if ($user){
					return redirect('home')->with('status',"Login successfully");
				}else{
					return redirect('login')->with('failed',"Login failed");	
				}	
			}
			catch(Exception $e){
				return redirect('insert')->with('failed',"operation failed");
			}
		}
    }
}