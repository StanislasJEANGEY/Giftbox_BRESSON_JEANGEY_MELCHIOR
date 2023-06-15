<?php

namespace gift\api\models;

/**
 * @method static findOrFail(int $id)
 */
class Categorie extends \Illuminate\Database\Eloquent\Model {

	protected $table = 'categorie';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $fillable = ['id', 'libelle', 'description'];

	public function prestations() : \Illuminate\Database\Eloquent\Relations\HasMany {
		return $this->hasMany(Prestation::class, 'cat_id');
	}

}