<?php

namespace App\Http\Controllers\Users;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use App\NewUserModel;
use App\RolesModel;
use App\PermissionsModel;
use App\RelativePriceListsModel;
use App\RelativePriceListsUsersModel;
use App\RelativePriceListsTestsModel;
use Hash;
use Auth;
use Crypt;

use DB;

class UsersController extends Controller
{

	public function index(){
		$users = NewuserModel::get();

		return view('users\viewsystemusers',['users'=>$users]);
		} 

	public function show($user_id){
		$users      = NewuserModel::where('user_id',$user_id)->get();
		$user       = NewuserModel::where('user_id',$user_id)->first();
		$screens    = PermissionsModel::where('type','=','S')->orderBy('name')->get();
		$rights     = PermissionsModel::where('type','=','R')->orderBy('name')->get();
		$relPriceLists = RelativePriceListsUsersModel::where('user_id',$user_id)->get();
		$userpass = Auth::user()->password;
		$pass = $users[0]->password;
		// dd($pass);

		$roles           = $user->roles()->get();
		$userpermissions = $user->getAllPermissions();
		
		$permissions     =  PermissionsModel::get();

// dd($roles);
		return view('users\edituser',['users'=>$users , 'permissions'=>$permissions , 'roles'=>$roles , 'screens'=>$screens , 'rights'=>$rights , 'relPriceLists'=>$relPriceLists]);
		}  

		public function edit(Request $request,$user_id) {
			$users      = NewuserModel::where('user_id',$user_id)->first();
			$OldPass   = $users->password;

			$pass      = $request->input('password');
			$conf_pass = $request->input('conf_password');

				// dd($OldPass);
			$login_name     = $request->input('login_name');
			$user_name      = $request->input('user_name');
			$permission_id  = $request->input('id');
			$rel_id         = $request->input('rel_id');
// dd($rel_id);
			$user            = NewuserModel::where('user_id',$user_id)->first();
			$userpermissions = $user->getAllPermissions();
// dd($userpermissions);
			if ($pass !== $conf_pass){
				return back()->with('status',"Password Dont Match");

			}elseif($pass == $conf_pass){
				if($pass == $OldPass){
					$users  = NewuserModel::where('user_id',$user_id)->update([
						'login_name'    => $login_name,
						'user_name'     => $user_name
		
						]);
				}elseif($pass !== $OldPass){
					$users  = NewuserModel::where('user_id',$user_id)->update([
						'login_name'    => $login_name,
						'user_name'     => $user_name,
						'password'      => Hash::make($pass)
						]);
				}
			}
		
			
			$Relatives       = $request->except('_token','_method','id');
			$RelativesCount  = count($request->only('rel_user_id')); 
			
		DB::beginTransaction();
		// dd($Relatives);

        foreach ($Relatives['rel_user_id'] as $i=> $relative) {

			$Active    = isset($Relatives['active'][$i]) ? $Relatives['active'][$i] : false;
			// isset($Normals['active']) ? $Normals['active'] : false;

			// dd($NormalRanges);
          
			$RelativePriceUsers = RelativepriceListsUsersModel::query()->where('rel_user_id',$i)->update(
				[
		
					'active'    =>$Active,
			]
				
			);
		
        }
    // when done commit
DB::commit();


			$user->syncPermissions($permission_id);

			

			return redirect('edituser/'.$user_id)->with('status',"Updated Successfully");
		}
    
    public function insert(){
        $roles       = RolesModel::get();
        $permissions = PermissionsModel::get();
		$screens = PermissionsModel::where('type','=','S')->orderBy('name')->get();
		$rights  = PermissionsModel::where('type','=','R')->orderBy('name')->get();

// dd($permissions);
        return view('Users\systemusers',compact('roles','permissions','screens','rights'));
    }
    public function create(Request $request){
		//dd($request->all());
        $rules = [
			'login_name' => 'required|string|min:3|max:255',
			'user_name'  => 'required|string|min:3|max:255',
			'password'   => 'required|string|min:3|max:255',
			// 'role_id'    => 'required_without:id',
			// 'id'         => 'required_without:role_id',

		];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('insert')->with('status',"Insert failed");
		}
		else{
            $data = $request->input();
			$screen_id = $request->has('screen_id');
			$right_id  = $request->has('right_id');

			// dd($screen_id);
			try{
				$user = new NewUserModel();
                $user->login_name = $data['login_name'];
                $user->user_name  = $data['user_name'];
				$user->password   = Hash::make($data['password']);
				// dd($user);
				$user->save();

				$relPriceLists = RelativePriceListsModel::get();

				foreach($relPriceLists as $relpricelist){
			   $relUsers = new RelativePriceListsUsersModel();
			   $relUsers->user_id                  = $user->user_id;
			   $relUsers->relative_pricelist_id    = $relpricelist->relative_pricelist_id;
			   $relUsers->active                   = '0';
			   $relUsers->save();
				
			}

				if ($data['role_id']){
					$user->assignRole($data['role_id']);

				}
				if ($screen_id){
					$user->givePermissionTo($data['screen_id']);
				}

				if ($right_id){
					$user->givePermissionTo($data['right_id']);
				}

				return redirect('insert')->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('insert')->with('failed',"operation failed");
			}
		}
    }
}