<?php

namespace App\Http\Controllers\SampleType;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\SampleTypeModel;
use DB;


class SampleTypeController extends Controller
{
    
    public function insert(){
        
        return view('SampleType\newsampletype');
    }
    public function create(Request $request){
		//dd($request->all());
        $rules = [
			'sample_type' => 'required|string|min:2|max:255',
		];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('newsampletype')->with('status',"Insert failed");
		}
		else{
            $data = $request->input();
			try{
				$user = new SampleTypeModel();
                $user->sample_type = $data['sample_type'];
				$user->save();
				return redirect('sampletype')->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('newsampletype')->with('failed',"Insert failed");
			}
		}
	}
	public function delete(Request $request,$sampletype_id){
        
		DB::table('sample_type')->where('sampletype_id', $sampletype_id)->delete();
		return redirect()->back();
		}
}