<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MegaTestsModel;
use App\TestDataModel;


class MegaTestsChildModel extends Model
{
    protected $table = 'mega_tests_child';
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		 'test_id','megatest_id','active'
	];
	public function megaTests(){
		return $this->belongsTo(MegaTestsModel::class,'megatest_id','megatest_id');

	}
	public function TestData(){
		return $this->belongsTo(TestDataModel::class,'test_id','test_id');

	}
}
