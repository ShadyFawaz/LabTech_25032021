<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AntibioticsModel extends Model
{
	use SoftDeletes;

    protected $table = 'antibiotics';
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'antibiotic_name','report_name'
	];
}
