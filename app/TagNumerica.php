<?php

namespace CapOut;

use Illuminate\Database\Eloquent\Model;

class TagNumerica extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $table = 'TB_TAG_NUMERICA';

    public function tipoTag()
    {
        return $this->hasOne('CapOut\TipoTag', 'idTpTag', 'idTpTag');
    }
}
