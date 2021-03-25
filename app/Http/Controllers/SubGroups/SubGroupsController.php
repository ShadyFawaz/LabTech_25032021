<?php

namespace App\Http\Controllers\SubGroups;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\SubGroupsModel;
use App\GroupsModel;
use App\TestDataModel;
use DB;


class SubGroupsController extends Controller
{
	
	public function index($group_id){
		$Groups    = GroupsModel::get();
		$users     = SubGroupsModel::with(['Groups'])->where('group_id',$group_id)->get();
		//dd($users->toArray());
		return view('subgroups\subgroups',['users'=>$users],compact('Groups'));
		}  

		public function show($subgroup_id) {
			$users = SubGroupsModel::where('subgroup_id',$subgroup_id)->get();
		   return view('subgroups/editsubgroups',['users'=>$users]);
		   }

		   public function edit(Request $request,$subgroup_id) {				   
				   $subgroup_name    = $request->input('subgroup_name');
				   $report_name      = $request->input('report_name');
				   
				   $users = SubGroupsModel::where('subgroup_id',$subgroup_id)->update([
					   'subgroup_name'  =>  $subgroup_name,
					   'report_name'    =>  $report_name
				   ]);

		   return redirect('groups')->with('status',"Updated Successfully");
		   
		   }
   


    public function insert(){
        $Groups  = GroupsModel::get();
        return view('subgroups\Newsubgroups',compact('Groups'));
    }
    public function create(Request $request){
		//dd($request->all());
        $rules = [
			'group_id'       => 'required|integer|min:1|max:255',
			
		];
		
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('newsubgroups')->with('status',"Insert failed");
		}
		else{
            $data = $request->input();
			try{
				$user = new SubGroupsModel();
				$user->group_id        = $data['group_id'];
				$user->subgroup_name   = $data['subgroup_name'];
				$user->report_name     = $data['report_name'];
			
				$user->save();
				return redirect('newsubgroups')->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('newsubgroups')->with('failed',"operation failed");
			}
		}
	}
	
	public function new(Request $request,$group_id){
		//dd($request->all());
		$data = $request->test_id;
		// dd($test_id);
			    $user = new SubGroupsModel();
				$user->group_id           = $group_id;
				$user->subgroup_name      = null; 
				$user->report_name        = null;
               
				$user->save();
				return redirect()->back();
			}

			public function subgroupTests($subgroup_id){
				$SubGroups    = SubGroupsModel::get();
				$users        = TestDataModel::with(['SubGroups'])->where('subgroup',$subgroup_id)->get();
				// dd($users->toArray());
				return view('testdata\testdata',['users'=>$users],compact('SubGroups'));
				} 
}