<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestRegModel extends Model
{
	use SoftDeletes;
	
    protected $table = 'test_reg';
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'regkey', 'megatest_id','patient_fees','insurance_fees','inlab','outlab','lab_name','canceled','registered','user_id'
	];
	
	public function PatientReg(){
		return $this->belongsTo(PatientRegModel::class,'regkey','regkey');

	}
	public function MegaTests(){
		return $this->belongsTo(MegaTestsModel::class,'megatest_id','megatest_id');

	}
	public function TestData(){
		return $this->belongsTo(TestDataModel::class,'test_id','test_id');

	}
	public function Grouptests(){
		return $this->belongsTo(GroupTestsModel::class,'grouptest_id','grouptest_id');

	}
	public function Users(){
		return $this->belongsTo(NewUserModel::class,'user_id','user_id');

	}
	public function OutLabs(){
		return $this->belongsTo(OutLabsModel::class,'outlab_id','outlab_id');

	}

}
