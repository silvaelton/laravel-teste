<?php

namespace CapOut;

use CapOut\Helpers\TratamentoDeDados;
use Illuminate\Database\Eloquent\Model;
use CapOut\Helpers\Data;

class DocProcCont extends Model
{

    //public $timestamps = false;
    protected $touches = ['identificacao','anexadoA'];
    protected $primaryKey = 'idDocProcCont';

    protected $table = 'TB_DOC_PROC_CONT';
    protected $instanciaSsO;

    /**
     * *******************************************************************************
     *
     * Aqui fazemos os geters
     *
     * *******************************************************************************
     */

    /*
     * Tratamento do endereço para exibir em areas menores
     * @param int $limite
     * @return null|string
     */
    public function getEndereco($limite=21){
        $texto=$this->attributes['dsEndereco'];
        $contador = strlen($texto);
        if ( $contador >= $limite ) {
            $texto = substr($texto, 0, strrpos(substr($texto, 0, $limite), ' ')) . '...';
            return $texto;
        }else{
            return $texto;
        }
        return null;
    }

    /*
     * tratamento da data para exibição
     * @param $value
     * @return string
     */
    public function getDtDocProcContFullAttribute() {
        $data= TratamentoDeDados::dataParaDateTime($this->attributes['dtDocProcCont']);
            return  $data;
    }
    public function getDtDocProcContAttribute($value) {
        $data= TratamentoDeDados::dataParaDateTime($value);
        if($data instanceof \DateTime)
            return  $data->format('d/m/Y');
    }
    public function getAnexosSituacaoDisponivelAttribute()
    {
        $aux= DocProcCont::whereIn('idDocProcCont',function($q) {
            $q->select('idDocProcCont')
                ->from(with(new SituacaoDocProcAnexo)->getTable())
                ->whereIn('idSituacaoDocProcCont',function($query) {
                    $query->select('id')
                        ->from(with(new SituacaoDocProc)->getTable())
                        ->where('idDocProcCont',$this->attributes['idDocProcCont']);
                })
                ->where('disponivel',1);
        })->get(); 
        return $aux;
    }
    /**
     * *******************************************************************************
     *
     * Aqui fazemos os Seters
     *
     * *******************************************************************************
     */
    
    public function getRaAttribute() {
        if(!($this->instanciaSsO instanceof Parte)){
            $this->instanciaSsO = new Parte($this->attributes['ssoRa'],'area');
        }
        return $this->instanciaSsO;
    }
    /*
     * trata entrada de data para salvar no banco
     * @param $value
     */
    public function setDtDocProcContAttribute($value) {
        $data= TratamentoDeDados::dataParaDateTime($value);
        if($data instanceof \DateTime)
            $this->attributes['dtDocProcCont'] = $data->format('Y-m-d H:i');
    }

    public function setIdAssuntoAttribute($value)
    {
        if($value=='')
            $this->attributes['idAssunto']=null;
        else
            $this->attributes['idAssunto']=$value;

    }
    public function setSsoRaAttribute($value)
    {
        if($value=='')
            $this->attributes['ssoRa']=null;
        else
            $this->attributes['ssoRa']=$value;

    }
    
    /**
     * -------------------------------------------------------------------------------
     * FIM tratamento
     * -------------------------------------------------------------------------------
     */
    /**
     * *******************************************************************************
     *
     * Aqui apontamos relacionamentos
     *
     * *******************************************************************************
     */
    /**
     * *******************************************************************************
     * Relacionamentos simples
     * *******************************************************************************
     */

    /*
     * Retorna o objeto que identifica esse documento
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function identificacao()
    {
        return $this->hasOne('CapOut\DocProc', 'idDocProc', 'idDocProc');
    }
    /*
     * retorna o assunto
     */
    public function assunto()
    {
        return $this->hasOne('CapOut\Assunto', 'idAssunto', 'idAssunto');
    }

    /*
     * Utiliza campo desnormatizado pra pegar  a ultima atualização
     */
    public function ultimaSituacao()
    {
        return $this->hasOne('CapOut\SituacaoDocProc', 'id', 'idUltimaSituacao');
    }

    /*
     * Utiliza campo desnormatizado pra pegar  a ultima movimentacao
     */
    public function ultimaMovimentacao()
    {
        return $this->hasOne('CapOut\movimentacao', 'idMovimentacao', 'idUltimaMovimentacao');
    }    

    /*
     * Utiliza campo desnormatizado pra pegar  o processo que originou todos os pedids posteriores
     */
    public function processoOriginal()
    {
        return $this->hasOne('CapOut\DocProc', 'idDocProc', 'idDocProcOrigem');
    }

    /*
     * retorna o pedido que a que estou anexado
     */
    public function anexadoA()
    {
        return $this->hasOne('CapOut\DocProcCont', 'idDocProcCont', 'idDocProcContPai')
            ->whereColumn('idDocProcCont','<>','idDocProcContPai');
    }
    /*
     * retorna o pedido que a que estou anexado
     */
    public function ultimoPedido()
    {
        return $this->hasOne('CapOut\DocProcCont', 'idDocProcCont', 'idDocProcContUltimo');
    }

    /**
     * ---------------------------
     * FIM relacionamento simples
     * ---------------------------
     */
    /**
     * *******************************************************************************
     * Relacionamentos multiplos
     * *******************************************************************************
     */

    /*
     * retorna os pedidos anexados a essa continuação
     */
    public function anexos()
    {
        return $this->hasMany('CapOut\DocProcCont', 'idDocProcContPai', 'idDocProcCont');
    }
    /*tudo errado 
    public function anexosSituacao()
    {
        return $this->hasMany('CapOut\SituacaoDocProcAnexo','idDocProcCont', 'idDocProcCont');
    }
     */
    

    /*
     * retorna apenas a tabela que relaciona ao tipo de situação (TB_SITUACAO_DOC_PROC_CONT)
     */
    public function situacoes()
    {
        return $this->hasMany('CapOut\SituacaoDocProc','idDocProcCont')->orderBy('dtSituacao','DESC');
    }

    /**
     * ---------------------------
     * FIM relacionamento multiplo
     * ---------------------------
     */
    /**
     * *******************************************************************************
     * Relacionamentos complexos
     * *******************************************************************************
     */

    /*
     * retorna as situações e seus nomes
     */
    public function detalheSituacoes()
    {
        return $this->belongsToMany('CapOut\Situacao', 'TB_DOC_PROC_TB_SITUACAO_DOC_PROC', 'idDocProcCont', 'idSituacaoDocProc')
            ->withPivot('id','dtSituacao','idMov')->orderBy('dtSituacao','asc');
    }

    /*
    * relaciona docProcCont as tags
    */
    public function relacionaTag()
    {
        return $this->belongsToMany('CapOut\Tag', 'TB_RELACIONA_TAG_DOC', 'idDocProcCont','idTag');
    }
    /*
     * relaciona com todas as tag numericas
     */
    public function tagsNumericas()
    {
        return $this->hasMany('CapOut\TagNumerica','idDocProcCont','idDocProcCont');
    }

    /**
     * *******************************************************************************
     * Relacionamentos complexos que envolvem serviços
     * *******************************************************************************
     */

    /*
     * Chamar apenas na cont do processo original
     * @return mixed
     */
    public function parteCapa()
    {
        return $this->hasOne('CapOut\SsoPartes','idDocProcCont','idDocProcCont')->where('flTipoParte',1);
    }

    /**
     * Atalhos para alguns tipos de partes
     * @return mixed
     */
    public function parteResponsavel()
    {
        return $this->hasOne('CapOut\SsoPartes','idDocProcCont','idDocProcCont')->where('flTipoParte',5);
    }
    public function parteAssinante()
    {
        return $this->hasOne('CapOut\SsoPartes','idDocProcCont','idDocProcCont')->where('flTipoParte',11);
    }
    public function parteInteressada()
    {
        return $this->hasOne('CapOut\SsoPartes','idDocProcCont','idDocProcCont')->where('flTipoParte',2);
    }    

    /*
     * retorna os ids para consulta no SSO
     */
    public function partes()
    {
        return $this->hasMany('CapOut\SsoPartes','idDocProcCont');
    }
    /*
     * retorna os ids para consulta no SSO
     */
    public function partesInteressadas()
    {
        return $this->hasMany('CapOut\SsoPartes','idDocProcCont')->whereIn('flTipoParte',[2,3,4,5,6,8,9]);
    }
    public function parteAutor()
    {
        return $this->hasOne('CapOut\SsoPartes','idDocProcCont')->where('flTipoParte',4);
    }
    public function partePreposto()
    {
        return $this->hasOne('CapOut\SsoPartes','idDocProcCont')->where('flTipoParte',6);
    }
    /**
     * ---------------------------
     * FIM relacionamentos complexos
     * ---------------------------
     */
    /**
     * -------------------------------------------------------------------------------
     * FIM relacionamentos
     * -------------------------------------------------------------------------------
     */
}
