<?php

namespace App\Http\Controllers\Antibiotics;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\AntibioticsModel;
use DB;

class EditAntibioticController extends Controller
{
    
public function index(){
	$users = AntibioticsModel::get();
	return view('antibiotics\antibiotics',['users'=>$users]);
	}

public function show($antibiotic_id) {
	$users = AntibioticsModel::where('antibiotic_id',$antibiotic_id)->get();
	return view('antibiotics\editantibiotic',['users'=>$users]);
	}
	

public function edit(Request $request,$antibiotic_id) {
	$antibiotic_name    = $request->input('antibiotic_name');
	$report_name        = $request->input('report_name');
	$users = AntibioticsModel::where('antibiotic_id',$antibiotic_id)->update([
		'antibiotic_name' => $antibiotic_name,
		'report_name'     => $report_name
	]);

	// DB::update('update antibiotics set antibiotic_name=?,report_name=? where antibiotic_id = ?',[$antibiotic_name,$report_name,$antibiotic_id]);
	return redirect('antibiotics')->with('status',"Updated Successfully");
	
		}
}