<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubGroupsModel extends Model
{
    protected $table = 'subgroups';
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'group_id', 'subgroup_name','report_name'
	];

	public function Groups(){
		return $this->belongsTo(GroupsModel::class,'group_id','group_id');

	}

	public function TestData(){
		return $this->hasMany(TestDataModel::class,'subgroup_id','subgroup');

	}
}
