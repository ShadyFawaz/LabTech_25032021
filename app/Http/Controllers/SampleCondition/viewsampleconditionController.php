<?php

namespace App\Http\Controllers\SampleCondition;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\SampleConditionModel;
use DB;


class ViewSampleConditionController extends Controller
{
    
	public function index(){
		$users = SampleConditionModel::get();
		return view('samplecondition\samplecondition',['users'=>$users]);
		}  
}