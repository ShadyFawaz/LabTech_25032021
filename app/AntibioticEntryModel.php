<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class AntibioticEntryModel extends Model
{
    protected $table = 'antibiotic_entry';
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'regkey', 'culture_link','organism_id','antibiotic_id','sensitivity'
	];
	public function PatientReg(){
		return $this->belongsTo(PatientRegModel::class,'regkey','regkey');

	}
	public function CultureLink(){
		return $this->belongsTo(CulturelinkModel::class,'culture_link','culturelink_id');

	}
	public function Organism(){
		return $this->belongsTo(OrganismModel::class,'organism_id','organism_id');

	}
	public function Antibiotics(){
		return $this->belongsTo(AntibioticsModel::class,'antibiotic_id','antibiotic_id');
	}
	
	
}
