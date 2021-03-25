<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MegaTestsChildModel;

class MegaTestsModel extends Model
{
    protected $table = 'mega_tests';
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		 'test_name','active','inlab','outlab'
	];
	public function MegaTestsChild(){
		return $this->hasMany(MegaTestsChildModel::class,'megatest_id');

	}
	public function OutLabs(){
		return $this->belongsTo(OutLabsModel::class,'outlab_id','outlab_id');

	}
	// public function PriceListsTests(){
	// 	return $this->hasMany(PriceListsTestsModel::class,'megatest_id');

	// }
}
