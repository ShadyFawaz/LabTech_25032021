<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class RegTrackingModel extends Model
{
    protected $table = 'reg_tracking';
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id','regkey','status'
	];
	public function Users(){
		return $this->belongsTo(NewuserModel::class,'user_id','user_id');

	}

	public function PatientReg(){
		return $this->belongsTo(PatientRegModel::class,'regkey','regkey')->withTrashed();

	}
	
}
