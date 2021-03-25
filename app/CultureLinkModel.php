<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CultureLinkModel extends Model
{
    protected $table = 'culture_link';
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'culture_name'	];
}
