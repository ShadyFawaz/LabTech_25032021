<?php

namespace App\Http\Controllers\Titles;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\TitlesModel;
use DB;


class ViewTitlesController extends Controller
{
    
	public function index(){
		$users = TitlesModel::get();
		return view('titles\titles',['users'=>$users]);
		}  
	public function trashedIndex(){
		$users = TitlesModel::onlyTrashed()->get();
		return view('titles\titles',['users'=>$users]);
		} 
}