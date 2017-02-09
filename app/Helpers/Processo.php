<?php
/**
 * Created by PhpStorm.
 * User: d2678128
 * Date: 06/09/2016
 * Time: 17:21
 */

namespace CapOut\Helpers;


use CapOut\DocProcCont;
use CapOut\SituacaoDocProcAnexo;

class Processo
{
    public static function publicar(DocProcCont $documento){
        if(!isset($documento->dsLocalUpload)){
            $documento->dsLocalUpload=Gerador::geraDocumento($documento->identificacao);
        }
        Gerador::geraEmail($documento);
        $relSitDocPai=SituacaoDocProcAnexo::where('idDocProcCont',$documento->idDocProcCont)->first();
        if(!isset($relSitDocPai)){
            $relSitDocPai=new SituacaoDocProcAnexo();
            $relSitDocPai->idSituacaoDocProcCont =$documento->anexadoA->idUltimaSituacao;
            $relSitDocPai->idDocProcCont=$documento->idDocProcCont;
        }
        $relSitDocPai->disponivel=1;
        $relSitDocPai->save();
    }
}