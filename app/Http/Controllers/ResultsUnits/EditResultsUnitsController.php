<?php

namespace App\Http\Controllers\ResultsUnits;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use App\ResultsUnitsModel;

class EditResultsUnitsController extends Controller
{
    
    public function index(){
		$users = ResultsUnitsModel::get();
		return view('resultsunits\resultsunits',['users'=>$users]);
		}
		public function show($resultunit_id) {
			$users = ResultsUnitsModel::where('resultunit_id',$resultunit_id)->get();
			return view('resultsunits\editresultsunits',['users'=>$users]);
		}
		public function edit(Request $request,$resultunit_id) {
		$result_unit = $request->input('result_unit');

			$users = ResultsUnitsModel::where('resultunit_id',$resultunit_id)->update([
				'result_unit'   =>  $result_unit
			]);
		return redirect('resultsunits')->with('status',"Updated Successfully");
		
		}
}