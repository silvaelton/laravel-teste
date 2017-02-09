<?php

namespace CapOut;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    
    public $timestamps = false; 

	protected $primaryKey = 'idTag';

	protected $table = 'TB_TAG';

    public function tipoTag()
    {
        return $this->hasOne('CapOut\TipoTag', 'idTpTag', 'idTpTag');
    }
}
