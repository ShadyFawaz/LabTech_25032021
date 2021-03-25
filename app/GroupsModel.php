<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupsModel extends Model
{
    protected $table = 'Groups';
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'group_name', 'report_name'
	];
}
