<?php

namespace App\Http\Controllers\LabUnit;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\LabUnitModel;
use DB;


class ViewLabUnitController extends Controller
{
    
	public function index(){
		// $users = DB::select('select * from lab_unit');
		$users = LabUnitModel::get();
		return view('labunit\labunit',['users'=>$users]);
		}  
}