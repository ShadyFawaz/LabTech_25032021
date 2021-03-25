<?php

namespace App\Http\Controllers\Groups;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\GroupsModel;
use App\TestDataModel;
use DB;


class GroupsController extends Controller
{
    
    public function insert(){
        
        return view('groups\newgroups');
    }
    public function create(Request $request){
		//dd($request->all());
        $rules = [
			'group_name' => 'required|string|min:2|max:255',
			'report_name' => 'required|string|min:2|max:255',
		];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('newgroups')->with('status',"Insert failed");
		}
		else{
            $data = $request->input();
			try{
				$user = new GroupsModel();
                $user->group_name = $data['group_name'];
                $user->report_name = $data['report_name'];
				$user->save();
				return redirect('groups')->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('newgroups')->with('failed',"Insert failed");
			}
		}
	}
	
	public function new(){
		//dd($request->all());
		// dd($test_id);
			    $user = new GroupsModel();
				$user->group_name         = null; 
				$user->report_name        = null;
               
				$user->save();
				return redirect()->back();
			}

			public function groupTests($group_id){
				$Groups    = GroupsModel::get();
				$users     = TestDataModel::with(['Groups'])->where('test_group',$group_id)->get();
				// dd($users->toArray());
				return view('testdata\testdata',['users'=>$users],compact('Groups'));
				} 
}