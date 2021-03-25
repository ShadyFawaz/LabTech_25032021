<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\GroupTestsModel;
use App\TestDataModel;


class GroupTestsChildModel extends Model
{
    protected $table = 'group_tests_child';
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		 'test_id','grouptest_id','active'
	];
	public function GroupTests(){
		return $this->belongsTo(GroupTestsModel::class,'grouptest_id','grouptest_id');

	}
	public function TestData(){
		return $this->belongsTo(TestDataModel::class,'test_id','test_id');

	}
}
