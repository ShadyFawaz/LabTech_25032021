<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TitlesModel;
use Carbon\Carbon;

class NewPatientDataModel extends Model
{
    protected $table = 'patient_data';
	public $timestamps = true;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'Patient_ID', 'Title_id','patient_name','DOB','phone_number','Ag','Age','Gender','Address','Email','Website','Country','Nationality'
	];
	public function Title(){
		return $this->belongsTo(TitlesModel::class,'Title_id','title_id');

	}
	public function Country(){
		return $this->belongsTo(CountryModel::class,'Title_id','title_id');

	}
// 	public function getAgeeAttribute()
// {
//     return Carbon::parse($this->attributes['dob'])->agee;
// }
}
