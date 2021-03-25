<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\RankPriceListsTestsModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class RankPriceListsModel extends Model
{
	use SoftDeletes;
    protected $table = 'rank_price_lists';
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		 'rank_pricelist_name'
	];
	public function RelativePriceLists(){
		return $this->hasMany(RelativePriceListsTestsModel::class,'rank_pricelist_id');

	}
}
