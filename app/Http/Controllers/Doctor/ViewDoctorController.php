<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\DoctorModel;
use DB;


class ViewDoctorController extends Controller
{
    
	public function index(){
		$users = DoctorModel::get();
		return view('doctor\doctor',['users'=>$users]);
		} 
		
	public function trashedIndex(){
		$users = DoctorModel::onlyTrashed()->get();
		return view('doctor\doctor',['users'=>$users]);
		}  
}