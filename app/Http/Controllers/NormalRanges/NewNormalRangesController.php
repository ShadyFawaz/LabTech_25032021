<?php

namespace App\Http\Controllers\NormalRanges;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\NormalRangesModel;
use App\TestDataModel;
use App\PatientConditionModel;


class NewNormalRangesController extends Controller
{
    
    public function create(Request $request,$test_id){
		//dd($request->all());
		$data = $request->test_id;
		// dd($test_id);
			    $user = new NormalRangesModel();
				$user->test_id           = $test_id;
				$user->low               = null; 
				$user->high              = null;
				$user->nn_normal         = null;
				$user->age_from_y        = "0";
				$user->age_from_d        = "0";
				$user->age_from_m        = "0";
				$user->age_to_y          = "0";
				$user->age_to_d          = "0";
				$user->age_to_m          = "0";
				$user->age_to            = '120';
				$user->age               = 'Years';
				$user->gender            = 'Male';
				$user->patient_condition = null;
				$user->active            = '1';
               
				$user->save();
				return redirect()->back();
			}
			
			}
		
    
