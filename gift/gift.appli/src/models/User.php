<?php

namespace gift\app\models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

	protected $table = 'user';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $fillable = ['id', 'nom', 'prenom', 'email', 'password','role'];

	const USER = 1;
	const ADMIN = 2;

	public function box() : \Illuminate\Database\Eloquent\Relations\HasMany {
		return $this->hasMany(Box::class, 'id');
	}

}