<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TestDataModel extends Model
{
    protected $table = 'test_data';
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'abbrev', 'report_name','subgroup','profile','test_header','unit','test_order','profile_order','culture_link','sample_type','sample_condition','lab_unit','calculated','test_equation','active','rpt','default_value','assay_time'
	];
	public function Groups(){
		return $this->belongsTo(GroupsModel::class,'test_group','group_id');

	}
	public function ResultsUnits(){
		return $this->belongsTo(ResultsUnitsModel::class,'unit','resultunit_id');

	}
	public function Culturelink(){
		return $this->belongsTo(CultureLinkModel::class,'culture_link','culturelink_id');

	}
	public function SampleType(){
		return $this->belongsTo(SampleTypeModel::class,'sample_type','sampletype_id');

	}
	public function SampleCondition(){
		return $this->belongsTo(SampleConditionModel::class,'sample_condition','samplecondition_id');

	}
	public function LabUnit(){
		return $this->belongsTo(LabUnitModel::class,'lab_unit','labunit_id');

	}
	public function ResultEntry(){
		return $this->hasMany(TestEntryModel::class,'test_id');

	}
	public function OutLabs(){
		return $this->belongsTo(OutLabsModel::class,'outlab_id','outlab_id');

	}
	// public function PriceListsTests(){
	// 	return $this->hasMany(PriceListsTestsModel::class,'test_id');

	// }
	
}
