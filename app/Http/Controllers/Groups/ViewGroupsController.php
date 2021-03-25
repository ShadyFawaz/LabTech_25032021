<?php

namespace App\Http\Controllers\Groups;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\GroupsModel;
use DB;


class ViewGroupsController extends Controller
{
    
	public function index(){
		$users = DB::select('select * from groups');
		return view('groups\groups',['users'=>$users]);
		}  
}