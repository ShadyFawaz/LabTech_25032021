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
		$TestData    = TestDataModel::get();
		$CultureLink = CultureLinkModel::get();
		$Organism    = OrganismModel::get();
		$Antibiotics = AntibioticsModel::get();
		
	
		$AntibioticEntry = AntibioticEntryModel::query()->with('PatientReg','CultureLink','Antibiotics','Organism')->where('regkey','=',$regkey)->where('culture_link','=',$culture_link);
        $users = $AntibioticEntry->get();
		// dd($users->all());
		return view('antibioticentry/antibioticentry',['users'=>$users],compact('TestData','PatientReg','CultureLink','Antibiotics','Organism','regkey','culture_link'));
		}  

		
		public function create(Request $request,$regkey,$culture_link){
			// $organism_select = $request->input('organism_id_select');

			$data = $request->regkey;
			$data = $request->culture_link;
			// dd($test_id);
					$user = new AntibioticEntryModel();
					$user->regkey            = $regkey;
					$user->culture_link      = $culture_link; 
					$user->organism_id       = null;
					$user->antibiotic_id     = null;
					$user->sensitivity       = null;
					// dd($organism_select);

					$user->save();
					return redirect()->back();
				}
				
		
		public function edit(Request $request,$regkey,$culturelink) {
			$PatientReg      = PatientRegModel::get();
			$CultureLink     = CultureLinkModel::get();
			$Organism        = OrganismModel::get();
			$Antibiotics     = AntibioticsModel::get();
	 		$AntibioticEntry = AntibioticEntryModel::query()->with('Antibiotics','CultureLink')->where('regkey',$regkey)->where('culture_link',$culturelink)->get();
		
				$newAntibioticEntry    = $request->except('_token','_method');
				$AntibioticEntryCount  = count($request->only('oragnism_id')); 
				
			DB::beginTransaction();
			foreach($AntibioticEntry as $antibiotic){
				AntibioticEntryModel::query()->where('antibioticentry_id',$antibiotic->antibioticentry_id)->update(
					[
						'organism_id'       => $newAntibioticEntry['organism_id'][$antibiotic->antibioticentry_id],
						'antibiotic_id'     => $newAntibioticEntry['antibiotic_id'][$antibiotic->antibioticentry_id],
						'sensitivity'       => $newAntibioticEntry['sensitivity'][$antibiotic->antibioticentry_id],
					]
					);
			}

	
	DB::commit();
			return redirect()->back();
			}
			
			public function newAntibiotic(Request $request,$regkey,$culture_link){
				// dd($request->all());
				$organism_select   = request()->post('organism_select');
				$antibiotic_select = request()->post('antibiotic_select');
				
				
				if($request->SaveAll){
					$PatientReg      = PatientRegModel::get();
					$CultureLink     = CultureLinkModel::get();
					$Organism        = OrganismModel::get();
					$Antibiotics     = AntibioticsModel::get();
	 		$AntibioticEntry = AntibioticEntryModel::query()->with('Antibiotics','CultureLink')->where('regkey',$regkey)->where('culture_link',$culture_link)->get();
			// $Transactions = TransactionsModel::query()->with('PatientReg')->where('regkey',$regkey)->get();
		
				$newAntibioticEntry    = $request->except('_token','_method');
				$AntibioticEntryCount  = count($request->only('oragnism_id')); 
				
			DB::beginTransaction();
			foreach($AntibioticEntry as $antibiotic){
				AntibioticEntryModel::query()->where('antibioticentry_id',$antibiotic->antibioticentry_id)->update(
					[
						'organism_id'       => $newAntibioticEntry['organism_id'][$antibiotic->antibioticentry_id],
						'antibiotic_id'     => $newAntibioticEntry['antibiotic_id'][$antibiotic->antibioticentry_id],
						'sensitivity'       => $newAntibioticEntry['sensitivity'][$antibiotic->antibioticentry_id],
					]
					);
			}
	
	DB::commit();
			return redirect()->back();
			}

			elseif($request->newEntry){
			$organism_select     = request()->input('organism_select');
			$sensitivity_select  = request()->input('sensitivity_select');
			$antibiotic_select   = request()->input('antibiotic_select');

			// $count_entries = AntibioticEntryModel::query()->with('Antibiotics','CultureLink')->where('regkey',$regkey)->where('culture_link',$culture_link)->get();

			// $dup_check   = $count_entries->organism_id.''.$count_entries->antibiotic_id;
			// $or                 = Request::old('organism_select');

			// $or = Request::old('organism_select');
		//    dd($dup_check);

		if(AntibioticEntryModel::where('regkey', $regkey)->where('organism_id', $organism_select)->where('antibiotic_id', $antibiotic_select)->exists()){
			return redirect()->back()->with('status','Cannot duplicate antibiotic')->withInput();
		   }
			elseif (!$organism_select){
				return redirect()->back()->with('status','No Organism Selected')->withInput();
			}else{
				$user = new AntibioticEntryModel();
					$user->regkey            = $regkey;
					$user->culture_link      = $culture_link; 
					$user->organism_id       = $organism_select;
					$user->antibiotic_id     = $antibiotic_select;
					$user->sensitivity       = $sensitivity_select;
					// dd($or);

					$user->save();
					return back()->withInput();
			
		return redirect()->back();
		}	}
}
public function delete(Request $request,$antibioticentry_id){
        
	AntibioticEntryModel::query()->where('antibioticentry_id', $antibioticentry_id)->delete();
	return redirect()->back();
}
}