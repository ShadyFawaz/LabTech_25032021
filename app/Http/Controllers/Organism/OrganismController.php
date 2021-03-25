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


class OrganismController extends Controller
{
    
    public function insert(){
        
        return view('organism\neworganism');
    }
    public function create(Request $request){
		//dd($request->all());
        $rules = [
			'organism' => 'required|string|min:2',
		];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('neworganism')->with('status',"Insert failed");
		}
		else{
            $data = $request->input();
			try{
				$user = new OrganismModel();
                $user->organism = $data['organism'];
				$user->save();
				return redirect('organism')->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('neworganism')->with('failed',"Insert failed");
			}
		}
	}
	public function delete(Request $request,$organism_id){
        
		OrganismModel::query()->where('organism_id', $organism_id)->delete();
		return redirect()->back();
	}
	public function restore(Request $request,$organism_id){
        
		OrganismModel::query()->where('organism_id', $organism_id)->restore();
		return redirect()->back();
	}
}