<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabUnitModel extends Model
{
    protected $table = 'lab_unit';
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'lab_unit'	];
}
