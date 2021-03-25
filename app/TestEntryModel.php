<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class TestEntryModel extends Model
{
	use SoftDeletes;
	
    protected $table = 'test_entry';
	public $timestamps = true;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'regkey', 'test_id','megatest_id','sample_id','result','unit','low','high','nn_normal','flag','test_order','profile_order','rpt','result_comment','printed','report_printed','canceled','completed','verified'
	];
	public function PatientReg(){
		return $this->belongsTo(PatientRegModel::class,'regkey','regkey');

	}
	public function TestData(){
		return $this->belongsTo(TestDataModel::class,'test_id','test_id');

	}

	public function MegaTests(){
		return $this->belongsTo(MegaTestsModel::class,'megatest_id','megatest_id');

	}
	
}
