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
use DB;


class ViewMegaTestsChildController extends Controller
{
    
	public function index($megatest_id){
		
		$users = MegaTestsChildModel::with(['megaTests','TestData'])->where('megatest_id',$megatest_id)->get();
		$test_name  = MegaTestsModel::where('megatest_id',$megatest_id)->first()->test_name;

		//dd($users->toArray());
		return view('megatestschild\megatestschild',['users'=>$users],compact('megatest_id','test_name'));
		}  

		public function edit(Request $request,$megatest_id) {
			// dd($request->all());
		$MegaTestsChild = MegaTestsChildModel::query()->with('megaTests','TestData');
	
			$TestChilds    = $request->except('_token','_method');
			$ChildsCount   = count($request->only('test_id')); 
			
		DB::beginTransaction();
		// dd($TestChilds);

        foreach ($TestChilds['test_id'] as $i=> $testchild) {
			// dd($i);
			$Active         = isset($TestChilds['active'][$i]) ? $TestChilds['active'][$i] : false;
			$MegaTestsChild = MegaTestsChildModel::query()->where('test_code',$i)->update(
				[
					'active'    =>$Active,
			]
				
			);
        }
    // when done commit
DB::commit();
		return redirect()->back();
		}


}