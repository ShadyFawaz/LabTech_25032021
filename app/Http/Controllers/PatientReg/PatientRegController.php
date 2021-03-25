<?php

namespace App\Http\Controllers\PatientReg;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\TitlesModel;
use App\CountryModel;
use App\DoctorModel;
use App\DiagnosisModel;
use App\PatientConditionModel;
use App\PatientRegModel;
use App\PriceListsModel;
use App\RankPriceListsModel;
use App\RelativePriceListsModel;
use App\TestRegModel;
use Carbon\Carbon;
use DB;


class PatientRegController extends Controller
{
    
	public function index(){
			$users                = PatientRegModel::query()->with('Titles','Country','Doctor','Diagnosis','PatientCondition','RankPriceLists','RelativePriceLists')->whereDate('req_date',Carbon::today())->get();
			
			// $users              = PatientRegModel::get();
			// $patient_count      = PatientRegModel::whereDate('req_date',Carbon::today())->count('regkey');
			$patient_count        = $users->count('regkey');
			// dd($patient_count);
		return view('patientreg\patientreg',['users'=>$users],compact(['patient_count']));
		}  

	public function search(){

		$patients      = PatientRegModel::query()->with('Titles','Country','Doctor','Diagnosis','PatientCondition','RankPriceLists','RelativePriceLists');
		
		
		$datefrom      = request()->post('datefrom') ? Carbon::parse(request()->post('datefrom')) : null;
		$dateto        = request()->post('dateto') ?   Carbon::parse(request()->post('dateto')) : null;
		$patient_id    = request()->post('patient_id');
		$visit_no      = request()->post('visit_no');
		$patient_name  = request()->post('patient_name');
		$phone_no      = request()->post('phone_no');

		// dd($datefrom);

		if($datefrom && !$dateto){
			$patients->whereDate('req_date','>=',$datefrom);
			$datefrom = $datefrom->format('Y-m-d g:i A');
		}

		if(!$datefrom && $dateto){
			$patients->whereDate('req_date','<=',$dateto);
			$dateto   = $dateto->format('Y-m-d g:i A');
		}
		
		if($datefrom && $dateto){
				$patients->whereBetween('req_date',[$datefrom,$dateto]);
				$datefrom = $datefrom->format('Y-m-d g:i A');
				$dateto   = $dateto->format('Y-m-d g:i A');
			}

			if($patient_id){
				$patients->where('patient_id',$patient_id);
			}

			if($visit_no){
				$patients->where('visit_no',$visit_no);
			}

			if($patient_name){
				$patients->Where('patient_name', 'like', '%' . $patient_name . '%');

			}

			if($phone_no){
				$patients->Where('phone_number',$phone_no);

			}
				// dd($patients);
				$users = $patients->get();
				$patient_count        = $users->count('regkey');
				// dd($patient_count);
	return view('patientreg\patientregsearch',['users'=>$users],compact(['patient_count']));
	} 
	
	public function indexTrashed(){
		$users    = PatientRegModel::query()->whereHas('TestReg',function($qurey) {
			$qurey->onlyTrashed();
			})
		->whereDate('req_date',Carbon::today())->withTrashed()->get();

		$totallytrashed    = PatientRegModel::query()->whereDate('req_date',Carbon::today())->onlyTrashed()->count();
		
		$withteststrashed  = PatientRegModel::query()->whereHas('TestReg',function($qurey) {
			$qurey->onlyTrashed();
			})
		->whereDate('req_date',Carbon::today())->onlyTrashed()->count();
	
		$teststrashed      = TestRegModel::query()->whereHas('PatientReg',function($qurey) {
			$qurey->whereDate('req_date',Carbon::today())->onlyTrashed();
			})->onlyTrashed()->count();

		$patient_count   = $users->count('regkey');
		// dd($patient_count);
	return view('patientreg\patientregdeleted',['users'=>$users],compact(['patient_count','totallytrashed','withteststrashed','teststrashed']));
	}  

public function searchTrashed(){

	$patients      = PatientRegModel::query()->whereHas('TestReg',function($qurey) {
		$qurey->onlyTrashed();
		})->withTrashed();
	
	$datefrom      = request()->post('datefrom') ? Carbon::parse(request()->post('datefrom')) : null;
	$dateto        = request()->post('dateto') ?   Carbon::parse(request()->post('dateto')) : null;
	$patient_id    = request()->post('patient_id');
	$visit_no      = request()->post('visit_no');
	$patient_name  = request()->post('patient_name');
	$phone_no      = request()->post('phone_no');

	// dd($datefrom);

	if($datefrom && !$dateto){
		$patients->whereDate('req_date','>=',$datefrom);
		$datefrom = $datefrom->format('Y-m-d g:i A');
	}

	if(!$datefrom && $dateto){
		$patients->whereDate('req_date','<=',$dateto);
		$dateto   = $dateto->format('Y-m-d g:i A');
	}
	
	if($datefrom && $dateto){
			$patients->whereBetween('req_date',[$datefrom,$dateto]);
			$datefrom = $datefrom->format('Y-m-d g:i A');
			$dateto   = $dateto->format('Y-m-d g:i A');
		}

		if($patient_id){
			$patients->where('patient_id',$patient_id);
		}

		if($visit_no){
			$patients->where('visit_no',$visit_no);
		}

		if($patient_name){
			$patients->Where('patient_name', 'like', '%' . $patient_name . '%');

		}

		if($phone_no){
			$patients->Where('phone_number',$phone_no);

		}
			// dd($patients);
			$users = $patients->get();

			$totallytrashed    = $users->whereNotNull('deleted_at')->count();
			$withteststrashed  = $users->count();
			$teststrashed      = $users->count('TestReg.testreg_id');

			$patient_count        = $users->count('regkey');
			// dd($patient_count);
return view('patientreg\patientregdeletedsearch',['users'=>$users],compact(['patient_count','totallytrashed','withteststrashed','teststrashed']));
}  
public function deletePatient($regkey){
TestRegModel::query()->where('regkey',$regkey)->delete();	
PatientRegModel::query()->where('regkey',$regkey)->delete();
return redirect('patientreg');
}

public function restorePatient($regkey){
	TestRegModel::query()->where('regkey',$regkey)->onlyTrashed()->restore();	
	PatientRegModel::query()->where('regkey',$regkey)->onlyTrashed()->restore();
	return redirect('patientreg');
}
}