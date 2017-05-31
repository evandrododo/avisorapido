<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
	public $timestamps = true;

    protected $fillable = [
        'nome',
    ];

    /**
     * Pega o usuário desse cliente
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
