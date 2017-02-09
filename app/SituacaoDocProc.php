<?php

namespace CapOut;

use CapOut\Helpers\TratamentoDeDados;
use Illuminate\Database\Eloquent\Model;
use CapOut\Helpers\Data;

class SituacaoDocProc extends Model
{

  //public $timestamps = false;
  protected $primaryKey = 'id';
  protected $table = 'TB_SITUACAO_TB_DOC_PROC';
  protected $fillable =['idDocProcCont','idSituacaoDocProc','dtSituacao','idMov','idSituacaoArea'];


  public function getDtSituacaoFullAttribute($value)
  {
    if(isset($value)){
      return TratamentoDeDados::dataParaDateTime($value);
    }
    return $value;
  }
  public function getDtSituacaoAttribute($value)
  {
    if(isset($value)){
      $temp=TratamentoDeDados::dataParaDateTime($value);
      if($temp){
        return $temp->format('d/m/Y');
      }
      return null;
    }
    return $value;
  }
  public function getflCienteAttribute($value)
  {
    if(isset($value)){
      if($value==1) {
        return 'Sim';
      }
    }
    return 'Não';
  }
  public function detalhes()
  {
    return $this->hasOne('CapOut\Situacao', 'idSituacaoDocProc', 'idSituacaoDocProc');
  }

  public function movimentacao()
  {
    return $this->hasOne('CapOut\Movimentacao', 'idMovimentacao', 'idMov');
  }

  public function area()
  {
    return $this->hasOne('CapOut\SituacaoArea', 'id', 'idSituacaoArea');
  }
  public function anexos()
  {
    return $this->belongsToMany('CapOut\DocProcCont', 'TB_SITUACAO_DOC_COMPOSTO','idSituacaoDocProcCont', 'idDocProcCont')
    ->withPivot('id')
    ->wherePivot('disponivel',1);
  }

  public function docProc()
  {
    return $this->hasOne('CapOut\DocProcCont', 'idDocProcCont', 'idDocProcCont');
  }
}
