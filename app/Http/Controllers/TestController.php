<?php

namespace CapOut\Http\Controllers;

use CapOut\Situacao;
use CapOut\Parte;
use CapOut\DocProcCont;
use Illuminate\Http\Request;
use CapOut\MovDocProc;
use CapOut\DocProc;
use CapOut\Movimentacao;
use CapOut\SsoPartes;
use CapOut\SituacaoDocProc;
use CapOut\Http\Controllers\Controller;
use Storage;


class TestController extends Controller
{
	public function testar(Request $request)
    {
        echo storage_path('app/public');
        //return var_dump(Storage::disk('public')->exists('teste.txt'));
        return Storage::disk('public')->url('teste.png');
        //$processos = SsoPartes::where('idSsoParte','=',6)->with('DocProcCont.identificacao','DocProcCont.detalheSituacoesDois')->get();
       $doc= DocProc::where('idDocProc','=',11)->with('movDocProc','movDocProc.detalhe')->first();
       return response()->json($doc);

        return $processos[0]->DocProcCont->ultimaSituacaoDois;
        
        /*
        $aux= new Parte(6);
        dd($aux);
    	$temp= DocProcCont::find(1);
    	//dd($temp->docProcs);
    	echo $temp->identicacao->nDoc.'<br>';
    	foreach ($temp->detalheSituacoes as $key=>$valor ) {
    	
    		if(isset($valor->dsSituacao))
    		echo $valor->dsSituacao.' - '.$valor->pivot->dtSituacao.'<br>';
    	}
        return 'testes ';
        */
    }
}