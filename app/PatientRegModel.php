<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientRegModel extends Model
{
	use SoftDeletes;

    protected $table = 'patient_reg';
	public $timestamps = true;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'patient_id', 'title_id','patient_name','gender','dob','phone_number','ag','age','req_date','req_time','patient_condition','email','website','country_id','nationality_id','doctore_id','diagnosis_id','comment'
	];
	public function Titles(){
		return $this->belongsTo(TitlesModel::class,'title_id','title_id');

	}
	public function Country(){
		return $this->belongsTo(CountryModel::class,'country_id','country_id');

	}

	public function Doctor(){
		return $this->belongsTo(DoctorModel::class,'doctor_id','doctor_id');

	}
	public function Diagnosis(){
		return $this->belongsTo(DiagnosisModel::class,'diagnosis_id','diagnosis_id');

	}

	public function PatientCondition(){
		return $this->belongsTo(PatientConditionModel::class,'patient_condition','patientcondition_id');

	}
	public function RankPriceLists(){
		return $this->belongsTo(RankPriceListsModel::class,'pricelist_id','rank_pricelist_id');

	}
	public function RelativePriceLists(){
		return $this->belongsTo(RelativePriceListsModel::class,'relative_pricelist_id','relative_pricelist_id');

	}
	
	public function TestReg(){
		return $this->hasMany(TestRegModel::class,'regkey','regkey');
	}

	public function TestRegSendOut(){
		return $this->hasMany(TestRegModel::class,'regkey','regkey')->where('outlab',true);
	}
// 	public function getAgeeAttribute()
// {
//     return Carbon::parse($this->attributes['dob'])->agee;
// }
}
