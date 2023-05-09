<?php

namespace gift\app\models;

use Illuminate\Database\Eloquent\Model as Model;

class Box extends Model {

	protected $table = 'box';
	protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';

	const CREATED = 1;
	const VALIDATED = 2;
	const PAYED = 3;
	const DELIVRED = 4;
	const USED = 5;

	public function prestations() : \Illuminate\Database\Eloquent\Relations\BelongsToMany {
		return $this->belongsToMany(Prestation::class, 'box2presta', 'box_id', 'presta_id') -> withPivot('quantite') -> as('contenu');
	}

}