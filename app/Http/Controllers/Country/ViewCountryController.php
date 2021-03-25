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


class ViewCountryController extends Controller
{
    
	public function index(){
		// $users = DB::select('select * from country');
		$users = CountryModel::get();
		return view('country\country',['users'=>$users]);
		} 
	public function trashedIndex(){
		// $users = DB::select('select * from country');
		$users = CountryModel::onlyTrashed()->get();
		return view('country\country',['users'=>$users]);
		}   
}