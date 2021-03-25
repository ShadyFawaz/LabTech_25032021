<?php

namespace App\Http\Controllers\TestData;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\MegaTestsModel;
use App\PriceListsTestsModel;
use App\TestDataModel;
use App\SubgroupsModel;
use App\LabUnitModel;
use App\SampleConditionModel;
use App\SampleTypeModel;
use App\CultureLinkModel;
use App\ResultsUnitsModel;
use App\PriceListsModel;
use App\GroupsModel;
use App\OutLabsModel;
use DB;


class NewTestDataController extends Controller
{
    
    public function insert(){
		$Groups          = GroupsModel::get();
		$LabUnit         = LabUnitModel::get();
		$SampleCondition = SampleConditionModel::get();
		$SampleType      = SampleTypeModel::get();
		$Culturelink     = CultureLinkModel::get();
		$ResultsUnits    = ResultsUnitsModel::get();
		$OutLabs         = OutLabsModel::get();

        return view('testdata\Newtestdata',compact(['Groups','LabUnit','SampleCondition','SampleType','Culturelink','ResultsUnits','OutLabs']));
    }
    public function create(Request $request){
		//dd($request->all());
        $rules = [
			'abbrev'            => 'required|string|min:1|max:255',
			'report_name'       => 'required|string|min:1|max:255',
			'group'             => 'required|integer|min:1|max:255',
			'sample_type'       => 'required|integer|min:1|max:255',
			'sample_condition'  => 'required|integer|min:1|max:255',
			'lab_unit'          => 'required|integer|min:1|max:255',
			
		];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('newtestdata')->with('status',"Insert failed");
		}
		else{
            $data = $request->input();
			try{
				$user = new TestDataModel();
                $user->abbrev           = $data['abbrev'];
                $user->report_name      = $data['report_name'];
				$user->test_group       = $data['group'];
				$user->profile          = $data['profile'];
                $user->test_header      = $data['test_header'];
				$user->unit             = $data['unit'];
				$user->test_order       = $data['test_order'];
				$user->culture_link     = $data['culture_link'];
				$user->sample_type      = $data['sample_type'];
                $user->sample_condition = $data['sample_condition'];
				$user->lab_unit         = $data['lab_unit'];
				$user->calculated       = isset($data['calculated']) ? $data['calculated'] : false;
				$user->test_equation    = $data['test_equation'];
				// $user->parent_test      = $data['parent_test'];
				$user->active           = isset($data['active']) ? $data['active'] : false;
				$user->out_lab          = isset($data['out_lab']) ? $data['out_lab'] : false;
				$user->outlab_id        = $data['outlab_id'];
				$user->default_value    = $data['default_value'];
				$user->assay_time       = $data['assay_time'];
				// dd($request->all());
				// dd($user->parent_test);
				$user->save();
				
				// dd($user->parent_test);

					 $PriceLists = PriceListsModel::get();

					 foreach($PriceLists as $pricelist){
					$PriceListsTests = new PriceListsTestsModel();
				 	$PriceListsTests->pricelist_id    = $pricelist->pricelist_id;
					$PriceListsTests->test_id         = $user->id;
					$PriceListsTests->price           = NULL;
					$PriceListsTests->save();
					//dd($MegaTests->id);
					 
				 }
				 
				return redirect('newtestdata')->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('newtestdata')->with('failed',"operation failed");
			}
		}
    }
}