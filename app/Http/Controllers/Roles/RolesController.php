<?php

namespace App\Http\Controllers\Roles;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\NewUserModel;
use App\RolesModel;
use App\PermissionsModel;
use Hash;
use DB;

// class RoleTableSeeder

class RolesController extends Controller
{

	public function index(){
		$roles        = RolesModel::get();
		$permissions  =  PermissionsModel::get();
		$screens = PermissionsModel::where('type','=','S')->orderBy('name')->get();
		$rights  = PermissionsModel::where('type','=','R')->orderBy('name')->get();

		return view('roles\roles',['roles'=>$roles , 'screens'=>$screens , 'rights'=>$rights]);
		} 

	public function show($id){
		$roles           =  Role::with('permissions')->where('id',$id)->get();
		$rolepermissions =  $roles[0]->getAllPermissions();
		// $check = $roles[0]->hasPermissionTo($rolepermissions);
		$screens = PermissionsModel::where('type','=','S')->orderBy('name')->get();
		$rights  = PermissionsModel::where('type','=','R')->orderBy('name')->get();

		$permissions     =  PermissionsModel::get();
// dd($rolepermissions);
		return view('roles\editrole',['roles'=>$roles ,'permissions'=>$permissions],compact(['roles','screens','rights']));
		}  

		public function edit(Request $request,$id) {
			$role_name      = $request->input('role_name');
			$permission_id  = $request->input('id');
			
			$role = Role::where('id',$id)->first();

			$roles    = Role::where('id',$id)->update([
			'name'    => $role_name
			]);

				$role->syncPermissions($permission_id);
				// dd($role);
			
			return redirect('editrole/'.$id)->with('status',"Updated Successfully");
		}
    
    public function insert(){
		$permissions  =  PermissionsModel::get();
		$screens = PermissionsModel::where('type','=','S')->orderBy('name')->get();
		$rights  = PermissionsModel::where('type','=','R')->orderBy('name')->get();

        return view('roles\newrole' , compact(['permissions','screens','rights']));
    }
    public function create(Request $request){
		// dd($request->all());
        $rules = [
			'role_name'      => 'required|string|min:3|max:255',
			'permission_id'  => 'required'
		

		];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('newrole')->with('status',"Insert failed");
		}
		else{
            $data = $request->input();
			try{
				// $user = new RolesModel();
                // $user->name = $data['role_name'];
				$role = Role::create(['name' => $data['role_name']]);
				// dd($role);
		foreach($request->id as $permission_id){
			$role->givePermissionTo($data['id']);
			// dd($role);
		}
				return redirect('newrole')->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('newrole')->with('failed',"operation failed");
			}
		}
    }
}