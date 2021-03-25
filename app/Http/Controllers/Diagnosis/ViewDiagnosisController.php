<?php

namespace App\Http\Controllers\Diagnosis;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\DiagnosisModel;
use DB;


class ViewDiagnosisController extends Controller
{
    
	public function index(){
		// $users = DB::select('select * from diagnosis');
		$users = DiagnosisModel::get();
		return view('diagnosis\diagnosis',['users'=>$users]);
		}  
	public function trashedIndex(){
		// $users = DB::select('select * from diagnosis');
		$users = DiagnosisModel::onlyTrashed()->get();
		return view('diagnosis\diagnosis',['users'=>$users]);
		} 
}