<?php

namespace App\Http\Controllers\AntibioticEntry;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\PatientRegModel;
use App\TestDataModel;
use App\CultureLinkModel;
use App\OrganismModel;
use App\AntibioticsModel;
use App\AntibioticEntryModel;
use DB;


class AntibioticEntryController extends Controller
{
    
	public function index($regkey, $culture_link){

		$PatientReg  = PatientRegModel::get();
		$CultureLink = CultureLinkModel::get();
		$Organism    = OrganismModel::get();
		$Antibiotics = AntibioticsModel::get();
		
	
		$AntibioticEntry = AntibioticEntryModel::query()->with('PatientReg','CultureLink','Antibiotics','Organism')->where('regkey','=',$regkey)->where('culture_link','=',$culture_link);
        $users = $AntibioticEntry->get();
		// dd($users->all());
		return view('antibioticentry/antibioticentry',['users'=>$users],compact('PatientReg','CultureLink','Antibiotics','Organism','regkey','culture_link'));
		}  

		public function create(Request $request,$regkey,$culture_link){
			// dd($request->all());
			$data = $request->input();
			$antibiotic_check = AntibioticEntryModel::query()->where('regkey',$regkey)
			->where('culture_link',$culture_link)
			->where('organism_id',$data['organism_select'])
			->where('antibiotic_id',$data['antibiotic_select'])
			->where('sensitivity',$data['sensitivity_select'])
			->first();
			// dd($antibiotic_check);
			if($antibiotic_check){
				return back()->withInput()->with('status','Cannot duplicate antibiotic');
			}else{
			$user = new AntibioticEntryModel();
			$user->regkey            = $regkey;
			$user->culture_link      = $culture_link; 
			$user->organism_id       = $data['organism_select'];
			$user->antibiotic_id     = $data['antibiotic_select'];
			$user->sensitivity       = $data['sensitivity_select'];
			// dd($or);

			$user->save();
			return back()->withInput();

		}}
		public function delete(Request $request,$antibioticentry_id){
			$data = $request->input();

			AntibioticEntryModel::query()->where('antibioticentry_id', $antibioticentry_id)->delete();
			return back()->withInput();
		}
}