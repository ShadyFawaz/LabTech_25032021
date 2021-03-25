<?php

namespace App\Http\Controllers\MegaTests;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\MegaTestsModel;
use DB;


class ViewMegaTestsController extends Controller
{
    
	public function index(){
		
		$users = MegaTestsModel::orderBy('test_name')->get();
		// dd($users);
		return view('megatests\megatests',['users'=>$users]);
		}  
}