<?php

namespace CapOut;

use Illuminate\Database\Eloquent\Model;

class TipoAnexo extends Model
{
    public $timestamps = false; 

	protected $primaryKey = 'id';

	protected $table = 'TB_TIPO_ANEXO';
    
}
