<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfilesTestsModel extends Model
{
    protected $table = 'profiles_tests';
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'profile_id', 'megatest_id'
	];

	public function Profiles(){
		return $this->belongsTo(ProfilesModel::class,'profile_id','profile_id');

	}

	public function MegaTests(){
		return $this->belongsTo(MegaTestsModel::class,'megatest_id','megatest_id');

	}
	public function TestData(){
		return $this->belongsTo(TestDataModel::class,'test_id','test_id');

	}
	public function GroupTests(){
		return $this->belongsTo(GroupTestsModel::class,'grouptest_id','grouptest_id');

	}
}
