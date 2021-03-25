<?php

namespace App\Http\Controllers;
use DB;
use App\RelativePriceListsModel;


use Illuminate\Http\Request;

class DynamicDependent extends Controller
{
    function index()
    {
        $RelativePriceLists = RelativePriceListsModel::with('RankPriceLists')->groupBy('rank_pricelist_id')->get();
        return view('dynamic_dependent',['RankPriceLists'=>$RankPriceLists],compact('RankPriceLists'));
    }
    function fetch(Request $request)
    {
     $select    = $request->get('select');
     $value     = $request->get('value');
     $dependent = $request->get('dependent');
     $nam       = $request->get('type');
     $data      = RelativePriceListsModel::where($select,$value)->groupBy($dependent)->get();
    //  $data = DB::table('relative_price_lists')
    //    ->where($select, $value)
    //    ->groupBy($dependent)
    //    ->get();
     $output = '<option value="">Select Relative Price List</option>';
//  dd($data);
     foreach($data as $row)
     {
      $output .= '<option value="'.$row->$dependent.'">'.$row->relative_pricelist_name.'</option>';


     }
     echo $output;
    }
}
