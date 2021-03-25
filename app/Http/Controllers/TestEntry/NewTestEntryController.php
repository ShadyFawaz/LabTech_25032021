<?php

namespace App\Http\Controllers\TestEntry;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\PatientRegModel;
use App\TestDataModel;
use App\TestEntryModel;



class NewTestEntryController extends Controller
{
	
	public function index(){
		$PatientReg       = PatientRegModel::get();
		$TestData         = TestDataModel::get();
		$users            = TestEntryModel::get();
		return view('testentry\testentry',['users'=>$users],compact(['PatientReg','TestData']));
		}  

    public function insert(){
		$PatientReg       = PatientRegModel::get();
		$TestData         = TestDataModel::get();
		$users            = TestEntryModel::get();
        return view('newtestentry',['users'=>$users],compact(['PatientReg','TestData']));
    }
    public function create(Request $request){
		//dd($request->all());
        $rules = [
			'regkey'       => 'required|integer|min:1|max:255',
			'test_id'      => 'required|integer|min:1|max:255',
			
		];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('newtestentry')->with('status',"Insert failed");
		}
		else{
            $data = $request->input();
			try{
				$user = new TestEntryModel();
                $user->regkey             = $data['abbrev'];
                $user->test_id            = $data['report_name'];
				$user->result             = $data['subgroup'];
				$user->unit               = $data['profile'];
                $user->low                = $data['test_header'];
				$user->high               = $data['unit'];
				$user->nn_normal          = $data['test_order'];
                $user->flag               = $data['profile_order'];
				$user->test_order         = $data['culture_link'];
				$user->profile_order      = $data['sample_type'];
                $user->rpt                = $data['sample_condition'];
				$user->result_comment     = $data['lab_unit'];
				$user->printed            = $data['lab_unit'];
				$user->report_printed     = $data['test_equation'];
				$user->completed          = $data['rpt'];
				$user->verified           = $data['default_value'];
				$user->canceled           = $data['assay_time'];
				// dd($request->all());
				// dd($user->parent_test);
				$user->save();
				
				// dd($user->parent_test);
				// if(isset($data['parent_test']))
				//  {
				// 	$MegaTests = new MegaTestsModel();
				//  	$MegaTests->test_name = $data['abbrev'];
				// 	$MegaTests->active    = '1';
				// 	$MegaTests->inlab     = '0';
				// 	$MegaTests->outlab    = '0';
				// 	$MegaTests->save();
				// 	//dd($MegaTests->id);
				//  	$MegaTests->MegaTestsChild()->create(['test_id'=>$user->id]);
				//  }
				 
				return redirect('testentry')->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('newtestentry')->with('failed',"operation failed");
			}
		}
    }
}