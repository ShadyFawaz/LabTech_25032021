<?php

namespace App\Http\Controllers\Titles;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\TitlesModel;
use DB;

class EditTitleController extends Controller
{
    
    public function index(){
		$users = TitlesModel::get();
		return view('titles\titles',['users'=>$users]);
		}
	public function show($title_id) {
			$users = TitlesModel::where('title_id',$title_id)->get();
			return view('titles\edittitle',['users'=>$users]);
		}
	public function edit(Request $request,$title_id) {
		$title  = $request->input('title');
		$gender = $request->input('gender');
		$users = TitlesModel::where('title_id',$title_id)->update([
		'title'    =>  $title,
		'gender'   => $gender
		]);

		// DB::update('update titles set title = ?,gender=? where title_id = ?',[$title,$gender,$title_id]);
		return redirect('titles')->with('status',"Updated Successfully");
		
		}
}