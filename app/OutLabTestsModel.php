<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OutLabTestsModel extends Model
{
    protected $table = 'outlab_tests';
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'outlab_id','megatest_id','grouptest_id','test_id','duration','price'	
	];
		
		public function MegaTests(){
			return $this->belongsTo(MegaTestsModel::class,'megatest_id','megatest_id');
	
		}
		public function OutLabs(){
			return $this->belongsTo(OutLabsModel::class,'outlab_id','outlab_id');
	
		}
		public function TestData(){
			return $this->belongsTo(TestDataModel::class,'test_id','test_id');
	
		}
		public function GroupTests(){
			return $this->belongsTo(GroupTestsModel::class,'grouptest_id','grouptest_id');
	
		}
	}
