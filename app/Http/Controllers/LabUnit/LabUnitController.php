<?php

namespace App\Http\Controllers\LabUnit;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\LabUnitModel;
use DB;


class LabUnitController extends Controller
{
    
    public function insert(){
        
        return view('labunit\newlabunit');
    }
    public function create(Request $request){
		//dd($request->all());
        $rules = [
			'lab_unit' => 'required|string|min:2|max:255',
		];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('newlabunit')->with('status',"Insert failed");
		}
		else{
            $data = $request->input();
			try{
				$user = new LabUnitModel();
                $user->lab_unit = $data['lab_unit'];
				$user->save();
				return redirect('labunit')->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('newlabunit')->with('failed',"Insert failed");
			}
		}
	}
	public function delete(Request $request,$labunit_id){
        
		DB::table('lab_unit')->where('labunit_id', $labunit_id)->delete();
		return redirect()->back();
		}
}