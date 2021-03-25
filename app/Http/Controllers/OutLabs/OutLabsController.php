<?php

namespace App\Http\Controllers\OutLabs;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\OutLabsModel;
use App\OutLabTestsModel;
use App\MegaTestsModel;
use App\TestDataModel;
use App\GroupTestsModel;
use DB;


class OutLabsController extends Controller
{
    public function index(){
		$users      = OutLabsModel::get();
		$MegaTests  = MegaTestsModel::where('active',true)->get();
		$GroupTests = MegaTestsModel::where('active',true)->get();
		$TestData   = TestDataModel::where('active',true)->get();

		return view('outlabs\outlabs',['Megatests'=>$MegaTests , 'TestData'=>$TestData , 'GroupTests' => $GroupTests],['users'=>$users]);
		}  


    public function insert(){
    
		$users      = OutLabsModel::get();
		$MegaTests  = MegaTestsModel::orderBy('test_name')->where('active',true)->get();
		$GroupTests = GroupTestsModel::orderBy('test_name')->where('active',true)->get();
		$TestData   = TestDataModel::orderBy('abbrev')->where('active',true)->get();

		return view('outlabs\newoutlab',['MegaTests'=>$MegaTests , 'TestData'=>$TestData , 'GroupTests' => $GroupTests],['users'=>$users]);
		}  
    
    public function create(Request $request){
		//dd($request->all());
        $rules = [
			'profile_name'   => 'required|string|min:2|max:255',
			// 'megatest_id'    => 'required_without:test_id,grouptest_id',
			// 'test_id'        => 'required_without:megatest_id,grouptest_id',
			// 'grouptest_id'   => 'required_without:megatest_id,test_id',

		];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
			//return redirect('insert')
			//->withInput()
			//->withErrors($validator);
			return redirect('newoutlab')->with('status',"Insert failed");
		}
		else{
            $data = $request->input();
			try{
				$user = new OutLabsModel();
                $user->out_lab    = $data['out_lab'];
				$user->save();

				
				$test_check      = $request->has('test_id');
				$megatest_check  = $request->has('megatest_id');
				$grouptest_check = $request->has('grouptest_id');

				// dd($megatest_check);
				$test_check     = $request->has('test_id');
				$megatest_check = $request->has('megatest_id');

			if ($megatest_check){
			foreach($request->megatest_id as $megaid){
				$OutLabTests  = new OutLabTestsModel();
				$OutLabTests->outlab_id        = $user->id;
				$OutLabTests->megatest_id      = $megaid;
				$OutLabTests->save();
			}}
			if ($grouptest_check){
				foreach($request->grouptest_id as $groupid){
					$OutLabTests  = new OutLabTestsModel();
					$OutLabTests->outlab_id        = $user->id;
					$OutLabTests->grouptest_id     = $groupid;
					$OutLabTests->save();
				}}
			if ($test_check){
				foreach($request->test_id as $testid){
					$OutLabTests  = new OutLabTestsModel();
					$OutLabTests->outlab_id        = $user->id;
					$OutLabTests->test_id      = $testid;
					$OutLabTests->save();
				}}
				return redirect('outlabs')->with('status',"Insert successfully");
			}
			catch(Exception $e){
				return redirect('newoutlab')->with('failed',"Insert failed");
			}
		}
	}
	public function show($outlab_id) {
		$users = OutLabsModel::where('outlab_id',$outlab_id)->get();
		return view('outlabs\editoutlab',['users'=>$users],compact('outlab_id'));
	}
	public function edit(Request $request,$outlab_id) {
	$out_lab  = $request->input('out_lab');
	
	$users = OutLabsModel::where('outlab_id',$outlab_id)->update([
		'out_lab'  =>  $out_lab,
	]);

	return redirect('outlabs')->with('status',"Updated Successfully");
	
	}
}