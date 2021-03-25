<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Session\Session;
use App\OutLabsModel;
use App\OutLabTestsModel;
use App\PatientRegModel;
use App\MegaTestsModel;
use App\MegaTestsChildModel;
use App\TestDataModel;
use App\PriceListsModel;
use App\PriceListsTestsModel;
use App\GroupsModel;
use App\SubGroupsModel;
use App\GroupTestsModel;
use App\GroupTestsChildModel;
use App\NormalRangesModel;
use Milon\Barcode\DNS1D;
use DB;


class TestController extends Controller
{
    
	public function generateBarcode(){
		return view('barcode');

	}
		  	
}