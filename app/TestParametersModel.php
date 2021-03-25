<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TestParametersModel extends Model
{
    protected $table = 'test_parameters';
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'test_id','test_parameter'
	];
	public function TestData(){
		return $this->belongsTo(TestDataModel::class,'test_id','test_id');

	}
	
}
