<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\PriceListsTestsModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class PriceListsModel extends Model
{
	use SoftDeletes;
    protected $table = 'price_lists';
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		 'price_list'
	];
	public function PriceListsTests(){
		return $this->hasMany(PriceListsTestsModel::class,'pricelist_id');

	}
}
