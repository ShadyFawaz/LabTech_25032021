<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\RankPriceListsModel;

class RelativePriceListsModel extends Model
{
	use SoftDeletes;
    protected $table = 'relative_price_lists';
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'pricelist_id', 'rank_pricelist_id','relative_pricelist_name','patient_load','insurance_load','insurance_factor'
	];

	public function RankPriceLists(){
		return $this->belongsTo(RankPriceListsModel::class,'rank_pricelist_id','rank_pricelist_id');

	}
	public function PriceLists(){
		return $this->belongsTo(PriceListsModel::class,'pricelist_id','pricelist_id');

	}

}
