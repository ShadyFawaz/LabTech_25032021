<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\GroupTestsChildModel;

class GroupTestsModel extends Model
{
    protected $table = 'group_tests';
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		 'test_name','active','inlab','outlab'
	];
	public function GroupTestsChild(){
		return $this->hasMany(GroupTestsChildModel::class,'grouptest_id');

	}
	public function OutLabs(){
		return $this->belongsTo(OutLabsModel::class,'outlab_id','outlab_id');

	}
	// public function PriceListsTests(){
	// 	return $this->hasMany(PriceListsTestsModel::class,'grouptest_id');

	// }
}
