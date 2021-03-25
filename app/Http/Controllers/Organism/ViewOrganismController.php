<?php

namespace App\Http\Controllers\Organism;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\OrganismModel;
use DB;


class ViewOrganismController extends Controller
{
    
	public function index(){
		$users = OrganismModel::get();
		return view('organism\organism',['users'=>$users]);
		}  
		
	public function trashedIndex(){
		$users = OrganismModel::onlyTrashed()->get();
		return view('organism\organism',['users'=>$users]);
		} 
}