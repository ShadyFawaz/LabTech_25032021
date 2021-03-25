<?php

namespace App\Http\Controllers\Culturelink;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\CulturelinkModel;


class CultureLinkController extends Controller
{
    
    public function insert(){
        
        return view('CultureLink\newculturelink');
    }
    public function create(Request $request){
		//dd($request->all());
        $rules = [
			'culture_name' => 'required|string|min:1|max:255',
		];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('newculturelink')->with('status',"Insert failed");
		}
		else{
            $data = $request->input();
			try{
				$user = new CultureLinkModel();
                $user->culture_name = $data['culture_name'];
				$user->save();
				return redirect('culturelink')->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('newculturelink')->with('failed',"Insert failed");
			}
		}
    }
}