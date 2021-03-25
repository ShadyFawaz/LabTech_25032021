<?php

namespace App\Http\Controllers\CultureLink;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use App\CultureLinkModel;

class EditCultureLinkController extends Controller
{
    
    public function index(){
		// $users = DB::select('select * from culture_link');
		$users = CultureLinkModel::get();
		return view('culturelink\culturelink',['users'=>$users]);
		}
		public function show($culturelink_id) {
			$users = CultureLinkModel::where('culturelink_id',$culturelink_id)->get();
			return view('culturelink\editculturelink',['users'=>$users]);
		}
		public function edit(Request $request,$culturelink_id) {
		$culture_name = $request->input('culture_name');
		
		$users = CultureLinkModel::where('culturelink_id',$culturelink_id)->update([
			'culture_name'  =>  $culture_name
		]);

		return redirect('culturelink')->with('status',"Updated Successfully");
		
		}
}