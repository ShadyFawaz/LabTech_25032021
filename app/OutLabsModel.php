<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OutLabsModel extends Model
{
    protected $table = 'Out_Labs';
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'out_lab'	];

		public function TestReg(){
			return $this->hasMany(TestRegModel::class,'outlab_id','outlab_id');
		}
		public function OutLabTests(){
			return $this->hasMany(OutLabTestsModel::class,'outlab_id','outlab_id');
		}
	}
	
