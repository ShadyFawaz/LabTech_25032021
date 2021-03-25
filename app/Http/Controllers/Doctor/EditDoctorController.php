<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\DoctorModel;
use DB;

class EditDoctorController extends Controller
{
    
    public function index(){
		// $users = DB::select('select * from doctor');
		$users = DoctorModel::get();
		return view('doctor\doctor',['users'=>$users]);
		}

	public function show($doctor_id) {
		$users = DoctorModel::where('doctor_id',$doctor_id)->get();
		return view('doctor\editdoctor',['users'=>$users]);
		}

	public function edit(Request $request,$doctor_id) {
		$doctor = $request->input('doctor');
		$users = DoctorModel::where('doctor_id',$doctor_id)->update([
			'doctor'  =>  $doctor
		]);

		return redirect('doctor')->with('status',"Updated Successfully");
		
		}
}