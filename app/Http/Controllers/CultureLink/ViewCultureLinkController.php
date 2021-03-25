<?php

namespace App\Http\Controllers\CultureLink;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\CultureLinkModel;
use DB;


class ViewCultureLinkController extends Controller
{
    
	public function index(){
		$users = DB::select('select * from culture_link');
		return view('culturelink\culturelink',['users'=>$users]);
		}  
}