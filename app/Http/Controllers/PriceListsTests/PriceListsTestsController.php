<?php

namespace App\Http\Controllers\PriceListsTests;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\PriceListsTestsModel;
use App\MegaTestsModel;
use App\PriceListsModel;
use App\TestDataModel;
use App\GroupTestsModel;
use DB;

class PriceListsTestsController extends Controller
{
	
	public function index($pricelist_id){
		
	$PriceListsTests = PriceListsTestsModel::where('pricelist_id',$pricelist_id);

		$users  = $PriceListsTests->whereHas('TestData',function($qurey) {
					$qurey->where('active',true);
					})->orwhereHas('GroupTests',function($qurey) {
						$qurey->where('active',true);
						})->where('pricelist_id',$pricelist_id)
					->orwhereHas('megaTests',function($qurey) {
						$qurey->where('active',true);
						})->where('pricelist_id',$pricelist_id)
				->get();


		// dd($users);
		return view('priceliststests\priceliststests',['users'=>$users],compact('pricelist_id'));
		}  
		public function showPrint($pricelist_id){
		$PriceListsTests = PriceListsTestsModel::where('pricelist_id',$pricelist_id);
	
			$users  = $PriceListsTests->whereHas('TestData',function($qurey) {
						$qurey->where('active',true);
						})->orwhereHas('GroupTests',function($qurey) {
							$qurey->where('active',true);
							})->where('pricelist_id',$pricelist_id)
						->orwhereHas('megaTests',function($qurey) {
							$qurey->where('active',true);
							})->where('pricelist_id',$pricelist_id)
					->get();
	
	
			// dd($users);
			return view('pricelists\printpricelist',['users'=>$users],compact('pricelist_id'));
			}  
		public function show($testprice_id){
			$megaTests    = MegaTestsModel::get();
			$PriceLists   = PriceListsModel::get();
			$TestData     = TestDataModel::get();
			$GroupTests   = GroupTestsModel::get();

			$users        = PriceListsTestsModel::with(['megaTests','PriceLists','TestData','GroupTests'])->where('testprice_id',$testprice_id)->get();
			//dd($users->toArray());
			return view('priceliststests\editpriceliststests',['users'=>$users],compact(['megaTests','PriceLists','GroupTests']));
			}  

			public function edit(Request $request,$testprice_id) {
				//$title = $request->input('title');
				$price    = $request->input('price');
				$users = PriceListsTestsModel::where('testprice_id',$testprice_id)->update([
					'price'  =>  $price
				]);
				return redirect()->back();
				// return redirect()->back();
				
				}
		public function update(Request $request,$pricelist_id) {
			$price    = $request->input('price');
			$PriceListsTests = PriceListsTestsModel::query();
			$Prices          = $request->except('_token','_method');
			$PricesCount     = count($request->only('price')); 
			DB::beginTransaction();
			// dd($Prices);
			foreach ($Prices['price'] as $i=> $pric) {
				// $TestEntry = TestEntryModel::query()->where('result_id',$i)->first();
	// dd($i);
				$price     = $Prices['price'][$i];
			
				$PriceListsTests = PriceListsTestsModel::query()->where('testprice_id',$i)->update(
					[
						'price'   =>$price,	
				]	
				);					
			}

						DB::commit();
		return redirect()->back();
		
					}
            public function newPriceListTests(Request $request ,$pricelist_id){
				 $MegaTests  = MegaTestsModel::get();
				 $GroupTests = GroupTestsModel::get();
				 $TestData   = TestDataModel::get();
				 
				 $PriceListsTests = PriceListsTestsModel::where('pricelist_id',$pricelist_id)->count();
// dd($PriceListsTests);
if ($PriceListsTests > 0){
	return redirect()->back()->with('status','Cannot add tests to this pricelist');			

}else{
				 foreach($MegaTests as $megatest){
					 $megaprice = PriceListsTestsModel::query()->where('megatest_id',$megatest->megatest_id)->where('pricelist_id','=','1')->first();
					// dd($megaprice);
				$PriceListsTests = new PriceListsTestsModel();
				$PriceListsTests->pricelist_id     = $pricelist_id;
				$PriceListsTests->megatest_id      = $megatest->megatest_id;
				$PriceListsTests->price            = $megaprice->price;
				$PriceListsTests->save();
					 }
					foreach($GroupTests as $grouptest){
				$groupprice = PriceListsTestsModel::query()->where('grouptest_id',$grouptest->grouptest_id)->where('pricelist_id','=','1')->first();

					// dd($MegaTests);
				$PriceListsTests = new PriceListsTestsModel();
				$PriceListsTests->pricelist_id     = $pricelist_id;
				$PriceListsTests->grouptest_id     = $grouptest->grouptest_id;
				$PriceListsTests->price            = $groupprice->price;
				$PriceListsTests->save();
						}
					foreach($TestData as $test){
			$testprice = PriceListsTestsModel::query()->where('test_id',$test->test_id)->where('pricelist_id','=','1')->first();

					// dd($MegaTests);
				$PriceListsTests = new PriceListsTestsModel();
				$PriceListsTests->pricelist_id     = $pricelist_id;
				$PriceListsTests->test_id          = $test->test_id;
				$PriceListsTests->price            = $testprice->price;
				$PriceListsTests->save();
						}
					 return redirect()->back();			
				}}
				public function UpdatePrices(Request $request,$pricelist_id) {

				$price           = $request->input('price');
				// $priceupdate     = $request->input('update_percent');
				$PriceListsTests = PriceListsTestsModel::query();
				$Prices          = $request->except('_token','_method');
				$PricesCount     = count($request->only('price')); 

if ($request->savePrices){
	DB::beginTransaction();
			// dd($Prices);
			foreach ($Prices['price'] as $i=> $pric) {
				// $TestEntry = TestEntryModel::query()->where('result_id',$i)->first();
	// dd($i);
				$price     = $Prices['price'][$i];
			
				$PriceListsTests = PriceListsTestsModel::query()->where('testprice_id',$i)->update(
					[
						'price'   =>$price,	
				]	
				);					
			}

						DB::commit();
		return redirect()->back();
}elseif($request->updatePrices){

	$PricesUpdate = PriceListsTestsModel::where('pricelist_id',$pricelist_id)->get();
	// dd($Prices);
	$priceupdate    = $request->input('update_percent');
	// dd($priceupdate);
	if (!$priceupdate){
		return redirect()->back();
	}else{
	foreach($PricesUpdate as $price){
	$testprice = PriceListsTestsModel::query()->where('testprice_id',$price->testprice_id)->first();
	// dd($testprice);
	$price2 = $testprice->price * $priceupdate;
	// dd($priceupdate);
	$PriceListsTests = PriceListsTestsModel::query()->where('testprice_id',$testprice->testprice_id)->update([
		'price'  => $price2,
	]);


	}
			return redirect()->back();
			// return redirect()->back();
			
			}}
}
		
				}