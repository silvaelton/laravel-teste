<?php

namespace CapOut;

use Illuminate\Database\Eloquent\Model;

class SituacaoDocProcAnexo extends Model
{
   
    //public $timestamps = false;

	protected $primaryKey = 'id';

	protected $table = 'TB_SITUACAO_DOC_COMPOSTO';
    
	protected $guarded=[];
}
