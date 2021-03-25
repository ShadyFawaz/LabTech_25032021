<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionsModel extends Model
{
    protected $table = 'transactions';
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		 'regkey','payed','transaction_date','visa','user_id'
	];
	public function PatientReg(){
		return $this->belongsTo(PatientRegModel::class,'regkey','regkey');

	}

}
