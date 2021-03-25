<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class NewUserModel extends Authenticatable
{
	protected $primaryKey = 'user_id';
    protected $table = 'users';
	public $timestamps = true;

	use HasRoles,Notifiable;
	protected $guard_name = 'web';
	// protected $primaryKey = 'user_id';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'login_name', 'user_name','password'
	];

}
