<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NormalRangesModel extends Model
{
    protected $table = 'normal_ranges';
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		 'test_id','low','high','nn_normal','gender','age_from','age_to','age','patient_condition','active'
	];
	public function TestData(){
		return $this->belongsTo(TestDataModel::class,'test_id','test_id');

	}
	public function PatientCondition(){
		return $this->belongsTo(PatientConditionModel::class,'patient_condition','patientcondition_id');

	}
}
