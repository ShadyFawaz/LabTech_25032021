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

class EditCountryController extends Controller
{
    
    public function index(){
		$users = CountryModel::get();
		return view('country\country',['users'=>$users]);
		}

		public function show($country_id) {
		$users = CountryModel::where('country_id',$country_id)->get();
		return view('country\editcountry',['users'=>$users]);
		}

		public function edit(Request $request,$country_id) {
		$country = $request->input('country');
		$users   = CountryModel::where('country_id',$country_id)->update([

			'country' => $country
			
			]);
		return redirect('country')->with('status',"Updated Successfully");
		
		}
}