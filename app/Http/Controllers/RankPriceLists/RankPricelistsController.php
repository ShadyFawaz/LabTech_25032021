<?php

namespace App\Http\Controllers\RankPriceLists;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\RankPriceListsModel;
use App\RelativePriceListsModel;

use DB;


class RankPriceListsController extends Controller
{
	
	public function index(){
		$users = RankPriceListsModel::get();
		return view('rankpricelists\rankpricelists',['users'=>$users]);
		} 
		public function trashedIndex(){
			$users = RankPriceListsModel::onlyTrashed()->get();
			return view('rankpricelists\rankpricelists',['users'=>$users]);
			} 

    public function insert(){
		$users = RankPriceListsModel::get();
        return view('rankpricelists\newrankpricelist');
    }
    public function create(Request $request){
		//dd($request->all());
        $rules = [
			'rank_pricelist_name' => 'required|string|min:2|max:255',
		];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('newrankpricelist')->with('status',"Insert failed");
		}
		else{
			$data = $request->input();
			try{
				$user = new RankPriceListsModel();
                $user->rank_pricelist_name = $data['rank_pricelist_name'];
				$user->save();
				return redirect('rankpricelists')->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('newrankpricelist')->with('failed',"Insert failed");
			}
		}
	}

	
		public function show($rank_pricelist_id) {
			$users = RankPriceListsModel::where('rank_pricelist_id',$rank_pricelist_id)->get();
			return view('rankpricelists\editrankpricelist',['users'=>$users]);
		}
		public function edit(Request $request,$rank_pricelist_id) {
		$rank_pricelist_name  = $request->input('rank_pricelist_name');
		
		$users = RankPriceListsModel::where('rank_pricelist_id',$rank_pricelist_id)->update([
			'rank_pricelist_name'  =>  $rank_pricelist_name,
		]);

		return redirect('rankpricelists')->with('status',"Updated Successfully");
		
		}
	
		public function delete(Request $request,$rank_pricelist_id){
        
			RankPriceListsModel::query()->where('rank_pricelist_id', $rank_pricelist_id)->delete();
			RelativePriceListsModel::query()->where('rank_pricelist_id', $rank_pricelist_id)->delete();
			return redirect()->back();
		}
	
		public function restore(Request $request,$rank_pricelist_id){
			
			RankPriceListsModel::query()->where('rank_pricelist_id', $rank_pricelist_id)->restore();
			RelativePriceListsModel::query()->where('rank_pricelist_id', $rank_pricelist_id)->restore();
			return redirect()->back();
		}
}