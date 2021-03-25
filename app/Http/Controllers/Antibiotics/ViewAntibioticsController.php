<?php

namespace App\Http\Controllers\Antibiotics;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\AntibioticsModel;
use DB;


class ViewAntibioticsController extends Controller
{
    
	public function index(){
		// $users = DB::select('select * from antibiotics');
		$users = AntibioticsModel::get();
		return view('antibiotics\antibiotics',['users'=>$users]);
		}  
		public function trashedIndex(){
			$users = AntibioticsModel::onlyTrashed()->get();
			return view('antibiotics\antibiotics',['users'=>$users]);
			} 
}