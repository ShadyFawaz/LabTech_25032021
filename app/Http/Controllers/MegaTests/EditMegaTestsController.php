<?php

namespace App\Http\Controllers\MegaTests;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\MegaTestsModel;
use App\OutLabsModel;
use DB;

class EditMegaTestsController extends Controller
{
    
    public function index(){
		$users = MegaTestsModel::get();
		return view('megatests\viewmegatests',['users'=>$users]);
		}
		public function show($megatest_id) {
			$OutLabs = OutLabsModel::get();
			$users   = MegaTestsModel::where('megatest_id',$megatest_id)->get();
			return view('megatests\editmegatests',['users'=>$users , 'OutLabs'=>$OutLabs]);
		}
		public function edit(Request $request,$megatest_id) {
		//$title = $request->input('title');
		        $test_name    = $request->input('test_name');
				$report_name  = $request->input('report_name');
				$test_comment = $request->input('test_comment');
				$outlab_id    = $request->input('outlab_id');

				$active       = isset($request['active']) ? $request['active'] : false;
				$outlab       = isset($request['outlab']) ? $request['outlab'] : false;
				$report_type  = $request->input('report_type');

				// dd($request->active);
				
				$users = MegaTestsModel::where('megatest_id',$megatest_id)->update([
						'test_name'   =>   $test_name,
						'report_name' =>   $report_name,
						'report_type' =>   $report_type,
						'test_comment'=>   $test_comment,
						'outlab_id'   =>   $outlab_id,

						'active'     =>   $active,
						'outlab'     =>   $outlab,

				]);

		return redirect('megatests')->with('status',"Updated Successfully");
		
		}
}