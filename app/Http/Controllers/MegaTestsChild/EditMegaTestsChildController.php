<?php

namespace App\Http\Controllers\MegaTestsChild;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\MegaTestsChildModel;
use App\MegaTestsModel;
use App\TestDataModel;
use DB;

class EditMegaTestsChildController extends Controller
{
    
	public function show($test_code){
		$megaTests  = MegaTestsModel::get();
		$TestData   = TestDataModel::get();
		$users      = MegaTestsChildModel::with(['megaTests','TestData'])->where('test_code',$test_code)->get();
		//dd($users->toArray());
		return view('megatestschild\editmegatestschild',['users'=>$users],compact(['megaTests','TestData']));
		}  
		
		public function edit(Request $request,$test_code) {
		//$title = $request->input('title');
		        $test_id    = $request->input('test_id');
				$users      = MegaTestsChildModel::with(['megaTests','TestData'])->where('test_code',$test_code)->update([
					'test_id'    =>  $test_id

				]);
		return redirect('megatests')->with('status',"Updated Successfully");
		
		}
}