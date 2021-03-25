<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MegaTestsModel;
use App\PriceListsModel;


class PriceListsTestsModel extends Model
{
    protected $table = 'price_lists_tests';
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		 'pricelist_id','megatest_id','price'
	];
	public function megaTests(){
		return $this->belongsTo(MegaTestsModel::class,'megatest_id','megatest_id');

	}
	public function PriceLists(){
		return $this->belongsTo(PriceListsModel::class,'pricelist_id','pricelist_id');

	}
	public function TestData(){
		return $this->belongsTo(TestDataModel::class,'test_id','test_id');

	}
	public function GroupTests(){
		return $this->belongsTo(GroupTestsModel::class,'grouptest_id','grouptest_id');

	}
}
