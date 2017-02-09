<?php

namespace CapOut;

use Illuminate\Database\Eloquent\Model;

class MovDocProc extends Model
{
   
    //public $timestamps = false;

	protected $primaryKey = 'id';

	protected $table = 'TB_MOV_TB_DOC_PROC';

	
	public function movimentacao()
	{
		return $this->hasOne('CapOut\Movimentacao','idMovimentacao','idMovimentacao');
	}

	public function docproc()
	{
		return $this->hasOne('CapOut\DocProc','idDocProc','id');
	}

		
}
