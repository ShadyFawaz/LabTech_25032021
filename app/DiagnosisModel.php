<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DiagnosisModel extends Model
{
	use SoftDeletes;

    protected $table = 'Diagnosis';
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'diagnosis', 'description'
	];
}
