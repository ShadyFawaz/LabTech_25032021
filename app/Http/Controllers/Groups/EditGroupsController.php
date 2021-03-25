<?php

namespace App\Http\Controllers\Groups;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use App\GroupsModel;

class EditGroupsController extends Controller
{
    
    public function index(){
		$users = GroupsModel::get();
		return view('groups\groups',['users'=>$users]);
		}
		public function show($group_id) {
			$users = GroupsModel::where('group_id',$group_id)->get();
			return view('groups\editgroups',['users'=>$users]);
		}
		public function edit(Request $request,$group_id) {
		$group_name  = $request->input('group_name');
		$report_name = $request->input('report_name');
		
		$users = GroupsModel::where('group_id',$group_id)->update([
			'group_name'  =>  $group_name,
			'report_name' =>  $report_name
		]);

		return redirect('groups')->with('status',"Updated Successfully");
		
		}
}