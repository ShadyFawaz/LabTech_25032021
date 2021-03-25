<?php

namespace App\Http\Controllers\MegaTests;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\MegaTestsModel;
use App\PriceListsModel;
use App\PriceListsTestsModel;
use App\TestDataModel;
use App\MegaTestsChildModel;
use App\OutLabsModel;
use DB;

class MegaTestsController extends Controller
{
    
    public function insert(){
		$OutLabs  = OutLabsModel::get();
        $TestData = TestDataModel::orderBy('abbrev')->get();
        return view('megatests\Newmegatests',compact(['TestData','OutLabs']));
    }
    public function create(Request $request){
		//dd($request->all());
        $rules = [
			'test_name'   => 'required|string|min:3|max:255',
			'test_id'     => 'required',

		];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('newmegatests')->with('status',"Insert failed");
		}
		else{
            $data = $request->input();
			try{
				$user = new MegaTestsModel();
				$user->test_name    = $data['test_name'];
				$user->report_name  = $data['report_name'];
				$user->active       = isset($data['active']) ? $data['active'] : false;
				$user->outlab       = isset($data['outlab']) ? $data['outlab'] : false;
				$user->report_type  = $data['report_type'];
				$user->test_comment = $data['test_comment'];
				$user->outlab_id    = $data['outlab_id'];

				$user->save();
				
				$PriceLists       = PriceListsModel::get();
				$MegaTests        = MegaTestsModel::get();
				$MegaTestsChild   = MegaTestsChildModel::get();

				foreach($PriceLists as $pricelist){
					// dd($MegaTests);
					$PriceListsTests = new PriceListsTestsModel();
				 	$PriceListsTests->pricelist_id    = $pricelist->pricelist_id;
					$PriceListsTests->megatest_id     = $user->id;
					$PriceListsTests->price           = NULL;
					$PriceListsTests->save();
					 
				 }
		foreach($request->test_id as $id){
			// dd($MegaTests);
			$MegaTestsChild = new MegaTestsChildModel();
			$MegaTestsChild->test_id         = $id;
			$MegaTestsChild->megatest_id     = $user->id;
			$MegaTestsChild->active          = '1';
			$MegaTestsChild->save();
				
			}
				// if($data['parent_test'])
				// {
				// 	$MegaTests = new MegaTestsModel();
				// 	$MegaTests->test_name = $data['abbrev'];
				// 	$MegaTests->active    = true;
				// 	$MegaTests->MegaTestsChild()->create(['test_id'=>$user->test_id]);
				// }
				
				return redirect('megatests')->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('newmegatests')->with('failed',"operation failed");
			}
		}
    }
}