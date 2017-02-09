<?php

namespace CapOut;

use Illuminate\Database\Eloquent\Model;

class TipoDocProc extends Model
{
    
    public $timestamps = false; 

	protected $primaryKey = 'idTpDocProc';

	protected $table = 'TB_TIPO_DOCUMENTO_PROCESSO';
}
