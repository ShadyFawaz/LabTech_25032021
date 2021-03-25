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
use Carbon\Carbon;
use DB;


class TestStatisticsController extends Controller
{
	
    
	public function test(){
		$PatientReg  = PatientRegModel::get();
		$MegaTests   = MegaTestsModel::get();
		$TestReg     = TestRegModel::get();
		
		$TestRegQuery = TestRegModel::query()->with('PatientReg','MegaTests');
		$datefrom  = request()->post('datefrom') ? Carbon::parse(request()->post('datefrom')) : null;
		$dateto    = request()->post('dateto') ? Carbon::parse(request()->post('dateto')) : null;
		if($datefrom && $dateto){
			
			$TestRegQuery->whereHas('PatientReg',function($qurey) use($datefrom,$dateto){
			$qurey->whereBetween('req_date',[$datefrom,$dateto]);
			});
			$datefrom = $datefrom->format('Y-m-d g:i A');
			$dateto   = $dateto->format('Y-m-d g:i A');
		}


		$users = $TestRegQuery->get();

		return view('invoice\teststatistics',['users'=>$users],compact('datefrom','dateto'));
		}  

		
}