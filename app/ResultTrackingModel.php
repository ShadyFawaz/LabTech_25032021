<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ResultTrackingModel extends Model
{
    protected $table = 'result_tracking';
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'result_id','regkey', 'test_id','user_id','result'
	];
	public function TestData(){
		return $this->belongsTo(TestDataModel::class,'test_id','test_id');

	}
	public function Users(){
		return $this->belongsTo(NewUserModel::class,'user_id','user_id');

	}
	public function PatientReg(){
		return $this->belongsTo(PatientRegModel::class,'regkey','regkey');

	}
	public function ResultEntry(){
		return $this->belongsTo(TestEntryModel::class,'result_id','result_id');

	}
}
