<?php

namespace CapOut;

use Illuminate\Database\Eloquent\Model;

class TipoTag extends Model
{
    
    public $timestamps = false; 

	protected $primaryKey = 'idTpTag';

	protected $table = 'TB_TIPO_TAG';

	public function tags()
	{
		return $this->hasMany('CapOut\Tag', 'idTpTag', 'idTpTag');
	}

}
