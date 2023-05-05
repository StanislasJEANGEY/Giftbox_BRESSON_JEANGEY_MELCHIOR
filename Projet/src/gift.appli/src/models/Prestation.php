<?php

namespace girft\app\models;

class Prestation extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'prestation';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = false;
    public $keyType = 'string';

    public function categorie(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Categorie::class, 'cat_id');
    }

}