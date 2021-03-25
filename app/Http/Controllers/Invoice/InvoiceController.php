<?php

namespace App\Http\Controllers\Invoice;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\TestRegModel;
use App\PatientRegModel;
use App\MegaTestsModel;
use App\DoctorModel;
use App\PriceListsModel;
use App\RelativePriceListsModel;
use App\GroupsTestsModel;
use App\TestDataModel;
use Carbon\Carbon;
use DB;


class InvoiceController extends Controller
{
	public function invoice(){
		$Doctor              = DoctorModel::get();
		$RelativePriceLists  = RelativePriceListsModel::with('PriceLists','RankPriceLists')->groupBy('rank_pricelist_id')->get();

		return view('invoice\invoice',compact('Doctor','RelativePriceLists'));
	}
    
	public function data(Request $request){
		// dd($request->all());
$datefrom                = request()->post('datefrom') ? Carbon::parse(request()->post('datefrom')) : null;
$dateto                  = request()->post('dateto') ?   Carbon::parse(request()->post('dateto')) : null;
$doctor_id               = request()->post('doctor');
$rank_price_list         = request()->post('rank_pricelist_id');
$relative_pricelist_id   = request()->post('relative_pricelist_id');
$PatientLoadInvoice      = request()->post('PatientLoadInvoice');
$InsuranceLoadInvoice    = request()->post('InsuranceLoadInvoice');

		if($request->invoicePatientData){
			$PatientRegQuery = PatientRegModel::query()->with('TestReg','TestReg.MegaTests','Doctor','RankPriceLists','RelativePriceLists.RankPriceLists');
			
			if($datefrom && $dateto){
				$PatientRegQuery->whereBetween('Patient_Reg.req_date',[$datefrom,$dateto]);
				$datefrom = $datefrom->format('Y-m-d g:i A');
				$dateto   = $dateto->format('Y-m-d g:i A');
			}

			if($doctor_id){
				$PatientRegQuery->where('doctor_id',$doctor_id);
			}

			if($rank_price_list){
				$PatientRegQuery->where('pricelist_id',$rank_price_list);
			}
			if($relative_pricelist_id){
				$PatientRegQuery->where('relative_pricelist_id',$relative_pricelist_id);
			}

			$users = $PatientRegQuery->get();
			$patientcount  = $users->count('regkey');
			$patientfees   = $users->sum('TestReg.patient_fees');
			$insurancefees = $users->sum('insurance_fees');

// dd($patientcount);
			if ($PatientLoadInvoice && !$InsuranceLoadInvoice){
			return view('invoice\invoicedata_pat',['users'=>$users],compact('datefrom','dateto','patientcount'));
			}
			elseif($InsuranceLoadInvoice && !$PatientLoadInvoice){
			return view('invoice\invoicedata_ins',['users'=>$users],compact('datefrom','dateto','patientcount'));
		}
	elseif($PatientLoadInvoice && $InsuranceLoadInvoice){
		return view('invoice\invoicedata',['users'=>$users],compact('datefrom','dateto','patientcount'));
	}
	else{
		return view('invoice\invoicedata',['users'=>$users],compact('datefrom','dateto','patientcount'));
	}}

	if($request->labtolabInvoice){
		$PatientRegQuery = PatientRegModel::query()->whereHas('TestRegSendOut',function($qurey) {
			$qurey->where('outlab',true);
			});
	
// dd($PatientRegQuery);
		if($datefrom && $dateto){
			$PatientRegQuery->whereBetween('Patient_Reg.req_date',[$datefrom,$dateto]);
			$datefrom = $datefrom->format('Y-m-d g:i A');
			$dateto   = $dateto->format('Y-m-d g:i A');
		}

		if($doctor_id){
			$PatientRegQuery->where('doctor_id',$doctor_id);
		}

		if($rank_price_list){
			$PatientRegQuery->where('pricelist_id',$rank_price_list);
		}
		if($relative_pricelist_id){
			$PatientRegQuery->where('relative_pricelist_id',$relative_pricelist_id);
		}

		$users = $PatientRegQuery->get();
		$patientcount  = $users->count('regkey');
		$patientfees   = $users->sum('TestRegSendOut.patient_fees');
		$insurancefees = $users->sum('insurance_fees');

// dd($users);

	return view('invoice\LabToLabInvoice',['users'=>$users],compact('datefrom','dateto','patientcount'));
}



		elseif($request->invoiceTest){
			$TestRegQuery = TestRegModel::query()->with('PatientReg','MegaTests','GroupTests','TestData');
			
			if($datefrom && $dateto){
				
				$TestRegQuery->whereHas('PatientReg',function($qurey) use($datefrom,$dateto){
					$qurey->whereBetween('req_date',[$datefrom,$dateto]);
				});
				$datefrom = $datefrom->format('Y-m-d g:i A');
				$dateto   = $dateto->format('Y-m-d g:i A');
			}
			
			$TestCount = $TestRegQuery->count('testreg_id');

			$users = $TestRegQuery->select('*',DB::raw('count(*) as mega_count'))
			->groupBy('megatest_id','grouptest_id','test_id')
			->get();
			// dd($TestCount);
			return view('invoice\teststatistics',['users'=>$users],compact('datefrom','dateto','TestCount'));
		}  
	}  

		
}