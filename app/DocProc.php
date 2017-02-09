<?php

namespace CapOut;

use CapOut\Helpers\TratamentoDeDados;
use Illuminate\Database\Eloquent\Model;
use CapOut\Helpers\Data;

class DocProc extends Model
{
    
    //public $timestamps = false;
    
    protected $primaryKey = 'idDocProc';
    
    protected $table = 'TB_DOCUMENTO_PROCESSO';
    
    /**
     * *******************************************************************************
     *
     * Aqui fazemos os Geters
     *
     * *******************************************************************************
     */
    
    public function getDtCadastroFullAttribute()
    {
        $data= TratamentoDeDados::dataParaDateTime($this->attributes['dtCadastro']);
        return  $data;
    }
    
    public function getDtCadastroAttribute($value)
    {
        if(isset($value)){
            $data= TratamentoDeDados::dataParaDateTime($value);
            if($data instanceof \DateTime)
                return  $data->format('d/m/Y');
        }
        return $value;
    }
    public function getDtAutuacaoAttribute($value) {
        if(isset($value)){
            $data= TratamentoDeDados::dataParaDateTime($value);
            if($data instanceof \DateTime)
                return  $data->format('d/m/Y');
        }
        return $value;
    }
    public function getNumeroAttribute($value)
    {
        if(isset($value)){
            return str_pad($value, 6, '0', STR_PAD_LEFT);
        }
        return $value;
    }
    
    public function setDtAutuacaoAttribute($value) {
        $data= TratamentoDeDados::dataParaDateTime($value);
        if($data instanceof \DateTime)
            $this->attributes['dtAutuacao'] = $data->format('Y-m-d H:i');
    }
    /**
     * *******************************************************************************
     *
     * Aqui fazemos os Seters
     *
     * *******************************************************************************
     */
    public function setNumeroAttribute($value)
    {
        //dump($value);
        if(isset($value)){
            if($value=='count'){
                //dump($value);
                $aux= DocProc::where('ssoArea',$this->attributes['ssoArea'])
                    ->where('ano',$this->attributes['ano'])
                    ->where('idTpDocProc',$this->attributes['idTpDocProc'])
                    ->count();
                $this->attributes['numero']=$aux+1;
                
            }else{
                $this->attributes['numero']=$value;
            }
        }
    }
    public function setFlTpDocProcAttribute($value)
    {
        if($value=='')
            $this->attributes['flTpDocProc']=null;
        else
            $this->attributes['flTpDocProc']=$value;
        
    }
    
    
    /**
     * Relacionamentos
     *
     */
    
    public function pedidosAguardando()
    {
        return $this->hasMany('CapOut\DocProcCont', 'idDocProcOrigem', 'idDocProc')
            ->whereIn('idUltimaSituacao', function ($quer)  {
                $quer->select('id')
                    ->from(with(new SituacaoDocProc())->getTable())
                    ->whereIn('idSituacaoDocProc', [1, 730, 731, 732]);
            })
            ->whereColumn('idDocProcOrigem','<>','idDocProc');
    }
    
    public function movDocProc()
    {
        return $this->belongsToMany('CapOut\Movimentacao','TB_MOV_TB_DOC_PROC', 'idDocProc','idMovimentacao' )->withPivot('id','idMovimentacao','idDocProc','volumesMov','total')->orderBy('dtEnvio','desc');
    }
    
    public function ultimaMovimentacao()
    {
        return $this->hasOne('CapOut\Movimentacao', 'idMovimentacao', 'idUltimaMov');
    }
    public function ultimaMovPivot()
    {
        return $this->hasOne('CapOut\MovDocProc', 'idMovimentacao', 'idUltimaMov')->where('idDocProc',$this->attributes['idDocProc']);
    }
    
    
    public function tipoDocProc()
    {
        return $this->hasOne('CapOut\tipoDocProc', 'idTpDocProc','idTpDocProc');
    }
    
    public function docProcSuperior()
    {
        return $this->hasOne('CapOut\DocProc', 'idDocProc', 'idDocProcPai');
    }
    
    /**
     * indica a continuação direta do cabeçalho
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function docProcCont()
    {
        return $this->hasOne('CapOut\DocProcCont', 'idDocProc', 'idDocProc');
    }
    /**
     *  chama o tipo de relação que o documento tem o o outro
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tipoAnexo()
    {
        return $this->hasOne('CapOut\TipoAnexo', 'flTpAnexo', 'id');
    }
    /**
     * chama todos os documentos que em algum nivel estão relacionados com o processo
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function todosPedidos()
    {
        return $this->hasMany('CapOut\DocProcCont', 'idDocProcOrigem', 'idDocProc')
            ->whereColumn('idDocProc','!=','idDocProcOrigem');
    }
    /*
     *
     * indica as relações pela cabeça
     *
     */
    public function processosRelacionados()
    {
        return $this->hasMany('CapOut\DocProc', 'idDocProcOrigem', 'idDocProc')->whereIn('flTpAnexo',[1,2]);
    }
    public function documentosRelacionados()
    {
        return $this->hasMany('CapOut\DocProc', 'idDocProcPai', 'idDocProc')->whereIn('flTpAnexo',[3,4]);
    }
    public function processosApenso()
    {
        return $this->hasMany('CapOut\DocProc', 'idDocProcPai', 'idDocProc')->where('flTpAnexo',1);
    }
    public function processosAnexo()
    {
        return $this->hasMany('CapOut\DocProc', 'idDocProcPai', 'idDocProc')->where('flTpAnexo',2);
    }
    public function documentosResposta()
    {
        return $this->hasMany('CapOut\DocProc', 'idDocProcPai', 'idDocProc')->where('flTpAnexo',4);
    }
    public function documentosAnexo()
    {
        return $this->hasMany('CapOut\DocProc', 'idDocProcPai', 'idDocProc')->where('flTpAnexo',3);
    }
}
