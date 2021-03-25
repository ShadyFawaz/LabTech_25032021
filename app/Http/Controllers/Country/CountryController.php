<?php

namespace App\Http\Controllers\Country;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\CountryModel;
use DB;


class CountryController extends Controller
{
    
    public function insert(){
        
        return view('Country\newcountry');
    }
    public function create(Request $request){
		//dd($request->all());
        $rules = [
			'country' => 'required|string|min:2|max:255',
		];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('newcountry')->with('status',"Insert failed");
		}
		else{
            $data = $request->input();
			try{
				$user = new CountryModel();
                $user->country = $data['country'];
				$user->save();
				return redirect('country')->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('newcountry')->with('failed',"Insert failed");
			}
		}
	}
	
	public function delete(Request $request,$country_id){
        
		CountryModel::query()->where('country_id', $country_id)->delete();
		return redirect()->back();
	}

	public function restore(Request $request,$country_id){
        
		CountryModel::query()->where('country_id', $country_id)->restore();
		return redirect()->back();
	}
}