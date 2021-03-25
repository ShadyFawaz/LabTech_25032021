<?php

namespace App\Http\Controllers\Transactions;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\PatientRegModel;
use App\TransactionsModel;
use App\TestRegModel;
use Carbon\Carbon;
use DB;


class TransactionsController extends Controller
{
    
	public function index($regkey){

		$PatientReg   = PatientRegModel::query()->with('TestReg')->where('regkey','=',$regkey);
		$Transactions = TransactionsModel::query()->with('PatientReg','PatientReg.TestReg')->where('regkey','=',$regkey);
		$users        = $Transactions->get();
		$patients     = $PatientReg->get();
		$change = $users[0]->PatientReg->TestReg->sum('patient_fees')-(($users[0]->PatientReg->discount))-($users->sum('payed'));
		$total  = $users[0]->PatientReg->TestReg->sum('patient_fees');
		$priceafter = ($users[0]->PatientReg->TestReg->sum('patient_fees'))-($users[0]->PatientReg->discount);
		// dd($change);
		// dd($users->all());
		return view('transactions/transactions',['users'=>$users],compact('PatientReg','change','total','priceafter','regkey'));
		}  

		public function reset($regkey){

			$PatientReg   = PatientRegModel::query()->with('TestReg','Doctor','RankPriceLists','RelativePriceLists')->where('regkey',$regkey);
			$Transactions = TransactionsModel::query()->with('PatientReg','PatientReg.TestReg')->where('regkey','=',$regkey);
			$TestReg      = TestRegModel::query()->with('MegaTests','TestData','GroupTests')->where('regkey',$regkey)->get();
			$users        = $Transactions->get();
			$patients     = $PatientReg->get();
            $change = $users[0]->PatientReg->TestReg->sum('patient_fees')-(($users[0]->PatientReg->discount))-($users->sum('payed'));
			$total  = $users[0]->PatientReg->TestReg->sum('patient_fees');
			$payed  = $users->sum('payed');

			$priceafter = ($users[0]->PatientReg->TestReg->sum('patient_fees'))-($users[0]->PatientReg->discount);
			// dd($change);
			return view('transactions/reset',['users'=>$users],compact('PatientReg','TestReg','change','total','priceafter','patients','payed'));
			}  	
		public function create(Request $request,$regkey){
			//dd($request->all());
			$data = $request->regkey;
			// dd($test_id);
					$user = new TransactionsModel();
					$user->regkey               = $regkey;
					$user->payed                = null;
					$user->visa                 = '0';
					$user->transaction_date     = null;
					$user->user_id              = null;

					$user->save();
					return redirect()->back();
				}
				
				public function edit(Request $request,$regkey) {

				$disc      = $request->input('disc');
				$discount  = $request->input('discount');
				DB::update('update patient_reg set disc=?,discount=? where regkey = ?',[$disc,$discount,$regkey]);
		
					// dd($request->all());
				$Transactions = TransactionsModel::query()->with('PatientReg')->where('regkey',$regkey)->get();
			
					$newTransactions    = $request->except('_token','_method');
					$TransactionsCount  = count($request->only('payed')); 
					
				DB::beginTransaction();
				foreach($Transactions as $transaction){
					TransactionsModel::query()->where('transaction_id',$transaction->transaction_id)->whereNull('user_id')->update(
						[
							'payed'                  => $newTransactions['payed'][$transaction->transaction_id],
							'visa'                   => (isset($newTransactions['visa']) && isset($newTransactions['visa'][$transaction->transaction_id])) ? true : false,
							'transaction_date'       => now(),
							'user_id'                => '1',
						]
						);
				}

				// foreach ($Transactions['payed'] as $i=> $transaction) {
				// 	// dd($i);
				// 	// $i=(string)$i;
		        //     $Payed       = $Transactions['payed'][$i];
				// 	$Visa        = isset($Transactions['visa'][$i]) ? $Transactions['visa'][$i] : false;
					
				// 	$Transactions = TransactionsModel::query()->where('transaction_id',$i)->whereNull('user_id')->update(
				// 		[
				// 			'payed'                  =>$Payed,
				// 			'visa'                   =>$Visa,
				// 			'transaction_date'       =>now(),
				// 			'user_id'                =>'1',
				// 	]
						
				// 	);
					
				// }
			// when done commit
		DB::commit();
				// return redirect()->back();
				return redirect('newpatientreg')->with('Status',"Insert Successfully");
				}

	public function deleteTransaction($transaction_id){

		$Transactions = TransactionsModel::query()->where('transaction_id',$transaction_id)->whereNull('user_id')->delete();
		
		return redirect()->back();
		}  
			}
			