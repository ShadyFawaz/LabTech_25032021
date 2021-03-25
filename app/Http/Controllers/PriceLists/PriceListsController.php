<?php

namespace App\Http\Controllers\PriceLists;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\PriceListsModel;
use DB;


class PriceListsController extends Controller
{

	public function index(){
		
		$users = PriceListsModel::get();
		return view('pricelists\pricelists',['users'=>$users]);
		}  
	public function trashedIndex(){
	
		$users = PriceListsModel::onlyTrashed()->get();
		return view('pricelists\pricelists',['users'=>$users]);
		} 
	public function show($pricelist_id) {
		$users = PriceListsModel::where('pricelist_id',$pricelist_id)->get();
		return view('pricelists\editpricelists',['users'=>$users]);
		}
		
	public function edit(Request $request,$pricelist_id) {
		$price_list = $request->input('price_list');
		// dd($request->all());
		$users = PriceListsModel::where('pricelist_id',$pricelist_id)->update([
			'price_list'   =>   $price_list
		]);

		return redirect('pricelists')->with('status',"Updated Successfully");
						
		}

    public function insert(){
        
        return view('pricelists\Newpricelists');
    }
    public function create(Request $request){
		//dd($request->all());
        $rules = [
			'price_list' => 'required|string|min:2|max:255',
			
		];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('newpricelists')->with('status',"Insert failed");
		}
		else{
            $data = $request->input();
			try{
				$user = new PriceListsModel();
				$user->price_list   = $data['price_list'];
				$user->save();
				// if($data['parent_test'])
				// {
				// 	$MegaTests = new MegaTestsModel();
				// 	$MegaTests->test_name = $data['abbrev'];
				// 	$MegaTests->active    = true;
				// 	$MegaTests->MegaTestsChild()->create(['test_id'=>$user->test_id]);
				// }
				
				return redirect('pricelists')->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('newpricelists')->with('failed',"operation failed");
			}
		}
	}
	public function delete(Request $request,$pricelist_id){
        
		PriceListsModel::query()->where('pricelist_id', $pricelist_id)->delete();
		return redirect()->back();
	}
	public function restore(Request $request,$pricelist_id){
        
		PriceListsModel::query()->where('pricelist_id', $pricelist_id)->restore();
		return redirect()->back();
	}
}