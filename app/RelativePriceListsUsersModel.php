<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\RelativePriceListsModel;
use App\UsersModel;

class RelativePriceListsUsersModel extends Model
{
	use SoftDeletes;
    protected $table = 'relative_pricelists_users';
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'relative_pricelist_id','user_id','active'
	];

	public function RelativePriceLists(){
		return $this->belongsTo(RelativePriceListsModel::class,'relative_pricelist_id','relative_pricelist_id');

	}
	public function Users(){
		return $this->belongsTo(UsersModel::class,'user_id','user_id');

	}

}
