<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SampleConditionModel extends Model
{
    protected $table = 'sample_condition';
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'sample_condition'	];
}
