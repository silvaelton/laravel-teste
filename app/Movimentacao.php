<?php

namespace CapOut;

use CapOut\Helpers\TratamentoDeDados;
use Illuminate\Database\Eloquent\Model;
use CapOut\Helpers\Data;

class Movimentacao extends Model
{

  //public $timestamps = false;
  protected $touches = ['docProc'];
  protected $primaryKey = 'idMovimentacao';

  protected $table = 'TB_MOVIMENTACAO';
  private $areaDestinoL;
  private $servDestinoL;
  private $areaOrigemL;
  private $servOrigemL;


  public function getDtEnvioFullAttribute($value)
  {
    if(isset($value)){
      return TratamentoDeDados::dataParaDateTime($value);
    }
    return $value;
  }
  public function getDtRecebidoFullAttribute($value)
  {
    if(isset($value)){
      return TratamentoDeDados::dataParaDateTime($value);
    }
    return $value;
  }
  public function getDtEnvioAttribute($value)
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
  public function getDtRecebidoAttribute($value)
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

  public function docProc()
  {
    return $this->belongsToMany('CapOut\DocProc', 'TB_MOV_TB_DOC_PROC', 'idMovimentacao', 'idDocProc')
    ->withPivot('id','volumesMov','total');
  }
  //p3 aqui
  public function detalhe()
  {
    return $this->hasMany('CapOut\MovDocProc', 'idMovimentacao', 'idMovimentacao');
  }
  public function getAreaDestinoAttribute()
  {
    if(!($this->areaDestinoL instanceof Parte)){
      $this->areaDestinoL=new Parte($this->attributes['idSsoAreaDestino']);
    }
    return $this->areaDestinoL;
  }
  public function getServDestinoAttribute()
  {
    if(!($this->servDestinoL instanceof Parte)){
      $this->servDestinoL=new Parte($this->attributes['idSsoServDestino']);
    }
    return $this->servDestinoL;
  }
  public function getAreaOrigemAttribute()
  {
    if(!($this->areaOrigemL instanceof Parte)){
      $this->areaOrigemL =new Parte($this->attributes['idSsoAreaOrigem']);
    }
    return $this->areaOrigemL ;
  }
  public function getServOrigemAttribute()
  {
    if(!($this->servOrigemL instanceof Parte)){
      $this->servOrigemL=new Parte($this->attributes['idSsoServOrigem']);
    }
    return $this->servOrigemL;
  }
}
