<?php

namespace App\Http\Controllers\RelativePriceLists;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\RelativePriceListsModel;
use App\RelativePriceListsUsersModel;
use App\RankPriceListsModel;
use App\PriceListsModel;
use App\NewUserModel;
use DB;


class RelativePriceListsController extends Controller
{
	
	public function index($rank_pricelist_id){
		$PriceLists        = PriceListsModel::get();
		$RankPriceLists    = RankPriceListsModel::get();
		$users             = RelativePriceListsModel::with(['PriceLists','RankPriceLists'])->where('rank_pricelist_id',$rank_pricelist_id)->get();
		//dd($users->toArray());
		return view('relativepricelists\relativepricelists',['users'=>$users],compact('PriceLists','RankPriceLists','rank_pricelist_id'));
		}  

		public function show($relative_pricelist_id) {
			$PriceLists        = PriceListsModel::get();
			$RankPriceLists    = RankPriceListsModel::get();
			$users = RelativePricelistsModel::where('relative_pricelist_id',$relative_pricelist_id)->get();
		   return view('relativepricelists/editrelativepricelist',['users'=>$users],compact('PriceLists','RankPriceLists','rank_pricelist_id'));
		   }

		   public function edit(Request $request,$relative_pricelist_id) {		

				   $relative_pricelist_name      = $request->input('relative_pricelist_name');
				   $pricelist_id                 = $request->input('pricelist_id');
				   $patient_load                 = $request->input('patient_load');
				   $insurance_load               = $request->input('insurance_load');
				   $insurance_factor             = $request->input('insurance_factor');

				   $users = RelativePriceListsModel::where('relative_pricelist_id',$relative_pricelist_id)->update([
					   'relative_pricelist_name'    =>  $relative_pricelist_name,
					   'pricelist_id'               =>  $pricelist_id,
					   'patient_load'               =>  $patient_load,
					   'insurance_load'             =>  $insurance_load,
					   'insurance_factor'           =>  $insurance_factor

				   ]);

		   return redirect('rankpricelists')->with('status',"Updated Successfully");
		   
		   }
   


    public function insert($rank_pricelist_id){
		$PriceLists      = PriceListsModel::get();
		$RankPriceLists  = RankPriceListsModel::where('rank_pricelist_id',$rank_pricelist_id)->first();
		$users           = RelativePriceListsModel::with(['PriceLists','RankPriceLists'])->where('rank_pricelist_id',$rank_pricelist_id)->get();

	
        return view('relativepricelists\newrelativepricelist',['users'=>$users],compact('PriceLists','RankPriceLists','rank_pricelist_id'));
    }
    public function create(Request $request,$rank_pricelist_id){
		//dd($request->all());
        $rules = [
			'rank_pricelist_id'        => 'required|integer|min:1',
			'pricelist_id'             => 'required|integer|min:1',
			'rank_pricelist_id'        => 'required|integer|min:1',
			'relative_pricelist_name'  => 'required|string|min:1|max:255',
		];
		
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('rankpricelists')->with('status',"Insert failed");
		}
		else{
            $data = $request->input();
			try{
				$user = new RelativePriceListsModel();
				$user->relative_pricelist_name    = $data['relative_pricelist_name'];
				$user->rank_pricelist_id          = $rank_pricelist_id;
				$user->pricelist_id               = $data['pricelist_id'];
				$user->patient_load               = $data['patient_load'];
				$user->insurance_load             = $data['insurance_load'];
				$user->insurance_factor           = $data['insurance_factor'];

				$user->save();

				$sysUsers = NewUserModel::get();

				foreach($sysUsers as $sysuser){
			   $relUsers = new RelativePriceListsUsersModel();
			   $relUsers->user_id                  = $sysuser->user_id;
			   $relUsers->relative_pricelist_id    = $user->id;
			   $relUsers->active                   = '0';
			   $relUsers->save();
				
			}
				return redirect('rankpricelists')->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('rankpricelists')->with('failed',"operation failed");
			}
		}
	}
	public function insertnew(){
		$PriceLists      = PriceListsModel::get();
		$RankPriceLists  = RankPriceListsModel::get();
		$users           = RelativePriceListsModel::with(['PriceLists','RankPriceLists'])->get();

        return view('relativepricelists\newrelativepricelist2',['users'=>$users],compact('PriceLists','RankPriceLists'));
    }
    public function createnew(Request $request){
		//dd($request->all());
        $rules = [
			'rank_pricelist_id'        => 'required|integer|min:1',
			'pricelist_id'             => 'required|integer|min:1',
			'rank_pricelist_id'        => 'required|integer|min:1',
			'relative_pricelist_name'  => 'required|string|min:1|max:255',
		];
		
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('newrelativepricelist2')->with('status',"Insert failed");
		}
		else{
            $data = $request->input();
			try{
				$user = new RelativePriceListsModel();
				$user->relative_pricelist_name    = $data['relative_pricelist_name'];
				$user->rank_pricelist_id          = $data['rank_pricelist_id'];
				$user->pricelist_id               = $data['pricelist_id'];
				$user->patient_load               = $data['patient_load'];
				$user->insurance_load             = $data['insurance_load'];
				$user->insurance_factor           = $data['insurance_factor'];

				$user->save();
				return redirect('newrelativepricelist2')->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('newrelativepricelist2')->with('failed',"operation failed");
			}
		}
	}
	public function delete($relative_pricelist_id) {		

		$users = RelativePriceListsModel::where('relative_pricelist_id',$relative_pricelist_id)->delete();

return redirect()->back();

}
}
