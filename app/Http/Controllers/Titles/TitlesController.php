<?php

namespace App\Http\Controllers\Titles;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\TitlesModel;


class TitlesController extends Controller
{
    
    public function insert(){
        return view('titles\newtitle');
    }
    public function create(Request $request){
		//dd($request->all());
        $rules = [
			'title' => 'required|string|min:2|max:255',
			'gender' => 'required|string|min:2|max:255',
		];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('newtitle')->with('status',"Insert failed");
		}
		else{
            $data = $request->input();
			try{
				$user = new TitlesModel();
                $user->title = $data['title'];
                $user->gender = $data['gender'];
				$user->save();
				return redirect('titles')->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('newtitle')->with('failed',"Insert failed");
			}
		}
	}
	public function delete(Request $request,$title_id){
        
		TitlesModel::query()->where('title_id', $title_id)->delete();
		return redirect()->back();
	}
	public function restore(Request $request,$title_id){
        
		TitlesModel::query()->where('title_id', $title_id)->restore();
		return redirect()->back();
	}
}