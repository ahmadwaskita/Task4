<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	protected $guarded = array('id');
	protected $fillable = array('email','username', 'password');
	public static function valid($id='',$pass_up=''){
		return array(
			'email' => 'required|email|unique:users,email'.($id?",id":''),
			'username' => 'required|min:6|unique:users, username'.($id?",id":''),
			'password' => ($pass_up ?'':"required|min:8|confirmed")
			);
	}

}
