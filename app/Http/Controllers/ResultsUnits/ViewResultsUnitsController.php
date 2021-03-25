<?php

namespace App\Http\Controllers\ResultsUnits;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\ResultsUnitsModel;
use DB;


class ViewResultsUnitsController extends Controller
{
    
	public function index(){
		$users = ResultsUnitsModel::get();
		return view('resultsunits\resultsunits',['users'=>$users]);
		}  
}