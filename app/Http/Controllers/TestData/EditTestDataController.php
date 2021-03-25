<?php

namespace App\Http\Controllers\TestData;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\TestDataModel;
use App\SubgroupsModel;
use App\LabUnitModel;
use App\SampleConditionModel;
use App\SampleTypeModel;
use App\CultureLinkModel;
use App\ResultsUnitsModel;
use App\GroupsModel;
use App\OutLabsModel;
use DB;
class EditTestDataController extends Controller
{
    
    public function index(){
		$users = TestDataModel::get();
		return view('testdata\testdata',['users'=>$users]);
		}
		public function show($test_id) {
			$Subgroups       = SubgroupsModel::get();
			$LabUnit         = LabUnitModel::get();
			$SampleCondition = SampleConditionModel::get();
			$SampleType      = SampleTypeModel::get();
			$Culturelink     = CultureLinkModel::get();
			$ResultsUnits    = ResultsUnitsModel::get();
			$Groups          = GroupsModel::get();
			$OutLabs         = OutLabsModel::get();

			$users = TestDataModel::where('test_id',$test_id)->get();
			return view('testdata\edittestdata',['users'=>$users],compact(['Groups','LabUnit','SampleCondition','SampleType','Culturelink','ResultsUnits','OutLabs']));
		}
		public function edit(Request $request,$test_id) {
		//$title = $request->input('title');
		        $abbrev             = $request->input('abbrev');
                $report_name        = $request->input('report_name');
				$group              = $request->input('group');
				$profile            = $request->input('profile');
                $test_header        = $request->input('test_header');
				$unit               = $request->input('unit');
				$test_order         = $request->input('test_order');
                
				$culture_link       = $request->input('culture_link');
				$sample_type        = $request->input('sample_type');
                $sample_condition   = $request->input('sample_condition');
				$lab_unit           = $request->input('lab_unit');
				$calculated         = isset($request['calculated']) ? $request['calculated'] : false;
				$test_equation      = $request->input('test_equation');
				$default_value      = $request->input('default_value');
				$active             = isset($request['active']) ? $request['active'] : false;
				$out_lab            = isset($request['out_lab']) ? $request['out_lab'] : false;
				$outlab_id          = $request->input('outlab_id');

				$assay_time         = $request->input('assay_time');
				
					//  dd($request->all());
				    // dd($request->parent_test);

			$users = TestDataModel::where('test_id',$test_id)->update([
				'abbrev'           =>   $abbrev,             
                'report_name'      =>   $report_name,       
				'test_group'       =>   $group,          
				'profile'          =>   $profile,          
                'test_header'      =>   $test_header,        
				'unit'             =>   $unit,              
				'test_order'       =>   $test_order,         
                
				'culture_link'     =>   $culture_link,       
				'sample_type'      =>   $sample_type,        
                'sample_condition' =>   $sample_condition,   
				'lab_unit'         =>   $lab_unit,           
				'calculated'       =>   $calculated,        
				'test_equation'    =>   $test_equation,      
				         
				'default_value'    =>   $default_value,      
				'active'           =>   $active,  
				'out_lab'          =>   $out_lab, 
				'outlab-id'        =>   $outlab_id,             
				'assay_time'       =>   $assay_time        
			]);

	
		return redirect('testdata')->with('status',"Updated Successfully");
		
		}
}