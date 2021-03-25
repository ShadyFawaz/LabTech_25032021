<?php

namespace App\Http\Controllers\Organism;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\OrganismModel;
use DB;

class EditOrganismController extends Controller
{
    
    public function index(){
		$users = OrganismModel::get();
		return view('organism\organism',['users'=>$users]);
		}

	public function show($organism_id) {
		$users = OrganismModel::where('organism_id',$organism_id)->get();
		return view('organism\editorganism',['users'=>$users]);
		}
		
	public function edit(Request $request,$organism_id) {
		$organism = $request->input('organism');
		$users = OrganismModel::where('organism_id',$organism_id)->update([
			'organism'  =>  $organism
		]);

		// DB::update('update organism set organism=? where organism_id = ?',[$organism,$organism_id]);
		return redirect('organism')->with('status',"Updated Successfully");
		
		}		
}