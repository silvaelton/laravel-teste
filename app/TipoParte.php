<?php

namespace CapOut;

use Illuminate\Database\Eloquent\Model;

class TipoParte extends Model
{
    
    public $timestamps = false; 

	protected $primaryKey = 'id';

	protected $table = 'TB_TIPO_PARTE';

	public function pessoas()
	{
		return $this->hasMany('CapOut\SsoPartes','flTipoParte');
	}
}
