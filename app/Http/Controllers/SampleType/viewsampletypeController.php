<?php

namespace App\Http\Controllers\SampleType;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\SampleTypeModel;
use DB;


class ViewSampleTypeController extends Controller
{
    
	public function index(){
		$users = SampleTypeModel::get();
		return view('sampletype\sampletype',['users'=>$users]);
		}  
}