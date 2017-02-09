<?php

namespace CapOut;

use Illuminate\Database\Eloquent\Model;

class Situacao extends Model
{
    
    public $timestamps = false;
    
    protected $primaryKey = 'idSituacaoDocProc';
    
    protected $table = 'TB_SITUACAO';
    
    public function idDocsOld()
    {
        return $this->hasMany('CapOut\SituacaoDocProc','idSituacaoDocProc');
    }
    public function situacaoSuperior()
    {
        return $this->hasOne('CapOut\Situacao', 'idSituacaoDocProc', 'idSituacaoDocProcPai');
    }
    public function situacoesFilho()
    {
        return $this->hasMany('CapOut\Situacao', 'idSituacaoDocProcPai', 'idSituacaoDocProc');
    }
    public function detalheOld()
    {
        return $this->belongsTo('CapOut\SituacaoDocProc', 'idSituacaoDocProc', 'idSituacaoDocProc');
    }
    
    /**
     * não estão em uso
     * Caminho preguiçoso para salvar muitas situações de uma vez acho que não esta em uso kkk
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    
    public function naSituacao()
    {
    return $this->hasMany('CapOut\SituacaoDocProc', 'idSituacaoDocProc', 'idSituacaoDocProc');
    }
    public function detalheDocs()
    {
    return $this->belongsToMany('CapOut\DocProcCont', 'TB_DOC_PROC_TB_SITUACAO_DOC_PROC', 'idSituacaoDocProc', 'idDocProcCont')
    ->withPivot('id','dtSituacao','idMov');
    }
     **/
}
