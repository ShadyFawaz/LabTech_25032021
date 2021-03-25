<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SampleTypeModel extends Model
{
    protected $table = 'sample_type';
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'sample_type'	];
}
