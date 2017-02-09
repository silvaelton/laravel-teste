<?php

namespace CapOut;

use Illuminate\Database\Eloquent\Model;

class SituacaoArea extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'TB_SITUACAO_SSO_AREA';
  	protected $instanciaSsO;

    public function detalhe()
    {
        return $this->hasOne('CapOut\Situacao', 'idSituacaoDocProc', 'idSituacao');
    }
    public function getAreaAttribute()
  	{
  		if(!($this->instanciaSsO instanceof Parte)){
  			$this->instanciaSsO = new Parte($this->attributes['idSsoArea']);
  		}
  		return $this->instanciaSsO;
  	}
}
